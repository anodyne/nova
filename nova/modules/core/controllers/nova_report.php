<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Report controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_report extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->_regions['content'] = Location::view('upload_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('upload_index_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function activity()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('posts_model', 'posts');
		$this->load->model('news_model', 'news');
		
		$users = $this->user->get_users();
		
		if ($users->num_rows() > 0)
		{
			// set the posting requirement threshold
			$requirement = now() - (86400 * $this->options['posting_requirement']);
			
			$timeframe = $this->options['posting_requirement'] * 86400;
			$timeframe = now() - $timeframe;
			
			$month = 30 * 86400;
			$month = now() - $month;
			
			foreach ($users->result() as $p)
			{
				$data['users'][$p->userid] = array(
					'name' => $p->name,
					'main_char' => $this->char->get_character_name($p->main_char, true),
					'email' => $p->email,
					'id' => $p->userid,
					'charid' => $p->main_char,
					'last_post' => timespan_short($p->last_post, now()),
					'last_login' => timespan_short($p->last_login, now()),
					'requirement_post' => ($p->last_post < $requirement) ? ' red' : '',
					'requirement_login' => ($p->last_login < $requirement) ? ' red' : '',
					'loa' => ($p->loa != 'active') ? '['. strtoupper($p->loa) .']' : '',
					'posts' => array(
						'timeframe' => $this->posts->count_user_posts($p->userid, 'activated', $timeframe),
						'month' => $this->posts->count_user_posts($p->userid, 'activated', $month),
					),
					'logs' => array(
						'timeframe' => $this->logs->count_user_logs($p->userid, 'activated', $timeframe),
						'month' => $this->logs->count_user_logs($p->userid, 'activated', $month),
					),
					'news' => array(
						'timeframe' => $this->news->count_user_news($p->userid, 'activated', $timeframe),
						'month' => $this->news->count_user_news($p->userid, 'activated', $month),
					),
				);
			}
		}
		
		$data['header'] = lang('head_report_activity');
		
		$data['label'] = array(
			'biochar' => ucwords(lang('global_character') .' '. lang('labels_bio')),
			'biouser' => ucwords(lang('global_user') .' '. lang('labels_bio')),
			'days' => ucfirst(lang('time_days')),
			'lastlogin' => ucwords(lang('order_last') .' '. lang('actions_login')),
			'lastpost' => ucwords(lang('order_last') .' '. lang('global_post')),
			'logs' => ucwords(lang('global_logs')),
			'name' => ucfirst(lang('labels_name')),
			'news' => ucwords(lang('global_news')),
			'posts' => ucwords(lang('global_posts')),
			'totals' => ucfirst(lang('labels_totals'))
		);
		
		$this->_regions['content'] = Location::view('report_activity', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_activity_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function applications($offset = 0)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->library('pagination');
		$this->load->model('applications_model', 'apps');
		
		// sanity check
		$offset = (is_numeric($offset)) ? $offset : false;
	
		// set the pagination configs
		$config['base_url'] = site_url('report/applications/');
		$config['total_rows'] = $this->apps->count_applications();
		$config['per_page'] = 25;
		$config['full_tag_open'] = '<p class="fontMedium bold">';
		$config['full_tag_close'] = '</p>';
	
		// initialize the pagination library
		$this->pagination->initialize($config);
		
		// create the page links
		$data['pagination'] = $this->pagination->create_links();
		
		$applications = $this->apps->get_applications();
		
		if ($applications->num_rows() > 0)
		{
			foreach ($applications->result() as $a)
			{
				$date = gmt_to_local($a->app_date, $this->timezone, $this->dst);
				
				$data['apps'][$a->app_id] = array(
					'id' => $a->app_id,
					'character' => $a->app_character_name,
					'user' => $a->app_user_name,
					'email' => $a->app_email,
					'ipaddr' => $a->app_ip,
					'position' => $a->app_position,
					'action' => $a->app_action,
					'date' => mdate($this->options['date_format'], $date)
				);
			}
		}
		
		$data['images'] = array(
			'green' => array(
				'src' => Location::img('icon-green.png', $this->skin, 'admin'),
				'alt' => lang('actions_accepted'),
				'class' => 'image'),
			'red' => array(
				'src' => Location::img('icon-red.png', $this->skin, 'admin'),
				'alt' => lang('actions_rejected'),
				'class' => 'image'),
			'yellow' => array(
				'src' => Location::img('icon-yellow.png', $this->skin, 'admin'),
				'alt' => lang('status_pending'),
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_deleted'),
				'class' => 'image'),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view')),
				'class' => 'image'),
		);
		
		$data['header'] = lang('head_report_applications');
		
		$data['text'] = sprintf(
			lang('text_applications_report'),
			img($data['images']['green']),
			img($data['images']['red']),
			img($data['images']['delete']),
			img($data['images']['yellow'])
		);
		
		$data['label'] = array(
			'action' => ucfirst(lang('actions_action')),
			'character' => ucfirst(lang('global_character')),
			'date' => ucfirst(lang('labels_date')),
			'email' => ucfirst(lang('labels_email')),
			'ipaddr' => ucwords(lang('labels_ipaddr')),
			'none' => ucfirst(lang('labels_no') .' '. lang('labels_applications') .' '. lang('actions_found')),
			'user' => ucfirst(lang('global_user')),
			'position' => ucfirst(lang('global_position')),
		);
		
		$this->_regions['content'] = Location::view('report_applications', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_applications_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function awardnominations($offset = 0)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->library('pagination');
		$this->load->model('awards_model', 'awards');
		
		// sanity check
		$offset = (is_numeric($offset)) ? $offset : false;
	
		// set the pagination configs
		$config['base_url'] = site_url('report/awardnominations/');
		$config['total_rows'] = $this->awards->count_award_noms('');
		$config['per_page'] = 25;
		$config['full_tag_open'] = '<p class="fontMedium bold">';
		$config['full_tag_close'] = '</p>';
	
		// initialize the pagination library
		$this->pagination->initialize($config);
		
		// create the page links
		$data['pagination'] = $this->pagination->create_links();
		
		$nominations = $this->awards->get_award_noms('');
		
		if ($nominations->num_rows() > 0)
		{
			foreach ($nominations->result() as $n)
			{
				$date = gmt_to_local($n->queue_date, $this->timezone, $this->dst);
				
				$data['nominations'][$n->queue_id] = array(
					'nominate' => $this->char->get_character_name($n->queue_nominate, true, false, true),
					'awardid' => $n->queue_award,
					'charid' => $n->queue_nominate,
					'award' => $this->awards->get_award($n->queue_award, 'award_name'),
					'reason' => $n->queue_reason,
					'status' => $n->queue_status,
					'date' => mdate($this->options['date_format'], $date)
				);
				
				if (empty($n->queue_receive_character))
				{
					$charid = $this->user->get_user($n->queue_receive_user, 'main_char');
					$data['nominations'][$n->queue_id]['name'] = $this->char->get_character_name($charid, true, false, true);
				}
				else
				{
					$charid = $n->queue_receive_character;
					$data['nominations'][$n->queue_id]['name'] = $this->char->get_character_name($charid, true, false, true);
				}
			}
		}
		
		$data['images'] = array(
			'green' => array(
				'src' => Location::img('icon-green.png', $this->skin, 'admin'),
				'alt' => lang('actions_approved'),
				'class' => 'image'),
			'red' => array(
				'src' => Location::img('icon-red.png', $this->skin, 'admin'),
				'alt' => lang('actions_rejected'),
				'class' => 'image'),
			'yellow' => array(
				'src' => Location::img('icon-yellow.png', $this->skin, 'admin'),
				'alt' => lang('status_pending'),
				'class' => 'image'),
		);
		
		$data['header'] = lang('head_report_awardnominations');
		
		$data['text'] = sprintf(
			lang('text_awardnom_report'),
			lang('global_award'),
			lang('global_awards'),
			img($data['images']['green']),
			lang('global_awards'),
			img($data['images']['yellow']),
			lang('global_awards'),
			img($data['images']['red'])
		);
		
		$data['label'] = array(
			'award' => ucfirst(lang('global_award')),
			'date' => ucfirst(lang('labels_date')),
			'nominated' => ucwords(lang('actions_nominated') .' '. lang('labels_by')),
			'none' => ucfirst(lang('labels_no') .' '. lang('global_award') .' '. 
				lang('labels_nominations') .' '. lang('actions_found')),
		);
		
		$this->_regions['content'] = Location::view('report_awardnominations', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_awardnominations_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function loa($offset = 0)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->library('pagination');
		
		// sanity check
		$offset = (is_numeric($offset)) ? $offset : false;
	
		// set the pagination configs
		$config['base_url'] = site_url('report/loa/');
		$config['total_rows'] = $this->sys->count_loa_records();
		$config['per_page'] = 25;
		$config['full_tag_open'] = '<p class="fontMedium bold">';
		$config['full_tag_close'] = '</p>';
	
		// initialize the pagination library
		$this->pagination->initialize($config);
		
		// create the page links
		$data['pagination'] = $this->pagination->create_links();
		
		// run the method
		$records = $this->sys->get_loa_records($config['per_page'], $offset);
		
		if ($records->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			
			foreach ($records->result() as $r)
			{
				$date_start = gmt_to_local($r->loa_start_date, $this->timezone, $this->dst);
				$date_end = gmt_to_local($r->loa_end_date, $this->timezone, $this->dst);
				
				$end = ( ! empty($r->loa_end_date)) ? $r->loa_end_date : now();
				
				$user = $this->user->get_user($r->loa_user);
				$name = ( ! empty($user->name)) ? $user->name : $user->email;
				
				$data['loa'][$r->loa_id]['user'] = $name;
				$data['loa'][$r->loa_id]['date_start'] = mdate($datestring, $date_start);
				$data['loa'][$r->loa_id]['date_end'] = ( ! empty($r->loa_end_date)) ? mdate($datestring, $date_end) : '';
				$data['loa'][$r->loa_id]['duration'] = $r->loa_duration;
				$data['loa'][$r->loa_id]['duration_actual'] = timespan($r->loa_start_date, $end);
				$data['loa'][$r->loa_id]['reason'] = $r->loa_reason;
			}
		}
		
		$data['header'] = lang('head_report_loa');
		
		$data['label'] = array(
			'date_end' => ucfirst(lang('status_end')) .':',
			'date_start' => ucfirst(lang('status_start')) .':',
			'dates' => ucfirst(lang('labels_dates')),
			'duration_expected' => ucwords(lang('labels_expected') .' '. lang('labels_duration')) .':',
			'duration_actual' => ucwords(lang('labels_actual') .' '. lang('labels_duration')) .':',
			'name' => ucfirst(lang('labels_name')),
			'none' => ucfirst(lang('labels_no') .' '. lang('abbr_loa') .' '. 
				lang('labels_records') .' '. lang('actions_found')),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		$this->_regions['content'] = Location::view('report_loa', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_loa_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function milestones()
	{
		Auth::check_access();
		
		$users = $this->user->get_users();
		
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $p)
			{
				$date = gmt_to_local($p->join_date, $this->timezone, $this->dst);
				
				$data['users'][$p->userid] = array(
					'name' => $this->char->get_character_name($p->main_char, true),
					'id' => $p->userid,
					'charid' => $p->main_char,
					'join_date' => mdate($this->options['date_format'], $date),
					'timespan' => timespan_short($p->join_date, now()),
				);
			}
		}
		
		$data['header'] = lang('head_report_milestones');
		
		$data['label'] = array(
			'bio_char' => ucwords(lang('global_character') .' '. lang('labels_bio')),
			'bio_user' => ucwords(lang('global_user') .' '. lang('labels_bio')),
			'name' => ucwords(lang('global_character') .' '. lang('labels_name')),
			'timespan' => ucfirst(lang('time_timespan')),
		);
		
		$this->_regions['content'] = Location::view('report_milestones', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_milestones_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function moderation()
	{
		Auth::check_access();
		
		$users = $this->user->get_users();
		
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $p)
			{
				$data['users'][$p->userid] = array(
					'name' => $this->char->get_character_name($p->main_char, true),
					'id' => $p->userid,
					'charid' => $p->main_char,
					'posts' => ($p->moderate_posts == 'y') ? 'red' : 'green',
					'comments_p' => ($p->moderate_post_comments == 'y') ? 'red' : 'green',
					'logs' => ($p->moderate_logs == 'y') ? 'red' : 'green',
					'comments_l' => ($p->moderate_log_comments == 'y') ? 'red' : 'green',
					'news' => ($p->moderate_news == 'y') ? 'red' : 'green',
					'comments_n' => ($p->moderate_news_comments == 'y') ? 'red' : 'green',
					'comments_w' => ($p->moderate_wiki_comments == 'y') ? 'red' : 'green',
				);
			}
		}
		
		$data['header'] = lang('head_report_moderation');
		
		$data['images'] = array(
			'green' => array(
				'src' => Location::img('icon-green.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'red' => array(
				'src' => Location::img('icon-red.png', $this->skin, 'admin'),
				'alt' => lang('actions_moderated'),
				'class' => 'image'),
		);
		
		$data['text'] = sprintf(
			lang('text_moderation_report'),
			lang('global_users'),
			img($data['images']['green']),
			img($data['images']['red'])
		);
		
		$data['label'] = array(
			'bio_char' => ucwords(lang('global_character') .' '. lang('labels_bio')),
			'bio_user' => ucwords(lang('global_user') .' '. lang('labels_bio')),
			'comments_l' => ucwords(lang('global_log') ."\r\n". lang('labels_comments')),
			'comments_n' => ucwords(lang('global_news') ."\r\n". lang('labels_comments')),
			'comments_p' => ucwords(lang('global_post') ."\r\n". lang('labels_comments')),
			'comments_w' => ucwords(lang('global_wiki') ."\r\n". lang('labels_comments')),
			'logs' => ucfirst(lang('global_logs')),
			'name' => ucwords(lang('global_character') .' '. lang('labels_name')),
			'news' => ucfirst(lang('global_news')),
			'posts' => ucfirst(lang('global_posts')),
		);
		
		$this->_regions['content'] = Location::view('report_moderation', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_moderation_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function posting()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('posts_model', 'posts');
		$this->load->model('news_model', 'news');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		// get all the users
		$users = $this->user->get_users('');
		
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $p)
			{
				if ($p->status != 'pending')
				{
					$last = now() - $p->last_post;
					$last = $last / 86400;
					
					$date = gmt_to_local($p->last_post, $this->timezone, $this->dst);
					
					$data['users'][$p->status][$p->userid] = array(
						'id' => $p->userid,
						'name' => ( ! empty($p->name)) ? $p->name : $p->email,
						'logs' => $this->logs->count_user_logs($p->userid),
						'news' => $this->news->count_user_news($p->userid),
						'posts' => $this->posts->count_user_posts($p->userid),
						'class' => ($last > $this->options['posting_requirement']) ? 'red bold' : '',
						'lastpost' => mdate($this->options['date_format'], $date),
					);
				}
			}
		}
		
		// get all the users
		$characters = $this->char->get_all_characters('all');
		
		if ($characters->num_rows() > 0)
		{
			foreach ($characters->result() as $c)
			{
				if ($c->crew_type != 'pending')
				{
					$last = now() - $c->last_post;
					$last = $last / 86400;
						
					$date = gmt_to_local($c->last_post, $this->timezone, $this->dst);
					
					$name = array(
						$this->ranks->get_rank($c->rank, 'rank_name'),
						$c->first_name,
						$c->middle_name,
						$c->last_name
					);
					
					$data['characters'][$c->crew_type][$c->charid] = array(
						'id' => $c->charid,
						'name' => parse_name($name),
						'logs' => $this->logs->count_character_logs($c->charid),
						'news' => $this->news->count_character_news($c->charid),
						'posts' => $this->posts->count_character_posts($c->charid),
						'class' => ($last > $this->options['posting_requirement']) ? 'red bold' : '',
						'lastpost' => mdate($this->options['date_format'], $date),
					);
				}
			}
		}
		
		$data['images'] = array(
			'loading' => array(
				'src' => Location::img('loading-circle-large.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['header'] = lang('head_report_posting');
		
		$data['label'] = array(
			'char_active' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'char_inactive' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'char_npc' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
			'lastpost' => ucwords(lang('order_last') .' '. lang('global_post')),
			'loading' => ucfirst(lang('actions_loading') .'...'),
			'logs' => ucwords(lang('global_personallogs')),
			'name' => ucfirst(lang('labels_name')),
			'news' => ucwords(lang('global_newsitems')),
			'no_characters' => ucfirst(lang('labels_no') .' '. lang('global_characters') .' '. lang('actions_found')),
			'no_users' => ucfirst(lang('labels_no') .' '. lang('global_users') .' '. lang('actions_found')),
			'users' => ucfirst(lang('global_users')),
			'users_active' => ucwords(lang('status_active') .' '. lang('global_users')),
			'users_inactive' => ucwords(lang('status_inactive') .' '. lang('global_users')),
			'posts' => ucwords(lang('global_missionposts')),
			'total' => ucfirst(lang('labels_totals')),
		);
		
		$js_data['lang'] = array(
			'search_active' => ucwords(lang('actions_search') .' '. lang('status_active') .' '. lang('global_characters')),
			'search_inactive' => ucwords(lang('actions_search') .' '. lang('status_inactive') .' '. lang('global_characters')),
			'search_npc' => ucwords(lang('actions_search') .' '. lang('abbr_npcs')),
			'search_users' => ucwords(lang('actions_search') .' '. lang('global_users')),
		);
		
		$this->_regions['content'] = Location::view('report_posting', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_posting_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function stats()
	{
		// grab the title
		$title = ucfirst(lang('labels_stats'));
		
		// load the resources
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		
		// set the times
		$today = getdate();
		
		// this month
		$this_month_mysql = $today['year'] .'-'. $today['mon'] .'-01 00:00:00';
		$this_month = human_to_unix($this_month_mysql, true);
		
		// last month
		$year = ($today['mon'] == 1) ? $today['year'] - 1 : $today['year'];
		$month = ($today['mon'] == 1) ? 12 : $today['mon'] - 1;
		$last_month_mysql = $year .'-'. $month .'-01 00:00:00';
		$last_month = human_to_unix($last_month_mysql, true);
		
		// next month
		$year = ($today['mon'] == 12) ? $today['year'] + 1 : $today['year'];
		$month = ($today['mon'] == 12) ? '01' : $today['mon'] + 1;
		$next_month_mysql = $year .'-'. $month .'-01 00:00:00';
		$next_month = human_to_unix($next_month_mysql, true);
		
		// days in the months
		$days = date('t');

		// run the methods
		$data['users'] = array(
			'current' => $this->user->count_users('current', $this_month, $last_month),
			'previous' => $this->user->count_users('previous', $this_month, $last_month)
		);
		
		$data['characters'] = array(
			'current' => $this->char->count_characters('active', 'current', $this_month, $last_month),
			'previous' => $this->char->count_characters('active', 'previous', $this_month, $last_month)
		);
		
		$data['npcs'] = array(
			'current' => $this->char->count_characters('npc', 'current', $this_month, $last_month),
			'previous' => $this->char->count_characters('npc', 'previous', $this_month, $last_month)
		);
		
		$data['posts'] = array(
			'current' => $this->posts->count_posts($this_month, $next_month, $this->options['post_count_format']),
			'previous' => $this->posts->count_posts($last_month, $this_month, $this->options['post_count_format'])
		);
		
		$data['logs'] = array(
			'current' => $this->logs->count_logs($this_month, $next_month),
			'previous' => $this->logs->count_logs($last_month, $this_month)
		);
		
		$data['post_totals'] = array(
			'current' => $data['posts']['current'] + $data['logs']['current'],
			'previous' => $data['posts']['previous'] + $data['logs']['previous'],
		);
		
		$data['avg_posts'] = array(
			'current' => ($data['posts']['current'] > 0) ? round($data['posts']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['posts']['previous'] > 0) ? round($data['posts']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['avg_logs'] = array(
			'current' => ($data['logs']['current'] > 0) ? round($data['logs']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['logs']['previous'] > 0) ? round($data['logs']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['avg_totals'] = array(
			'current' => ($data['post_totals']['current'] > 0) ? round($data['post_totals']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['post_totals']['previous'] > 0) ? round($data['post_totals']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['pace'] = array(
			'posts' => round((($data['posts']['current']) / ($today['mday'])) * $days, 2),
			'logs' => round((($data['logs']['current']) / ($today['mday'])) * $days, 2),
			'total' => round((($data['post_totals']['current']) / ($today['mday'])) * $days, 2)
		);
		
		// set the header
		$data['header'] = $title;
		
		$data['label'] = array(
			'avgentries' => lang('abbr_avg') .' '. ucwords(lang('labels_entries') .' / '. lang('global_user')),
			'avglogs' => lang('abbr_avg') .' '. ucwords(lang('global_personallogs') .' / '. lang('global_user')),
			'avgposts' => lang('abbr_avg') .' '. ucwords(lang('global_missionposts') .' / '. lang('global_user')),
			'lastmonth' => ucwords(lang('order_last') .' '. lang('time_month')),
			'logs' => ucwords(lang('global_personallogs')),
			'npcs' => lang('abbr_npcs'),
			'pacelogs' => ucwords(lang('global_personallogs') .' '. lang('labels_pace')),
			'paceposts' => ucwords(lang('global_missionposts') .' '. lang('labels_pace')),
			'pacetotal' => ucwords(lang('labels_totals') .' '. lang('labels_pace')),
			'users' => ucfirst(lang('global_users')),
			'playing_chars' => ucwords(lang('status_playing') .' '. lang('global_characters')),
			'posts' => ucwords(lang('global_missionposts')),
			'statsavg' => lang('text_stats_avg'),
			'statspace' => lang('text_stats_pace'),
			'thismonth' => ucwords(lang('labels_this') .' '. lang('time_month')),
			'totals' => ucwords(lang('labels_totals')),
		);
		
		$this->_regions['content'] = Location::view('report_stats', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_stats_js', $this->skin, 'admin');
		$this->_regions['title'].= $title;
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function versions()
	{
		$ver = $this->sys->get_item('system_info', 'sys_id', 1);
		
		$data['version'] = array(
			'files' => APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
			'ci' => CI_VERSION,
			'database' => $ver->sys_version_major .'.'. $ver->sys_version_minor .'.'. $ver->sys_version_update
		);
		
		$data['header'] = lang('head_report_system');
		
		$data['images'] = array(
			'loading' => array(
				'src' => Location::img('loading-circle-large.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'components' => ucwords(lang('labels_system') .' '. lang('labels_components')),
			'loading' => ucfirst(lang('actions_loading') .'...'),
			'systeminfo' => ucwords(lang('labels_system') .' '. lang('labels_info')),
			'url' => ucwords(lang('labels_site') .' '. lang('abbr_url')) .': ',
			'version_ci' => ucwords(lang('labels_codeigniter') .' '. lang('labels_version')) .': ',
			'version_db' => ucwords(lang('labels_database') .' '. lang('labels_version')) .': ',
			'version_files' => ucwords(lang('labels_files') .' '. lang('labels_version')) .': ',
			'versions' => ucwords(lang('labels_version') .' '. lang('labels_history')),
			'versions_redirect' => lang('versions_redirect'),
			'components_redirect' => lang('components_redirect'),
		);
		
		$this->_regions['content'] = Location::view('report_system', $this->skin, 'admin', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function viewapp($id = 0)
	{
		Auth::check_access('report/applications');
		
		// load the resources
		$this->load->model('applications_model', 'apps');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
	
		$application = $this->apps->get_application($id);
		
		if ($application->num_rows() > 0)
		{
			foreach ($application->result() as $a)
			{
				$date = gmt_to_local($a->app_date, $this->timezone, $this->dst);
				
				$data['app'] = array(
					'id' => $a->app_id,
					'email' => $a->app_email,
					'character' => $a->app_character_name,
					'user' => $a->app_user_name,
					'position' => $a->app_position,
					'action' => ucfirst($a->app_action),
					'date' => mdate($this->options['date_format'], $date),
					'message' => $a->app_message,
				);
			}
		}
		
		$data['header'] = lang('head_report_viewapplication');
		
		$data['label'] = array(
			'action' => ucwords(lang('actions_action') .' '. lang('actions_taken')),
			'cname' => ucwords(lang('global_character') .' '. lang('labels_name')),
			'date' => ucwords(lang('labels_application') .' '. lang('labels_date')),
			'email' => ucwords(lang('labels_email_address')),
			'message' => ucfirst(lang('labels_message')),
			'none' => ucfirst(lang('labels_no') .' '. lang('labels_applications') .' '. lang('actions_found')),
			'pname' => ucwords(lang('global_user') .' '. lang('labels_name')),
			'position' => ucfirst(lang('global_position')),
		);
		
		$this->_regions['content'] = Location::view('report_viewapp', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('report_viewapp_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
