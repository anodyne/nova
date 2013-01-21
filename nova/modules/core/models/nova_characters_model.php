<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Characters model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_characters_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_characters($status = 'active', $order = '')
	{
		$this->db->from('characters');
		
		switch ($status)
		{
			case 'active':
				$this->db->where('crew_type', 'active');
			break;
			
			case 'inactive':
				$this->db->where('crew_type', 'inactive');
			break;
				
			case 'npc':
				$this->db->where('crew_type', 'npc');
			break;
				
			case 'user_npc':
				$this->db->where('crew_type', 'active');
				$this->db->or_where('crew_type', 'npc');
			break;
				
			case 'pending':
				$this->db->where('crew_type', 'pending');
			break;
				
			case 'has_user':
				$this->db->where('user >', '');
			break;
				
			case 'no_user':
				$this->db->where('user', NULL);
				$this->db->or_where('user', 0);
			break;
				
			case 'all':
			break;
		}
		
		if (empty($order))
		{
			$this->db->order_by('rank', 'asc');
			$this->db->order_by('position_1', 'asc');
		}
		else
		{
			foreach ($order as $key => $value)
			{
				$this->db->order_by($key, $value);
			}
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Display a string of authors.
	 *
	 * @param	string	Comma-separated list of character IDs
	 * @param	bool	Show each character's rank?
	 * @param	bool	Link to each character's bio?
	 * @return	string
	 */
	public function get_authors($character = '', $showRank = true, $linkToBio = false)
	{
		// Explode the string into an array
		$characters = explode(',', $character);

		// Setup an array for holding our final values
		$charsFinal = array();
		
		foreach ($characters as $key)
		{
			// Get the caracter name
			$name = $this->get_character_name($key, $showRank, false, $linkToBio);
			
			// Make sure we have a name
			if ($name !== false)
			{
				$charsFinal[] = $name;
			}
		}
		
		if (count($charsFinal) > 0)
		{
			$charString = implode(' &amp; ', $charsFinal);
		
			return $charString;
		}
		
		return false;
	}
	
	public function get_bio_fields($section = '', $type = '', $display = 'y')
	{
		$this->db->from('characters_fields');
		
		if ( ! empty($section))
		{
			$this->db->where('field_section', $section);
		}
		
		if ( ! empty($type))
		{
			$this->db->where('field_type', $type);
		}
		
		if ( ! empty($display))
		{
			$this->db->where('field_display', $display);
		}
		
		$this->db->order_by('field_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_bio_field_details($id = '')
	{
		$query = $this->db->get_where('characters_fields', array('field_id' => $id));
		
		return $query;
	}
	
	public function get_bio_field_value_details($id = '')
	{
		$query = $this->db->get_where('characters_values', array('value_id' => $id));
		
		return $query;
	}
	
	public function get_bio_sections()
	{
		$this->db->from('characters_sections');
		$this->db->order_by('section_tab', 'asc');
		$this->db->order_by('section_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_bio_section_details($id = '')
	{
		$query = $this->db->get_where('characters_sections', array('section_id' => $id));
		
		return $query;
	}
	
	public function get_bio_tab_details($id = '')
	{
		$query = $this->db->get_where('characters_tabs', array('tab_id' => $id));
		
		return $query;
	}
	
	public function get_bio_tabs($display = 'y')
	{
		$this->db->from('characters_tabs');
		
		if ( ! empty($display))
		{
			$this->db->where('tab_display', 'y');
		}
		
		$this->db->order_by('tab_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_bio_values($field = '')
	{
		$this->db->from('characters_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_character($id = '', $return = '')
	{
		$query = $this->db->get_where('characters', array('charid' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ( ! empty($return) && $row !== false)
		{
			if ( ! is_array($return))
			{
				return $row->$return;
			}
			else
			{
				$array = array();
				
				foreach ($return as $r)
				{
					$array[$r] = $row->$r;
				}
				
				return $array;
			}
		}
		
		return $row;
	}
	
	public function get_character_emails($data = '')
	{
		if ( ! is_array($data))
		{
			$data = explode(',', $data);
		}
		
		$array = array();
		
		foreach ($data as $item)
		{
			$this->db->select('user');
			$this->db->from('characters');
			$this->db->where('charid', $item);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				
				$query2 = $this->db->get_where('users', array('userid' => $row->user));
				
				if ($query2->num_rows() > 0)
				{
					$user = $query2->row();
					
					$array[$user->userid] = $user->email;
				}
			}
		}
		
		return $array;
	}
	
	/**
	 * Get the character's name.
	 *
	 * @param	int		A character ID
	 * @param	bool	Show the character's rank?
	 * @param	bool	Show the character's short rank?
	 * @param	bool	Show a link to the character's bio?
	 * @return	string
	 */
	public function get_character_name($character = '', $showRank = false, $showShortRank = false, $showBioLink = false)
	{
		$this->db->from('characters');
		
		if ($showRank === true)
		{
			$this->db->join('ranks_'.GENRE, 'ranks_'.GENRE .'.rank_id = characters.rank');
		}
		
		$this->db->where('charid', $character);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$item = $query->row();
		
			$array['rank'] = ($showRank === true) ? $item->rank_name : false;
			$array['rank'] = ($showShortRank === true) ? $item->rank_short_name : $array['rank'];
			$array['first_name'] = $item->first_name;
			$array['last_name'] = $item->last_name;
			$array['suffix'] = $item->suffix;
		
			foreach ($array as $key => $value)
			{
				if (empty($value))
				{
					unset($array[$key]);
				}
			}
		
			$string = implode(' ', $array);

			if ($showBioLink === true)
			{
				return anchor('personnel/character/'.$item->charid, $string);
			}
		
			return $string;
		}
		
		return false;
	}
	
	public function get_characters_for_position($position = '', $order = '')
	{
		$this->db->from('characters');
		$this->db->where('crew_type !=', 'pending');
		$this->db->where('position_1', $position);
		$this->db->or_where('position_2', $position);
		
		if ( ! empty($order))
		{
			if (is_array($order))
			{
				foreach ($order as $field => $order)
				{
					$this->db->order_by($field, $order);
				}
			}
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_characters_minus_user($user = '')
	{
		$this->db->from('characters');
		$this->db->where('user >', '');
		$this->db->where('user !=', $user);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_coc()
	{
		$this->db->from('coc');
		$this->db->join('characters', 'characters.charid = coc.coc_crew');
		$this->db->join('positions_'. GENRE, 'positions_'. GENRE .'.pos_id = characters.position_1');
		$this->db->join('ranks_'. GENRE, 'ranks_'. GENRE .'.rank_id = characters.rank');
		$this->db->order_by('coc_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get the field data.
	 *
	 * @since	2.2
	 * @param	mixed	The field ID or the field_name
	 * @param	int		The character ID
	 * @param	bool	Whether to return just the value or the whole query object
	 * @return	mixed
	 */
	public function get_field_data($field = '', $character = '', $value_only = false)
	{
		if ( ! is_numeric($field))
		{
			$q = $this->db->get_where('characters_fields', array('field_name' => $field));
			$r = ($q->num_rows() > 0) ? $q->row() : false;

			$field = ($r !== false) ? $r->field_id : false;
		}

		$this->db->from('characters_data');
		$this->db->where('data_char', $character);
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();

		if ($value_only)
		{
			$row = ($query->num_rows() > 0) ? $query->row() : false;
			$retval = ($row !== false) ? $row->data_value : false;

			return $retval;
		}
		
		return $query;
	}
	
	public function get_user_characters($user = '', $type = 'active', $return = 'object')
	{
		$this->db->from('characters');
		$this->db->where('user', $user);
		
		if ( ! empty($type))
		{
			switch ($type)
			{
				case 'active':
				default:
					$string = "`crew_type` = 'active'";
				break;
					
				case 'inactive':
					$string = "`crew_type` = 'inactive'";
				break;
					
				case 'pending':
					$string = "`crew_type` = 'pending'";
				break;
					
				case 'npc':
					$string = "`crew_type` = 'npc'";
				break;
					
				case 'active_npc':
					$string = "`crew_type` = 'active' OR `crew_type` = 'npc'";
				break;
			}
			
			$this->db->where("($string)", NULL);
		}
		
		$query = $this->db->get();
		
		if ($return == 'object')
		{
			return $query;
		}
		else
		{
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $row)
				{
					$array[] = $row->charid;
				}
				
				return $array;
			}
		}
		
		return false;
	}
	
	public function get_rank_history($user = '')
	{
		$this->db->from('characters_promotions');
		$this->db->where('prom_user', $user);
		$this->db->order_by('prom_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function count_characters($type = 'active', $timeframe = 'current', $this_month = '', $last_month = '')
	{
		$this->db->from('characters');
		
		if ( ! empty($timeframe))
		{
			if ($timeframe == 'current')
			{
				if ( ! empty($type))
				{
					$this->db->where('crew_type', $type);
				}
			}
			elseif ($timeframe == 'previous')
			{
				$this->db->where('date_activate <', $this_month);
				$this->db->where('crew_type', $type);
				
				$this->db->or_where('date_deactivate >', $last_month);
				$this->db->where('date_deactivate <', $this_month);
				
				if ($type == 'npc')
				{
					$this->db->where('crew_type', 'npc');
				}
			}
		}
		else
		{
			if ( ! empty($type))
			{
				$this->db->where('crew_type', $type);
			}
		}
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function add_bio_field($data = '')
	{
		$query = $this->db->insert('characters_fields', $data);
		
		return $query;
	}
	
	public function add_bio_field_data($data = '')
	{
		$query = $this->db->insert('characters_data', $data);
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function add_bio_field_value($data = '')
	{
		$query = $this->db->insert('characters_values', $data);
		
		return $query;
	}
	
	public function add_bio_sec($data = '')
	{
		$query = $this->db->insert('characters_sections', $data);
		
		$this->dbutil->optimize_table('characters_sections');
		
		return $query;
	}
	
	public function add_bio_tab($data = '')
	{
		$query = $this->db->insert('characters_tabs', $data);
		
		$this->dbutil->optimize_table('characters_tabs');
		
		return $query;
	}
	
	public function create_character($data = '')
	{
		$query = $this->db->insert('characters', $data);
		
		return $query;
	}
	
	public function create_character_data_fields($character = 0, $user = 0)
	{
		$get = $this->db->get_where('characters_fields', array('field_display' => 'y'));
		
		if ($get->num_rows() > 0)
		{
			foreach ($get->result() as $row)
			{
				$data = array(
					'data_field' => $row->field_id,
					'data_char' => $character,
					'data_user' => $user,
					'data_value' => '',
					'data_updated' => now()
				);
				
				$insert = $this->db->insert('characters_data', $data);
			}
			
			$this->dbutil->optimize_table('characters_data');
			
			return $insert;
		}
		
		return false;
	}
	
	public function create_character_data($data = '')
	{
		$query = $this->db->insert('characters_data', $data);
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function create_coc_entry($data = '')
	{
		$query = $this->db->insert('coc', $data);
		
		$this->dbutil->optimize_table('coc');
		
		return $query;
	}
	
	public function create_promotion_record($data = '')
	{
		$query = $this->db->insert('characters_promotions', $data);
		
		$this->dbutil->optimize_table('characters_promotions');
		
		return $query;
	}
	
	public function update_bio_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('characters_fields', $data);
		
		$this->dbutil->optimize_table('characters_fields');
		
		return $query;
	}
	
	public function update_bio_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('characters_values', $data);
		
		$this->dbutil->optimize_table('characters_values');
		
		return $query;
	}
	
	public function update_bio_section($id = '', $data = '')
	{
		$this->db->where('section_id', $id);
		$query = $this->db->update('characters_sections', $data);
		
		$this->dbutil->optimize_table('characters_sections');
		
		return $query;
	}
	
	public function update_bio_tab($id = '', $data = '')
	{
		$this->db->where('tab_id', $id);
		$query = $this->db->update('characters_tabs', $data);
		
		$this->dbutil->optimize_table('characters_tabs');
		
		return $query;
	}
	
	public function update_character($id = '', $data = '')
	{
		$this->db->where('charid', $id);
		$query = $this->db->update('characters', $data);
		
		$this->dbutil->optimize_table('characters');
		
		return $query;
	}
	
	public function update_character_data($field = '', $character = '', $data = '')
	{
		// find the record first
		$this->db->from('characters_data');
		$this->db->where('data_field', $field);
		$this->db->where('data_char', $character);
		$find = $this->db->get();
		
		// if there isn't a record, create it
		if ($find->num_rows() == 0)
		{
			$query = $this->create_character_data($data);
		}
		else
		{
			$this->db->where('data_field', $field);
			$this->db->where('data_char', $character);
			$query = $this->db->update('characters_data', $data);
		}
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function update_character_data_all($id = '', $identifier = 'data_user', $data = '')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('characters_data', $data);
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function update_field_sections($old_id = '', $new_id = '')
	{
		$data = array('field_section' => $new_id);
		
		$this->db->where('field_section', $old_id);
		$query = $this->db->update('characters_fields', $data);
		
		$this->dbutil->optimize_table('characters_fields');
		
		return $query;
	}
	
	public function update_section_tabs($old_id = '', $new_id = '')
	{
		$data = array('section_tab' => $new_id);
		
		$this->db->where('section_tab', $old_id);
		$query = $this->db->update('characters_sections', $data);
		
		$this->dbutil->optimize_table('characters_sections');
		
		return $query;
	}
	
	public function delete_bio_field($id = '')
	{
		$query = $this->db->delete('characters_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('characters_fields');
		
		return $query;
	}
	
	public function delete_bio_field_value($id = '')
	{
		$query = $this->db->delete('characters_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('characters_values');
		
		return $query;
	}
	
	public function delete_bio_section($id = '')
	{
		$query = $this->db->delete('characters_sections', array('section_id' => $id));
		
		$this->dbutil->optimize_table('characters_sections');
		
		return $query;
	}
	
	public function delete_bio_tab($id = '')
	{
		$query = $this->db->delete('characters_tabs', array('tab_id' => $id));
		
		$this->dbutil->optimize_table('characters_tabs');
		
		return $query;
	}
	
	public function delete_character($id = '')
	{
		$query = $this->db->delete('characters', array('charid' => $id));
		
		$this->dbutil->optimize_table('characters');
		
		return $query;
	}
	
	public function delete_character_data($id = '', $identifier = '')
	{
		$query = $this->db->delete('characters_data', array($identifier => $id));
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function delete_character_field_data($field = '')
	{
		$query = $this->db->delete('characters_data', array('data_field' => $field));
		
		$this->dbutil->optimize_table('characters_data');
		
		return $query;
	}
	
	public function delete_coc_entry($id = '')
	{
		$query = $this->db->delete('coc', array('coc_crew' => $id));
		
		$this->dbutil->optimize_table('coc');
		
		return $query;
	}
	
	public function empty_coc()
	{
		$query = $this->db->truncate('coc');
		
		$this->dbutil->optimize_table('coc');
		
		return $query;
	}
}
