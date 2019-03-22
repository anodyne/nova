<?php
/**
 * CodeIgniter Extension Helpers
 *
 * @package		Nova
 * @category	Helper
 * @author		Anodyne Productions
 * @copyright	2018 Anodyne Productions
 */

/**
 * Container for an extension. The extension is initialized by loading the 
 * init.php file within application/extensions/EXTENSION_NAME directory. 
 * 
 * Initialization allows an extension to expose objects via {@see attach()},
 * which are then made avaiable via ArrayAccess of this extension. For example,
 * given a jquery plugin that attaches an object 'generator', access via this
 * container within the {@see Nova_extension} library occurs as:
 *
 *   $this->extension['jquery']['generator'] 
 *
 * This container also tracks extensions this extension requires within its 
 * public member {@see $required_extension}.
 */
class Nova_extension_container implements ArrayAccess {
	
	public $name;
	
	public $path;
	
	public $ci;
	
	public $_initialized = false;
	
	public $required_extensions = [];
	
	public $facades = array();
	
	public function __construct($name)
	{
		$this->name = $name;
		$this->path = APPPATH.'extensions/'.$name.'/';
		$this->ci =& get_instance();
	}
	
	public function initialize()
	{
		if(!$this->_initialized)
		{
			$initializer = new Extension_initialization_context($this, $this->name);
			$initializer->initialize();
			$this->_initialized = true;
		}
	}
	
	public function inline_css($name, $section, $data = null)
	{
		$ci =& get_instance();
		$path = APPPATH.'extensions/'.$this->name.'/views/'.$section.'/css/'.$name.'.css';
		$output = $ci->load->_ci_load(array(
			'_ci_vars' => $ci->load->_ci_object_to_array($data), 
			'_ci_path' => $path,
			'_ci_return' => true
		));
		return '<style>'.$output.'</style>';
	}
	
	public function url($path)
	{
		return site_url('extensions/'.$this->name.'/'.$path);
	}
	
	public function view($view, $skin, $section, $data = null)
	{
		$ci =& get_instance();
		
		$obj = new stdClass;
		$obj->view = $view;
		$obj->sec = 'extensions/'.$this->name.'/'.$section;
		$obj->skin = '_base';
		
		if ($skin === null and $section === null)
		{
			$location = $view;
		}
		else
		{
			if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/pages/'.$view.'.php'))
			{
				$obj->skin = $skin;
			}
			elseif (is_file(APPPATH.'views/_base_override/'.$section.'/pages/'.$view.'.php'))
			{
				$obj->skin = '_base_override';
			}
			
			$location = $obj->skin.'/'.$obj->sec.'/pages/'.$obj->view;
		}
		
		$ci->event->fire(['location', 'view', 'data', $obj->sec, $obj->view], [
			'data' => &$data
		]);
		
		if ($data !== null)
		{
			if ($obj->skin == '_base')
			{
				if(!file_exists($ci->nova->_path.'views/'.$location.'.php')){
					$path = APPPATH.'extensions/'.$this->name.'/views/'.$section.'/pages/'.$view.'.php';
					if(file_exists($path)){
			            $output = $ci->load->_ci_load(array(
			              '_ci_view' => $location, 
			              '_ci_vars' => $ci->load->_ci_object_to_array($data), 
			              '_ci_path' => $path,
			              '_ci_return' => true
			            ));
						$ci->event->fire(['location', 'view', 'output', $obj->sec, $obj->view], [
							'data' => &$data,
							'output' => &$output
						]);
            			return $output;
          			}
				}
				
				$output = $ci->nova->view($location, $data, true);
				$ci->event->fire(['location', 'view', 'output', $obj->sec, $obj->view], [
					'data' => &$data,
					'output' => &$output
				]);
				return $output;
			}
			else
			{
				$output = $ci->load->view($location, $data, true);
				$ci->event->fire(['location', 'view', $obj->sec, $obj->view, 'output'], [
					'data' => &$data,
					'output' => &$output
				]);
				return $output;
			}
		}
		
		return $location;
	}

	public function offsetSet($offset, $value)
	{
    	if(is_null($offset))
		{
      		show_error('Extension append by integer not allowed');
    	}
		else
		{
      		$this->facades[$offset] = $value;
    	}
	}

	public function offsetExists($offset)
	{
    	return isset($this->facades[$offset]);
 	}

	public function offsetUnset($offset)
	{
    	unset($this->facades[$offset]);
	}

	public function offsetGet($offset)
	{
    	return isset($this->facades[$offset]) ? $this->facades[$offset] : null;
	}
}

/**
 * Object $this scope for the extension's init.php file, enabling calls such as
 * $this->attach('example_lib', new MyExtensionExampleLib()) and 
 * $this->require('other_extension_name') from within init.php. Besides these
 * special functions, all other calls and parameter access are forwarded to 
 * the CodeIgniter controller returned by {@see get_instance()}.
 */
class Nova_extension_initialization_context {
	
	public $ci;
	
	protected $_extensionContainer;
	
	public function __construct($extension, $name)
	{
		$this->name = $name;
		$this->path = APPPATH.'extensions/'.$name.'/';
		$this->ci =& get_instance();
		$this->_extensionContainer =& $extension;
	}
	
	// Call-forward to the CI context
	public function __get($name)
	{
		return $this->ci->$name;
	}
	
	// Call-forward to the CI context
	public function __call($name, $args)
	{
		return call_user_func_array([$this->ci, $name], $args);
	}
	 
	public function initialize()
	{
		// init.php run with $this context of Nova_extension_initialization_context
		if(file_exists($this->path.'init.php'))
		{
			require_once($this->path.'init.php');
		}
	}
	
	public function attach($name, $object)
	{
		$this->_extensionContainer[$name] = $object;
	}
	
	public function require_extension($extension)
	{
		$this->_extensionContainer->required_extensions[] = $extension;
	}
	
}
