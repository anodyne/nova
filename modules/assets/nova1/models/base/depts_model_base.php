<?php
/*
|---------------------------------------------------------------
| DEPARTMENTS MODEL
|---------------------------------------------------------------
|
| File: models/base/depts_model.php
| System Version: 1.0
|
| Model used to access the ranks table
|
*/

class Depts_model_base extends Model {

	function Depts_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/*
	|---------------------------------------------------------------
	| GET METHODS
	|---------------------------------------------------------------
	*/
	
	function get_all_depts($sort = 'asc', $display = 'y', $parent = 0, $sort_col = 'dept_order')
	{
		$this->db->from('departments_'. GENRE);
		
		if ($parent == 0)
		{
			$this->db->where('dept_parent', 0);
		}
		
		if (!empty($display))
		{
			$this->db->where('dept_display', $display);
		}
		
		$this->db->order_by($sort_col, $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_dept($id = '', $return = '')
	{
		$query = $this->db->get_where('departments_'. GENRE, array('dept_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if (!empty($return) && $row !== false)
		{
			if (!is_array($return))
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
	
	function get_sub_depts($dept = '', $sort = 'asc', $display = 'y')
	{
		$this->db->from('departments_'. GENRE);
		$this->db->where('dept_parent', $dept);
		
		if (!empty($display))
		{
			$this->db->where('dept_display', $display);
		}
		
		$this->db->order_by('dept_order', $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_dept($data = '')
	{
		$query = $this->db->insert('departments_'. GENRE, $data);
		
		$this->dbutil->optimize_table('departments_'. GENRE);
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_dept($dept = '', $data = '')
	{
		$this->db->where('dept_id', $dept);
		$query = $this->db->update('departments_'. GENRE, $data);
		
		$this->dbutil->optimize_table('departments_'. GENRE);
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_dept($id = '')
	{
		$query = $this->db->delete('departments_'. GENRE, array('dept_id' => $id));
		
		$this->dbutil->optimize_table('departments_'. GENRE);
		
		return $query;
	}
}

/* End of file depts_model.php */
/* Location: ./application/models/base/depts_model.php */