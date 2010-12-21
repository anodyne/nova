<?php
/**
 * RSS feed model
 *
 * @package		Nova
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.0
 */

class Rss_model_base extends Model {

	function Rss_model_base()
	{
		parent::Model();
	}
	
	/**
	 * Retrieve methods
	 */
	
	function get_logs($limit = 25)
	{
		$this->db->from('personallogs');
		$this->db->where('log_status', 'activated');
		$this->db->order_by('log_date', 'desc');
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_news($limit = 25)
	{
		$this->db->from('news');
		$this->db->join('news_categories', 'news_categories.newscat_id = news.news_cat');
		$this->db->where('news_status', 'activated');
		$this->db->where('news_private', 'n');
		$this->db->order_by('news_date', 'desc');
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $query;
	}
	
	function get_posts($limit = 25)
	{
		$this->db->from('posts');
		$this->db->where('post_status', 'activated');
		$this->db->order_by('post_date', 'desc');
		$this->db->limit($limit);
		
		$query = $this->db->get();
		
		return $query;
	}
}
