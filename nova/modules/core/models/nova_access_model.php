<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Access model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_access_model extends CI_Model {
	
	const SYSADMIN	= 1;
	const ADMIN		= 2;
	const POWERUSER	= 3;
	const STANDARD	= 4;
	const INACTIVE	= 5;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_group($id = '', $return = '')
	{
		$query = $this->db->get_where('access_groups', array('group_id' => $id));
		
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
	
	public function get_page($id = '', $return = '')
	{
		$query = $this->db->get_where('access_pages', array('page_id' => $id));
		
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
	
	public function get_page_groups()
	{
		$this->db->from('access_groups');
		$this->db->order_by('group_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_pages($data = '')
	{
		$data = explode(',', $data);
		
		$array = array();
		
		foreach ($data as $value)
		{
			$query = $this->db->get_where('access_pages', array('page_id' => $value));
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				
				$array[$row->page_url] = (empty($row->page_level)) ? 0 : $row->page_level;
			}
		}
		
		return $array;
	}
	
	public function get_users_with_role($id = '')
	{
		$this->db->from('access_roles');
		$this->db->join('users', 'users.access_role = access_roles.role_id');
		$this->db->where('role_id', $id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $a)
			{
				$array[] = $a->main_char;
			}
			
			return $array;
		}
		
		return false;
	}
	
	public function get_role($id = '')
	{
		$query = $this->db->get_where('access_roles', array('role_id' => $id));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		return $row;
	}
	
	public function get_role_data($role = '')
	{
		$query = $this->db->get_where('access_roles', array('role_id' => $role));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->role_access;
		}
		
		return false;
	}
	
	public function get_role_pages()
	{
		$query = $this->db->get('access_pages');
		
		return $query;
	}
	
	public function get_roles()
	{
		$query = $this->db->get('access_roles');
		
		return $query;
	}
	
	public function insert_group($data = '')
	{
		$query = $this->db->insert('access_groups', $data);
		
		$this->dbutil->optimize_table('access_groups');
		
		return $query;
	}
	
	public function insert_page($data = '')
	{
		$query = $this->db->insert('access_pages', $data);
		
		$this->dbutil->optimize_table('access_pages');
		
		return $query;
	}
	
	public function insert_role($data = '')
	{
		$query = $this->db->insert('access_roles', $data);
		
		$this->dbutil->optimize_table('access_roles');
		
		return $query;
	}
	
	public function update_group($id = '', $data = '')
	{
		$this->db->where('group_id', $id);
		$query = $this->db->update('access_groups', $data);
		
		$this->dbutil->optimize_table('access_groups');
		
		return $query;
	}
	
	public function update_page($id = '', $data = '')
	{
		$this->db->where('page_id', $id);
		$query = $this->db->update('access_pages', $data);
		
		$this->dbutil->optimize_table('access_pages');
		
		return $query;
	}
	
	public function update_pages($data = '', $where = array('' => ''))
	{
		foreach ($where as $key => $value)
		{
			$this->db->where($key, $value);
		}
		
		$query = $this->db->update('access_pages', $data);
		
		$this->dbutil->optimize_table('access_pages');
		
		return $query;
	}
	
	public function update_role($id = '', $data = '')
	{
		$this->db->where('role_id', $id);
		$query = $this->db->update('access_roles', $data);
		
		$this->dbutil->optimize_table('access_roles');
		
		return $query;
	}
	
	public function delete_group($id = '')
	{
		$query = $this->db->delete('access_groups', array('group_id' => $id));
		
		$this->dbutil->optimize_table('access_groups');
		
		return $query;
	}
	
	public function delete_page($id = '')
	{
		$query = $this->db->delete('access_pages', array('page_id' => $id));
		
		$this->dbutil->optimize_table('access_pages');
		
		return $query;
	}
	
	public function delete_role($id = '')
	{
		$query = $this->db->delete('access_roles', array('role_id' => $id));
		
		$this->dbutil->optimize_table('access_roles');
		
		return $query;
	}
}
