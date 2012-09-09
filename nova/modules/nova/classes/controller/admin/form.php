<?php
/**
 * Nova's forms admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Form extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	/**
	 * Shows all of the dynamic forms available in the system. With the proper permissions,
	 * a user can also edit any of them from a dropdown menu.
	 */
	public function action_index()
	{
		\Sentry::allowed('form.read', true);

		$this->_view = 'admin/form/index';
		$this->_js_view = 'admin/form/index_js';

		if (\Sentry::user()->has_access('form.update') and \Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the id
				$id = \Security::xss_clean(\Input::post('id'));

				// update the form
				$entry = \Model_Form::update_item($id, \Input::post(), true);

				if (is_object($entry))
				{
					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|form|action.updated]]', 1),
					);

					\SystemEvent::add('user', '[[event.form.update|{{'.$entry->name.'}}]]');
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('[[short.flash.failure|form|action.update]]', 1),
					);
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
			}
		}

		// grab all the forms from the database
		$this->_data->forms = \Model_Form::find('all');

		// set up the images
		$this->_data->images = array(
			'action' => \Location::image($this->images['settings'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the fields associated with a specific form. In addition, if an ID is passed
	 * through the URI, that field can be edited, or new fields can be created.
	 */
	public function action_fields($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/fields';
		$this->_js_view = 'admin/form/fields_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$field_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->has_access('form.delete') and $action == 'delete')
				{
					// delete the field
					$item = \Model_Form_Field::delete_item($field_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|field|action.deleted]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|field|action.deletion]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'add')
				{
					// add the field
					$item = \Model_Form_Field::create_item(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|field|action.added]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|field|action.creation]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'update')
				{
					// update the field
					$item = \Model_Form_Field::update_item($field_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|field|action.updated]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|field|action.update]]', 1),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
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
			$this->_messages['fields'] = lang('sitecontent.message.fields_all');
		}
		else
		{
			$this->_view = 'admin/form/fields_action';

			// get the sections
			$this->_data->sections = \Model_Form_Section::get_sections($key);

			// set the types
			$this->_data->types = array(
				'text' => lang('text_field', 2),
				'textarea' => lang('text_area', 2),
				'select' => lang('dropdown', 2),
			);

			// set the roles
			$empty_role = array(0 => '');
			$this->_data->roles = array_merge($empty_role, \Model_Access_Role::get_roles());

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
				$this->_messages['fields'] = false;
			}
			else
			{
				// get the field
				$this->_data->field = \Model_Form_Field::find($id);

				// if we don't have a field, redirect to the creation screen
				if ($this->_data->field === null)
				{
					\Response::redirect('admin/form/fields/'.$key.'/0');
				}

				// if the field isn't part of this form, redirect them
				if ($this->_data->field->form_key != $key)
				{
					\Response::redirect('admin/form/fields/'.$this->_data->field->form_key.'/'.$id);
				}

				// get the field values
				$this->_data->values = \Model_Form_Value::get_values($id);

				// set the action
				$this->_data->action = 'update';

				// manually set the header, footer, and message
				$this->_headers['fields'] = lang('action.update form field', 2);
				$this->_titles['fields'] = lang('action.update form field', 2);
				$this->_messages['fields'] = lang('sitecontent.message.fields_edit');
			}
		}

		// set up the images
		$this->_data->images = array(
			'sections' => \Location::image($this->images['sections'], $this->skin, 'admin'),
			'tabs' => \Location::image($this->images['tabs'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the sections associated with a specific form. In addition, if an ID is passed
	 * through the URI, that section can be edited, or new sections can be created.
	 *
	 * Ideally, we would do the field update for a deleted section in the observer, but
	 * we can't pass arguments to the observer (the new section ID), so we have to do it
	 * in here.
	 */
	public function action_sections($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/sections';
		$this->_js_view = 'admin/form/sections_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$section_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->has_access('form.delete') and $action == 'delete')
				{
					// get the new section ID
					$new_section = \Security::xss_clean(\Input::post('new_section_id'));

					// get the section we're deleting
					$section = \Model_Form_Section::find($section_id);

					// loop through the fields and update them
					foreach ($section->fields as $f)
					{
						// update the section ID
						$f->section_id = $new_section;

						// save the record
						$f->save();
					}

					// delete the section
					$item = \Model_Form_Section::delete_item($section_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|section|action.deleted]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|section|action.deletion]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'add')
				{
					// add the section
					$item = \Model_Form_Section::create_item(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|section|action.added]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|section|action.creation]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'update')
				{
					// update the section
					$item = \Model_Form_Section::update_item($section_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|section|action.updated]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|section|action.update]]', 1),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
			}
		}

		// no ID, show all the sections
		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;
			$this->_data->sections = false;

			// get the form elements
			$tabs = \Model_Form_Tab::find_form_items($key);
			$sections = \Model_Form_Section::find_form_items($key);

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

			// manually set the header, footer, and message
			$this->_headers['sections'] = lang('action.manage form sections', 2);
			$this->_titles['sections'] = lang('action.manage form sections', 2);
			$this->_messages['sections'] = lang('sitecontent.message.sections_all');
		}
		else
		{
			$this->_view = 'admin/form/sections_action';

			// get the forms
			$this->_data->forms = \Model_Form::get_forms();

			// get the tabs
			$this->_data->tabs = \Model_Form_Tab::get_tabs($key);

			// ID 0 means a new section, anything else edits an existing section
			if ($id == 0)
			{
				// get the section
				$this->_data->section = false;

				// set the action
				$this->_data->action = 'add';

				// manually set the header, footer, and message
				$this->_headers['sections'] = lang('action.create status.new form section', 2);
				$this->_titles['sections'] = lang('action.create status.new form section', 2);
				$this->_messages['sections'] = false;
			}
			else
			{
				// get the section
				$this->_data->section = \Model_Form_Section::find($id);

				// if we don't have a section, redirect to the creation screen
				if ($this->_data->section === null)
				{
					\Response::redirect('admin/form/sections/'.$key.'/0');
				}

				// if the section isn't part of this form, redirect them
				if ($this->_data->section->form_key != $key)
				{
					\Response::redirect('admin/form/sections/'.$this->_data->section->form_key.'/'.$id);
				}

				// set the action
				$this->_data->action = 'update';

				// manually set the header, footer, and message
				$this->_headers['sections'] = lang('action.update form section', 2);
				$this->_titles['sections'] = lang('action.update form section', 2);
				$this->_messages['sections'] = false;
			}
		}

		// set up the images
		$this->_data->images = array(
			'fields' => \Location::image($this->images['fields'], $this->skin, 'admin'),
			'tabs' => \Location::image($this->images['tabs'], $this->skin, 'admin'),
		);

		return;
	}

	/**
	 * Shows all the tabs associated with a specific form. In addition, if an ID is passed
	 * through the URI, that tab can be edited, or new tabs can be created.
	 *
	 * Ideally, we would do the section update for a deleted tab in the observer, but
	 * we can't pass arguments to the observer (the new tab ID), so we have to do it
	 * in here.
	 */
	public function action_tabs($key, $id = false)
	{
		\Sentry::allowed('form.update', true);

		$this->_view = 'admin/form/tabs';
		$this->_js_view = 'admin/form/tabs_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				// get the ID from the POST
				$tab_id = \Security::xss_clean(\Input::post('id'));

				if (\Sentry::user()->has_access('form.delete') and $action == 'delete')
				{
					// get the new tab ID
					$new_tab = \Security::xss_clean(\Input::post('new_tab_id'));

					// get the tab we're deleting
					$tab = \Model_Form_Tab::find($tab_id);

					// loop through the sections and update them
					foreach ($tab->sections as $sec)
					{
						// update the tab ID
						$sec->tab_id = $new_tab;

						// save the record
						$sec->save();
					}

					// delete the tab
					$item = \Model_Form_Tab::delete_item($tab_id);

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|tab|action.deleted]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|tab|action.deletion]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'add')
				{
					// add the tab
					$item = \Model_Form_Tab::create_item(\Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|tab|action.added]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|tab|action.creation]]', 1),
						);
					}
				}

				if (\Sentry::user()->has_access('form.update') and $action == 'update')
				{
					// update the tab
					$item = \Model_Form_Tab::update_item($tab_id, \Input::post());

					if ($item)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|tab|action.updated]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|tab|action.update]]', 1),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
			}
		}

		// no ID, show all the tabs
		if ($id === false)
		{
			// set up the variables
			$this->_data->tabs = false;

			// get the form elements
			$tabs = \Model_Form_Tab::find_form_items($key);

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

			// manually set the header, footer, and message
			$this->_headers['tabs'] = lang('action.manage form tabs', 2);
			$this->_titles['tabs'] = lang('action.manage form tabs', 2);
			$this->_messages['tabs'] = lang('sitecontent.message.tabs_all');
		}
		else
		{
			$this->_view = 'admin/form/tabs_action';

			// get the tabs
			$this->_data->tabs = \Model_Form_Tab::get_tabs($key);

			// ID 0 means a new tab, anything else edits an existing tab
			if ($id == 0)
			{
				// get the tab
				$this->_data->tab = false;

				// set the action
				$this->_data->action = 'add';

				// manually set the header, footer, and message
				$this->_headers['tabs'] = lang('action.create status.new form tab', 2);
				$this->_titles['tabs'] = lang('action.create status.new form tab', 2);
				$this->_messages['tabs'] = false;
			}
			else
			{
				// get the tab
				$this->_data->tab = \Model_Form_Tab::find($id);

				// if we don't have a tab, redirect to the creation screen
				if ($this->_data->tab === null)
				{
					\Response::redirect('admin/form/tabs/'.$key.'/0');
				}

				// if the tab isn't part of this form, redirect them
				if ($this->_data->tab->form_key != $key)
				{
					\Response::redirect('admin/form/tabs/'.$this->_data->tab->form_key.'/'.$id);
				}

				// set the action
				$this->_data->action = 'update';

				// manually set the header, footer, and message
				$this->_headers['tabs'] = lang('action.update form tab', 2);
				$this->_titles['tabs'] = lang('action.update form tab', 2);
				$this->_messages['tabs'] = false;
			}
		}

		// set up the images
		$this->_data->images = array(
			'sections' => \Location::image($this->images['sections'], $this->skin, 'admin'),
			'fields' => \Location::image($this->images['fields'], $this->skin, 'admin'),
		);

		return;
	}
}
