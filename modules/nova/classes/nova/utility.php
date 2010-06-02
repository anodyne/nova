<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Utility Class
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Utility
{
	/**
	 * Initializes the class and sets a debug message.
	 *
	 * @return 	void
	 */
	public function __construct()
	{
		Kohana_Log::Instance()->add('debug', 'Auth library initialized.');
	}
	
	/**
	 * Pulls the image index arrays from the base as well as the current skin.
	 *
	 *     $image_index = Utility::get_image_index('default');
	 *
	 * @uses	Kohana::find_file
	 * @uses	Kohana::load
	 * @param	string	the current skin
	 * @return 	array 	the image index array
	 */
	public static function get_image_index($skin)
	{
		// load the base image index
		$common = Kohana::find_file('views', '_common/image_index');
		$common_index = Kohana::load($common);
		
		// load the skin's image index
		$skin = Kohana::find_file('views', $skin.'/image_index');
		$skin_index = Kohana::load($skin);
		
		// merge the files into an array
		$image_index = array_merge((array)$common_index, (array)$skin_index);
		
		return $image_index;
	}
	
	/**
	 * Prints a date in the proper format and with the right timezone
	 *
	 *     echo utility::print_date(1271393940);
	 *     // would produce: Thur Apr 15th 2010 @ 11:59pm
	 *
	 * @uses	Session::Instance
	 * @uses	Session::get
	 * @uses	Date::mdate
	 * @param	integer	the UNIX timestamp to print out
	 * @return	string	the formatted date string
	 */
	public static function print_date($time)
	{
		// get an instance of the session
		$session = Session::Instance();
		
		// get the date format
		$format = Jelly::select('setting')->where('key', '=', 'date_format')->load()->value;
		
		// set the timezone
		$timezone = $session->get('timezone', 'GMT');
		
		return date::mdate($format, $time, $timezone);
	}
	
	/**
	 * Verifies that the server can run Nova
	 *
	 * @return	mixed	an array if there are any warnings or failures or FALSE if everything checks out
	 */
	public static function verify_server()
	{
		// grab the database config
		$dbconf = Kohana::config('database.default');
		
		// grab the database version
		$version = db::query(Database::SELECT, 'SELECT version() AS ver')->execute()->current();
		
		$items = array(
			'php' => array(
				'eval' => version_compare('5.2.4', PHP_VERSION, '<'),
				'header' => 'PHP',
				'text' => __('verify.php_text', array(':php_req' => '5.2.4', ':php_act' => PHP_VERSION)),
				'failure' => TRUE),
			'db' => array(
				'eval' => ('mysql' == $dbconf['type']),
				'header' => 'MySQL',
				'text' => __('verify.db_text'),
				'failure' => TRUE),
			'dbver' => array(
				'eval' => version_compare('4.1', $version['ver'], '<'),
				'header' => 'MySQL Version',
				'text' => __('verify.dbver_text', array(':db_req' => '4.1', ':db_act' => $version['ver'])),
				'failure' => TRUE),
			'reflection' => array(
				'eval' => class_exists('ReflectionClass'),
				'header' => 'Reflection Class',
				'text' => __('verify.reflection_text'),
				'failure' => TRUE),
			'filters' => array(
				'eval' => function_exists('filter_list'),
				'header' => 'Filters Enabled',
				'text' => __('verify.filters_text'),
				'failure' => TRUE),
			'iconv' => array(
				'eval' => extension_loaded('iconv'),
				'header' => 'Iconv Enabled',
				'text' => __('verify.iconv_text'),
				'failure' => FALSE),
			'spl' => array(
				'eval' => function_exists('spl_autoload_register'),
				'header' => 'SPL Autoloading',
				'text' => __('verify.spl_text'),
				'failure' => TRUE),
			'mbstring' => array(
				'eval' => extension_loaded('mbstring'),
				'header' => 'MBString Available',
				'text' => __('verify.mbstring_text'),
				'failure' => TRUE),
			'mbstring_overload' => array(
				'eval' => ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING,
				'header' => 'MBString Overloaded',
				'text' => __('verify.mbstring_overload_text'),
				'failure' => TRUE),
			'pcre_utf8' => array(
				'eval' => ! @preg_match('/^.$/u', 'ñ'),
				'header' => 'PCRE UTF-8',
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
			'pcre_unicode' => array(
				'eval' => ! @preg_match('/^\pL$/u', 'ñ'),
				'header' => 'PCRE Unicode',
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
		);
		
		foreach ($items as $key => $value)
		{
			if ($value['eval'] === FALSE)
			{
				$type = ($value['failure'] === TRUE) ? 'failure' : 'info';
				
				$verify[$type][$value['header']] = $value['text'];
			}
		}
		
		if (isset($verify))
		{
			return $verify;
		}
		
		return FALSE;
	}
} // End Utility