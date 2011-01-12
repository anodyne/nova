<?php
/**
 * News model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.2
 *
 * Updated some of the methods to avoid situations where errors could be
 * thrown if a character or user ID wasn't present
 */

abstract class Nova_news_model extends Model {

	public function __construct()
	{
		parent::Model();
		
		$this->load->dbutil();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function get_category_news($c = '', $session = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->join('characters', 'characters.charid = news.news_author_character');
		$this->db->where('news_status', 'activated');
		
		/* determine which categories should be pulled */
		if ($c > 0)
		{
			$this->db->where('news_cat', $c);
		}
		
		if ($session === FALSE)
		{
			$this->db->where('news_private', 'n');
		}
		
		$this->db->order_by('news_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_link_id($id = '', $direction = 'next', $session = '')
	{
		$get = $this->db->get_where('news', array('news_id' => $id));
		
		if ($get->num_rows() > 0)
		{
			$fetch = $get->row();
			
			$this->db->select('news_id');
			$this->db->from('news');
			$this->db->where('news_status', 'activated');
			
			switch ($direction)
			{
				case 'next':
					$this->db->where('news_date >', $fetch->news_date);
					$this->db->order_by('news_date', 'asc');
				break;
				
				case 'prev':
					$this->db->where('news_date <', $fetch->news_date);
					$this->db->order_by('news_date', 'desc');
				break;
			}
			
			if ($session === FALSE)
			{
				$this->db->where('news_private', 'n');
			}
			
			$this->db->limit(1);
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$row = $query->row();
				return $row->news_id;
			}
		}
		
		return FALSE;
	}
	
	function get_news_categories($display = 'y')
	{
		$this->db->from('news_categories');
		
		if (!empty($display))
		{
			$this->db->where('newscat_display', $display);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_news_category($id = '', $return = '')
	{
		$this->db->from('news_categories');
		$this->db->where('newscat_id', $id);
		
		$query = $this->db->get();
		
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
	
	function get_news_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('news_comments', array('ncomment_id' => $id));
		
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
	
	function get_news_comments($id = '', $status = 'activated', $order_field = 'ncomment_date', $order = 'asc')
	{
		$this->db->from('news_comments');
		
		if (!empty($id))
		{
			$this->db->where('ncomment_news', $id);
		}
		
		$this->db->where('ncomment_status', $status);
		
		$this->db->order_by($order_field, $order);
		
		if ($order_field != 'ncomment_date')
		{
			$this->db->order_by('ncomment_date', $order);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_news_item($id = '', $return = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_id', $id);
		
		$query = $this->db->get();
		
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
	
	function get_news_items($limit = 5, $session = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_status', 'activated');
		
		if ($session === FALSE)
		{
			$this->db->where('news_private', 'n');
		}
		
		$this->db->order_by('news_date', 'desc');
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_news_list($num = '', $offset = 0, $status = 'activated')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		
		if (!empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		$this->db->order_by('news_date', 'desc');
		$this->db->limit($num, $offset);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_user_news($id = '', $limit = 0, $status = 'activated')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		
		if (!empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		$this->db->where('news_author_user', $id);
		$this->db->order_by('news_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Count methods
	 */
	
	function count_character_news($character = '', $status = 'activated')
	{
		$count = 0;
		
		if (is_array($character))
		{
			foreach ($character as $value)
			{
				$this->db->where('news_status', $status);
				$this->db->where('news_author_character', $value);
				$this->db->from('news');
				
				$count += $this->db->count_all_results();
			}
		}
		else
		{
			$this->db->where('news_status', $status);
			$this->db->where('news_author_character', $character);
			$this->db->from('news');
			
			$count += $this->db->count_all_results();
		}
		
		return $count;
	}
	
	function count_news_comments($status = 'activated', $id = '')
	{
		$this->db->from('news_comments');
		
		if (!empty($status))
		{
			$this->db->where('ncomment_status', $status);
		}
		
		if (!empty($id))
		{
			$this->db->where('ncomment_news', $id);
		}
		
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_news_items($status = 'activated')
	{
		$this->db->from('news');
		
		if (!empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_user_news($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		if ( ! empty($id) && $id !== FALSE && $id !== NULL)
		{
			$this->db->from('news');
			$this->db->where('news_status', $status);
		
			if (!empty($timeframe))
			{
				$this->db->where('news_date >=', $timeframe);
			}
		
			$this->db->where('news_author_user', $id);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	function count_user_news_comments($user = '')
	{
		$count = 0;
		
		if ( ! empty($user) && $user !== FALSE && $user !== NULL)
		{
			$this->db->from('news_comments');
			$this->db->where('ncomment_status', 'activated');
			$this->db->where('ncomment_author_user', $user);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	/**
	 * Search methods
	 */
	
	function search_news($component = '', $input = '')
	{
		$this->db->from('news');
		$this->db->where('news_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Create methods
	 */
	
	function add_news_category($data = '')
	{
		$this->db->insert('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $this->db->affected_rows();
	}
	
	function add_news_comment($data = '')
	{
		$this->db->insert('news_comments', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('news_comments');
		
		/* return the number of affected rows to show success/failure (should be 1) */
		return $this->db->affected_rows();
	}
	
	function create_news_item($data = '')
	{
		$query = $this->db->insert('news', $data);
		
		return $this->db->affected_rows();
	}
	
	/**
	 * Update methods
	 */
	
	function update_news_category($id = '', $data = '')
	{
		$this->db->where('newscat_id', $id);
		$query = $this->db->update('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
	
	function update_news_comment($id = '', $data = '')
	{
		$this->db->where('ncomment_id', $id);
		$query = $this->db->update('news_comments', $data);
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	function update_news_item($id = '', $data = '', $identifier = 'news_id')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('news', $data);
		
		$this->dbutil->optimize_table('news');
		
		return $query;
	}
	
	/**
	 * Delete methods
	 */
	
	function delete_news_category($id = '')
	{
		$query = $this->db->delete('news_categories', array('newscat_id' => $id));
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
	
	function delete_news_comment($id = '')
	{
		$query = $this->db->delete('news_comments', array('ncomment_id' => $id));
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	function delete_news_item($id = '')
	{
		/* grab the comments associated with the log */
		$comments = $this->db->get_where('news_comments', array('ncomment_news' => $id));
		
		/* loop through and the delete the comments associated with the log */
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('news_comments', array('ncomment_id' => $r->ncomment_id));
			}
		}
		
		/* now delete the log */
		$query = $this->db->delete('news', array('news_id' => $id));
		
		/* optimize the table */
		$this->dbutil->optimize_table('news');
		
		return $query;
	}
}
