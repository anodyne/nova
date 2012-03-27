<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Date Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/date_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Timespan Short
 *
 * Returns a span of seconds in this format:
 *	10 days 14 hours
 * 
 * This is identical to timespan except that
 * it drops minutes and seconds from the string
 *
 * @access	public
 * @param	integer	a number of seconds
 * @param	integer	Unix timestamp
 * @return	integer
 */	
if ( ! function_exists('timespan_short'))
{
	function timespan_short($seconds = 1, $time = '')
	{
		$CI =& get_instance();
		$CI->lang->load('date');
		$CI->lang->load('app');
		
		if ($seconds !== NULL)
		{
			if ( ! is_numeric($seconds))
			{
				$seconds = 1;
			}
		
			if ( ! is_numeric($time))
			{
				$time = time();
			}
		
			if ($time <= $seconds)
			{
				$seconds = 1;
			}
			else
			{
				$seconds = $time - $seconds;
			}
			
			$str = '';
			$years = floor($seconds / 31536000);
		
			if ($years > 0)
			{	
				$str .= $years.' '.$CI->lang->line((($years	> 1) ? 'date_years' : 'date_year')).', ';
			}	
		
			$seconds -= $years * 31536000;
			$months = floor($seconds / 2628000);
		
			if ($years > 0 OR $months > 0)
			{
				if ($months > 0)
				{	
					$str .= $months.' '.$CI->lang->line((($months	> 1) ? 'date_months' : 'date_month')).', ';
				}	
		
				$seconds -= $months * 2628000;
			}
	
			$weeks = floor($seconds / 604800);
		
			if ($years > 0 OR $months > 0 OR $weeks > 0)
			{
				if ($weeks > 0)
				{	
					$str .= $weeks.' '.$CI->lang->line((($weeks	> 1) ? 'date_weeks' : 'date_week')).', ';
				}
			
				$seconds -= $weeks * 604800;
			}			
	
			$days = floor($seconds / 86400);
		
			if ($months > 0 OR $weeks > 0 OR $days > 0)
			{
				if ($days > 0)
				{	
					$str .= $days.' '.$CI->lang->line((($days	> 1) ? 'date_days' : 'date_day')).', ';
				}
		
				$seconds -= $days * 86400;
			}
		
			$hours = floor($seconds / 3600);
		
			if ($days > 0 OR $hours > 0)
			{
				if ($hours > 0)
				{
					$str .= $hours.' '.$CI->lang->line((($hours	> 1) ? 'date_hours' : 'date_hour')).', ';
				}
			
				$seconds -= $hours * 3600;
			}
			else
			{
				return ucfirst($CI->lang->line('labels_less')) .' '. $CI->lang->line('labels_than') . ' 1 '. strtolower($CI->lang->line('date_hour')).' '.$CI->lang->line('time_ago');
			}
		
			$minutes = floor($seconds / 60);
				
			return substr(trim($str), 0, -1) .' '. $CI->lang->line('time_ago');
		}
		else
		{
			return ucwords($CI->lang->line('labels_no') .' '. $CI->lang->line('labels_data') .' '. $CI->lang->line('labels_available'));
		}
	}
	
	/**
	 * Converts GMT time to a localized value
	 *
	 * Takes a Unix timestamp (in GMT) as input, and returns at the local value
	 * based on the timezone and DST setting submitted
	 *
	 * This change in the code is an attempt to make sure we aren't throwing the 
	 * illegal operand error message by checking that what comes back from the 
	 * timezones() function is in fact an integer.
	 *
	 * @access	public
	 * @param	integer Unix timestamp
	 * @param	string	timezone
	 * @param	bool	whether DST is active
	 * @return	integer
	 */	
	function gmt_to_local($time = '', $timezone = 'UTC', $dst = FALSE)
	{			
		if ($time == '')
		{
			return now();
		}
		
		$zone = timezones($timezone);
		$zone = ( ! is_numeric($zone)) ? 0 : $zone;
		
		$time += $zone * 3600;
	
		if ($dst === true)
		{
			$time += 3600;
		}
	
		return $time;
	}
}
