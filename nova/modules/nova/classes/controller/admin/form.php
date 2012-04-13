<?php
/**
 * Nova's forms admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Form extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	public function action_index()
	{
		$this->_view = 'admin/form/index';
		$this->_js_view = 'admin/form/index_js';

		if (\Sentry::user()->has_access('form.edit') and \Input::method() == 'POST')
		{
			// get the id
			$id = trim(\Security::xss_clean($_POST['id']));

			// update the form
			\Model_Form::update_item($id, $_POST);

			# TODO: need to figure out how to see if the update was successful or not

			$this->_flash[] = array(
				'status' => 'success',
				'message' => __('short.flash_success', array('thing' => ucfirst(__('form')))),
			);
		}

		// grab all the forms from the database
		$this->_data->forms = \Model_Form::find('all');
		
		return;
	}

	public function action_fields($key, $id = false)
	{
		$this->_view = 'admin/form/fields';

		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;
			$this->_data->sections = false;
			$this->_data->fields = false;

			// get the form elements
			$tabs = \Model_Form_Tab::find_form_items($key);
			$sections = \Model_Form_Section::find_form_items($key);
			$fields = \Model_Form_Field::find_form_items($key);

			/**
			 * Tabs
			 */
			if (count($tabs) > 0)
			{
				foreach ($tabs as $tab)
				{
					$this->_data->tabs[] = $tab;
				}
			}

			/**
			 * Sections
			 */
			if (count($sections) > 0)
			{
				foreach ($sections as $section)
				{
					if (count($tabs) > 0)
					{
						$this->_data->sections[$section->tab_id][] = $section;
					}
					else
					{
						$this->_data->sections[] = $section;
					}
				}
			}

			/**
			 * Fields
			 */
			if (count($fields) > 0)
			{
				foreach ($fields as $field)
				{
					if (count($sections) > 0)
					{
						$this->_data->fields[$field->section_id][] = $field;
					}
					else
					{
						$this->_data->fields[] = $field;
					}
				}
			}
		}

		return;
	}

	public function action_sections($key)
	{
		# code...
	}

	public function action_tabs($key)
	{
		# code...
	}
}
