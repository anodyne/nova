<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_posts_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}

	public function get_author_emails($post = '')
	{
		$post = $this->db->get_where('posts', array('post_id' => $post));
		
		if ($post->num_rows() > 0)
		{
			$row = $post->row();
			
			$authors = explode(',', $row->post_authors);
			
			$array = array();
			$users = array();
			
			foreach ($authors as $a)
			{
				$q = $this->db->get_where('characters', array('charid' => $a));
				
				if ($q->num_rows() > 0)
				{
					$i = $q->row();
					
					if ( ! empty($i->user))
					{
						$users[$i->user] = $i->user;
					}
				}
			}
			
			foreach ($users as $value)
			{
				$this->db->select('email');
				$this->db->from('users');
				$this->db->where('userid', $value);
				
				$query = $this->db->get();
				
				if ($query->num_rows() > 0)
				{
					$item = $query->row();
					
					if ( ! in_array($item->email, $array))
					{
						$array[] = $item->email;
					}
				}
			}
			
			return $array;
		}
		
		return false;
	}
	
	/**
	 * Get all posts from specific character(s).
	 *
	 * @access	public
	 * @param	mixed	either the character ID or an array of character IDs
	 * @param	int		the number of records to limit the result to
	 * @param	string	the status to pull
	 * @param	int		the offset
	 * @return	object	the result object
	 */
	public function get_character_posts($character = '', $limit = 0, $status = 'activated', $offset = 0)
	{
		$this->db->from('posts');
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		if (is_array($character))
		{
			$character = array_values($character);
			
			$count = count($character);
			
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
				
				$string.= $or . "(post_authors LIKE '%,$character[$i]' OR post_authors LIKE '$character[$i],%' OR post_authors LIKE '%,$character[$i],%' OR post_authors = $character[$i])";
			}
			
			$this->db->where("($string)", null);
		}
		else
		{
			$string = "(post_authors LIKE '%,$character' OR post_authors LIKE '$character,%' OR post_authors LIKE '%,$character,%' OR post_authors = $character)";
			
			$this->db->where("$string", null);
		}
		
		$this->db->order_by('post_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_link_id($id = '', $direction = 'next')
	{
		$get = $this->db->get_where('posts', array('post_id' => $id));
		
		if ($get->num_rows() > 0)
		{
			$fetch = $get->row();
			
			$this->db->select('post_id');
			$this->db->from('posts');
			$this->db->where('post_status', 'activated');
			
			switch ($direction)
			{
				case 'next':
					$this->db->where('post_date >', $fetch->post_date);
					$this->db->order_by('post_date', 'asc');
				break;
				
				case 'prev':
					$this->db->where('post_date <', $fetch->post_date);
					$this->db->order_by('post_date', 'desc');
				break;
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->post_id;
			}
		}
		
		return false;
	}
	
	public function get_post($id = '', $return = '')
	{
		$query = $this->db->get_where('posts', array('post_id' => $id));
		
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
	
	public function get_post_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('posts_comments', array('pcomment_id' => $id));
		
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
	
	public function get_post_comments($id = '', $status = 'activated', $order_field = 'pcomment_date', $order = 'asc')
	{
		$this->db->from('posts_comments');
		
		if ( ! empty($id))
		{
			$this->db->where('pcomment_post', $id);
		}
		
		$this->db->where('pcomment_status', $status);
		
		$this->db->order_by($order_field, $order);
		
		if ($order_field != 'pcomment_date')
		{
			$this->db->order_by('pcomment_date', $order);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_post_list($mission = '', $order = 'desc', $limit = 0, $offset = 0, $status = '')
	{
		$this->db->from('posts');
		
		if ( ! empty($mission))
		{
			$this->db->where('post_mission', $mission);
		}
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$this->db->order_by('post_date', $order);
		
		if ( ! empty($limit))
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_saved_posts($id = '', $limit = 0)
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'saved');
		
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
					
					$string.= $or . "(post_authors LIKE '%,$id[$i]' OR post_authors LIKE '$id[$i],%' OR post_authors LIKE '%,$id[$i],%' OR post_authors = $id[$i])";
				}
				
				$this->db->where("($string)", null);
			}
			else
			{
				$this->db->like('post_authors', $id);
			}
		}
		
		$this->db->order_by('post_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get all posts from specific user(s).
	 *
	 * @access	public
	 * @since	2.0
	 * @param	int		either the character ID or an array of character IDs
	 * @param	int		the number of records to limit the result to
	 * @param	string	the status to pull
	 * @return	object	the result object
	 */
	public function get_user_posts($user = '', $limit = 0, $status = 'activated')
	{
		$this->db->from('posts');
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$string = "(post_authors_users LIKE '%,$user' OR post_authors_users LIKE '$user,%' OR post_authors_users = '%,$user,%' OR post_authors_users = $user)";
		$this->db->where("$string", null);
		
		$this->db->order_by('post_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function count_all_post_comments($status = 'activated', $id = '')
	{
		$this->db->from('posts_comments');
		$this->db->where('pcomment_status', $status);
		
		if ( ! empty($id))
		{
			$this->db->where('pcomment_post', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_all_posts($mission = '', $status = 'activated')
	{
		$this->db->from('posts');
		
		if ($mission > '')
		{
			$this->db->where('post_mission', $mission);
		}
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_character_posts($character = '', $status = 'activated')
	{
		$count_final = 0;
		
		if ( ! empty($character) and $character !== false and $character !== null)
		{
			$this->db->from('posts');
			$this->db->where('post_status', $status);
		
			if (is_array($character))
			{
				$character = array_values($character);
			
				$count = count($character);
			
				$string = "";
			
				for ($i=0; $i < $count; $i++)
				{
					$or = ($i > 0) ? ' OR ' : '';
				
					$string.= $or . "(post_authors LIKE '%,$character[$i]' OR post_authors LIKE '$character[$i],%' OR post_authors LIKE '%,$character[$i],%' OR post_authors = $character[$i])";
				}
			
				$this->db->where("($string)", null);
			}
			else
			{
				$string = "(post_authors LIKE '%,$character' OR post_authors LIKE '$character,%' OR post_authors LIKE '%,$character,%' OR post_authors = $character)";
			
				$this->db->where("$string", null);
			}
		
			$count_final += $this->db->count_all_results();
		}
		
		return $count_final;
	}
	
	public function count_mission_posts($mission = '', $count_pref = '', $status = 'activated')
	{
		$this->db->from('posts');
		$this->db->where('post_mission', $mission);
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$query = $this->db->get();
		
		$count = 0;
		
		if ($query->num_rows() > 0)
		{
			switch ($count_pref)
			{
				case 'single':
					$count = $query->num_rows();
				break;
					
				case 'multiple':
					$array = array();
					
					foreach ($query->result() as $row)
					{
						if (substr_count($row->post_authors_users, ',') > 0)
						{
							$temp = explode(',', $row->post_authors_users);
							
							foreach ($temp as $a)
							{
								$array[] = $a;
							}
						}
						else
						{
							$array[] = $row->post_authors;
						}
					}
					
					$count = count($array);
				break;
			}
		}
		
		return $count;
	}
	
	public function count_posts($start = '', $end = '', $count_pref = '', $status = 'activated')
	{
		$this->db->from('posts');
		
		if ( ! empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$this->db->where('post_date >', $start);
		$this->db->where('post_date < ', $end);
		
		$query = $this->db->get();
		
		$count = 0;
		
		if ($query->num_rows() > 0)
		{
			switch ($count_pref)
			{
				case 'single':
					$count = $query->num_rows();
				break;
					
				case 'multiple':
					$array = array();
					
					foreach ($query->result() as $row)
					{
						if (substr_count($row->post_authors_users, ',') > 0)
						{
							$temp = explode(',', $row->post_authors_users);
							
							foreach ($temp as $a)
							{
								$array[] = $a;
							}
						}
						else
						{
							$array[] = $row->post_authors_users;
						}
					}
					
					$count = count($array);
				break;
			}
		}
		
		return $count;
	}
	
	public function count_unattended_posts($id = '', $status = 'saved')
	{
		$this->db->from('posts');
		$this->db->where('post_status', $status);
		
		if ( ! empty($id))
		{
			if (is_array($id))
			{
				$id = array_values($id);
				
				$count = count($id);
				
				$string = "";
				$string2 = "";
				
				for ($i=0; $i < $count; $i++)
				{
					$or = ($i > 0) ? ' OR ' : '';
					$and = ($i > 0) ? ' AND ' : '';
					
					$string.= $or . "(post_authors LIKE '%,$id[$i]' OR post_authors LIKE '$id[$i],%' OR post_authors LIKE '%,$id[$i],%' OR post_authors = $id[$i])";
					$string2.= $and . "post_saved != '$id[$i]'";
				}
				
				$this->db->where("($string)", null);
				$this->db->where("($string2)", null);
			}
			else
			{
				$string.= $or . "(post_authors LIKE '%,$id' OR post_authors LIKE '$id,%' OR post_authors LIKE '%,$id,%' OR post_authors = $id)";
				
				$this->db->where("($string)", null);
				$this->db->where('post_saved !=', $id);
			}
		}
		
		return $this->db->count_all_results();
	}
	
	public function count_user_post_comments($user = '')
	{
		$count = 0;
		
		if ( ! empty($user) && $user !== false && $user !== null)
		{
			$this->db->from('posts_comments');
			$this->db->where('pcomment_status', 'activated');
			$this->db->where('pcomment_author_user', $user);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function count_user_posts($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		if ( ! empty($id) && $id !== false && $id !== null)
		{
			$this->db->from('posts');
			$this->db->where('post_status', $status);
		
			if ( ! empty($timeframe))
			{
				$this->db->where('post_date >=', $timeframe);
			}
		
			$string = "(post_authors_users LIKE '%,$id' OR post_authors_users LIKE '$id,%' OR post_authors_users LIKE '%,$id,%' OR post_authors_users = $id)";
			
			$this->db->where("($string)", null);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function search_posts($component = '', $input = '')
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_post_comment($data = '')
	{
		$this->db->insert('posts_comments', $data);
		
		$this->dbutil->optimize_table('posts_comments');
		
		return $this->db->affected_rows();
	}
	
	public function create_mission_entry($data = '')
	{
		$this->db->insert('posts', $data);
		
		return $this->db->affected_rows();
	}
	
	public function update_post($id = '', $data = '')
	{
		$this->db->where('post_id', $id);
		$query = $this->db->update('posts', $data);
		
		$this->dbutil->optimize_table('posts');
		
		return $query;
	}
	
	public function update_post_comment($id = '', $data = '')
	{
		$this->db->where('pcomment_id', $id);
		$query = $this->db->update('posts_comments', $data);
		
		$this->dbutil->optimize_table('posts_comments');
		
		return $query;
	}
	
	/**
	 * Update a post lock.
	 *
	 * @access	public
	 * @since	2.0
	 * @param	int		the post ID
	 * @param	int		the user ID
	 * @param	bool	retain the lock?
	 */
	public function update_post_lock($post, $user, $retain_lock = true)
	{
		$data = array(
			'post_lock_user' => $user,
			'post_lock_date' => ($retain_lock === true) ? now() : 0
		);
		
		$this->db->where('post_id', $post);
		$query = $this->db->update('posts', $data);
		
		$this->dbutil->optimize_table('posts');
		
		return $query;
	}
	
	public function delete_post($id = '')
	{
		$comments = $this->db->get_where('posts_comments', array('pcomment_post' => $id));
		
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('posts_comments', array('pcomment_id' => $r->pcomment_id));
			}
		}
		
		$query = $this->db->delete('posts', array('post_id' => $id));
		
		$this->dbutil->optimize_table('posts');
		
		return $query;
	}
	
	public function delete_post_comment($id = '')
	{
		$query = $this->db->delete('posts_comments', array('pcomment_id' => $id));
		
		$this->dbutil->optimize_table('posts_comments');
		
		return $query;
	}
}
