<?php
/**
 * Nova's ajax controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Ajax_Get extends Controller_Base_Ajax
{
	public function action_content_load()
	{
		// get the content key
		$key = \Input::get('key');

		// load and return the content from the database
		echo \Model_SiteContent::get_content($key);
	}
}
