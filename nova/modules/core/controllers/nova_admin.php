<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Admin controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_admin extends Nova_controller_admin {

	public function __construct()
	{
		parent::__construct();

		// load the install language file
		$this->nova->lang('install');
	}

	public function index()
	{
		// load the resources
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('news_model', 'news');
		$this->load->model('missions_model', 'mis');
		$this->load->model('privmsgs_model', 'pm');
		$this->load->model('awards_model', 'awards');
		$this->load->model('wiki_model', 'wiki');
		$this->load->model('docking_model', 'docking');
		$this->load->helper('utility');

		if (isset($_POST['submit']))
		{
			$action = $this->input->post('action', TRUE);

			if ($action == 'password_change')
			{
				$password = $this->input->post('password', TRUE);
				$user = $this->input->post('user', TRUE);

				// make sure the person submitting the form is the person logged in
				if ($user == $this->session->userdata('userid'))
				{
					$update_array = array(
						'password' => Auth::hash($password),
						'password_reset' => 0,
						'last_update' => now()
					);

					$update = $this->user->update_user($user, $update_array);

					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_password')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);

						// load the cookie helper
						$this->load->helper('cookie');

						// grab nova's unique identifier
						$uid = $this->sys->get_nova_uid();

						// grab the cookie
						$cookie = get_cookie('nova_'. $uid);

						if ($cookie !== FALSE)
						{
							// set the cookie data
							$c_data = array(
								'password' => array(
									'name'   => $uid .'[password]',
									'value'  => Auth::hash($password),
									'expire' => '1209600',
									'prefix' => 'nova_')
							);

							// set the cookie
							set_cookie($c_data['password']);
						}
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_password')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}

					$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
				}
			}

			$update = false;
		}

		/*
		|---------------------------------------------------------------
		| STATS
		|---------------------------------------------------------------
		*/

		if (is_array($this->session->userdata('characters')) && count($this->session->userdata('characters')) > 0)
		{
			$data['posts'] = array(
				'entries' => $this->posts->count_character_posts($this->session->userdata('characters')),
				'comments' => $this->posts->count_user_post_comments($this->session->userdata('userid'))
			);
			$data['logs'] = array(
				'entries' => $this->logs->count_character_logs($this->session->userdata('characters')),
				'comments' => $this->logs->count_user_log_comments($this->session->userdata('userid'))
			);
			$data['news'] = array(
				'entries' => $this->news->count_character_news($this->session->userdata('characters')),
				'comments' => $this->news->count_user_news_comments($this->session->userdata('userid'))
			);
		}
		else
		{
			$data['posts'] = array(
				'entries' => 0,
				'comments' => $this->posts->count_user_post_comments($this->session->userdata('userid'))
			);
			$data['logs'] = array(
				'entries' => 0,
				'comments' => $this->logs->count_user_log_comments($this->session->userdata('userid'))
			);
			$data['news'] = array(
				'entries' => 0,
				'comments' => $this->news->count_user_news_comments($this->session->userdata('userid'))
			);
		}

		/*
		|---------------------------------------------------------------
		| NOTIFICATIONS
		|---------------------------------------------------------------
		*/

		$data['notification'] = array(
			'saved_logs'		=> $this->logs->count_user_logs($this->session->userdata('userid'), 'saved'),
			'saved_news' 		=> $this->news->count_user_news($this->session->userdata('userid'), 'saved'),
			'unread_pms' 		=> $this->pm->count_pms($this->session->userdata('userid'), 'unread'),
			'pending_users' 	=> (Auth::check_access('characters/index', false)) ? $this->char->count_characters('pending', '') : 0,
			'pending_posts' 	=> $this->posts->count_all_posts('', 'pending'),
			'pending_logs' 		=> $this->logs->count_all_logs('pending'),
			'pending_news' 		=> $this->news->count_news_items('pending'),
			'pending_comments' 	=> $this->posts->count_all_post_comments('pending') + $this->logs->count_all_log_comments('pending') + $this->news->count_news_comments('pending') + $this->wiki->count_all_comments('pending'),
			'pending_awards' 	=> $this->awards->count_award_noms('pending'),
			'pending_docked' 	=> $this->docking->count_docked_items('pending'),
		);

		if (is_array($this->session->userdata('characters')) and count($this->session->userdata('characters')) > 0)
		{
			$data['notification']['saved_posts'] = $this->posts->count_character_posts($this->session->userdata('characters'), 'saved');
		}
		else
		{
			$data['notification']['saved_posts'] = 0;
		}

		// set the count to zero by default
		$data['notifycount'] = 0;

		foreach ($data['notification'] as $a)
		{
			$data['notifycount'] += $a;
		}

		// pass the count to the js view
		$js_data['panel'] = ($data['notifycount'] > 0) ? 'notifications' : 'stats';

		/*
		|---------------------------------------------------------------
		| ACTIVITY
		|---------------------------------------------------------------
		*/

		$all = $this->user->get_users();

		$now = now();
		$threshold = $now - ($this->options['posting_requirement'] * 86400);

		// set activity as an empty array to avoid errors
		$data['activity'] = array();

		if ($all->num_rows() > 0)
		{
			foreach ($all->result() as $a)
			{
				if ($threshold > $a->last_post)
				{
					$data['activity'][$a->userid] = array(
						'post' => ( ! empty($a->last_post)) ? $a->last_post : lang('error_no_last_post'),
						'login' => ( ! empty($a->last_login)) ? $a->last_login : lang('error_no_last_login'),
						'name' => $this->char->get_character_name($a->main_char, true, false, true)
					);
				}

				$milestones[] = array(
					'id' => $a->userid,
					'char' => $a->main_char,
					'join' => $a->join_date
				);
			}
		}

		// set the count to zero by default
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
						'name' => $this->char->get_character_name($m['char'], true, false, true),
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
						'name' => $this->char->get_character_name($m['char'], true, false, true),
						'months' => $months,
						'years' => $years,
						'timespan' => timespan($m['join'], $now)
					);
				}
			}

			foreach ($data['milestones'] as $k => $v)
			{
				if ( ($v['years'] == 0 and $v['months'] != 6) or ($v['years'] > 0 and $v['months'] > 0) )
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

		// set the datestring
		$datestring = $this->options['date_format'];

		// grab the data
		$posts_all = $this->posts->get_post_list('', 'desc', 10, '', 'activated');
		$logs_all = $this->logs->get_log_list(10);
		$news_all = $this->news->get_news_items(10, $this->session->userdata('userid'));

		if ($posts_all->num_rows() > 0)
		{
			$i = 1;
			foreach ($posts_all->result() as $p)
			{
				$data['posts_all'][$i]['title'] = $p->post_title;
				$data['posts_all'][$i]['post_id'] = $p->post_id;
				$data['posts_all'][$i]['date'] = mdate($datestring, gmt_to_local($p->post_date, $this->timezone, $this->dst));
				$data['posts_all'][$i]['authors'] = $this->char->get_authors($p->post_authors, true, true);
				$data['posts_all'][$i]['mission'] = $this->mis->get_mission($p->post_mission, 'mission_title');
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
				$data['logs_all'][$i]['author'] = $this->char->get_character_name($l->log_author_character, true, false, true);

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
				$data['news_all'][$i]['author'] = $this->char->get_character_name($n->news_author_character, true, false, true);
				$data['news_all'][$i]['date'] = mdate($datestring, gmt_to_local($n->news_date, $this->timezone, $this->dst));

				++$i;
			}
		}

		/*
		|---------------------------------------------------------------
		| NEW VERSION NOTIFICATION
		|---------------------------------------------------------------
		*/

		$data['update'] = FALSE;

		if (Auth::is_sysadmin($this->session->userdata('userid')) and $this->options['updates'] != 'none')
		{
			// load the install file
			$this->nova->load('install', $this->session->userdata('language'));

			// grab the ignore version
			$ignore = $this->sys->get_item('system_info', 'sys_id', 1, 'sys_version_ignore');

			// go check the version
			$check = $this->_check_version();

			if (isset($check['update']['version']) && $check['update']['version'] != $ignore)
			{
				$data['update']['version'] = $check['flash']['header'];
				$data['update']['version_only'] = $check['update']['version'];
				$data['update']['desc'] = $check['flash']['message'];
				$data['update']['link'] = ($check['flash']['status'] == 1) ? $check['update']['link'] : site_url('update/index');
				$data['update']['status'] = $check['flash']['status'];

				switch ($check['update']['severity'])
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
		}

		// set the panel
		$js_data['panel'] = ($data['update'] !== FALSE) ? 'update' : $js_data['panel'];

		// view data
		$data['header'] = lang('head_admin_index');

		// javascript data
		$js_data['first_launch'] = $this->session->flashdata('first_launch');
		$js_data['password_reset'] = $this->session->flashdata('password_reset');
		$js_data['version'] = (isset($check['update']['version'])) ? $check['update']['version'] : '';

		$data['loader'] = array(
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
		);

		$data['label'] = array(
			'view_all_posts' => ucwords(lang('actions_viewall') .' '. lang('global_posts') .' '. RARROW),
			'view_all_logs' => ucwords(lang('actions_viewall') .' '. lang('global_personallogs') .' '. RARROW),
			'view_all_news' => ucwords(lang('actions_viewall') .' '. lang('global_newsitems') .' '. RARROW),
			'mynova' => ucwords(lang('labels_my') .' '. APP_NAME),
			'mynotify' => ucfirst(lang('labels_notifications')),
			'online' => ucwords(lang('online_now')) .':',
			's_posts' => ucwords(lang('status_saved') .' '. lang('global_missionposts')),
			's_logs' => ucwords(lang('status_saved') .' '. lang('global_personallogs')),
			's_news' => ucwords(lang('status_saved') .' '. lang('global_newsitems')),
			'pm' => ucwords(lang('status_unread') .' '. lang('global_privatemessages')),
			'p_users' => ucwords(lang('status_pending') .' '. lang('global_characters')),
			'p_posts' => ucwords(lang('status_pending') .' '. lang('global_missionposts')),
			'p_logs' => ucwords(lang('status_pending') .' '. lang('global_personallogs')),
			'p_news' => ucwords(lang('status_pending') .' '. lang('global_newsitems')),
			'p_comments' => ucwords(lang('status_pending') .' '. lang('labels_comments')),
			'p_awards' => ucwords(lang('status_pending') .' '. lang('global_award') .' '. lang('labels_nominations')),
			'p_docked' => ucwords(lang('status_pending') .' '. lang('actions_docking') .' '. lang('labels_requests')),
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
			'noposts' => sprintf(lang('error_not_found'), lang('global_posts')),
			'nologs' => sprintf(lang('error_not_found'), lang('global_logs')),
			'nonews' => sprintf(lang('error_not_found'), lang('global_news')),
			'update' => ucwords(APP_NAME .' '. lang('actions_update')),
			'getupdate' => ucfirst(lang('actions_get') .' '. lang('labels_the') .' '. lang('actions_update')) .' '. RARROW,
			'runupdate' => ucfirst(lang('actions_run') .' '. lang('labels_the') .' '. lang('actions_update')) .' '. RARROW,
			'ignore' => ucfirst(lang('actions_ignore') .' '. lang('labels_this') .' '. lang('labels_version')),
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'nonotifications' => ucfirst(lang('labels_no') .' '. lang('labels_notifications') .' '. lang('labels_available')),
			'nomilestones' => ucfirst(lang('labels_no') .' '. lang('labels_milestones') .' '. lang('labels_available')),
			'noactivity' => ucfirst(lang('labels_no') .' '. lang('labels_activity') .' '. lang('labels_notifications')),

			'm_pending_items' => ucwords(lang('status_pending').' '.lang('labels_items')),

			'm_useropts' => ucwords(lang('global_user') .' '. lang('labels_options')),
			'm_loa' => ucwords(lang('actions_request') .' '. lang('abbr_loa')),

			'm_pms' => ucwords(lang('global_privatemessages')),
			'm_inbox' => ucwords(lang('labels_inbox')),
			'm_sent' => ucwords(lang('actions_sent').' '.lang('labels_messages')),
			'm_write' => ucwords(lang('actions_write') .' '. lang('status_new') .' '. lang('labels_message')),

			'm_wcp' => ucwords(lang('labels_writing') .' '. lang('labels_controlpanel')),
			'm_saved' => ucwords(lang('labels_my') .' '. lang('status_saved') .' '. lang('labels_entries')),
			'm_write_log' => ucwords(lang('actions_write') .' '. lang('global_personallog')),
			'm_write_news' => ucwords(lang('actions_write') .' '. lang('global_newsitem')),
			'm_write_post' => ucwords(lang('actions_write') .' '. lang('global_missionpost')),
		);

		$this->_regions['content'] = Location::view('admin_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('admin_index_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= lang('head_admin_index');

		Template::assign($this->_regions);

		Template::render();
	}

	public function error($code = 0)
	{
		// sanity check
		$code = (is_numeric($code)) ? $code : false;

		// set the referer
		$page = ($this->session->flashdata('referer')) ? $this->session->flashdata('referer') : false;

		// set the data used by the view
		$data['header'] = lang('head_admin_error');
		$data['error'] = lang('error_admin_'.$code);

		$this->_regions['content'] = Location::view('error', $this->skin, 'admin', $data);
		$this->_regions['title'].= lang('head_admin_error');

		Template::assign($this->_regions);

		Template::render();
	}
	
	protected function _check_version()
	{
		if (ini_get('allow_url_fopen'))
		{
			// load the resources
			$this->load->helper('yayparser');

			// get the contents of the file
			$contents = file_get_contents(VERSION_FEED);

			// parse the contents of the yaml file
			$array = yayparser($contents);

			// get the system information
			$system = $this->sys->get_system_info();

			// build the array of version info
			$version = array(
				'files' => array(
					'full'		=> APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
					'major'		=> APP_VERSION_MAJOR,
					'minor'		=> APP_VERSION_MINOR,
					'update'	=> APP_VERSION_UPDATE
				),
				'database' => array(
					'full'		=> $system->sys_version_major .'.'. $system->sys_version_minor .'.'. $system->sys_version_update,
					'major'		=> $system->sys_version_major,
					'minor'		=> $system->sys_version_minor,
					'update'	=> $system->sys_version_update
				),
			);

			// grab the updates setting
			$type = $this->options['updates'];

			$update = FALSE;

			switch ($type)
			{
				case 'major':

					if (version_compare($array['version_major'], $version['files']['major'], '>') || version_compare($array['version_major'], $version['database']['major'], '>'))
					{
						$update['version']		= $array['version'];
						$update['notes']		= $array['notes'];
						$update['severity']		= $array['severity'];
						$update['link']			= $array['link'];
					}
				break;

				case 'minor':

					if (version_compare($array['version_minor'], $version['files']['minor'], '>') || version_compare($array['version_minor'], $version['database']['minor'], '>'))
					{
						$update['version']		= $array['version'];
						$update['notes']		= $array['notes'];
						$update['severity']		= $array['severity'];
						$update['link']			= $array['link'];
					}
				break;

				case 'update':

					if (version_compare($array['version_update'], $version['files']['update'], '>') || version_compare($array['version_update'], $version['database']['update'], '>'))
					{
						$update['version']		= $array['version'];
						$update['notes']		= $array['notes'];
						$update['severity']		= $array['severity'];
						$update['link']			= $array['link'];
					}
				break;

				case 'all':

					if (version_compare($version['files']['full'], $array['version'], '<') || version_compare($version['database']['full'], $array['version'], '<'))
					{
						$update['version']		= $array['version'];
						$update['notes']		= $array['notes'];
						$update['severity']		= $array['severity'];
						$update['link']			= $array['link'];
					}
				break;
			}

			if (version_compare($version['database']['full'], $version['files']['full'], '>'))
			{
				$flash['header'] = lang('update_required');
				$flash['message'] = sprintf(
					lang('update_outofdate_files'),
					$version['files']['full'],
					$version['database']['full']
				);
				$flash['status'] = 2;
			}
			elseif (version_compare($version['database']['full'], $version['files']['full'], '<'))
			{
				$flash['header'] = lang('update_required');
				$flash['message'] = sprintf(
					lang('update_outofdate_database'),
					$version['database']['full'],
					$version['files']['full']
				);
				$flash['status'] = 2;
			}
			elseif (isset($update))
			{
				$flash['header'] = sprintf(
					lang('update_available'),
					APP_NAME,
					$update['version'],
					''
				);
				$flash['message'] = $update['notes'];
				$flash['status'] = 1;
			}
			else
			{
				$flash['header'] = '';
				$flash['message'] = '';
				$flash['status'] = '';
			}

			$retval = array(
				'flash' => $flash,
				'update' => $update
			);

			return $retval;
		}

		return false;
	}
}
