<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Base Controller
 *
 * @package		Nova Core
 * @subpackage	Controller
 * @author		Anodyne Productions
 * @version		2.0
 */

abstract class Controller_Nova_Base extends Controller_Template
{
	// these models should be globally available
	public $mCore;
	public $mSettings;
	public $mMessages;
	
	// these libraries should be globally available
	public $auth;
	public $session;
	
	// the options array
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
		
		// load the session library
		$this->session = Session::instance();
		
		// load the core model
		$this->mCore = new Model_Core;
		
		// load the settings model
		$this->mSettings = new Model_Setting;
		
		// load the messages model
		$this->mMessages = new Model_Message;
		
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

// End of file base.php
// Location: modules/nova/classes/controller/nova/base.php