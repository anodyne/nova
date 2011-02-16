<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Location class provides methods for searching through Nova's file structure
 * to find the correct view or image to pull. This is the heart and soul of seamless
 * substitution.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Location {
	
	/**
	 * Searches to find where to pull the file from. If the file exists in the
	 * skin, it'll use that, otherwise, it'll use what's found in the common
	 * directory.
	 *
	 *     echo Location::file('main', 'default', 'templates');
	 *     echo Location::file('main', 'default', 'layouts');
	 *     echo Location::file('footer', 'default', 'partials');
	 *
	 * @access	public
	 * @param	string	the name of the layout
	 * @param	string	the name of the current skin
	 * @return	string	path to the layout file
	 */
	public static function file($file, $skin, $type)
	{
		if (is_file(APPPATH.'views/'.$skin.'/components/'.$type.'/'.$file.EXT))
		{
			return $skin.'/components/'.$type.'/'.$file;
		}
		
		return '_common/'.$type.'/'.$file;
	}
	
	/**
	 * Looks for the location of an image in the system. The first place this
	 * will look is in the current skin then in the override extension. After
	 * that, it'll make its way through the other extensions and modules before
	 * finally checking in the core nova module where it should find the image
	 * in question.
	 *
	 *     echo Location::image('feed.png', 'default', 'main', 'image');
	 *
	 * @access	public
	 * @uses	Kohana::config
	 * @param	string	the image to find
	 * @param	string	the skin to look in
	 * @param	string	the section to look in
	 * @param	string	the type of image (image, asset, rank)
	 * @return	string	path to the image relative to index.php
	 */
	public static function image($image, $skin, $section, $type = 'image')
	{
		$locations = self::_setup_modules(array('install', 'update', 'upgrade'))
		
		switch ($type)
		{
			case 'image':
				// set up the path array
				$path = array(
					'head' => '',
					'skin' => '',
					'section' => $section,
					'type' => 'images',
					'image' => $image
				);
				
				foreach ($locations as $key => $l)
				{
					switch ($key)
					{
						case APPFOLDER:
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
				// set the up the path array
				$path = array(
					'head' => '',
					'image' => $image
				);
				
				foreach ($locations as $key => $l)
				{
					if (is_file($l.'/assets/images/'.$image))
					{
						unset($path['skin']);
						$path['head'] = $key.'/assets/images';
						
						return implode('/', $path);
					}
				}
				
				return false;
				
			break;
				
			case 'rank':
				return APPFOLDER.'/assets/common/'.Kohana::config('nova.genre').'/ranks/'.$section.'/'.$image;
			break;
		}
		
		return false;
	}
	
	/**
	 * Looks for the location of a view file in the system. The first place this
	 * will look is in the current skin then in the override extension. After
	 * that, it'll make its way through the other extensions and modules before
	 * finally checking in the core nova module where it should find the file
	 * in question.
	 *
	 *     echo Location::view('main_index', 'default', 'main', 'pages');
	 *     echo Location::view('main_index_js', 'default', 'main', 'js');
	 *
	 * @access	public
	 * @param	string	the view file
	 * @param	string	the skin to search in
	 * @param	string	the section to search in
	 * @param	string	the type of view file (pages, js, ajax)
	 * @param	string	the extension of the view file (default: .php)
	 * @return	string	path to the view file relative to the views directory
	 */
	public static function view($view, $skin, $section, $type = 'pages', $ext = EXT)
	{
		$locations = self::_setup_modules();
		
		// set the up the path array
		$path = array(
			'skin' => '',
			'section' => $section,
			'type' => $type,
			'view' => $view
		);
		
		foreach ($locations as $key => $l)
		{
			switch ($key)
			{
				case APPFOLDER:
					if (is_file($l.'views/'.$skin.'/'.$section.'/'.$type.'/'.$view.$ext))
					{
						// add the skin to the path
						$path['skin'] = $skin;
						
						return implode('/', $path);
					}
				break;
					
				default:
					if (is_file($l.'views/'.$section.'/'.$type.'/'.$view.$ext))
					{
						// we don't need the skin key any more
						unset($path['skin']);
						
						return implode('/', $path);
					}
				break;
			}
		}
		
		return false;
	}
	
	/**
	 * Setup the array of modules to be used by seamless substitution.
	 *
	 * @access	protected
	 * @uses	Kohana::modules
	 * @param	array 	an array of items to exclude
	 * @return	array 	an array of modules
	 */
	protected static function _setup_modules($exclude = array())
	{
		// start setting up where we're gonna search
		$locations = array(APPFOLDER => APPPATH);
		
		// get all the modules
		$modules = Kohana::modules();
		
		foreach ($modules as $m)
		{
			// figure out if it's a module or an extension
			$modtype = (strpos($m, MODPATH) !== false) ? 'module' : 'extension';
			
			// make sure we're replacing the right thing based on what type of "thing" it is
			$mod = ($modtype == 'module') ? str_replace(MODPATH, '', $m) : str_replace(EXTPATH, '', $m);
			
			if ( ! in_array($mod, $exclude))
			{
				$loc = ($modtype == 'module') ? MODFOLDER.'/'.$mod : EXTFOLDER.'/'.$mod;
				$locations[$loc] = $m;
			}
		}
		
		return $locations;
	}
}
