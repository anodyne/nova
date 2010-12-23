<?php
/**
 * RSS feed controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.2.1
 *
 * Fixed error thrown on the RSS feed
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
		$this->head['rss_description']		= $this->config->item('rss_description');
		$this->head['rss_feed_lang']		= $this->config->item('rss_feed_lang');
		$this->head['rss_creator_email']	= $this->config->item('rss_creator_email');
		
		/* set the template */
		$this->template->set_template('rss');
		$this->template->set_master_template('_base/template_rss.php');
		
		/* set and load the language file needed */
		$this->lang->load('app');
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
				
				$log_header = ucfirst(lang('labels_a') .' '. lang('personallog') .' '. lang('labels_by'));
				$log_header.= ' '. $this->char->get_character_name($log->log_author_character, TRUE) ."\r\n\r\n";
				
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
				
				$news_header = ucfirst(lang('labels_a') .' '. lang('newsitem') .' '. lang('labels_by'));
				$news_header.= ' '. $this->char->get_character_name($item->news_author_character, TRUE) ."\r\n";
				$news_header.= "<b>". ucfirst(lang('labels_category')) ."</b> - ". $item->newscat_name ."\r\n\r\n";
				
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
				$post_header = ucfirst(lang('labels_a') .' '. lang('missionpost') .' '. lang('labels_by'));
				$post_header.= ' '. implode(', ', $authors['full_names']) ."\r\n\r\n";
				$post_header.= "<b>". ucfirst(lang('global_mission')) ."</b> - ". $this->mis->get_mission($post->post_mission, 'mission_title') ."\r\n";
				$post_header.= (!empty($post->post_location)) ? "<b>". ucfirst(lang('labels_location')) ."</b> - ". $post->post_location ."\r\n" : '';
				$post_header.= (!empty($post->post_timeline)) ? "<b>". ucfirst(lang('labels_timeline')) ."</b> - ". $post->post_timeline ."\r\n" : '';
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
