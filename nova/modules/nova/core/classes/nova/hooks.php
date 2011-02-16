<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Hooks class provides methods that are run at different times throughout
 * Nova's execution for various purposes. The order and timing of hooks is
 * controlled through the events config file.
 *
 * @package		Nova
 * @category	Hooks
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Hooks {
	
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
			'Chrome'			=> 4,
		);
		
		$browser = Request::user_agent('browser');
		
		$version = Request::user_agent('version');
		
		if (isset($notallowed[$browser]))
		{
			// if the version requirements don't line up, redirect them
			if (version_compare($version, $notallowed[$browser], '<'))
			{
				header('Location:'.url::base().'browser.php?b='.$browser.'&v='.$version.'&pv='.$notallowed[$browser]);
				exit();
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
	 * @uses	Jelly::query
	 * @return	void
	 */
	public static function maintenance()
	{
		// if the config file isn't set
		if (file_exists(APPPATH.'config/database'.EXT) and Utility::install_status())
		{
			// get an instance of the request object
			$request = Request::initial();
			
			// get an instance of the session object
			$session = Session::instance();
			
			// figure out which controllers to ignore
			$ignore = array('install', 'update', 'upgrade', 'upgradeajax', 'login');
			
			if ( ! in_array($request->controller(), $ignore))
			{
				// get the maintenance setting
				$maint = Jelly::query('setting', 'maintenance')->limit(1)->select()->value;
				
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
	 * The module hook pulls information from the database (if the system is installed)
	 * about which modules to load. If the system isn't installed, it will manually
	 * load the upgrade and userguide modules so they can be used to view the user
	 * guide or upgrade from SMS.
	 *
	 * @access	public
	 * @uses	Utility::install_status
	 * @uses	Kohana::modules
	 * @uses	Jelly::query
	 * @return	void
	 */
	public static function modules()
	{
		// check the install status of the system
		$installed = Utility::install_status();
		
		if ($installed)
		{
			// grab all of the modules out of the database
			$dbmodules = Jelly::query('cataloguemodule')->where('status', '=', 'active')->select();
			
			if (count($dbmodules) > 0)
			{
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
		else
		{
			// add the upgrade and userguide modules manually if the system isn't installed
			$addmodules = array(
				'upgrade' 	=> MODPATH.'nova/upgrade',
				'userguide'	=> MODPATH.'kohana/userguide'
			);
			
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
