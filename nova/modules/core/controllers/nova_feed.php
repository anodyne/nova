<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * RSS feed controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_feed extends Controller {
	
	/**
	 * @var	array 	The options array that stores all the settings from the database
	 */
	public $options;
	
	/**
	 * @var	array 	Variable to store all the information about template regions
	 */
	protected $_regions = array();
	
	public function __construct()
	{
		parent::__construct();
		
		// load the resources
		$this->load->database();
		$this->load->model('settings_model', 'settings');
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
		
		// an array of the global we want to retrieve
		$settings_array = array('sim_name');
		
		// grab the settings
		$this->options = $this->settings->get_settings($settings_array);
		
		// set the head variables
		$head = array(
			'rss_encoding'		=> $this->config->item('rss_encoding'),
			'rss_feed_name'		=> $this->options['sim_name'],
			'rss_feed_url'		=> site_url(),
			'rss_description'	=> $this->config->item('rss_description'),
			'rss_feed_lang'		=> $this->config->item('rss_feed_lang'),
			'rss_creator_email'	=> $this->config->item('rss_creator_email'),
		);
		
		// load the language file
		$this->lang->load('app');
		
		// set the template file
		Template::$file = '_base/template_rss';
		
		// set the module
		Template::$data['module'] = 'core';
		
		$this->_regions = array(
			'header'	=> Location::view('_base/rss_head', null, null, $head),
			'items'		=> false,
		);
	}
	
	/**
	 * RSS feed for personal logs
	 *
	 * @access	public
	 * @return	void
	 */
	public function logs()
	{
		// load the resources
		$this->load->model('personallogs_model', 'logs');
		$this->load->helper('xml');
		
		$logs = $this->logs->get_log_list($this->config->item('rss_num_entries'));
		
		// need an empty array to prevent errors
		$data = array();
		
		if ($logs->num_rows() > 0)
		{
			$i = 1;
			foreach ($logs->result() as $log)
			{
				$data['entries'][$i]['link'] = site_url('sim/viewlog/'.$log->log_id);
				$data['entries'][$i]['title'] = $log->log_title;
				$data['entries'][$i]['date'] = $log->log_date;
				
				$log_header = ucfirst(lang('labels_a') .' '. lang('global_personallog') .' '. lang('labels_by'));
				$log_header.= ' '. $this->char->get_character_name($log->log_author_character, true) ."\r\n\r\n";
				
				$data['entries'][$i]['content'] = nl2br($log_header.$log->log_content);
				
				++$i;
			}
		}
		
		// set the header
		header("Content-Type: application/rss+xml");
		
		$this->_regions['items'] = Location::view('_base/rss_items', null, null, $data);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * RSS feed for news items (private news items are not included)
	 *
	 * @access	public
	 * @return	void
	 */
	public function news()
	{
		// load the resources
		$this->load->model('news_model', 'news');
		$this->load->helper('xml');
		
		$news = $this->news->get_news_items($this->config->item('rss_num_entries'), null);
		
		// need an empty array to prevent errors
		$data = array();
		
		if ($news->num_rows() > 0)
		{
			$i = 1;
			foreach ($news->result() as $item)
			{
				$data['entries'][$i]['link'] = site_url('main/viewnews/'.$item->news_id);
				$data['entries'][$i]['title'] = $item->news_title;
				$data['entries'][$i]['date'] = $item->news_date;
				
				$news_header = ucfirst(lang('labels_a') .' '. lang('global_newsitem') .' '. lang('labels_by'));
				$news_header.= ' '. $this->char->get_character_name($item->news_author_character, TRUE) ."\r\n";
				$news_header.= "<b>". ucfirst(lang('labels_category')) ."</b> - ". $item->newscat_name ."\r\n\r\n";
				
				$data['entries'][$i]['content'] = nl2br($news_header . $item->news_content);
				
				++$i;
			}
		}
		
		// set the header
		header("Content-Type: application/rss+xml");
		
		$this->_regions['items'] = Location::view('_base/rss_items', null, null, $data);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * RSS feed for mission entries
	 *
	 * @access	public
	 * @return	void
	 */
	public function posts()
	{
		// load the resources
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		$this->load->helper('xml');
		
		$posts = $this->posts->get_post_list(null, 'desc', $this->config->item('rss_num_entries'), 0, 'activated');
		
		// need an empty array to prevent errors
		$data = array();
		
		if ($posts->num_rows() > 0)
		{
			$i = 1;
			foreach ($posts->result() as $post)
			{
				$data['entries'][$i]['link'] = site_url('sim/viewpost/'.$post->post_id);
				$data['entries'][$i]['title'] = $post->post_title;
				$data['entries'][$i]['date'] = $post->post_date;
				
				/* grab the authors and put them in an array */
				$authors = explode(',', $post->post_authors);
				
				foreach ($authors as $value)
				{ /* grab the character names for each author */
					$authors['full_names'][] = $this->char->get_character_name($value, TRUE);
				}
				
				/* break the array into a string */
				$post_header = ucfirst(lang('labels_a') .' '. lang('global_missionpost') .' '. lang('labels_by'));
				$post_header.= ' '. implode(', ', $authors['full_names']) ."\r\n\r\n";
				$post_header.= "<b>". ucfirst(lang('global_mission')) ."</b> - ". $this->mis->get_mission($post->post_mission, 'mission_title') ."\r\n";
				$post_header.= ( ! empty($post->post_location)) ? "<b>". ucfirst(lang('labels_location')) ."</b> - ". $post->post_location ."\r\n" : '';
				$post_header.= ( ! empty($post->post_timeline)) ? "<b>". ucfirst(lang('labels_timeline')) ."</b> - ". $post->post_timeline ."\r\n" : '';
				$post_header.= "\r\n";
				
				$data['entries'][$i]['content'] = nl2br($post_header . $post->post_content);
				
				++$i;
			}
		}
		
		// set the header
		header("Content-Type: application/rss+xml");
		
		$this->_regions['items'] = Location::view('_base/rss_items', null, null, $data);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * RSS feed for created or updated wiki pages
	 *
	 * @access	public
	 * @since	2.0
	 * @return	void
	 */
	public function wiki($type = 'created')
	{
		// load the resources
		$this->load->model('wiki_model', 'wiki');
		$this->load->helper('xml');
		
		switch ($type)
		{
			case 'created':
				// run the method
				$created = $this->wiki->get_recently_created($this->config->item('rss_num_entries'));
				
				if ($created->num_rows() > 0)
				{
					$i = 1;
					foreach ($created->result() as $c)
					{
						$data['entries'][$i]['link'] = site_url('wiki/view/page/'.$c->page_id);
						$data['entries'][$i]['title'] = $c->draft_title;
						$data['entries'][$i]['date'] = $c->page_created_at;
						
						// build the header for the entry
						$header = ucfirst(lang('actions_created').' '.lang('labels_by')).' ';
						$header.= ($c->page_created_by_character == 0)
							? ucfirst(lang('labels_system'))
							: $this->char->get_character_name($c->page_created_by_character, TRUE);
						$header.= "\r\n";
						$header.= ucfirst(lang('labels_summary')).': '.$c->draft_summary."\r\n";
						
						// put it all into the content
						$data['entries'][$i]['content'] = nl2br($header).$c->draft_content;
						
						++$i;
					}
				}
			break;
			
			case 'updated':
				// run the method
				$updated = $this->wiki->get_recently_updated($this->config->item('rss_num_entries'));
				
				if ($updated->num_rows() > 0)
				{
					$i = 1;
					foreach ($updated->result() as $u)
					{
						$data['entries'][$i]['link'] = site_url('wiki/view/page/'.$u->page_id);
						$data['entries'][$i]['title'] = $u->draft_title;
						$data['entries'][$i]['date'] = $u->page_updated_at;
						
						// build the header for the entry
						$header = ucfirst(lang('actions_updated').' '.lang('labels_by')).' ';
						$header.= (empty($u->page_updated_by_character))
							? ucfirst(lang('labels_system'))
							: $this->char->get_character_name($u->page_updated_by_character, TRUE);
						$header.= "\r\n";
						$header.= ucfirst(lang('actions_changes')).': '.$u->draft_changed_comments."\r\n";
						
						// put it all into the content
						$data['entries'][$i]['content'] = nl2br($header).$u->draft_content;
						
						++$i;
					}
				}
			break;
		}
		
		// set the header
		header("Content-Type: application/rss+xml");
		
		$this->_regions['items'] = Location::view('_base/rss_items', null, null, $data);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
