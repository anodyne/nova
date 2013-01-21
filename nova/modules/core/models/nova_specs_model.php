<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Specs model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_specs_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	/**
	 * Get spec field data.
	 *
	 * @since	2.2
	 * @param	int		The spec ID
	 * @param	mixed	The field ID or field_name field
	 * @param	bool	Whether to return only the value or the entire object
	 * @return	mixed
	 */
	public function get_field_data($id = 0, $field = '', $value_only = false)
	{
		if ( ! is_numeric($field))
		{
			$q = $this->db->get_where('specs_fields', array('field_name' => $field));
			$r = ($q->num_rows() > 0) ? $q->row() : false;

			$field = ($r !== false) ? $r->field_id : false;
		}

		$this->db->from('specs_data');
		$this->db->where('data_item', $id);
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
	
	public function get_spec_field_details($id = '')
	{
		$query = $this->db->get_where('specs_fields', array('field_id' => $id));
		
		return $query;
	}
	
	public function get_spec_fields($section = '', $display = 'y', $type = '')
	{
		$this->db->from('specs_fields');
		
		if ( ! empty($section))
		{
			$this->db->where('field_section', $section);
		}
		
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
	
	public function get_spec_item($id = '')
	{
		$this->db->from('specs');
		$this->db->where('specs_id', $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	public function get_spec_items($display = 'y')
	{
		$this->db->from('specs');
		
		if ( ! empty($display))
		{
			$this->db->where('specs_display', $display);
		}
		
		$this->db->order_by('specs_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_spec_section_details($id = '')
	{
		$query = $this->db->get_where('specs_sections', array('section_id' => $id));
		
		return $query;
	}
	
	public function get_spec_sections()
	{
		$this->db->from('specs_sections');
		$this->db->order_by('section_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_spec_value_details($id = '')
	{
		$query = $this->db->get_where('specs_values', array('value_id' => $id));
		
		return $query;
	}
	
	public function get_spec_values($field = '')
	{
		$this->db->from('specs_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Count all specification items.
	 *
	 * @access	public
	 * @since	2.0
	 * @return	int		the number of items
	 */
	public function count_spec_items()
	{
		$this->db->from('specs');
		
		return $this->db->count_all_results();
	}
	
	public function add_spec_field($data = '')
	{
		$query = $this->db->insert('specs_fields', $data);
		
		return $query;
	}
	
	public function add_spec_field_data($data = '')
	{
		$query = $this->db->insert('specs_data', $data);
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	public function add_spec_field_value($data = '')
	{
		$query = $this->db->insert('specs_values', $data);
		
		return $query;
	}
	
	public function add_spec_item($data = '')
	{
		$query = $this->db->insert('specs', $data);
		
		return $query;
	}
	
	public function add_spec_section($data = '')
	{
		$query = $this->db->insert('specs_sections', $data);
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
	
	public function update_field_sections($old_id = '', $new_id = '')
	{
		$data = array('field_section' => $new_id);
		
		$this->db->where('field_section', $old_id);
		$query = $this->db->update('specs_fields', $data);
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	/**
	 * Update the specification data. This involves a check to make sure the data
	 * exists first. If it does, we update the record, if it doesn't, we create
	 * the new data record.
	 *
	 * @access	public
	 * @param	integer	the item ID
	 * @param	integer	the field ID
	 * @param	array 	the data array to update the field with
	 * @return	object	a result object
	 */
	public function update_spec_data($id = '', $field = '', $data = '')
	{
		$this->db->from('specs_data')
			->where('data_item', $id)
			->where('data_field', $field);
		$count = $this->db->count_all_results();
		
		if ($count > 0)
		{
			$this->db->where('data_item', $id)
				->where('data_field', $field);
			$query = $this->db->update('specs_data', $data);
		}
		else
		{
			$data['data_item'] = $id;
			$data['data_field'] = $field;
			
			$query = $this->add_spec_field_data($data);
		}
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	public function update_spec_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('specs_fields', $data);
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	public function update_spec_field_data($id = '', $data = '', $identifier = 'data_id')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('specs_data', $data);
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	public function update_spec_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('specs_values', $data);
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	public function update_spec_item($id = '', $data = '')
	{
		$this->db->where('specs_id', $id);
		$query = $this->db->update('specs', $data);
		
		$this->dbutil->optimize_table('specs');
		
		return $query;
	}
	
	public function update_spec_section($id = '', $data = '')
	{
		$this->db->where('section_id', $id);
		$query = $this->db->update('specs_sections', $data);
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
	
	public function delete_spec_field($id = '')
	{
		$query = $this->db->delete('specs_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	public function delete_spec_field_data($value = '', $identifier = 'data_field')
	{
		$query = $this->db->delete('specs_data', array($identifier => $value));
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	public function delete_spec_field_value($id = '')
	{
		$query = $this->db->delete('specs_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	public function delete_spec_item($id = '')
	{
		$query = $this->db->delete('specs', array('specs_id' => $id));
		
		$this->dbutil->optimize_table('specs');
		
		return $query;
	}
	
	public function delete_spec_section($id = '')
	{
		$query = $this->db->delete('specs_sections', array('section_id' => $id));
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
}
