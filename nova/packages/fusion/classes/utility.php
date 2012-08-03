<?php
/**
 * The Utility class contains methods for a wide variety of operations that need
 * to be completed throughout the system.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class Utility
{
	/**
	 * Check for updates to the system.
	 *
	 * 0 - no updates
	 * 1 - major update (3.0 => 4.0)
	 * 2 - minor update (3.0 => 3.1)
	 * 3 - incremental update (3.0.1 => 3.0.2)
	 *
	 * @api
	 * @uses	Config::load
	 * @uses	Config::get
	 * @uses	Model_Settings::get_settings
	 * @uses	Model_System::find
	 * @return 	mixed	false if there are no updates, an object with information if there are
	 */
	public static function check_for_updates()
	{
		if (ini_get('allow_url_fopen'))
		{
			// grab the update setting preference
			$pref = \Model_Settings::get_settings('updates');
			
			// get the ignore version info
			$sys = \Model_System::find('first');
			
			// load the nova config file
			\Config::load('nova::nova', 'nova');
			
			// load the data
			$content = file_get_contents(\Config::get('nova.version_info'));
			
			// parse the content
			$US = json_decode($content);

			if ($US !== null)
			{
				// if the admin has ignored this version, stop execution
				if (version_compare($US->version, $sys->version_ignore, '=='))
				{
					return false;
				}
				
				// build the system version string
				$sysversion = $sys->version_major.'.'.$sys->version_minor.'.'.$sys->version_update;
				
				// check the version in the system versus what's coming from the update server
				if (version_compare($sysversion, $US->version, '<'))
				{
					// if the admin wants to see these specific updates, pass the object along
					if ($US->severity <= $pref)
					{
						return $US;
					}
					
					return false;
				}
			}

			return false;
		}
		
		return false;
	}

	/**
	 * Pulls the image index arrays from the base as well as the current skin.
	 *
	 * <code>
	 * $image_index = Utility::get_image_index('default');
	 * </code>
	 *
	 * @api
	 * @uses	Finder::search
	 * @uses	Fuel::load
	 * @param	string	the current skin
	 * @return 	array 	the image index array
	 */
	public static function get_image_index($skin)
	{
		// load the image index from the nova module first
		$common_path = \Finder::search('views', 'nova::images');
		$common_index = \Fuel::load($common_path);
		
		// load the current skin's image index (if it has one)
		$skin_path = \Finder::search('views', $skin.'/images');
		$skin_index = ($skin_path !== false) ? \Fuel::load($skin_path) : array();
		
		// merge the files into an array
		$image_index = array_merge( (array) $common_index, (array) $skin_index);
		
		return $image_index;
	}

	/**
	 * Get the current rank set, whether it's the user's preference or the
	 * system default.
	 *
	 * @api
	 * @return	string
	 */
	public static function get_rank()
	{
		if (\Sentry::check())
		{
			$pref = \Model_User::find(\Sentry::user()->id)->get_user_preferences();

			return $pref['display_rank'];
		}

		return \Model_Settings::get_settings('display_rank');
	}

	/**
	 * Get the current skin for a given section, whether it's the user's
	 * preference or the system default.
	 *
	 * @api
	 * @param	string	the section
	 * @return	string
	 */
	public static function get_skin($section)
	{
		if (\Sentry::check())
		{
			$pref = \Model_User::find(\Sentry::user()->id)->get_user_preferences();

			return $pref['skin_'.$section];
		}

		return \Model_Settings::get_settings('skin_'.$section);
	}

	/**
	 * Checks to see if the system is installed.
	 *
	 * If the system is installed, we'll cache the result so that subsequent 
	 * checks will be a lot faster. In the event the user is in the setup module, 
	 * the cache will be wiped out to avoid throwing some nasty exceptions.
	 *
	 * <code>
	 * if (Utility::installed())
	 * {
	 * 		// do something
	 * }
	 * </code>
	 *
	 * @api
	 * @return	bool	is the system installed?
	 */
	public static function installed()
	{
		// get the request object
		$request = \Request::main();

		// make sure the database config file is there first
		if ( ! file_exists(APPPATH.'config/'.\Fuel::$env.'/db.php'))
		{
			// make sure we take in to account the controllers this needs to ignore
			if (($request->directory != 'setup'))
			{
				\Response::redirect('setup/main/config');
			}
		}
		else
		{
			// wipe out the system install cache if we're in the setup module
			if ($request->directory == 'setup')
			{
				\Cache::delete('nova_system_installed');
			}

			try
			{
				/**
				 * Since we only ever cache the install status when the system is
				 * actually installed, we can just assume here that if an
				 * exception isn't thrown that the system is installed.
				 */
				$status = \Cache::get('nova_system_installed');
				
				return true;
			}
			catch (\CacheNotFoundException $e) 
			{
				/**
				 * Just because we didn't find the cached install status doesn't
				 * mean the system isn't installed. Check it again and cache the
				 * result only in the event that the system is installed.
				 */
				try
				{
					$uid = \Model_System::get_uid();
					
					if ( ! empty($uid))
					{
						if ($request->directory != 'setup')
						{
							\Cache::set('nova_system_installed', 1);
						}

						return true;
					}
					
					return false;
				}
				catch (\Fuel\Core\Database_Exception $e)
				{
					return false;
				}
				catch (Exception $e)
				{
					return false;
				}
			}
		}
	}

	public static function setup_email()
	{
		# code...
	}
}
