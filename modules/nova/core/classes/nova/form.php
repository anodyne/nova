<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Form class extends Kohana's native Form class to add additional methods specific to Nova.
 * The methods added to the Form class allow developers to generate select menus with position,
 * rank, department and character listings with only a single line of code.
 *
 * The HTML5 input elements are based off of work done by Adam Fairholm for CodeIgniter 2.0.
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 */

abstract class Nova_Form extends Kohana_Form {
	
	/**
	 * Creates a color picker input field. Currently, no browsers support this field type.
	 * The HTML5 spec calls for it though, so at some point, it will be supported.
	 *
	 *     echo form::color('color');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function color($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'color';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a datalist input field. Datalists describe possible values for an input
	 * element and have a similar format to a select box. The final output of a datalist
	 * will look something like this:
	 *
	 *     <input list="cars" />
	 *
	 *     <datalist id="cars">
	 *         <option value="BMW">
	 *         <option value="Ford">
	 *         <option value="Volvo">
	 *     </datalist>
	 *
	 * The input has an attribute called list which corresponds to the id of the datalist.
	 * The datalist contains elements that are possible values of the input. When a user starts 
	 * typing, they see the options. This only works in Opera 9+.
	 *
	 *     echo form::datalist('data', $values, $attributes);
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	array 	an array of potential values
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function datalist($name, array $values, array $attributes = null)
	{
		// set the initial element
		$html = '<datalist name="'.$name.'" '.html::attributes($attributes).'>';
		
		// loop through and create the options
		foreach ($values as $label => $value)
		{
			$html.= '<option value="'.$value.'"></option>';
		}
		
		return $html.= "</datalist>";
	}
	
	/**
	 * Creates a date input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera,
	 * the field will use a standard date picker. More information about dates and times in
	 * HTML5 can be found [here](http://diveintohtml5.org/forms.html).
	 *
	 *     echo form::date('date');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function date($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'date';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a datetime input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera, you'll
	 * be shown a datetime selector.
	 *
	 *     echo form::datetime('datetime');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function datetime($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'datetime';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a local datetime email input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera, you'll
	 * be shown a datetime selector.
	 *
	 *     echo form::datetime_local('datetime');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function datetime_local($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'datetime-local';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates an email input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field on a device like an iPhone,
	 * special formatting will be used. This is the preferred way of displaying and gathering
	 * an email address.
	 *
	 *     echo form::email('email');
	 *
	 * @uses	form::input
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
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a month input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera,
	 * a month/year selector will be shown.
	 *
	 *     echo form::month('month');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function month($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'month';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a number input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field on a device like an iPhone,
	 * special formatting will be used. This is the preferred way of displaying and gathering
	 * numbers. Some browsers will also read specific attributes for numbers as well.
	 *
	 *     $attributes = array(
     *         'min' => 1, // the input's minimum value
	 *         'max' => 5, // the input's maximum value
	 *         'step' => 1 // increments the number can go in
	 *     );
	 *
	 *     echo form::number('number', null, $attributes);
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function number($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'number';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a slider input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field on a device like an iPhone,
	 * special formatting will be used. This field takes the numeric attributes found in form::number
	 * as well.
	 *
	 *     echo form::range('range');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function range($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'range';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a search input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. In some browsers, like Safari, the search box will
	 * render in a native style. You can read more about search boxes [here](http://diveintohtml5.org/forms.html#type-search).
	 *
	 *     echo form::search('search');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function search($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'search';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
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
				$depts = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === true)
					{
						$options[0] = ucfirst(__('word.none'));
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
						$subd = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
						
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
				$depts = $mCore->get_all('departments_'.Kohana::config('nova.genre'), $args);
		
				if ($depts)
				{
					if ($blank_option === true)
					{
						$options[0] = ucfirst(__('word.none'));
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
	public static function select_position($name, $selected = array(), $extra = null, $type = 'all', $display = 'y', $dept_type = '')
	{
		// grab the positions
		if ($type == 'open')
		{
			$positions = Jelly::query('position')->open()->order_by('dept', 'asc')->order_by('order', 'asc');
		}
		elseif (is_numeric($type))
		{
			$positions = Jelly::query('position')->where('dept', '=', $type)->order_by('order', 'asc');
		}
		else
		{
			$positions = Jelly::query('position')->order_by('order', 'asc');
		}
		
		// set the display parameter
		( ! empty($display)) ? $positions->where('display', '=', $display) : false;
		
		$positions = $positions->select();
		
		if (count($positions) > 0)
		{
			$options[0] = __('phrase.please_choose_one');
			
			$valid = false;
			
			foreach ($positions as $pos)
			{
				if (($dept_type == 'playing' and $pos->dept->type == 'playing') or
						($dept_type == 'nonplaying' and $pos->dept->type == 'nonplaying') or
						$pos->dept->display == 'y')
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
			
			return form::select($name, $options, $selected, $extra);
		}
		
		return false;
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
	public static function select_rank($name, $selected = array(), $extra = null)
	{
		// grab the ranks
		$ranks = Jelly::query('rank')
			->where('display', '=', 'y')
			->order_by('class', 'asc')
			->order_by('order', 'asc')
			->select();
		
		if (count($ranks) > 0)
		{
			foreach ($ranks as $rank)
			{
				$options[$rank->id] = $rank->name;
			}
			
			return form::select($name, $options, $selected, $extra);
		}
		
		return false;
	}
	
	/**
	 * Creates a telephone input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field on a device like an iPhone,
	 * special formatting will be used. This is the preferred way of displaying and gathering
	 * telephone numers.
	 *
	 *     echo form::tel('phone');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function tel($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'tel';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a time input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera,
	 * a time selector will be shown.
	 *
	 *     echo form::time('time');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function time($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'time';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a URL input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field on a device like an iPhone,
	 * special formatting will be used. This is the preferred way of displaying and gathering
	 * a URL.
	 *
	 *     echo form::url('link');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function url($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'url';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
	
	/**
	 * Creates a week input field. For browsers that don't support this field type, a standard
	 * text input will be used instead. If you're viewing this field in a browser like Opera,
	 * you'll be shown a week selector.
	 *
	 *     echo form::week('week');
	 *
	 * @uses	form::input
	 * @param	string	the name of the field
	 * @param	string	the value of the field
	 * @param	array 	an array of attributes
	 * @return	string	the complete field
	 */
	public static function week($name, $value = null, array $attributes = null)
	{
		// set the type
		$attributes['type'] = 'week';
		
		// create the element
		return form::input($name, $value, $attributes);
	}
} // End Form