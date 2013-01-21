<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ranks model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_ranks_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_rank_sets($status = 'active')
	{
		$this->db->from('catalogue_ranks');
		$this->db->where('rankcat_genre', GENRE);
		
		if ( ! empty($status))
		{
			if ( ! is_array($status))
			{
				$status = array($status);
			}
			
			/* count the items in the array */
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
				
				$string.= $or . "rankcat_status = '$status[$i]'";
			}
			
			$this->db->where("($string)", NULL);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_group_ranks($name_id = '', $identifier = 'rank_name')
	{
		$this->db->from('ranks_'. GENRE);
		$this->db->where($identifier, $name_id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_rank($id = '', $return = '')
	{
		$query = $this->db->get_where('ranks_'. GENRE, array('rank_id' => $id));
		
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
	
	public function get_rank_default()
	{
		$this->db->from('catalogue_ranks');
		$this->db->where('rankcat_status', 'active');
		$this->db->where('rankcat_default', 'y');
		$this->db->where('rankcat_genre', GENRE);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->rankcat_location;
		}
		
		return false;
	}
	
	public function get_rankcat($id = '', $identifier = 'rankcat_location', $return = '')
	{
		$this->db->from('catalogue_ranks');
		$this->db->where($identifier, $id);
		$this->db->where('rankcat_genre', GENRE);
		
		$query = $this->db->get();
		
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
	
	public function get_ranks($class = '', $display = 'y')
	{
		$this->db->from('ranks_'. GENRE);
		
		if ( ! empty($class))
		{
			$this->db->where('rank_class', $class);
		}
		
		if ( ! empty($display))
		{
			$this->db->where('rank_display', $display);
		}
		
		$this->db->order_by('rank_class, rank_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_rank($data = '')
	{
		$query = $this->db->insert('ranks_'. GENRE, $data);
		
		$this->dbutil->optimize_table('ranks_'. GENRE);
		
		return $query;
	}
	
	public function add_rank_set($data = '')
	{
		$query = $this->db->insert('catalogue_ranks', $data);
		
		$this->dbutil->optimize_table('catalogue_ranks');
		
		return $query;
	}
	
	public function update_rank($id = '', $data = '')
	{
		$this->db->where('rank_id', $id);
		$query = $this->db->update('ranks_'. GENRE, $data);
		
		$this->dbutil->optimize_table('ranks_'. GENRE);
		
		return $query;
	}
	
	public function update_rank_set($id = '', $data = '', $where = array())
	{
		if ( ! empty($id))
		{
			$this->db->where('rankcat_id', $id);
		}
		
		if ( ! empty($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		$query = $this->db->update('catalogue_ranks', $data);
		
		$this->dbutil->optimize_table('catalogue_ranks');
		
		return $query;
	}
	
	public function delete_rank($id = '')
	{
		$query = $this->db->delete('ranks_'. GENRE, array('rank_id' => $id));
		
		$this->dbutil->optimize_table('ranks_'. GENRE);
		
		return $query;
	}
	
	public function delete_rank_set($id = '')
	{
		$query = $this->db->delete('catalogue_ranks', array('rankcat_id' => $id));
		
		$this->dbutil->optimize_table('catalogue_ranks');
		
		return $query;
	}
}
