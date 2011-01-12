<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter URL Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/html_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Is Working URL
 *
 * Checks to make sure the URL supplied is legitimate
 *
 * @access	public
 * @param	string
 * @return	boolean
 */	
if ( ! function_exists('is_working_url'))
{
	function is_working_url($url = '')
	{
		$url = prep_url($url);
		
		$header_arr = @get_headers($url);
		
		if (is_array($header_arr) && preg_grep('/HTTP\/\d+\.\d+ 200 OK/', $header_arr))
		{
			return TRUE;
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * Link To If
 *
 * Display a link to something if the condition is TRUE
 * (Credit to symfony for the idea for this helper)
 *
 * @access	public
 * @param	string
 * @param	string	(the URL)
 * @param	string	(the link title)
 * @param	mixed	(any attributes)
 * @return	string/boolean
 */
if ( ! function_exists('link_to_if'))
{
	function link_to_if($condition, $uri = '', $title = '', $attributes = '')
	{
		if ($condition)
		{
			return anchor($uri, $title, $attributes);
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * Link To Unless
 *
 * Display a link to something if the condition is FALSE
 * (Credit to symfony for the idea for this helper)
 *
 * @access	public
 * @param	string
 * @param	string	(the URL)
 * @param	string	(the link title)
 * @param	mixed	(any attributes)
 * @return	string/boolean
 */
if ( ! function_exists('link_to_unless'))
{
	function link_to_unless($condition, $uri = '', $title = '', $attributes = '')
	{
		if (!$condition)
		{
			return anchor($uri, $title, $attributes);
		}

		return FALSE;
	}
}
