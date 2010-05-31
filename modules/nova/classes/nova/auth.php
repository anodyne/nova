<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Auth Class
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

class Nova_Auth
{	
	/**
	 * @var		integer	Number of attempts allowed before lockout
	 */
	public static $allowed_login_attempts = 5;
	
	/**
	 * @var		integer	Number of seconds the lockout lasts
	 */
	public static $lockout_time = 1800;
	
	/**
	 * @var		an instance of the session for use throughout the class
	 */
	protected static $session;
	
	/**
	 * Initializes the Auth class if necessary. The constructor will also
	 * get an instance of the session and store it in the class variable
	 * and set a Kohana debug log item to notify that the library has been
	 * initialized.
	 *
	 * @return 	void
	 */
	public function __construct()
	{
		// get an instance of the session library
		self::$session = Session::instance();
		
		Kohana_Log::Instance()->add('debug', 'Auth library initialized.');
	}
	
	/**
	 * Checks a user's access level for the given page to see if they're allowed
	 * to access the page. If no URI is given in the first parameter, Nova will
	 * attempt to figure out what the current URI is and use that in its place.
	 *
	 *     // check the user's access to the page and redirects if FALSE
	 *     Auth::check_access('admin/index');
	 *
	 *     // check the user's access to the page and doesn't redirect
	 *     Auth::check_access('main/index', FALSE);
	 *
	 *     // no URI given, will auto-detect and redirect if FALSE
	 *     Auth::check_access();
	 *
	 *     // no URI given, will auto-detect and not redirect
	 *     Auth::check_access(NULL, FALSE);
	 *
	 * @param	string	the URI to check in the access session array
	 * @param	boolean	whether to redirect to the login page (default: true)
	 * @param	boolean	whether to search for a partial match (default: false)
	 * @return	boolean	a boolean value of whether the user is allowed to access the page
	 */
	public static function check_access($uri = NULL, $redirect = TRUE, $partial = FALSE)
	{
		// make sure the uri is set properly
		$uri = ($uri === NULL) ? self::_set_uri() : $uri;
		
		if ($partial === TRUE)
		{
			$array = explode('/', $uri);
			$uri = $array[0];
		}
		
		if ($partial === FALSE)
		{
			if (!array_key_exists($uri, self::$session->get('access', array())))
			{
				if ($redirect === TRUE)
				{
					self::$session->set_flash('referer', $uri);
					
					Request::Instance()->redirect('admin/error/1');
				}
				
				return FALSE;
			}
		}
		else
		{
			foreach (self::$session->get('access') as $a => $b)
			{
				if (strpos($a, $uri) !== FALSE)
				{
				    return TRUE;
				}
				
				return FALSE;
			}
		}
		
		return TRUE;
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
	 * @param	string	the URI to check
	 * @return	mixed	the access level for a given page or FALSE if no access
	 */
	public static function get_access_level($uri = NULL)
	{
		// make sure the uri is set properly
		$uri = ($uri === NULL) ? self::_set_uri() : $uri;
		
		// grab the session
		$session = self::$session->get('access', array());
		
		// break out the segments
		$segments = (is_array($uri)) ? $uri[1] .'/'. $uri[2] : $uri;
			
		if (array_key_exists($segments, $session))
		{
			return $session[$segments];
		}
		
		return FALSE;
	}
	
	/**
	 * Takes a string and hashes with the system's unique identifier.
	 *
	 * *WARNING:* uninstalling the system and re-installing it with the same data
	 * will break all passwords since the UID is never the same between two installations.
	 *
	 *     // hash the password
	 *     $password = Auth::hash('foo');
	 *
	 * @param	string	the string to hash
	 * @return	string	the hashed string
	 */
	public static function hash($string)
	{
		// grab the system model
		$uid = Jelly::select('system', 1)->uid;
		
		// double hash the UID
		$uid = sha1(sha1($uid));
		
		// hash the string with the salt
		$string = sha1($uid.$string);
		
		return $string;
	}
	
	/**
	 * Checks to see if someone is logged in or not. If the parameter is TRUE, Nova will
	 * redirect the user to the login page.
	 *
	 *     // is the user logged in?
	 *     Auth::is_logged_in();
	 *
	 *     // if the user isn't logged in, send them to the login page
	 *     Auth::is_logged_in(TRUE);
	 *
	 * @param	boolean	whether a failure should redirect the user to the login page
	 * @return	boolean	TRUE/FALSE depending on its result or a redirect to the login page
	 */
	public static function is_logged_in($redirect = FALSE)
	{
		if (is_null(self::$session->get('userid')))
		{
			$auto = self::_autologin();
			
			if ($auto !== FALSE)
			{
				return TRUE;
			}
			
			if ($redirect === TRUE)
			{
				Request::Instance()->redirect('login/index/error/1');
			}
			
			return FALSE;
		}
		
		return TRUE;
	}
	
	/**
	 * Checks to see if the user is flagged a certain way.
	 *
	 *     // is the user a system administrator?
	 *     $sysadmin = Auth::is_type('sysadmin', 1);
	 *
	 * @param	string	what is the type to check for (webmaster, game_master, sysadmin)
	 * @param	integer	the user id to check
	 * @return	boolean	a boolean value of whether or not the user is the type passed in the first parameter
	 */
	public static function is_type($type, $id)
	{
		// load the user model
		$is = Jelly::select('user', $id)->$type;
		
		// figure out whether it's true or false
		$retval = ($is == 'y') ? TRUE : FALSE;
		
		return $retval;
	}
	
	/**
	 * Executes the login process, sets the remember me cookie if it's been requested
	 * and calls the method to set the session variables.
	 *
	 *     // do the login process
	 *     $login = Auth::login('me@example.com', 'password', 'yes');
	 *
	 * @param	string	the email address
	 * @param	string	the password (should NOT be hashed before)
	 * @param	string	whether to set the auto-login (yes, no)
	 * @return	integer	the login error code (0 means a successful login)
	 */
	public static function login($email, $password, $remember = 'no')
	{
		// set the variables
		$retval = 0;
		$maintenance = Jelly::select('setting')->where('key', '=', 'maintenance')->load()->value;
		
		// check the login attempts
		$attempts = self::_check_login_attempts($email);
		
		if ($attempts === FALSE)
		{
			return 6;
		}
		
		// do the legwork
		$login = self::_verify($email, $password, TRUE);
		
		if (is_object($login))
		{
			// hash the password
			$password = self::hash($password);
			
			if ($maintenance == 'on' && $login->sysadmin == 'n')
			{
				// maintenance mode active
				$retval = 5;
			}
			else
			{
				// clear the login attempts if there are any
				$sys->delete_login_attempts($email);
			
				// update the login record
				$login->last_login = date::now();
				$login->save();
				
				// set the session
				self::_set_session($login);
				
				if ($remember == 'yes')
				{
					// set the cookie
					self::_set_cookie($email, $password);
				}
			}
		}
		else
		{
			// grab the error code
			$retval = $login;
			
			// create and save the login attempt
			$attempt = Jelly::factor('loginattempt')
				->set(array(
					'ip' => Request::Instance()->$client_ip,
					'email' => $email
				))
				->save();
		}
		
		return $retval;
	}
	
	/**
	 * Log the user out of the system, destroy their cookies and session variables.
	 *
	 *     // log the user out
	 *     Auth::logout();
	 *
	 * @return 	void
	 */
	public static function logout()
	{
		// destroy any cookies that exist
		self::_destroy_cookie();
		
		// wipe out the session
		self::$session->destroy();
	}
	
	/**
	 * Verify a user's login credentials with their email address and password.
	 *
	 *     // verify the login credentials and return the login error code
	 *     $login = Auth::verify('me@example.com', 'password');
	 *
	 *     // verify the login credentials and return the person object on success
	 *     $login = Auth::verify('me@example.com', 'password', TRUE);
	 *
	 * @param	string	the email address
	 * @param	string	the password
	 * @param	boolean	whether or not to return the person object (TRUE) or the login code (FALSE)
	 * @return	mixed	an integer with the error code (0 means successful login) or the person object
	 */
	public static function verify($email, $password, $object = FALSE)
	{
		return self::_verify($email, $password, $object);
	}
	
	/**
	 * Checks to see how many login attempts a user has in the allowed timeframe
	 *
	 * @param	string	the email address
	 * @return	boolean	a boolean value of whether the user is allowed to try another login attempt
	 */
	protected static function _check_login_attempts($email)
	{
		// load the resources
		$user = new Model_User;
		$sys = new Model_System;
		
		$attempts = $sys->count_login_attempts($email);
		
		if ($attempts < self::$allowed_login_attempts)
		{
			return TRUE;
		}
		else
		{
			$item = $sys->get_last_login_attempt($email);
			
			$timeframe = now() - $item->login_time;
			
			if ($timeframe > self::$lockout_time)
			{
				return TRUE;
			}
			
			return FALSE;
		}
	}
	
	/**
	 * Initiate the autologin process
	 *
	 * @return	mixed	the login error code (0 is successful) or FALSE if the user didn't want to be remembered
	 */
	protected static function _autologin()
	{
		// load the core model
		$mCore = new Model_Core;
		
		// get the uid from the database
		$args = array(
			'where' => array(
				array(
					'field' => 'sys_id',
					'value' => 1)
				),
			);
		$uid = $mCore->get('system_info', $args, 'sys_uid');
		
		// get the cookie
		$cookie = cookie::get('nova_'.$uid, FALSE, TRUE);
		
		if ($cookie !== FALSE)
		{
			$login = $this->login($cookie['email'], $cookie['password']);
			
			return $login;
		}
		
		return FALSE;
	}
	
	/**
	 * Destroy the cookie (called from the logout method)
	 *
	 * @return 	void
	 */
	protected static function _destroy_cookie()
	{
		// grab nova's unique identifier
		$uid = Jelly::select('system', 1)->uid;
		
		// destroy the cookie
		cookie::delete('nova_'.$uid.'[email]');
		cookie::delete('nova_'.$uid.'[password]');
	}
	
	/**
	 * Get the access page data to be used in the session
	 *
	 * @param	integer	the role ID
	 * @return 	array	the pages from the access role
	 */
	protected static function _set_access($role)
	{
		// load the models
		$access = new Access_Model;
		
		// a string of page ids
		$page_ids = $access->get_role_data($role);
		
		// get all the page data for those page ids
		$pages = $access->get_pages($page_ids);
		
		return $pages;
	}
	
	/**
	 * Set the cookie if a user wants to be remembered (called from the login method)
	 *
	 * @param	string	the email address
	 * @param	string	the password
	 * @return 	void
	 */
	protected static function _set_cookie($email, $password)
	{
		// grab nova's unique identifier
		$uid = Jelly::select('system', 1)->uid;
		
		// set the cookie
		cookie::set('nova_'.$uid.'[email]', $email, 1209600);
		cookie::set('nova_'.$uid.'[password]', $password, 1209600);
	}
	
	/**
	 * Set the session variables (called from the login method)
	 *
	 * @param	object	an object with the user information
	 * @return 	void
	 */
	protected static function _set_session(object $person)
	{
		// load the models
		$user = new Users_Model;
		$char = new Characters_Model;
		$menu = new Menu_Model;
		
		$characters = $char->get_user_characters($person->userid, '', 'array');
		
		// set the data that goes in to the session
		$array['userid'] = $person->userid;
		$array['skin_main'] = $person->skin_main;
		$array['skin_admin'] = $person->skin_admin;
		$array['skin_wiki'] = $person->skin_wiki;
		$array['display_rank'] = $person->display_rank;
		$array['language'] = $person->language;
		$array['timezone'] = $person->timezone;
		$array['dst'] = $person->daylight_savings;
		$array['main_char'] = $person->main_char;
		$array['characters'] = $characters;
		$array['access'] = $this->_set_access($person->access_role);
		
		// put my links into an array
		$my_links = explode(',', $person->my_links);
		
		if (count($my_links) > 0)
		{
			foreach ($my_links as $value)
			{
				$menus = $menu->get_menu_item($value);
			
				if ($menus->num_rows() > 0)
				{
					$item = $menus->row();
					
					$array['my_links'][] = anchor($item->menu_link, $item->menu_name);
				}
			}
		}
	
		// set first launch in the flashdata
		self::$session->set_flash('first_launch', $person->is_firstlaunch);
		self::$session->set_flash('password_reset', $person->password_reset);
		
		// set the session data
		self::$session->set($array);
		
		# TODO: need to optimize the table
	}
	
	/**
	 * Set the URI (called from the get_access_level and check_access methods)
	 *
	 * @return	string	a string with the URI properly set
	 */
	protected static function _set_uri()
	{
		// slice the current uri to only the first 2 segments
		$uri = array_slice(explode('/', Request::Instance()->uri()), 0, 2);
		
		// if there's only one array key, push INDEX on to the end
		$uri = (count($uri) == 1) ? array_push($uri, 'index') : $uri;
		
		// return the string
		return implode('/', $uri);
	}
	
	/**
	 * Method that does the legwork of verifying whether a
	 * user has the right login credentials
	 *
	 * @param	string	the email address
	 * @param	string	the password
	 * @param	boolean	whether or not to return the person object (TRUE) or the login code (FALSE)
	 * @return	mixed	an integer with the error code (0 means successful login) or the person object
	 */
	protected static function _verify($email, $password, $object = FALSE)
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
		$login = Jelly::select('user')->where('email', '=', $email)->execute();
		
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
			$person = $login->current();
			
			// make sure the password checks out
			$retval = ($person->password == $password) ? 0 : 3;
			
			if ($retval == 0 && $object === TRUE)
			{
				return $person;
			}
		}
		
		return $retval;
	}
} // End Auth