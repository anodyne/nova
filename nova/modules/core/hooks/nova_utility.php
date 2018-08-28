<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Utility hook
 *
 * @package		Nova
 * @category	Hook
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_utility {
	
	public function __construct()
	{
		log_message('info', 'Utility Hook Initialized');
	}
	
	/**
	 * Checks the ban list to see if there are any level 2 bans that should be acted on
	 *
	 * @access	public
	 * @return	void
	 */
	public function bans()
	{
		$ci =& get_instance();
		
		if ($ci->uri->segment(1) != 'install')
		{
			$ci->load->database();
			$ci->load->model('system_model', 'sys');
			
			$installed = $ci->sys->check_install_status();
			
			if ($installed and $ci->db->table_exists('bans'))
			{
				$bans = $ci->sys->get_bans(2, false);
			
				if (in_array($ci->input->ip_address(), $bans))
				{
					if ($ci->uri->segment(1) != 'main' and $ci->uri->segment(2) != 'contact')
					{
						header('Location:'.base_url().'message.php?type=banned');
					}
				}
			}
		}
	}
	 
	/**
	 * Checks to see if a user is using IE6 and redirects them to a notice page if they are
	 *
	 * @access	public
	 * @return	void
	 */
	public function browser()
	{
		$ci =& get_instance();
		
		$ci->load->library('user_agent');
		
		if ($ci->agent->browser() == 'Internet Explorer' and $ci->agent->version() < 7)
		{
			header('Location:'.base_url().'message.php?type=browser');
		}
	}
	
	/**
	 * Checks to see if maintenance mode is active and redirects as necessary
	 *
	 * @access	public
	 * @return	void
	 */
	public function maintenance()
	{
		$ci =& get_instance();
		
		if ($ci->uri->segment(1) != 'install')
		{
			$ci->load->database();
			$ci->load->model('settings_model', 'settings');
			
			$ignore = array('install', 'login', 'update', 'upgrade', 'feed');
			
			if ( ! in_array($ci->uri->segment(1), $ignore))
			{
				if ($ci->settings->get_setting('maintenance') == 'on' and $ci->uri->segment(1) != 'login')
				{
					$sysadmin = $ci->auth->is_sysadmin($ci->session->userdata('userid'));
					
					if ( ! $sysadmin)
					{
						$view = Location::view('maintenance', $ci->settings->get_setting('skin_login'), 'login');
						
						if (file_exists(APPPATH .'views/'. $view .'.php'))
						{
							$data = $ci->load->view($view, '', true);
							
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
	
	/**
	 * Loads any enabled extensions
	 *
	 * @access	public
	 * @return	void
	 */
	public function extensions()
	{
		$ci =& get_instance();
		
		$ci->config->load('extensions');
		$ci->load->library('extension');
		$ci->load->helper('extension');
		
		$extensions = $ci->config->item('extensions');
		
		$requiredExtensions = [];
		
		foreach($extensions['enabled'] as $extensionName)
		{
			if(!is_dir(APPPATH.'extensions/'.$extensionName.'/'))
			{
				show_error('Extension missing: '.$extensionName);
			}
			
			$ci->extension[$extensionName] = new Extension_container($extensionName);
			$ci->extension[$extensionName]->initialize();
			
			foreach($ci->extension[$extensionName]->required_extensions as $requiredExtension)
			{
				if(!isset($requiredExtensions[$requiredExtension]))
				{
					$requiredExtensions[$requiredExtension] = [];
				}
				
				$requiredExtensions[$requiredExtension][] = $extensionName;
			}
			
		}
		
		$missingRequiredExtensions = [];
		
		foreach($requiredExtensions as $requiredExtensionName => $requiringExtensions)
		{
			if(!isset($ci->extension[$requiredExtensionName]))
			{
				$missingRequiredExtensions[] = $requiredExtensionName.' (required by: '.implode(', ', array_unique($requiringExtensions)).')';
			}
		}
		
		if(count($missingRequiredExtensions))
		{
			show_error('Required extension(s) not included: '.implode(', ', $missingRequiredExtensions));
		}
		
	}
}
