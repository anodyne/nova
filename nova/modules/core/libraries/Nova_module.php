<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExiteCMS Dev Team
 * @copyright	Copyright (c) 2010, WanWizard
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Module Library Class
 *
 * This library enables you to load classes from a "Modules" directory
 * to extend CodeIgniter with modulair capabilities, without the drawbacks
 * of using packages (no view or controller support, namespace issues, etc)
 *
 * @package		Modular CI
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExiteCMS Dev Team
 * @link
 */

class CI_Module
{
    // use a generic class name in controllers to access its own module classes
    private $_generic = false;

    // store module languages in an array using the module class name
    private $_use_language_array = false;

    // store the generic language object
    private $_lang_obj = null;

    // store the path for this module instance
    public $_path = '';

    // store the module name for this module instance
    public $_module = '';

    // store the module class name for this module instance
    public $_class = '';

    // --------------------------------------------------------------------

    public function __construct($path, $class)
    {
        // get the module filename
        $info = pathinfo($path);

        // define the module path, module name and classname
        $this->_path = rtrim($path, '/').'/';
        $this->_module = $info['filename'];
        $this->_class = $class;

        // load the module config file
        $CI =& get_instance();
        $CI->config->load('module', true, true);

        // process the config items
        if ($CI->config->item('module')) {
            foreach ($CI->config->item('module') as $key => $value) {
                switch ($key) {
                    case 'self':
                        $this->_generic = $value;
                        break;

                    case 'use_language_array':
                        $this->_use_language_array = (bool) $value;
                        break;

                    default:
                        break;
                }
            }
        }

        // create links to the subclasses (if needed for this module)
        if (is_dir($this->_path . 'libraries')) {
            $this->library = new Module_Library($this, $this->_path, $this->_class, $this->_generic);
        }
        if (is_dir($this->_path . 'models')) {
            $this->model = new Module_Model($this, $this->_path, $this->_class, $this->_generic);
        }
        if (is_dir($this->_path . 'controllers')) {
            $this->controller = new Module_Controller($this, $this->_path, $this->_class, $this->_generic);
        }

        log_message('debug', 'Module "'.$this->_class. '" loaded');
    }

    // --------------------------------------------------------------------

    // capture calls to unknown methods, so we can dynamically support them
    public function __call($name = '', $args = null)
    {
        // dynamic call support for the 'lang' method
        if (strtolower($name) == 'lang') {
            // make sure we have all parameters
            if (! is_array($args)) {
                $args = array();
            }
            if (! isset($args[0])) {
                $args[0] = '';
            }
            if (! isset($args[1])) {
                $args[1] = '';
            }
            if (! isset($args[2])) {
                $args[2] = false;
            }
            if (! isset($args[3])) {
                $args[3] = false;
            }

            // load the requested language file
            $this->_lang($args[0], $args[1], $args[2], $args[3]);

            // create a new language object and return it
            if (is_null($this->_lang_obj)) {
                $this->_lang_obj = new Module_Lang($this->_module, $this->_use_language_array);
            }
            return $this->_lang_obj;
        } else {
            // unknown method requested
            return null;
        }
    }

    // --------------------------------------------------------------------

    // capture calls to undefined properties, so we can dynamically support them
    public function __get($name)
    {
        // dynamic call support for the 'lang' property (links to the lang method)
        if (strtolower($name) == 'lang') {
            // create a new language object and return it
            if (is_null($this->_lang_obj)) {
                $this->_lang_obj = new Module_Lang($this->_class, $this->_use_language_array);
            }
            return $this->_lang_obj;
        } else {
            return null;
        }
    }

    // --------------------------------------------------------------------

    public function view($view, $vars = array(), $return = false)
    {
        // get the CI superobject
        $CI =& get_instance();

        if ($return) {
            return $CI->load->_ci_load(array('_ci_path' => $this->_path.'views/'.$view.'.php', '_ci_vars' => $CI->load->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        } else {
            $CI->load->_ci_load(array('_ci_path' => $this->_path.'views/'.$view.'.php', '_ci_vars' => $CI->load->_ci_prepare_view_vars($vars), '_ci_return' => $return));
        }
    }

    // --------------------------------------------------------------------

    public function viewpath($view = '')
    {
        // return the full path to the view
        return $this->_path.'views/'.$view;
    }

    // --------------------------------------------------------------------

    public function helper($helpers)
    {
        if (! is_array($helpers)) {
            $helpers = array($helpers);
        }

        foreach ($helpers as $helper) {
            $helper = strtolower(str_replace('.php', '', str_replace('_helper', '', $helper)).'_helper');

            if (file_exists($this->_path . 'helpers/' . $helper . '.php')) {
                include_once($this->_path . 'helpers/' . $helper . '.php');
            }
        }
    }

    // --------------------------------------------------------------------

    public function config($file = '', $use_sections = false, $fail_gracefully = false)
    {
        if ($use_sections === true) {
            $use_sections = $this->_class . '/' . $file;
        }

        $file = $this->_path .'config/' . (($file == '') ? 'config' : str_replace('.php', '', $file));

        $CI =& get_instance();

        if (in_array($file, $CI->config->is_loaded, true)) {
            return true;
        }

        if (! file_exists($file.'.php')) {
            if ($fail_gracefully === true) {
                return false;
            }
            show_error('The configuration file '.$file.'.php'.' does not exist.');
        }

        include($file.'.php');

        if (! isset($config) or ! is_array($config)) {
            if ($fail_gracefully === true) {
                return false;
            }
            show_error('Your '.$file.'.php'.' file does not appear to contain a valid configuration array.');
        }

        if ($use_sections !== false) {
            if (isset($CI->config->config[$use_sections])) {
                $CI->config->config[$use_sections] = array_merge($CI->config->config[$use_sections], $config);
            } else {
                $CI->config->config[$use_sections] = $config;
            }
        } else {
            $CI->config->config = array_merge($CI->config->config, $config);
        }

        $CI->config->is_loaded[] = $file;
        unset($config);

        log_message('debug', 'Config file loaded: config/'.$file.'.php');
        return true;
    }

    // --------------------------------------------------------------------

    // internal method to load a module language file if 'lang' was called as a method
    private function _lang($langfile = '', $idiom = '', $return = false, $add_suffix = true)
    {
        // get the CI superobject
        $CI =& get_instance();

        $langfile = str_replace('.php', '', str_replace('_lang.', '', $langfile)).'_lang.php';

        if ($idiom == '') {
            $deft_lang = $CI->config->item('language');
            $idiom = ($deft_lang == '') ? 'english' : $deft_lang;
        }

        $langfile = $this->_path.'language/'.$idiom.'/'.$langfile;

        if (in_array($langfile, $CI->lang->is_loaded, true)) {
            return;
        }

        // Determine where the language file is and load it
        if (file_exists($langfile)) {
            include($langfile);
        } else {
            show_error('Unable to load the requested module language file: '.$langfile);
        }

        if (! isset($lang)) {
            log_message('error', 'Module language file contains no data: '.$langfile);
            return;
        }

        if ($return == true) {
            return $lang;
        }

        $CI->lang->is_loaded[] = $langfile;
        if ($this->_use_language_array) {
            if (! isset($CI->lang->language[$this->_module])) {
                $CI->lang->language[$this->_module] = $lang;
            } else {
                $CI->lang->language[$this->_module] = array_merge($CI->lang->language[$this->_module], $lang);
            }
        } else {
            $CI->lang->language = array_merge($CI->lang->language, $lang);
        }
        unset($lang);

        log_message('debug', 'Language file loaded: '.$langfile);
        return true;
    }
}
// END Module CLASS

// --------------------------------------------------------------------

class Module_Library
{

    // storage for manually loaded configs
    private $_config = array();

    public function __construct($parent, $path, $class, $generic)
    {
        // store the loaded module parent, class and path
        $this->_parent	= $parent;
        $this->_path	= $path;
        $this->_class	= $class;
        $this->_generic	= $generic;
    }

    // --------------------------------------------------------------------

    // assume all unknown methods are library names, so we can load configs
    public function __call($name = '', $args = null)
    {
        // make sure we have all arguments
        if (! empty($name) && is_string($name) && is_array($args)) {
            // store the config for this named library
            $this->_config[$name] = $args[0];

            log_message('debug', 'Manual config loaded for library '.$name);
        }
    }

    // --------------------------------------------------------------------

    // dynamically load the requested library if needed
    public function __get($class)
    {
        // class names are lowercase
        $class = strtolower($class);

        // locate the library file
        foreach (array(ucfirst($class), $class) as $name) {
            $filepath = $this->_path.'libraries/'.$name.'.php';

            if (file_exists($filepath)) {
                include_once $filepath;
                break;
            }
        }

        // the module file can't be found
        if (! class_exists($class)) {
            log_message('error', "Unable to load the requested module library: ".$class);
            show_error("Unable to load the requested module library: ".$class);
        }

        // see if a config file is defined for this library
        if (empty($this->_config[$class])) {
            // We test for both uppercase and lowercase, for servers that
            // are case-sensitive with regard to file names
            if (file_exists($this->_path.'config/'.strtolower($class).'.php')) {
                include_once($this->_path.'config/'.strtolower($class).'.php');
            } elseif (file_exists($this->_path.'config/'.ucfirst(strtolower($class)).'.php')) {
                include_once($this->_path.'config/'.ucfirst(strtolower($class)).'.php');
            } else {
                $config = null;
            }
        } else {
            $config = $this->_config[$class];
        }

        // instantiate the library
        if ($config !== null) {
            $this->$class = new $class($config);
        } else {
            $this->$class = new $class;
        }

        // do we need a generic name for the parent?
        if (is_string($this->_generic)) {
            $parent = $this->_generic;
            if (! isset($this->$class->$parent) or ! is_object($this->$class->$parent)) {
                $this->$class->$parent = null;
                $this->$class->$parent =& $this->_parent;
            }
        } else {
            $parent = $this->_class;
        }

        // make the parent accessable
        $this->$class->__modulereference = $parent;

        log_message('debug', 'Dynamically load the module library '.$class);

        $CI =& get_instance();
        $CI->load->_ci_assign_to_models();

        return $this->$class;
    }
}
// END Module_Library CLASS

// --------------------------------------------------------------------

class Module_Controller
{
    public $__instances = array();

    public function __construct($parent, $path, $class, $generic)
    {
        // store the loaded module parent, class and path
        $this->_parent	= $parent;
        $this->_path	= $path;
        $this->_class	= $class;
        $this->_generic	= $generic;
    }

    // --------------------------------------------------------------------

    // capture property requests, to support
    public function __call($name = '', $args = null)
    {
        if (! empty($args)) {
            $obj = $this->__get($name, $args);
        } else {
            $obj = $this->__get($name);
        }

        if (method_exists($obj, '_remap')) {
            return $obj->_remap();
        } elseif (method_exists($obj, 'index')) {
            return $obj->index();
        } else {
            return $obj;
        }

        log_message('debug', 'Manual config loaded for controller '.$name);
    }

    // --------------------------------------------------------------------

    // dynamically load the requested controller if needed
    public function __get($class)
    {
        // class names are lowercase
        $class = strtolower($class);

        // did we already load this class?
        if (! isset($this->__instances[$class])) {
            // locate the controller file
            foreach (array(ucfirst($class), $class) as $name) {
                $filepath = $this->_path.'controllers/'.$name.'.php';

                if (file_exists($filepath)) {
                    include_once $filepath;
                    break;
                }
            }

            // the module file can't be found
            if (! class_exists($class)) {
                log_message('error', "Unable to load the requested module controller: ".$this->_class.'/'.$class);
                show_error("Unable to load the requested module controller: ".$this->_class.'/'.$class);
            }

            // fetch the CI superobject
            $CI =& get_instance();

            // instantiate the model
            if (func_num_args() == 2) {
                $config = func_get_args();
                if (isset($config[1])) {
                    $reflector = new ReflectionClass($class);
                    $this->$class = $reflector->newInstanceArgs($config[1]);
                } else {
                    $this->$class = new $class;
                }
            } else {
                $this->$class = new $class;
            }

            log_message('debug', 'Dynamically load the module controller '.$class);

            // do we need a generic name for the parent?
            if (is_string($this->_generic)) {
                $parent = $this->_generic;
                if (! isset($this->$class->$parent) or ! is_object($this->$class->$parent)) {
                    $this->$class->$parent = null;
                    $this->$class->$parent =& $this->_parent;
                }
            } else {
                $parent = $this->_class;
            }
            // make the parent accessable
            $this->$class->__modulereference = $parent;

            // store it for future reference
            $this->__instances[$class] =& $this->$class;
        } else {
            $this->$class =& $this->__instances[$class];

            // if arguments were present, log an error
            if (func_num_args() == 2) {
                log_message('error', 'Calling already instantiated module controller '.$class.' with arguments!');
            }
        }

        return $this->$class;
    }
}
// END Module_Controller CLASS

// --------------------------------------------------------------------

class Module_Model
{
    public function __construct($parent, $path, $class, $generic)
    {
        // store the loaded module parent, class and path
        $this->_parent	= $parent;
        $this->_path	= $path;
        $this->_class	= $class;
        $this->_generic	= $generic;

        // get the CI superobject
        $CI =& get_instance();

        // CI 1.7.2 doesn't support _ci_model_paths
        if ((int) CI_VERSION < 2 && ! isset($CI->load->_ci_model_paths)) {
            // created so it can be used by Datamapper
            $CI->load->_ci_model_paths = array(APPPATH);
        }

        // add this models module path to the loaders model search path
        if (! in_array($path, $CI->load->_ci_model_paths)) {
            $CI->load->_ci_model_paths[] = $path;
        }
    }

    // --------------------------------------------------------------------

    // capture property requests, to support dynamic library loading when calling a method
    public function __call($name = '', $args = null)
    {
        if (! empty($args)) {
            $result = $this->__get($name, $args);
        } else {
            $result = $this->__get($name);
        }

        log_message('debug', 'Manual config loaded for library '.$name);

        return $result;
    }

    // --------------------------------------------------------------------

    // dynamically load the requested model if needed
    public function __get($class)
    {
        if ((int) CI_VERSION < 2) {
            if (! class_exists('Model')) {
                load_class('Model', false);
            }
        } else {
            if (! class_exists('CI_Model')) {
                load_class('Model', 'core');
            }
        }

        // loves me some nesting!
        foreach (array(ucfirst($class), strtolower($class)) as $name) {
            $filepath = $this->_path.'models/'.$name.'.php';

            if (file_exists($filepath)) {
                include_once $filepath;
                break;
            }
        }

        // the module file can't be found
        if (! class_exists($class)) {
            log_message('error', "Unable to load the requested module model: ".$class);
            show_error("Unable to load the requested module model: ".$class);
        }

        // instantiate the model
        if (func_num_args() == 2) {
            $config = func_get_args();
            if (isset($config[1])) {
                $reflector = new ReflectionClass($class);
                $this->$class = $reflector->newInstanceArgs($config[1]);
            } else {
                $this->$class = new $class;
            }
        } else {
            $this->$class = new $class;
        }

        // do we need a generic name for the parent?
        if (is_string($this->_generic)) {
            $parent = $this->_generic;
            if (! isset($this->$class->$parent) or ! is_object($this->$class->$parent)) {
                $this->$class->$parent = null;
                $this->$class->$parent =& $this->_parent;
            }
        } else {
            $parent = $this->_class;
        }
        // make the parent accessable
        $this->$class->__modulereference = $parent;

        log_message('debug', 'Dynamically load the module model '.$class);

        return $this->$class;
    }
}

// END Module_Model CLASS

// --------------------------------------------------------------------

class Module_Lang
{
    private $_class;
    private $_use_language_array;

    public function __construct($class, $use_language_array)
    {
        $this->_class				= $class;
        $this->_use_language_array	= $use_language_array;
    }

    // --------------------------------------------------------------------

    // call CI's lang->line() method
    public function line($line = '', $section = null)
    {
        // get the CI superobject
        $CI =& get_instance();

        // if no section is defined, default to the module itself
        if (is_null($section) && $this->_use_language_array) {
            $section = $this->_class;
        }
        // get the line() method of the Lang library
        return $CI->lang->line($line, $section);
    }
}
// END Module_Lang CLASS
