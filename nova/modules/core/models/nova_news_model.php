<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * News model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_news_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
		$this->load->dbutil();
	}
	
	public function get_category_news($c = '', $session = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->join('characters', 'characters.charid = news.news_author_character');
		$this->db->where('news_status', 'activated');
		
		if ($c > 0)
		{
			$this->db->where('news_cat', $c);
		}
		
		if ($session === false)
		{
			$this->db->where('news_private', 'n');
		}
		
		$this->db->order_by('news_date', 'desc');
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/**
	 * Get all news items by a specific character.
	 *
	 * @access	public
	 * @since	2.0
	 * @param	mixed	either a character ID or an array of character IDs
	 * @param	int		the number of records to limit the result to
	 * @param	string	the status
	 * @return	object	result object
	 */
	public function get_character_news($id = '', $limit = 0, $status = 'activated')
	{
		$this->db->from('news');
		
		if ( ! empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		if (is_array($id))
		{
			$id = array_values($id);
			
			$count = count($id);
			
			$string = '';
			
			for ($i=0; $i < $count; $i++)
			{
				$or = ($i > 0) ? ' OR ' : '';
				
				$string.= $or ."news_author_character = '$id[$i]'";
			}
			
			$this->db->where("($string)", null);
		}
		else
		{
			$this->db->where('news_author_character', $id);
		}
		
		$this->db->order_by('news_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_link_id($id = '', $direction = 'next', $session = '')
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
			
			if ($session === false)
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
		
		return false;
	}
	
	public function get_news_categories($display = 'y')
	{
		$this->db->from('news_categories');
		
		if ( ! empty($display))
		{
			$this->db->where('newscat_display', $display);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_news_category($id = '', $return = '')
	{
		$this->db->from('news_categories');
		$this->db->where('newscat_id', $id);
		
		$query = $this->db->get();
		
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
	
	public function get_news_comment($id = '', $return = '')
	{
		$query = $this->db->get_where('news_comments', array('ncomment_id' => $id));
		
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
	
	public function get_news_comments($id = '', $status = 'activated', $order_field = 'ncomment_date', $order = 'asc')
	{
		$this->db->from('news_comments');
		
		if ( ! empty($id))
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
	
	public function get_news_item($id = '', $return = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_id', $id);
		
		$query = $this->db->get();
		
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
	
	public function get_news_items($limit = 5, $session = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_status', 'activated');
		
		if ($session === false)
		{
			$this->db->where('news_private', 'n');
		}
		
		$this->db->order_by('news_date', 'desc');
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_news_list($num = '', $offset = 0, $status = 'activated')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		
		if ( ! empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		$this->db->order_by('news_date', 'desc');
		$this->db->limit($num, $offset);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function get_user_news($id = '', $limit = 0, $status = 'activated')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		
		if ( ! empty($status))
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
	
	public function count_character_news($character = '', $status = 'activated')
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
	
	public function count_news_comments($status = 'activated', $id = '')
	{
		$this->db->from('news_comments');
		
		if ( ! empty($status))
		{
			$this->db->where('ncomment_status', $status);
		}
		
		if ( ! empty($id))
		{
			$this->db->where('ncomment_news', $id);
		}
		
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	public function count_news_items($status = 'activated')
	{
		$this->db->from('news');
		
		if ( ! empty($status))
		{
			$this->db->where('news_status', $status);
		}
		
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	public function count_user_news($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		if ( ! empty($id) && $id !== false && $id !== null)
		{
			$this->db->from('news');
			$this->db->where('news_status', $status);
		
			if ( ! empty($timeframe))
			{
				$this->db->where('news_date >=', $timeframe);
			}
		
			$this->db->where('news_author_user', $id);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function count_user_news_comments($user = '')
	{
		$count = 0;
		
		if ( ! empty($user) && $user !== false && $user !== null)
		{
			$this->db->from('news_comments');
			$this->db->where('ncomment_status', 'activated');
			$this->db->where('ncomment_author_user', $user);
			
			$count = $this->db->count_all_results();
		}
		
		return $count;
	}
	
	public function search_news($component = '', $input = '')
	{
		$this->db->from('news');
		$this->db->where('news_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	public function add_news_category($data = '')
	{
		$this->db->insert('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $this->db->affected_rows();
	}
	
	public function add_news_comment($data = '')
	{
		$this->db->insert('news_comments', $data);
		
		$this->dbutil->optimize_table('news_comments');
		
		return $this->db->affected_rows();
	}
	
	public function create_news_item($data = '')
	{
		$query = $this->db->insert('news', $data);
		
		return $this->db->affected_rows();
	}
	
	public function update_news_category($id = '', $data = '')
	{
		$this->db->where('newscat_id', $id);
		$query = $this->db->update('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
	
	public function update_news_comment($id = '', $data = '')
	{
		$this->db->where('ncomment_id', $id);
		$query = $this->db->update('news_comments', $data);
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	public function update_news_item($id = '', $data = '', $identifier = 'news_id')
	{
		$this->db->where($identifier, $id);
		$query = $this->db->update('news', $data);
		
		$this->dbutil->optimize_table('news');
		
		return $query;
	}
	
	public function delete_news_category($id = '')
	{
		$query = $this->db->delete('news_categories', array('newscat_id' => $id));
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
	
	public function delete_news_comment($id = '')
	{
		$query = $this->db->delete('news_comments', array('ncomment_id' => $id));
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	public function delete_news_item($id = '')
	{
		$comments = $this->db->get_where('news_comments', array('ncomment_news' => $id));
		
		if ($comments->num_rows() > 0)
		{
			foreach ($comments->result() as $r)
			{
				$query = $this->db->delete('news_comments', array('ncomment_id' => $r->ncomment_id));
			}
		}
		
		$query = $this->db->delete('news', array('news_id' => $id));
		
		$this->dbutil->optimize_table('news');
		
		return $query;
	}
}
