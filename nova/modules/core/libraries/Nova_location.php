<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Location library that finds the right path the use for pulling back views and images.
 * This is the central component to seamless substitution and stepping through the
 * locations seamless substitution is set up to search through. In most cases,
 * seamless substitution will check the current skin, then the _base_override directory
 * followed finally by the core module's _base directory until it finds what it's
 * been asked to find.
 *
 * @package		Nova
 * @category	Library
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_location {
	
	/**
	 * Finds and returns the content of an Ajax view file
	 *
	 * @access	public
	 * @param	string	the ajax view to find
	 * @param	string	the current skin
	 * @param	string	the section to search in
	 * @param	array 	the data to be passed to the ajax view
	 * @return	string	the full content of the ajax view
	 */
	public static function ajax($view, $skin, $section, $data = null)
	{
		$ci =& get_instance();
		
		if ($skin === null and $section === null)
		{
			$location = $view;
		}
		else
		{
			$obj = new stdClass;
			$obj->view = $view;
			$obj->sec = $section;
			
			if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/ajax/'.$view.'.php'))
			{
				$obj->skin = $skin;
			}
			elseif (is_file(APPPATH.'views/_base_override/'.$section.'/ajax/'.$view.'.php'))
			{
				$obj->skin = '_base_override';
			}
			else
			{
				$obj->skin = '_base';
			}
			
			$location = $obj->skin.'/'.$obj->sec.'/ajax/'.$obj->view;
		}
		
		if ($data !== null)
		{
			if ($obj->skin == '_base')
			{
				return $ci->nova->view($location, $data, true);
			}
			else
			{
				return $ci->load->view($location, $data, true);
			}
		}
		
		return $location;
	}
	
	/**
	 * Returns the path to an asset image
	 *
	 * @access	public
	 * @param	string	the directory in the assets folder to use
	 * @param	string	the image to grab
	 * @return	string	the path to the assets image
	 */
	public static function asset($location, $image)
	{
		return APPFOLDER.'/assets/'.$location.'/'.$image;
	}
	
	/**
	 * Finds and returns the path to the right combadge image
	 *
	 * @access	public
	 * @param	string	the image to find
	 * @param	string	the current skin
	 * @param	string 	the section to look in
	 * @return	string	the path to the combadge image
	 */
	public static function cb($img, $skin, $section)
	{
		if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/images/'.$img))
		{
			return APPFOLDER.'/views/'.$skin.'/'.$section.'/images/'.$img;
		}
		elseif (is_file(APPPATH.'assets/common/'.GENRE.'/images/'.$img))
		{
			return APPFOLDER.'/assets/common/'.GENRE.'/images/'.$img;
		}
		
		return MODFOLDER.'/core/views/_base/'.$section.'/images/'.$img;
	}
	
	/**
	 * Finds and returns the path to the right email view
	 *
	 * @access	public
	 * @param	string	the email view to find
	 * @param	string	the type of email to find (html, text)
	 * @return	string	the path to the email view
	 */
	public static function email($view, $type = 'html')
	{
		// get an instance of the CI super object
		$ci =& get_instance();
		
		// load the core
		$ci->load->module('core', 'nova', MODPATH);
		
		if (is_file(APPPATH.'views/_base_override/emails/'.$type.'/'.$view.'.php'))
		{
			return $ci->load->view('_base_override/emails/'.$type.'/'.$view, null, true);
		}
		
		return $ci->nova->view('_base/emails/'.$type.'/'.$view, null, true);
	}
	
	/**
	 * Finds and returns the path to the right version of an image
	 *
	 * @access	public
	 * @param	string	the image to find
	 * @param	string	the current skin
	 * @param	string	the section to search in
	 * @param	string	the module to look in for the final step
	 * @return	string	the path where the image was found
	 */
	public static function img($img, $skin, $section, $module = 'core')
	{
		$obj = new stdClass;
		$obj->img = $img;
		$obj->sec = $section;
		
		if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/images/'.$img))
		{
			$obj->skin = APPFOLDER.'/views/'.$skin;
		}
		elseif (is_file(APPPATH.'views/_base_override/'.$section.'/images/'.$img))
		{
			$obj->skin = APPFOLDER.'/views/_base_override';
		}
		else
		{
			$obj->skin = MODFOLDER.'/'.$module.'/views/_base';
		}
		
		return $obj->skin.'/'.$obj->sec.'/images/'.$obj->img;
	}
	
	/**
	 * Finds and generates a javascript view file using seamless substitution
	 *
	 * @access	public
	 * @param	string	the name of the js view file
	 * @param	string	the current skin
	 * @param	string	the section to pull from
	 * @param	array 	the data array for the view file
	 * @return	string	the complete output of the js view file
	 */
	public static function js($file, $skin, $section, $data = null)
	{
		$ci =& get_instance();
		
		$obj = new stdClass;
		$obj->file = $file;
		$obj->sec = $section;
		
		if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/js/'.$file.'.php'))
		{
			$obj->skin = $skin;
		}
		elseif (is_file(APPPATH.'views/_base_override/'.$section.'/js/'.$file.'.php'))
		{
			$obj->skin = '_base_override';
		}
		else
		{
			$obj->skin = '_base';
		}
		
		$location = $obj->skin.'/'.$obj->sec.'/js/'.$obj->file;
		
		if ($obj->skin == '_base')
		{
			return $ci->nova->view($location, $data, true);
		}
		
		return $ci->load->view($location, $data, true);
	}
	
	/**
	 * Returns the path to a rank image
	 *
	 * @access	public
	 * @param	string	the rank set to use
	 * @param	string	the rank image to use
	 * @param	string	the extensioin of the image
	 * @return	string	the path to the rank image
	 */
	public static function rank($set, $image, $ext)
	{
		return APPFOLDER.'/assets/common/'.GENRE.'/ranks/'.$set.'/'.$image.$ext;
	}
	
	/**
	 * Finds and generates a view file using seamless substitution.
	 *
	 * @access	public
	 * @param	string	the name of the view file
	 * @param	string	the current skin
	 * @param	string	the section to pull from
	 * @param	array 	the data array for the view file
	 * @param	string	the absolute path to the application folder
	 * @return	string	the complete output of the view file
	 */
	public static function view($view, $skin, $section, $data = null)
	{
		$ci =& get_instance();
		
		$obj = new stdClass;
		$obj->view = $view;
		$obj->sec = $section;
		$obj->skin = '_base';
		
		if ($skin === null and $section === null)
		{
			$location = $view;
		}
		else
		{
			if (is_file(APPPATH.'views/'.$skin.'/'.$section.'/pages/'.$view.'.php'))
			{
				$obj->skin = $skin;
			}
			elseif (is_file(APPPATH.'views/_base_override/'.$section.'/pages/'.$view.'.php'))
			{
				$obj->skin = '_base_override';
			}
			
			$location = $obj->skin.'/'.$obj->sec.'/pages/'.$obj->view;
		}
		
		$ci->event->fire(['location', 'view', 'data', $obj->sec, $obj->view], [
			'data' => &$data
		]);
		
		if ($data !== null)
		{
			if ($obj->skin == '_base')
			{
				$output = $ci->nova->view($location, $data, true);
				$ci->event->fire(['location', 'view', 'output', $obj->sec, $obj->view], [
					'data' => &$data,
					'output' => &$output
				]);
				return $output;
			}
			else
			{
				$output = $ci->load->view($location, $data, true);
				$ci->event->fire(['location', 'view', 'output', $obj->sec, $obj->view], [
					'data' => &$data,
					'output' => &$output
				]);
				return $output;
			}
		}
		
		return $location;
	}
}
