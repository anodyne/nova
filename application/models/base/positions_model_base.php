<?php
/*
|---------------------------------------------------------------
| POSITIONS MODEL
|---------------------------------------------------------------
|
| File: models/positions_model_base.php
| System Version: 1.0
|
| Model used to access the positions table
|
*/

class Positions_model_base extends Model {

	function Positions_model_base()
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
	
	function get_all_positions($sort = 'asc', $display = 'y')
	{
		$this->db->from('positions_'. GENRE);
		
		if (!empty($display))
		{
			$this->db->where('pos_display', $display);
		}
		
		$this->db->order_by('pos_order', $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_dept_positions($dept = '', $display = 'y', $return = 'object')
	{
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_dept', $dept);
		
		if (!empty($display))
		{
			$this->db->where('pos_display', $display);
		}
		
		$this->db->order_by('pos_order', 'asc');
		
		$query = $this->db->get();
		
		if ($return == 'object')
		{
			return $query;
		}
		else
		{
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $p)
				{
					$array[] = $p->pos_id;
				}
				
				return $array;
			}
		}
		
		return FALSE;
	}
	
	function get_open_positions($display = 'y')
	{
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_open >', 0);
		$this->db->where('pos_display', $display);
		$this->db->order_by('pos_dept', 'asc');
		$this->db->order_by('pos_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_position($id = '', $return = '')
	{
		$query = $this->db->get_where('positions_'. GENRE, array('pos_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		if (!empty($return) && $row !== FALSE)
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
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_position($data = '')
	{
		$query = $this->db->insert('positions_'. GENRE, $data);
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_open_slots($position = '', $direction = '')
	{
		$this->db->select('pos_open');
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_id', $position);
		
		$get = $this->db->get();
		
		if ($get->num_rows() > 0)
		{
			$open = $get->row();
			
			$new_num = ($direction == 'add_crew') ? $open->pos_open - 1 : $open->pos_open + 1;
			$new_num = ($new_num < 0) ? 0 : $new_num;
			
			$data = array('pos_open' => $new_num);
			
			$this->db->where('pos_id', $position);
			$query = $this->db->update('positions_'. GENRE, $data);
			
			$this->dbutil->optimize_table('positions_'. GENRE);
			
			return $query;
		}
		
		return FALSE;
	}
	
	function update_position($position = '', $data = '')
	{
		$this->db->where('pos_id', $position);
		$query = $this->db->update('positions_'. GENRE, $data);
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_position($id = '')
	{
		$query = $this->db->delete('positions_'. GENRE, array('pos_id' => $id));
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
}

/* End of file positions_model_base.php */
/* Location: ./application/models/base/positions_model_base.php */