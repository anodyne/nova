<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Base Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

abstract class Controller_Nova_Base extends Controller_Template
{
	// these libraries should be globally available
	public $auth;
	public $session;
	
	// the options object
	public $options;
	
	// the images array
	public $images;
	
	// the important system settings
	public $skin;
	public $rank;
	public $timezone;
	public $dst;
	
	// the array of setting keys to pull
	protected $settingsArray;
	
	public function before()
	{
		parent::before();
		
		// if the config file isn't set
		if (!file_exists(APPPATH.'config/database'.EXT))
		{
			$this->request->redirect('install/setupconfig');
		}
		
		// make sure the system is installed
		if (!Utility::install_status())
		{
			$this->request->redirect('install/index');
		}
		
		// load the session library
		$this->session = Session::instance();
		
		// load the auth library
		$this->auth = new Auth;
		
		// set the locale
		i18n::lang($this->session->get('language', 'en-us'));
		
		// these are the setting items we need to pull for this controller
		$this->settingsArray = array(
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'system_email'
		);
	}
}