<?php
/**
 * The Verify class contains methods for verifying various things about Nova and
 * about the server attempting to run Nova.
 *
 * @package		Setup
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
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
		$dbconf = Kohana::$config->load('database.default');
		
		// grab the database version
		$version = DB::query(Database::SELECT, 'SELECT version() AS ver')->execute()->current();
		
		$items = array(
			'php' => array(
				'eval' => version_compare('5.3.0', PHP_VERSION, '<'),
				'header' => 'PHP',
				'text' => ___('setup.verify.php', array(':php_req' => '5.3.0', ':php_act' => PHP_VERSION)),
				'failure' => true),
			'db' => array(
				'eval' => ('mysql' == $dbconf['type']),
				'header' => 'MySQL',
				'text' => ___('setup.verify.db'),
				'failure' => true),
			'dbver' => array(
				'eval' => version_compare('4.1', $version['ver'], '<'),
				'header' => 'MySQL Version',
				'text' => ___('setup.verify.dbversion', array(':db_req' => '4.1', ':db_act' => $version['ver'])),
				'failure' => true),
			'reflection' => array(
				'eval' => class_exists('ReflectionClass'),
				'header' => 'Reflection Class',
				'text' => ___('setup.verify.reflection'),
				'failure' => true),
			'filters' => array(
				'eval' => function_exists('filter_list'),
				'header' => 'Filters Enabled',
				'text' => ___('setup.verify.filters'),
				'failure' => true),
			'iconv' => array(
				'eval' => extension_loaded('iconv'),
				'header' => 'Iconv Enabled',
				'text' => ___('setup.verify.iconv'),
				'failure' => false),
			'spl' => array(
				'eval' => function_exists('spl_autoload_register'),
				'header' => 'SPL Autoloading',
				'text' => ___('setup.verify.spl'),
				'failure' => true),
			'mbstring_overload' => array(
				'eval' => extension_loaded('mbstring') and ! (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
				'header' => 'mbstring Is Overloaded',
				'text' => ___('setup.verify.mbstring_overload'),
				'failure' => true),
			'pcre_utf8' => array(
				'eval' => @preg_match('/^.$/u', 'ñ'),
				'header' => 'PCRE UTF-8',
				'text' => ___('setup.verify.pcre'),
				'failure' => false),
			'pcre_unicode' => array(
				'eval' => @preg_match('/^\pL$/u', 'ñ'),
				'header' => 'PCRE Unicode',
				'text' => ___('setup.verify.pcre'),
				'failure' => false),
			'fopen' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fopen') === false,
				'header' => 'File Handling',
				'text' => ___('setup.verify.fopen'),
				'failure' => true),
			'fwrite' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fwrite') === false,
				'header' => 'File Writing',
				'text' => ___('setup.verify.fwrite'),
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
