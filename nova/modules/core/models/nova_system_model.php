<?php
/**
 * System model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.2
 *
 * Added methods to create, retrieve and delete site bans from the database,
 * updated method that automatically sets the first My Link
 */

abstract class Nova_system_model extends Model {

	public function __construct()
	{
		parent::Model();
		
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function check_install_status()
	{
		$prefix = $this->db->dbprefix;
		
		/* get an array of the tables */
		$data = $this->db->list_tables();
		
		/* get the prefix length */
		$prefix_len = strlen($prefix);
		
		/* go through all the tables to find out if its part of the system or not */
		foreach ($data as $key => $value)
		{
			if (substr($value, 0, $prefix_len) != $prefix)
			{
				unset($data[$key]);
			}
		}
		
		/* check to see if there are tables or not */
		if (count($data) > 0)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	function get_all_skins()
	{
		$query = $this->db->get('catalogue_skins');
		
		return $query;
	}
	
	function get_all_system_components()
	{
		$this->db->from('system_components');
		$this->db->order_by('comp_id', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_all_system_versions()
	{
		$this->db->from('system_versions');
		$this->db->order_by('version_id', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_ban($id = '', $return = '')
	{
		$query = $this->db->get_where('bans', array('ban_id' => $id));
		
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
	
	function get_bans($level = '', $returnall = TRUE)
	{
		$this->db->from('bans');
		
		if ( ! empty($level))
		{
			$this->db->where('ban_level', $level);
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			if ($returnall === TRUE)
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
	
	function get_current_version()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		/* grab the data */
		foreach ($query->result() as $row)
		{
			$data = $row->system_version_complete;
		}
		
		/* return the data for use */
		return $data;
	}
	
	function get_database_size()
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
	
	function get_item($table = '', $key = '', $id = '', $return = '')
	{
		$query = $this->db->get_where($table, array($key => $id));
		
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
	
	function get_last_login_attempt($data = '', $field = 'login_email')
	{
		$this->db->from('login_attempts');
		$this->db->where($field, $data);
		$this->db->order_by('login_time', 'desc');
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_loa_records($limit = 0, $offset = 0)
	{
		$this->db->from('user_loa');
		$this->db->order_by('loa_start_date', 'desc');
		
		if (!empty($limit))
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_nova_uid()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->sys_uid;
		}
		
		return FALSE;
	}
	
	function get_preferences()
	{
		$query = $this->db->get('user_prefs');
		
		return $query;
	}
	
	function get_security_questions()
	{
		$query = $this->db->get('security_questions');
		
		return $query;
	}
	
	function get_sim_types()
	{
		$query = $this->db->get('sim_type');
		
		return $query;
	}
	
	function get_skinsec_default($section = '')
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
		
		return FALSE;
	}
	
	function get_skin_info($id = '', $field = 'skin_location')
	{
		$this->db->from('catalogue_skins');
		$this->db->where($field, $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_skin_name($id = '')
	{
		$query = $this->db->get_where('catalogue_skins', array('skin_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		if ($row !== FALSE)
		{
			return $row->skin_name;
		}
		
		return $row;
	}
	
	function get_skin_section_info($id = '', $field = 'skinsec_section')
	{
		$this->db->from('catalogue_skinsecs');
		$this->db->where($field, $id);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_skin_sections($id = '', $status = 'active')
	{
		$this->db->from('catalogue_skinsecs');
		
		if (!empty($id))
		{
			$this->db->where('skinsec_skin', $id);
		}
		
		if (!empty($status))
		{
			if (!is_array($status))
			{
				$status = array($status);
			}
			
			/* count the array */
			$count = count($status);
			
			/* set the initial string */
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
			
			$this->db->where("($string)", NULL);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_skinsec($where = '')
	{
		$this->db->from('catalogue_skinsecs');
		
		foreach ($where as $key => $value)
		{
			$this->db->where($key, $value);
		}
		
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		$row = ($query->num_rows() > 0) ? $query->row() : FALSE;
		
		return $row;
	}
	
	function get_system_info()
	{
		$query = $this->db->get_where('system_info', array('sys_id' => 1));
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
		
		return FALSE;
	}
	
	function get_uploaded_images($type = '')
	{
		$this->db->from('uploads');
		
		if (!empty($type))
		{
			$this->db->where('upload_resource_type', $type);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Count methods
	 */
	
	function count_loa_records()
	{
		$this->db->from('user_loa');
		
		return $this->db->count_all_results();
	}
	
	function count_login_attempts($email = '')
	{
		$this->db->from('login_attempts');
		$this->db->where('login_email', $email);
		
		return $this->db->count_all_results();
	}
	
	/**
	 * Create methods
	 */
	
	function add_ban($data = '')
	{
		$query = $this->db->insert('bans', $data);
		
		$this->dbutil->optimize_table('bans');
		
		return $query;
	}
	
	function add_login_attempt($data = '')
	{
		$query = $this->db->insert('login_attempts', $data);
		
		$this->dbutil->optimize_table('login_attempts');
		
		return $query;
	}
	
	function add_sim_type($data = '')
	{
		$query = $this->db->insert('sim_type', $data);
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	function add_skin($data = '')
	{
		$query = $this->db->insert('catalogue_skins', $data);
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	function add_skin_section($data = '')
	{
		$query = $this->db->insert('catalogue_skinsecs', $data);
		
		$this->dbutil->optimize_table('catalogue_skinsecs');
		
		return $query;
	}
	
	function add_system_version($data = '')
	{
		$query = $this->db->insert('system_versions', $data);
		
		$this->dbutil->optimize_table('system_versions');
		
		return $query;
	}
	
	function add_upload_record($data = '')
	{
		$query = $this->db->insert('uploads', $data);
		
		$this->dbutil->optimize_table('uploads');
		
		return $query;
	}
	
	/**
	 * Update methods
	 */
	
	function update_database_charset()
	{
		$query = $this->db->query('ALTER DATABASE `'. $this->db->database .'` DEFAULT CHARACTER SET '. $this->db->char_set .' COLLATE '. $this->db->dbcollat .'');
		
		return $query;
	}
	
	function update_my_links($id = '', $status = 'active', $items = '83')
	{
		/* sets the default to Site Options link */
		$update = array('my_links' => $items);
		
		if (!empty($id))
		{
			$this->db->where('userid', $id);
		}
		
		if (!empty($status))
		{
			$this->db->where('status', 'active');
		}
		
		$query = $this->db->update('users', $update);
		
		/* optimize the table */
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	function update_sim_type($id = '', $data = '')
	{
		$this->db->where('simtype_id', $id);
		$query = $this->db->update('sim_type', $data);
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	function update_skin($id = '', $data = '')
	{
		$this->db->where('skin_id', $id);
		$query = $this->db->update('catalogue_skins', $data);
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	function update_skin_section($id = '', $data = '', $where = array())
	{
		if (!empty($id))
		{
			$this->db->where('skinsec_id', $id);
		}
		
		if (!empty($where))
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
	
	function update_system_info($data = '')
	{
		$this->db->where('sys_id', 1);
		$query = $this->db->update('system_info', $data);
		
		$this->dbutil->optimize_table('system_info');
		
		return $query;
	}
	
	/**
	 * Delete methods
	 */
	
	function delete_ban($id = '')
	{
		$query = $this->db->delete('bans', array('ban_id' => $id));
		
		$this->dbutil->optimize_table('bans');
		
		return $query;
	}
	
	function delete_login_attempts($email = '')
	{
		$query = $this->db->delete('login_attempts', array('login_email' => $email));
		
		$this->dbutil->optimize_table('login_attempts');
		
		return $query;
	}
	
	function delete_sim_type($id = '')
	{
		$query = $this->db->delete('sim_type', array('simtype_id' => $id));
		
		$this->dbutil->optimize_table('sim_type');
		
		return $query;
	}
	
	function delete_skin($id = '')
	{
		$query = $this->db->delete('catalogue_skins', array('skin_id' => $id));
		
		$this->dbutil->optimize_table('catalogue_skins');
		
		return $query;
	}
	
	function delete_skin_section($id = '')
	{
		$query = $this->db->delete('catalogue_skinsecs', array('skinsec_id' => $id));
		
		$this->dbutil->optimize_table('catalogue_skinsecs');
		
		return $query;
	}
	
	function delete_upload_record($id = '')
	{
		$query = $this->db->delete('uploads', array('upload_id' => $id));
		
		$this->dbutil->optimize_table('uploads');
		
		return $query;
	}
	
	/**
	 * Miscellaneous methods
	 */
	
	function optimize_table($table = '')
	{
		if (!empty($table))
		{
			$this->dbutil->optimize_table($table);
		}
		else
		{
			return FALSE;
		}
	}
}