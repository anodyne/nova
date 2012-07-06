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
	public static function build($key, $skin, $id = false)
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
	 * @param	string	which positions to pull (all, open, or a department ID)
	 * @param	string	whether to pull displayed positions or not (y,n)
	 * @param	string	the department type to pull
	 * @return	string	a select menu output from Form::select
	 */
	public static function position($name, $selected = array(), $extra = null, $type = 'all', $display = 'y', $dept_type = '')
	{
		// grab the positions
		if ($type == 'open')
		{
			$positions = \Model_Position::get_positions('open');
		}
		elseif (is_numeric($type))
		{
			$positions = \Model_Position::get_positions('all', $type);
		}
		else
		{
			$positions = \Model_Position::get_positions();
		}

		if (count($positions) > 0)
		{
			$options[0] = '';
			
			$valid = false;
			
			foreach ($positions as $p)
			{
				if (($dept_type == 'playing' and $p->dept->type == 'playing') or
						($dept_type == 'nonplaying' and $p->dept->type == 'nonplaying') or
						(bool) $p->dept->display === true)
				{
					if ($type == 'all' or $type == 'open')
					{
						$options[$p->dept->name][$p->id] = $p->name;
					}
					else
					{
						$options[$p->id] = $p->name;
					}
				}
			}

			return \Form::select($name, $selected, $options, (array) $extra);
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
	 * @return	string
	 */
	public static function rank($name, $selected = false, $extra = null)
	{
		// grab the ranks
		$ranks = \Model_Rank::get_ranks();
		
		if (count($ranks) > 0)
		{
			foreach ($ranks as $r)
			{
				$options[$r->id] = $r->name;
			}

			return \Form::select($name, $selected, $options, (array) $extra);
		}
		
		return false;
	}
}
