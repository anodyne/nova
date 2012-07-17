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
	public function action_formfield($id)
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

				echo \View::forge(\Location::file('delete/field', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	public function action_formfield_value()
	{
		if (\Sentry::check() and \Sentry::user()->has_access('form.edit'))
		{
			// get the value
			$id = trim(\Security::xss_clean(\Input::post('id')));

			// grab the value from the database
			$value = \Model_Form_Value::find($id);

			// delete it
			$value->delete();

			\SystemEvent::add('user', '[[event.admin.form.field_delete|{{'.$value->label.'}}|{{'.$value->form_key.'}}]]');
		}
	}

	public function action_formsection($id)
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

				echo \View::forge(\Location::file('delete/section', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	public function action_formtab($id)
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

				echo \View::forge(\Location::file('delete/tab', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	public function action_rankset($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.delete'))
		{
			// get the rank set
			$set = \Model_Rank_Set::find($id);

			if ($set !== null)
			{
				$data = array(
					'name' => $set->name,
					'id' => $set->id,
				);

				// get all the sets
				$sets = \Model_Rank_Set::find_items(true);

				// create an empty array
				$data['sets'] = array();

				if (count($sets) > 0)
				{
					foreach ($sets as $s)
					{
						if ($s->id != $id)
						{
							$data['sets'][$s->id] = $s->name;
						}
					}
				}

				echo \View::forge(\Location::file('delete/rankset', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}
}
