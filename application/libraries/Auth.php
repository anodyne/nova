<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
/*
|---------------------------------------------------------------
| AUTHENTICATION LIBRARY
|---------------------------------------------------------------
|
| File: libraries/Auth.php
| System Version: 1.0
|
| Library for all things authentication
|
*/

class Auth {
	
	var $allowed_login_attempts = 3;
	var $lockout_time = 1800; /* 30 minutes */
	
	function Auth()
	{
		/* log the debug message */
		log_message('debug', 'Auth Library Initialized');
	}
	
	function check_access($uri = '', $redirect = TRUE, $partial = FALSE)
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* set the URI */
		if (empty($uri))
		{
			$uri = $this->ci->uri->segment(1) .'/'. $this->ci->uri->segment(2);
		}
		
		if ($partial === TRUE)
		{
			$array = explode('/', $uri);
			$uri = $array[0];
		}
		
		if ($partial === FALSE)
		{
			if (!array_key_exists($uri, $this->ci->session->userdata('access')))
			{
				if ($redirect === TRUE)
				{
					$this->ci->session->set_flashdata('referer', $uri);
					
					redirect('admin/error/1');
				}
				else
				{
					return FALSE;
				}
			}
		}
		else
		{
			foreach ($this->ci->session->userdata('access') as $a => $b)
			{
				if (strpos($a, $uri) !== FALSE)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}
		
		return TRUE;
	}
	
	function get_access_level($uri = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		if (empty($uri))
		{
			$uri = $this->ci->uri->segment(1) .'/'. $this->ci->uri->segment(2);
		}
		
		$session = $this->ci->session->userdata('access');
			
		$segments = (is_array($uri)) ? $uri[1] .'/'. $uri[2] : $uri;
			
		if (array_key_exists($segments, $session))
		{
			return $session[$segments];
		}
		
		return FALSE;
	}
	
	function hash($string = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('system_model', 'sys');
		
		/* grab the Nova UID */
		$uid = $this->ci->sys->get_nova_uid();
		
		/* double hash the UID */
		$uid = sha1(sha1($uid));
		
		/* hash the string with the salt */
		$string = sha1($uid . $string);
		
		return $string;
	}
	
	function is_gamemaster($user = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		
		$gm = $this->ci->user->get_user($user, 'is_game_master');
		
		$retval = ($gm == 'y') ? TRUE : FALSE;
		
		return $retval;
	}
	
	function is_logged_in($redirect = FALSE)
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		if ($this->ci->session->userdata('userid') === FALSE)
		{
			$auto = $this->_autologin();
			
			if ($auto !== FALSE)
			{ /* if the autologin was successful */
				return TRUE;
			}
			
			if ($redirect === TRUE)
			{
				redirect('login/index/error/1');
			}
			else
			{
				return FALSE;
			}
		}
		
		return TRUE;
	}
	
	function is_sysadmin($user = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		
		$admin = $this->ci->user->get_user($user, 'is_sysadmin');
		
		$retval = ($admin == 'y') ? TRUE : FALSE;
		
		return $retval;
	}
	
	function is_webmaster($user = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		
		$web = $this->ci->user->get_user($user, 'is_webmaster');
		
		$retval = ($web == 'y') ? TRUE : FALSE;
		
		return $retval;
	}
	
	function login($email = '', $password = '', $remember = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		$this->ci->load->model('system_model', 'sys');
		
		/* xss clean of the data coming in */
		$email = $this->ci->input->xss_clean($email);
		$password = $this->ci->input->xss_clean($password);
		$remember = $this->ci->input->xss_clean($remember);
		
		/* set the variables */
		$retval = 0;
		$maintenance = $this->ci->settings->get_setting('maintenance');
		
		if ($email == '')
		{ /* if they don't put anything for an email address, stop right here */
			$retval = 2;
			return $retval;
		}
		
		if ($password == '')
		{ /* if they don't put anything for a password, stop right here */
			$retval = 3;
			return $retval;
		}
		
		$attempts = $this->_check_login_attempts($email);
		
		if ($attempts === FALSE)
		{
			$retval = 6;
			return $retval;
		}
		
		/* check to see if the account exists */
		$login = $this->ci->user->get_user_details_by_email($email);
		
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
				if ($maintenance == 'on' && $person->is_sysadmin == 'n')
				{
					/* maintenance mode active */
					$retval = 5;
				}
				else
				{
					/* clear the login attempts if there are any */
					$this->ci->sys->delete_login_attempts($email);
				
					/* update the login record */
					$this->ci->user->update_login_record($person->userid, now());
					
					/* set the session */
					$this->_set_session($person);
				}
			}
			else
			{
				/* password is wrong */
				$retval = 3;
				
				/* create the attempt array */
				$login_attempt = array(
					'login_ip' => $this->ci->input->ip_address(),
					'login_email' => $email,
					'login_time' => now()
				);
				
				/* add a record to login attempt table */
				$this->ci->sys->add_login_attempt($login_attempt);
			}
		}
		
		if ($remember == 'yes')
		{
			/* set the cookie */
			$this->_set_cookie($email, $password);
		}
		
		return $retval;
	}
	
	function logout()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* destroy the cookie */
		$this->_destroy_cookie();
		
		/* destroy the session */
		$this->ci->session->sess_destroy();
	}
	
	function set($param = '', $value = '')
	{
		$this->$param = $value;
	}
	
	function verify($email = '', $password = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		
		/* hash the password */
		$password = $this->hash($password);
		
		$retval = 0;
		
		$login = $this->ci->user->get_user_details_by_email($email);
		
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
	
	function _check_login_attempts($email = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		$this->ci->load->model('system_model', 'sys');
		
		$attempts = $this->ci->sys->count_login_attempts($email);
		
		if ($attempts < $this->allowed_login_attempts)
		{
			return TRUE;
		}
		else
		{
			$item = $this->ci->sys->get_last_login_attempt($email);
			
			$timeframe = now() - $item->login_time;
			
			if ($timeframe > $this->lockout_time)
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
	}
	
	function _autologin()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('system_model', 'sys');
		
		/* load the CI resources */
		$this->ci->load->helper('cookie');
		
		/* grab nova's unique identifier */
		$uid = $this->ci->sys->get_nova_uid();
		
		/* get the cookie */
		$cookie = get_cookie('nova_'. $uid, TRUE);
		
		if ($cookie !== FALSE)
		{
			$login = $this->login($cookie['email'], $cookie['password']);
			
			return $login;
		}
		
		return FALSE;
	}
	
	function _destroy_cookie()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('system_model', 'sys');
		
		/* load the CI resources */
		$this->ci->load->helper('cookie');
		
		/* grab nova's unique identifier */
		$uid = $this->ci->sys->get_nova_uid();
		
		/* set the cookie data */
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
		
		/* destroy the cookie */
		delete_cookie($c_data['email']);
		delete_cookie($c_data['password']);
	}
	
	function _set_access($role = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('access_model', 'access');
		
		/* a string of page ids */
		$page_ids = $this->ci->access->get_role_data($role);
		
		/* get all the page data for those page ids */
		$pages = $this->ci->access->get_pages($page_ids);
		
		return $pages;
	}
	
	function _set_cookie($email = '', $password = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('system_model', 'sys');
		
		/* load the CI resources */
		$this->ci->load->helper('cookie');
		
		/* grab nova's unique identifier */
		$uid = $this->ci->sys->get_nova_uid();
		
		/* set the cookie data */
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
		
		/* set the cookie */
		set_cookie($c_data['email']);
		set_cookie($c_data['password']);
	}
	
	function _set_session($person = '')
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->model('users_model', 'user');
		$this->ci->load->model('menu_model');
		$this->ci->load->model('characters_model', 'char');
		
		$characters = $this->ci->char->get_user_characters($person->userid, '', 'array');
		
		/* set the data that goes in to the session */
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
		
		/* put my links into an array */
		$my_links = explode(',', $person->my_links);
		
		if (count($my_links) > 0)
		{ /* first, make sure there is more than 1 link */
			foreach ($my_links as $value)
			{ /* get the data and put it into a temp array */
				$menus = $this->ci->menu_model->get_menu_item($value);
			
				if ($menus->num_rows() > 0)
				{
					$item = $menus->row();
					
					$array['my_links'][] = anchor($item->menu_link, $item->menu_name);
				}
			}
		}
	
		/* set first launch in the flashdata */
		$this->ci->session->set_flashdata('first_launch', $person->is_firstlaunch);
		$this->ci->session->set_flashdata('password_reset', $person->password_reset);
		
		/* set the session data */
		$this->ci->session->set_userdata($array);
		
		/* load the database utility class */
		$this->ci->load->dbutil();
		
		/* optimize the sessions table */
		$this->ci->dbutil->optimize_table('sessions');
	}
}

/* End of file Auth.php */
/* Location: ./application/libraries/Auth.php */