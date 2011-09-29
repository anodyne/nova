<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * CodeIgniter Module Router Controller
 *
 * This controller allows you to route to module controllers, without having
 * to modify or extend the CodeIgniter core code.
 *
 * All you need is to add a route in config/routes.php for each of your
 * modules:
 *
 * $route['modulename/(.*)'] = 'modulerouter';
 *
 * You could also turn it around, catch all your normal controllers using
 * routes, and then route all others to the module router:
 *
 * $route['(welcome|test)(.*)'] = '$1$2';						// welcome.php and test.php are application controllers
 * $route['(.*)'] = 'modulerouter/$1';
 *
 * Or use any construction of custom routes supported by CodeIgniter
 * $route['site/(:any)/(.*)'] = 'modulerouter/$1/$2';			// only do module routing for this module
 * $route['(:any)/controller/(.*)'] = 'modulerouter/$1/$2';		// use different segments to route to the module
 *
 * @package		Modular CI
 * @subpackage	Controllers
 * @category	Controllers
 * @author		ExiteCMS Dev Team
 * @link
 */

class Nova_modulerouter extends MY_Controller {

	/*
	 * constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	/*
	 * _remap
	 *
	 * capture all calls to this controller, we don't support direct access
	 */
	function _remap()
	{
		// set the location of our modules
		$path = $this->load->module_path('modules');

		// fetch the URI segments
		$segments = $this->uri->rsegments;

		// drop the first one, it's this controller
		array_shift($segments);

		// fetch the required info from the segments
		$module = array_shift($segments);
		$controller = array_shift($segments);
		$method = array_shift($segments);
		
		// validate the info
		if ( empty($controller) )
		{
			// we don't have a controller, bail out
			show_404();

		}
		if ( empty($method) )
		{
			// we don't have a method, load index instead
			$method = 'index';
		}
		// check if we've been called directly
		if ( strtolower($module) == strtolower(get_class($this)) )
		{
			// pretend we don't exist
			show_404();
		}
		else
		{
			// does the requested module exists?
			if ( ! is_dir ( $path . '/' . strtolower($module) ) )
			{
				// module not found, page can't exist
				show_404();
			}
			else
			{
				// initialize the module
				$this->load->module( strtolower($module) );

				// does the controller contain a _remap() method?
				if ( method_exists( $this->$module->controller->$controller, '_remap') )
				{
					// call the controllers remap method
					$this->$module->controller->$controller->_remap($method);
				}
				else
				{
					// call the requested controller method, pass the remaining segments
					call_user_func_array(array($this->$module->controller->$controller, $method), $segments);
				}
			}
		}
	}
}
