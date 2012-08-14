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
	public function action_apprule($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_level('character.create', 2))
		{
			// get the rule
			$rule = \Model_Application_Rule::find($id);

			if ($rule !== null)
			{
				$data = array(
					'type' => ($rule->type == 'dept') ? lang('department') : lang('global'),
					'id' => $rule->id,
				);

				echo \View::forge(\Location::file('delete/apprule', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	/**
	 * Un-ban a user.
	 *
	 * @return	void
	 */
	public function action_arc_unbanuser($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('ban.delete'))
		{
			// get the user
			$user = \Model_User::find(\Security::xss_clean($id));

			// delete the ban
			\Model_Ban::delete_item(array('email' => $user->email));

			\SystemEvent::add('user', '[[event.admin.arc.unban_user|{{'.$user->email.'}}]]');

			echo '<p class="alert alert-success">'.lang('[[short.flash.success|action.ban|action.removed]]', 1).'</p>';
			echo '<div class="form-actions"><button class="btn close-dialog">'.lang('action.close', 1).'</button></div>';
		}
	}

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
			$id = \Security::xss_clean(\Input::post('id'));

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

	public function action_rank($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.delete'))
		{
			// get the rank info
			$rank = \Model_Rank::find($id);

			if ($rank !== null)
			{
				$data = array(
					'name' => $rank->info->name,
					'id' => $rank->id,
				);

				echo \View::forge(\Location::file('delete/rank', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	public function action_rankgroup($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.delete'))
		{
			// get the rank group
			$group = \Model_Rank_Group::find($id);

			if ($group !== null)
			{
				$data = array(
					'name' => $group->name,
					'id' => $group->id,
				);

				// get all the groups
				$groups = \Model_Rank_Group::find_items(true);

				// create an empty array
				$data['groups'] = array();

				if (count($groups) > 0)
				{
					foreach ($groups as $g)
					{
						if ($g->id != $id)
						{
							$data['groups'][$g->id] = $g->name;
						}
					}
				}

				echo \View::forge(\Location::file('delete/rankgroup', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}

	public function action_rankinfo($id)
	{
		if (\Sentry::check() and \Sentry::user()->has_access('rank.delete'))
		{
			// get the rank info
			$info = \Model_Rank_Info::find($id);

			if ($info !== null)
			{
				$data = array(
					'name' => $info->name,
					'id' => $info->id,
				);

				// get all the info records
				$infoItems = \Model_Rank_Info::find_items(true);

				// create an empty array
				$data['infos'] = array();

				if (count($infoItems) > 0)
				{
					foreach ($infoItems as $i)
					{
						$group = lang('group', 1).' '.$i->group;

						if ($i->id != $id)
						{
							$data['infos'][$group][$i->id] = $i->name;
						}
					}
				}

				echo \View::forge(\Location::file('delete/rankinfo', \Utility::get_skin('admin'), 'ajax'), $data);
			}
		}
	}
}
