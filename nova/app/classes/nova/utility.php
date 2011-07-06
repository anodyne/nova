<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Utility class contains methods for a wide variety of operations that need
 * to be completed throughout the system.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Utility {
	
	/**
	 * Reads the directory path specified in the first parameter and builds an
	 * array representation of it and its contained files.
	 *
	 * __This is a port of the CodeIgniter directory_map function.__
	 *
	 *     // this will map sub-folders as well
	 *     $map = Utility::directory_map('./mydirectory/');
	 *
	 *     // this will not map sub-folders
	 *     $map = Utility::directory_map('./mydirectory/', true);
	 *
	 *     // this will map hidden files as well
	 *     $map = Utility::directory_map('./mydirectory/', true, true);
	 *
	 * @access	public
	 * @param	string	the path to map
	 * @param	bool	show the top level only?
	 * @param	bool	show hidden files?
	 * @return	array 	an array of the directory structure
	 */
	public static function directory_map($source_dir, $top_level_only = false, $hidden = false)
	{	
		if ($fp = @opendir($source_dir))
		{
			$source_dir = rtrim($source_dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;		
			$filedata = array();
			
			while (false !== ($file = readdir($fp)))
			{
				if (($hidden == false and strncmp($file, '.', 1) == 0) or ($file == '.' or $file == '..'))
				{
					continue;
				}
				
				if ($top_level_only == false and @is_dir($source_dir.$file))
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
			return false;
		}
	}
	
	/**
	 * Pulls the image index arrays from the base as well as the current skin.
	 *
	 *     $image_index = Utility::get_image_index('default');
	 *
	 * @access	public
	 * @uses	Kohana::find_file
	 * @uses	Kohana::load
	 * @param	string	the current skin
	 * @return 	array 	the image index array
	 */
	public static function get_image_index($skin)
	{
		// load the base image index
		$common = Kohana::find_file('views', 'images');
		$common_index = Kohana::load($common);
		
		// load the skin's image index
		$skin = Kohana::find_file('views', $skin.'/images');
		$skin_index = Kohana::load($skin);
		
		// merge the files into an array
		$image_index = array_merge( (array) $common_index, (array) $skin_index);
		
		return $image_index;
	}
	
	/**
	 * Uses the rank.json file to quickly install a rank set. If no value is
	 * passed to the method then the method will attempt to find all uninstalled
	 * ranks and install them.
	 *
	 *     Utility::install_rank();
	 *     Utility::install_rank('location');
	 *
	 * @access	public
	 * @uses	Kohana::$config->load
	 * @param	string	the location of a specific rank set to install
	 * @return	void
	 */
	public static function install_rank($location = null)
	{
		if ($location === null)
		{
			// get the directory listing for the genre
			$dir = self::directory_map(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/', true);
			
			// get all the rank sets locations
			$ranks = Model_CatalogueRank::get_all_items();
			
			if (count($ranks) > 0)
			{
				// start by removing anything that's already installed
				foreach ($ranks as $rank)
				{
					// find the location in the directory listing
					$key = array_search($rank->location, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
				
				// loop through the directories now
				foreach ($dir as $key => $value)
				{
					// assign our path to a variable
					$file = APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/'.$value.'/rank.json';
					
					// make sure the file exists first
					if (file_exists($file))
					{
						// get the contents and decode the JSON
						$content = file_get_contents($file);
						$data = json_decode($content);
						
						// create the item
						Model_CatalogueRank::create_item($data);
					}
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/'.$location.'/rank.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// create the item
				Model_CatalogueRank::create_item($data);
			}
		}
	}
	
	/**
	 * Uses the skin.json file to quickly install a skin. If no value is passed
	 * to the method then the method will attempt to find all uninstalled skins
	 * and install them.
	 *
	 *     Utility::install_skin();
	 *     Utility::install_skin('location');
	 *
	 * @access	public
	 * @param	string	the location of a skin to install
	 * @return	void
	 */
	public static function install_skin($location = null)
	{
		if ($location === null)
		{
			// get the listing of the directory
			$dir = self::directory_map(APPPATH.'views/', true);
			
			// get all the skin catalogue items
			$skins = Model_CatalogueSkin::get_all_items();
			
			if (count($skins) > 0)
			{
				// start by removing anything that's already installed
				foreach ($skins as $skin)
				{
					// find the location in the directory listing
					$key = array_search($skin->location, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
				
				// create an array of items to remove
				$pop = array('template.php');
				
				// remove the items
				foreach ($pop as $p)
				{
					// find the location in the directory listing
					$key = array_search($p, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
				
				// now loop through the directories and install the skins
				foreach ($dir as $key => $value)
				{
					// assign our path to a variable
					$file = APPPATH.'views/'.$value.'/skin.json';
					
					// make sure the file exists first
					if (file_exists($file))
					{
						$content = file_get_contents($file);
						$data = json_decode($content);
						
						$data_skin = array(
							'name' => $data->name,
							'location' => $data->location,
							'credits' => $data->credits,
							'version' => $data->version
						);
						
						// create the skin
						Model_CatalogueSkin::create_item($data_skin);
						
						// go through and add the sections
						foreach ($data->sections as $v)
						{
							$data_section = array(
								'section' => $v->type,
								'skin' => $data->location,
								'preview' => $v->preview,
								'status' => 'active',
								'default' => 0
							);
							
							// create the section
							Model_CatalogueSkinSec::create_item($data_section);
						}
					}
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'views/'.$location.'/skin.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				$data_skin = array(
					'name' => $data->name,
					'location' => $data->location,
					'credits' => $data->credits,
					'version' => $data->version
				);
				
				// create the skin
				Model_CatalogueSkin::create_item($data_skin);
				
				// go through and add the sections
				foreach ($data->sections as $v)
				{
					$data_section = array(
						'section' => $v->type,
						'skin' => $data->location,
						'preview' => $v->preview,
						'status' => 'active',
						'default' => 0
					);
					
					// create the section
					Model_CatalogueSkinSec::create_item($data_section);
				}
			}
		}
	}
	
	/**
	 * Checks to see if the system is installed.
	 *
	 *     $check = Utility::install_status();
	 *
	 * @access	public
	 * @uses	Request::initial
	 * @uses	Request::controller
	 * @uses	Request::redirect
	 * @uses	Kohana::$config->load
	 * @uses	Database::instance
	 * @uses	Database::list_tables
	 * @return	bool	is the system installed?
	 */
	public static function install_status()
	{
		// make sure the database config file is there first
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			// get an instance of the request
			$request = Request::initial();
			
			// make sure we take in to account the controllers this needs to ignore
			if (($request->directory() != 'setup'))
			{
				$request->redirect('setup/main/config');
			}
		}
		else
		{
			// get the database config
			$dbconf = Kohana::$config->load('database.default');
			
			// get an array of the tables in the system
			$tables = Database::instance()->list_tables($dbconf['table_prefix'].'%');
			
			// make sure there aren't any tables in there
			$retval = (count($tables) > 0) ? true : false;
			
			return $retval;
		}
	}
	
	/**
	 * Uses the widget.json file to quickly install a widget. If no value is
	 * passed to the method then the method will attempt to find all uninstalled
	 * widgets and install them.
	 *
	 *     Utility::install_widget();
	 *     Utility::install_widget('location');
	 *
	 * @access	public
	 * @uses	Jelly::query
	 * @uses	Jelly::factory
	 * @param	string	the location of a specific widget to install
	 * @return	void
	 */
	public static function install_widget($location = null)
	{
		if ($location === null)
		{
			// get the directory listing
			$dir = self::directory_map(MODPATH.'app/views/components/widgets/', true);
			
			// get all the installed widgets
			$widgets = Model_CatalogueWidget::get_all_items();
			
			if (count($widgets) > 0)
			{
				// start by removing anything that's already installed
				foreach ($widgets as $w)
				{
					// find the location in the directory listing
					$key = array_search($w->location, $dir);
					
					if ($key !== false)
					{
						unset($dir[$key]);
					}
				}
			}
			
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = MODPATH.'app/views/components/widgets/'.$value.'/widget.json';
				
				// make sure the file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);
					
					$data_widget = array(
						'name'		=> $data->name,
						'location'	=> $data->location,
						'page'		=> $data->page,
						'zone'		=> $data->zone,
						'status'	=> 'active',
						'credits'	=> $data->credits
					);
					
					// create the item
					Model_CatalogueWidget::create_item($data_widget);
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = MODPATH.'app/views/components/widgets/'.$location.'/widget.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				$data_widget = array(
					'name'		=> $data->name,
					'location'	=> $data->location,
					'page'		=> $data->page,
					'zone'		=> $data->zone,
					'status'	=> 'active',
					'credits'	=> $data->credits
				);
				
				// create the item
				Model_CatalogueWidget::create_item($data_widget);
			}
		}
	}
	
	/**
	 * Verifies that the server can run Nova.
	 *
	 * @access	public
	 * @uses	Kohana::$config->load
	 * @uses	Db::query
	 * @return	mixed	an array if there are any warnings or failures or false if everything checks out
	 */
	public static function verify_server()
	{
		// grab the database config
		$dbconf = Kohana::$config->load('database.default');
		
		// grab the database version
		$version = db::query(Database::SELECT, 'SELECT version() AS ver')->execute()->current();
		
		$items = array(
			'php' => array(
				'eval' => version_compare('5.2.4', PHP_VERSION, '<'),
				'header' => 'PHP',
				'text' => __('verify.php_text', array(':php_req' => '5.2.4', ':php_act' => PHP_VERSION)),
				'failure' => true),
			'db' => array(
				'eval' => ('mysql' == $dbconf['type']),
				'header' => 'MySQL',
				'text' => __('verify.db_text'),
				'failure' => true),
			'dbver' => array(
				'eval' => version_compare('4.1', $version['ver'], '<'),
				'header' => 'MySQL Version',
				'text' => __('verify.dbver_text', array(':db_req' => '4.1', ':db_act' => $version['ver'])),
				'failure' => true),
			'reflection' => array(
				'eval' => class_exists('ReflectionClass'),
				'header' => 'Reflection Class',
				'text' => __('verify.reflection_text'),
				'failure' => true),
			'filters' => array(
				'eval' => function_exists('filter_list'),
				'header' => 'Filters Enabled',
				'text' => __('verify.filters_text'),
				'failure' => true),
			'iconv' => array(
				'eval' => extension_loaded('iconv'),
				'header' => 'Iconv Enabled',
				'text' => __('verify.iconv_text'),
				'failure' => false),
			'spl' => array(
				'eval' => function_exists('spl_autoload_register'),
				'header' => 'SPL Autoloading',
				'text' => __('verify.spl_text'),
				'failure' => true),
			'mbstring_overload' => array(
				'eval' => extension_loaded('mbstring') and ! (ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING),
				'header' => 'mbstring Is Overloaded',
				'text' => __('verify.mbstring_overload_text'),
				'failure' => true),
			'pcre_utf8' => array(
				'eval' => @preg_match('/^.$/u', 'ñ'),
				'header' => 'PCRE UTF-8',
				'text' => __('verify.pcre_text'),
				'failure' => false),
			'pcre_unicode' => array(
				'eval' => @preg_match('/^\pL$/u', 'ñ'),
				'header' => 'PCRE Unicode',
				'text' => __('verify.pcre_text'),
				'failure' => false),
			'fopen' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fopen') === false,
				'header' => 'File Handling',
				'text' => __('verify.fopen_text'),
				'failure' => true),
			'fwrite' => array(
				'eval' => strpos(ini_get('disable_functions'), 'fwrite') === false,
				'header' => 'File Writing',
				'text' => __('verify.fwrite_text'),
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
