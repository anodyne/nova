<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Settings model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_settings_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_settings($user = 'n')
	{
		$this->db->from('settings');
		$this->db->where('setting_user_created', $user);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_setting($value = '')
	{
		$query = $this->db->get_where('settings', array('setting_key' => $value));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->setting_value;
		}
		
		return false;
	}
	
	public function get_setting_details($value = '', $identifier = 'setting_key')
	{
		$query = $this->db->get_where('settings', array($identifier => $value));
		
		return $query;
	}
	
	public function get_setting_label($value = '', $identifier = 'setting_key')
	{
		$query = $this->db->get_where('settings', array($identifier => $value));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->setting_label;
		}
		
		return false;
	}
	
	public function get_settings($value = '')
	{
		$array = false;
		
		if (is_array($value))
		{
			$select = $value;
		}
		else
		{
			$select[] = $value;
		}
		
		$query = $this->db->get('settings');
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				if (in_array($item->setting_key, $select))
				{
					$array[$item->setting_key] = $item->setting_value;
				}
			}
		}
		
		return $array;
	}
	
	public function get_sim_types($start_id = 2)
	{
		$this->db->from('sim_type');
		$this->db->where('simtype_id >=', $start_id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_new_setting($data = '')
	{
		$query = $this->db->insert('settings', $data);
		
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	/**
	 * Update a single setting
	 *
	 * @access	public
	 * @param	string	the key to update
	 * @param	array 	an array of data to use in updating the record
	 * @param	string	the name of the identifer to use
	 * @return	integer	the number of affected rows (1 = success, 0 = failure)
	 */
	public function update_setting($field = '', $data = '', $identifier = 'setting_key')
	{
		$this->db->where($identifier, $field);
		$query = $this->db->update('settings', $data);
		
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	public function delete_setting($id = '')
	{
		$query = $this->db->delete('settings', array('setting_id' => $id));
		
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
}
