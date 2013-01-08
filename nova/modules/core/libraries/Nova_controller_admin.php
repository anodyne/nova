<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin base controller
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */
 
class Nova_controller_admin extends CI_Controller {
	
	/**
	 * @var	array 	The options array that stores all the settings from the database
	 */
	public $options;
	
	/**
	 * @var	string	The current skin
	 */
	public $skin;
	
	/**
	 * @var	string	The current rank set
	 */
	public $rank;
	
	/**
	 * @var	string	The current timezone
	 */
	public $timezone;
	
	/**
	 * @var	bool	The current daylight savings time setting
	 */
	public $dst;
	
	/**
	 * @var	bool	Variable to store all the information about template regions
	 */
	protected $_regions = array();
	
	public function __construct()
	{
		parent::__construct();
		
		// load the nova core module
		$this->load->module('core', 'nova', MODPATH);
		
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			redirect('install/setupconfig');
		}
		
		$this->load->database();
		$this->load->model('system_model', 'sys');
		
		// check to see if the system is installed
		$installed = $this->sys->check_install_status();
		
		if ( ! $installed)
		{
			redirect('install/index', 'refresh');
		}
		
		// these need to be loaded after the install check to prevent errors
		$this->load->library('session');
		$this->load->model('settings_model', 'settings');
		$this->load->model('messages_model', 'msgs');
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		
		// are we logged in?
		Auth::is_logged_in(true);
		
		// these are the options we want to pull for all main pagesg
		$settings_array = array(
			'skin_admin',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'email_subject',
			'system_email',
			'online_timespan',
			'posting_requirement',
			'updates',
			'use_mission_notes',
			'post_count_format',
			'allowed_chars_playing',
			'allowed_chars_npc',
			'default_email_address',
			'use_post_participants',
		);
		
		// set the options
		$this->options = $this->settings->get_settings($settings_array);
		
		// set the initial values
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		// if the user is logged in, reset the values
		if (Auth::is_logged_in())
		{
			$this->skin = (file_exists(APPPATH.'views/'.$this->session->userdata('skin_admin').'/template_admin.php'))
				? $this->session->userdata('skin_admin')
				: $this->skin;
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (bool) $this->session->userdata('dst');
		}
		
		// load the language file
		$this->lang->load('app', $this->session->userdata('language'));
		
		// set the template file
		Template::$file = $this->skin.'/template_admin';
		
		// assign all of the items to the template with false values to prevent errors
		$this->_regions += array(
			'nav_main'			=> Menu::build('main', 'main'),
			'nav_sub'			=> Menu::build('adminsub', 'admin'),
			'content'			=> false,
			'javascript'		=> false,
			'ajax'				=> false,
			'flash_message'		=> false,
			'_redirect'			=> false,
			'title'				=> $this->options['sim_name'].' :: ',
			'panel_1'			=> $this->user_panel->panel_1(),
			'panel_2'			=> $this->user_panel->panel_2(),
			'panel_3'			=> $this->user_panel->panel_3(),
			'panel_workflow'	=> $this->user_panel->panel_workflow(),
		);
	}
}
