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

class Controller_Base_Ajax extends \Controller
{
	public function before()
	{
		parent::before();

		// manually add the nova module to the paths
		\Finder::instance()->add_path(\Fuel::add_module('nova'));
		
		// go out and load then merge the nova config files
		\Config::load('nova', true, false, true);

		// load the language files
		\Lang::load('app');
		\Lang::load('nova::base');
		\Lang::load('nova::event', 'event');
		\Lang::load('nova::email', 'email');
		\Lang::load('nova::error', 'error');
		\Lang::load('nova::action', 'action');
		\Lang::load('nova::short', 'short');
		\Lang::load('nova::status', 'status');
		\Lang::load('nova::sitecontent', 'sitecontent');
	}
	
	public function after($response)
	{
		parent::after($response);
		
		// return the response object
		return $this->response;
	}
}
