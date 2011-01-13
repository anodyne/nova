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

	var $_mb_default = FALSE;
	var $_mb_module  = FALSE;
	var $_mb_routes  = array();
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

	/**
	 * Sets the Route
	 *
	 * This function takes an array of URI segments as
	 * input, and sets the current class/method
	 */
	function _mb_route($segments)
	{
		// Does a module exist that matches the request?
		$module = $segments[0];

		// Loop through the paths in search of the elusive module!
		foreach ($this->_mb_paths as $path)
		{
			if (is_dir($path.$module))
			{
				$this->_mb_module = $path.$module.'/';
				$this->module     = $module;			// UNNECESSARY?
			}
		}

		// If the module doesn't exist then it's a regular request
		if ($this->_mb_module === FALSE)
		{
			return $segments;
		}

		$segments = array_slice($segments, 1);

		if (file_exists($this->_mb_module.'config/routes'.EXT))
		{
			include_once($this->_mb_module.'config/routes'.EXT);

			$this->_mb_routes  = ( ! isset($route) OR ! is_array($route)) ? array() : $route;
			$this->_mb_default = ( ! isset($this->_mb_routes['default_controller']) OR $this->_mb_routes['default_controller'] == '') ? FALSE : strtolower($this->_mb_routes['default_controller']);	
		}

		if ($this->_mb_strict === TRUE && $this->_mb_default === FALSE)
		{
			$this->_mb_default = $module;
		}

		// Is it the default controller?
		if (count($segments) < 2)
		{
			if ($this->_mb_default === FALSE)
			{
				show_error("Matchbox: Unable to determine what should be displayed. A default module route has not been specified in the module's routing file.");
			}

			// Are blah?
			if (strpos($this->_mb_default, '/') !== FALSE)
			{
				$x = explode('/', $this->_mb_default);

				$this->set_class(end($x));
				$this->set_method('index');
				$segments = $x;
			}
			else
			{
				$this->set_class($this->_mb_default);
				$this->set_method('index');
				$segments = array($this->_mb_default, 'index');
			}

			$this->uri->_reindex_segments();

			log_message('debug', "Matchbox: Only module present in URI. Default module controller set.");
			return $segments;
		}
		unset($this->_mb_routes['default_controller']);

		// Do we even have any custom routing to deal with?
		// There is a default scaffolding trigger, so we'll look just for 1
		if (count($this->_mb_routes) == 1 && key($this->_mb_routes) === 'scaffolding_trigger')
		{
			return $segments;
		}

		// Turn the segment array into a URI string
		$uri = implode('/', $segments);

		// Is there a literal match?  If so we're done
		if (isset($this->_mb_routes[$uri]))
		{
			return explode('/', $this->_mb_routes[$uri]);
		}

		// Loop through the route array looking for wild-cards
		foreach ($this->_mb_routes as $from => $to)
		{
			// Convert wild-cards to RegEx
			$from = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $from));

			// Does the RegEx match?
			if (preg_match('#^'.$from.'$#', $uri))
			{
				// Do we have a back-reference?
				if (strpos($to, '$') !== FALSE AND strpos($from, '(') !== FALSE)
				{
					$to = preg_replace('#^'.$from.'$#', $to, $uri);
				}

				$segments = explode('/', $to);
				break;
			}
		}

		return $segments;
	}

	/**
	 * Locate controller
	 */
	function _mb_locate($segments)
	{
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

		// Strict mode off falls back to just module name as controller
		if ( ! is_dir($directory.$segments[0]))
		{
			if ($this->_mb_strict === FALSE && file_exists($directory.$segments[0].EXT))
			{
				return $segments;
			}

			show_404($directory.$segments[0]);
		}

		// At this point, the controller can only be in a sub-directory
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
			$this->set_class($this->_mb_default);
			$this->set_method('index');

			if ( ! file_exists($directory.$this->_mb_default.EXT))
			{
				$this->directory2 = '';
				return array();
			}
		}

		return $segments;
	}

	function _set_request($segments)
	{
		$segments = $this->_mb_route($segments);

		return parent::_set_request($segments);
	}

	function _validate_request($segments)
	{
		if ($this->_mb_module !== FALSE)
		{
			return $this->_mb_locate($segments);
		}

		// Otherwise run stock code
		return parent::_validate_request($segments);
	}

	function set_directory($dir)
	{
		$this->directory = $dir.'/';
	}
}

/* End of file MY_Router.php */
/* Location: ./system/application/libraries/MY_Router.php */