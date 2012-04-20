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

class Controller_Ajax_Delete extends Controller_Base_Ajax
{
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

	public function action_field_value()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the value
			$id = trim(\Security::xss_clean(\Input::post('id')));

			// grab the value from the database
			$value = \Model_Form_Value::find($id);

			// delete it
			$value->delete();

			\SystemEvent::add('user', '[[event.form_update|{{'.$key.'}}]]');
		}
	}

	public function action_section($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.delete'))
		{
			// get the section
			$section = \Model_Form_Section::find($id);

			// get all the sections
			$sections = \Model_Form_Section::get_sections($section->form_key);

			// remove the section we are deleting
			unset($sections[$id]);

			if ($section !== null)
			{
				$data = array(
					'name' => $section->name,
					'id' => $section->id,
					'sections' => $sections,
				);

				echo \View::forge(\Location::file('delete/section', 'default', 'ajax'), $data);
			}
		}
	}

	public function action_tab($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.delete'))
		{
			// get the tab
			$tab = \Model_Form_Tab::find($id);

			// get all the tabs
			$tabs = \Model_Form_Tab::get_tabs($tab->form_key);

			// remove the tab we are deleting
			unset($tabs[$id]);

			if ($tab !== null)
			{
				$data = array(
					'name' => $tab->name,
					'id' => $tab->id,
					'tabs' => $tabs,
				);

				echo \View::forge(\Location::file('delete/tab', 'default', 'ajax'), $data);
			}
		}
	}
}
