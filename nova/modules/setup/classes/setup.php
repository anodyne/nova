<?php
/**
 * The Setup class contains methods for operations that need to be completed 
 * during setup.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Setup
{
	/**
	 * Install Nova.
	 *
	 * @internal
	 * @return	bool
	 * @throws	NovaSetupException
	 */
	public static function install()
	{
		// move to the latest migration
		\Migrate::latest('setup', 'module');
		
		if (\Config::get('nova.dev_install'))
		{
			// pause the script for a few seconds to let the server breathe
			sleep(3);
			
			// wipe out the data from inserting the data
			unset($data);
			
			// load the file
			include \Finder::search('assets/install', 'dev');
			
			$insert = array();
			
			foreach ($data as $value)
			{
				foreach ($$value as $k => $v)
				{
					// do the query
					$result = \DB::insert($value)->set($v)->execute();

					// capture whether it was successful or not
					$insert[$value] = (is_array($result));
				}
			}
			
			if (in_array(false, $insert))
			{
				throw new \NovaSetupException('Dev data insert failed.');
			}
		}
		
		// do the quick installs
		\QuickInstall::module();
		\QuickInstall::rank();
		\QuickInstall::skin();
		\QuickInstall::widget();
		
		// clear the entire cache
		\Cache::delete_all();
		
		// cache the headers
		\Model_SiteContent::get_section_content('header', 'main');
		\Model_SiteContent::get_section_content('header', 'sim');
		\Model_SiteContent::get_section_content('header', 'personnel');
		\Model_SiteContent::get_section_content('header', 'search');
		\Model_SiteContent::get_section_content('header', 'login');
		
		// cache the titles
		\Model_SiteContent::get_section_content('title', 'main');
		\Model_SiteContent::get_section_content('title', 'sim');
		\Model_SiteContent::get_section_content('title', 'personnel');
		\Model_SiteContent::get_section_content('title', 'search');
		\Model_SiteContent::get_section_content('title', 'login');
		
		// cache the messages
		\Model_SiteContent::get_section_content('message', 'main');
		\Model_SiteContent::get_section_content('message', 'sim');
		\Model_SiteContent::get_section_content('message', 'personnel');
		\Model_SiteContent::get_section_content('message', 'search');
		\Model_SiteContent::get_section_content('message', 'login');
		
		return true;
	}
	
	/**
	 * Send the registration email out.
	 *
	 * @internal
	 * @param	string	the type of registration (install, update, upgrade)
	 * @return	bool
	 * @todo
	 */
	public static function register($type)
	{
		if (\Fuel::$env == \Fuel::PRODUCTION)
		{
			if ($path = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required'))
			{
				// load the file
				Kohana::load($path);
				
				// build the data we need
				$request = array(
					\Config::get('nova.app_name'),
					\Config::get('nova.app_version_full'),
					\Uri::base(false),
					$_SERVER['REMOTE_ADDR'],
					$_SERVER['SERVER_ADDR'],
					PHP_VERSION,
					$type,
					\Config::get('nova.genre'),
				);
				
				$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, type, date, genre) VALUES (%s, %s, %s, %s, %s, %s, %s, %d, %s);";
				
				$data['message'] = sprintf(
					$insert,
					\DB::escape($request[0]),
					\DB::escape($request[1]),
					\DB::escape($request[2]),
					\DB::escape($request[3]),
					\DB::escape($request[4]),
					\DB::escape($request[5]),
					\DB::escape($request[6]),
					\DB::escape($request[7]),
					\DB::escape(time())
				);
				
				// send the email
				//$email = email::install_register($data);
			}
		}

		return false;
	}

	/**
	 * Uninstall Nova.
	 *
	 * @internal
	 * @return	bool
	 */
	public static function uninstall()
	{
		// get all modules
		$modules = \Model_Catalog_Module::find('all');

		// loop through the modules and uninstall them
		foreach ($modules as $m)
		{
			if (is_dir(APPPATH.'modules/'.$m->location.'/migrations'))
			{
				\Migrate::version(0, $m->location, 'module');
			}
		}

		// move down to the zero migration
		\Migrate::version(0, 'setup', 'module');

		// remove the cache item
		\Cache::delete('nova_system_installed');

		return true;
	}
}
