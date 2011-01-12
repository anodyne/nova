<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Matchbox Router Class
 * Copyright 2007, 2008, 2009 Zacharias Knudsen
 * Documentation: http://codeigniter.com/wiki/Matchbox/
 *
 * This file is part of Matchbox.
 *
 * Matchbox is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published
 * by the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Matchbox is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.  See the GNU Lesser General Public
 * License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with Matchbox.  If not, see <http://www.gnu.org/licenses/>.
 */

class MY_Router extends CI_Router {

	// {{{ Matchbox

	var $_mb_module  = FALSE;
	var $module      = FALSE;

	function MY_Router()
	{
		$this->_mb_init();
		parent::CI_Router();
		log_message('debug', "Matchbox: Router Class Hooked");
	}

	function _mb_init()
	{
		// Set default values
		$callers = array(
			APPPATH.'libraries/Loader',
			APPPATH.'libraries/MY_Config',
			APPPATH.'libraries/MY_Language',
			BASEPATH.'libraries/Parser',
		);
		$paths = array(
			APPPATH.'modules',
		);
		$strict = FALSE;

		// Load configuration file and merge with default data
		$file = APPPATH.'config/matchbox'.EXT;
		if (file_exists($file))
		{
			include($file);
			if (isset($config) && is_array($config))
			{
				if (isset($config['callers']))
				{
					if ( ! is_array($config['callers']))
					{
						$config['callers'] = array($config['callers']);
					}
					$callers = array_merge($callers, $config['callers']);
				}
				if (isset($config['paths']))
				{
					if ( ! is_array($config['paths']))
					{
						$config['paths'] = array($config['paths']);
					}
					$paths = $config['paths'];
				}
				if (isset($config['strict']))
				{
					$strict = $config['strict'];
				}
			}
		}

		// Prepare data
		foreach($callers as $key => $caller)
		{
			$callers[$key] = str_replace('\\', '/', realpath(str_replace(EXT, '', $caller).EXT));
		}
		foreach($paths as $key => $path)
		{
			$paths[$key] = str_replace('\\', '/', realpath($path)).'/';
		}

		// Assign data
		$this->_mb_callers = $callers;
		$this->_mb_paths   = $paths;
		$this->_mb_strict  = $strict;
	}

	function _mb_module($module)
	{
		foreach ($this->_mb_paths as $path) {
			if (is_dir($path.$module))
			{
				$this->_mb_module = $path.$module.'/';
				$this->module     = $module;
			}
		}

		if ($this->_mb_module === FALSE)
		{
			return FALSE;
		}

		// Fetch and ready module routing data
		@include($this->_mb_module.'config/routes'.EXT);
		if (isset($route) && is_array($route)) {
			$this->routes = array_merge($this->routes, $route);
		}
		unset($route);

		// Default controller
		if (isset($this->routes['default_controller']) && $this->routes['default_controller'] !== '')
		{
			$this->_mb_default_controller = strtolower($this->routes['default_controller']);
		} else {
			$this->_mb_default_controller = FALSE;
		}

		return TRUE;
	}

	function _validate_request($segments)
	{
		// Regular non-modular requests are handled by stock CI code
		if ($this->_mb_module === FALSE)
		{
			return parent::_validate_request($segments);
		}

		// Now we need to find the relative path to the module
		$path  = '../';
		$path1 = explode('/', trim(str_replace("\\", "/", realpath(APPPATH)), '/'));
		$path2 = explode('/', trim($this->_mb_module.'controllers', '/'));
		$size1 = count($path1);
		$size2 = count($path2);
		$diff  = $size1 - $size2;
		for($i = 0; $i < min($size1, $size2); $i++)
		{
			if ($path1[$i] !== $path2[$i])
			{
				$path = '../'.$path.$path2[$i].'/';
			}
		}
		$path = ($diff > 0 ? str_repeat('../', $diff) : '').$path.implode('/', array_slice($path2, $size1));
		$this->set_directory($path);

		$directory = $this->_mb_module.'controllers/';

		// Does the controller exist in module controller root?
		if (file_exists($directory.$segments[0].EXT))
		{
			return $segments;
		}

		// At this point, the controller can only be in a sub-directory
		if ( ! is_dir($directory.$segments[0]))
		{
			show_404($directory.$segments[0]);
		}

		$this->set_directory($this->fetch_directory().$segments[0]);
		$directory .= $segments[0].'/';
		$segments  = array_slice($segments, 1);

		if (count($segments) > 0)
		{
			if ( ! file_exists($directory.$segments[0].EXT))
			{
				show_404($directory.$segments[0]);
			}
		}
		else
		{
			$this->set_class($this->_mb_default_controller);
			$this->set_method('index');

			if ( ! file_exists($directory.$this->_mb_default_controller.EXT))
			{
				$this->directory2 = '';
				return array();
			}
		}

		return $segments;
	}

	// }}}

	function _set_routing()
	{
		// Are query strings enabled in the config file?
		// If so, we're done since segment based URIs are not used with query strings.
		if ($this->config->item('enable_query_strings') === TRUE AND isset($_GET[$this->config->item('controller_trigger')]))
		{
			$this->set_class(trim($this->uri->_filter_uri($_GET[$this->config->item('controller_trigger')])));

			if (isset($_GET[$this->config->item('function_trigger')]))
			{
				$this->set_method(trim($this->uri->_filter_uri($_GET[$this->config->item('function_trigger')])));
			}

			return;
		}

		// Load the routes.php file.
		@include(APPPATH.'config/routes'.EXT);
		$this->routes = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
		unset($route);

		// Set the default controller so we can display it in the event
		// the URI doesn't correlated to a valid controller.
		$this->default_controller = ( ! isset($this->routes['default_controller']) OR $this->routes['default_controller'] == '') ? FALSE : strtolower($this->routes['default_controller']);	

		// Fetch the complete URI string
		$this->uri->_fetch_uri_string();

		// Is there a URI string? If not, the default controller specified in the "routes" file will be shown.
		if ($this->uri->uri_string == '')
		{
			if ($this->default_controller === FALSE)
			{
				show_error("Unable to determine what should be displayed. A default route has not been specified in the routing file.");
			}

			// {{{ Matchbox

			if (strpos($this->default_controller, '/') !== FALSE)
			{
				$x = explode('/', $this->default_controller);

				if ($this->_mb_module($x[0]))
				{
					$x = array_slice($x, 1);
				}

				$this->set_class(end($x));
				$this->set_method('index');
				$this->_set_request($x);
			}
			else
			{
				$this->set_class($this->default_controller);
				$x = array($this->default_controller, 'index');

				if ($this->_mb_module($this->default_controller))
				{
					$x = explode('/', $this->_mb_default_controller);
					$this->set_class(end($x));
				}

				$this->set_method('index');
				$this->_set_request($x);
			}

			// }}}

			// re-index the routed segments array so it starts with 1 rather than 0
			$this->uri->_reindex_segments();

			log_message('debug', "No URI present. Default controller set.");
			return;
		}
		unset($this->routes['default_controller']);

		// Do we need to remove the URL suffix?
		$this->uri->_remove_url_suffix();

		// Compile the segments into an array
		$this->uri->_explode_segments();

		// {{{ Matchbox

		$segments = $this->uri->segments;
		$module   = $segments[0].'/';

		if ($this->_mb_module($segments[0]))
		{
			$this->uri->segments  = array_slice($this->uri->segments, 1);

			if (count($segments) < 2)
			{

				if ($this->_mb_default_controller === FALSE)
				{
					if ($this->_mb_strict === TRUE)
					{
						show_error("Matchbox: Unable to determine what should be displayed. A default module route has not been specified in the module's routing file.");
					}

					$this->_mb_default_controller = $this->module;
				}

				if (strpos($this->_mb_default_controller, '/') !== FALSE)
				{
					$x = explode('/', $this->_mb_default_controller);

					$this->set_class(end($x));
					$this->set_method('index');
					$this->_set_request($x);
				}
				else
				{
					$this->set_class($this->_mb_default_controller);
					$this->set_method('index');
					$this->_set_request(array($this->_mb_default_controller, 'index'));
				}

				$this->uri->_reindex_segments();

				log_message('debug', "Matchbox: Only module present in URI. Default module controller set.");
				return;
			}
		}

		// }}}

		// Parse any custom routing that may exist
		$this->_parse_routes();		

		// Re-index the segment array so that it starts with 1 rather than 0
		$this->uri->_reindex_segments();
	}

}

/* End of file MY_Router.php */
/* Location: ./system/application/libraries/MY_Router.php */