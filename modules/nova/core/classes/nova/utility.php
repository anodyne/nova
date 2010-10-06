<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Utility Class
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Utility {
	
	/**
	 * Initializes the class and sets a debug message.
	 *
	 * @return 	void
	 */
	public function __construct()
	{
		Kohana_Log::instance()->add('debug', 'Auth library initialized.');
	}
	
	/**
	 * Reads the directory path specified in the first parameter and builds an array representation
	 * of it and its contained files.
	 *
	 * *This is a port of the CodeIgniter directory_map function.*
	 *
	 *     // this will map sub-folders as well
	 *     $map = Utility::directory_map('./mydirectory/');
	 *
	 *     // this will not map sub-folders
	 *     $map = Utility::directory_map('./mydirectory/', TRUE);
	 *
	 *     // this will map hidden files as well
	 *     $map = Utility::directory_map('./mydirectory/', TRUE, TRUE);
	 *
	 * @param	string	the path to map
	 * @param	boolean	show the top level only?
	 * @param	boolean	show hidden files?
	 * @return	array 	an array of the directory structure
	 */
	public static function directory_map($source_dir, $top_level_only = FALSE, $hidden = FALSE)
	{	
		if ($fp = @opendir($source_dir))
		{
			$source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;		
			$filedata = array();
			
			while (FALSE !== ($file = readdir($fp)))
			{
				if (($hidden == FALSE AND strncmp($file, '.', 1) == 0) OR ($file == '.' OR $file == '..'))
				{
					continue;
				}
				
				if ($top_level_only == FALSE AND @is_dir($source_dir.$file))
				{
					$temp_array = array();
				
					$temp_array = self::directory_map($source_dir.$file.DIRECTORY_SEPARATOR, $top_level_only, $hidden);
				
					$filedata[$file] = $temp_array;
				}
				else
				{
					$filedata[] = $file;
				}
			}
			
			closedir($fp);
			return $filedata;
		}
		else
		{
			return FALSE;
		}
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
	 * Uses the rank.yml file to quickly install a rank set
	 *
	 *     Utility::install_ranks();
	 *
	 * @uses	Utility::directory_map()
	 * @uses	Kohana::find_file()
	 * @uses	Kohana::load()
	 * @param	string	the value of a specific rank set to install
	 * @return	void
	 */
	public static function install_ranks($value = NULL)
	{
		// get the list of classes that have been loaded
		$classes = get_declared_classes();
		
		// if sfYaml hasn't been loaded, then load it
		if ( ! in_array('sfYaml', $classes))
		{
			// find the sfYAML library
			$path = Kohana::find_file('vendor', 'sfYaml/sfYaml');
			
			// load the sfYAML library
			Kohana::load($path);
		}
		
		// get the directory listing for the genre
		$dir = self::directory_map(APPPATH.'assets/common/'.Kohana::config('nova.genre').'/ranks/', TRUE);
		
		// get all the rank sets locations
		$ranks = Jelly::query('cataloguerank')->where('genre', '=', Kohana::config('nova.genre'))->select();
		
		if (count($ranks) > 0)
		{
			// start by removing anything that's already installed
			foreach ($ranks as $rank)
			{
				// find the location in the directory listing
				$key = array_search($rank->location, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			// set the items to be pulled out of the listing
			$pop = array('index.html');
			
			// remove unwanted items
			foreach ($pop as $value)
			{
				// find the locations in the directory listing
				$key = array_search($value, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = APPPATH.'assets/common/'.Kohana::config('nova.genre').'/ranks/'.$value.'/rank.yml';
				
				// make sure the file exists first
				if (file_exists($file))
				{
					// load the YAML data into an array
					$content = sfYaml::load($file);
					
					// add the item to the database
					$add = Jelly::query('cataloguerank')
						->columns(array(
							'name',
							'location',
							'credits',
							'preview',
							'blank',
							'extension',
							'url',
							'genre'
						))
						->values(array(
							$content['rank'],
							$content['location'],
							$content['credits'],
							$content['preview'],
							$content['blank'],
							$content['extension'],
							$content['url'],
							$content['genre']
						))
						->insert();
				}
			}
		}
	}
	
	/**
	 * Uses the skin.yml file to quickly install a skin
	 *
	 *     Utility::install_skins();
	 *
	 * @uses	Utility::directory_map()
	 * @uses	Kohana::find_file()
	 * @uses	Kohana::load()
	 * @param	string	the value of a specific skin set to install
	 * @return	void
	 */
	public static function install_skins($value = '')
	{
		// get the list of classes that have been loaded
		$classes = get_declared_classes();
		
		// if sfYaml hasn't been loaded, then load it
		if ( ! in_array('sfYaml', $classes))
		{
			// find the sfYAML library
			$path = Kohana::find_file('vendor', 'sfYaml/sfYaml');
			
			// load the sfYAML library
			Kohana::load($path);
		}
		
		// get the listing of the directory
		$dir = self::directory_map(APPPATH.'views/', TRUE);
		
		// get all the skin catalogue items
		$skins = Jelly::query('catalogueskin')->select();
		
		if (count($skins) > 0)
		{
			// start by removing anything that's already installed
			foreach ($skins as $skin)
			{
				// find the location in the directory listing
				$key = array_search($skin->location, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			// create an array of items to remove
			$pop = array('index.html');
			
			# TODO: remove this after the application directory has been cleaned out
			$pop[] = '_base';
			$pop[] = 'template.php';
			
			// remove the items
			foreach ($pop as $value)
			{
				// find the location in the directory listing
				$key = array_search($value, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			// now loop through the directories and install the skins
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = APPPATH.'views/'.$value.'/skin.yml';
				
				// make sure the file exists first
				if (file_exists($file))
				{
					// load the YAML data into an array
					$content = sfYaml::load($file);
					
					// add the skin to the database
					Jelly::query('catalogueskin')
						->columns(array(
							'name',
							'location',
							'credits'
						))
						->values(array(
							$content['skin'],
							$content['location'],
							$content['credits'],
						))
						->insert();
					
					// go through and add the sections
					foreach ($content['sections'] as $v)
					{
						Jelly::query('catalogueskinsec')
							->columns(array(
								'section',
								'skin',
								'preview',
								'status',
								'default'
							))
							->values(array(
								$v['type'],
								$content['location'],
								$v['preview'],
								'active',
								'n'
							))
							->insert();
					}
				}
			}
		}
	}
	
	/**
	 * Checks to see if the system is installed.
	 *
	 *     $check = Utiliity::install_status();
	 *
	 * @return	boolean	is the system installed?
	 */
	public static function install_status()
	{
		// get the database config
		$dbconf = Kohana::config('database.default');
		
		// get an array of the tables in the system
		$tables = Database::instance()->list_tables($dbconf['table_prefix'].'%');
		
		// make sure there aren't any tables in there
		$retval = (count($tables) > 0) ? TRUE : FALSE;
		
		return $retval;
	}
	
	/**
	 * Prints a date in the proper format and with the right timezone
	 *
	 *     echo utility::print_date(1271393940);
	 *     // would produce: Thur Apr 15th 2010 @ 11:59pm
	 *
	 * @uses	Session::instance
	 * @uses	Session::get
	 * @uses	Date::mdate
	 * @param	integer	the UNIX timestamp to print out
	 * @return	string	the formatted date string
	 */
	public static function print_date($time)
	{
		// get an instance of the session
		$session = Session::instance();
		
		// get the date format
		$format = Jelly::query('setting', 'date_format')->limit(1)->select()->value;
		
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
			'mbstring_overload' => array(
				'eval' => extension_loaded('mbstring') AND ! (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
				'header' => 'mbstring Is Overloaded',
				'text' => __('verify.mbstring_overload_text'),
				'failure' => TRUE),
			'pcre_utf8' => array(
				'eval' => @preg_match('/^.$/u', 'ñ'),
				'header' => 'PCRE UTF-8',
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
			'pcre_unicode' => array(
				'eval' => @preg_match('/^\pL$/u', 'ñ'),
				'header' => 'PCRE Unicode',
				'text' => __('verify.pcre_text'),
				'failure' => FALSE),
			'fopen' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fopen') === FALSE,
				'header' => 'File Handling',
				'text' => __('verify.fopen_text'),
				'failure' => TRUE),
			'fwrite' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fwrite') === FALSE,
				'header' => 'File Writing',
				'text' => __('verify.fwrite_text'),
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