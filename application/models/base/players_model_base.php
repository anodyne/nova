<?php
/*
|---------------------------------------------------------------
| PLAYERS MODEL
|---------------------------------------------------------------
|
| File: models/players_model_base.php
| System Version: 1.0
|
| Model used to access the players table.
|
*/

class Players_model_base extends Model {

	function Players_model_base()
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
	
	function verify_login_details($email = '', $password = '')
	{
		$this->db->select('player_id');
		$this->db->from('players');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		$query = $this->db->get();
		
		return $query;
	}

	function verify_sysadmin($player = '')
	{
		$this->db->select('player_id');
		$this->db->from('players');
		$this->db->where('player_id', $player);
		$this->db->where('is_sysadmin', 'y');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function is_sysadmin($player = '')
	{
		$this->db->select('player_id');
		$this->db->from('players');
		$this->db->where('player_id', $player);
		$this->db->where('is_sysadmin', 'y');
		
		$query = $this->db->get();
		
		if ($query->num_rows() == 1)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function check_email($email = '')
	{
		/* check to see if the email address exists */
		$this->db->select('player_id');
		$this->db->from('players');
		$this->db->where('email', $email);
		
		/* run the query */
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->player_id;
		}
		
		return FALSE;
	}
	
	function check_password($email = '', $password = '')
	{
		/* check to see if the email address exists */
		$this->db->select('player_id');
		$this->db->from('players');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		/* run the query */
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_player($id = '', $return = '')
	{
		$query = $this->db->get_where('players', array('player_id' => $id));
		
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
	
	function get_user_details($id = '')
	{
		$query = $this->db->get_where('players', array('player_id' => $id));
		
		return $query;
	}
	
	function get_user_details_by_email($email = '')
	{
		$this->db->from('players');
		$this->db->where('email', $email);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_player_name($id = '')
	{
		$query = $this->db->get_where('players', array('player_id' => $id));
		$item = $query->row();
		
		return $item->name;
	}
	
	function get_main_character($id = '')
	{
		$query = $this->db->get_where('players', array('player_id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->main_char;
		}
		
		return FALSE;
	}
	
	function get_loa($id = '')
	{
		$this->db->select('loa');
		$this->db->from('players');
		$this->db->where('player_id', $id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
		
			return $row->loa;
		}
		
		return FALSE;
	}
	
	function get_gm_emails()
	{
		$query = $this->db->get_where('players', array('is_game_master' => 'y'));
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{ /* put them into an array */
				$array[] = $item->email;
			}
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_webmasters_emails()
	{
		$query = $this->db->get_where('players', array('is_webmaster' => 'y'));
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{ /* put them into an array */
				$array[] = $item->email;
			}
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_emails_with_access($access = '', $level = '')
	{
		/* first, get the access id */
		$this->db->from('access_pages');
		$this->db->where('page_url', $access);
		
		if ($level > '')
		{
			$this->db->where('page_level >=', $level);
		}
		
		$access = $this->db->get();
		
		if ($access->num_rows() > 0)
		{
			$access_row = $access->row();
			$access_id = $access_row->page_id;
			
			/* next, get all the roles with that access */
			$roles = $this->db->get('access_roles');
			
			if ($roles->num_rows() > 0)
			{
				$array = array();
				
				foreach ($roles->result() as $role)
				{
					if (strstr($role->role_access, $access_id) !== FALSE)
					{
						$array[] = $role->role_id;
					}
				}
				
				/* get all active crew */
				$crew = $this->db->get_where('players', array('status' => 'active'));
				
				if ($crew->num_rows() > 0)
				{
					$people = array();
					
					foreach ($crew->result() as $c)
					{
						if (in_array($c->access_role, $array))
						{
							$people[$c->player_id] = $c->email;
						}
					}
					
					return $people;
				}
				
				return FALSE;
			}
			
			return FALSE;
		}
		
		return FALSE;
	}
	
	function get_command_staff_emails()
	{
		/* get all positions that have a type of senior */
		$p_query = $this->db->get_where('positions_'. GENRE, array('pos_type' => 'senior'));
		
		if ($p_query->num_rows() > 0)
		{
			foreach ($p_query->result() as $position)
			{ /* dump the positions into an array */
				$positions[] = $position->pos_id;
			}
			
			/* set the players array */
			$players = array();
			
			foreach ($positions as $a)
			{ /* get all characters with senior positions */
				$this->db->from('characters');
				$this->db->where('crew_type', 'active');
				$this->db->where('position_1', $a);
				$this->db->or_where('position_2', $a);
				
				$c_query = $this->db->get();
				
				if ($c_query->num_rows() > 0)
				{
					foreach ($c_query->result() as $char)
					{
						if (!empty($char->player))
						{ /* put the characters into the array */
							$email = $this->db->get_where('players', array('player_id' => $char->player));
							$row = $email->row();
							
							if (!in_array($row->email, $players))
								{ /* if it isn't in the array already, put it there */
								$players[] = $row->email;
							}
						}
					}
				}
			}
			
			return $players;
		}
		
		return FALSE;
	}
	
	function get_email_address($referer = '', $id = '')
	{
		$this->db->select('email');
		$this->db->from('players');
		
		if ($referer == 'character')
		{
			$this->db->join('characters', 'characters.player = players.player_id');
			$this->db->where('charid', $id);
		}
		
		if ($referer == 'player')
		{
			$this->db->where('player_id', $id);
		}
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->email;
		}
		
		return FALSE;
	}
	
	function get_crew_emails($email_prefs = FALSE, $pref_name = '')
	{
		$this->db->from('players');
		$this->db->where('status', 'active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $a)
			{
				$array[$a->player_id] = $a->email;
			}
			
			if ($email_prefs === TRUE)
			{
				foreach ($array as $k => $v)
				{
					/* get their prefs */
					$pref = $this->get_pref($pref_name, $k);
					
					if ($pref == 'y')
					{
						/* don't do anything */
					}
					else
					{
						unset($array[$k]);
					}
				}
			}
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_pref($key = '', $player = '')
	{
		$this->db->from('player_prefs_values');
		$this->db->where('prefvalue_key', $key);
		$this->db->where('prefvalue_player', $player);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->prefvalue_value;
		}
		
		return FALSE;
	}
	
	function get_player_id($character = '')
	{
		$query = $this->db->get_where('characters', array('charid' => $character));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->player;
		}
		
		return FALSE;
	}
	
	function get_player_id_from_email($email = '')
	{
		$query = $this->db->get_where('players', array('email' => $email));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->player_id;
		}
		
		return FALSE;
	}
	
	function get_main_characters()
	{
		$this->db->from('players');
		$this->db->where('main_char >', 0);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_all_characters($player = '')
	{
		$this->db->from('players');
		$this->db->where('player_id', $player);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			$retval = (!empty($row->characters)) ? $row->characters : FALSE;
			
			return $retval;
		}
		
		return FALSE;
	}
	
	function get_my_links($id = '')
	{
		$query = $this->db->get_where('players', array('player_id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$array = explode(',', $row->my_links);
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_online_players($time = 5)
	{
		$final_time = now() - ($time * 60);
		
		$this->db->from('sessions');
		$this->db->where('last_activity >=', $final_time);
		
		$query = $this->db->get();
		
		$array = array();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
			{
				$item = unserialize($row->user_data);
				
				$array[] = $item['player_id'];
			}
		}
		
		return $array;
	}
	
	function get_players($status = 'active')
	{
		$this->db->from('players');
		
		if (!empty($status))
		{
			$this->db->where('status', $status);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_last_loa($player = '', $blank = FALSE)
	{
		$this->db->from('player_loa');
		$this->db->where('loa_player', $player);
		
		if ($blank === TRUE)
		{
			$this->db->where('loa_end_date', NULL);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function checking_moderation($type = '', $data = '')
	{
		if (!is_array($data))
		{
			$data = explode(',', $data);
		}
		
		foreach ($data as $key => $value)
		{
			if ($type == 'post')
			{
				$value = $this->get_player_id($value);
			}
			
			$query = $this->db->get_where('players', array('player_id' => $value));
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				
				switch ($type)
				{
					case 'post':
						$retval = ($row->moderate_posts == 'y') ? TRUE : FALSE;
						break;
						
					case 'log':
						$retval = ($row->moderate_logs == 'y') ? TRUE : FALSE;
						break;
						
					case 'news':
						$retval = ($row->moderate_news == 'y') ? TRUE : FALSE;
						break;
						
					case 'post_comment':
						$retval = ($row->moderate_post_comments == 'y') ? TRUE : FALSE;
						break;
						
					case 'log_comment':
						$retval = ($row->moderate_log_comments == 'y') ? TRUE : FALSE;
						break;
						
					case 'news_comment':
						$retval = ($row->moderate_news_comments == 'y') ? TRUE : FALSE;
						break;
				}
				
				if ($retval === TRUE)
				{
					return 'pending';
				}
			}
		}
		
		return 'activated';
	}
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_players($timeframe = '', $this_month = '', $last_month = '')
	{
		$this->db->from('players');
		
		if ($timeframe == 'current')
		{
			$this->db->where('status', 'active');
		}
		elseif ($timeframe == 'previous')
		{
			$this->db->where('join_date <', $this_month);
			$this->db->where('status', 'active');
			$this->db->or_where('leave_date >', $last_month);
			$this->db->where('leave_date <', $this_month);
		}
		
		$query = $this->db->get();
		
		return $query->num_rows();
	}
	
	function count_all_players($status = 'active')
	{
		$this->db->from('players');
		$this->db->where('status', $status);
		
		return $this->db->count_all_results();
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function create_loa_record($data = '')
	{
		$query = $this->db->insert('player_loa', $data);
		
		$this->dbutil->optimize_table('player_loa');
		
		/* this returns the number of affected rows, not the query object */
		return $query;
	}
	
	function create_player($data = '')
	{
		$query = $this->db->insert('players', $data);
		
		$this->dbutil->optimize_table('players');
		
		/* this returns the number of affected rows, not the query object */
		return $query;
	}
	
	function create_player_prefs($id = '')
	{
		/* get the prefs from the table */
		$prefs = $this->db->get('player_prefs');
		
		/* set the number of affected rows */
		$insert = 0;
		
		if ($prefs->num_rows() > 0)
		{
			foreach ($prefs->result() as $p)
			{ /* create an array of pref keys */
				$insert_array = array(
					'prefvalue_player' => $id,
					'prefvalue_key' => $p->pref_key,
					'prefvalue_value' => $p->pref_default
				);
					
				/* insert the data into the database */
				$insert+= $this->db->insert('player_prefs_values', $insert_array);
			}
		}
		
		$this->dbutil->optimize_table('player_prefs');
		
		return $insert;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_player($id = '', $data = '')
	{
		$this->db->where('player_id', $id);
		$query = $this->db->update('players', $data);
		
		$this->dbutil->optimize_table('players');
		
		return $query;
	}
	
	function update_all_player_prefs($id = '', $value = 'n')
	{
		$data = array('prefvalue_value' => $value);
		
		$this->db->where('prefvalue_player', $id);
		$query = $this->db->update('player_prefs_values', $data);
		
		$this->dbutil->optimize_table('player_prefs_values');
		
		return $query;
	}
	
	function update_player_pref($player = '', $key = '', $data = '')
	{
		$this->db->where('prefvalue_key', $key);
		$this->db->where('prefvalue_player', $player);
		$query = $this->db->update('player_prefs_values', $data);
		
		$this->dbutil->optimize_table('player_prefs_values');
		
		return $query;
	}
	
	function update_first_launch($id = '')
	{
		$data = array('first_launch' => 0);
		
		$this->db->where('player_id', $id);
		$query = $this->db->update('players', $data);
		
		$this->dbutil->optimize_table('players');
		
		return $query;
	}
	
	function update_loa_record($id = '', $data = '')
	{
		$this->db->where('loa_id', $id);
		$query = $this->db->update('player_loa', $data);
		
		$this->dbutil->optimize_table('player_loa');
		
		return $query;
	}
	
	function update_login_record($id = '', $time = '')
	{
		$data = array('last_login' => $time);
		
		$this->db->where('player_id', $id);
		$query = $this->db->update('players', $data);
		
		$this->dbutil->optimize_table('players');
		
		return $query;
	}
	
	function update_all_players($data = '', $where = array('' => ''))
	{
		if (is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		$query = $this->db->update('players', $data);
		
		$this->dbutil->optimize_table('players');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_player($id = '')
	{
		$query = $this->db->delete('players', array('player_id' => $id));
		
		$this->dbutil->optimize_table('players');
		
		return $query;
	}
}

/* End of file players_model_base.php */
/* Location: ./application/models/base/players_model_base.php */