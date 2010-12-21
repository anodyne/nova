<?php
/**
 * Tour model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.2
 *
 * Fixed bug from 1.1 update where you couldn't have a deck listing for
 * each specification item you've created
 */

class Tour_model_base extends Model {

	function Tour_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function get_deck_details($id = '')
	{
		$query = $this->db->get_where('tour_decks', array('deck_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_decks($item = '')
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
	
	function get_tour_data($item = '', $field = '')
	{
		$this->db->from('tour_data');
		$this->db->where('data_tour_item', $item);
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return FALSE;
	}
	
	function get_tour_field_details($id = '')
	{
		$query = $this->db->get_where('tour_fields', array('field_id' => $id));
		
		return $query;
	}
	
	function get_tour_fields($display = 'y', $type = '')
	{
		$this->db->from('tour_fields');
		
		if (!empty($display))
		{
			$this->db->where('field_display', $display);
		}
		
		if (!empty($type))
		{
			$this->db->where('field_type', $type);
		}
		
		$this->db->order_by('field_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_tour_item($id = '')
	{
		$this->db->from('tour');
		$this->db->where('tour_id', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_tour_items($display = 'y')
	{
		$this->db->from('tour');
		
		if (!empty($display))
		{
			$this->db->where('tour_display', $display);
		}
		
		$this->db->order_by('tour_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_tour_value_details($id = '')
	{
		$query = $this->db->get_where('tour_values', array('value_id' => $id));
		
		return $query;
	}
	
	function get_tour_values($field = '')
	{
		$this->db->from('tour_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Create methods
	 */
	
	function add_deck($data = '')
	{
		$query = $this->db->insert('tour_decks', $data);
		
		return $query;
	}
	
	function add_tour_field($data = '')
	{
		$query = $this->db->insert('tour_fields', $data);
		
		return $query;
	}
	
	function add_tour_field_data($data = '')
	{
		$query = $this->db->insert('tour_data', $data);
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	function add_tour_field_value($data = '')
	{
		$query = $this->db->insert('tour_values', $data);
		
		return $query;
	}
	
	function add_tour_item($data = '')
	{
		$query = $this->db->insert('tour', $data);
		
		return $query;
	}
	
	/**
	 * Update methods
	 */
	
	function update_deck($id = '', $data = '')
	{
		$this->db->where('deck_id', $id);
		$query = $this->db->update('tour_decks', $data);
		
		$this->dbutil->optimize_table('tour_decks');
		
		return $query;
	}
	
	function update_tour_data($id = '', $field = '', $data = '')
	{
		$this->db->where('data_tour_item', $id);
		$this->db->where('data_field', $field);
		$query = $this->db->update('tour_data', $data);
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	function update_tour_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('tour_fields', $data);
		
		$this->dbutil->optimize_table('tour_fields');
		
		return $query;
	}
	
	function update_tour_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('tour_values', $data);
		
		$this->dbutil->optimize_table('tour_values');
		
		return $query;
	}
	
	function update_tour_item($id = '', $data = '')
	{
		$this->db->where('tour_id', $id);
		$query = $this->db->update('tour', $data);
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	/**
	 * Delete methods
	 */
	
	function delete_deck($id = '')
	{
		$query = $this->db->delete('tour_decks', array('deck_id' => $id));
		
		$this->dbutil->optimize_table('tour_decks');
		
		return $query;
	}
	
	function delete_tour_field($id = '')
	{
		$query = $this->db->delete('tour_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('tour_fields');
		
		return $query;
	}
	
	function delete_tour_field_data($value = '', $identifier = 'data_field')
	{
		$query = $this->db->delete('tour_data', array($identifier => $value));
		
		$this->dbutil->optimize_table('tour_data');
		
		return $query;
	}
	
	function delete_tour_item($id = '')
	{
		$query = $this->db->delete('tour', array('tour_id' => $id));
		
		$this->dbutil->optimize_table('tour');
		
		return $query;
	}
	
	function delete_tour_value($id = '')
	{
		$query = $this->db->delete('tour_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('tour_values');
		
		return $query;
	}
}
