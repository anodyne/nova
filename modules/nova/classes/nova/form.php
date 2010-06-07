<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * The Form class extends Kohana's native Form class to add additional methods specific to Nova.
 * The methods added to the Form class allow developers to generate select menus with position,
 * rank, department and character listings with only a single line of code.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Form extends Kohana_Form
{
	/**
	 * Dropdown menu of characters
	 *
	 * @param	string	the name of the dropdown menu
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes for the dropdown menu
	 * @param	string	the type of characters to pull
	 * @param	boolean	whether to print a NONE option at the top of the menu
	 * @return			a dropdown output from form::dropdown
	 */
	/*public static function dropdown_characters($name = '', $selected = array(), $extra = '', $type = 'active', $blank_option = FALSE)
	{
		// load the core model
		$mCore = new Core_Model;
		
		switch ($type)
		{
			case 'active':
				$args['where'] = array(
					array(
						'field' => 'crew_type',
						'value' => 'active'
					),
				);
				break;
			
			case 'inactive':
				$args['where'] = array(
					array(
						'field' => 'crew_type',
						'value' => 'inactive'
					),
				);
				break;
				
			case 'npc':
				$args['where'] = array(
					array(
						'field' => 'crew_type',
						'value' => 'npc'
					),
				);
				break;
				
			case 'user_npc':
				$args = array(
					'where' => array(
						array(
							'field' => 'crew_type',
							'value' => 'active'
						),
					),
					'or_where' => array(
						array(
							'field' => 'crew_type',
							'value' => 'npc'
						),
					),
				);
				break;
				
			case 'pending':
				$args['where'] = array(
					array(
						'field' => 'crew_type',
						'value' => 'pending'
					),
				);
				break;
				
			case 'has_user':
				$args['where'] = array(
					array(
						'field' => 'user',
						'value' => '',
						'operand' => '>',
					),
				);
				break;
				
			case 'no_user':
				$args = array(
					'where' => array(
						array(
							'field' => 'user',
							'value' => NULL
						),
					),
					'or_where' => array(
						array(
							'field' => 'user',
							'value' => 0
						),
					),
				);
				break;
				
			case 'all':
				$args = array();
				break;
		}
		
		$args['order_by'] = array(
			'rank' => 'asc',
			'position_1' => 'asc',
		);
		$all = $mCore->get_all('characters', $args);
		
		if ($all)
		{
			if ($blank_option === TRUE)
			{
				$options[0] = ucfirst(__('word.none'));
			}
			
			foreach ($all as $a)
			{
				if ($type == 'user_npc')
				{
					switch ($a->crew_type)
					{
						case 'active':
							$label = ucwords(__('status.playing').' '.__('global.characters'));
							break;
							
						case 'npc':
							$label = ucwords(__('status.nonplaying').' '.__('global.characters'));
							break;
							
						case 'inactive':
							$label = ucwords(__('status.inactive').' '.__('global.characters'));
							break;
							
						case 'pending':
							$label = ucwords(__('status.pending').' '.__('global.characters'));
							break;
					}
					
					$options[$label][$a->charid] = Utility::print_character_name($a->charid, TRUE);
				}
				else
				{
					$options[$a->charid] = Utility::print_character_name($a->charid, TRUE);
				}
			}
			
			return form::dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}*/
	
	/**
	 * Dropdown menu of the departments
	 *
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes to be added to the dropdown
	 * @param	string	which departments to pull (all/main)
	 * @param	string	whether the department should be a displayed department
	 * @param	string	a department to exclude from the list
	 * @param	boolean	whether to print a NONE option at the top of the dropdown
	 * @return			a select menu output from form::select
	 */
	/*public static function dropdown_dept($name = '', $selected = array(), $extra = NULL, $type = 'all', $display = 'y', $exclude = '', $blank_option = FALSE)
	{
		// load the core model
		$mCore = new Core_Model;
		
		switch ($type)
		{
			case 'all':
				// build the query
				$args = array(
					'where' => array(
						array(
							'field' => 'dept_parent',
							'value' => 0),
						array(
							'field' => 'dept_display',
							'value' => $display),
					),
					'order_by' => array(
						'dept_order' => 'asc'),
				);
				$depts = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === TRUE)
					{
						$options[0] = ucfirst(__('word.none'));
					}
					
					foreach ($depts as $dept)
					{
						if (!empty($exclude) && $exclude == $dept->dept_id)
						{
							// don't do anything
						}
						else
						{
							$options[$dept->dept_id] = $dept->dept_name;
						}
						
						// build the query
						$args = array(
							'where' => array(
								array(
									'field' => 'dept_parent',
									'value' => $dept->dept_id),
								array(
									'field' => 'dept_display',
									'value' => $display),
							),
							'order_by' => array(
								'dept_order' => 'asc'),
						);
						$subd = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
						
						if ($subd)
						{
							foreach ($subd as $sub)
							{
								if (!empty($exclude) && $exclude == $sub->dept_id)
								{
									// don't do anything
								}
								else
								{
									$options[$sub->dept_id] = $sub->dept_name;
								}
							}
						}
					}
				}
			
				break;
				
			case 'main':
				// build the query
				$args = array(
					'where' => array(
						array(
							'field' => 'dept_parent',
							'value' => 0),
						array(
							'field' => 'dept_display',
							'value' => $display),
					),
					'order_by' => array(
						'dept_order' => 'asc'),
				);
				$depts = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === TRUE)
					{
						$options[0] = ucfirst(__('word.none'));
					}
					
					foreach ($depts as $dept)
					{
						if (!empty($exclude) && $exclude == $dept->dept_id)
						{
							// don't do anything
						}
						else
						{
							$options[$dept->dept_id] = $dept->dept_name;
						}
					}
				}
				
				break;
		}
		
		if (isset($options))
		{
			return form::dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}*/
	
	/**
	 * A select menu that includes all of the postions from the database based on the parameters passed to the method.
	 *
	 *     echo form::select_position('positions', 8, array('id' => 'positions'), 'open');
	 *
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @param	string	which positions to pull (all, open, or a department ID)
	 * @param	string	whether to pull displayed positions or not (y,n)
	 * @param	string	the department type to pull
	 * @return	string	a select menu output from form::select
	 */
	public static function select_position($name, $selected = array(), $extra = NULL, $type = 'all', $display = 'y', $dept_type = '')
	{
		// grab the positions
		if ($type == 'open')
		{
			$positions = Jelly::select('position')->open()->order_by('dept', 'asc')->order_by('order', 'asc');
		}
		elseif (is_numeric($type))
		{
			$positions = Jelly::select('position')->where('dept', '=', $type)->order_by('order', 'asc');
		}
		else
		{
			$positions = Jelly::select('position')->order_by('order', 'asc');
		}
		
		// set the display parameter
		(!empty($display)) ? $positions->where('display', '=', $display) : FALSE;
		
		$positions = $positions->execute();
		
		if (count($positions) > 0)
		{
			$options[0] = __('phrase.please_choose_one');
			
			$valid = FALSE;
			
			foreach ($positions as $pos)
			{
				if (($dept_type == 'playing' && $pos->dept->type == 'playing') ||
						($dept_type == 'nonplaying' && $pos->dept->type == 'nonplaying') ||
						$pos->dept->display == 'y')
				{
					if ($type == 'all' || $type == 'open')
					{
						$options[$pos->dept->name][$pos->id] = $pos->name;
					}
					else
					{
						$options[$pos->id] = $pos->name;
					}
				}
			}
			
			return form::select($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
	
	/**
	 * A select menu that includes all of the ranks from the database based on the parameters passed to the method.
	 *
	 *     echo form::select_rank('ranks', 3, array('id' => 'ranks'));
	 *
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to add to the select menu
	 * @return	string	a select menu from form::select
	 */
	public static function select_rank($name, $selected = array(), $extra = NULL)
	{
		// grab the ranks
		$ranks = Jelly::select('rank')
			->where('display', '=', 'y')
			->order_by('class', 'asc')
			->order_by('order', 'asc')
			->execute();
		
		if (count($ranks) > 0)
		{
			foreach ($ranks as $rank)
			{
				$options[$rank->id] = $rank->name;
			}
			
			return form::select($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
} // End Form