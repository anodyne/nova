<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Hooks class
 *
 * @package		Nova
 * @category	Hooks
 * @author		Anodyne Productions
 */

abstract class Nova_Hooks {
	
	/**
	 * The bans hook goes through the database list of level 2 bans and then gets the
	 * incoming user's IP address to compare it. If someone with a level 2 ban is found
	 * they'll be redirected to the ban page.
	 *
	 * @return	void
	 */
	public static function bans()
	{
		# code...
	}
	
	/**
	 * The browser hook grabs the user's browser and version from the user agent and then
	 * checks it against the list of acceptable browser versions. Nova 2 requires users
	 * to have IE 8+, Safari 4+, Firefox 3+ or Chrome 3+.
	 *
	 * @uses	Request::user_agent
	 * @uses	URL::base
	 * @return	void
	 */
	public static function browser()
	{
		// create an array of browsers and versions that we don't allow
		$notallowed = array(
			'Internet Explorer'	=> 8,
			'Safari'			=> 4,
			'Firefox'			=> 3,
			'Chrome'			=> 4,
		);
		
		// get the browser
		$browser = Request::user_agent('browser');
		
		// get the browser version
		$version = Request::user_agent('version');
		
		// make sure the index exists
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
	 * The maintenance hook checks the database to find out if maintenance mode is
	 * currently active. If it is, it'll check to make sure A) the user is logged
	 * in and B) the user is a system administrators in order to let them continue
	 * on to the system. Otherwise, the user will be redirected to the login page
	 * or the maintenance page.
	 *
	 * @uses	Utility::install_status
	 * @uses	Request::instance
	 * @uses	Request::redirect
	 * @uses	Session::instance
	 * @uses	Jelly::query
	 * @uses	Auth::is_type
	 * @return	void
	 */
	public static function maintenance()
	{
		// if the config file isn't set
		if (file_exists(APPPATH.'config/database'.EXT) and Utility::install_status())
		{
			// get an instance of the request object
			$request = Request::instance();
			
			// get an instance of the session object
			$session = Session::instance();
			
			// figure out which controllers to ignore
			$ignore = array('install', 'update', 'upgrade', 'upgradeajax', 'login');
			
			if ( ! in_array($request->controller, $ignore))
			{
				// get the maintenance setting
				$maint = Jelly::query('setting', 'maintenance')->limit(1)->select()->value;
				
				if ($maint == 'on' and $request->controller != 'login')
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
}