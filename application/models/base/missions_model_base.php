<?php
/**
 * Missions model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.0
 */

class Missions_model_base extends Model {

	function Missions_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function get_all_mission_groups()
	{
		$this->db->from('mission_groups');
		$this->db->order_by('misgroup_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
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
	
	function get_mission_group($id = '', $return = '')
	{
		$query = $this->db->get_where('mission_groups', array('misgroup_id' => $id));
		
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
	
	function get_mission_where($where = array(), $display = 'count')
	{
		$this->db->from('missions');
		
		foreach ($where as $key => $value)
		{
			$this->db->where($key, $value);
		}
		
		$query = $this->db->get();
		
		if ($display == 'count')
		{
			return $query->num_rows();
		}
		
		return $query;
	}
	
	/**
	 * Create methods
	 */
	
	function add_mission($data = '')
	{
		$query = $this->db->insert('missions', $data);
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	function add_mission_group($data = '')
	{
		$query = $this->db->insert('mission_groups', $data);
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
	
	/**
	 * Update methods
	 */
	
	function update_mission($id = '', $data = '', $where = '')
	{
		if (is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		else
		{
			$this->db->where('mission_id', $id);
		}
		
		$query = $this->db->update('missions', $data);
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	function update_mission_group($id = '', $data = '')
	{
		$this->db->where('misgroup_id', $id);
		$query = $this->db->update('mission_groups', $data);
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
	
	/**
	 * Delete methods
	 */
	
	function delete_mission($id = '')
	{
		$query = $this->db->delete('missions', array('mission_id' => $id));
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	function delete_mission_group($id = '')
	{
		$query = $this->db->delete('mission_groups', array('misgroup_id' => $id));
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
}
