<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Auth Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Auth
{	
	// the number of allowed login attempts
	public static $allowed_login_attempts = 5;
	
	// the lockout time is 30 minutes
	public static $lockout_time = 1800;
	
	public static $session;
	
	public function __construct()
	{
		// get an instance of the session library
		self::$session = Session::instance();
		
		Kohana_Log::Instance()->add('debug', 'Auth library initialized.');
	}
	
	/**
	 * Check a user's access to see if they're allowed to access a page
	 *
	 * @param	string	the URI to check in the access session array
	 * @param	boolean	whether to redirect to the login page (default: true)
	 * @param	boolean	whether to search for a partial match (default: false)
	 * @return			a boolean value of whether the user is allowed to access the page
	 */
	public static function check_access($uri = '', $redirect = TRUE, $partial = FALSE)
	{
		// make sure the uri is set properly
		$uri = (empty($uri)) ? self::_set_uri() : $uri;
		
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
	 * Grab the access level from the session's access array to find out how much
	 * access a user has to the page
	 *
	 * @param	string	the URI to check
	 * @return			the access level for a given page or FALSE if no access
	 */
	public static function get_access_level($uri = '')
	{
		// make sure the uri is set properly
		$uri = (empty($uri)) ? self::_set_uri() : $uri;
		
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
	 * Hash a string and salt it with the system UID
	 *
	 * WARNING: uninstalling the system and re-installing it with the same data will break
	 * all passwords since the UID is never the same between two installations
	 *
	 * @param	string	the string to hash
	 * @return			the hashed string
	 */
	public static function hash($string = '')
	{
		// grab the system model
		$sys = Jelly::select('system', 1);
		
		// grab the Nova UID
		$uid = $sys->uid;
		
		// double hash the UID
		$uid = sha1(sha1($uid));
		
		// hash the string with the salt
		$string = sha1($uid . $string);
		
		return $string;
	}
	
	/**
	 * Checks to see if someone is logged in or not
	 *
	 * @param	boolean	whether a failure should redirect the user to the login page
	 * @return			TRUE/FALSE depending on its result or a redirect to the login page
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
	 * Checks to see if the user is flagged a certain way
	 *
	 * @param	string	what is the type to check for (webmaster, game_master, sysadmin)
	 * @param	integer	the user id to check
	 * @return			a boolean value of whether or not the user is the type passed in the first parameter
	 */
	public static function is_type($type = '', $id = '')
	{
		// load the user model
		$user = Jelly::select('user', $id);
		
		// check the database for the flag
		$is = $user->$type;
		
		// figure out whether it's true or false
		$retval = ($is == 'y') ? TRUE : FALSE;
		
		return $retval;
	}
	
	/**
	 * Executes the login process, sets the remember me cookie if it's been requested
	 * and calls the method to set the session variables
	 *
	 * @param	string	the email address
	 * @param	string	the password (should already be hashed using Auth::hash())
	 * @param	string	whether to set the auto-login (y, n)
	 * @return			an integer with the error code, 0 means a successful login
	 */
	public static function login($email = '', $password = '', $remember = '')
	{
		// set the variables
		$retval = 0;
		$maintenance = Jelly::select('setting')->where('key', '=', 'maintenance')->load()->value;
		
		if ($email == '')
		{
			$retval = 2;
			return $retval;
		}
		
		if ($password == '')
		{
			$retval = 3;
			return $retval;
		}
		
		$attempts = $this->_check_login_attempts($email);
		
		if ($attempts === FALSE)
		{
			$retval = 6;
			return $retval;
		}
		
		// check to see if the account exists
		$login = Jelly::select('user')
			->where('email', '=', $email)
			->execute();
		
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
			/* assign the object to a variable */
			$person = $login->current();
			
			if ($person->password == $password)
			{
				if ($maintenance == 'on' && $person->sysadmin == 'n')
				{
					// maintenance mode active
					$retval = 5;
				}
				else
				{
					// clear the login attempts if there are any
					$sys->delete_login_attempts($email);
				
					// update the login record
					$user->update_login_record($person->userid, now());
					
					// set the session
					self::_set_session($person);
				}
			}
			else
			{
				// password is wrong
				$retval = 3;
				
				// create the attempt array
				$login_attempt = array(
					'login_ip' => $this->input->ip_address(),
					'login_email' => $email,
					'login_time' => now()
				);
				
				/* add a record to login attempt table */
				$sys->add_login_attempt($login_attempt);
			}
		}
		
		if ($remember == 'yes')
		{
			// set the cookie
			$this->_set_cookie($email, $password);
		}
		
		return $retval;
	}
	
	/**
	 * Log the user out of the system, destroy their cookies and session variables
	 */
	public static function logout()
	{
		// destroy any cookies that exist
		$this->_destroy_cookie();
		
		// wipe out the session
		self::$session->destroy();
	}
	
	/**
	 * Verify a user's login credentials
	 *
	 * @param	string	the email address
	 * @param	string	the password (this should already be hashed using Auth::hash())
	 * @return			an integer with the error code, 0 means a successful login
	 */
	public static function verify($email = '', $password = '')
	{
		// load the resources
		$user = new Model_User;
		
		// hash the password
		$password = self::hash($password);
		
		$retval = 0;
		
		$login = $user->get_user_details_by_email($email);
		
		if ($login->num_rows() == 0)
		{
			/* email doesn't exist */
			$retval = 2;
		}
		elseif ($login->num_rows() > 1)
		{
			/* more than one account found - contact the GM */
			$retval = 4;
		}
		else
		{
			/* assign the object to a variable */
			$person = $login->row();
			
			if ($person->password == $password)
			{
				$retval = 0;
			}
			else
			{
				/* password is wrong */
				$retval = 3;
			}
		}
		
		return $retval;
	}
	
	/**
	 * Checks to see how many login attempts a user has in the allowed timeframe
	 *
	 * @param	string	the email address
	 * @return			a boolean value of whether the user is allowed to try another login attempt
	 */
	protected static function _check_login_attempts($email = '')
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
	 * @return			an integer of the login error code (0 = success) or FALSE if the user didn't want to be remembered
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
	 */
	protected static function _destroy_cookie()
	{
		// load the models
		$sys = new Model_System;
		
		// grab nova's unique identifier
		$uid = $sys->get_nova_uid();
		
		// set the cookie data
		$c_data = array(
			'email' => array(
				'name'   => $uid .'[email]',
				'value'  => '',
				'expire' => '0',
				'prefix' => 'nova_'),
			'password' => array(
				'name'   => $uid .'[password]',
				'value'  => '',
				'expire' => '0',
				'prefix' => 'nova_')
		);
		
		// destroy the cookie
		cookie::delete($c_data['email']);
		cookie::delete($c_data['password']);
	}
	
	protected static function _set_access($role = '')
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
	 */
	protected static function _set_cookie($email = '', $password = '')
	{
		// load the models
		$sys = new System_Model;
		
		// grab nova's unique identifier
		$uid = $sys->get_nova_uid();
		
		// set the cookie data
		$c_data = array
		(
			'email' => array(
				'name'   => $uid .'[email]',
				'value'  => $email,
				'expire' => '1209600',
				'prefix' => 'nova_'),
			'password' => array(
				'name'   => $uid .'[password]',
				'value'  => $password,
				'expire' => '1209600',
				'prefix' => 'nova_')
		);
		
		// set the cookie
		cookie::set($c_data['email']);
		cookie::set($c_data['password']);
	}
	
	/**
	 * Set the session variables (called from the login method)
	 *
	 * @param	object	an object with the user information
	 */
	protected static function _set_session($person = '')
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
	 * @return			a string with the URI properly set
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
}

// End of file auth.php
// Location: modules/nova/classes/nova/auth.php