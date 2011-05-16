<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Date class extends Kohana's native Data class to provide additional
 * functionality that's specific to Nova. Extended methods include a make date
 * method and a method for accurately getting the current time.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

abstract class Nova_Date extends Kohana_Date {
	
	/**
	 * Makes a human readable date from a UNIX timestamp. The format is pulled
	 * from the database (done in the PHP date() format) and the timezone is
	 * pulled from the session if it exists or the database if a session doesn't
	 * exist.
	 *
	 *     echo Date::mdate(946706400);
	 *     // would produce: Sat Jan 1st 2000
	 *
	 *     echo Date::mdate(946706400, 'Y/m/d');
	 *     // would produce: 2000/01/01
	 *
	 * @access	public
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @param	int		the UNIX timestamp to convert
	 * @param	string	a PHP date() formatted string for the format of the date
	 * @return	string	the formatted date string
	 */
	public static function mdate($time, $format = null)
	{
		// get an instance of the session
		$session = Session::instance();
		
		// only get the date format from the database if an override isn't specified
		if ($format === null)
		{
			$format = Model_Settings::get_settings('date_format');
		}
		
		// get the default timezone from the database
		$tz = Model_Settings::get_settings('timezone');
		
		// set the timezone
		$timezone = $session->get('timezone', $tz);
		
		// get a new DateTime object based on the time
		$date = new DateTime('@'.$time, new DateTimeZone($timezone));
		
		return $date->format($format);
	}
	
	/**
	 * Returns the current time based on either the timezone in the session,
	 * or if the session doesn't exist, from the default timezone in the
	 * database.
	 *
	 *     $time = Date::now();
	 *
	 * @access	public
	 * @param	string	the timezone to use when creating the new datetime object
	 * @return	int		the UNIX timestamp of the current time
	 */
	public static function now($timezone = 'GMT')
	{
		$now = new DateTime('now', new DateTimeZone($timezone));
		
		return $now->format('U');
	}
	
	/**
	 * Returns an array with all of the timezones used in Nova.
	 *
	 * @access	public
	 * @return	array 	an array of timezones
	 */
	public static function timezones()
	{
		$zones = array(
			'Pacific/Midway'		=> ___("(UTC - 11:00) Nome, Midway Island, Samoa"),
			'Pacific/Honolulu'		=> ___("(UTC - 10:00) Hawaii"),
			'Pacific/Marquesas'		=> ___("(UTC - 9:30) Marquesas Islands"),
			'America/Juneau'		=> ___("(UTC - 9:00) Alaska"),
			'America/Los_Angeles'	=> ___("(UTC - 8:00) Pacific Time"),
			'America/Denver'		=> ___("(UTC - 7:00) Mountain Time"),
			'America/Chicago'		=> ___("(UTC - 6:00) Central Time, Mexico City"),
			'America/New_York'		=> ___("(UTC - 5:00) Eastern Time, Bogota, Lima, Quito"),
			'America/Caracas'		=> ___("(UTC - 4:30)  Caracas"),
			'America/Puerto_Rico'	=> ___("(UTC - 4:00) Atlantic Time, La Paz"),
			'America/St_Johns'		=> ___("(UTC - 3:30) Newfoundland"),
			'America/Buenos_Aires'	=> ___("(UTC - 3:00) Brazil, Buenos Aires, Georgetown, Falkland Islands"),
			'Atlantic/St_Helena'	=> ___("(UTC - 2:00) Mid-Atlantic, Ascention Is., St Helena"),
			'Atlantic/Azores'		=> ___("(UTC - 1:00) Azores, Cape Verde Islands"),
			'UTC'					=> ___("(UTC) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia"),
			'Europe/Berlin'			=> ___("(UTC + 1:00) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome"),
			'Europe/Warsaw'			=> ___("(UTC + 2:00) Kaliningrad, South Africa, Warsaw"),
			'Europe/Moscow'			=> ___("(UTC + 3:00) Baghdad, Riyadh, Moscow, Nairobi"),
			'Asia/Tehran'			=> ___("(UTC + 3:30) Tehran"),
			'Asia/Dubai'			=> ___("(UTC + 4:00) Adu Dhabi, Baku, Muscat, Tbilisi"),
			'Asia/Kabul'			=> ___("(UTC + 4:30) Kabul"),
			'Asia/Ashgabat'			=> ___("(UTC + 5:00) Islamabad, Karachi, Tashkent"),
			'Asia/Kolkata'			=> ___("(UTC + 5:30) Bombay, Calcutta, Madras, New Delhi"),
			'Asia/Kathmandu'		=> ___("(UTC + 5:45) Kathmandu"),
			'Asia/Dhaka'			=> ___("(UTC + 6:00) Almaty, Colomba, Dhaka"),
			'Asia/Rangoon'			=> ___("(UTC + 6:30) Rangoon"),
			'Asia/Jakarta'			=> ___("(UTC + 7:00) Bangkok, Hanoi, Jakarta"),
			'Asia/Hong_Kong'		=> ___("(UTC + 8:00) Beijing, Hong Kong, Perth, Singapore, Taipei"),
			'Australia/Eucla'		=> ___("(UTC + 8:45) Western Australia"),
			'Asia/Tokyo'			=> ___("(UTC + 9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk"),
			'Australia/Adelaide'	=> ___("(UTC + 9:30) Adelaide, Darwin"),
			'Australia/Sydney'		=> ___("(UTC + 10:00) Melbourne, Papua New Guinea, Sydney, Vladivostok"),
			'Australia/Lord_Howe'	=> ___("(UTC + 10:30) Lord Howe Island"),
			'Pacific/Guadalcanal'	=> ___("(UTC + 11:00) Magadan, New Caledonia, Solomon Islands"),
			'Pacific/Norfolk'		=> ___("(UTC + 11:30) Norfolk Island"),
			'Pacific/Auckland'		=> ___("(UTC + 12:00) Auckland, Wellington, Fiji, Marshall Island"),
			'Pacific/Chatham'		=> ___("(UTC + 12:45) Chatham Islands"),
			'Pacific/Enderbury'		=> ___("(UTC + 13:00) Phoenix Islands"),
			'Pacific/Kiritimati'	=> ___("(UTC + 14:00) Line Islands"),
		);
		
		return $zones;
	}
}
