<?php
/*
|---------------------------------------------------------------
| SETTINGS MODEL
|---------------------------------------------------------------
|
| File: models/base/settings_model.php
| System Version: 1.0
|
| Model used to access the config table and pull the system global
| variables for use by the controllers and views.
|
*/

class Settings_model_base extends Model {

	function Settings_model_base()
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
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_setting($field = '', $data = '', $identifier = 'setting_key')
	{
		$this->db->where($identifier, $field);
		$query = $this->db->update('settings', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_new_setting($data = '')
	{
		$query = $this->db->insert('settings', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('settings');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
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

/* End of file settings_model.php */
/* Location: ./application/models/base/settings_model.php */