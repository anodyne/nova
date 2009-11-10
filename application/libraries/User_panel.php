<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|---------------------------------------------------------------
| USER PANEL LIBRARY
|---------------------------------------------------------------
|
| File: libraries/User_panel.php
| System Version: 1.0
|
| Library that handles generating the user panel.
|
*/

class User_panel {
	
	function User_panel()
	{
		/* log the debug message */
		log_message('debug', 'User Panel Library Initialized');
	}
	
	function panel_1()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->library('parser');
		$this->ci->load->model('privmsgs_model', 'pm');
		
		/* run the methods */
		$user = $this->ci->user->get_user_details($this->ci->session->userdata('userid'));
		$count = $this->ci->pm->count_unread_pms($this->ci->session->userdata('userid'));
		
		$data['count'] = ($count > 0) ? ' <strong>('. $count .')</strong>' : FALSE;
		
		if ($user->num_rows() > 0)
		{
			$row = $user->row();
			
			$data['name'] = $row->name;
		}
		else
		{
			$data['name'] = '';
		}
		
		$data['label'] = array(
			'edit_account' => ucwords(lang('actions_edit') .' '. lang('labels_account')),
			'edit_prefs' => ucwords(lang('actions_edit') .' '. lang('labels_site') .' '. lang('labels_preferences')),
			'private_messages' => ucwords(lang('global_privatemessages')),
			'request_loa' => ucwords(lang('actions_request') .' '. lang('abbr_loa')),
		);
		
		/* parse the content */
		$content = $this->ci->parser->parse('_base/ajax/userpanel_1', $data, TRUE);
		
		return $content;
	}
	
	function panel_2()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->library('parser');
		
		/* run the methods */
		$characters = $this->ci->session->userdata('characters');
		
		/* set the variables */
		$data = array();
		
		if ($characters !== FALSE)
		{
			foreach ($characters as $char)
			{
				$data['panel_characters'][] = array(
					'id' => $char,
					'name' => $this->ci->char->get_character_name($char, TRUE)
				);
			}
		}
		
		$data['label'] = array(
			'characters' => ucfirst(lang('global_characters')),
		);
		
		/* parse the content */
		$content = $this->ci->parser->parse('_base/ajax/userpanel_2', $data, TRUE);
		
		return $content;
	}
	
	function panel_3()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->library('parser');
		
		$data['panel_my_links'] = $this->ci->session->userdata('my_links');
		
		$data['label'] = array(
			'links' => ucwords(lang('labels_my') .' '. lang('labels_links')),
		);
		
		/* parse the content */
		$content = $this->ci->parser->parse('_base/ajax/userpanel_3', $data, TRUE);
		
		return $content;
	}
	
	function panel_workflow()
	{
		/* get an instance of CI */
		$this->ci =& get_instance();
		
		/* load the resources */
		$this->ci->load->library('parser');
		$this->ci->load->model('privmsgs_model', 'pm');
		$this->ci->load->model('posts_model', 'posts');
		$this->ci->load->model('personallogs_model', 'logs');
		$this->ci->load->model('news_model', 'news');
		
		$data['unreadpm'] = $this->ci->pm->count_unread_pms($this->ci->session->userdata('userid'));
		$data['unreadpm_icon'] = ($data['unreadpm'] > 0) ? 'green' : 'gray';
		
		$data['unreadjp'] = $this->ci->posts->count_unattended_posts($this->ci->session->userdata('characters'));
		
		$posts = $this->ci->posts->count_character_posts($this->ci->session->userdata('characters'), 'saved');
		$logs = $this->ci->logs->count_user_logs($this->ci->session->userdata('userid'), 'saved');
		$news = $this->ci->news->count_user_news($this->ci->session->userdata('userid'), 'saved');
		
		$data['saveditems'] = $posts + $logs + $news;
		
		$data['unreadjp_icon'] = ($data['saveditems'] > 0) ? 'yellow' : 'gray';
		$data['unreadjp_icon'] = ($data['unreadjp'] > 0) ? 'green' : $data['unreadjp_icon'];
		
		$data['icons'] = array(
			'green' => array(
				'src' => asset_location('images', 'icon-green.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
			'gray' => array(
				'src' => asset_location('images', 'icon-gray.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
			'yellow' => array(
				'src' => asset_location('images', 'icon-yellow.png'),
				'alt' => '',
				'class' => 'image panel-notify-icon'),
		);
		
		$data['label'] = array(
			'dashboard' => ucfirst(lang('labels_dashboard')),
			'inbox' => ucfirst(lang('labels_inbox')),
			'writing' => ucwords(lang('labels_writing') .' '. lang('labels_entries')),
		);
		
		/* parse the content */
		$content = $this->ci->parser->parse('_base/ajax/userpanel_workflow', $data, TRUE);
		
		return $content;
	}
}

/* End of file User_panel.php */
/* Location: ./application/libraries/User_panel.php */