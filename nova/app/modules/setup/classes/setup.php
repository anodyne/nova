<?php
/**
 * The Setup class contains methods that handle many of the duplicated
 * tasks found throughout Nova's setup module.
 *
 * @package		Setup
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Setup {
	
	/**
	 * Install the system.
	 *
	 * @access	public
	 * @return	void
	 */
	public static function install()
	{
		// get an instance of the database
		$db = Database::instance();
		
		// update the character set
		$dbconfig = Kohana::$config->load('database');
		$db->set_charset($dbconfig['default']['charset']);
		
		// pull in the field information
		include_once MODPATH.'app/modules/setup/assets/install/fields.php';
		
		foreach ($data as $key => $value)
		{
			$fieldID = (isset($value['id'])) ? $value['id'] : 'id';
			$fieldName = (isset($value['fields'])) ? $value['fields'] : 'fields_'.$key;
			
			DBForge::add_field($$fieldName);
			DBForge::add_key($fieldID, true);
			
			if (isset($value['index']))
			{
				foreach ($value['index'] as $index)
				{
					DBForge::add_key($index);
				}
			}
			
			DBForge::create_table($key, true);
		}
		
		// pause the script for a second
		sleep(1);
		
		// wipe out the data from inserting the tables
		$data = null;
		
		// pull in the basic data
		include_once MODPATH.'app/modules/setup/assets/install/data.php';
		
		$insert = array();
		
		foreach ($data as $value)
		{
			foreach ($$value as $k => $v)
			{
				$sql = DB::insert($value)
					->columns(array_keys($v))
					->values(array_values($v))
					->compile($db);
					
				$insert[$value] = $db->query(Database::INSERT, $sql, true);
			}
		}
		
		// pause the script for a second
		sleep(1);
		
		// wipe out the data from insert the data
		$data = null;
		
		// pull in the genre data
		include_once MODPATH.'app/modules/setup/assets/install/genres/'.strtolower(Kohana::$config->load('nova.genre')).'.php';
		
		$genre = array();
		
		foreach ($data as $key_d => $value_d)
		{
			foreach ($$value_d as $k => $v)
			{
				$sql = DB::insert($key_d)
					->columns(array_keys($v))
					->values(array_values($v))
					->compile($db);
					
				$genre[$key_d] = $db->query(Database::INSERT, $sql, true);
			}
		}
		
		if (Kohana::$config->load('install.dev'))
		{
			// pause the script for a second
			sleep(1);
			
			// wipe out the data from insert the data
			$data = null;
			
			// pull in the development test data
			include_once MODPATH.'app/modules/setup/assets/install/dev.php';
			
			$insert = array();
			
			foreach ($data as $value)
			{
				foreach ($$value as $k => $v)
				{
					$sql = DB::insert($value)
						->columns(array_keys($v))
						->values(array_values($v))
						->compile($db);
						
					$insert[$value] = $db->query(Database::INSERT, $sql, true);
				}
			}
		}
		
		// do the quick installs
		Utility::install_rank();
		Utility::install_skin();
		Utility::install_widget();
	}
	
	/**
	 * Send the registration email out.
	 *
	 * @access	public
	 * @param	string	the type of registration (install, update, upgrade)
	 * @return	void
	 */
	public static function register($type)
	{
		if (Kohana::$environment == Kohana::PRODUCTION)
		{
			if ($path = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required'))
			{
				// load the file
				Kohana::load($path);
				
				// get an instance of the database
				$db = Database::instance();
				
				// build the data we need
				$request = array(
					Kohana::$config->load('novasys.app_name'),
					Kohana::$config->load('novasys.app_version_full'),
					Url::site(),
					$_SERVER['REMOTE_ADDR'],
					$_SERVER['SERVER_ADDR'],
					phpversion(),
					$type,
					Kohana::$config->load('nova.genre'),
				);
				
				$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, type, date, genre) VALUES (%s, %s, %s, %s, %s, %s, %s, %d, %s);";
				
				$data['message'] = sprintf(
					$insert,
					$db->escape($request[0]),
					$db->escape($request[1]),
					$db->escape($request[2]),
					$db->escape($request[3]),
					$db->escape($request[4]),
					$db->escape($request[5]),
					$db->escape($request[6]),
					$db->escape($request[7]),
					$db->escape(Date::now())
				);
				
				// send the email
				//$email = email::install_register($data);
			}
		}
	}
	
	/**
	 * Verifies that the server can run Nova.
	 *
	 * @access	public
	 * @return	mixed	an array if there are any warnings or failures or false if everything checks out
	 */
	public static function verify_server()
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
