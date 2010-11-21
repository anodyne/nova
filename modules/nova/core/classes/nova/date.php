<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Date class extends Kohana's native Data class to provide additional functionality that's
 * specific to Nova. Extended methods include a make date method and a method for accurately
 * getting the current time.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
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
	 * @param	integer	the UNIX timestamp to convert
	 * @param	string	a PHP date() formatted string for the format of the date
	 * @return	string	the formatted date string
	 */
	public static function mdate($time, $format = NULL)
	{
		// get an instance of the session
		$session = Session::instance();
		
		// only get the date format from the database if an override isn't specified
		if ($format === NULL)
		{
			$format = Jelly::query('setting', 'date_format')->limit(1)->select()->value;
		}
		
		// get the default timezone from the database
		$tz = Jelly::query('setting', 'timezone')->limit(1)->select()->value;
		
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
	 *     // get the current time
	 *     $time = Date::now();
	 *
	 * @param	string	the timezone to use when creating the new datetime object
	 * @return	integer	the UNIX timestamp of the current time
	 */
	public static function now($timezone = 'GMT')
	{
		// get a new DateTime object based on the timezone
		$now = new DateTime('now', new DateTimeZone($timezone));
		
		return $now->format('U');
	}
	
	/**
	 * Returns an array with all of the timezones used in Nova
	 *
	 * @return	array 	an array of timezones
	 */
	public static function timezones()
	{
		$zones = array(
			'Pacific/Midway'		=> __("(UTC - 11:00) Nome, Midway Island, Samoa"),
			'Pacific/Honolulu'		=> __("(UTC - 10:00) Hawaii"),
			'Pacific/Marquesas'		=> __("(UTC - 9:30) Marquesas Islands"),
			'America/Juneau'		=> __("(UTC - 9:00) Alaska"),
			'America/Los_Angeles'	=> __("(UTC - 8:00) Pacific Time"),
			'America/Denver'		=> __("(UTC - 7:00) Mountain Time"),
			'America/Chicago'		=> __("(UTC - 6:00) Central Time, Mexico City"),
			'America/New_York'		=> __("(UTC - 5:00) Eastern Time, Bogota, Lima, Quito"),
			'America/Caracas'		=> __("(UTC - 4:30)  Caracas"),
			'America/Puerto_Rico'	=> __("(UTC - 4:00) Atlantic Time, La Paz"),
			'America/St_Johns'		=> __("(UTC - 3:30) Newfoundland"),
			'America/Buenos_Aires'	=> __("(UTC - 3:00) Brazil, Buenos Aires, Georgetown, Falkland Islands"),
			'Atlantic/St_Helena'	=> __("(UTC - 2:00) Mid-Atlantic, Ascention Is., St Helena"),
			'Atlantic/Azores'		=> __("(UTC - 1:00) Azores, Cape Verde Islands"),
			'UTC'					=> __("(UTC) Casablanca, Dublin, Edinburgh, London, Lisbon, Monrovia"),
			'Europe/Berlin'			=> __("(UTC + 1:00) Berlin, Brussels, Copenhagen, Madrid, Paris, Rome"),
			'Europe/Warsaw'			=> __("(UTC + 2:00) Kaliningrad, South Africa, Warsaw"),
			'Europe/Moscow'			=> __("(UTC + 3:00) Baghdad, Riyadh, Moscow, Nairobi"),
			'Asia/Tehran'			=> __("(UTC + 3:30) Tehran"),
			'Asia/Dubai'			=> __("(UTC + 4:00) Adu Dhabi, Baku, Muscat, Tbilisi"),
			'Asia/Kabul'			=> __("(UTC + 4:30) Kabul"),
			'Asia/Ashgabat'			=> __("(UTC + 5:00) Islamabad, Karachi, Tashkent"),
			'Asia/Kolkata'			=> __("(UTC + 5:30) Bombay, Calcutta, Madras, New Delhi"),
			'Asia/Kathmandu'		=> __("(UTC + 5:45) Kathmandu"),
			'Asia/Dhaka'			=> __("(UTC + 6:00) Almaty, Colomba, Dhaka"),
			'Asia/Rangoon'			=> __("(UTC + 6:30) Rangoon"),
			'Asia/Jakarta'			=> __("(UTC + 7:00) Bangkok, Hanoi, Jakarta"),
			'Asia/Hong_Kong'		=> __("(UTC + 8:00) Beijing, Hong Kong, Perth, Singapore, Taipei"),
			'Australia/Eucla'		=> __("(UTC + 8:45) Western Australia"),
			'Asia/Tokyo'			=> __("(UTC + 9:00) Osaka, Sapporo, Seoul, Tokyo, Yakutsk"),
			'Australia/Adelaide'	=> __("(UTC + 9:30) Adelaide, Darwin"),
			'Australia/Sydney'		=> __("(UTC + 10:00) Melbourne, Papua New Guinea, Sydney, Vladivostok"),
			'Australia/Lord_Howe'	=> __("(UTC + 10:30) Lord Howe Island"),
			'Pacific/Guadalcanal'	=> __("(UTC + 11:00) Magadan, New Caledonia, Solomon Islands"),
			'Pacific/Norfolk'		=> __("(UTC + 11:30) Norfolk Island"),
			'Pacific/Auckland'		=> __("(UTC + 12:00) Auckland, Wellington, Fiji, Marshall Island"),
			'Pacific/Chatham'		=> __("(UTC + 12:45) Chatham Islands"),
			'Pacific/Enderbury'		=> __("(UTC + 13:00) Phoenix Islands"),
			'Pacific/Kiritimati'	=> __("(UTC + 14:00) Line Islands"),
		);
		
		return $zones;
	}
} // End date