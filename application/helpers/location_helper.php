<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter Location Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		David VanScott
 */

// ------------------------------------------------------------------------

/**
 * View Location
 *
 * Determine if a view exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('view_location'))
{
	function view_location($view = '', $skin = 'default', $section = '', $app_loc = APPPATH)
	{
		$array = array();
		$array['view'] = $view;
		$array['sec'] = $section;
		
		if (is_file($app_loc . 'views/' . $skin . '/' . $section . '/pages/' . $view . '.php'))
		{
			$array['skin'] = $skin;
		}
		elseif (is_file($app_loc . 'views/_base_override/' . $section . '/pages/' . $view . '.php'))
		{
			$array['skin'] = '_base_override';
		}
		else
		{
			$array['skin'] = '_base';
		}
		
		$location = $array['skin'] . '/' . $array['sec'] . '/pages/' . $array['view'];
		
		return $location;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Image Location
 *
 * Determine if an image exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('img_location'))
{
	function img_location($img = '', $skin = 'default', $section = '', $app_loc = APPPATH, $app_folder = APPFOLDER)
	{
		$array = array();
		$array['img'] = $img;
		$array['sec'] = $section;
		
		if (is_file($app_loc . 'views/' . $skin . '/' . $section . '/images/' . $img))
		{
			$array['skin'] = $skin;
		}
		elseif (is_file($app_loc . 'views/_base_override/' . $section . '/images/' . $img . '.php'))
		{
			$array['skin'] = '_base_override';
		}
		else
		{
			$array['skin'] = '_base';
		}
		
		$image = $array['skin'] . '/' . $array['sec'] . '/images/' . $array['img'];
		
		return $app_folder . '/views/' . $image;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Combadge Location
 *
 * Determine if an image exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('cb_location'))
{
	function cb_location($img = '', $skin = 'default', $section = '', $app_loc = APPPATH, $app_folder = APPFOLDER)
	{
		if (is_file($app_loc . 'views/' . $skin . '/' . $section . '/images/' . $img))
		{
			return $app_folder .'/views/'. $skin .'/'. $section .'/images/'. $img;
		}
		elseif (is_file($app_loc .'assets/common/'. GENRE .'/images/'. $img))
		{
			return $app_folder . '/assets/common/'. GENRE .'/images/'. $img;
		}
		else
		{
			return $app_folder .'/views/_base/'. $section .'/images/'. $img;
		}
	}
}
	
// ------------------------------------------------------------------------

/**
 * JS Location
 *
 * Determine if a Javascript file exists in the current skin and if it doesn't,
 * check the system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('js_location'))
{
	function js_location($file = '', $skin = 'default', $section = '', $app_loc = APPPATH, $app_folder = APPFOLDER)
	{
		$array = array();
		$array['file'] = $file;
		$array['sec'] = $section;
		
		if (is_file($app_loc . 'views/' . $skin . '/' . $section . '/js/' . $file . '.php'))
		{
			$array['skin'] = $skin;
		}
		elseif (is_file($app_loc . 'views/_base_override/' . $section . '/js/' . $file . '.php'))
		{
			$array['skin'] = '_base_override';
		}
		else
		{
			$array['skin'] = '_base';
		}
		
		$location = $array['skin'] . '/' . $array['sec'] . '/js/' . $array['file'];
		
		return $location;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Assets Location
 *
 * Determine if a view exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('asset_location'))
{
	function asset_location($location = '', $image = '', $app_loc = APPFOLDER)
	{
		return $app_loc .'/assets/'. $location .'/'. $image;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Rank Location
 *
 * Determine if a view exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('rank_location'))
{
	function rank_location($rank_set = '', $image = '', $ext = '', $genre = GENRE, $app_loc = APPFOLDER)
	{
		if ($app_loc > '' && substr($app_loc, -1) != '/')
		{
			$app_loc = $app_loc .'/';
		}
		
		return $app_loc .'assets/common/'. $genre .'/ranks/'. $rank_set .'/'. $image . $ext;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Email Location
 *
 * Determine where to pull the email template from
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('email_location'))
{
	function email_location($view = '', $type = 'html', $app_loc = APPPATH)
	{
		if (is_file($app_loc . 'views/_base/emails/' . $type . '/' . $view . '.php'))
		{
			return '_base/emails/' . $type . '/' . $view;
		}
		
		return '_base/emails/text/' . $view;
	}
}
	
// ------------------------------------------------------------------------

/**
 * Ajax Location
 *
 * Determine if a view exists in the current skin and if it doesn't, use the
 * system global one instead
 *
 * @access	public
 * @param	string
 * @return	string
 */	
if ( ! function_exists('ajax_location'))
{
	function ajax_location($view = '', $skin = 'default', $section = '', $app_loc = APPPATH)
	{
		$array = array();
		$array['view'] = $view;
		$array['sec'] = $section;
		
		if (is_file($app_loc . 'views/' . $skin . '/' . $section . '/ajax/' . $view . '.php'))
		{
			$array['skin'] = $skin;
		}
		elseif (is_file($app_loc . 'views/_base_override/' . $section . '/ajax/' . $view . '.php'))
		{
			$array['skin'] = '_base_override';
		}
		else
		{
			$array['skin'] = '_base';
		}
		
		$location = $array['skin'] . '/' . $array['sec'] . '/ajax/' . $array['view'];
		
		return $location;
	}
}
	
// ------------------------------------------------------------------------
