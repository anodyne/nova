<?php
/*
|---------------------------------------------------------------
| NEWS MODEL
|---------------------------------------------------------------
|
| File: models/base/news_model.php
| System Version: 1.0
|
| Model used to access the news, news categories, and news comments tables.
|
*/

class News_model_base extends Model {

	function News_model_base()
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
	
	function get_news_item($i = '')
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->join('characters', 'characters.charid = news.news_author_character');
		$this->db->where('news_id', $i);
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_newsitem($id = '', $return = '')
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
	
	function get_news_category($c)
	{
		$query = $this->db->get_where('news_categories', array('newscat_id' => $c));
		
		return $query;
	}
	
	function get_news_category_name($id = '')
	{
		$query = $this->db->get_where('news_categories', array('newscat_id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->newscat_name;
		}
		
		return FALSE;
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
					break;
				
				case 'prev':
					$this->db->where('news_date <', $fetch->news_date);
					$this->db->order_by('news_id', 'desc');
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
	
	function get_news_author($id = '')
	{
		$query = $this->db->get_where('news', array('news_id' => $id));
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			return $row->news_author_character;
		}
		
		return FALSE;
	}
	
	function get_player_news($id = '', $limit = 0)
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_status', 'activated');
		$this->db->where('news_author_player', $id);
		$this->db->order_by('news_date', 'desc');
		
		if ($limit > 0)
		{
			$this->db->limit($limit);
		}
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_saved_news($id = '', $limit = 0)
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_status', 'saved');
		
		if (!empty($id))
		{
			$this->db->where('news_author_player', $id);
		}
		
		$this->db->order_by('news_date', 'desc');
		
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
	
	function count_character_news($id = '', $status = 'activated')
	{
		$count = 0;
		
		$this->db->from('news');
		$this->db->where('news_status', $status);
		$this->db->where('news_author_character', $id);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_news_comments($id = NULL)
	{
		$query = $this->db->get_where('news_comments', array('ncomment_news' => $id));
		
		return $query->num_rows();
	}
	
	function count_player_news($id = '', $status = 'activated', $timeframe = '')
	{
		$count = 0;
		
		$this->db->from('news');
		$this->db->where('news_status', $status);
		
		if (!empty($timeframe))
		{
			$this->db->where('news_date >=', $timeframe);
		}
		
		$this->db->where('news_author_player', $id);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_player_news_comments($player = '')
	{
		$count = 0;
		
		$this->db->from('news_comments');
		$this->db->where('ncomment_status', 'activated');
		$this->db->where('ncomment_author_player', $player);
			
		$count = $this->db->count_all_results();
		
		return $count;
	}
	
	function count_all_news($status = 'activated')
	{
		$this->db->from('news');
		$this->db->where('news_status', $status);
		
		return $this->db->count_all_results();
	}
	
	function count_all_news_comments($status = 'activated', $id = '')
	{
		$this->db->from('news_comments');
		$this->db->where('ncomment_status', $status);
		
		if (!empty($id))
		{
			$this->db->where('ncomment_news', $id);
		}
		
		return $this->db->count_all_results();
	}
	
	/*
	|---------------------------------------------------------------
	| SEARCH METHODS
	|---------------------------------------------------------------
	*/
	
	function search_news($component = '', $input = '')
	{
		$this->db->from('news');
		$this->db->where('news_status', 'activated');
		$this->db->like($component, $input);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| CREATE METHODS
	|---------------------------------------------------------------
	*/
	
	function create_news_item($data = '')
	{
		$query = $this->db->insert('news', $data);
		
		/* optimize the table */
		$this->dbutil->optimize_table('news');
		
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
	
	function add_news_category($data = '')
	{
		$this->db->insert('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $this->db->affected_rows();
	}
	
	/*
	|---------------------------------------------------------------
	| UPDATE METHODS
	|---------------------------------------------------------------
	*/
	
	function update_news_item($id = '', $data = '')
	{
		$this->db->where('news_id', $id);
		$query = $this->db->update('news', $data);
		
		$this->dbutil->optimize_table('news');
		
		return $query;
	}
	
	function update_news_comment($id = '', $data = '')
	{
		$this->db->where('ncomment_id', $id);
		$query = $this->db->update('news_comments', $data);
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	function update_news_category($id = '', $data = '')
	{
		$this->db->where('newscat_id', $id);
		$query = $this->db->update('news_categories', $data);
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
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
	
	function delete_news_comment($id = '')
	{
		$query = $this->db->delete('news_comments', array('ncomment_id' => $id));
		
		$this->dbutil->optimize_table('news_comments');
		
		return $query;
	}
	
	function delete_news_category($id = '')
	{
		$query = $this->db->delete('news_categories', array('newscat_id' => $id));
		
		$this->dbutil->optimize_table('news_categories');
		
		return $query;
	}
}

/* End of file news_model.php */
/* Location: ./application/models/base/news_model.php */