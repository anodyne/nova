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

class Controller_Ajax_Get extends \Controller
{
	public function before()
	{
		parent::before();

		// manually add the nova module to the paths
		\Finder::instance()->add_path(\Fuel::add_module('nova'));
		
		// go out and load then merge the nova config files
		\Config::load('nova', true, false, true);
	}
	
	public function after($response)
	{
		parent::after($response);
		
		// return the response object
		return $this->response;
	}

	public function action_content_load()
	{
		// get the content key
		$key = \Input::get('key');

		// load and return the content from the database
		echo \Model_SiteContent::get_content($key);
	}
}
