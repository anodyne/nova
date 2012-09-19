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
	 */
	public static function install()
	{
		// move to the latest migration
		\Migrate::latest('setup', 'module');
		
		// do the quick installs
		\QuickInstall::module();
		\QuickInstall::rank();
		\QuickInstall::skin();
		\QuickInstall::widget();

		// install the dev data
		static::installDevData();
		
		// clear the entire cache
		\Cache::delete_all();
		
		// cache the headers
		\Model_SiteContent::getSectionContent('header', 'main');
		\Model_SiteContent::getSectionContent('header', 'sim');
		\Model_SiteContent::getSectionContent('header', 'personnel');
		\Model_SiteContent::getSectionContent('header', 'search');
		\Model_SiteContent::getSectionContent('header', 'login');
		
		// cache the titles
		\Model_SiteContent::getSectionContent('title', 'main');
		\Model_SiteContent::getSectionContent('title', 'sim');
		\Model_SiteContent::getSectionContent('title', 'personnel');
		\Model_SiteContent::getSectionContent('title', 'search');
		\Model_SiteContent::getSectionContent('title', 'login');
		
		// cache the messages
		\Model_SiteContent::getSectionContent('message', 'main');
		\Model_SiteContent::getSectionContent('message', 'sim');
		\Model_SiteContent::getSectionContent('message', 'personnel');
		\Model_SiteContent::getSectionContent('message', 'search');
		\Model_SiteContent::getSectionContent('message', 'login');
		
		return true;
	}

	/**
	 * Install the development data into the database.
	 *
	 * @internal
	 * @return	bool
	 * @throws	NovaSetupException
	 */
	public static function installDevData()
	{
		if (\Config::get('nova.dev_install'))
		{
			// make sure we have a clean data variable
			$data = false;
			
			// load the dev install data
			include \Finder::search('assets/install', 'dev');
			
			// an array for tracking what did and didn't succeed
			$insert = array();

			// loop through the directory of data
			foreach ($data as $d)
			{
				// now loop through the actual data
				foreach ($$d['data'] as $k => $v)
				{
					try
					{
						// call the model's create method with the data from the dev file
						$insert[$d['data']] = call_user_func_array(array($d['model'], $d['method']), array($v));
					}
					catch (\Database_Exception $e)
					{
						// we're just going to ignore any exceptions since this is a dev-only thing
					}
				}
			}
			
			// if any of the dev data insert failed, throw an exception
			if (in_array(false, $insert))
			{
				throw new \NovaSetupException('Dev data insert failed.');
			}

			return true;
		}

		return false;
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
					\DB::escape(\Carbon::now('UTC')->timestamp)
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
