<?php
/**
 * The Verify class contains methods for verifying various things about Nova and
 * about the server attempting to run Nova.
 *
 * @package		Setup
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

class Verify {
	
	/**
	 * Verifies that the server can run Nova.
	 *
	 * @access	public
	 * @return	mixed	an array if there are any warnings or failures or false if everything checks out
	 */
	public static function server()
	{
		// grab the database config
		$dbconf = Kohana::config('database.default');
		
		// grab the database version
		$version = DB::query(Database::SELECT, 'SELECT version() AS ver')->execute()->current();
		
		$items = array(
			'php' => array(
				'eval' => version_compare('5.3.0', PHP_VERSION, '<'),
				'header' => 'PHP',
				'text' => ___('verify.php_text', array(':php_req' => '5.3.0', ':php_act' => PHP_VERSION)),
				'failure' => true),
			'db' => array(
				'eval' => ('mysql' == $dbconf['type']),
				'header' => 'MySQL',
				'text' => ___('verify.db_text'),
				'failure' => true),
			'dbver' => array(
				'eval' => version_compare('4.1', $version['ver'], '<'),
				'header' => 'MySQL Version',
				'text' => ___('verify.dbver_text', array(':db_req' => '4.1', ':db_act' => $version['ver'])),
				'failure' => true),
			'reflection' => array(
				'eval' => class_exists('ReflectionClass'),
				'header' => 'Reflection Class',
				'text' => ___('verify.reflection_text'),
				'failure' => true),
			'filters' => array(
				'eval' => function_exists('filter_list'),
				'header' => 'Filters Enabled',
				'text' => ___('verify.filters_text'),
				'failure' => true),
			'iconv' => array(
				'eval' => extension_loaded('iconv'),
				'header' => 'Iconv Enabled',
				'text' => ___('verify.iconv_text'),
				'failure' => false),
			'spl' => array(
				'eval' => function_exists('spl_autoload_register'),
				'header' => 'SPL Autoloading',
				'text' => ___('verify.spl_text'),
				'failure' => true),
			'mbstring_overload' => array(
				'eval' => extension_loaded('mbstring') and ! (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
				'header' => 'mbstring Is Overloaded',
				'text' => ___('verify.mbstring_overload_text'),
				'failure' => true),
			'pcre_utf8' => array(
				'eval' => @preg_match('/^.$/u', 'ñ'),
				'header' => 'PCRE UTF-8',
				'text' => ___('verify.pcre_text'),
				'failure' => false),
			'pcre_unicode' => array(
				'eval' => @preg_match('/^\pL$/u', 'ñ'),
				'header' => 'PCRE Unicode',
				'text' => ___('verify.pcre_text'),
				'failure' => false),
			'fopen' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fopen') === false,
				'header' => 'File Handling',
				'text' => ___('verify.fopen_text'),
				'failure' => true),
			'fwrite' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fwrite') === false,
				'header' => 'File Writing',
				'text' => ___('verify.fwrite_text'),
				'failure' => false),
		);
		
		foreach ($items as $key => $value)
		{
			if ($value['eval'] === false)
			{
				$type = ($value['failure'] === true) ? 'failure' : 'info';
				
				$verify[$type][$value['header']] = $value['text'];
			}
		}
		
		if (isset($verify))
		{
			return $verify;
		}
		
		return false;
	}
}
