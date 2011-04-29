<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Base Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

abstract class Controller_Nova_Base extends Controller_Template {
	
	// these libraries should be globally available
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
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			$this->request->redirect('install/setupconfig');
		}
		
		// make sure the system is installed
		if ( ! Utility::install_status())
		{
			$this->request->redirect('install/index');
		}
		
		// load the session library
		$this->session = Session::instance();
		
		// set the locale
		I18n::lang($this->session->get('language', 'en-us'));
		
		// set the cache driver
		Cache::$default = Kohana::config('cache.driver');
		
		// these are the setting items we need to pull for this controller
		$this->settingsArray = array(
			'display_rank',
			'timezone',
			'daylight_savings',
			'date_format',
			'sim_name',
			'system_email'
		);
	}
}
