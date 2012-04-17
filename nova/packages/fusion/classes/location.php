<?php
/**
 * The Location class provides methods for searching through Nova's file structure
 * to find the correct view or image to pull. This is the heart and soul of seamless
 * substitution.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

/**
 * Invalid image type exception
 */
class NovaInvalidImageTypeException extends \FuelException {}

class Location
{	
	/**
	 * Searches to find where to pull the specified file from. If the file exists
	 * in the skin, it'll use that that one and stop searching. If the file exists
	 * in the override module (app/modules/override), it'll use that and stop searching.
	 * Otherwise, it'll use whatever's found in the nova module (core/modules/nova).
	 *
	 * <code>
	 * echo Location::file('main', $this->skin, 'templates');
	 * echo Location::file('main', $this->skin, 'layouts');
	 * echo Location::file('footer', $this->skin, 'partials');
	 * echo Location::file('main/index', $this->skin, 'pages');
	 * echo Location::file('personnel/character_js', $this->skin, 'js');
	 * </code>
	 *
	 * @api
	 * @param	string	the file
	 * @param	string	the current skin
	 * @param	string	the type of file (structure, template, partial, pages, js)
	 * @param	string	the module to fall back to
	 * @return	string	path to the file
	 */
	public static function file($file, $skin, $type, $module = 'nova')
	{
		if (is_file(APPPATH."views/{$skin}/components/{$type}/{$file}.php"))
		{
			return "{$skin}/components/{$type}/{$file}";
		}
		elseif (is_file(APPPATH."modules/override/views/components/{$type}/{$file}.php"))
		{
			return "override::components/{$type}/{$file}";
		}
		
		return $module."::components/{$type}/{$file}";
	}
	
	/**
	 * Finds and returns the path to an asset image. Asset images are not part of 
	 * seamless substitution since they're stored entirely outside of the Nova core.
	 *
	 * <code>
	 * Location::asset('image.png');
	 * // will return <img src="http://{yoursite}/app/assets/images/image.png" alt="image.png">
	 *
	 * Location::asset('characters/john-smith.jpg', 'urlpath');
	 * // will return http://{yoursite}/app/assets/images/characters/john-smith.jpg
	 *
	 * Location::asset('missions/mission01.png', 'abspath');
	 * // will return public_html/app/assets/images/missions/mission01.png
	 * </code>
	 *
	 * @api
	 * @param	string	the name and extension of the image
	 * @param	string	what to return (image, path, abspath, urlpath)
	 * @param	array 	an array of attributes to be used on the image
	 * @return	string	the path to the image
	 */
	public static function asset($image, $return = 'image', $attr = array())
	{
		// find the path to the image
		$path = Location::_find_image('asset', $image);
		
		if ($return == 'image')
		{
			return \Html::img(\Uri::base(false).$path, $attr);
		}
		
		if ($return == 'urlpath')
		{
			return \Uri::base(false).$path;
		}
		
		if ($return == 'abspath')
		{
			return APPPATH.$path;
		}
		
		return $path;
	}
	
	/**
	 * Finds and returns the path to an image. Nova will first look inside the
	 * current skin to find the image. If the image is found, it'll use that
	 * and stop looking, otherwise it'll move on to the override module and
	 * check there. Again, if the image is found, it'll use that and stop looking,
	 * otherwise it'll finally look in the nova module and use that image.
	 *
	 * <code>
	 * Location::image('feed.png', $this->skin, 'main');
	 * </code>
	 *
	 * @api
	 * @param	string	the name of the directory the rank set is stored in
	 * @param	string	the name of the image (usually from the database)
	 * @param	string	the extension of the rank set (usually from the database)
	 * @param	string	what to return (image, path, abspath, urlpath)
	 * @param	array 	an array of attributes to be used on the image
	 * @return	string	the path to the image
	 */
	public static function image($image, $skin, $section, $return = 'image', $attr = array())
	{
		// find the path to the image
		$path = static::_find_image('image', $image, $skin, $section);
		
		if ($return == 'image')
		{
			return \Html::img(\Uri::base(false).$path, $attr);
		}
		
		if ($return == 'urlpath')
		{
			return \Uri::base(false).$path;
		}
		
		if ($return == 'abspath')
		{
			return APPPATH.$path;
		}
		
		return $path;
	}
	
	/**
	 * Finds and returns the path to a rank image (app/assets/common/{GENRE}/ranks).
	 * Rank images are not part of seamless substitution since they're stored
	 * entirely outside of the Nova core.
	 *
	 * <code>
	 * Location::rank('default', 'r-06', '.png');
	 * // extension is its own parameter since the rank catalog stores that information
	 * </code>
	 *
	 * @api
	 * @param	string	the name of the directory the rank set is stored in
	 * @param	string	the name of the image (usually from the database)
	 * @param	string	the extension of the rank set (usually from the database)
	 * @param	string	what to return (image, path, abspath, urlpath)
	 * @param	array 	an array of attributes to be used on the image
	 * @return	string	the path to the image
	 */
	public static function rank($set, $image, $ext, $return = 'image', $attr = array())
	{
		// find the path to the image
		$path = Location::_find_image('rank', $set, $image.$ext);
		
		if ($return == 'image')
		{
			return \Html::img(\Uri::base(false).$path, $attr);
		}
		
		if ($return == 'urlpath')
		{
			return \Uri::base(false).$path;
		}
		
		if ($return == 'abspath')
		{
			return APPPATH.$path;
		}
		
		return $path;
	}
	
	/**
	 * Executes the search and return of images from the file system. Alias
	 * methods exist to interact with this since it uses dynamic arguments to
	 * make the API a little cleaner.
	 *
	 * @internal
	 * @param	mixed	a dynamic list of parameters
	 * @return	string	the path to the image
	 * @throws	NovaImageNotFoundException
	 */
	protected static function _find_image()
	{
		// get the complete list of arguments
		$args = func_get_args();
		
		// the first one needs to always be the type
		$type = $args[0];
		
		switch ($type)
		{
			case 'asset':
				return "app/assets/images/{$args[1]}";
			break;
			
			case 'image':
				if (is_file(APPPATH."views/{$args[2]}/design/images/{$args[1]}"))
				{
					return "app/views/{$skin}/design/images/{$args[1]}";
				}
				elseif (is_file(APPPATH."modules/override/views/design/images/{$args[1]}"))
				{
					return "app/modules/override/views/design/images/{$args[1]}";
				}
				
				return "nova/modules/nova/views/design/images/{$args[1]}";
			break;
			
			case 'rank':
				return "app/assets/common/".\Config::get('nova.genre')."/ranks/{$args[1]}/{$args[2]}";
			break;
			
			default:
				throw new NovaInvalidImageTypeException(__('Invalid image type provided. Available options are asset, image, and rank.'));
			break;
		}
	}
}
