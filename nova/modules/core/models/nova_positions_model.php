<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Positions model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_positions_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_all_positions($sort = 'asc', $display = 'y')
	{
		$this->db->from('positions_'. GENRE);
		
		if ( ! empty($display))
		{
			$this->db->where('pos_display', $display);
		}
		
		$this->db->order_by('pos_order', $sort);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_dept_positions($dept = '', $display = 'y', $return = 'object')
	{
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_dept', $dept);
		
		if ( ! empty($display))
		{
			$this->db->where('pos_display', $display);
		}
		
		$this->db->order_by('pos_order', 'asc');
		
		$query = $this->db->get();
		
		if ($return == 'object')
		{
			return $query;
		}
		else
		{
			if ($query->num_rows() > 0)
			{
				foreach ($query->result() as $p)
				{
					$array[] = $p->pos_id;
				}
				
				return $array;
			}
		}
		
		return false;
	}
	
	/**
	 * Get a list of all open positions.
	 *
	 * @since	2.0
	 * @access	public
	 * @param	string	whether to show displayed positions or not
	 * @param	bool	whether to just show top positions
	 * @return	object	a result object
	 */
	public function get_open_positions($display = 'y', $top_positions = false)
	{
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_open >', 0);
		$this->db->where('pos_display', $display);
		
		if ($top_positions)
		{
			$this->db->where('pos_top_open', 'y');
		}
		
		$this->db->order_by('pos_dept', 'asc');
		$this->db->order_by('pos_order', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_position($id = '', $return = '')
	{
		$query = $this->db->get_where('positions_'. GENRE, array('pos_id' => $id));
		
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
	
	public function add_position($data = '')
	{
		$query = $this->db->insert('positions_'. GENRE, $data);
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
	
	public function update_open_slots($position = '', $direction = '')
	{
		$this->db->select('pos_open');
		$this->db->from('positions_'. GENRE);
		$this->db->where('pos_id', $position);
		
		$get = $this->db->get();
		
		if ($get->num_rows() > 0)
		{
			$open = $get->row();
			
			$new_num = ($direction == 'add_crew') ? $open->pos_open - 1 : $open->pos_open + 1;
			$new_num = ($new_num < 0) ? 0 : $new_num;
			
			$data = array('pos_open' => $new_num);
			
			$this->db->where('pos_id', $position);
			$query = $this->db->update('positions_'. GENRE, $data);
			
			$this->dbutil->optimize_table('positions_'. GENRE);
			
			return $query;
		}
		
		return false;
	}
	
	public function update_position($position = '', $data = '')
	{
		$this->db->where('pos_id', $position);
		$query = $this->db->update('positions_'. GENRE, $data);
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
	
	public function delete_position($id = '')
	{
		$query = $this->db->delete('positions_'. GENRE, array('pos_id' => $id));
		
		$this->dbutil->optimize_table('positions_'. GENRE);
		
		return $query;
	}
}
