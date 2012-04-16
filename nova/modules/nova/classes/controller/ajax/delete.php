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

class Controller_Ajax_Delete extends \Controller
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
		\Lang::load('nova::action', 'action');
		\Lang::load('nova::short', 'short');
		\Lang::load('nova::status', 'status');
	}
	
	public function after($response)
	{
		parent::after($response);
		
		// return the response object
		return $this->response;
	}

	public function action_field($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.delete'))
		{
			// get the field
			$field = \Model_Form_Field::find($id);

			if ($field !== null)
			{
				$data = array(
					'name' => $field->label,
					'id' => $field->id,
				);

				echo \View::forge(\Location::file('delete/field', 'default', 'ajax'), $data);
			}
		}
	}
}
