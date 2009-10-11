<?php
/*
|---------------------------------------------------------------
| ADMIN CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/admin_base.php
| System Version: 1.0
|
| Controller that handles the ADMIN section of the system.
|
*/

class Admin_base extends Controller {

	/* set the variables */
	var $settings;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Admin_base()
	{
		parent::Controller();
		
		/* load the system model */
		$this->load->model('system_model', 'sys');
		$installed = $this->sys->check_install_status();
		
		if ($installed === FALSE)
		{ /* check whether the system is installed */
			redirect('install/index', 'refresh');
		}
		
		/* load the session library */
		$this->load->library('session');
		
		/* load the models */
		$this->load->model('characters_model', 'char');
		$this->load->model('players_model', 'player');
		
		/* check to see if they are logged in */
		$this->auth->is_logged_in(TRUE);
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_admin',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'email_subject',
			'system_email',
			'online_timespan',
			'posting_requirement',
			'updates'
		);
		
		/* grab the settings */
		$this->settings = $this->settings_model->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->settings['skin_admin'];
		$this->rank = $this->settings['display_rank'];
		$this->timezone = $this->settings['timezone'];
		$this->dst = $this->settings['daylight_savings'];
		
		if ($this->session->userdata('player_id') === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_admin');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_template('admin');
		$this->template->set_master_template($this->skin .'/template_admin.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('adminsub', 'acp'), TRUE);
		$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
		$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
		$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		$this->template->write('title', $this->settings['sim_name'] . ' :: ');
	}

	function index()
	{
		/* load the models */
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('news_model', 'news');
		$this->load->model('missions_model', 'mis');
		$this->load->model('privmsgs_model', 'pm');
		$this->load->model('awards_model', 'awards');
		
		/* load the helpers */
		$this->load->helper('utility');
		
		/*
		|---------------------------------------------------------------
		| STATS
		|---------------------------------------------------------------
		*/
		
		$data['posts'] = array(
			'entries' => $this->posts->count_character_posts($this->session->userdata('characters')),
			'comments' => $this->posts->count_player_post_comments($this->session->userdata('player_id'))
		);
		$data['logs'] = array(
			'entries' => $this->logs->count_player_logs($this->session->userdata('player_id')),
			'comments' => $this->logs->count_player_log_comments($this->session->userdata('player_id'))
		);
		$data['news'] = array(
			'entries' => $this->news->count_player_news($this->session->userdata('player_id')),
			'comments' => $this->news->count_player_news_comments($this->session->userdata('player_id'))
		);
		
		/*
		|---------------------------------------------------------------
		| NOTIFICATIONS
		|---------------------------------------------------------------
		*/
		
		$data['notification'] = array(
			'saved_posts'		=> $this->posts->count_character_posts($this->session->userdata('characters'), 'saved'),
			'saved_logs'		=> $this->logs->count_player_logs($this->session->userdata('player_id'), 'saved'),
			'saved_news' 		=> $this->news->count_player_news($this->session->userdata('player_id'), 'saved'),
			'unread_pms' 		=> $this->pm->count_unread_pms($this->session->userdata('player_id')),
			'pending_users' 	=> $this->char->count_characters('pending', ''),
			'pending_posts' 	=> $this->posts->count_all_posts('', 'pending'),
			'pending_logs' 		=> $this->logs->count_all_logs('pending'),
			'pending_news' 		=> $this->news->count_all_news('pending'),
			'pending_comments' 	=> $this->posts->count_all_post_comments('pending') + $this->logs->count_all_log_comments('pending') + $this->news->count_all_news_comments('pending'),
			'pending_awards' 	=> $this->awards->count_award_noms('pending')
		);
		
		/* set the count to zero by default */
		$data['notifycount'] = 0;
		
		foreach ($data['notification'] as $a)
		{ /* count all the notifications */
			$data['notifycount'] += $a;
		}
		
		/* pass the count to the js view */
		$js_data['panel'] = ($data['notifycount'] > 0) ? 'notifications' : 'stats';
		
		/*
		|---------------------------------------------------------------
		| ACTIVITY
		|---------------------------------------------------------------
		*/
		
		$all = $this->player->get_players();
		
		$now = now();
		$threshold = $now - ($this->settings['posting_requirement'] * 86400);
		
		if ($all->num_rows() > 0)
		{
			foreach ($all->result() as $a)
			{
				if ($threshold > $a->last_post)
				{
					$data['activity'][$a->player_id] = array(
						'post' => (!empty($a->last_post)) ? $a->last_post : lang('error_no_last_post'),
						'login' => (!empty($a->last_login)) ? $a->last_login : lang('error_no_last_login'),
						'name' => $this->char->get_character_name($a->main_char, TRUE)
					);
				}
				
				$milestones[] = array(
					'id' => $a->player_id,
					'char' => $a->main_char,
					'join' => $a->join_date
				);
			}
		}
		
		/* set the count to zero by default */
		$data['activitycount'] = count($data['activity']);
		
		/*
		|---------------------------------------------------------------
		| MILESTONES
		|---------------------------------------------------------------
		*/
		
		if (isset($milestones))
		{
			foreach ($milestones as $m)
			{
				$time = $now - $m['join'];
				$time = $time / 86400;
				$time = $time / 30;
				
				if ($time <= 12)
				{
					$data['milestones'][] = array(
						'name' => $this->char->get_character_name($m['char'], TRUE),
						'months' => floor($time),
						'years' => 0,
						'timespan' => timespan($m['join'], $now)
					);
				}
				else
				{
					$years = floor($time / 12);
					
					$subt = $years * 12;
					$months = floor($time - $subt);
					
					$data['milestones'][] = array(
						'name' => $this->char->get_character_name($m['char'], TRUE),
						'months' => $months,
						'years' => $years,
						'timespan' => timespan($m['join'], $now)
					);
				}
			}
			
			foreach ($data['milestones'] as $k => $v)
			{
				if ( ($v['years'] == 0 && $v['months'] != 6) || ($v['years'] > 0 && $v['months'] > 0) )
				{
					unset($data['milestones'][$k]);
				}
			}
			
			$data['milestonecount'] = count($data['milestones']);
		}
		
		/*
		|---------------------------------------------------------------
		| ALL RECENT ENTRIES
		|---------------------------------------------------------------
		*/
		
		/* set the datestring */
		$datestring = $this->settings['date_format'];
		
		/* grab the data */		
		$posts_all = $this->posts->get_post_list('', 'desc', 10);
		$logs_all = $this->logs->get_log_list(10);
		$news_all = $this->news->get_news_items(10, $this->session->userdata('player_id'));
		
		if ($posts_all->num_rows() > 0)
		{
			$i = 1;
			foreach ($posts_all->result() as $p)
			{
				$data['posts_all'][$i]['title'] = $p->post_title;
				$data['posts_all'][$i]['post_id'] = $p->post_id;
				$data['posts_all'][$i]['date'] = mdate($datestring, gmt_to_local($p->post_date, $this->timezone, $this->dst));
				$data['posts_all'][$i]['authors'] = $this->char->get_authors($p->post_authors);
				$data['posts_all'][$i]['mission'] = $this->mis->get_mission_name($p->post_mission);
				$data['posts_all'][$i]['mission_id'] = $p->post_mission;
				
				++$i;
			}
		}
		
		if ($logs_all->num_rows() > 0)
		{
			$i = 1;
			foreach ($logs_all->result() as $l)
			{
				$data['logs_all'][$i]['title'] = $l->log_title;
				$data['logs_all'][$i]['log_id'] = $l->log_id;
				$data['logs_all'][$i]['date'] = mdate($datestring, gmt_to_local($l->log_date, $this->timezone, $this->dst));
				$data['logs_all'][$i]['author'] = $this->char->get_character_name($l->log_author_character, TRUE);
				
				++$i;
			}
		}
		
		if ($news_all->num_rows() > 0)
		{
			$i = 1;
			foreach ($news_all->result() as $n)
			{
				$data['news_all'][$i]['title'] = $n->news_title;
				$data['news_all'][$i]['news_id'] = $n->news_id;
				$data['news_all'][$i]['category'] = $n->newscat_name;
				$data['news_all'][$i]['author'] = $this->char->get_character_name($n->news_author_character, TRUE);
				$data['news_all'][$i]['date'] = mdate($datestring, gmt_to_local($n->news_date, $this->timezone, $this->dst));
				
				++$i;
			}
		}
		
		/*
		|---------------------------------------------------------------
		| NEW VERSION NOTIFICATION
		|---------------------------------------------------------------
		*/
		
		if ($this->auth->is_sysadmin($this->session->userdata('player_id')))
		{
			/* load the resources */
			$this->load->library('simplepie');
			$this->lang->load('install', $this->session->userdata('language'));
			
			/* get the system information */
			$s = $this->sys->get_system_info();
			
			/* build the array of version info */
			$version = array(
				'files' => array(
					'full'		=> APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
					'major'		=> APP_VERSION_MAJOR,
					'minor'		=> APP_VERSION_MINOR,
					'update'	=> APP_VERSION_UPDATE
				),
				'database' => array(
					'full'		=> $s->sys_version_major .'.'. $s->sys_version_minor .'.'. $s->sys_version_update,
					'major'		=> $s->sys_version_major,
					'minor'		=> $s->sys_version_minor,
					'update'	=> $s->sys_version_update
				),
			);
			
			/* grab the information from the version feed */
			$this->simplepie->set_feed_url(base_url() . APPFOLDER .'/assets/version.xml');
			$this->simplepie->enable_cache(FALSE);
			$this->simplepie->init();
			$this->simplepie->handle_content_type();
			
			/* get the items from the feed */
			$items = $this->simplepie->get_items();
			
			foreach ($items as $i)
			{ /* loop through and figure out what we should be displaying */
				$type = $this->settings['updates'];
				
				switch ($type)
				{
					case 'major':
						$major = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'major');
						$major = $major[0]['data'];
						
						if ($major > $version['files']['major'] && $major > $version['database']['major'])
						{
							$severity = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'severity');
							
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
							$update['severity'] = $severity[0]['date'];
						}
					
						break;
						
					case 'minor':
						$major = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'major');
						$minor = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'minor');
						
						$major = $major[0]['data'];
						$minor = $minor[0]['data'];
						
						if ($minor > $version['files']['minor'] && $minor > $version['database']['minor'])
						{
							$severity = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'severity');
							
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
							$update['severity'] = $severity[0]['data'];
						}
						elseif (($minor < $version['files']['minor'] && $major > $version['files']['major']) &&
								($minor < $version['database']['minor'] && $major > $version['database']['major']))
						{
							$severity = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'severity');
							
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
							$update['severity'] = $severity[0]['data'];
						}
					
						break;
						
					case 'all':
						if ($i->get_title() != $version['files']['full'] && $i->get_title() != $version['database']['full'])
						{
							$severity = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'severity');
							
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
							$update['severity'] = $severity[0]['data'];
						}
							
						break;
				}
			}
			
			if ($version['database']['full'] > $version['files']['full'])
			{
				$data['update']['version'] = sprintf(
					lang_output('update_outofdate_files'),
					$version['files']['full'],
					$version['database']['full']
				);
				$data['update']['desc'] = $update['description'];
				$data['update']['link'] = 'http://www.anodyne-productions.com/index.php/nova/downloads';
				
				switch ($update['severity'])
				{
					case 'critical':
						$data['update']['severity'] = 'red';
						break;
					
					case 'major':
						$data['update']['severity'] = 'orange';
						break;
						
					case 'minor':
						$data['update']['severity'] = 'blue';
						break;
				}
			}
			elseif ($version['database']['full'] < $version['files']['full'])
			{
				$data['update']['version'] = sprintf(
					lang_output('update_outofdate_database'),
					$version['database']['full'],
					$version['files']['full']
				);
				$data['update']['desc'] = $update['description'];
				$data['update']['link'] = 'http://www.anodyne-productions.com/index.php/nova/downloads';
				
				switch ($update['severity'])
				{
					case 'critical':
						$data['update']['severity'] = 'red';
						break;
					
					case 'major':
						$data['update']['severity'] = 'orange';
						break;
						
					case 'minor':
						$data['update']['severity'] = 'blue';
						break;
				}
			}
			elseif (isset($update))
			{
				$data['update']['version'] = sprintf(
					lang_output('update_available'),
					APP_NAME,
					$update['version'],
					APP_NAME
				);
				$data['update']['desc'] = $update['description'];
				$data['update']['link'] = 'http://www.anodyne-productions.com/index.php/nova/downloads';
				
				switch ($update['severity'])
				{
					case 'critical':
						$data['update']['severity'] = 'red';
						break;
					
					case 'major':
						$data['update']['severity'] = 'orange';
						break;
						
					case 'minor':
						$data['update']['severity'] = 'blue';
						break;
				}
			}
			
			$js_data['panel'] = (isset($data['update'])) ? 'update' : $js_data['panel'];
		}
		
		/* view data */
		$data['header'] = lang('head_admin_index');
		
		/*  javascript data */
		$js_data['first_launch'] = $this->session->flashdata('first_launch');
		$js_data['password_reset'] = $this->session->flashdata('password_reset');
		$js_data['version'] = (isset($update)) ? $update['version'] : '';
		
		$data['label'] = array(
			'view_all_posts' => ucwords(lang('actions_viewall') .' '. lang('global_posts') .' '. RARROW),
			'view_all_logs' => ucwords(lang('actions_viewall') .' '. lang('global_personallogs') .' '. RARROW),
			'view_all_news' => ucwords(lang('actions_viewall') .' '. lang('global_newsitems') .' '. RARROW),
			'mynova' => ucwords(lang('labels_my') .' '. APP_NAME),
			'mynotify' => ucwords(lang('labels_my') .' '. lang('labels_notifications')),
			'online' => ucwords(lang('online_now')) .':',
			's_posts' => ucwords(lang('status_saved') .' '. lang('global_missionposts')),
			's_logs' => ucwords(lang('status_saved') .' '. lang('global_personallogs')),
			's_news' => ucwords(lang('status_saved') .' '. lang('global_newsitems')),
			'pm' => ucwords(lang('status_unread') .' '. lang('global_privatemessages')),
			'p_players' => ucwords(lang('status_pending') .' '. lang('global_characters')),
			'p_posts' => ucwords(lang('status_pending') .' '. lang('global_missionposts')),
			'p_logs' => ucwords(lang('status_pending') .' '. lang('global_personallogs')),
			'p_news' => ucwords(lang('status_pending') .' '. lang('global_newsitems')),
			'p_comments' => ucwords(lang('status_pending') .' '. lang('labels_comments')),
			'p_awards' => ucwords(lang('status_pending') .' '. lang('global_award') .' '. lang('labels_nominations')),
			'r_posts' => ucwords(lang('status_recent') .' '. lang('global_missionposts')),
			'r_logs' => ucwords(lang('status_recent') .' '. lang('global_personallogs')),
			'r_news' => ucwords(lang('status_recent') .' '. lang('global_newsitems')),
			'posts' => ucwords(lang('global_missionposts')),
			'logs' => ucwords(lang('global_personallogs')),
			'news' => ucwords(lang('global_newsitems')),
			'post_comments' => ucwords(lang('global_missionpost') .' '. lang('labels_comments')),
			'log_comments' => ucwords(lang('global_personallog') .' '. lang('labels_comments')),
			'news_comments' => ucwords(lang('global_newsitem') .' '. lang('labels_comments')),
			'title' => ucfirst(lang('labels_title')),
			'date' => ucfirst(lang('labels_date')),
			'by' => ucfirst(lang('labels_by')),
			'category' => ucfirst(lang('labels_category')) .':',
			'mission' => ucfirst(lang('global_mission')) .':',
			'joined' => ucfirst(lang('actions_joined')),
			'ago' => lang('time_ago'),
			'last_post' => ucwords(lang('order_last') .' '. lang('global_post')) .':',
			'last_login' => ucwords(lang('order_last') .' '. lang('actions_login')) .':',
			'activity' => ucfirst(lang('labels_activity')),
			'milestones' => ucfirst(lang('labels_milestones')),
			'noposts' => lang('error_no_posts'),
			'nologs' => lang('error_no_logs'),
			'nonews' => lang('error_no_news'),
			'update' => ucwords(APP_NAME .' '. lang('actions_update')),
			'getupdate' => ucfirst(lang('actions_get') .' '. lang('labels_the') .' '. lang('actions_update')) .' '. RARROW,
			'ignore' => ucfirst(lang('actions_ignore') .' '. lang('labels_this') .' '. lang('labels_version')),
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('admin_index', $this->skin, 'admin');
		$js_loc = js_location('admin_index_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', lang('head_admin_index'));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function error()
	{
		/* set the variables */
		$error = $this->uri->segment(3, 0);
		$page = ($this->session->flashdata('referer')) ? $this->session->flashdata('referer') : FALSE;
		
		$data['header'] = lang('head_admin_error');
		
		/* set the data used by the view */
		$data['error'] = sprintf(
			lang('error_admin_'. $error),
			$page,
			'foo'
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('error', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', lang('head_admin_error'));
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function version()
	{
		$version = array(
			'version' => APP_VERSION,
			'major' => APP_MAJOR_VERSION,
			'minor' => APP_MINOR_VERSION,
			'update' => APP_UPDATE_VERSION
		);
		
		$this->_check_version($version);
	}
	
	function whats_new()
	{
		/* load the model and assign the data to a variable */
		$this->load->model('system_model', 'sys');
		$data['whats_new'] = $this->sys->get_whatsnew();
		
		/* load the view */
		$this->load->view('_base/admin/pages/whats_new', $data);
	}
	
	function _check_version($local_version = '')
	{
		/*
		
		CRITERIA
		
			if they only want MAJOR updates:
				* get the base version
				* if they're the same (which they should be), don't do anything
				* get the major version variable
				* if they're the same, don't do anything
				* if what's coming from the XML file is greater, then there's a new major version
			
			if they want ALL updates:
				* check the major version
				* check the minor version
				* check the update version
		
		*/
		
		/* load the simplepie library */
		$this->load->library('simplepie');
		
		/* set the feed url and initiate it */
		$this->simplepie->set_feed_url(APPFOLDER . '/assets/version.xml');
		$this->simplepie->init();
		
		/* assign the objects to an array */
		$items = $this->simplepie->get_items();
		
		echo 'local version - '. $local_version['version'] .'<br />';
		
		/* create an array that will hold all the version info */
		$versions = array();
		
		foreach ($items as $item)
		{ /* go through the feed items */
			$major = $item->get_item_tags('', 'major');
			$minor = $item->get_item_tags('', 'minor');
			$update = $item->get_item_tags('', 'update');
			
			/* add the items to the versions array */
			$versions[] = array(
				'version' => $item->get_title(),
				'major' => $major[0]['data'],
				'minor' => $minor[0]['data'],
				'update' => $update[0]['data']
			);
		}
		
		foreach ($versions as $key => $value)
		{ /* loop through the versions array and remove unneeded items */
			
			if ($this->globals['updates'] == 'major')
			{
				
			}
			elseif ($this->globals['updates'] == 'minor')
			{
				
			}
			
			
			
			if (
				($this->globals['updates'] == 'major' && ($value['major'] == $local_version['major'] || $value['minor'] <= $local_version['minor'])) ||
				($value['version'] == $local_version['version'])
				)
			{
				unset($versions[$key]);
			}
		}
		
		$this->load->helper('debug');
		print_var($versions);
	}
}

/* End of file admin_base.php */
/* Location: ./application/controllers/admin_base.php */