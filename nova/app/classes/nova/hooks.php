<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Hooks class provides methods that are run at different times throughout
 * Nova's execution for various purposes. The order and timing of hooks is
 * controlled through the events config file.
 *
 * @package		Nova
 * @category	Hooks
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

abstract class Nova_Hooks {
	
	/**
	 * Execute the calls on each event from the config file.
	 *
	 * @access	private
	 * @param	string	the name of the event to get the calls for
	 * @return	void
	 */
	private static function _execute_calls($event)
	{
		// get the event calls
		$calls = Kohana::$config->load('event.event_calls.'.$event);
		
		// loop through the calls and execute them
		foreach ($calls as $c)
		{
			call_user_func($c);
		}
	}
	
	/**
	 * Pre-create event.
	 */
	public static function pre_create()
	{
		static::_execute_calls('pre_create');
	}
	
	/**
	 * Post-create event.
	 */
	public static function post_create()
	{
		static::_execute_calls('post_create');
	}
	
	/**
	 * Pre-execute event.
	 */
	public static function pre_execute()
	{
		static::_execute_calls('pre_execute');
	}
	
	/**
	 * Post-execute event.
	 */
	public static function post_execute()
	{
		static::_execute_calls('post_execute');
	}
	
	/**
	 * Pre-headers event.
	 */
	public static function pre_headers()
	{
		static::_execute_calls('pre_headers');
	}
	
	/**
	 * Post-headers event.
	 */
	public static function post_headers()
	{
		static::_execute_calls('post_headers');
	}
	
	/**
	 * Pre-response event.
	 */
	public static function pre_response()
	{
		static::_execute_calls('pre_response');
	}
	
	/**
	 * Post-response event.
	 */
	public static function post_reponse()
	{
		static::_execute_calls('post_response');
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * The bans hook goes through the database list of level 2 bans and then gets
	 * the incoming user's IP address to compare it. If someone with a level 2
	 * ban is found they'll be redirected to the ban page.
	 *
	 * @return	void
	 */
	public static function bans()
	{
		# code...
	}
	
	/**
	 * The browser hook grabs the user's browser and version from the user agent
	 * and then checks it against the list of acceptable browser versions. Nova
	 * 3 requires users to have IE 8+, Safari 4+, Firefox 4+ or Chrome 4+.
	 *
	 * @access	public
	 * @uses	Request::user_agent
	 * @uses	Url::base
	 * @return	void
	 */
	public static function browser()
	{
		// these are the browsers we allow
		$notallowed = array(
			'Internet Explorer'	=> 8,
			'Safari'			=> 5,
			'Firefox'			=> 4,
			'Chrome'			=> 10,
		);
		
		// get the browser
		$browser = Request::user_agent('browser');
		
		// get the browser version
		$version = Request::user_agent('version');
		
		if (isset($notallowed[$browser]))
		{
			// if the version requirements don't line up, redirect them
			if (version_compare($version, $notallowed[$browser], '<'))
			{
				header('Location:'.Url::base().'message.php?type=browser');
				exit;
			}
		}
	}
	
	/**
	 * The maintenance hook checks the database to find out if maintenance mode
	 * is turned on. If it is, it'll check to make sure A) the user is logged in
	 * and B) the user is a system administrators in order to let them continue
	 * on to the system. Otherwise, the user will be redirected to the login page
	 * or the maintenance page.
	 *
	 * @access	public
	 * @uses	Utility::install_status
	 * @uses	Request::initial
	 * @uses	Request::redirect
	 * @uses	Request::controller
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Auth::is_type
	 * @return	void
	 */
	public static function maintenance()
	{
		// if the config file isn't set
		if (file_exists(APPPATH.'config/database.php') and Utility::install_status())
		{
			// get an instance of the request object
			$request = Request::initial();
			
			// get an instance of the session object
			$session = Session::instance();
			
			// figure out which directories and controllers to ignore
			$ignore_dirs = array('setup');
			$ignore_controllers = array('login');
			
			if ( ! in_array($request->directory(), $ignore_dirs) and ! in_array($request->controller(), $ignore_controllers))
			{
				// get the maintenance setting
				$maint = Model_Settings::get_settings('maintenance');
				
				if ($maint == 'on' and $request->controller() != 'login')
				{
					if ( ! Auth::is_type('sysadmin', $session->get('userid')))
					{
						// redirect to the login page
						$request->redirect('login/maintenance');
					}
				}
			}
		}
	}
	
	/**
	 * The module hook pulls information from the database (if the system is
	 * installed) about which modules to load.
	 *
	 * @access	public
	 * @uses	Utility::install_status
	 * @uses	Kohana::modules
	 * @return	void
	 */
	public static function modules()
	{
		// check the install status of the system
		$installed = Utility::install_status();
		
		if ($installed)
		{
			// grab all of the modules out of the database
			$dbmodules = Model_CatalogueModule::get_all_entries();
			
			if (count($dbmodules) > 0)
			{
				$addmodules = array();
				
				foreach ($dbmodules as $m)
				{
					$addmodules[$m->shortname] = EXTPATH.$m->location;
				}
				
				// get all the modules
				$allmodules = Kohana::modules();
				
				// find the numeric index of the core module
				$coreposition = array_search('nova', array_keys($allmodules));
				
				// grab all of the modules BEFORE the core module
				$startmodules = array_slice($allmodules, 0, $coreposition);
				
				// grab all of the modules AFTER (and including) the core module
				$endmodules = array_slice($allmodules, $coreposition);
				
				// merge the list of modules from the database with the beginning and end core modules
				$newmodules = array_merge($startmodules, $addmodules, $endmodules);
				
				// set the new list of modules
				Kohana::modules($newmodules);
			}
		}
	}
}
