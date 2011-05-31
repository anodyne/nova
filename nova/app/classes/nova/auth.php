<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Auth class is responsible for managing authentication in Nova. Included
 * in the class are methods for checking access, getting access levels, hashing
 * passwords, checking whether a user is logged in or not, verify login credentials,
 * logging a user out, logging a user in and various protected methods for setting
 * session variables, cookies and performing the autologin process.
 *
 * __Note:__ This class cannot easily be extended by the application because of
 * the fact it's a core class that Nova relies heavily on. If you think this
 * class is missing functionality, please submit a feature request on the issue
 * tracker.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
abstract class Nova_Auth {
	
	/**
	 * @var	int		number of attempts allowed before lockout
	 */
	public static $allowed_login_attempts = 5;
	
	/**
	 * @var	int		number of seconds the lockout lasts
	 */
	public static $lockout_time = 1800;
	
	/**
	 * @var	object	an instance of the session for use throughout the class
	 */
	protected static $_session;
	
	/**
	 * Initializes the Auth class. It isn't necessary to directly call this
	 * method as it's called automatically when the class is used.
	 *
	 * @access	public
	 * @uses	Session::instance
	 * @return	void
	 */
	public static function init()
	{
		self::$_session = Session::instance();
	}
	
	/**
	 * Checks a user's access level for the given page to see if they're allowed
	 * to access the page. If no URI is given in the first parameter, Nova will
	 * attempt to figure out what the current URI is and use that in its place.
	 *
	 *     // check the user's access to the page and redirects if false
	 *     Auth::check_access('admin/index');
	 *
	 *     // check the user's access to the page and doesn't redirect
	 *     Auth::check_access('main/index', false);
	 *
	 *     // no URI given, will auto-detect and redirect if false
	 *     Auth::check_access();
	 *
	 *     // no URI given, will auto-detect and not redirect
	 *     Auth::check_access(null, false);
	 *
	 * @access	public
	 * @uses	Request::current
	 * @uses	Request::redirect
	 * @uses	Session::get
	 * @uses	Session::set
	 * @param	string	the URI to check in the access session array
	 * @param	boolean	whether to redirect to the login page (default: true)
	 * @param	boolean	whether to search for a partial match (default: false)
	 * @return	boolean	a boolean value of whether the user is allowed to access the page
	 */
	public static function check_access($uri = null, $redirect = true, $partial = false)
	{
		// make sure the uri is set properly
		$uri = ($uri === null) ? self::_set_uri() : $uri;
		
		if ($partial === true)
		{
			$array = explode('/', $uri);
			$uri = $array[0];
		}
		
		if ($partial === false)
		{
			if ( ! array_key_exists($uri, self::$_session->get('access', array())))
			{
				if ($redirect === true)
				{
					self::$_session->set('referer', $uri);
					
					Request::current()->redirect('admin/error/1');
				}
				
				return false;
			}
		}
		else
		{
			foreach (self::$_session->get('access') as $a => $b)
			{
				if (strpos($a, $uri) !== false)
				{
				    return true;
				}
				
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Grabs the access level from the session's access array to find out how much
	 * access a user has to the page. If no URI is given, Nova will attempt to
	 * auto-detect the current URI and use that instead.
	 *
	 *     // get the access level for the current page
	 *     $level = Auth::get_access_level();
	 *
	 *     // get the access level for a page that isn't the current one
	 *     $level = Auth::get_access_level('admin/index');
	 *
	 * @access	public
	 * @uses	Request::current
	 * @uses	Session::get
	 * @param	string	the URI to check
	 * @return	mixed	the access level for a given page or false if no access
	 */
	public static function get_access_level($uri = null)
	{
		// get an instance of the request object
		$request = Request::current();
		
		// make sure the uri is set properly
		$uri = ($uri === null) ? self::_set_uri() : $uri;
		
		// grab the session
		$access = self::$_session->get('access', array());
			
		if (array_key_exists($uri, $access))
		{
			return $access[$uri];
		}
		
		return false;
	}
	
	/**
	 * Takes a string and hashes with the system's unique identifier.
	 *
	 * *WARNING:* uninstalling the system and re-installing it with the same data
	 * will break all passwords since the UID is never the same between two
	 * installations.
	 *
	 *     $password = Auth::hash('foo');
	 *
	 * @access	public
	 * @param	string	the string to hash
	 * @return	string	the hashed string
	 */
	public static function hash($string)
	{
		// double hash the UID
		$uid = sha1(sha1(Model_System::get_uid()));
		
		// hash the string with the salt
		$string = sha1($uid.$string);
		
		return $string;
	}
	
	/**
	 * Checks to see if someone is logged in or not. If the parameter is true,
	 * Nova will redirect the user to the login page.
	 *
	 *     // is the user logged in?
	 *     Auth::is_logged_in();
	 *
	 *     // if the user isn't logged in, send them to the login page
	 *     Auth::is_logged_in(true);
	 *
	 * @access	public
	 * @uses	Request::current
	 * @uses	Request::redirect
	 * @uses	Session::get
	 * @param	boolean	whether a failure should redirect the user to the login page
	 * @return	boolean
	 */
	public static function is_logged_in($redirect = false)
	{
		if (is_null(self::$_session->get('userid')))
		{
			$auto = self::_autologin();
			
			if ($auto !== false)
			{
				return true;
			}
			
			if ($redirect === true)
			{
				Request::current()->redirect('login/error/1');
			}
			
			return false;
		}
		
		return true;
	}
	
	/**
	 * Checks to see if the user is flagged a certain way.
	 *
	 *     $sysadmin = Auth::is_type('sysadmin', 1);
	 *
	 * @access	public
	 * @param	string	what is the type to check for (webmaster, game_master, sysadmin)
	 * @param	integer	the user id to check
	 * @return	boolean
	 */
	public static function is_type($type, $id)
	{
		if ( ! is_numeric($id))
		{
			return false;
		}
		
		// load the user model
		$user = Model_User::find($id);
		
		// figure out the type
		$type = 'is_'.$type;
		
		// find the property
		$is = (bool) $user->{$type};
		
		return $is;
	}
	
	/**
	 * Executes the log in process, sets the remember me cookie if it's been
	 * requested and calls the method to set the session variables.
	 *
	 *     $login = Auth::login('me@example.com', 'password', 'yes');
	 *
	 * @access	public
	 * @uses	Date::now
	 * @uses	Request::$client_ip
	 * @param	string	the email address
	 * @param	string	the password (should NOT be hashed before)
	 * @param	integer	whether to set the auto-login (1 - yes, 0 - no)
	 * @return	integer	the login error code (0 means a successful login)
	 */
	public static function login($email, $password, $remember = 0)
	{
		// set the variables
		$retval = 0;
		$maintenance = (bool) Model_Settings::get_settings('maintenance');
			
		// check the login attempts
		$attempts = self::_check_login_attempts($email);
		
		if ($attempts === false)
		{
			return 6;
		}
		
		// do the legwork
		$login = self::_verify($email, $password, true);
		
		if (is_object($login))
		{
			// hash the password
			$password = self::hash($password);
			
			if ($maintenance and $login->is_sysadmin == 'n')
			{
				// maintenance mode active
				$retval = 5;
			}
			else
			{
				// remove all of a user's login attempts
				$attempts = Model_LoginAttempts::delete_user_attempts($email);
			
				// update the login record
				$login->last_login = Date::now();
				$login->save();
				
				// set the session
				self::_set_session($login);
				
				if ($remember == 1)
				{
					// set the cookie
					self::_set_cookie($email, $password);
				}
			}
		}
		else
		{
			$retval = $login;
			
			$data = array(
				'ip_address'	=> Request::$client_ip,
				'email'			=> $email,
				'time'			=> Date::now(),
			);
			
			Model_LoginAttempts::create_attempt($data);
		}
		
		return $retval;
	}
	
	/**
	 * Log the user out of the system, destroy their cookies and session variables.
	 *
	 *     Auth::logout();
	 *
	 * @access	public
	 * @uses	Session::destroy
	 * @return 	void
	 */
	public static function logout()
	{
		// destroy any cookies that exist
		self::_destroy_cookie();
		
		// wipe out the session
		self::$_session->destroy();
	}
	
	/**
	 * Verify a user's login credentials with their email address and password.
	 *
	 *     // verify the login credentials and return the login error code
	 *     $login = Auth::verify('me@example.com', 'password');
	 *
	 *     // verify the login credentials and return the person object on success
	 *     $login = Auth::verify('me@example.com', 'password', true);
	 *
	 * @access	public
	 * @param	string	the email address
	 * @param	string	the password
	 * @param	boolean	whether or not to return the person object (true) or the login code (false)
	 * @return	mixed	an integer with the error code (0 means successful login) or the person object
	 */
	public static function verify($email, $password, $object = false)
	{
		return self::_verify($email, $password, $object);
	}
	
	/**
	 * Checks to see how many login attempts a user has in the allowed timeframe.
	 *
	 * @access	protected
	 * @uses	Date::now
	 * @uses	Session::delete
	 * @uses	Session::set
	 * @param	string	the email address
	 * @return	boolean	a boolean value of whether the user is allowed to try another login attempt
	 */
	protected static function _check_login_attempts($email)
	{
		// get the number of attempts the user has made
		$attempts = Model_LoginAttempts::get_user_attempts($email);
		
		if (count($attempts) < self::$allowed_login_attempts)
		{
			return true;
		}
		else
		{
			// grab the nova uid
			$uid = Model_System::get_uid();
			
			// get the last login attempt
			$item = Model_LoginAttempts::get_user_attempts($email, 'last');
			
			// calculate how long it's been since their last attempt
			$timeframe = Date::now() - $item->time;
			
			// make sure they're allowed to log in
			if ($timeframe > self::$lockout_time)
			{
				// clear the session data
				self::$_session->delete('nova_'.$uid.'_lockout_time');
				
				return true;
			}
			
			// set the lockout time as session data to check login attempts
			self::$_session->set('nova_'.$uid.'_lockout_time', $item->time);
			
			return false;
		}
	}
	
	/**
	 * Initiate the autologin process.
	 *
	 * @access	protected
	 * @uses	Cookie::get
	 * @return	mixed	the login error code (0 is successful) or false if the user didn't want to be remembered
	 */
	protected static function _autologin()
	{
		// get the UID
		$uid = Model_System::get_uid();
		
		// get the cookie
		$cookie = Cookie::get('nova_'.$uid, false, true);
		
		if ($cookie !== false)
		{
			$login = self::login($cookie['email'], $cookie['password']);
			
			return $login;
		}
		
		return false;
	}
	
	/**
	 * Destroy the cookie (called from the logout method).
	 *
	 * @access	protected
	 * @uses	Cookie::delete
	 * @return 	void
	 */
	protected static function _destroy_cookie()
	{
		// grab nova's unique identifier
		$uid = Model_System::get_uid();
		
		// destroy the cookie
		Cookie::delete('nova_'.$uid.'[email]');
		Cookie::delete('nova_'.$uid.'[password]');
	}
	
	/**
	 * Get the access page data to be used in the session.
	 *
	 * @access	protected
	 * @param	integer	the role ID
	 * @return 	array	the pages from the access role
	 */
	protected static function _set_access($role)
	{
		// get the string of page IDs
		$pageids = Model_AccessRole::find($role)->pages;
		
		// explode the string of page IDs into an array
		$pageids_array = explode(',', $pageids);
		
		// create an empty array
		$pages = array();
		
		// loop through the page IDs to get page information and put it into an array
		foreach ($pageids_array as $p)
		{
			$pageinfo = Model_AccessPage::find($p);
			
			$pages[$pageinfo->url] = $pageinfo->level;
		}
		
		return $pages;
	}
	
	/**
	 * Set the cookie if a user wants to be remembered (called from the login
	 * method).
	 *
	 * @access	protected
	 * @uses	Cookie::set
	 * @param	string	the email address
	 * @param	string	the password
	 * @return 	void
	 */
	protected static function _set_cookie($email, $password)
	{
		// grab nova's unique identifier
		$uid = Model_System::get_uid();
		
		// set the cookie
		Cookie::set('nova_'.$uid.'[email]', $email, 1209600);
		Cookie::set('nova_'.$uid.'[password]', $password, 1209600);
	}
	
	/**
	 * Set the session variables (called from the login method).
	 *
	 * @access	protected
	 * @uses	Html::anchor
	 * @uses	Session::set
	 * @uses	DBForge::optimize
	 * @param	object	an object with the user information
	 * @return 	void
	 */
	protected static function _set_session($user)
	{
		// get the IDs of all a user's characters
		foreach ($user->characters as $c)
		{
			$chars[] = $c->id;
		}
		
		// get the user's my links list
		$mylinks = explode(',', $user->my_links);
		
		// set an empty array
		$links = array();
		
		if (count($mylinks) > 0)
		{
			foreach ($mylinks as $value)
			{
				if ( ! empty($value) and $value !== null)
				{
					// get the menu item
					$m = Model_Menu::get_menu_item('url', $value);
					
					// set the link info
					$links[] = html::anchor($m->url, $m->name);
				}
			}
		}
		
		// set the session data
		self::$_session->set('userid', $user->id);
		self::$_session->set('skin_main', $user->skin_main);
		self::$_session->set('skin_wiki', $user->skin_wiki);
		self::$_session->set('skin_admin', $user->skin_admin);
		self::$_session->set('display_rank', $user->display_rank);
		self::$_session->set('language', $user->language);
		self::$_session->set('dst', $user->daylight_savings);
		self::$_session->set('mainchar', $user->character->id);
		self::$_session->set('characters', $chars);
		self::$_session->set('access', self::_set_access($user->role_id));
		self::$_session->set('my_links', $links);
		self::$_session->set('status', $user->get_status());
		
		// set the password reset session variable if it needs to be set
		if ($user->password_reset == 1)
		{
			self::$_session->set('password_reset', $user->password_reset);
		}
		
		// set the first launch session variable if it needs to be set
		if ($user->is_firstlaunch == 1)
		{
			self::$_session->set('first_launch', $user->is_firstlaunch);
		}
		
		DBForge::optimize('sessions');
	}
	
	/**
	 * Set the URI (called from the get_access_level and check_access methods).
	 *
	 * @access	protected
	 * @uses	Request::current
	 * @uses	Request::directory
	 * @uses	Request::controller
	 * @uses	Request::action
	 * @param	boolean	whether to include the directory at the start of the URI
	 * @return	string	a string with the URI properly set
	 */
	protected static function _set_uri($directory = false)
	{
		// get an instance of the request object
		$request = Request::current();
		
		if ($directory === true)
		{
			$uri[] = $request->directory();
		}
		
		// add the controller
		$uri[] = $request->controller();
		
		// add the action
		$action = $request->action();
		$uri[] = (empty($action)) ? 'index' : $action;
		
		// return the string
		return implode('/', $uri);
	}
	
	/**
	 * Method that does the legwork of verifying whether a user has the proper
	 * login credentials.
	 *
	 * @access	protected
	 * @param	string	the email address
	 * @param	string	the password
	 * @param	boolean	whether or not to return the person object (true) or the login code (false)
	 * @return	mixed	an integer with the error code (0 means successful login) or the person object
	 */
	protected static function _verify($email, $password, $object = false)
	{
		// set the default return value
		$retval = 0;
		
		// make sure the email address isn't blank
		$retval = ($email == '') ? 2 : $retval;
		
		// make sure the password isn't blank
		$retval = ($password == '') ? 3 : $retval;
		
		// hash the password
		$password = self::hash($password);
		
		// get the user record
		$login = Model_User::get_user('email', $email);
		
		if (count($login) == 0)
		{
			// email doesn't exist
			$retval = 2;
		}
		elseif (count($login) > 1)
		{
			// more than one account found - contact the GM
			$retval = 4;
		}
		else
		{
			// assign the object to a variable
			$person = $login;
			
			// make sure the password checks out
			$retval = ($person->password == $password) ? 0 : 3;
			
			if ($retval == 0 and $object === true)
			{
				return $person;
			}
		}
		
		return $retval;
	}
}
