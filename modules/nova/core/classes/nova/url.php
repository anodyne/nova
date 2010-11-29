<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The URL class extends Kohana's native URL class to provide additional methods for showing links
 * based on whether a condition is true or false.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_URL extends Kohana_URL {
	
	/**
	 * Creates an HTML anchor tag to a page if the condition is true.
	 *
	 *     echo html:link_to_if($foo == 'y', 'page/foo', 'Foo');
	 *
	 * @uses	Html::anchor
	 * @param	mixed	the condition
	 * @param	string	the URI to link to
	 * @param	string	the text of the link
	 * @param	array	additional attributes
	 * @return	mixed	the anchor or false if the condition is false
	 */
	public static function link_to_if($condition, $uri, $title, $attributes = array())
	{
		if ($condition)
		{
			return html::anchor($uri, $title, $attributes);
		}
		
		return false;
	}
	
	/**
	 * Creates an HTML anchor tag to a page if the condition is false.
	 *
	 *     echo html::link_to_unless($foo == 'y', 'page/foo', 'Foo');
	 *
	 * @uses	Html::anchor
	 * @param	mixed	the condition
	 * @param	string	the URI to link to
	 * @param	string	the text of the link
	 * @param	array	additional attributes
	 * @return	mixed	the anchor or false if the condition is true
	 */
	public static function link_to_unless($condition, $uri, $title, $attributes = array())
	{
		if ( ! $condition)
		{
			return html::anchor($uri, $title, $attributes);
		}

		return false;
	}
}

// End of file url.php
// Location: modules/nova/classes/nova/url.php