<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication library
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_auth {
	
	/**
	 * The number of allowed log in attempts before lockout
	 */
	public static $allowed_login_attempts = 5;
	
	/**
	 * The standard lockout time in seconds
	 */
	public static $lockout_time = 1800;
	
	public function __construct()
	{
		log_message('debug', 'Auth Library Initialized');
	}
	
	public static function check_access($uri = null, $redirect = true, $partial = false)
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// set the URI
		if (empty($uri))
		{
			$uri = $ci->uri->segment(1) .'/'. $ci->uri->segment(2);
		}
		
		if ($partial)
		{
			$array = explode('/', $uri);
			$uri = $array[0];
		}
		
		if ( ! $partial)
		{
			$access = $ci->session->userdata('access');
			$access = ( ! $access) ? array() : $access;
			
			if ( ! array_key_exists($uri, $access))
			{
				if ($redirect)
				{
					$ci->session->set_flashdata('referer', $uri);
					
					redirect('admin/error/1');
				}
				
				return false;
			}
		}
		else
		{
			foreach ($ci->session->userdata('access') as $a => $b)
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
	 * Get a user's access level for the URI passed to the method.
	 *
	 * @access	public
	 * @param	string	the URI
	 * @return	mixed	the access level or FALSE if there is no level
	 */
	public static function get_access_level($uri = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// make sure we have a URI to work with
		$uri = (empty($uri)) ? $ci->uri->segment(1).'/'.$ci->uri->segment(2) : $uri;
		
		// obviously you need to be logged in to have an access level
		if (self::is_logged_in())
		{
			// grab the access stuff from the session
			$session = $ci->session->userdata('access');
			
			// split out the segments
			$segments = (is_array($uri)) ? $uri[1] .'/'. $uri[2] : $uri;
			
			// find the URI in the access array if it's there
			if (is_array($session) and array_key_exists($segments, $session))
			{
				return $session[$segments];
			}
		}
		
		return false;
	}
	
	public static function hash($string = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('system_model', 'sys');
		
		// grab the Nova UID
		$uid = $ci->sys->get_nova_uid();
		
		// double hash the UID
		$uid = sha1(sha1($uid));
		
		// hash the string with the salt
		$string = sha1($uid . $string);
		
		return $string;
	}
	
	public static function is_gamemaster($user = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		
		$gm = $ci->user->get_user($user, 'is_game_master');
		
		$retval = ($gm == 'y');
		
		return $retval;
	}
	
	public static function is_logged_in($redirect = false)
	{
		// get an instance of CI
		$ci =& get_instance();
		
		if ( ! $ci->session->userdata('userid'))
		{
			$auto = self::_autologin();
			
			if ($auto)
			{
				return true;
			}
			
			if ($redirect)
			{
				redirect('login/index/error/1');
			}
			
			return false;
		}
		
		return true;
	}
	
	public static function is_sysadmin($user = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		
		$admin = $ci->user->get_user($user, 'is_sysadmin');
		
		$retval = ($admin == 'y');
		
		return $retval;
	}
	
	public static function is_webmaster($user = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		
		$web = $ci->user->get_user($user, 'is_webmaster');
		
		$retval = ($web == 'y');
		
		return $retval;
	}
	
	public static function login($email = '', $password = '', $remember = '', $autologin_attempt = false)
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		$ci->load->model('system_model', 'sys');
		$ci->load->model('settings_model', 'settings');
		
		// xss clean of the data coming in
		$email = $ci->security->xss_clean($email);
		$password = $ci->security->xss_clean($password);
		$remember = $ci->security->xss_clean($remember);
		
		// set the variables
		$retval = 0;
		$maintenance = $ci->settings->get_setting('maintenance');
		
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
		
		$attempts = self::_check_login_attempts($email);
		
		if ( ! $attempts)
		{
			$retval = 6;
			return $retval;
		}
		
		// check to see if the account exists
		$login = $ci->user->get_user_details_by_email($email);
		
		if ($login->num_rows() == 0)
		{
			// email doesn't exist
			$retval = 2;
		}
		elseif ($login->num_rows() > 1)
		{
			// more than one account found - contact the GM
			$retval = 4;
		}
		else
		{
			// assign the object to a variable
			$person = $login->row();
			
			if ($person->password == $password)
			{
				if ($maintenance == 'on' and $person->is_sysadmin == 'n')
				{
					// maintenance mode active
					$retval = 5;
				}
				elseif ($person->status == 'pending')
				{
					// they haven't been approved yet
					$retval = 7;
				}
				else
				{
					// clear the login attempts if there are any
					$ci->sys->delete_login_attempts($email);
				
					// update the login record
					$ci->user->update_login_record($person->userid, now());
					
					// set the session
					self::_set_session($person);
				}
			}
			else
			{
				// password is wrong
				$retval = 3;
				
				if ( ! $autologin_attempt)
				{
					// create the attempt array
					$login_attempt = array(
						'login_ip' => $ci->input->ip_address(),
						'login_email' => $email,
						'login_time' => now()
					);
					
					// add a record to login attempt table
					$ci->sys->add_login_attempt($login_attempt);
				}
			}
		}
		
		if ($remember == 'yes')
		{
			// set the cookie
			self::_set_cookie($email, $password);
		}
		
		return $retval;
	}
	
	public static function logout()
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// destroy the cookie
		self::_destroy_cookie();
		
		// destroy the session
		$ci->session->sess_destroy();
	}
	
	public static function set($param = '', $value = '')
	{
		self::$param = $value;
	}
	
	public static function verify($email = '', $password = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		
		// hash the password
		$password = self::hash($password);
		
		$retval = 0;
		
		$login = $ci->user->get_user_details_by_email($email);
		
		if ($login->num_rows() == 0)
		{
			// email doesn't exist
			$retval = 2;
		}
		elseif ($login->num_rows() > 1)
		{
			// more than one account found - contact the GM
			$retval = 4;
		}
		else
		{
			// assign the object to a variable
			$person = $login->row();
			
			if ($person->password == $password)
			{
				$retval = 0;
			}
			else
			{
				// password is wrong
				$retval = 3;
			}
		}
		
		return $retval;
	}
	
	protected static function _check_login_attempts($email = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		$ci->load->model('system_model', 'sys');
		
		$attempts = $ci->sys->count_login_attempts($email);
		
		if ($attempts < self::$allowed_login_attempts)
		{
			return true;
		}
		else
		{
			$item = $ci->sys->get_last_login_attempt($email);
			
			$timeframe = now() - $item->login_time;
			
			if ($timeframe > self::$lockout_time)
			{
				// clear the login attempts if there are any
				$ci->sys->delete_login_attempts($email);
					
				return true;
			}
			
			return false;
		}
	}
	
	protected static function _autologin()
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('system_model', 'sys');
		
		// load the CI resources
		$ci->load->helper('cookie');
		
		// grab nova's unique identifier
		$uid = $ci->sys->get_nova_uid();
		
		// get the cookie
		$cookie = get_cookie('nova_'. $uid, true);
		
		if ($cookie !== false and is_array($cookie))
		{
			$login = self::login($cookie['email'], $cookie['password'], null, true);
			
			return $login;
		}
		
		return false;
	}
	
	protected static function _destroy_cookie()
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('system_model', 'sys');
		
		// load the CI resources
		$ci->load->helper('cookie');
		
		// grab nova's unique identifier
		$uid = $ci->sys->get_nova_uid();
		
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
		delete_cookie($c_data['email']);
		delete_cookie($c_data['password']);
	}
	
	protected static function _set_access($role = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('access_model', 'access');
		
		// a string of page ids
		$page_ids = $ci->access->get_role_data($role);
		
		// get all the page data for those page ids
		$pages = $ci->access->get_pages($page_ids);
		
		return $pages;
	}
	
	protected static function _set_cookie($email = '', $password = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('system_model', 'sys');
		
		// load the CI resources
		$ci->load->helper('cookie');
		
		// grab nova's unique identifier
		$uid = $ci->sys->get_nova_uid();
		
		// set the cookie data
		$c_data = array(
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
		set_cookie($c_data['email']);
		set_cookie($c_data['password']);
	}
	
	protected static function _set_session($person = '')
	{
		// get an instance of CI
		$ci =& get_instance();
		
		// load the resources
		$ci->load->model('users_model', 'user');
		$ci->load->model('menu_model');
		$ci->load->model('characters_model', 'char');
		
		$characters = $ci->char->get_user_characters($person->userid, '', 'array');
		
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
		$array['role'] = $person->access_role;
		$array['access'] = self::_set_access($person->access_role);
		
		// put my links into an array
		$my_links = explode(',', $person->my_links);
		
		if (count($my_links) > 0)
		{
			foreach ($my_links as $value)
			{
				$menus = $ci->menu_model->get_menu_item($value);
			
				if ($menus->num_rows() > 0)
				{
					$item = $menus->row();
					
					$array['my_links'][] = anchor($item->menu_link, $item->menu_name);
				}
			}
		}
	
		// set first launch in the flashdata
		$ci->session->set_flashdata('first_launch', $person->is_firstlaunch);
		$ci->session->set_flashdata('password_reset', $person->password_reset);
		
		// set the session data
		$ci->session->set_userdata($array);
		
		// load the database utility class
		$ci->load->dbutil();
		
		// optimize the sessions table
		$ci->dbutil->optimize_table('sessions');
	}
}
