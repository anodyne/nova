<?php
/*
|---------------------------------------------------------------
| USERS MODEL
|---------------------------------------------------------------
|
| File: models/users_model_base.php
| System Version: 1.0
|
| Model used to access the users table.
|
*/

class Users_model_base extends Model {

	function Users_model_base()
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
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		$query = $this->db->get();
		
		return $query;
	}

	function verify_sysadmin($user = '')
	{
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('userid', $user);
		$this->db->where('is_sysadmin', 'y');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function is_sysadmin($user = '')
	{
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('userid', $user);
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
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('email', $email);
		
		/* run the query */
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->userid;
		}
		
		return FALSE;
	}
	
	function check_password($email = '', $password = '')
	{
		/* check to see if the email address exists */
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		/* run the query */
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_user($id = '', $return = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		
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
		$query = $this->db->get_where('users', array('userid' => $id));
		
		return $query;
	}
	
	function get_user_details_by_email($email = '')
	{
		$this->db->from('users');
		$this->db->where('email', $email);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_user_name($id = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		$item = $query->row();
		
		return $item->name;
	}
	
	function get_main_character($id = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		
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
		$this->db->from('users');
		$this->db->where('userid', $id);
		
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
		$query = $this->db->get_where('users', array('is_game_master' => 'y'));
		
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
		$query = $this->db->get_where('users', array('is_webmaster' => 'y'));
		
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
				$crew = $this->db->get_where('users', array('status' => 'active'));
				
				if ($crew->num_rows() > 0)
				{
					$people = array();
					
					foreach ($crew->result() as $c)
					{
						if (in_array($c->access_role, $array))
						{
							$people[$c->userid] = $c->email;
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
			
			/* set the users array */
			$users = array();
			
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
						if (!empty($char->user))
						{ /* put the characters into the array */
							$email = $this->db->get_where('users', array('userid' => $char->user));
							$row = $email->row();
							
							if (!in_array($row->email, $users))
								{ /* if it isn't in the array already, put it there */
								$users[] = $row->email;
							}
						}
					}
				}
			}
			
			return $users;
		}
		
		return FALSE;
	}
	
	function get_email_address($referer = '', $id = '')
	{
		$this->db->select('email');
		$this->db->from('users');
		
		if ($referer == 'character')
		{
			$this->db->join('characters', 'characters.user = users.userid');
			$this->db->where('charid', $id);
		}
		
		if ($referer == 'user')
		{
			$this->db->where('userid', $id);
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
		$this->db->from('users');
		$this->db->where('status', 'active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $a)
			{
				$array[$a->userid] = $a->email;
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
	
	function get_pref($key = '', $user = '')
	{
		$this->db->from('user_prefs_values');
		$this->db->where('prefvalue_key', $key);
		$this->db->where('prefvalue_user', $user);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->prefvalue_value;
		}
		
		return FALSE;
	}
	
	function get_userid($character = '')
	{
		$query = $this->db->get_where('characters', array('charid' => $character));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->user;
		}
		
		return FALSE;
	}
	
	function get_userid_from_email($email = '')
	{
		$query = $this->db->get_where('users', array('email' => $email));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->userid;
		}
		
		return FALSE;
	}
	
	function get_main_characters()
	{
		$this->db->from('users');
		$this->db->where('main_char >', 0);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_all_characters($user = '')
	{
		$this->db->from('users');
		$this->db->where('userid', $user);
		
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
		$query = $this->db->get_where('users', array('userid' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$array = explode(',', $row->my_links);
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_online_users($time = 5)
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
				
				$array[] = $item['userid'];
			}
		}
		
		return $array;
	}
	
	function get_users($status = 'active')
	{
		$this->db->from('users');
		
		if (!empty($status))
		{
			$this->db->where('status', $status);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_last_loa($user = '', $blank = FALSE)
	{
		$this->db->from('user_loa');
		$this->db->where('loa_user', $user);
		
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
				$value = $this->get_userid($value);
			}
			
			$query = $this->db->get_where('users', array('userid' => $value));
			
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
						
					case 'wiki_comment':
						$retval = ($row->moderate_wiki_comments == 'y') ? TRUE : FALSE;
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
	
	function count_users($timeframe = '', $this_month = '', $last_month = '')
	{
		$this->db->from('users');
		
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
	
	function count_all_users($status = 'active')
	{
		$this->db->from('users');
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
		$query = $this->db->insert('user_loa', $data);
		
		$this->dbutil->optimize_table('user_loa');
		
		/* this returns the number of affected rows, not the query object */
		return $query;
	}
	
	function create_user($data = '')
	{
		$query = $this->db->insert('users', $data);
		
		/* this returns the number of affected rows, not the query object */
		return $query;
	}
	
	function create_user_prefs($id = '')
	{
		/* get the prefs from the table */
		$prefs = $this->db->get('user_prefs');
		
		/* set the number of affected rows */
		$insert = 0;
		
		if ($prefs->num_rows() > 0)
		{
			foreach ($prefs->result() as $p)
			{ /* create an array of pref keys */
				$insert_array = array(
					'prefvalue_user' => $id,
					'prefvalue_key' => $p->pref_key,
					'prefvalue_value' => $p->pref_default
				);
					
				/* insert the data into the database */
				$insert+= $this->db->insert('user_prefs_values', $insert_array);
			}
		}
		
		$this->dbutil->optimize_table('user_prefs');
		
		return $insert;
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_user($id = '', $data = '')
	{
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	function update_all_user_prefs($id = '', $value = 'n')
	{
		$data = array('prefvalue_value' => $value);
		
		$this->db->where('prefvalue_user', $id);
		$query = $this->db->update('user_prefs_values', $data);
		
		$this->dbutil->optimize_table('user_prefs_values');
		
		return $query;
	}
	
	function update_user_pref($user = '', $key = '', $data = '')
	{
		$this->db->where('prefvalue_key', $key);
		$this->db->where('prefvalue_user', $user);
		$query = $this->db->update('user_prefs_values', $data);
		
		$this->dbutil->optimize_table('user_prefs_values');
		
		return $query;
	}
	
	function update_first_launch($id = '')
	{
		$data = array('first_launch' => 0);
		
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	function update_loa_record($id = '', $data = '')
	{
		$this->db->where('loa_id', $id);
		$query = $this->db->update('user_loa', $data);
		
		$this->dbutil->optimize_table('user_loa');
		
		return $query;
	}
	
	function update_login_record($id = '', $time = '')
	{
		$data = array('last_login' => $time);
		
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	function update_all_users($data = '', $where = array('' => ''))
	{
		if (is_array($where))
		{
			foreach ($where as $key => $value)
			{
				$this->db->where($key, $value);
			}
		}
		
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_user($id = '')
	{
		$query = $this->db->delete('users', array('userid' => $id));
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
}

/* End of file users_model_base.php */
/* Location: ./application/models/base/users_model_base.php */