<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * URL Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_URL extends Kohana_URL
{
	/**
	 * Link to something if the condition is TRUE
	 *
	 * @param			the condition
	 * @param	string	the URI to link to
	 * @param	string	the text of the link
	 * @param	string	additional attributes
	 * @return			the anchor output from html::anchor
	 */
	public static function link_to_if($condition, $uri = '', $title = '', $attributes = '')
	{
		if ($condition)
		{
			return html::anchor($uri, $title, $attributes);
		}
		
		return FALSE;
	}
	
	/**
	 * Link to something if the condition is FALSE
	 *
	 * @param			the condition
	 * @param	string	the URI to link to
	 * @param	string	the text of the link
	 * @param	string	additional attributes
	 * @return			the anchor output from html::anchor
	 */
	public static function link_to_unless($condition, $uri = '', $title = '', $attributes = '')
	{
		if (!$condition)
		{
			return html::anchor($uri, $title, $attributes);
		}

		return FALSE;
	}
}

// End of file url.php
// Location: modules/nova/classes/nova/url.php