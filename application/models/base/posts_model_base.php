<?php
/*
|---------------------------------------------------------------
| POSTS MODEL
|---------------------------------------------------------------
|
| File: models/posts_model_base.php
| System Version: 1.0
|
| Model used to access the posts and posts comments tables.
|
*/

class Posts_model_base extends Model {

	function Posts_model_base()
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
	
	function get_author_emails($post = '')
	{
		$post = $this->db->get_where('posts', array('post_id' => $post));
		
		if ($post->num_rows() > 0)
		{
			/* grab the row */
			$row = $post->row();
			
			/* put the authors string into an array */
			$authors = explode(',', $row->post_authors);
			
			/* create an arrray to use */
			$array = array();
			
			foreach ($authors as $value)
			{
				$this->db->select('email');
				$this->db->from('users');
				$this->db->like('characters', $value);
				
				$query = $this->db->get();
				
				if ($query->num_rows() > 0)
				{
					$item = $query->row();
					
					if (!in_array($item->email, $array))
					{
						$array[] = $item->email;
					}
				}
			}
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_author_user_ids($post = '')
	{
		$post = $this->db->get_where('posts', array('post_id' => $post));
		
		if ($post->num_rows() > 0)
		{
			/* grab the row */
			$row = $post->row();
			
			/* put the authors string into an array */
			$authors = explode(',', $row->post_authors);
			
			/* create an arrray to use */
			$array = array();
			
			foreach ($authors as $value)
			{
				$this->db->select('user_id');
				$this->db->from('users');
				$this->db->like('characters', $value);
				
				$query = $this->db->get();
				
				if ($query->num_rows() > 0)
				{
					$item = $query->row();
					
					if (!in_array($item->userid, $array))
					{
						$array[] = $item->userid;
					}
				}
			}
			
			return $array;
		}
		
		return FALSE;
	}
	
	function get_character_posts($character = '', $limit = 0)
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'activated');
		
		if (is_array($character))
		{
			/* make sure the keys are set up right */
			$character = array_values($character);
			
			/* count the items in the array */
			$count = count($character);
			
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
				
				$string.= $or . "(post_authors LIKE '%,$character[$i]' OR post_authors LIKE '$character[$i],%' OR post_authors = $character[$i])";
			}
			
			$this->db->where("($string)", NULL);
		}
		else
		{
			$this->db->like('post_authors', $character);
		}
		
		$this->db->order_by('post_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_link_id($id = '', $direction = 'next')
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
					break;
				
				case 'prev':
					$this->db->where('post_date <', $fetch->post_date);
					$this->db->order_by('post_id', 'desc');
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
		
		return FALSE;
	}
	
	function get_post($id = '', $return = '')
	{
		$query = $this->db->get_where('posts', array('post_id' => $id));
		
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
	
	function get_post_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('posts_comments', array('pcomment_id' => $id));
		
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
	
	function get_post_comments($id = '', $status = 'activated', $order_field = 'pcomment_date', $order = 'asc')
	{
		$this->db->from('posts_comments');
		
		if (!empty($id))
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
	
	function get_post_list($mission = '', $order = 'desc', $limit = 0, $offset = 0, $status = '')
	{
		$this->db->from('posts');
		
		if (!empty($mission))
		{
			$this->db->where('post_mission', $mission);
		}
		
		if (!empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$this->db->order_by('post_date', $order);
		
		if (!empty($limit))
		{
			$this->db->limit($limit, $offset);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_saved_posts($id = '', $limit = 0)
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'saved');
		
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
					
					$string.= $or . "(post_authors LIKE '%,$id[$i]' OR post_authors LIKE '$id[$i],%' OR post_authors = $id[$i])";
				}
				
				$this->db->where("($string)", NULL);
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
	
	/*
	|---------------------------------------------------------------
	| COUNT METHODS
	|---------------------------------------------------------------
	*/
	
	function count_all_post_comments($status = 'activated', $id = '')
	{
		$this->db->from('posts_comments');
		$this->db->where('pcomment_status', $status);
		
		if (!empty($id))
		{
			$this->db->where('pcomment_post', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	function count_all_posts($mission = '', $status = 'activated')
	{
		$this->db->from('posts');
		
		if ($mission > '')
		{
			$this->db->where('post_mission', $mission);
		}
		
		if (!empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		return $this->db->count_all_results();
	}
	
	function count_character_posts($character = '', $status = 'activated')
	{
		$count_final = 0;
		
		$this->db->from('posts');
		$this->db->where('post_status', $status);
		
		if (is_array($character))
		{
			/* make sure the keys are set up right */
			$character = array_values($character);
			
			/* count the items in the array */
			$count = count($character);
			
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
				
				$string.= $or . "(post_authors LIKE '%,$character[$i]' OR post_authors LIKE '$character[$i],%' OR post_authors = $character[$i])";
			}
			
			$this->db->where("($string)", NULL);
		}
		else
		{
			$this->db->like('post_authors', $character);
		}
		
		$count_final += $this->db->count_all_results();
		
		return $count_final;
	}
	
	function count_mission_posts($mission = '', $count_pref = '')
	{
		/* run the query */
		$query = $this->db->get_where('posts', array('post_mission' => $mission));
		
		/* set the count variable */
		$count = 0;
		
		if ($query->num_rows() > 0)
		{ /* if there are results, continue */
			switch ($count_pref)
			{ /* take action based on how nova is set up to count posts */
				case 'single':
					$count = $query->num_rows();
					
					break;
					
				case 'multiple':
					$array = array();
					
					foreach ($query->result() as $row)
					{ /* we need to break out the authors if we are counting by multiple */
						if (substr_count($row->post_authors, ',') > 0)
						{
							$temp = explode(',', $row->post_authors);
							
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
	
	function count_posts($start = '', $end = '', $count_pref = '', $status = 'activated')
	{
		$this->db->from('posts');
		
		if (!empty($status))
		{
			$this->db->where('post_status', $status);
		}
		
		$this->db->where('post_date >', $start);
		$this->db->where('post_date < ', $end);
		
		$query = $this->db->get();
		
		/* set the count variable */
		$count = 0;
		
		if ($query->num_rows() > 0)
		{ /* if there are results, continue */
			switch ($count_pref)
			{ /* take action based on how nova is set up to count posts */
				case 'single':
					$count = $query->num_rows();
					
					break;
					
				case 'multiple':
					$array = array();
					
					foreach ($query->result() as $row)
					{ /* we need to break out the authors if we are counting by multiple */
						if (substr_count($row->post_authors, ',') > 0)
						{
							$temp = explode(',', $row->post_authors);
							
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
	
	function count_unattended_posts($id = '')
	{
		$this->db->from('posts');
		
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
				$string2 = "";
				
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
					
					$string.= $or . "post_authors LIKE '%$id[$i]%'";
					$string2.= $or . "post_saved NOT LIKE '%$id[$i]%'";
				}
				
				$this->db->where("($string)", NULL);
				$this->db->where("($string2)", NULL);
			}
			else
			{
				$this->db->like('post_authors', $id);
				$this->db->where('post_saved !=', $id);
			}
		}
		
		return $this->db->count_all_results();
	}
	
	function count_user_post_comments($user = '')
	{
		$count = 0;
		
		$this->db->from('posts_comments');
		$this->db->where('pcomment_status', 'activated');
		$this->db->where('pcomment_author_user', $user);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_user_posts($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		$this->db->from('posts');
		$this->db->where('post_status', $status);
		
		if (!empty($timeframe))
		{
			$this->db->where('post_date >=', $timeframe);
		}
		
		$this->db->like('post_authors_users', $id);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	/*
	|---------------------------------------------------------------
	| SEARCH METHODS
	|---------------------------------------------------------------
	*/
	
	function search_posts($component = '', $input = '')
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function add_post_comment($data = '')
	{
		/* run the insert query */
		$this->db->insert('posts_comments', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('posts_comments');
		
		/* return the number of affected rows to show success/failure (should be 1) */
		return $this->db->affected_rows();
	}
	
	function create_mission_entry($data = '')
	{
		/* run the insert query */
		$this->db->insert('posts', $data);
		
		/* return the number of affected rows to show success/failure (should be 1) */
		return $this->db->affected_rows();
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_post($id = '', $data = '')
	{
		$this->db->where('post_id', $id);
		$query = $this->db->update('posts', $data);
		
		$this->dbutil->optimize_table('posts');
		
		return $query;
	}
	
	function update_post_comment($id = '', $data = '')
	{
		$this->db->where('pcomment_id', $id);
		$query = $this->db->update('posts_comments', $data);
		
		$this->dbutil->optimize_table('posts_comments');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function delete_post($id = '')
	{
		/* grab the comments associated with the post */
		$comments = $this->db->get_where('posts_comments', array('pcomment_post' => $id));
		
		/* loop through and the delete the comments associated with the post */
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('posts_comments', array('pcomment_id' => $r->pcomment_id));
			}
		}
		
		/* now delete the post */
		$query = $this->db->delete('posts', array('post_id' => $id));
		
		/* optimize the table */
		$this->dbutil->optimize_table('posts');
		
		return $query;
	}
	
	function delete_post_comment($id = '')
	{
		$query = $this->db->delete('posts_comments', array('pcomment_id' => $id));
		
		$this->dbutil->optimize_table('posts_comments');
		
		return $query;
	}
}

/* End of file posts_model_base.php */
/* Location: ./application/models/base/posts_model_base.php */