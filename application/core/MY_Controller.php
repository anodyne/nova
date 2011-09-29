<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to and replaces the standard
 * CI Controller Class, which doesn't support sub-controllers (HMVC)
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		WanWizard
 * @link		http://www.exitecms.org
 */
if ( class_exists('CI_Controller') )
{
	class Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
		}
	}
}

class MY_Controller extends Controller
{
	function __construct()
	{
		// get the CI superobject
		$CI =& get_instance();

		// call the parent constructor
		parent::__construct();

		// do we have a superobject?
		if ( $CI )
		{
			// yes, so this is an HMVC sub-controller.

			// check how we reference the module itself
			$config = $CI->config->item('module');
			$self = isset($config['self']) ? $config['self'] : false;

			// copy all objects from the parent controller to the sub-controller
			foreach (array_keys(get_object_vars($CI)) as $attribute)
			{
				if ($attribute != $self && is_object($CI->$attribute))
				{
					$this->$attribute =& $CI->$attribute;
				}
			}

			// inform the loader we're now in HVMC mode
			if ( is_null($this->load->_ci_root) )
			{
				$this->load->_ci_root =& $CI;
			}
		}
	}
}
// END MY_Controller class

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
