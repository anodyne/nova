<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Matchbox Loader Class
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

_mb_extend();

class CI_Loader extends MB_Loader {

	// {{{ Matchbox

	function _mb_init()
	{
		$CI =& get_instance();
		$this->_mb_callers = $CI->router->_mb_callers;
		$this->_mb_module  = $CI->router->_mb_module;
		$this->_mb_paths   = $CI->router->_mb_paths;
		$this->_mb_strict  = $CI->router->_mb_strict;

		log_message('debug', "Matchbox: Loader Class Hooked");
	}

	function _mb_caller()
	{
		foreach ($this->_mb_callers as $caller)
		{
			$callers[] = str_replace("\\", "/", realpath($caller));
		}

		foreach ($this->_mb_paths as $path)
		{
			$paths[] = str_replace("\\", "/", realpath($path));
		}

		if ($this->_mb_strict === TRUE)
		{
			$paths['application'] = str_replace("\\", "/", realpath(APPPATH));
		}

		$steps   = debug_backtrace();
		$pattern = '@^(' . implode('|', $paths) . '?)\/(.+?)\/@i';
		foreach ($steps as $step)
		{
			if ( ! isset($step['file']))
			{
				continue;
			}

			$filepath = str_replace("\\", "/", $step['file']);
			foreach ($callers as $caller)
			{
				if (strpos($filepath, $caller) !== FALSE)
				{
					continue 2;
				}
			}

			if (preg_match($pattern, $filepath, $matches))
			{
				if ($this->_mb_strict === TRUE && $matches[1] == $paths['application'])
				{
					return APPPATH;
				}

				return $matches[1].'/'.$matches[2].'/';
			}

			// die('Damn caller detection...');
		}

		return FALSE;
	}

	function _mb_load($resource, $modules, $basepath = FALSE)
	{
		$paths = array();

		if ($modules !== FALSE)
		{
			if ( ! is_array($modules)) {
				$modules = array($modules);
			}
			foreach ($modules as $module)
			{
				if ($module === APPPATH)
				{
					$paths[] = APPPATH;
					continue;
				}
				foreach ($this->_mb_paths as $path)
				{
					$append[] = $path.$module.'/';

					if (strpos($module, $path) !== FALSE)
					{
						$append = array($module);
						break;
					}
				}

				$paths = array_merge($paths, $append);
			}
		}
		else
		{
			if ($caller = $this->_mb_caller())
			{
				$paths[] = $caller;
			}

			if ($this->_mb_strict === FALSE)
			{
				$paths[] = APPPATH;
			}

			if ($basepath !== FALSE)
			{
				$paths[] = BASEPATH;
			}
		}

		foreach ($paths as $path)
		{
			$filepath = $path.str_replace(EXT, '', $resource).EXT;
			if (file_exists($filepath))
			{
				return $filepath;
			}
		}

		return FALSE;
	}

	// }}}

	// {{{ Matchbox

	function config($file = '', $use_sections = FALSE, $fail_gracefully = FALSE, $module = FALSE)
	{
		$CI =& get_instance();
		$CI->config->load($file, $use_sections, $fail_gracefully, $module);
	}

	// }}}

	// {{{ Matchbox

	function helper($helper = '', $module = FALSE)
	{
		if (is_array($helper))
		{
			foreach ($helper as $value)
			{
				$this->helper($value);
			}

			return;
		}

		if ($helper === '')
		{
			return;
		}

		$helper = strtolower(str_replace(EXT, '', str_replace('_helper', '', $helper)).'_helper');

		if (isset($this->_ci_helpers[$helper]))
		{
			return;
		}

		if ($mb_file = $this->_mb_load('helpers/'.config_item('subclass_prefix').$helper, $module))
		{
			$base_helper = BASEPATH.'helpers/'.$helper.EXT;

			if ( ! file_exists($base_helper))
			{
				show_error('Matchbox: Unable to load the requested file: helpers/'.$helper.EXT);
			}

			include_once($mb_file);
			include_once($base_helper);
		}
		elseif ($mb_file = $this->_mb_load('helpers/'.$helper, $module, TRUE))
		{
			include_once($mb_file);
		}
		else
		{
			show_error('Matchbox: Unable to load the requested file: helpers/'.$helper.EXT);
		}

		$this->_ci_helpers[$helper] = TRUE;
		log_message('debug', 'Matchbox: Helper loaded: '.$helper);	
	}

	// }}}

	// {{{ Matchbox

	function language($file = array(), $lang = '', $module = FALSE)
	{
		$CI =& get_instance();

		if ( ! is_array($file))
		{
			$file = array($file);
		}

		foreach ($file as $langfile)
		{	
			$CI->lang->load($langfile, $lang, $module);
		}
	}

	// }}}

	function library($library = '', $params = NULL, $object_name = NULL, $module = FALSE)
	{
		if ($library == '')
		{
			return FALSE;
		}

		if ( ! is_null($params) AND ! is_array($params))
		{
			$params = NULL;
		}

		// {{{ Matchbox

		if (is_array($library))
		{
			foreach ($library as $class)
			{
				$this->_ci_load_class($class, $params, $object_name, $module);
			}
		}
		else
		{
			$this->_ci_load_class($library, $params, $object_name, $module);
		}

		// }}}

		$this->_ci_assign_to_models();
	}

	function model($model, $name = '', $db_conn = FALSE, $module = FALSE)
	{
		if (is_array($model))
		{
			foreach($model as $babe)
			{
				$this->model($babe);	
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (strpos($model, '/') === FALSE)
		{
			$path = '';
		}
		else
		{
			$x = explode('/', $model);
			$model = end($x);			
			unset($x[count($x)-1]);
			$path = implode('/', $x).'/';
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			// {{{ Matchbox

			show_error('Matchbox: The model name you are loading is the name of a resource that is already being used: '.$name);

			// }}}
		}

		$model = strtolower($model);

		// {{{ Matchbox

		if ( ! $mb_file = $this->_mb_load('models/'.$path.$model, $module))
		{
			show_error('Matchbox: Unable to locate the model you have specified: '.$model);
		}

		// }}}

		if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
		{
			if ($db_conn === TRUE)
				$db_conn = '';

			$CI->load->database($db_conn, FALSE, TRUE);
		}

		if ( ! class_exists('Model'))
		{
			load_class('Model', FALSE);
		}

		// {{{ Matchbox

		require_once($mb_file);

		// }}}

		$model = ucfirst($model);

		$CI->$name = new $model();
		$CI->$name->_assign_libraries();

		$this->_ci_models[] = $name;	
	}

	// {{{ Matchbox

	function plugin($plugin = '', $module = FALSE)
	{
		if (is_array($plugin))
		{
			foreach ($plugin as $value)
			{
				$this->plugin($value);
			}

			return;
		}

		if ($plugin === '')
		{
			return;
		}

		$plugin = strtolower(str_replace(EXT, '', str_replace('_pi', '', $plugin)).'_pi');

		if (isset($this->_ci_plugins[$plugin]))
		{
			continue;
		}

		if ($mb_file = $this->_mb_load('plugins/'.$plugin, $module, TRUE))
		{
			include_once($mb_file);	
		}
		else
		{
			show_error('Matchbox: Unable to load the requested file: plugins/'.$plugin.EXT);
		}
		
		$this->_ci_plugins[$plugin] = TRUE;
		log_message('debug', 'Matchbox: Plugin loaded: '.$plugin);
	}

	// }}}

	// {{{ Matchbox

	function view($view, $vars = array(), $return = FALSE, $module = FALSE)
	{
		$mb_file = $this->_mb_load('views/'.$view, $module);
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_path' => $mb_file, '_ci_return' => $return));
	}

	// }}}

	function _ci_load_class($class, $params = NULL, $object_name = NULL, $module = FALSE)
	{	
		// Get the class name, and while we're at it trim any slashes.  
		// The directory path can be included as part of the class name, 
		// but we don't want a leading slash
		$class = str_replace(EXT, '', trim($class, '/'));

		// Was the path included with the class name?
		// We look for a slash to determine this
		$subdir = '';
		if (strpos($class, '/') !== FALSE)
		{
			// explode the path so we can separate the filename from the path
			$x = explode('/', $class);	

			// Reset the $class variable now that we know the actual filename
			$class = end($x);

			// Kill the filename from the array
			unset($x[count($x)-1]);

			// Glue the path back together, sans filename
			$subdir = implode($x, '/').'/';
		}

		// We'll test for both lowercase and capitalized versions of the file name
		foreach (array(ucfirst($class), strtolower($class)) as $class)
		{
			$subclass = APPPATH.'libraries/'.$subdir.config_item('subclass_prefix').$class.EXT;

			// {{{ Matchbox

			// Is this a class extension request?			
			if ($mb_file = $this->_mb_load('libraries/'.$subdir.config_item('subclass_prefix').$class, $module))
			{

			// }}}

				$baseclass = BASEPATH.'libraries/'.ucfirst($class).EXT;

				if ( ! file_exists($baseclass))
				{
					// {{{ Matchbox

					log_message('error', "Matchbox: Unable to load the requested class: ".$class);
					show_error("Matchbox: Unable to load the requested class: ".$class);

					// }}}
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($subclass, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);			
						}
					}

					$is_duplicate = TRUE;

					// {{{ Matchbox

					log_message('debug', "Matchbox: ".$class." class already loaded. Second attempt ignored.");

					// }}}

					return;
				}

				include_once($baseclass);

				// {{{ Matchbox

				include_once($mb_file);

				$this->_ci_loaded_files[] = $subclass;
				return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name, $module);

				// }}}
			}

			// Lets search for the requested library file and load it.
			$is_duplicate = FALSE;		
			for ($i = 1; $i < 3; $i++)
			{
				$path = ($i % 2) ? APPPATH : BASEPATH;	
				$filepath = $path.'libraries/'.$subdir.$class.EXT;

				// {{{ Matchbox

				// Does the file exist?  No?  Bummer...
				if ( ! $mb_file = $this->_mb_load('libraries/'.$subdir.$class, $module, TRUE))
				{
					continue;
				}

				// }}}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($filepath, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, '', $params, $object_name);
						}
					}

					$is_duplicate = TRUE;

					// {{{ Matchbox

					log_message('debug', "Matchbox: ".$class." class already loaded. Second attempt ignored.");

					// }}}

					return;
				}

				// {{{ Matchbox

				include_once($mb_file);

				$this->_ci_loaded_files[] = $filepath;
				return $this->_ci_init_class($class, '', $params, $object_name, $module);

				// }}}
			}
		} // END FOREACH

		// One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
		if ($subdir == '')
		{
			$path = strtolower($class).'/'.$class;
			return $this->_ci_load_class($path, $params);
		}

		// If we got this far we were unable to find the requested class.
		// We do not issue errors if the load call failed due to a duplicate request
		if ($is_duplicate == FALSE)
		{
			// {{{ Matchbox

			log_message('error', "Matchbox: Unable to load the requested class: ".$class);
			show_error("Matchbox: Unable to load the requested class: ".$class);

			// }}}
		}
	}

	function _ci_init_class($class, $prefix = '', $config = FALSE, $object_name = NULL, $module = FALSE)
	{
		// {{{ Matchbox

		if ($config === NULL)
		{
			if ($mb_file = $this->_mb_load('config/'.strtolower($class).EXT, $module))
			{
				include_once($mb_file);
			}
			elseif ($mb_file = $this->_mb_load('config/'.ucfirst(strtolower($class)).EXT, $module))
			{
				include_once($mb_file);
			}
		}

		// }}}

		if ($prefix == '')
		{			
			if (class_exists('CI_'.$class)) 
			{
				$name = 'CI_'.$class;
			}
			elseif (class_exists(config_item('subclass_prefix').$class)) 
			{
				$name = config_item('subclass_prefix').$class;
			}
			else
			{
				$name = $class;
			}
		}
		else
		{
			$name = $prefix.$class;
		}

		// Is the class name valid?
		if ( ! class_exists($name))
		{
			log_message('error', "Non-existent class: ".$name);
			show_error("Non-existent class: ".$class);
		}

		// Set the variable name we will assign the class to
		// Was a custom class name supplied?  If so we'll use it
		$class = strtolower($class);

		if (is_null($object_name))
		{
			$classvar = ( ! isset($this->_ci_varmap[$class])) ? $class : $this->_ci_varmap[$class];
		}
		else
		{
			$classvar = $object_name;
		}

		// Save the class name and object name
		$this->_ci_classes[$class] = $classvar;

		// Instantiate the class
		$CI =& get_instance();
		if ($config !== NULL)
		{
			$CI->$classvar = new $name($config);
		}
		else
		{
			$CI->$classvar = new $name;
		}
	}

	// {{{ Matchbox

	function _ci_autoloader()
	{
		$this->_mb_init();

		parent::_ci_autoloader();

		if ($this->_mb_module === FALSE) {
			return;
		}

		if ( ! file_exists($this->_mb_module.'config/autoload'.EXT)) {
			return;
		}

		include_once($this->_mb_module.'config/autoload'.EXT);

		if ( ! isset($autoload))
		{
			return FALSE;
		}

		// Load any custom config file
		if (count($autoload['config']) > 0)
		{
			$CI =& get_instance();
			foreach ($autoload['config'] as $key => $val)
			{
				$CI->config->module_load($this->_mb_module, $val);
			}
		}

		// Autoload plugins, helpers and languages
		foreach (array('helper', 'plugin', 'language') as $type)
		{
			if (isset($autoload[$type]) AND count($autoload[$type]) > 0)
			{
				$this->{'module_'.$type}($this->_mb_module, $autoload[$type]);
			}
		}

		// A little tweak to remain backward compatible
		// The $autoload['core'] item was deprecated
		if ( ! isset($autoload['libraries']))
		{
			$autoload['libraries'] = $autoload['core'];
		}

		// Load libraries
		if (isset($autoload['libraries']) AND count($autoload['libraries']) > 0)
		{
			// Load the database driver.
			if (in_array('database', $autoload['libraries']))
			{
				$this->database();
				$autoload['libraries'] = array_diff($autoload['libraries'], array('database'));
			}

			// Load scaffolding
			if (in_array('scaffolding', $autoload['libraries']))
			{
				$this->scaffolding();
				$autoload['libraries'] = array_diff($autoload['libraries'], array('scaffolding'));
			}

			// Load all other libraries
			foreach ($autoload['libraries'] as $item)
			{
				$this->module_library($this->_mb_module, $item);
			}
		}

		// Autoload models
		if (isset($autoload['model']))
		{
			$this->module_model($this->_mb_module, $autoload['model']);
		}
	}

	// }}}

}

function _mb_extend()
{
	$content = file_get_contents(BASEPATH.'libraries/Loader'.EXT);
	$methods = array(
		'config',
		'helper',
		'helpers',
		'language',
		'library',
		'model',
		'plugin',
		'plugins',
		'view',
	);

	$pattern = '/function ('.implode('|', $methods).')\(([\$A-Za-z_ =\(\)\',]*)\)/';
	preg_match_all($pattern, $content, $methods, PREG_SET_ORDER);

	$new = '';
	foreach ($methods as $method)
	{
		list( , $name, $definition) = $method;
		preg_match_all('/\$[A-Za-z_]+/', $definition, $matches);
		$arguments = implode(', ', $matches[0]);
		$new .= <<<EOD
	function module_$name(\$module = FALSE, $definition)
	{
		if(\$module == '')
		{
			return;
		}

		return \$this->$name($arguments, \$module);
	}


EOD;
	}

	$content = substr_replace($content, $new, strrpos($content, '}'), 0);

	eval(str_replace('CI_Loader', 'MB_Loader', substr($content, 7)));
}

/* End of file Loader.php */
/* Location: ./system/application/libraries/Loader.php */