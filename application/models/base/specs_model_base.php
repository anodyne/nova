<?php
/*
|---------------------------------------------------------------
| SPECS MODEL
|---------------------------------------------------------------
|
| File: models/specs_model_base.php
| System Version: 1.0
|
| Model used to access the specs tables.
|
*/

class Specs_model_base extends Model {

	function Specs_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/*
	|---------------------------------------------------------------
	| RETRIEVE METHODS
	|---------------------------------------------------------------
	*/
	
	function get_spec_sections()
	{
		$this->db->from('specs_sections');
		$this->db->order_by('section_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_spec_section_details($id = '')
	{
		$query = $this->db->get_where('specs_sections', array('section_id' => $id));
		
		return $query;
	}
	
	function get_spec_fields($section = '', $display = 'y', $type = '')
	{
		$this->db->from('specs_fields');
		
		if (!empty($section))
		{
			$this->db->where('field_section', $section);
		}
		
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
	
	function get_spec_field_details($id = '')
	{
		$query = $this->db->get_where('specs_fields', array('field_id' => $id));
		
		return $query;
	}
	
	function get_spec_values($field = '')
	{
		$this->db->from('specs_values');
		$this->db->where('value_field', $field);
		$this->db->order_by('value_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_spec_value_details($id = '')
	{
		$query = $this->db->get_where('specs_values', array('value_id' => $id));
		
		return $query;
	}
	
	function get_field_data($field = '')
	{
		$this->db->from('specs_data');
		$this->db->where('data_field', $field);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_spec_field($data = '')
	{
		$query = $this->db->insert('specs_fields', $data);
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	function add_spec_field_value($data = '')
	{
		$query = $this->db->insert('specs_values', $data);
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	function add_spec_field_data($data = '')
	{
		$query = $this->db->insert('specs_data', $data);
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	function add_spec_section($data = '')
	{
		$query = $this->db->insert('specs_sections', $data);
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_spec_field_data($field = '')
	{
		$query = $this->db->delete('specs_data', array('data_field' => $field));
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
	
	function delete_spec_field($id = '')
	{
		$query = $this->db->delete('specs_fields', array('field_id' => $id));
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	function delete_spec_value($id = '')
	{
		$query = $this->db->delete('specs_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	function delete_spec_section($id = '')
	{
		$query = $this->db->delete('specs_sections', array('section_id' => $id));
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
	
	function delete_spec_field_value($id = '')
	{
		$query = $this->db->delete('specs_values', array('value_id' => $id));
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_spec_field($id = '', $data = '')
	{
		$this->db->where('field_id', $id);
		$query = $this->db->update('specs_fields', $data);
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	function update_spec_field_value($id = '', $data = '')
	{
		$this->db->where('value_id', $id);
		$query = $this->db->update('specs_values', $data);
		
		$this->dbutil->optimize_table('specs_values');
		
		return $query;
	}
	
	function update_field_sections($old_id = '', $new_id = '')
	{
		$data = array('field_section' => $new_id);
		
		$this->db->where('field_section', $old_id);
		$query = $this->db->update('specs_fields', $data);
		
		$this->dbutil->optimize_table('specs_fields');
		
		return $query;
	}
	
	function update_spec_section($id = '', $data = '')
	{
		$this->db->where('section_id', $id);
		$query = $this->db->update('specs_sections', $data);
		
		$this->dbutil->optimize_table('specs_sections');
		
		return $query;
	}
	
	function update_spec_field_data($id = '', $data = '', $identifier = 'data_id')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('specs_data', $data);
		
		$this->dbutil->optimize_table('specs_data');
		
		return $query;
	}
}

/* End of file specs_model_base.php */
/* Location: ./application/models/base/specs_model_base.php */