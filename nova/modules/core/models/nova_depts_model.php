<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Departments model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_depts_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_depts($sort = 'asc', $display = 'y', $parent = 0, $sort_col = 'dept_order')
	{
		$this->db->from('departments_'. GENRE);
		
		if ($parent == 0)
		{
			$this->db->where('dept_parent', 0);
		}
		
		if ( ! empty($display))
		{
			$this->db->where('dept_display', $display);
		}
		
		$this->db->order_by($sort_col, $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_all_manifests($display = 'y', $sort = 'asc', $sort_col = 'manifest_order')
	{
		$this->db->from('manifests');
		
		if ( ! empty($display))
		{
			$this->db->where('manifest_display', $display);
		}
		
		$this->db->order_by($sort_col, $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_default_manifest()
	{
		$query = $this->db->get_where('manifests', array('manifest_default' => 'y'));
		
		$row = ($query->num_rows() > 0) ? $query->row() : false;
		
		if ($row !== false)
		{
			return $row->manifest_id;
		}
		
		return false;
	}
	
	public function get_dept($id = '', $return = '')
	{
		$query = $this->db->get_where('departments_'. GENRE, array('dept_id' => $id));
		
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
	
	public function get_manifest($id = '', $return = '')
	{
		$query = $this->db->get_where('manifests', array('manifest_id' => $id));
		
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
	
	public function get_sub_depts($dept = '', $sort = 'asc', $display = 'y')
	{
		$this->db->from('departments_'. GENRE);
		$this->db->where('dept_parent', $dept);
		
		if ( ! empty($display))
		{
			$this->db->where('dept_display', $display);
		}
		
		$this->db->order_by('dept_order', $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_dept($data = '')
	{
		$query = $this->db->insert('departments_'. GENRE, $data);
		
		return $query;
	}
	
	public function add_manifest($data = '')
	{
		$query = $this->db->insert('manifests', $data);
		
		$this->dbutil->optimize_table('manifests');
		
		return $query;
	}
	
	public function update_dept($dept = '', $data = '')
	{
		$this->db->where('dept_id', $dept);
		$query = $this->db->update('departments_'. GENRE, $data);
		
		$this->dbutil->optimize_table('departments_'. GENRE);
		
		return $query;
	}
	
	public function update_manifest($id = '', $data = '')
	{
		$this->db->where('manifest_id', $id);
		$query = $this->db->update('manifests', $data);
		
		$this->dbutil->optimize_table('manifests');
		
		return $query;
	}
	
	public function update_manifest_default($old = 'y', $new = 'n')
	{
		$this->db->where('manifest_default', $old);
		$query = $this->db->update('manifests', array('manifest_default' => $new));
		
		$this->dbutil->optimize_table('manifests');
		
		return $query;
	}
	
	public function delete_dept($id = '')
	{
		$query = $this->db->delete('departments_'. GENRE, array('dept_id' => $id));
		
		$this->dbutil->optimize_table('departments_'. GENRE);
		
		return $query;
	}
	
	public function delete_manifest($id = '')
	{
		$query = $this->db->delete('manifests', array('manifest_id' => $id));
		
		$this->dbutil->optimize_table('manifests');
		
		return $query;
	}
}
