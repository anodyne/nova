<?php
/**
 * RSS feed controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.3
 *
 * Fixed major issues with RSS feeds not being accurate and throwing all
 * sorts of errors, added a feed for created wiki pages and updated wiki
 * pages
 */

class Feed_base extends Controller {
	
	var $head;
	var $options;
	
	function Feed_base()
	{
		parent::Controller();
		
		// load the models
		$this->load->model('characters_model', 'char');
		
		// an array of the global we want to retrieve
		$settings_array = array('sim_name');
		
		// grab the settings
		$this->options = $this->settings->get_settings($settings_array);
		
		// set the head variables
		$this->head['rss_encoding']			= $this->config->item('rss_encoding');
		$this->head['rss_feed_name']		= $this->options['sim_name'];
		$this->head['rss_feed_url']			= site_url();
		$this->head['rss_description']		= $this->config->item('rss_description');
		$this->head['rss_feed_lang']		= $this->config->item('rss_feed_lang');
		$this->head['rss_creator_email']	= $this->config->item('rss_creator_email');
		
		// set the template
		$this->template->set_template('rss');
		$this->template->set_master_template('_base/template_rss.php');
		
		// set and load the language file needed
		$this->lang->load('app');
	}
	
	function logs()
	{
		// load the necessary models and helpers
		$this->load->model('rss_model', 'rss');
		
		// load the helpers
		$this->load->helper('xml');
		
		// run the method
		$logs = $this->rss->get_logs($this->config->item('rss_num_entries'));
		
		// need an empty array to prevent errors
		$data = array();
		
		if ($logs->num_rows() > 0)
		{
			$i = 1;
			foreach ($logs->result() as $log)
			{
				$data['entries'][$i]['link'] = site_url('sim/viewpost/'.$log->log_id);
				$data['entries'][$i]['title'] = $log->log_title;
				$data['entries'][$i]['date'] = $log->log_date;
				
				$log_header = ucfirst(lang('labels_a') .' '. lang('global_personallog') .' '. lang('labels_by'));
				$log_header.= ' '. $this->char->get_character_name($log->log_author_character, TRUE) ."\r\n\r\n";
				
				$data['entries'][$i]['content'] = nl2br($log_header . $log->log_content);
				
				++$i;
			}
		}
		
		// set the header
		header("Content-Type: application/rss+xml");
		
		// write the data to the template
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		// render the template
		$this->template->render();
	}
	
	function news()
	{
		// load the necessary models and helpers
		$this->load->model('rss_model', 'rss');
		
		// load the helpers
		$this->load->helper('xml');
		
		// run the method
		$news = $this->rss->get_news($this->config->item('rss_num_entries'));
		
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
		
		// write the data to the template
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		// render the template
		$this->template->render();
	}
	
	function posts()
	{
		// load the necessary models and helpers
		$this->load->model('rss_model', 'rss');
		$this->load->model('missions_model', 'mis');
		
		// load the helpers
		$this->load->helper('xml');
		
		// run the method
		$posts = $this->rss->get_posts($this->config->item('rss_num_entries'));
		
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
		
		// write the data to the template
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		// render the template
		$this->template->render();
	}
	
	/**
	 * RSS feed for created wiki pages
	 *
	 * @since	1.3
	 * @return	void
	 */
	function wiki($type = 'created')
	{
		// load the necessary models and helpers
		$this->load->model('wiki_model', 'wiki');
		
		// load the helpers
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
		
		// write the data to the template
		$this->template->write_view('header', '_base/rss_head', $this->head);
		$this->template->write_view('items', '_base/rss_items', $data);
		
		// render the template
		$this->template->render();
	}
}
