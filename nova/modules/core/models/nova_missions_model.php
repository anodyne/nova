<?php
/**
 * Missions model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		2.0
 */

abstract class Nova_missions_model extends Model {

	public function __construct()
	{
		parent::Model();
		
		$this->load->dbutil();
	}
	
	/**
	 * Get all mission groups.
	 *
	 * @access	public
	 * @param	int		the mission group parent ID, empty for all groups
	 * @return	object
	 */
	public function get_all_mission_groups($parent = 0)
	{
		$this->db->from('mission_groups');
		
		if (is_numeric($parent))
		{
			$this->db->where('misgroup_parent', $parent);
		}
		
		$this->db->order_by('misgroup_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_all_missions($status = '')
	{
		$this->db->from('missions');
		
		if ( ! empty($status))
		{
			$this->db->where('mission_status', $status);
		}
		
		$this->db->order_by('mission_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_mission($id = '', $return = '')
	{
		$query = $this->db->get_where('missions', array('mission_id' => $id));
		
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
	
	public function get_mission_group($id = '', $return = '')
	{
		$query = $this->db->get_where('mission_groups', array('misgroup_id' => $id));
		
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
	
	public function get_mission_where($where = array(), $display = 'count')
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
	
	public function add_mission($data = '')
	{
		$query = $this->db->insert('missions', $data);
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	public function add_mission_group($data = '')
	{
		$query = $this->db->insert('mission_groups', $data);
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
	
	public function update_mission($id = '', $data = '', $where = '')
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
	
	public function update_mission_group($id = '', $data = '')
	{
		$this->db->where('misgroup_id', $id);
		$query = $this->db->update('mission_groups', $data);
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
	
	public function delete_mission($id = '')
	{
		$query = $this->db->delete('missions', array('mission_id' => $id));
		
		$this->dbutil->optimize_table('missions');
		
		return $query;
	}
	
	/**
	 * Delete a mission group, making sure to update the missions table so that
	 * we don't have any orphan missions.
	 *
	 * @access	public
	 * @uses	Missions_model::update_mission
	 * @param	int		the mission group ID
	 * @return	int		the number of affected rows
	 */
	public function delete_mission_group($id = '')
	{
		// update all missions that are part of the group
		$this->update_mission(null, array('mission_group' => 0), array('mission_group' => $id));
		
		// delete the mission group
		$query = $this->db->delete('mission_groups', array('misgroup_id' => $id));
		
		$this->dbutil->optimize_table('mission_groups');
		
		return $query;
	}
}
