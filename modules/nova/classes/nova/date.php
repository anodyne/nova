<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * The Date class extends Kohana's native Data class to provide additional functionality that's
 * specific to Nova. Extended methods include a make date method and a method for accurately
 * getting the current time.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Date extends Kohana_Date
{
	/**
	 * Makes the date from a UNIX timestamp with the format provided. Date formats should
	 * be in the PHP date() format unlike Nova 1.0 which uses the MySQL format.
	 *
	 *     echo mdate('D M jS Y', 946706400);
	 *     // would produce Sat Jan 1st 2000
	 *
	 * @param	string	the format to use for the date
	 * @param	integer	the UNIX timestamp to convert
	 * @param	string	the timezone to use for converting the timestamp
	 * @return	string	the formatted date string
	 */
	public static function mdate($format, $time, $timezone = 'GMT')
	{
		$date = new DateTime('@'.$time, new DateTimeZone($timezone));
		
		return $date->format($format);
	}
	
	/**
	 * Returns the current time with the timezone specified.
	 *
	 *     // get the current time
	 *     $time = date::now();
	 *
	 *     // get the current time in New York
	 *     $time = date::now('America/New_York');
	 *
	 * @param	string	the timezone to use for creating the current timestamp (GMT default)
	 * @return	integer	the UNIX timestamp of the current time
	 */
	public static function now($timezone = 'GMT')
	{
		$now = new DateTime('now', new DateTimeZone($timezone));
		
		return $now->format('U');
	}
} // End date