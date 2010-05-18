<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Location Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Location
{
	/**
	 * Looks for the location of different types of images throughout the system
	 *
	 * @param	string	the image to find
	 * @param	string	the skin to look in
	 * @param	string	the section to look in
	 * @param	string	the type of image (image, asset, rank)
	 * @return			path to the image relative to index.php
	 */
	public static function image($image = '', $skin = '', $section = '', $type = '')
	{
		switch ($type)
		{
			case 'image':
				// exclude these modules
				$exclude = array('install', 'update', 'upgrade');
				
				// start setting up where we're gonna search
				$locations = array(
					APPFOLDER => APPPATH,
				);
				
				// flip the modules array, which we need to do to make sure things are checked in the right order
				$modules = array_reverse(Kohana::modules());
				
				// go through the modules and figure out what should and shouldn't be included
				foreach ($modules as $m)
				{
					$mod = str_replace(MODPATH, '', $m);
					
					if (!in_array($mod, $exclude))
					{
						$loc = MODFOLDER.'/'.$mod;
						$locations[$loc] = $m;
					}
				}
				
				// set the up the path array
				$path = array(
					'head' => '',
					'skin' => '',
					'section' => $section,
					'type' => 'images',
					'image' => $image
				);
				
				// go through the locations and try to find the image
				foreach ($locations as $key => $l)
				{
					switch ($key)
					{
						case 'application':
							if (is_file($l.'views/'.$skin.'/'.$section.'/images/'.$image))
							{
								$path['head'] = APPFOLDER.'/views';
								$path['skin'] = $skin;
								
								return implode('/', $path);
							}
							break;
							
						default:
							if (is_file($l.'/views/'.$section.'/images/'.$image))
							{
								unset($path['skin']);
								$path['head'] = $key.'/views';
								
								return implode('/', $path);
							}
					}
				}
				
				break;
				
			case 'asset':
				// exclude these modules
				$exclude = array('install', 'update', 'upgrade');
				
				// start setting up where we're gonna search
				$locations = array(
					APPFOLDER => APPPATH,
				);
				
				// flip the modules array, which we need to do to make sure things are checked in the right order
				$modules = array_reverse(Kohana::modules());
				
				// go through the modules and figure out what should and shouldn't be included
				foreach ($modules as $m)
				{
					$mod = str_replace(MODPATH, '', $m);
					
					if (!in_array($mod, $exclude))
					{
						$loc = MODFOLDER.'/'.$mod;
						$locations[$loc] = $m;
					}
				}
				
				// set the up the path array
				$path = array(
					'head' => '',
					'image' => $image
				);
				
				// go through the locations and try to find the image
				foreach ($locations as $key => $l)
				{
					if (is_file($l.'/assets/images/'.$image))
					{
						unset($path['skin']);
						$path['head'] = $key.'/assets/images';
						
						return implode('/', $path);
					}
				}
				
				return FALSE;
				
				break;
				
			case 'rank':
				return APPFOLDER.'/assets/common/'.Kohana::config('nova.genre').'/ranks/'.$section.'/'.$image;
				break;
		}
	}
	
	/**
	 * Looks for the location of the view file throughout the system
	 *
	 * @param	string	the view file
	 * @param	string	the skin to search in
	 * @param	string	the section to search in
	 * @param	string	the type of view file (pages, js, ajax)
	 * @param	string	the extension of the view file (default: .php)
	 * @return			path to the view file relative to index.php
	 */
	public static function view($view = '', $skin = '', $section = '', $type = '', $ext = EXT)
	{
		// exclude these modules
		$exclude = array();
		
		// start setting up where we're gonna search
		$locations = array(
			APPFOLDER => APPPATH,
		);
		
		// flip the modules array, which we need to do to make sure things are checked in the right order
		$modules = array_reverse(Kohana::modules());
		
		// go through the modules and figure out what should and shouldn't be included
		foreach ($modules as $m)
		{
			$mod = str_replace(MODPATH, '', $m);
			
			if (!in_array($mod, $exclude))
			{
				$loc = MODFOLDER.'/'.$mod;
				$locations[$loc] = $m;
			}
		}
		
		// set the up the path array
		$path = array(
			'skin' => '',
			'section' => $section,
			'type' => $type,
			'view' => $view
		);
		
		// go through the locations and try to find the image
		foreach ($locations as $key => $l)
		{
			switch ($key)
			{
				case 'application':
					if (is_file($l.'views/'.$skin.'/'.$section.'/'.$type.'/'.$view.$ext))
					{
						$path['view'] = $view;
						
						return implode('/', $path);
					}
					break;
					
				default:
					if (is_file($l.'/views/'.$section.'/'.$type.'/'.$view.$ext))
					{
						unset($path['skin']);
						
						return implode('/', $path);
					}
			}
		}
		
		return FALSE;
	}
}

// End of file location.php
// Location: modules/nova/classes/nova/location.php