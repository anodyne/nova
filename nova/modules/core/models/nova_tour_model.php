<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Tour model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_tour_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_deck_details($id = '')
	{
		$query = $this->db->get_where('tour_decks', array('deck_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	public function get_decks($item = '')
	{
		$this->db->from('tour_decks');
		
		if ( ! empty($item))
		{
			$this->db->where('deck_item', $item);
		}
		
		$this->db->order_by('deck_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get tour field data.
	 *
	 * @since	2.2
	 * @param	int		The tour item ID
	 * @param	mixed	The field ID or field_name field
	 * @param	bool	Whether to return only the value or the entire object
	 * @return	mixed
	 */
	public function get_tour_data($item = '', $field = '', $value_only = false)
	{
		if ( ! is_numeric($field))
		{
			$q = $this->db->get_where('tour_fields', array('field_name' => $field));
			$r = ($q->num_rows() > 0) ? $q->row() : false;

			$field = ($r !== false) ? $r->field_id : false;
		}

		$this->db->from('tour_data');
		$this->db->where('data_tour_item', $item);
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();

			if ($value_only)
			{
				return $row->data_value;
			}

			return $row;
		}
		
		return false;
	}
	
	public function get_tour_field_details($id = '')
	{
		$query = $this->db->get_where('tour_fields', array('field_id' => $id));
		
		return $query;
	}
	
	public function get_tour_fields($display = 'y', $type = '')
	{
		$this->db->from('tour_fields');
		
		if ( ! empty($display))
		{
			$this->db->where('field_display', $display);
		}
		
		if ( ! empty($type))
		{
			$this->db->where('field_type', $type);
		}
		
		$this->db->order_by('field_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_tour_item($id = '')
	{
		$this->db->from('tour');
		$this->db->where('tour_id', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_tour_items($display = 'y')
	{
		$this->db->from('tour');
		
		if ( ! empty($display))
		{
			$this->db->where('tour_display', $display);
		}
		
		$this->db->order_by('tour_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_tour_value_details($id = '')
	{
		$query = $this->db->get_where('tour_values', array('value_id' => $id));
		
		return $query;
	}
	
	public function get_tour_values($field = '')
	{
		$this->db->from('tour_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Find the number of unique deck items in the database.
	 *
	 * @access	public
	 * @since	2.0
	 * @return	int		the number of deck items
	 */
	public function count_deck_items()
	{
		$this->db->from('tour_decks');
		$this->db->group_by('deck_item');
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function add_deck($data = '')
	{
		$query = $this->db->insert('tour_decks', $data);
		
		return $query;
	}
	
	public function add_tour_field($data = '')
	{
		$query = $this->db->insert('tour_fields', $data);
		
		return $query;
	}
	
	public function add_tour_field_data($data = '')
	{
		$query = $this->db->insert('tour_data', $data);
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	public function add_tour_field_value($data = '')
	{
		$query = $this->db->insert('tour_values', $data);
		
		return $query;
	}
	
	public function add_tour_item($data = '')
	{
		$query = $this->db->insert('tour', $data);
		
		return $query;
	}
	
	public function update_deck($id = '', $data = '')
	{
		$this->db->where('deck_id', $id);
		$query = $this->db->update('tour_decks', $data);
		
		$this->dbutil->optimize_table('tour_decks');
		
		return $query;
	}
	
	public function update_tour_data($id = '', $field = '', $data = '')
	{
		$this->db->where('data_tour_item', $id);
		$this->db->where('data_field', $field);
		$query = $this->db->update('tour_data', $data);
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	public function update_tour_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('tour_fields', $data);
		
		$this->dbutil->optimize_table('tour_fields');
		
		return $query;
	}
	
	public function update_tour_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('tour_values', $data);
		
		$this->dbutil->optimize_table('tour_values');
		
		return $query;
	}
	
	public function update_tour_item($id = '', $data = '')
	{
		$this->db->where('tour_id', $id);
		$query = $this->db->update('tour', $data);
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	public function delete_deck($id = '', $delete_all = false)
	{
		if ($delete_all === false)
		{
			$query = $this->db->delete('tour_decks', array('deck_id' => $id));
		}
		else
		{
			$query = $this->db->delete('tour_decks', array('deck_item' => $id));
		}
		
		$this->dbutil->optimize_table('tour_decks');
		
		return $query;
	}
	
	public function delete_tour_field($id = '')
	{
		$query = $this->db->delete('tour_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('tour_fields');
		
		return $query;
	}
	
	public function delete_tour_field_data($value = '', $identifier = 'data_field')
	{
		$query = $this->db->delete('tour_data', array($identifier => $value));
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	public function delete_tour_item($id = '')
	{
		$query = $this->db->delete('tour', array('tour_id' => $id));
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	public function delete_tour_value($id = '')
	{
		$query = $this->db->delete('tour_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('tour_values');
		
		return $query;
	}
}
