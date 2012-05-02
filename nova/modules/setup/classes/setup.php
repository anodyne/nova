<?php
/**
 * The Setup class contains methods for operations that need to be
 * completed during setup.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

/**
 * Nova Install Exception
 */
class NovaInstallException extends \FuelException {}

# TODO: registration email

class Setup
{
	/**
	 * Install Nova.
	 *
	 * @internal
	 * @return	bool
	 * @throws	NovaInstallException
	 */
	public static function install()
	{
		// get the database connection
		$conn = \Database_Connection::instance();
		
		// find the path to the fields file
		$field_path = \Finder::search('assets/install', 'fields');

		// load the file
		include $field_path;
		
		foreach ($data as $table => $value)
		{
			// set the primary key
			$primary_key = (isset($value['id'])) ? array($value['id']) : array('id');

			// set the fields for the table
			$fields = (isset($value['fields'])) ? $$value['fields'] : ${'fields_'.$table};

			// create the table with the values
			\DBUtil::create_table($table, $fields, $primary_key);
			
			// if we've specified an index, create it
			if (isset($value['index']))
			{
				foreach ($value['index'] as $index)
				{
					\DBUtil::create_index($table, $index);
				}
			}
		}
		
		// pause the script for a few seconds to let the server breathe
		sleep(5);
		
		// wipe out the data from inserting the tables
		unset($data);
		
		// find the path to the data file
		$data_path = \Finder::search('assets/install', 'data');
		
		// load the file
		include $data_path;
		
		$insert = array();
		
		foreach ($data as $value)
		{
			foreach ($$value as $k => $v)
			{
				if ($value == 'roles_tasks')
				{
					foreach ($v as $task)
					{
						// do the query
						$result = \DB::insert($value)
							->columns(array('role_id', 'task_id'))
							->values(array($k, $task))
							->execute();
					}
				}
				else
				{
					// do the query
					$result = \DB::insert($value)->set($v)->execute();

					// capture whether it was successful or not
					$insert[$value] = (is_array($result));
				}
			}
		}
		
		if (in_array(false, $insert))
		{
			throw new NovaInstallException('Basic data insert failed.');
		}
		
		// pause the script for a few seconds to let the server breathe
		sleep(5);
		
		// wipe out the data from insert the data
		unset($data);
		
		// find the path to the genre data file
		$genre_path = \Finder::search('assets/install/genres', strtolower(\Config::get('nova.genre')));
		
		// load the file
		include $genre_path;
		
		$genre = array();
		
		foreach ($data as $key_d => $value_d)
		{
			foreach ($$value_d as $k => $v)
			{
				// do the query
				$result = \DB::insert($key_d)->set($v)->execute();

				// capture whether it was successful or not
				$genre[$key_d] = (is_array($result));
			}
		}
		
		if (in_array(false, $genre))
		{
			throw new NovaInstallException('Genre data insert failed.');
		}
		
		if (\Config::get('nova.dev_install'))
		{
			// pause the script for a few seconds to let the server breathe
			sleep(5);
			
			// wipe out the data from inserting the data
			unset($data);
			
			// find the path to the dev data file
			$dev_path = \Finder::search('assets/install', 'dev');
			
			// load the file
			include $dev_path;
			
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
				throw new NovaInstallException('Dev data insert failed.');
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
	 * Install Nova with migrations.
	 *
	 * @internal
	 * @return	bool
	 */
	public static function migration_install()
	{
		// move up to the latest migration
		\Migrate::latest('setup', 'module');
		
		if (\Config::get('nova.dev_install'))
		{
			// pause the script for a few seconds to let the server breathe
			sleep(5);
			
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
				throw new NovaInstallException('Dev data insert failed.');
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
	 * @return	bool 	whether the registration happened or not
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
}
