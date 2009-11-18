<?php
/*
|---------------------------------------------------------------
| RSS FEED CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/feed_base.php
| System Version: 1.0
|
| Controller that handles generating the various RSS feeds used
| by the system.
|
*/

class Feed_base extends Controller {
	
	var $head;
	var $options;
	
	function Feed_base()
	{
		parent::Controller();
		
		/* load the models */
		$this->load->model('characters_model', 'char');
		
		/* an array of the global we want to retrieve */
		$settings_array = array('sim_name');
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the head variables */
		$this->head['rss_encoding']			= $this->config->item('rss_encoding');
		$this->head['rss_feed_name']		= $this->options['sim_name'];
		$this->head['rss_feed_url']			= site_url();
		$this->head['rss_feed_desc']		= $this->config->item('rss_description');
		$this->head['rss_feed_lang']		= $this->config->item('rss_feed_lang');
		$this->head['rss_creator_email']	= $this->config->item('rss_creator_email');
		
		/* set the template */
		$this->template->set_template('rss');
		$this->template->set_master_template('_base/template_rss.php');
	}
	
	function logs()
	{
		/* load the necessary models and helpers */
		$this->load->model('rss_model', 'rss');
		
		/* load the helpers */
		$this->load->helper('xml');
		
		/* run the method */
		$logs = $this->rss->get_logs($this->config->item('rss_num_entries'));
		
		if ($logs->num_rows() > 0)
		{
			$i = 1;
			foreach ($logs->result() as $log)
			{
				$data['entries'][$i]['id'] = $log->log_id;
				$data['entries'][$i]['title'] = $log->log_title;
				$data['entries'][$i]['date'] = $log->log_date;
				
				$log_header = 'A personal log by '. $this->char->get_character_name($log->log_author_character, TRUE) ."\r\n\r\n";
				
				$data['entries'][$i]['content'] = nl2br($log_header . $log->log_content);
				
				++$i;
			}
		}
		
		/* set the header */
		header("Content-Type: application/rss+xml");
		
		/* write the data to the template */
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function news()
	{
		/* load the necessary models and helpers */
		$this->load->model('rss_model', 'rss');
		
		/* load the helpers */
		$this->load->helper('xml');
		
		/* run the method */
		$news = $this->rss->get_news($this->config->item('rss_num_entries'));
		
		if ($news->num_rows() > 0)
		{
			$i = 1;
			foreach ($news->result() as $item)
			{
				$data['entries'][$i]['id'] = $item->news_id;
				$data['entries'][$i]['title'] = $item->news_title;
				$data['entries'][$i]['date'] = $item->news_date;
				
				$news_header = 'A news item by '. $this->char->get_character_name($item->news_author_character, TRUE) ."\r\n";
				$news_header.= "<b>Category</b> - ". $item->newscat_name ."\r\n\r\n";
				
				$data['entries'][$i]['content'] = nl2br($news_header . $item->news_content);
				
				++$i;
			}
		}
		
		/* set the header */
		header("Content-Type: application/rss+xml");
		
		/* write the data to the template */
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function posts()
	{
		/* load the necessary models and helpers */
		$this->load->model('rss_model', 'rss');
		$this->load->model('missions_model', 'mis');
		
		/* load the helpers */
		$this->load->helper('xml');
		
		/* run the method */
		$posts = $this->rss->get_posts($this->config->item('rss_num_entries'));
		
		if ($posts->num_rows() > 0)
		{
			$i = 1;
			foreach ($posts->result() as $post)
			{
				$data['entries'][$i]['id'] = $post->post_id;
				$data['entries'][$i]['title'] = $post->post_title;
				$data['entries'][$i]['date'] = $post->post_date;
				
				/* grab the authors and put them in an array */
				$authors = explode(',', $post->post_authors);
				
				foreach ($authors as $value)
				{ /* grab the character names for each author */
					$authors['full_names'][] = $this->char->get_character_name($value, TRUE);
				}
				
				/* break the array into a string */
				$post_header = 'A post by '. implode(', ', $authors['full_names']) ."\r\n\r\n";
				$post_header.= "<b>Mission</b> - ". $this->mis->get_mission($post->post_mission, 'mission_title') ."\r\n";
				$post_header.= (!empty($post->post_location)) ? "<b>Location</b> - ". $post->post_location ."\r\n" : '';
				$post_header.= (!empty($post->post_timeline)) ? "<b>Timeline</b> - ". $post->post_timeline ."\r\n" : '';
				$post_header.= "\r\n";
				
				$data['entries'][$i]['content'] = nl2br($post_header . $post->post_content);
				
				++$i;
			}
		}
		
		/* set the header */
		header("Content-Type: application/rss+xml");
		
		/* write the data to the template */
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file feed_base.php */
/* Location: ./application/controllers/base/feed_base.php */