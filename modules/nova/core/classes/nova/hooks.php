<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Hooks class
 *
 * @package		Nova
 * @category	Hooks
 * @author		Anodyne Productions
 */

abstract class Nova_Hooks {
	
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
	
	public static function maintenance()
	{
		// if the config file isn't set
		if (file_exists(APPPATH.'config/database'.EXT) && Utility::install_status())
		{
			// get an instance of the request object
			$request = Request::instance();
			
			// get an instance of the session object
			$session = Session::instance();
			
			// figure out which controllers to ignore
			$ignore = array('install', 'update', 'upgrade', 'upgradeajax', 'login');
			
			if (!in_array($request->controller, $ignore))
			{
				$maint = null;
				// get the maintenance setting
				//$maint = Jelly::select('setting')->key('maintenance')->load()->value;
				//$maint = Jelly::query('setting')->key('maintenance')->select()->value;
				//$maint = Jelly::query('setting')->where('key', '=', 'maintenance')->select();
				//$maint = Jelly::query('post', 1)->select();
				
				if ($maint == 'on' && $request->controller != 'login')
				{
					if (!Auth::is_type('sysadmin', $session->get('userid')))
					{
						// redirect to the login page
						$request->redirect('login/maintenance');
					}
				}
			}
		}
	}
} // End hooks