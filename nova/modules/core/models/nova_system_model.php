<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * System model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_system_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function check_install_status()
	{
		$prefix = $this->db->dbprefix;
		
		$data = $this->db->list_tables();
		
		$prefix_len = strlen($prefix);
		
		foreach ($data as $key => $value)
		{
			if (substr($value, 0, $prefix_len) != $prefix)
			{
				unset($data[$key]);
			}
		}
		
		if (count($data) > 0)
		{
			return true;
		}
		
		return false;
	}
	
	public function get_all_skins()
	{
		$query = $this->db->get('catalogue_skins');
		
		return $query;
	}
	
	/**
	 * @deprecated
	 */
	public function get_all_system_components()
	{
		$this->db->from('system_components');
		$this->db->order_by('comp_id', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * @deprecated
	 */
	public function get_all_system_versions()
	{
		$this->db->from('system_versions');
		$this->db->order_by('version_id', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_ban($id = '', $return = '')
	{
		$query = $this->db->get_where('bans', array('ban_id' => $id));
		
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
	
	public function get_bans($level = '', $returnall = true)
	{
		$this->db->from('bans');
		
		if ( ! empty($level))
		{
			$this->db->where('ban_level', $level);
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			if ($returnall === true)
			{
				return $query->result();
			}
			else
			{
				$array = array();
				
				foreach ($query->result() as $q)
				{
					$array[] = $q->ban_ip;
				}
				
				return $array;
			}
		}
		
		return array();
	}
	
	public function get_current_version()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		foreach ($query->result() as $row)
		{
			$data = $row->system_version_complete;
		}
		
		return $data;
	}
	
	public function get_database_size()
	{
		$query = $this->db->query('SHOW TABLE STATUS');
		
		$dbsize = 0;
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$dbsize += $row->Data_length + $row->Index_length;
			}
		}
		
		return $dbsize;
	}
	
	public function get_item($table = '', $key = '', $id = '', $return = '')
	{
		$query = $this->db->get_where($table, array($key => $id));
		
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
	
	public function get_last_login_attempt($data = '', $field = 'login_email')
	{
		$this->db->from('login_attempts');
		$this->db->where($field, $data);
		$this->db->order_by('login_time', 'desc');
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	public function get_loa_records($limit = 0, $offset = 0)
	{
		$this->db->from('user_loa');
		$this->db->order_by('loa_start_date', 'desc');
		
		if ( ! empty($limit))
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_nova_uid()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->sys_uid;
		}
		
		return false;
	}
	
	public function get_preferences()
	{
		$query = $this->db->get('user_prefs');
		
		return $query;
	}
	
	public function get_security_questions()
	{
		$query = $this->db->get('security_questions');
		
		return $query;
	}
	
	public function get_sim_types()
	{
		$query = $this->db->get('sim_type');
		
		return $query;
	}
	
	public function get_skinsec_default($section = '')
	{
		$this->db->from('catalogue_skinsecs');
		$this->db->where('skinsec_section', $section);
		$this->db->where('skinsec_status', 'active');
		$this->db->where('skinsec_default', 'y');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->skinsec_skin;
		}
		
		return false;
	}
	
	public function get_skin_info($id = '', $field = 'skin_location')
	{
		$this->db->from('catalogue_skins');
		$this->db->where($field, $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	public function get_skin_name($id = '')
	{
		$query = $this->db->get_where('catalogue_skins', array('skin_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ($row !== false)
		{
			return $row->skin_name;
		}
		
		return $row;
	}
	
	public function get_skin_section_info($id = '', $field = 'skinsec_section')
	{
		$this->db->from('catalogue_skinsecs');
		$this->db->where($field, $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	public function get_skin_sections($id = '', $status = 'active')
	{
		$this->db->from('catalogue_skinsecs');
		
		if ( ! empty($id))
		{
			$this->db->where('skinsec_skin', $id);
		}
		
		if ( ! empty($status))
		{
			if ( ! is_array($status))
			{
				$status = array($status);
			}
			
			$count = count($status);
			
			$string = "";
			
			for ($i=0; $i < $count; $i++)
			{
				if ($i > 0)
				{
					$or = " OR ";
				}
				else
				{
					$or = "";
				}
				
				$string.= $or . "skinsec_status LIKE '$status[$i]'";
			}
			
			$this->db->where("($string)", null);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_skinsec($where = '')
	{
		$this->db->from('catalogue_skinsecs');
		
		foreach ($where as $key => $value)
		{
			$this->db->where($key, $value);
		}
		
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	/**
	 * Pull all of the skins for a given section.
	 *
	 * @access	public
	 * @since	2.0
	 * @param	string	the section
	 * @return	mixed	an array of result objects or FALSE if there are no results
	 */
	public function get_skins_by_section($section)
	{
		$query = $this->db->get_where('catalogue_skinsecs', array('skinsec_section' => $section));
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$skin = $this->get_skin_info($row->skinsec_skin);
				$sections[] = $skin;
			}
			
			return $sections;
		}
		
		return false;
	}
	
	public function get_system_info()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return false;
	}
	
	public function get_uploaded_images($type = '')
	{
		$this->db->from('uploads');
		
		if ( ! empty($type))
		{
			$this->db->where('upload_resource_type', $type);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get a list of a tables columns. While CI's database driver is capable of
	 * doing this, there's currently no way to actually strip the prefix name
	 * off so that we can use the sms_ prefix without creating a whole new
	 * database config group.
	 *
	 * @access	public
	 * @since	2.0
	 * @param	string	name of the name
	 * @param	string	any LIKE statement used to pull the table columns
	 * @param	bool	whether to prepend the table with the database prefix
	 * @return	array 	an array of table columns
	 */
	public function list_table_columns($table, $like = false, $add_prefix = false)
	{
		$table = $this->db->protect_identifiers($table, $add_prefix);

		$sql = (is_string($like)) 
			? 'SHOW FULL COLUMNS FROM '.$table.' LIKE '.$this->db->protect_identifiers($like)
			: 'SHOW FULL COLUMNS FROM '.$table;
		
		$query = $this->db->query($sql);
		
		$retval = array();
		
		foreach($query->result_array() as $row)
		{
			$retval[] = (isset($row['COLUMN_NAME'])) ? $row['COLUMN_NAME'] : current($row);
		}
		
		return $retval;
	}
	
	public function count_loa_records()
	{
		$this->db->from('user_loa');
		
		return $this->db->count_all_results();
	}
	
	public function count_login_attempts($email = '')
	{
		$this->db->from('login_attempts');
		$this->db->where('login_email', $email);
		
		return $this->db->count_all_results();
	}
	
	public function add_ban($data = '')
	{
		$query = $this->db->insert('bans', $data);
		
		$this->dbutil->optimize_table('bans');
		
		return $query;
	}
	
	public function add_login_attempt($data = '')
	{
		$query = $this->db->insert('login_attempts', $data);
		
		$this->dbutil->optimize_table('login_attempts');
		
		return $query;
	}
	
	public function add_sim_type($data = '')
	{
		$query = $this->db->insert('sim_type', $data);
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	public function add_skin($data = '')
	{
		$query = $this->db->insert('catalogue_skins', $data);
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	public function add_skin_section($data = '')
	{
		$query = $this->db->insert('catalogue_skinsecs', $data);
		
		$this->dbutil->optimize_table('catalogue_skinsecs');
		
		return $query;
	}
	
	/**
	 * @deprecated
	 */
	public function add_system_version($data = '')
	{
		$query = $this->db->insert('system_versions', $data);
		
		$this->dbutil->optimize_table('system_versions');
		
		return $query;
	}
	
	public function add_upload_record($data = '')
	{
		$query = $this->db->insert('uploads', $data);
		
		$this->dbutil->optimize_table('uploads');
		
		return $query;
	}
	
	public function update_database_charset()
	{
		$query = $this->db->query('ALTER DATABASE `'. $this->db->database .'` DEFAULT CHARACTER SET '. $this->db->char_set .' COLLATE '. $this->db->dbcollat .'');
		
		return $query;
	}
	
	public function update_my_links($id = '', $status = 'active', $items = '84')
	{
		$update = array('my_links' => $items);
		
		if ( ! empty($id))
		{
			$this->db->where('userid', $id);
		}
		
		if ( ! empty($status))
		{
			$this->db->where('status', 'active');
		}
		
		$query = $this->db->update('users', $update);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	public function update_sim_type($id = '', $data = '')
	{
		$this->db->where('simtype_id', $id);
		$query = $this->db->update('sim_type', $data);
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	public function update_skin($id = '', $data = '')
	{
		$this->db->where('skin_id', $id);
		$query = $this->db->update('catalogue_skins', $data);
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	public function update_skin_section($id = '', $data = '', $where = array())
	{
		if ( ! empty($id))
		{
			$this->db->where('skinsec_id', $id);
		}
		
		if ( ! empty($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		$query = $this->db->update('catalogue_skinsecs', $data);
		
		$this->dbutil->optimize_table('catalogue_skinsecs');
		
		return $query;
	}
	
	/**
	 * Update the system info.
	 *
	 * @param	array	Array of data to use in the update
	 * @return	int
	 */
	public function update_system_info($data = false)
	{
		if ( ! is_array($data))
		{
			$this->db->set('sys_last_update', now());
			$this->db->set('sys_version_major', APP_VERSION_MAJOR);
			$this->db->set('sys_version_minor', APP_VERSION_MINOR);
			$this->db->set('sys_version_update', APP_VERSION_UPDATE);
		}
		else
		{
			$this->db->set('sys_last_update', $data['sys_last_update']);
			$this->db->set('sys_version_major', $data['sys_version_major']);
			$this->db->set('sys_version_minor', $data['sys_version_minor']);
			$this->db->set('sys_version_update', $data['sys_version_update']);
		}

		$this->db->where('sys_id', 1);
		$query = $this->db->update('system_info');
		
		$this->dbutil->optimize_table('system_info');
		
		return $query;
	}
	
	public function delete_ban($id = '')
	{
		$query = $this->db->delete('bans', array('ban_id' => $id));
		
		$this->dbutil->optimize_table('bans');
		
		return $query;
	}
	
	public function delete_login_attempts($email = '')
	{
		$query = $this->db->delete('login_attempts', array('login_email' => $email));
		
		$this->dbutil->optimize_table('login_attempts');
		
		return $query;
	}
	
	public function delete_sim_type($id = '')
	{
		$query = $this->db->delete('sim_type', array('simtype_id' => $id));
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	public function delete_skin($id = '')
	{
		$query = $this->db->delete('catalogue_skins', array('skin_id' => $id));
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	public function delete_skin_section($id = '', $identifier = 'skinsec_id')
	{
		$query = $this->db->delete('catalogue_skinsecs', array($identifier => $id));
		
		$this->dbutil->optimize_table('catalogue_skinsecs');
		
		return $query;
	}
	
	public function delete_upload_record($id = '')
	{
		$query = $this->db->delete('uploads', array('upload_id' => $id));
		
		$this->dbutil->optimize_table('uploads');
		
		return $query;
	}
	
	public function optimize_table($table = '')
	{
		if ( ! empty($table))
		{
			$this->dbutil->optimize_table($table);
		}
		else
		{
			return false;
		}
	}
}
