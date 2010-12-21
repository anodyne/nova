<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package CodeIgniter
 * @author  ExpressionEngine Dev Team
 * @copyright  Copyright (c) 2006, EllisLab, Inc.
 * @license http://codeigniter.com/user_guide/license.html
 * @link http://codeigniter.com
 * @since   Version 1.0
 * @filesource
 */

// --------------------------------------------------------------------

/**
 * CodeIgniter Template Class
 *
 * This class is and interface to CI's View class. It aims to improve the
 * interaction between controllers and views. Follow @link for more info
 *
 * @package		CodeIgniter
 * @author		Colin Williams
 * @subpackage	Libraries
 * @category	Libraries
 * @link		http://www.williamsconcepts.com/ci/libraries/template/index.html
 * @copyright	Copyright (c) 2008, Colin Williams.
 * @version		1.4.1
 * 
 */
class MY_Template extends CI_Template {
   
   var $regions = array(
      '_scripts' => array(),
      '_styles' => array(),
      '_redirect' => array(),
   );
   var $redirect = array();
   
   /**
	 * Constructor
	 *
	 * Loads template configuration, template regions, and validates existence of 
	 * default template
	 *
	 * @access	public
	 */
   
   function MY_Template()
   {
      parent::CI_Template();
   }
   
   // --------------------------------------------------------------------
   
   /**
    * Set regions for writing to
    *
    * @access  public
    * @param   array   properly formed regions array
    * @return  void
    */
   
   function set_regions($regions)
   {
      if (count($regions))
      {
         $this->regions = array(
            '_scripts' => array(),
            '_styles' => array(),
            '_redirect' => array(),
         );
         foreach ($regions as $key => $region) 
         {
            // Regions must be arrays, but we take the burden off the template 
            // developer and insure it here
            if ( ! is_array($region))
            {
               $this->add_region($region);
            }
            else {
               $this->add_region($key, $region);
            }
         }
      }
   }
   
   // --------------------------------------------------------------------
   
   /**
	 * Build a redirect in to the template
	 *
	 * @access	public
	 * @param	string	region to build
	 * @param	string	HTML element to wrap regions in; like '<div>'
	 * @param	array	Multidimensional array of HTML elements to apply to $wrapper
	 * @return	string	Output of region contents
	 */
	 
	function add_redirect($location = '', $time = 5)
	{
		$success = TRUE;
		$redirect = NULL;
		
		$this->CI->load->helper('url');
		
		$url = site_url($location);
		
		$redirect = '<meta http-equiv="refresh" content="'. $time .';url='. $url .'" />';
		
		// Add to redirect array if it doesn't already exist
		if ($redirect != NULL && !in_array($redirect, $this->redirect))
		{
			$this->redirect[] = $redirect;
			$this->write('_redirect', $redirect);
		}
		
		return $success;
	}
}
