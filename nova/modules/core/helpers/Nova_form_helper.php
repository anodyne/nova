<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/form_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Form Button
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */	
if ( ! function_exists('form_button'))
{
	function form_button($data = '', $content = '', $extra = '')
	{
		/* load the user agent library */
		$ci =& get_instance();
		$ci->load->library('user_agent');
		
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''), 'type' => 'submit');
		
		if ( is_array($data) AND isset($data['content']))
		{
			$content = $data['content'];
			$data['value'] = $data['content'];
			unset($data['content']); // content is not an attribute
		}
		
		/*
		 * if a user has IE 7, we need to show them an input tag instead of a button tag
		 * because of the way IE 7 handles submitting multiple buttons (it send the
		 * innerHTML instead of the value in the key=>value pair)
		 */
		if ($ci->agent->browser() == 'Internet Explorer' && $ci->agent->version() < 8)
		{
			return "<input "._parse_form_attributes($data, $defaults).$extra." />";
		}
		else
		{
			return "<button "._parse_form_attributes($data, $defaults).$extra."><span>".$content."</span></button>\n";
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_dropdown'))
{
	function form_dropdown($name = '', $options = array(), $selected = array(), $extra = '', $disabled = '')
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}
		
		// run the check for disabled items
		$disabled = ($disabled != '0') ? preg_split("/[\s,]+/", $disabled) : FALSE;
		
		if ( ! is_array($disabled))
		{
			$disabled = array($disabled);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';
					
					$dis = (in_array($optgroup_key, $disabled)) ? ' disabled="disabled"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.$dis.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';
				
				$dis = (in_array($key, $disabled)) ? ' disabled="disabled"' : '';

				$form .= '<option value="'.$key.'"'.$sel.$dis.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}

// ------------------------------------------------------------------------

/**
 * Department Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @param	string (all/main)
 * @param	string (''/y/n)
 */
if ( ! function_exists('form_dropdown_characters'))
{
	function form_dropdown_characters($name = '', $selected = array(), $extra = '', $type = 'active', $blank_option = FALSE)
	{
		/* load the user agent library */
		$ci =& get_instance();
		
		/* load the resources */
		$ci->load->model('characters_model', 'char');
		
		/* set and load the language file needed */
		$ci->lang->load('app', $ci->session->userdata('language'));
		
		$all = $ci->char->get_all_characters($type);
		
		if ($all->num_rows() > 0)
		{
			if ($blank_option === TRUE)
			{
				$options[0] = ucfirst($ci->lang->line('labels_none'));
			}
			
			foreach ($all->result() as $a)
			{
				if ($type == 'user_npc')
				{
					switch ($a->crew_type)
					{
						case 'active':
							$label = ucwords($ci->lang->line('status_playing') .' '. $ci->lang->line('global_characters'));
						break;
							
						case 'npc':
							$label = ucwords($ci->lang->line('status_nonplaying') .' '. $ci->lang->line('global_characters'));
						break;
							
						case 'inactive':
							$label = ucwords($ci->lang->line('status_inactive') .' '. $ci->lang->line('global_characters'));
						break;
							
						case 'pending':
							$label = ucwords($ci->lang->line('status_pending') .' '. $ci->lang->line('global_characters'));
						break;
					}
					
					$options[$label][$a->charid] = $ci->char->get_character_name($a->charid, TRUE);
				}
				else
				{
					$options[$a->charid] = $ci->char->get_character_name($a->charid, TRUE);
				}
			}
			
			return form_dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * Department Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @param	string (all/main)
 * @param	string (''/y/n)
 */
if ( ! function_exists('form_dropdown_dept'))
{
	function form_dropdown_dept($name = '', $selected = array(), $extra = '', $type = 'all', $display = 'y', $exclude = '', $blank_option = FALSE)
	{
		/* load the user agent library */
		$ci =& get_instance();
		
		/* load the resources */
		$ci->load->model('depts_model', 'dept');
		
		/* set and load the language file needed */
		$ci->lang->load('app', $ci->session->userdata('language'));
		
		switch ($type)
		{
			case 'all':
				$depts = $ci->dept->get_all_depts('asc', $display);
				
				if ($depts->num_rows() > 0)
				{
					if ($blank_option === TRUE)
					{
						$options[0] = ucfirst($ci->lang->line('labels_none'));
					}
					
					foreach ($depts->result() as $dept)
					{
						if (!empty($exclude) && $exclude == $dept->dept_id)
						{
							/* don't do anything */
						}
						else
						{
							$manifestname = $ci->dept->get_manifest($dept->dept_manifest, 'manifest_name');
							$manifest = ($manifestname == '') ? FALSE : ' ('.$manifestname.')';
							
							$options[$dept->dept_id] = $dept->dept_name.$manifest;
						}
						
						$subd = $ci->dept->get_sub_depts($dept->dept_id, 'asc', $display);
						
						if ($subd->num_rows() > 0)
						{
							foreach ($subd->result() as $sub)
							{
								if (!empty($exclude) && $exclude == $sub->dept_id)
								{
									/* don't do anything */
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
				$depts = $ci->dept->get_all_depts('asc', $display);
		
				if ($depts->num_rows() > 0)
				{
					if ($blank_option === TRUE)
					{
						$options[0] = ucfirst($ci->lang->line('labels_none'));
					}
					
					foreach ($depts->result() as $dept)
					{
						if (!empty($exclude) && $exclude == $dept->dept_id)
						{
							/* don't do anything */
						}
						else
						{
							$manifestname = $ci->dept->get_manifest($dept->dept_manifest, 'manifest_name');
							$manifest = ($manifestname == '') ? FALSE : ' ('.$manifestname.')';
							
							$options[$dept->dept_id] = $dept->dept_name.$manifest;
						}
					}
				}
			break;
		}
		
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";
	
		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}

// ------------------------------------------------------------------------

/**
 * Position Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string (all/open/number)
 */
if ( ! function_exists('form_dropdown_position'))
{
	function form_dropdown_position($name = '', $selected = array(), $extra = '', $type = 'all', $display = 'y', $dept_type = '')
	{
		/* load the user agent library */
		$ci =& get_instance();
		
		/* load the resources */
		$ci->load->model('depts_model', 'dept');
		$ci->load->model('positions_model', 'pos');
		$ci->load->library('session');
		
		/* set and load the language file needed */
		$ci->lang->load('app', $ci->session->userdata('language'));
		
		/* grab the positions */
		if ($type == 'open')
		{
			$positions = $ci->pos->get_open_positions($display);
		}
		elseif (is_numeric($type))
		{
			$positions = $ci->pos->get_dept_positions($type, $display);
		}
		else
		{
			$positions = $ci->pos->get_all_positions('asc', $display);
		}
		
		if ($positions->num_rows() > 0)
		{
			$options[0] = ucwords($ci->lang->line('labels_please') .' '. $ci->lang->line('actions_choose')
				.' '. $ci->lang->line('order_one'));
			
			$valid = FALSE;
			
			foreach ($positions->result() as $pos)
			{
				$dept = $ci->dept->get_dept($pos->pos_dept, array('dept_name', 'dept_type', 'dept_display', 'dept_manifest'));
				
				$manifestname = $ci->dept->get_manifest($dept['dept_manifest'], 'manifest_name');
				$manifest = ($manifestname == '') ? FALSE : ' ('.$manifestname.')';
				$fullname = $dept['dept_name'].$manifest;
				
				if (($dept_type == 'playing' && $dept['dept_type'] == 'playing') ||
						($dept_type == 'nonplaying' && $dept['dept_type'] == 'nonplaying') ||
						$dept['dept_display'] == 'y')
				{
					if ($type == 'all' || $type == 'open')
					{
						$options[$fullname][$pos->pos_id] = $pos->pos_name;
					}
					else
					{
						$options[$pos->pos_id] = $pos->pos_name;
					}
				}
			}
			
			return form_dropdown($name, $options, $selected, $extra);
		}
		
		return FALSE;
	}
}

// ------------------------------------------------------------------------

/**
 * Rank Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_dropdown_rank'))
{
	function form_dropdown_rank($name = '', $selected = array(), $extra = '')
	{
		/* load the user agent library */
		$ci =& get_instance();
		
		/* load the resources */
		$ci->load->model('ranks_model', 'ranks');
		$ci->load->library('session');
		
		/* set and load the language file needed */
		$ci->lang->load('app', $ci->session->userdata('language'));
		
		/* grab the ranks */
		$ranks = $ci->ranks->get_ranks();
		
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";
	
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $rank)
			{
				$key = (string) $rank->rank_id;
	
				$sel = (in_array($rank->rank_id, $selected)) ? ' selected="selected"' : '';
	
				$form .= '<option value="'.$rank->rank_id.'"'.$sel.'>'.(string) $rank->rank_name."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}
