<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Form class extends Kohana's native Form class to add additional methods
 * specific to Nova. The methods added to the Form class allow developers to
 * generate select menus with position, rank, department and character listings
 * with only a single line of code.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		3.0
 */

abstract class Nova_Form extends Kohana_Form {
	
	/**
	 * Creates an email input field. For browsers that don't support this field
	 * type, a standard text input will be used instead. If you're viewing this
	 * field on an iOS device, special formatting will be used. This is the
	 * preferred way of displaying and gathering an email address.
	 *
	 *     echo form::email('email');
	 *
	 * @access	public
	 * @uses	Form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function email($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'email';
		
		// create the element
		return Form::input($name, $value, $attributes);
	}
	
	/**
	 * Dropdown menu of characters.
	 *
	 * @access	public
	 * @param	string	the name of the dropdown menu
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes for the dropdown menu
	 * @param	string	the type of characters to pull
	 * @param	bool	whether to print a NONE option at the top of the menu
	 * @return	string	a dropdown output from form::dropdown
	 */
	/*public static function dropdown_characters($name = '', $selected = array(), $extra = '', $type = 'active', $blank_option = false)
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
							'value' => null
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
			if ($blank_option === true)
			{
				$options[0] = ucfirst(___('word.none'));
			}
			
			foreach ($all as $a)
			{
				if ($type == 'user_npc')
				{
					switch ($a->crew_type)
					{
						case 'active':
							$label = ucwords(___('status.playing').' '.___('global.characters'));
						break;
							
						case 'npc':
							$label = ucwords(___('status.nonplaying').' '.___('global.characters'));
						break;
							
						case 'inactive':
							$label = ucwords(___('status.inactive').' '.___('global.characters'));
						break;
							
						case 'pending':
							$label = ucwords(___('status.pending').' '.___('global.characters'));
						break;
					}
					
					$options[$label][$a->charid] = Utility::print_character_name($a->charid, true);
				}
				else
				{
					$options[$a->charid] = Utility::print_character_name($a->charid, true);
				}
			}
			
			return form::dropdown($name, $options, $selected, $extra);
		}
		
		return false;
	}*/
	
	/**
	 * Dropdown menu of the departments.
	 *
	 * @access	public
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	string	any extra attributes to be added to the dropdown
	 * @param	string	which departments to pull (all/main)
	 * @param	string	whether the department should be a displayed department
	 * @param	string	a department to exclude from the list
	 * @param	bool	whether to print a NONE option at the top of the dropdown
	 * @return	string	a select menu output from form::select
	 */
	/*public static function dropdown_dept($name = '', $selected = array(), $extra = null, $type = 'all', $display = 'y', $exclude = '', $blank_option = false)
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
				$depts = $mCore->get_all('departments_'.Kohana::$config->load('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === true)
					{
						$options[0] = ucfirst(___('word.none'));
					}
					
					foreach ($depts as $dept)
					{
						if ( ! empty($exclude) and $exclude == $dept->dept_id)
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
						$subd = $mCore->get_all('departments_'.Kohana::$config->load('nova.genre'), $args);
						
						if ($subd)
						{
							foreach ($subd as $sub)
							{
								if ( ! empty($exclude) and $exclude == $sub->dept_id)
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
				$depts = $mCore->get_all('departments_'.Kohana::$config->load('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === true)
					{
						$options[0] = ucfirst(___('word.none'));
					}
					
					foreach ($depts as $dept)
					{
						if ( ! empty($exclude) and $exclude == $dept->dept_id)
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
		
		return false;
	}*/
	
	/**
	 * A select menu that includes all of the postions from the database based
	 * on the parameters passed to the method.
	 *
	 *     echo Form::select_position('positions', 8, array('id' => 'positions'), 'open');
	 *
	 * @access	public
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to be added to the select menu
	 * @param	string	which positions to pull (all, open, or a department ID)
	 * @param	string	whether to pull displayed positions or not (y,n)
	 * @param	string	the department type to pull
	 * @return	string	a select menu output from form::select
	 */
	public static function select_position($name, $selected = array(), $extra = null, $type = 'all', $display = 'y', $dept_type = '')
	{
		// grab the positions
		if ($type == 'open')
		{
			$positions = Model_Position::get_positions('open');
		}
		elseif (is_numeric($type))
		{
			$positions = Model_Position::get_positions('all', $type);
		}
		else
		{
			$positions = Model_Position::get_positions();
		}
		
		if (count($positions) > 0)
		{
			$options[0] = ___('Please Choose One');
			
			$valid = false;
			
			foreach ($positions as $pos)
			{
				if (($dept_type == 'playing' and $pos->dept->type == 'playing') or
						($dept_type == 'nonplaying' and $pos->dept->type == 'nonplaying') or
						(bool) $pos->dept->display === true)
				{
					if ($type == 'all' or $type == 'open')
					{
						$options[$pos->dept->name][$pos->id] = $pos->name;
					}
					else
					{
						$options[$pos->id] = $pos->name;
					}
				}
			}
			
			return Form::select($name, $options, $selected, $extra);
		}
		
		return false;
	}
	
	/**
	 * A select menu that includes all of the ranks from the database based on
	 * the parameters passed to the method.
	 *
	 *     echo Form::select_rank('ranks', 3, array('id' => 'ranks'));
	 *
	 * @access	public
	 * @uses	Form::select
	 * @param	string	the name of the select menu
	 * @param	array 	an array of selected items
	 * @param	array	any extra attributes to add to the select menu
	 * @return	string	a select menu from form::select
	 */
	public static function select_rank($name, $selected = array(), $extra = null)
	{
		// grab the ranks
		$ranks = Model_Rank::get_ranks();
		
		if (count($ranks) > 0)
		{
			foreach ($ranks as $rank)
			{
				$options[$rank->id] = $rank->name;
			}
			
			return Form::select($name, $options, $selected, $extra);
		}
		
		return false;
	}
}
