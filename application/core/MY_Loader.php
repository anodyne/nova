<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ExiteCMS
 *
 * An open source application development framework for PHP 5+
 * ExiteCMS is based on CodeIgniter, Copyright (c) Ellislab Inc.
 *
 * Loader extension to allow modules to be loaded using $this->load->module()
 *
 * @package		ExiteCMS
 * @author		WanWizard
 * @copyright	Copyright (c) 2010, ExiteCMS.org
 * @link		http://www.exitecms.org
 * @filesource
 */

// ---------------------------------------------------------------------

class MY_Loader extends CI_Loader
{
	var $_ci_module_path 	= '';
	var $_ci_modules		= array();
	var $_ci_root 			= NULL;

	/**
	 * class contructor
	 */
	function __construct()
	{
		parent::__construct();

		// by default, modules live in the application folder
		$this->_ci_module_path = APPPATH.'modules/';
	}

	// --------------------------------------------------------------------

	/**
	 * allows the definition of a custom module path
	 *
	 * @param	string	path to the modules directory
	 * @return	void
	 */
	function module_path($path = '')
	{
		// if the given path does not exist
		if ( ! is_dir ( $path ) )
		{
			// is it located in the application folder?
			if ( ! is_dir ( APPPATH . $path ) )
			{
				log_message('error', "Module path ".$path." does not exist.");
				show_error("Module path ".$path." does not exist.");
			}
			else
			{
				// update the path
				$path = APPPATH . $path;
			}
		}

		// set the module path
		return $this->_ci_module_path = rtrim($path,'/');
	}

	// --------------------------------------------------------------------

	/**
	 * module
	 *
	 * loads a module, so we can access the modules components from the CI superobject
	 *
	 * @param	string	the name of the module & module directory
	 * @param	string	optional, alternative classname
	 * @param	string	optional, alternative module path
	 * @param	boolean	optional, if true, do not terminate with an error
	 * @return	void
	 */
	function module($module = '', $class = FALSE, $path = NULL, $silent = FALSE)
	{
		// make sure the module name is lowercase
		$module = strtolower(str_replace('.php', '', trim($module, '/')));

		// make sure we have a valid class name
		if (! is_string($class))
		{
			$pi = pathinfo($module);
			$class = strtolower($pi['basename']);
		}
		else
		{
			$class = strtolower(str_replace('.php', '', trim($class, '/')));
		}

		// module already loaded?
		if (in_array($class, $this->_ci_modules, TRUE))
		{
			return TRUE;
		}

		// check if an alternative path is passed
		if ( is_null($path) OR ! is_dir($path) )
		{
			$path = $this->_ci_module_path;
		}

		// check if the module exists
		if ( ! is_dir( $path.'/'.$module ) )
		{
			log_message('error', "Module directory ".$module." does not exist.");
			if ( $silent )
			{
				return FALSE;
			}
			show_error("Module directory ".$module." does not exist.");
		}

		// check if it's not a base class or a loaded class or if a class with this name is already present?
		if ( isset($this->_base_classes[$class]) OR isset($this->_ci_classes[$class]) )
		{
			log_message('error', "Module name ".$module." is already in use.");
			if ( $silent )
			{
				return FALSE;
			}
			show_error("Module name ".$module." is already in use.");
		}

		// get the CI superobject
		$CI =& get_instance();

		// is there already a class instantiated by $class name?
		if ( isset( $CI->$class ) )
		{
			// no, duplicate class name detected
			log_message('error', "Class name ".$class." is already in use.");
			if ( $silent )
			{
				return FALSE;
			}
			show_error("Class name ".$class." is already in use.");
		}
		else
		{
			// load the module class if needed
			if ( ! class_exists('CI_Module') )
			{
				require_once(APPPATH.'libraries/Module.php');

				if ( ! class_exists('CI_Module'))
				{
					log_message('error', "Unable to load the module library.");
					if ( $silent )
					{
						return FALSE;
					}
					show_error("Unable to load the module library.");
				}
			}

			// create a new module instance and assign it to the CI superobject
			$CI->$class = new CI_Module( $path.'/'.$module, $class );

			// are we in HMVC mode?
			if ( is_object($this->_ci_root) )
			{
				// assign the module to the root controller too
				$this->_ci_root->$class =& $CI->$class;
			}

			// store the name of the loaded module
			$this->_ci_modules[] = $class;

			// assign it to already loaded models and controllers
			$this->_ci_assign_to_models();
		}
		return TRUE;

	}

	// --------------------------------------------------------------------

	/**
	 * Assign to All Models
	 *
	 * Makes sure that anything loaded by the loader class (libraries, etc.)
	 * will be available to models and module models, if any exist.
	 *
	 * @access	private
	 * @param	object
	 * @return	array
	 */
	function _ci_assign_to_models()
	{
		// CI < 2.0 doesn't support magic get's
		if ( (int) CI_VERSION < 2 )
		{
			// assign the object to standard CI models
			parent::_ci_assign_to_models();
		}

		// assign the object to loaded module models
		$this->_ci_assign_to_modules();
	}

	/**
	 * Assign to Module Files
	 *
	 * Makes sure that anything loaded by the loader class (libraries, etc.)
	 * will be available to all loaded module objects
	 *
	 * @access	private
	 * @param	object
	 * @return	array
	 */
	function _ci_assign_to_modules( $oneclass = FALSE )
	{
		if (count($this->_ci_modules) == 0)
		{
			return;
		}

		// get the current CI instance
		$CI =& get_instance();

		// do we have an HMVC root controller?
		if ( ! is_null($this->_ci_root) )
		{
			if ( $oneclass )
			{
				if ( isset($CI->$oneclass) && is_object($CI->$oneclass) )
				{
					// Needed to prevent reference errors with some configurations
					$this->_ci_root->$oneclass = '';
					$this->_ci_root->$oneclass =& $CI->$oneclass;
				}
			}
			else
			{
				// assign the objects to the root controller too
				foreach (array_keys(get_object_vars($CI)) as $key)
				{
					if ( ! isset($this->_ci_root->$key) )
					{
						// Needed to prevent reference errors with some configurations
						$this->_ci_root->$key = '';
						$this->_ci_root->$key =& $CI->$key;
					}
				}
			}
		}

		foreach($this->_ci_modules as $module)
		{
			// loop through the list of module models
			if ( isset($CI->$module->model) && is_object($CI->$module->model) )
			{
				foreach( $CI->$module->model as $name => $class)
				{
					if ( is_object($class) )
					{
						if ( $oneclass )
						{
							if ( isset($CI->$oneclass) && is_object($CI->$oneclass) )
							{
								// Needed to prevent reference errors with some configurations
								$CI->$module->model->$name->$oneclass = '';
								$CI->$module->model->$name->$oneclass =& $CI->$oneclass;
							}
						}
						else
						{
							foreach (array_keys(get_object_vars($CI)) as $key)
							{
								if ( ! isset($class->$key) )
								{
									// Needed to prevent reference errors with some configurations
									$CI->$module->model->$name->$key = '';
									$CI->$module->model->$name->$key =& $CI->$key;
								}
							}
						}
					}
				}
			}

			// loop through the list of module controllers
			if ( isset($CI->$module->controller) && is_object($CI->$module->controller) )
			{
				foreach( $CI->$module->controller->__instances as $class)
				{
					if ( $oneclass )
					{
						if ( isset($CI->$oneclass) && is_object($CI->$oneclass) )
						{
							// Needed to prevent reference errors with some configurations
							$class->$oneclass = '';
							$class->$oneclass =& $CI->$oneclass;
						}
					}
					else
					{
						foreach (array_keys(get_object_vars($CI)) as $key)
						{
							if ( ! isset($class->$key) && is_object($CI->$key) )
							{
								// Needed to prevent reference errors with some configurations
								$class->$key = '';
								$class->$key =& $CI->$key;
							}
						}
					}
				}
			}

			// loop through the list of module libraries
			if ( isset($CI->$module->library) && is_object($CI->$module->library) )
			{
				foreach( $CI->$module->library as $name => $class)
				{
					if ( is_object($class) )
					{
						if ( $oneclass )
						{
							if ( isset($CI->$oneclass) && is_object($CI->$oneclass) )
							{
								// Needed to prevent reference errors with some configurations
								$CI->$module->library->$name->$oneclass = '';
								$CI->$module->library->$name->$oneclass =& $CI->$oneclass;
							}
						}
						else
						{
							foreach (array_keys(get_object_vars($CI)) as $key)
							{
								if ( ! isset($class->$key) )
								{
									// Needed to prevent reference errors with some configurations
									$CI->$module->library->$name->$key = '';
									$CI->$module->library->$name->$key =& $CI->$key;
								}
							}
						}
					}
				}
			}
		}
	}
}

/* End of file MY_Loader.php */
/* Location: ./application/core/MY_Loader.php */
