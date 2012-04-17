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
		\Sentry::allowed('form.read', true);

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
				'message' => lang('short.flash.success|form|action.updated', 1),
			);
		}

		// grab all the forms from the database
		$this->_data->forms = \Model_Form::find('all');

		// set up the images
		$this->_data->images = array(
			'action' => \Location::image($this->images['settings'], $this->skin, 'admin'),
		);

		return;
	}

	public function action_fields($key, $id = false)
	{
		\Sentry::allowed('form.edit', true);

		$this->_view = 'admin/form/fields';
		$this->_js_view = 'admin/form/fields_js';

		if (\Input::method() == 'POST')
		{
			// get the action
			$action = trim(\Security::xss_clean(\Input::post('action')));

			// get the ID from the POST
			$field_id = trim(\Security::xss_clean(\Input::post('id')));

			if (\Sentry::user()->has_access('form.delete') and $action == 'delete')
			{
				// get the field
				$field = \Model_Form_Field::find($field_id);

				// delete the field (with transactions)
				$field->delete(null, true);

				# TODO: need to figure out how to see if the delete was successful or not

				$this->_flash[] = array(
					'status' => 'success',
					'message' => lang('short.flash.success|field|action.deleted', 1),
				);
			}

			if (\Sentry::user()->has_access('form.edit') and $action == 'add')
			{
				// get an instance of the field object
				$item = \Model_Form_Field::forge();

				// get the POST
				$post = $_POST;

				// drop the items we don't need
				unset($post['action']);

				// loop through the POST and create the properties
				foreach ($post as $key => $value)
				{
					$item->{$key} = trim(\Security::xss_clean($value));
				}

				// save the record
				$record = $item->save();

				// figure out what flash message to show
				if ($record)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('short.flash.success|field|action.added', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('short.flash.failure|field|action.creation', 1),
					);
				}
			}

			if (\Sentry::user()->has_access('form.edit') and $action == 'update')
			{
				// get the field
				$item = \Model_Form_Field::find($id);

				// get the POST
				$post = $_POST;

				// drop the items we don't need
				unset($post['action']);
				unset($post['value-add-content']);

				// loop through the POST and create the properties
				foreach ($post as $key => $value)
				{
					$item->{$key} = trim(\Security::xss_clean($value));
				}

				// save the record
				$record = $item->save();

				// figure out what flash message to show
				if ($record)
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('short.flash.success|field|action.updated', 1),
					);
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('short.flash.failure|field|action.update', 1),
					);
				}
			}
		}

		// no ID, show all the fields
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

			// manually set the header, footer, and message
			$this->_headers['fields'] = lang('action.manage form fields', 2);
			$this->_titles['fields'] = lang('action.manage form fields', 2);
			$this->_messages['fields'] = lang('action.manage form fields', 2);
		}
		else
		{
			$this->_view = 'admin/form/fields_action';

			// get the forms
			$this->_data->forms = \Model_Form::get_forms();

			// get the sections
			$this->_data->sections = \Model_Form_Section::get_sections($key);

			// set the types
			$this->_data->types = array(
				'text' => lang('text_field', 2),
				'textarea' => lang('text_area', 2),
				'select' => lang('dropdown', 2),
			);

			// ID 0 means a new field, anything else edits an existing field
			if ($id == 0)
			{
				// get the field
				$this->_data->field = false;

				// set the action
				$this->_data->action = 'add';

				// manually set the header, footer, and message
				$this->_headers['fields'] = lang('action.create status.new form field', 2);
				$this->_titles['fields'] = lang('action.create status.new form field', 2);
				$this->_messages['fields'] = lang('action.create status.new form field', 2);
			}
			else
			{
				// get the field
				$this->_data->field = \Model_Form_Field::find($id);

				// if we don't have a field, redirect to the creation screen
				if ($this->_data->field === null)
				{
					$this->response->redirect('admin/form/fields/'.$key.'/0');
				}

				// get the field values
				$this->_data->values = \Model_Form_Value::get_values($id);

				// set the action
				$this->_data->action = 'update';

				// manually set the header, footer, and message
				$this->_headers['fields'] = lang('action.update form field', 2);
				$this->_titles['fields'] = lang('action.update form field', 2);
				$this->_messages['fields'] = lang('action.update form field', 2);
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
