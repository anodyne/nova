<?php
/**
 * CodeIgniter Utility Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David VanScott
 */

// ------------------------------------------------------------------------

/**
 * File Size
 *
 * Determine the file size of a number (in bytes) passed in and returns it
 * as the number of megabytes
 *
 * @access	public
 * @param	integer
 * @return	string
 */	
if ( ! function_exists('file_size'))
{
	function file_size($data = '')
	{
		if (empty($data))
		{
			return FALSE;
		}
		else
		{
			return round(($data / 1024000), 3);
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Check Memory vs. Database
 *
 * Check the memory consumption of the system vs the server memory limit
 * for running the database backup
 *
 * @access	public
 * @param	integer
 * @param	integer
 * @return	string
 */	
if ( ! function_exists('check_memory'))
{
	function check_memory($data = '', $usage = 3)
	{
		/* get the memory limit and pop the M off the end */
		$mem = ini_get('memory_limit');
		$mem = str_replace('M', '', $mem);
		
		/* nova consumes about 3MB of memory, so add that to the database size */
		$sys = $data + $usage;
		
		if ($sys >= $mem)
		{ /* if the potential memory consumption is greater than the limit, fail */
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Who's Online
 *
 * Displays a list of who is currently online
 *
 * @access	public
 * @return	string
 */	
if ( ! function_exists('whos_online'))
{
	function whos_online()
	{
		$ci =& get_instance();
	
		$ci->load->model('players_model', 'player');
		$ci->load->model('characters_model', 'char');
		
		$timespan = $ci->settings_model->get_setting('online_timespan');
		
		$online = $ci->player->get_online_players($timespan);
			
		if (count($online) > 0)
		{
			foreach ($online as $value)
			{
				$char = $ci->player->get_main_character($value);
				$array[$value] = $ci->char->get_character_name($char, TRUE);
			}
			
			$string = implode(', ', $array);
			
			return $string;
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * Parse Name
 *
 * Takes a list of arguments and parses them to make sure there are no blanks
 *
 * @access	public
 * @param	array
 * @return	string
 */	
if ( ! function_exists('parse_name'))
{
	function parse_name($segments = array())
	{
		foreach ($segments as $key => $value)
		{
			if (empty($value))
			{
				unset($segments[$key]);
			}
		}
	
		$string = implode(' ', $segments);
	
		return $string;
	}
}

// ------------------------------------------------------------------------

/**
 * Parse Dynamic Message
 *
 * Parse a message with variables in it
 *
 * @access	public
 * @param	string
 * @param	array
 * @return	string
 */	
if ( ! function_exists('parse_dynamic_message'))
{
	function parse_dynamic_message($message = '', $args = array())
	{
		$result = $message;

		foreach ($args as $key => $value)
		{
			if (strpos($result, '#'. $key .'#') !== FALSE)
			{
				$result = str_replace('#'. $key .'#', $value, $result);
			}
		}

		return $result;
	}
}

// ------------------------------------------------------------------------

/**
 * Is Valid Email
 *
 * Checks to see if an email is valid and if it has a valid MX record
 *
 * @access	public
 * @param	string
 * @param	boolean (true/false)
 * @return	boolean (true/false)
 */	
if ( ! function_exists('is_valid_email'))
{
	function is_valid_email($email = '', $test_mx = FALSE)
	{
		if (eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email))
		{
			if ($test_mx === TRUE)  
			{  
				list($username, $domain) = split('@', $email);
				return getmxrr($domain, $mxrecords);
			}
			else
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/* End of file utility_helper.php */
/* Location: ./application/helpers/utility_helper.php */