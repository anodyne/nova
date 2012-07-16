<?php
/**
 * The QuickInstall class provides methods for installing modules, ranks, skins,
 * and widgets into Nova's catalogs.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class QuickInstall
{
	/**
	 * Install a module or loop through all the modules and install whatever
	 * isn't already installed.
	 *
	 * @api
	 * @param	string	the directory of the module to install or NULL for all modules
	 * @return	void
	 */
	public static function module($location = null)
	{
		if ($location === null)
		{
			// get a listing of all modules
			$dir = \File::read_dir(APPPATH.'modules');

			// get all the installed modules
			$modules = \Model_Catalog_Module::get_all_items();

			if (count($modules) > 0)
			{
				// start by removing anything that's already installed
				foreach ($modules as $module)
				{
					if (array_key_exists($module->location.DS, $dir))
					{
						unset($dir[$module->location.DS]);
					}
				}
			}
				
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				try
				{
					// get the list of files for the module's migrations
					$moddir = \File::read_dir(APPPATH.'modules/'.$key.'migrations');

					// if we have migration files, do the module install
					if (count($moddir) > 0)
					{
						// clean the key
						$clean_key = str_replace(DS, '', $key);

						// run the migration
						\Migrate::latest($clean_key, 'module');
					}
				}
				catch (\Fuel\Core\InvalidPathException $e)
				{
					// we have no migrations to run for this module
				}

				// assign our path to a variable
				$file = APPPATH.'modules/'.$key.'module.json';
				
				// make sure the QI file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);
					
					// create the item
					\Model_Catalog_Module::create_item($data);
				}
			}
		}
		else
		{
			try
			{
				// get the list of files for the module's migrations
				$dir = \File::read_dir(APPPATH.'modules/'.$location.'/migrations');

				// if we have migration files, do the module install
				if (count($dir) > 0)
				{
					\Migrate::latest($location, 'module');
				}
			}
			catch (\Fuel\Core\InvalidPathException $e)
			{
				// we have no migrations to run for this module
			}

			// assign our path to a variable
			$file = APPPATH.'modules/'.$location.'/module.json';
			
			// make sure the QI file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// create the item
				\Model_Catalog_Module::create_item($data);
			}
		}
	}
	
	/**
	 * Install a rank set or loop through all the ranks and install whatever
	 * isn't already installed.
	 *
	 * @api
	 * @param	string	the directory of the rank to install or NULL for all ranks
	 * @return	void
	 */
	public static function rank($location = null)
	{
		if ($location === null)
		{
			// get the directory listing for the genre
			$dir = \File::read_dir(APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/');

			// get all the rank sets locations
			$ranks = \Model_Catalog_Rank::get_all_items();

			if (count($ranks) > 0)
			{
				// start by removing anything that's already installed
				foreach ($ranks as $rank)
				{
					if (array_key_exists($rank->location.DS, $dir))
					{
						unset($dir[$rank->location.DS]);
					}
				}
			}
				
			// loop through the directories now
			foreach ($dir as $key => $value)
			{
				// assign our path to a variable
				$file = APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/'.$key.'rank.json';

				// make sure the file exists first
				if (file_exists($file))
				{
					// get the contents and decode the JSON
					$content = file_get_contents($file);
					$data = json_decode($content);

					// create the item
					\Model_Catalog_Rank::create_item($data);
				}
			}
		}
		else
		{
			// assign our path to a variable
			$file = APPPATH.'assets/common/'.\Config::get('nova.genre').'/ranks/'.$location.'/rank.json';
			
			// make sure the file exists first
			if (file_exists($file))
			{
				// get the contents and decode the JSON
				$content = file_get_contents($file);
				$data = json_decode($content);
				
				// create the item
				\Model_Catalog_Rank::create_item($data);
			}
		}
	}
	
	public static function skin($location = null)
	{
		return true;
		/*
		if ($location === null)
		{
			// get the listing of the directory
			$dir = self::directory_list(APPPATH.'views/');
			
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
		*/
	}
	
	public static function widget($location = null)
	{
		return true;
		/*
		if ($location === null)
		{
			// get the directory listing
			$dir = self::directory_list(MODPATH.'app/views/components/widgets/');
			
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
		*/
	}
}
