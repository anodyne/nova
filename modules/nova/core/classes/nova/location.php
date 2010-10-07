<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Location class provides methods for searching through Nova's file structure to find the correct
 * view or image to pull. This is the heart and soul of seamless substitution.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Location {
	
	/**
	 * Looks for the location of the image file throughout the system. The first place this will look is in the
	 * current skin. If the image isn't found there, it moves through the modules. Finally, if it can't be
	 * found in the modules, it checks the nova module where it should find the image in question.
	 *
	 *     echo Location::image('feed.png', 'default', 'main', 'image');
	 *
	 * @param	string	the image to find
	 * @param	string	the skin to look in
	 * @param	string	the section to look in
	 * @param	string	the type of image (image, asset, rank)
	 * @return	string	path to the image relative to index.php
	 */
	public static function image($image, $skin, $section, $type = 'image')
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
					
					if ( ! in_array($mod, $exclude))
					{
						$loc = MODFOLDER.'/'.$mod;
						$loc = (substr($loc, -1, 1) == "\\") ? substr_replace($loc, '', -1, 1) : $loc;
						$loc = str_replace('\\', '/', $loc); // fixes an issue on windows machines
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
						break;
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
					
					if ( ! in_array($mod, $exclude))
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
	 * Looks for the location of the view file throughout the system. The first place this will look is in the
	 * current skin. If the view file isn't found there, it moves through the modules. Finally, if it can't be
	 * found in the modules, it checks the nova module where it should find the file in question.
	 *
	 *     echo Location::view('main_index', 'default', 'main', 'pages');
	 *     echo Location::view('main_index_js', 'default', 'main', 'js');
	 *
	 * @param	string	the view file
	 * @param	string	the skin to search in
	 * @param	string	the section to search in
	 * @param	string	the type of view file (pages, js, ajax)
	 * @param	string	the extension of the view file (default: .php)
	 * @return	string	path to the view file relative to index.php
	 */
	public static function view($view, $skin, $section, $type = 'pages', $ext = EXT)
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
			
			if ( ! in_array($mod, $exclude))
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
				break;
			}
		}
		
		return FALSE;
	}
} // End Location