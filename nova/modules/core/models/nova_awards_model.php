<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Awards model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_awards_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	/**
	 * Get all awards from the database.
	 *
	 * @access	public
	 * @param	string	the order to pull awards in (asc, desc)
	 * @param	string	the display flag to use when pulling awards
	 * @param	string	the category of awards to pull (ic, ooc, both)
	 * @return	object	the result object
	 */
	public function get_all_awards($order = 'asc', $display = 'y', $cat = '')
	{
		$this->db->from('awards');
		
		if ( ! empty($display))
		{
			$this->db->where('award_display', $display);
		}
		
		if ( ! empty($cat))
		{
			$this->db->where('award_cat', $cat);
		}
		
		$this->db->order_by('award_order', $order);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_award($id = '', $return = '')
	{
		$query = $this->db->get_where('awards', array('award_id' => $id));
		
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
	
	public function get_award_noms($status = 'pending', $order = 'desc')
	{
		$this->db->from('awards_queue');
		
		if ( ! empty($status))
		{
			$this->db->where('queue_status', $status);
		}
		
		$this->db->order_by('queue_date', $order);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_awardees($award = '')
	{
		$this->db->from('awards_received');
		$this->db->where('awardrec_award', $award);
		$this->db->order_by('awardrec_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_user_awards($user = '', $limit = 10, $where = array())
	{
		$this->db->from('awards_received');
		$this->db->join('awards', 'awards.award_id = awards_received.awardrec_award');
		$this->db->where('awardrec_user', $user);
		
		if ( ! empty($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_awards_for_id($id = '', $type = 'character')
	{
		switch ($type)
		{
			case 'user':
				$field = 'awardrec_user';
			break;
			
			default:
				$field = 'awardrec_character';
			break;
		}
		
		$this->db->from('awards_received');
		$this->db->join('awards', 'awards.award_id = awards_received.awardrec_award');
		$this->db->where($field, $id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function count_award_noms($status = 'accepted')
	{
		$this->db->from('awards_queue');
		
		if ( ! empty($status))
		{
			$this->db->where('queue_status', $status);
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_character_awards($id = '', $field = 'awardrec_character')
	{
		$this->db->from('awards_received');
		$this->db->where($field, $id);
		
		return $this->db->count_all_results();
	}
	
	public function add_award($data = '')
	{
		$query = $this->db->insert('awards', $data);
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	public function add_award_nomination($data = '')
	{
		$query = $this->db->insert('awards_queue', $data);
		
		$this->dbutil->optimize_table('awards_queue');
		
		return $query;
	}
	
	public function add_nominated_award($data = '')
	{
		$query = $this->db->insert('awards_received', $data);
		
		$this->dbutil->optimize_table('awards_received');
		
		return $query;
	}
	
	public function update_award($id = '', $data = '')
	{
		$this->db->where('award_id', $id);
		$query = $this->db->update('awards', $data);
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	public function update_queue_record($id = '', $data = '')
	{
		$this->db->where('queue_id', $id);
		$query = $this->db->update('awards_queue', $data);
		
		$this->dbutil->optimize_table('awards_queue');
		
		return $query;
	}
	
	public function delete_award($id = '')
	{
		$query = $this->db->delete('awards', array('award_id' => $id));
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	public function delete_received_award($id = '')
	{
		$query = $this->db->delete('awards_received', array('awardrec_id' => $id));
		
		$this->dbutil->optimize_table('awards_received');
		
		return $query;
	}
}
