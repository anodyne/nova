<?php
/**
 * The QuickInstall class provides methods for installing modules, ranks, skins, and
 * widgets into Nova's catalogs.
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
	public static function module($location = null)
	{
		return true;
	}
	
	public static function rank($location = null)
	{
		return true;
		/*
		if ($location === null)
		{
			// get the directory listing for the genre
			$dir = self::directory_list(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/');
			
			// get all the rank sets locations
			$ranks = Model_Catalog_Rank::get_all_items();
			
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
		*/
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
