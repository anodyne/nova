<?php
/**
 * The NovaForm class handles building some of the more complex form
 * elements found throughout Nova.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author 		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class NovaForm
{
	public static function build($key, $skin, $id = false, $editable = true)
	{
		// set up the variables
		$data = new \stdClass;
		$data->form = \Model_Form::get_form($key);
		$data->tabs = false;
		$data->sections = false;
		$data->fields = false;
		$data->data = array();
		$data->id = $id;
		$data->skin = $skin;
		$data->editable = $editable;

		// get the form elements
		$tabs = \Model_Form_Tab::find_form_items($key, true);
		$sections = \Model_Form_Section::find_form_items($key, true);
		$fields = \Model_Form_Field::find_form_items($key, true);
		$content = \Model_Form_Data::get_data($key, $id);

		/**
		 * Tabs
		 */
		if (count($tabs) > 0)
		{
			$data->tabs = array();

			foreach ($tabs as $tab)
			{
				$data->tabs[] = $tab;
			}
		}

		/**
		 * Sections
		 */
		if (count($sections) > 0)
		{
			$data->sections = array();

			foreach ($sections as $section)
			{
				if (count($tabs) > 0)
				{
					$data->sections[$section->tab_id][] = $section;
				}
				else
				{
					$data->sections[] = $section;
				}
			}
		}

		/**
		 * Fields
		 */
		if (count($fields) > 0)
		{
			$data->fields = array();
			
			foreach ($fields as $field)
			{
				if (count($sections) > 0)
				{
					$data->fields[$field->section_id][] = $field;
				}
				else
				{
					$data->fields[] = $field;
				}

				$data->data[$field->id] = '';
			}
		}

		/**
		 * Data
		 */
		if (count($content) > 0)
		{
			foreach ($content as $c)
			{
				if (array_key_exists($c->field_id, $data->data))
				{
					$data->data[$c->field_id] = $c->value;
				}
			}
		}

		return \View::forge(\Location::file('form', $skin, 'partials'), $data);
	}

	/**
	 * Builds a select menu that includes all of the positions from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::position('positions', 8, array('id' => 'positions', 'open'));
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @return	string	a select menu output from Form::select
	 */
	public static function department($name, $selected = array(), $extra = null)
	{
		// grab the departments
		$depts = \Model_Department::find('all');

		if (count($depts) > 0)
		{
			$options[0] = '';
			
			$valid = false;
			
			foreach ($depts as $d)
			{
				if ($d->manifest)
				{
					$options[$d->manifest->name][$d->id] = $d->name;
				}
				else
				{
					$options[$d->id] = $d->name;
				}
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}
		
		return false;
	}

	/**
	 * Builds a select menu that includes all of the positions from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::position('positions', 8, array('id' => 'positions'), 'open');
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @param	string	which positions to pull (all, open, or a department ID)
	 * @param	bool	whether to show just the select menu or everything else too
	 * @return	string
	 */
	public static function position($name, $selected = array(), $extra = array(), $type = 'all', $select_only = false)
	{
		if (is_numeric($type))
		{
			$positions = \Model_Position::find_positions('all', $type);
		}
		elseif (is_string($type))
		{
			$positions = \Model_Position::find_positions($type);
		}
		else
		{
			$positions = \Model_Position::find_positions();
		}

		if (count($positions) > 0)
		{
			// the first element should be blank
			$options[''] = '';
			
			// loop through the positions and put them in a format we can use
			foreach ($positions as $p)
			{
				if ( ! is_numeric($type))
				{
					$options[$p->dept->name][$p->id] = $p->name;
				}
				else
				{
					$options[$p->id] = $p->name;
				}
			}

			if ($select_only)
			{
				return \Form::select($name, $selected, $options, (array) $extra);
			}

			// merge the user options into what should be there
			$extra = array_merge(array('id' => 'positionDrop', 'class' => 'span4'), (array) $extra);

			// build the output
			$output = '<div class="control-group"><label class="control-label">'.lang('position', 1).'</label><div class="controls">';
			$output.= \Form::select($name, $selected, $options, $extra);
			$output.= '<div id="positionDesc" class="help-block">';

			if (is_numeric($selected))
			{
				$output.= \Markdown::parse(\Model_Position::find($selected)->desc);
			}

			$output.= '</div></div></div>';

			return $output;
		}
		
		return false;
	}
	
	/**
	 * Builds a select menu that includes all of the ranks from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::rank('ranks', 3, array('id' => 'ranks'));
	 * </code>
	 *
	 * @api
	 * @param	string	the name of the select menu
	 * @param	mixed 	an array of selected items
	 * @param	array	any extra attributes to add to the select menu
	 * @param	bool	whether to just show the select or everything else as well
	 * @return	string
	 */
	public static function rank($name, $selected = false, $extra = array(), $select_only = false)
	{
		// grab the rank groups
		$groups = \Model_Rank_Group::find_items(true);
		
		if (count($groups) > 0)
		{
			foreach ($groups as $g)
			{
				foreach ($g->ranks as $r)
				{
					$options[$g->name][$r->id] = $r->info->name;
				}
			}

			if ($select_only)
			{
				return \Form::select($name, $selected, $options, (array) $extra);
			}

			// merge the user options into what should be there
			$extra = array_merge(array('id' => 'rankDrop', 'class' => 'span4'), (array) $extra);

			// build the output
			$output = '<div class="control-group"><label class="control-label">'.lang('rank', 1).'</label><div class="controls">';
			$output.= \Form::select($name, $selected, $options, $extra);
			$output.= '<div id="rankImg" class="help-block"></div>';

			if (is_numeric($selected))
			{
				// get the rank
				$rank = \Model_Rank::find($selected);

				$output.= \Location::rank($rank->base, $rank->pip);
			}

			$output.= '</div></div>';

			return $output;
		}
		
		return false;
	}

	/**
	 * Builds a select menu that includes all of the access roles from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::roles('role', 3, array('id' => 'roles'));
	 * </code>
	 *
	 * @api
	 * @param	string	the name of the select menu
	 * @param	mixed 	an array of selected items
	 * @param	array	any extra attributes to add to the select menu
	 * @param	bool	whether to just show the select or everything else as well
	 * @return	string
	 */
	public static function roles($name, $selected = array(), $extra = array(), $select_only = false)
	{
		// get the access roles
		$roles = \Model_Access_Role::get_roles();

		if (count($roles) > 0)
		{
			if ($select_only)
			{
				return \Form::select($name, $selected, $roles, (array) $extra);
			}

			// merge the user options into what should be there
			$extra = array_merge(array('id' => 'roleDrop', 'class' => 'span4'), (array) $extra);

			// build the output
			$output = '<div class="control-group"><label class="control-label">'.lang('access_role', 2).'</label><div class="controls">';
			$output.= \Form::select($name, $selected, $roles, $extra);
			$output.= '<div id="roleDesc" class="help-block">';

			if (is_numeric($selected))
			{
				$output.= \Markdown::parse(\Model_Access_Role::find($selected)->desc);
			}

			$output.= '</div></div></div>';

			return $output;
		}

		return false;
	}

	/**
	 * Builds a select menu that includes all timezones supported in PHP.
	 *
	 * <code>
	 * echo NovaForm::timezones('timezone', 'America/Chicago', array('class' => 'span4 chzn'));
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @return	string	a select menu output from Form::select
	 */
	public static function timezones($name, $selected = array(), $extra = array())
	{
		// get the timezone information
		$zones = timezone_identifiers_list();

		// make sure UTC is in the list
		$locations['UTC'] = 'UTC';

		foreach ($zones as $zone)
		{
			// break out the zones into contintent and city
			$zone = explode('/', $zone);

			// only use "friendly" continent names
			if ($zone[0] == 'Africa' or $zone[0] == 'America' or $zone[0] == 'Antarctica' or $zone[0] == 'Arctic' or 
					$zone[0] == 'Asia' or $zone[0] == 'Atlantic' or $zone[0] == 'Australia' or $zone[0] == 'Europe' or 
					$zone[0] == 'Indian' or $zone[0] == 'Pacific')
			{
				if (isset($zone[1]) != '')
				{
					// create an array with the zone and the friendly name
					$locations[$zone[0]][$zone[0].'/'.$zone[1]] = str_replace('_', ' ', $zone[1]);
				}
			}
		}

		return \Form::select($name, $selected, $locations, $extra);
	}

	/**
	 * Builds a select menu that includes all of the users from
	 * the database based on the parameters passed to the method.
	 *
	 * <code>
	 * echo NovaForm::position('positions', 8, array('id' => 'positions', 'open'));
	 * </code>
	 *
	 * @api
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @return	string	a select menu output from Form::select
	 */
	public static function users($name, $selected = array(), $extra = array(), $status = \Status::ACTIVE)
	{
		// get the users
		$users = ( ! empty($status)) ? \Model_User::find_users($status) : \Model_User::find('all');
		
		if (count($users) > 0)
		{
			$options[0] = '';
			
			foreach ($users as $u)
			{
				$options[$u->id] = $u->name;
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}
		
		return false;
	}
}
