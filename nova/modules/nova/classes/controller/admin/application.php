<?php
/**
 * Nova's application admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Application extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	public function action_index()
	{
		$this->_view = 'admin/arc/index';

		// get the active reviews
		$this->_data->reviews = \Model_Application::find_items();

		// set up the images
		$this->_data->images = array(
			'rules' => \Location::image($this->images['rules'], $this->skin, 'admin'),
		);

		return;
	}

	public function action_review($id)
	{
		return;
	}

	public function action_rules($id = false)
	{
		\Sentry::allowed('character.create', true);

		$this->_view = 'admin/arc/rules';
		$this->_js_view = 'admin/arc/rules_js';

		if (is_numeric($id))
		{
			// change the view
			$this->_view = 'admin/arc/rules_action';

			// set the action
			$this->_data->action = ($id == 0) ? 'create' : 'update';

			// get the rule record
			$rule = $this->_data->rule = \Model_Application_Rule::find($id);

			// pass data to the JS view
			$this->_js_data->type = ($rule) ? $rule->type : false;
		}
		else
		{
			// pull all the rules
			$this->_data->rules = \Model_Application_Rule::get_items(false);
		}

		return;
	}
}
