<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Users model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_users_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function check_email($email = '')
	{
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('email', $email);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->userid;
		}
		
		return false;
	}
	
	public function check_password($email = '', $password = '')
	{
		$this->db->select('userid');
		$this->db->from('users');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function checking_moderation($type = '', $data = '')
	{
		if ( ! is_array($data))
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
						$retval = ($row->moderate_posts == 'y') ? true : false;
					break;
						
					case 'log':
						$retval = ($row->moderate_logs == 'y') ? true : false;
					break;
						
					case 'news':
						$retval = ($row->moderate_news == 'y') ? true : false;
					break;
						
					case 'post_comment':
						$retval = ($row->moderate_post_comments == 'y') ? true : false;
					break;
						
					case 'log_comment':
						$retval = ($row->moderate_log_comments == 'y') ? true : false;
					break;
						
					case 'news_comment':
						$retval = ($row->moderate_news_comments == 'y') ? true : false;
					break;
						
					case 'wiki_comment':
						$retval = ($row->moderate_wiki_comments == 'y') ? true : false;
					break;
				}
				
				if ($retval === true)
				{
					return 'pending';
				}
			}
		}
		
		return 'activated';
	}
	
	public function get_crew_emails($email_prefs = false, $pref_name = '')
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
			
			if ($email_prefs === true)
			{
				foreach ($array as $k => $v)
				{
					$pref = $this->get_pref($pref_name, $k);
					
					if ($pref == 'y')
					{
						// don't do anything
					}
					else
					{
						unset($array[$k]);
					}
				}
			}
			
			return $array;
		}
		
		return false;
	}
	
	public function get_email_address($referer = '', $id = '')
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
		
		return false;
	}
	
	public function get_emails_with_access($access = '', $level = '')
	{
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
			
			$roles = $this->db->get('access_roles');
			
			if ($roles->num_rows() > 0)
			{
				$array = array();
				
				foreach ($roles->result() as $role)
				{
					if (strstr($role->role_access, $access_id) !== false)
					{
						$array[] = $role->role_id;
					}
				}
				
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
				
				return false;
			}
			
			return false;
		}
		
		return false;
	}
	
	public function get_gm_emails()
	{
		$this->db->from('users');
		$this->db->where('is_game_master', 'y');
		$this->db->where('status', 'active');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				$array[] = $item->email;
			}
			
			return $array;
		}
		
		return false;
	}
	
	public function get_last_loa($user = '', $blank = false)
	{
		$this->db->from('user_loa');
		$this->db->where('loa_user', $user);
		
		if ($blank === true)
		{
			$this->db->where('loa_end_date', null);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_loa($id = '')
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
		
		return false;
	}
	
	public function get_main_character($id = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->main_char;
		}
		
		return false;
	}
	
	public function get_main_characters()
	{
		$this->db->from('users');
		$this->db->join('characters', 'characters.user = users.userid');
		$this->db->where('main_char >', 0);
		$this->db->order_by('characters.rank', 'asc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_my_links($id = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			$array = explode(',', $row->my_links);
			
			return $array;
		}
		
		return false;
	}
	
	public function get_online_users($time = 5)
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
				if ( ! is_null($row->user_data) and ! empty($row->user_data))
				{
					$item = unserialize($row->user_data);
				
					$array[] = (isset($item['userid'])) ? $item['userid'] : false;
				}
			}
		}
		
		return $array;
	}
	
	public function get_pref($key = '', $user = '')
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
		
		return false;
	}
	
	public function get_user($id = '', $return = '')
	{
		$query = $this->db->get_where('users', array('userid' => $id));
		
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
	
	public function get_user_details_by_email($email = '')
	{
		$this->db->from('users');
		$this->db->where('email', $email);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Pull all of a user's LOA records.
	 *
	 * @since	2.0
	 * @access	public
	 * @param	int		the user ID
	 * @return	object	the object with all the data
	 */
	public function get_user_loa_records($id)
	{
		$this->db->from('user_loa');
		$this->db->where('loa_user', $id);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_userid($character = '')
	{
		$query = $this->db->get_where('characters', array('charid' => $character));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->user;
		}
		
		return false;
	}
	
	public function get_userid_from_email($email = '')
	{
		$query = $this->db->get_where('users', array('email' => $email));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->userid;
		}
		
		return false;
	}
	
	public function get_users($status = 'active')
	{
		$this->db->from('users');
		
		if ( ! empty($status))
		{
			$this->db->where('status', $status);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Pulls the user information from the database based on the
	 * crew_type of characters.
	 *
	 * @param	string	the status of the characters to pull
	 * @return	mixed	false if there are no characters, an array of objects if there are
	 */
	public function get_users_from_characters($status = 'active')
	{
		$chars = $this->db->get_where('characters', array('crew_type' => $status));
		
		if ($chars->num_rows() > 0)
		{
			foreach ($chars->result() as $c)
			{
				$user[] = $this->get_user($c->user);
			}
			
			return $user;
		}
		
		return false;
	}
	
	public function count_all_users($status = 'active')
	{
		$this->db->from('users');
		$this->db->where('status', $status);
		
		return $this->db->count_all_results();
	}
	
	public function count_users($timeframe = '', $this_month = '', $last_month = '')
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
	
	public function create_loa_record($data = '')
	{
		$query = $this->db->insert('user_loa', $data);
		
		$this->dbutil->optimize_table('user_loa');
		
		return $query;
	}
	
	public function create_user($data = '')
	{
		$query = $this->db->insert('users', $data);
		
		return $query;
	}
	
	public function create_user_prefs($id = '')
	{
		$prefs = $this->db->get('user_prefs');
		
		$insert = 0;
		
		if ($prefs->num_rows() > 0)
		{
			foreach ($prefs->result() as $p)
			{
				$insert_array = array(
					'prefvalue_user' => $id,
					'prefvalue_key' => $p->pref_key,
					'prefvalue_value' => $p->pref_default
				);
					
				$insert+= $this->db->insert('user_prefs_values', $insert_array);
			}
		}
		
		$this->dbutil->optimize_table('user_prefs');
		
		return $insert;
	}
	
	public function update_all_user_prefs($id = '', $value = 'n')
	{
		$data = array('prefvalue_value' => $value);
		
		$this->db->where('prefvalue_user', $id);
		$query = $this->db->update('user_prefs_values', $data);
		
		$this->dbutil->optimize_table('user_prefs_values');
		
		return $query;
	}
	
	public function update_all_users($data = '', $where = '')
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
	
	public function update_first_launch($id = '')
	{
		$data = array('first_launch' => 0);
		
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	public function update_loa_record($id = '', $data = '')
	{
		$this->db->where('loa_id', $id);
		$query = $this->db->update('user_loa', $data);
		
		$this->dbutil->optimize_table('user_loa');
		
		return $query;
	}
	
	public function update_login_record($id = '', $time = '')
	{
		$data = array('last_login' => $time);
		
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	public function update_user($id = '', $data = '')
	{
		$this->db->where('userid', $id);
		$query = $this->db->update('users', $data);
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	public function update_user_pref($user = '', $key = '', $data = '')
	{
		$this->db->where('prefvalue_key', $key);
		$this->db->where('prefvalue_user', $user);
		$query = $this->db->update('user_prefs_values', $data);
		
		$this->dbutil->optimize_table('user_prefs_values');
		
		return $query;
	}
	
	public function delete_user($id = '')
	{
		$query = $this->db->delete('users', array('userid' => $id));
		
		$this->dbutil->optimize_table('users');
		
		return $query;
	}
	
	public function delete_user_pref_values($id = '')
	{
		$query = $this->db->delete('user_prefs_values', array('prefvalue_user' => $id));
		
		$this->dbutil->optimize_table('user_prefs_values');
		
		return $query;
	}
}
