<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Form Class
 *
 * @package		Nova Core
 * @subpackage	Base
 * @author		Anodyne Productions
 * @version		2.0
 */

class Nova_Form extends Kohana_Form
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
	public static function dropdown_characters($name = '', $selected = array(), $extra = '', $type = 'active', $blank_option = FALSE)
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
	}
	
	/**
	 * Dropdown menu of the departments
	 *
	 * @param	string	the name of the dropdown menu
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes to be added to the dropdown
	 * @param	string	which departments to pull (all/main)
	 * @param	string	whether the department should be a displayed department
	 * @param	string	a department to exclude from the list
	 * @param	boolean	whether to print a NONE option at the top of the dropdown
	 * @return			a dropdown output from form::dropdown
	 */
	public static function dropdown_dept($name = '', $selected = array(), $extra = '', $type = 'all', $display = 'y', $exclude = '', $blank_option = FALSE)
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
	}
	
	/**
	 * Dropdown of positions
	 *
	 * @param	string	the name of the dropdown
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes to be added to the dropdown
	 * @param	string	which positions to pull
	 * @param	string	whether to pull displayed positions or not
	 * @param	string	the department type to pull
	 * @return			a dropdown output from form::dropdown
	 */
	public static function dropdown_position($name = '', $selected = array(), $extra = '', $type = 'all', $display = 'y', $dept_type = '')
	{
		// load the core model
		$mCore = new Core_Model;
		
		/* grab the positions */
		if ($type == 'open')
		{
			$args = array(
				'where' => array(
					array(
						'field' => 'pos_open',
						'value' => 0,
						'operand' => '>'),
				),
				'order_by' => array(
					'pos_dept' => 'asc',
					'pos_order' => 'asc'
				),
			);
			
			if (!empty($display))
			{
				$args['where'][] = array(
					'field' => 'pos_display',
					'value' => $display
				);
			}
		}
		elseif (is_numeric($type))
		{
			$args = array(
				'where' => array(
					array(
						'field' => 'pos_dept',
						'value' => $type),
				),
				'order_by' => array(
					'pos_order' => 'asc'
				),
			);
			
			if (!empty($display))
			{
				$args['where'][] = array(
					'field' => 'pos_display',
					'value' => $display
				);
			}
		}
		else
		{
			$args = array(
				'order_by' => array(
					'pos_order' => 'asc'
				),
			);
			
			if (!empty($display))
			{
				$args['where'][] = array(
					'field' => 'pos_display',
					'value' => $display
				);
			}
		}
		
		$positions = $mCore->get_all('positions_'.Kohana::config('nova.genre'), $args);
		
		if ($positions)
		{
			$options[0] = __('phrase.please_choose_one');
			
			$valid = FALSE;
			
			foreach ($positions as $pos)
			{
				$args = array(
					'where' => array(
						array(
							'field' => 'dept_id',
							'value'=> $pos->pos_dept),
					),
				);
				$dept = $mCore->get('departments_'.Kohana::config('nova.genre'), $args, array('dept_name', 'dept_type', 'dept_display'));
				
				if (($dept_type == 'playing' && $dept['dept_type'] == 'playing') ||
						($dept_type == 'nonplaying' && $dept['dept_type'] == 'nonplaying') ||
						$dept['dept_display'] == 'y')
				{
					if ($type == 'all' || $type == 'open')
					{
						$options[$dept['dept_name']][$pos->pos_id] = $pos->pos_name;
					}
					else
					{
						$options[$pos->pos_id] = $pos->pos_name;
					}
				}
			}
			
			return form::dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
	
	/**
	 * Dropdown of ranks
	 *
	 * @param	string	the name of the dropdown
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes to add to the dropdown
	 * @return			a dropdown output from form::dropdown
	 */
	public static function dropdown_rank($name = '', $selected = array(), $extra = '')
	{
		// load the core model
		$mCore = new Core_Model;
		
		// build the query
		$args = array(
			'where' => array(
				array(
					'field' => 'rank_display',
					'value' => 'y'),
			),
			'order_by' => array(
				'rank_class' => 'asc',
				'rank_order' => 'asc'
			),
		);
		$ranks = $mCore->get_all('ranks_'.Kohana::config('nova.genre'), $args);
		
		if ($ranks)
		{
			foreach ($ranks as $rank)
			{
				$options[$rank->rank_id] = $rank->rank_name;
			}
			
			return form::dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
}

// End of file form.php
// Location: modules/nova/classes/nova/form.php