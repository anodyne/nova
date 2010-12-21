<?php
/**
 * Settings model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.0
 */

class Settings_model_base extends Model {

	function Settings_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function get_all_settings($user = 'n')
	{
		$this->db->from('settings');
		$this->db->where('setting_user_created', $user);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_setting($value = '')
	{
		$query = $this->db->get_where('settings', array('setting_key' => $value));
		
		if ($query->num_rows() > 0)
		{ /* if there is at least 1 row in the result */
			$row = $query->row();
			
			return $row->setting_value;
		}
		
		return FALSE;
	}
	
	function get_setting_details($value = '', $identifier = 'setting_key')
	{
		$query = $this->db->get_where('settings', array($identifier => $value));
		
		return $query;
	}
	
	function get_setting_label($value = '', $identifier = 'setting_key')
	{
		$query = $this->db->get_where('settings', array($identifier => $value));
		
		if ($query->num_rows() > 0)
		{ /* if there is at least 1 row in the result */
			$row = $query->row();
			
			return $row->setting_label;
		}
		
		return FALSE;
	}
	
	function get_settings($value = '')
	{
		$array = FALSE;
		
		if (is_array($value))
		{ /* if the value is array, do nothing */
			$select = $value;
		}
		else
		{ /* otherwise, we need to set the string as an array value */
			$select[] = $value;
		}
		
		/* grab all the global items */
		$query = $this->db->get('settings');
		
		if ($query->num_rows() > 0)
		{ /* if there is at least 1 row in the result */
			foreach ($query->result() as $item)
			{
				if (in_array($item->setting_key, $select))
				{ /* if the key is in the array of keys we want, drop it in an array */
					$array[$item->setting_key] = $item->setting_value;
				}
			}
		}
		
		/* return the final settings array */
		return $array;
	}
	
	function get_sim_types($start_id = 2)
	{
		$this->db->from('sim_type');
		$this->db->where('simtype_id >=', $start_id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Create methods
	 */
	
	function add_new_setting($data = '')
	{
		$query = $this->db->insert('settings', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	/**
	 * Update methods
	 */
	
	function update_setting($field = '', $data = '', $identifier = 'setting_key')
	{
		$this->db->where($identifier, $field);
		$query = $this->db->update('settings', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	/**
	 * Delete methods
	 */
	
	function delete_setting($id = '')
	{
		/* build the query */
		$query = $this->db->delete('settings', array('setting_id' => $id));
		
		/* optimize the table */
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
}
