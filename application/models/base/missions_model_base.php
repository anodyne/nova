<?php
/*
|---------------------------------------------------------------
| MISSIONS MODEL
|---------------------------------------------------------------
|
| File: models/missions_model_base.php
| System Version: 1.0
|
| Model used to access the missions table
|
*/

class Missions_model_base extends Model {

	function Missions_model_base()
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
	
	function get_all_missions($status = '')
	{
		$this->db->from('missions');
		
		if (!empty($status))
		{
			$this->db->where('mission_status', $status);
		}
		
		$this->db->order_by('mission_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_mission($id = '', $return = '')
	{
		$query = $this->db->get_where('missions', array('mission_id' => $id));
		
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
	
	function add_mission($data = '')
	{
		$query = $this->db->insert('missions', $data);
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_mission($id = '', $data = '')
	{
		$this->db->where('mission_id', $id);
		$query = $this->db->update('missions', $data);
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_mission($id = '')
	{
		$query = $this->db->delete('missions', array('mission_id' => $id));
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
}

/* End of file missions_model_base.php */
/* Location: ./application/models/base/missions_model_base.php */