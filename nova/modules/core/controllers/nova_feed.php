<?php
/**
 * RSS feed controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		2.0
 */

require_once MODPATH.'core/libraries/Nova_main_controller'.EXT;

class Nova_feed extends Nova_main_controller {
	
	public function __construct()
	{
		parent::__construct();
		
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
		
		Template::$file = '_base/template_rss';
		
		$this->_regions = array(
			'header'	=> Location::view('_base/rss_head', null, null, $head),
			'items'		=> false,
		);
	}

	public function logs()
	{
		$this->load->helper('debug');
		//print_var($this->_regions);
		
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
		
		$this->_regions['items'] = Location::view('_base/rss_items', null, null, $data);
		
		//Template::assign($this->_regions);
		
		Template::render();
	}
}
