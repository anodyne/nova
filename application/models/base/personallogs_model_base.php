<?php
/*
|---------------------------------------------------------------
| PERSONAL LOGS MODEL
|---------------------------------------------------------------
|
| File: models/personallogs_model_base.php
| System Version: 1.0
|
| Model used to access the personal logs and personal logs comments tables.
|
*/

class Personallogs_model_base extends Model {

	function Personallogs_model_base()
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

	function get_log($id = '', $return = '')
	{
		$query = $this->db->get_where('personallogs', array('log_id' => $id));
		
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
	
	function get_log_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('personallogs_comments', array('lcomment_id' => $id));
		
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
	
	function get_log_comments($id = '', $status = 'activated', $order_field = 'lcomment_date', $order = 'asc')
	{
		$this->db->from('personallogs_comments');
		
		if (!empty($id))
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
	
	function get_log_list($num = '', $offset = 0, $status = 'activated')
	{
		$this->db->from('personallogs');
		
		if (!empty($status))
		{
			$this->db->where('log_status', $status);
		}
		
		$this->db->order_by('log_date', 'desc');
		$this->db->limit($num, $offset);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_log_author($id = '')
	{
		$query = $this->db->get_where('personallogs', array('log_id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->log_author_player;
		}
		
		return FALSE;
	}
	
	function get_character_logs($id = '', $limit = 0)
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		
		if (is_array($id))
		{
			/* make sure the keys are set up right */
			$id = array_values($id);
			
			$this->db->where('log_author_character', $id[0]);
			
			$count = count($id);
			for ($i=1; $i < $count; $i++)
			{ 
				$this->db->or_where('log_author_character', $id[$i]);
			}
		}
		else
		{
			$this->db->where('log_author_character', $id);
		}
		
		$this->db->order_by('log_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_link_id($id = '', $direction = 'next')
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
					break;
				
				case 'prev':
					$this->db->where('log_date <', $fetch->log_date);
					$this->db->order_by('log_id', 'desc');
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
		
		return FALSE;
	}
	
	function get_saved_logs($id = '', $limit = 0)
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'saved');
		
		if (!empty($id))
		{
			if (is_array($id))
			{
				/* make sure the keys are set up right */
				$id = array_values($id);
				
				/* count the items in the array */
				$count = count($id);
				
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
					
					$string.= $or . "log_author_character = '$id[$i]'";
				}
				
				$this->db->where("($string)", NULL);
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
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_character_logs($character = '', $status = 'activated')
	{
		$count = 0;
		
		if (is_array($character))
		{
			foreach ($character as $value)
			{
				$this->db->where('log_status', $status);
				$this->db->like('log_author_character', $value);
				$this->db->from('personallogs');
				
				$count += $this->db->count_all_results();
			}
		}
		else
		{
			$this->db->where('log_status', $status);
			$this->db->like('log_author_character', $character);
			$this->db->from('personallogs');
			
			$count += $this->db->count_all_results();
		}
		
		return $count;
	}
	
	function count_player_logs($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		$this->db->from('personallogs');
		$this->db->where('log_status', $status);
		
		if (!empty($timeframe))
		{
			$this->db->where('log_date >=', $timeframe);
		}
		
		$this->db->where('log_author_player', $id);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_logs($start = '', $end = '')
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		$this->db->where('log_date >', $start);
		$this->db->where('log_date < ', $end);
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function count_player_log_comments($player = '')
	{
		$count = 0;
		
		$this->db->from('personallogs_comments');
		$this->db->where('lcomment_status', 'activated');
		$this->db->where('lcomment_author_player', $player);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_all_logs($status = 'activated')
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', $status);
		
		return $this->db->count_all_results();
	}
	
	function count_all_log_comments($status = 'activated', $id = '')
	{
		$this->db->from('personallogs_comments');
		$this->db->where('lcomment_status', $status);
		
		if (!empty($id))
		{
			$this->db->where('lcomment_log', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	/*
	|---------------------------------------------------------------
	| SEARCH METHODS
	|---------------------------------------------------------------
	*/
	
	function search_logs($component = '', $input = '')
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function create_personal_log($data = '')
	{
		$query = $this->db->insert('personallogs', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('personallogs');
		
		return $query;
	}
	
	function add_log_comment($data = '')
	{
		$this->db->insert('personallogs_comments', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('personallogs_comments');
		
		/* return the number of affected rows to show success/failure (should be 1) */
		return $this->db->affected_rows();
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_log($id = '', $data = '')
	{
		$this->db->where('log_id', $id);
		$query = $this->db->update('personallogs', $data);
		
		$this->dbutil->optimize_table('personallogs');
		
		return $query;
	}
	
	function update_log_comment($id = '', $data = '')
	{
		$this->db->where('lcomment_id', $id);
		$query = $this->db->update('personallogs_comments', $data);
		
		$this->dbutil->optimize_table('personallogs_comments');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_log($id = '')
	{
		/* grab the comments associated with the log */
		$comments = $this->db->get_where('personallogs_comments', array('lcomment_log' => $id));
		
		/* loop through and the delete the comments associated with the log */
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('personallogs_comments', array('lcomment_id' => $r->lcomment_id));
			}
		}
		
		/* now delete the log */
		$query = $this->db->delete('personallogs', array('log_id' => $id));
		
		/* optimize the table */
		$this->dbutil->optimize_table('personallogs');
		
		return $query;
	}
	
	function delete_log_comment($id = '')
	{
		$query = $this->db->delete('personallogs_comments', array('lcomment_id' => $id));
		
		$this->dbutil->optimize_table('personallogs_comments');
		
		return $query;
	}
}

/* End of file personallogs_model_base.php */
/* Location: ./application/models/base/personallogs_model_base.php */