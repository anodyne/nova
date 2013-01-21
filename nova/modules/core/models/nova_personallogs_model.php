<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Personal logs model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_personallogs_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	/**
	 * Get all personal logs by a specific character.
	 *
	 * @access	public
	 * @param	mixed	either a character ID or an array of character IDs
	 * @param	int		the number of records to limit the result to
	 * @param	string	the status
	 * @param	int		the offset
	 * @return	object	result object
	 */
	public function get_character_logs($id = '', $limit = 0, $status = 'activated', $offset = 0)
	{
		$this->db->from('personallogs');
		
		if ( ! empty($status))
		{
			$this->db->where('log_status', $status);
		}
		
		if (is_array($id))
		{
			$id = array_values($id);
			
			$count = count($id);
			
			$string = '';
			
			for ($i=0; $i < $count; $i++)
			{
				$or = ($i > 0) ? ' OR ' : '';
				
				$string.= $or ."log_author_character = '$id[$i]'";
			}
			
			$this->db->where("($string)", null);
		}
		else
		{
			$this->db->where('log_author_character', $id);
		}
		
		$this->db->order_by('log_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_link_id($id = '', $direction = 'next')
	{
		$get = $this->db->get_where('personallogs', array('log_id' => $id));
		
		if ($get->num_rows() > 0)
		{
			$fetch = $get->row();
			
			$this->db->select('log_id');
			$this->db->from('personallogs');
			$this->db->where('log_status', 'activated');
			
			switch ($direction)
			{
				case 'next':
					$this->db->where('log_date >', $fetch->log_date);
					$this->db->order_by('log_date', 'asc');
				break;
				
				case 'prev':
					$this->db->where('log_date <', $fetch->log_date);
					$this->db->order_by('log_date', 'desc');
				break;
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->log_id;
			}
		}
		
		return false;
	}

	public function get_log($id = '', $return = '')
	{
		$query = $this->db->get_where('personallogs', array('log_id' => $id));
		
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
	
	public function get_log_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('personallogs_comments', array('lcomment_id' => $id));
		
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
	
	public function get_log_comments($id = '', $status = 'activated', $order_field = 'lcomment_date', $order = 'asc')
	{
		$this->db->from('personallogs_comments');
		
		if ( ! empty($id))
		{
			$this->db->where('lcomment_log', $id);
		}
		
		$this->db->where('lcomment_status', $status);
		
		$this->db->order_by($order_field, $order);
		
		if ($order_field != 'lcomment_date')
		{
			$this->db->order_by('lcomment_date', $order);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_log_list($num = '', $offset = 0, $status = 'activated')
	{
		$this->db->from('personallogs');
		
		if ( ! empty($status))
		{
			$this->db->where('log_status', $status);
		}
		
		$this->db->order_by('log_date', 'desc');
		$this->db->limit($num, $offset);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_saved_logs($id = '', $limit = 0)
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'saved');
		
		if ( ! empty($id))
		{
			if (is_array($id))
			{
				$id = array_values($id);
				
				$count = count($id);
				
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
					
					$string.= $or . "log_author_character = '$id[$i]'";
				}
				
				$this->db->where("($string)", null);
			}
			else
			{
				$this->db->like('log_author_character', $id);
			}
		}
		
		$this->db->order_by('log_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get all personal logs by a specific user.
	 *
	 * @access	public
	 * @since	2.0
	 * @param	int		a user ID
	 * @param	int		the number of records to limit the result to
	 * @param	string	the status
	 * @return	object	result object
	 */
	public function get_user_logs($id = '', $limit = 0, $status = 'activated')
	{
		$this->db->from('personallogs');
		
		if ( ! empty($status))
		{
			$this->db->where('log_status', $status);
		}
		
		$this->db->where('log_author_user', $id);
		$this->db->order_by('log_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function count_all_log_comments($status = 'activated', $id = '')
	{
		$this->db->from('personallogs_comments');
		$this->db->where('lcomment_status', $status);
		
		if ( ! empty($id))
		{
			$this->db->where('lcomment_log', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_all_logs($status = 'activated')
	{
		$this->db->from('personallogs');
		
		if ( ! empty($status))
		{
			$this->db->where('log_status', $status);
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_character_logs($character = '', $status = 'activated')
	{
		$count = 0;
		
		if ( ! empty($character) && $character !== false && $character !== null)
		{
			if (is_array($character))
			{
				foreach ($character as $value)
				{
					$this->db->where('log_status', $status);
					$this->db->where('log_author_character', $value);
					$this->db->from('personallogs');
				
					$count += $this->db->count_all_results();
				}
			}
			else
			{
				$this->db->where('log_status', $status);
				$this->db->where('log_author_character', $character);
				$this->db->from('personallogs');
			
				$count += $this->db->count_all_results();
			}
		}
		
		return $count;
	}
	
	public function count_logs($start = '', $end = '')
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		$this->db->where('log_date >', $start);
		$this->db->where('log_date < ', $end);
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	public function count_user_log_comments($user = '')
	{
		$count = 0;
		
		if ( ! empty($user) && $user !== false && $user !== null)
		{
			$this->db->from('personallogs_comments');
			$this->db->where('lcomment_status', 'activated');
			$this->db->where('lcomment_author_user', $user);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function count_user_logs($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		if ( ! empty($id) && $id !== false && $id !== null)
		{
			$this->db->from('personallogs');
		
			if ( ! empty($status))
			{
				$this->db->where('log_status', $status);
			}
		
			if ( ! empty($timeframe))
			{
				$this->db->where('log_date >=', $timeframe);
			}
		
			$this->db->where('log_author_user', $id);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function search_logs($component = '', $input = '')
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_log_comment($data = '')
	{
		$this->db->insert('personallogs_comments', $data);
		
		$this->dbutil->optimize_table('personallogs_comments');
		
		return $this->db->affected_rows();
	}
	
	public function create_personal_log($data = '')
	{
		$query = $this->db->insert('personallogs', $data);
		
		return $query;
	}
	
	public function update_log($id = '', $data = '', $identifier = 'log_id')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('personallogs', $data);
		
		$this->dbutil->optimize_table('personallogs');
		
		return $query;
	}
	
	public function update_log_comment($id = '', $data = '')
	{
		$this->db->where('lcomment_id', $id);
		$query = $this->db->update('personallogs_comments', $data);
		
		$this->dbutil->optimize_table('personallogs_comments');
		
		return $query;
	}
	
	public function delete_log($id = '')
	{
		$comments = $this->db->get_where('personallogs_comments', array('lcomment_log' => $id));
		
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('personallogs_comments', array('lcomment_id' => $r->lcomment_id));
			}
		}
		
		$query = $this->db->delete('personallogs', array('log_id' => $id));
		
		$this->dbutil->optimize_table('personallogs');
		
		return $query;
	}
	
	public function delete_log_comment($id = '')
	{
		$query = $this->db->delete('personallogs_comments', array('lcomment_id' => $id));
		
		$this->dbutil->optimize_table('personallogs_comments');
		
		return $query;
	}
}
