<?php
/*
|---------------------------------------------------------------
| AWARDS MODEL
|---------------------------------------------------------------
|
| File: models/base/awards_model.php
| System Version: 1.0
|
| Model used to access the awards tables
|
*/

class Awards_model_base extends Model {

	function Awards_model_base()
	{
		parent::Model();
		
		/* load the db utility library */
		$this->load->dbutil();
	}
	
	/*
	|---------------------------------------------------------------
	| RETRIEVE METHODS
	|---------------------------------------------------------------
	*/

	function get_all_awards($order = 'asc', $display = 'y', $cat = '')
	{
		/*
			param1	=> asc, desc, random
			param2	=> y, n, all
		*/
		
		$this->db->from('awards');
		
		if (!empty($display))
		{
			$this->db->where('award_display', $display);
		}
		
		if (!empty($cat))
		{
			$this->db->where('award_cat', $cat);
		}
		
		$this->db->order_by('award_order', $order);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_award($id = '', $return = '')
	{
		$query = $this->db->get_where('awards', array('award_id' => $id));
		
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
	
	function get_award_noms($status = 'pending', $order = 'desc')
	{
		$this->db->from('awards_queue');
		
		if (!empty($status))
		{
			$this->db->where('queue_status', $status);
		}
		
		$this->db->order_by('queue_date', $order);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_awardees($award = '')
	{
		$this->db->from('awards_received');
		$this->db->where('awardrec_award', $award);
		$this->db->order_by('awardrec_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_user_awards($user = '', $limit = 10, $where = array())
	{
		$this->db->from('awards_received');
		$this->db->join('awards', 'awards.award_id = awards_received.awardrec_award');
		$this->db->where('awardrec_user', $user);
		
		if (!empty($where))
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
	
	function get_awards_for_id($id = '', $type = 'character')
	{
		switch ($type)
		{ /* make sure we're querying the right field */
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
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_award_noms($status = 'accepted')
	{
		$this->db->from('awards_queue');
		
		if (!empty($status))
		{
			$this->db->where('queue_status', $status);
		}
		
		return $this->db->count_all_results();
	}
	
	function count_character_awards($id = '', $field = 'awardrec_character')
	{
		$this->db->from('awards_received');
		$this->db->where($field, $id);
		
		return $this->db->count_all_results();
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_award($data = '')
	{
		$query = $this->db->insert('awards', $data);
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	function add_award_nomination($data = '')
	{
		$query = $this->db->insert('awards_queue', $data);
		
		$this->dbutil->optimize_table('awards_queue');
		
		return $query;
	}
	
	function add_nominated_award($data = '')
	{
		$query = $this->db->insert('awards_received', $data);
		
		$this->dbutil->optimize_table('awards_received');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_award($id = '', $data = '')
	{
		$this->db->where('award_id', $id);
		$query = $this->db->update('awards', $data);
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	function update_queue_record($id = '', $data = '')
	{
		$this->db->where('queue_id', $id);
		$query = $this->db->update('awards_queue', $data);
		
		$this->dbutil->optimize_table('awards_queue');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_award($id = '')
	{
		$query = $this->db->delete('awards', array('award_id' => $id));
		
		$this->dbutil->optimize_table('awards');
		
		return $query;
	}
	
	function delete_received_award($id = '')
	{
		$query = $this->db->delete('awards_received', array('awardrec_id' => $id));
		
		$this->dbutil->optimize_table('awards_received');
		
		return $query;
	}
}

/* End of file awards_model.php */
/* Location: ./application/models/base/awards_model.php */