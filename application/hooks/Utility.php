<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
|---------------------------------------------------------------
| UTILITY HOOK
|---------------------------------------------------------------
|
| File: hooks/Utility.php
| System Version: 1.2
|
| Changes: added a hook to check for level 2 bans while the site is spinning up
|
*/

class Utility {
	
	function Utility()
	{
		/* log the debug message */
		log_message('info', 'Utility Hook Initialized');
	}
	
	/**
	 * Checks the ban list to see if there are any level 2 bans that should be acted on
	 */
	function bans()
	{
		$ci =& get_instance();
		
		// load the system model
		$ci->load->model('system_model', 'sys');
		
		// run the method
		$bans = $ci->sys->get_bans(2, FALSE);
		
		if (in_array($ci->input->ip_address(), $bans))
		{
			if ($ci->uri->segment(1) != 'main' && $ci->uri->segment(2) != 'contact')
			{
				header('Location:'.base_url().'banned.php');
			}
		}
	}
	 
	/**
	 * Checks to see if a user is using IE6 and redirects them to a notice page if they are
	 */
	function browser()
	{
		$ci =& get_instance();
		
		/* load the user agent library */
		$ci->load->library('user_agent');
		
		if ($ci->agent->browser() == 'Internet Explorer' && $ci->agent->version() < 7)
		{
			header('Location:http://www.anodyne-productions.com/index.php/nova/browser');
		}
	}
	
	/**
	 * Checks to see if maintenance mode is active and redirects as necessary
	 */
	function maintenance()
	{
		$ci =& get_instance();
		
		$ignore = array('install', 'login', 'update', 'upgrade');
		
		if (!in_array($ci->uri->segment(1), $ignore))
		{
			if ($ci->settings->get_setting('maintenance') == 'on' && $ci->uri->segment(1) != 'login')
			{
				$sysadmin = $ci->auth->is_sysadmin($ci->session->userdata('userid'));
				
				if ($sysadmin === FALSE)
				{
					$view = view_location('maintenance', $ci->settings->get_setting('skin_login'), 'login');
					
					if (file_exists(APPPATH .'views/'. $view .'.php'))
					{
						$data = $ci->load->view($view, '', TRUE);
						
						echo $data;
						exit();
					}
					else
					{
						redirect('login/index');
					}
				}
			}
		}
	}
}

/* End of file Utility.php */
/* Location: ./application/hooks/Utility.php */