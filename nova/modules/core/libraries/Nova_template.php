<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template engine created by wiredesignz on the CodeIgniter forums.
 *
 * Has 2 modes of use:
 * 1: Using a container template with template parts (blocks) inside.
 * 2: Using template parts only (header,content,footer. etc).
 * 
 * Allows any data part to be re-assigned to all parts (global data).
 * Allows a template source directory to be specified.
 * Can be used with Matchbox modules.
 *
 * @package		Nova
 * @category	Library
 * @author		wiredesignz (CodeIgniter forums)
 * @link 		http://codeigniter.com/forums/viewthread/67028/
 */

abstract class Nova_template 
{
	
	/**
	 * The file name of the template to load
	 */
	public static $file;
	
	/**
	 * Data to be passed to the template
	 */
	public static $data;
	
	/**
	 * Constructor
	 *
	 * @param	string	the file name of the template to load
	 */
	public function __construct($file = null) 
	{
		self::$file = $file;
		self::$data = array(
			'module'	=> null,	// use with Matchbox modules
			'directory' => null,
		);
	}
	
	/**
	 * Assign a redirect to the template object
	 *
	 *     Template::add_redirect('controller/method')
	 *
	 * @access	public
	 * @param	string	the uri to redirect to
	 * @param	integer	the number of seconds to wait before redirecting
	 * @return	string	the meta tag with the refresh info
	 */
	public static function add_redirect($location, $time = 5)
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the url helper
		$ci->load->helper('url');
		
		// set the url we're going to
		$url = site_url($location);
		
		// assign the redirection to the data array
		return '<meta http-equiv="refresh" content="'.$time.';url='.$url.'" />';
	}
	
	/**
	 * Assign data to this template object.
	 * 
	 * @access	public
	 * @param	string
	 * @param	mixed
	 * @return 	void
	 */
	public static function assign($key, $value = null) 
	{
		if (is_array($key)) 
		{
			foreach ($key as $k => $v) 
			{
				self::$data[$k] = $v;
			}
		}
		else
		{
			self::$data[$key] = $value;
		}
	}
	
	/**
	 * Assign data to a specific template object.
	 * 
	 * @param	string
	 * @param	string
	 * @param	mixed
	 * @return	void
	 */	
	public static function assign_to($tpl, $key, $value = null)
	{
		self::$data[$tpl]->assign($key, $value);
	}
	
	/**
	 * Assign data to all template objects.
	 * 
	 * @param	string
	 * @param	mixed
	 * @return	void
	 */
	public static function assign_global($key, $value = null)
	{
		// iterate through the data
		foreach (self::$data as $k => $v)
		{
			// if the data is the template object, assign to it
			if (get_class($v) == 'Template')
			{
				$v->assign($key, $value);
			}
		}
		
		// assign to this template also
		self::assign($key, $value);
	}
	
	/**
	 * Assign new template object parts to this template.
	 * 
	 * @param	string
	 * @param	mixed
	 * @return	void
	 */
	public static function assign_tpl($tpl, $file = null)
	{
		if (is_array($tpl))
		{
			foreach ($tpl as $k => $v)
			{ 
				self::assign($k, new Template($v));
			} 
		}
		else
		{
			self::assign($tpl, new Template($file));
		}
	}
  
	/**
	 * Fetch a specific template data value.
	 *
	 * @param	string	the template name
	 * @param	string	the data key
	 * @return	string	 
	 */
	public static function fetch($tpl, $key)
	{
		return self::$data[$tpl]->data[$key];	
	}
		
	/**
	 * Build the HTML output.
	 *
	 * @param	 bool	set the output mode
	 * @return	 string	 the rendered template
	 */
	public static function render($return = FALSE) 
	{
		// get an instance of CI
		$ci =& get_instance();
		
		$routerClass = $ci->router->fetch_class();
		$routerMethod = $ci->router->fetch_method();
		
		if($routerClass && $routerMethod)
		{
			$ci->event->fire([
				'template',
				'render',
				'data',
				$routerClass, 
				$routerMethod
			], [
				'data' => &self::$data
			]);
		}
		
		$out = '';
		ob_start();

		// iterate through data
		foreach (self::$data as $k => $v)				
		{
			// if data is template object
			if (is_object($v) && strtolower(get_class($v)) == 'template')
			{
				// render it
				self::$data[$k] = $v->render(TRUE);

				// output the part
				if ( ! self::$file) echo self::$data[$k];
			}
		}

		if (self::$file)
		{
			echo self::out(TRUE);
		}
		
		$buffer = ob_get_contents();
		@ob_end_clean();
		
		$elapsed = $ci->benchmark->elapsed_time('total_execution_time_start', 'total_execution_time_end');
		$memory	 = ( ! function_exists('memory_get_usage')) ? '0' : round(memory_get_usage()/1024/1024, 2).'MB';
		
		$buffer = str_replace('{elapsed_time}', $elapsed, $buffer);
		$buffer = str_replace('{memory_usage}', $memory, $buffer);
		
		if($routerClass && $routerMethod)
		{
			$ci->event->fire([
				'template',
				'render',
				'output',
				$routerClass, 
				$routerMethod
			], [
				'data' => &self::$data,
				'output' => &$buffer
			]);
		}
		
		if ($return)
		{
			return $buffer;
		}
		
		echo $buffer;
	}
   
	/**
	 * Render this template.
	 *
	 * @param	boolean	set the output mode
	 * @return	string	the rendered template
	 */
	public static function out($return = FALSE)
	{		
		$ci =& get_instance();
		
		if (substr(self::$file, 0, 5) == '_base')
		{
			return $ci->nova->view(self::$data['directory'].self::$file, self::$data, $return, self::$data['module']);
		}
		
		return $ci->load->view(self::$data['directory'].self::$file, self::$data, $return, self::$data['module']);
	}
}
