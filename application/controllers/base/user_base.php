<?php
/*
|---------------------------------------------------------------
| ADMIN - USER CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/user_base.php
| System Version: 1.0
|
| Controller that handles the USER section of the admin system.
|
*/

class User_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function User_base()
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
			'system_email',
			'email_subject',
			'allowed_chars_playing',
			'allowed_chars_npc'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
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
		$this->template->write('nav_sub', $this->menu->build('adminsub', 'user'), TRUE);
		$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
		$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
		$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
	}

	function index()
	{
		/* nothing goes here */
	}
	
	function account()
	{
		$this->auth->check_access();
		
		$level = $this->auth->get_access_level();
		$id = $this->session->userdata('player_id');
		$id = ($level == 2) ? $this->uri->segment(3, $id, TRUE) : $id;
		
		if (isset($_POST['submit']))
		{
			/*
			 * level 1 can update everything but status and loa
			 * level 2 can update everything
			 */
			 
			if ($_POST['submit'] == 'Update')
			{
				$player = $this->uri->segment(3, 0, TRUE);
				
				if ($level == 1 && $player != $this->session->userdata('player_id'))
				{
					redirect('admin/error/7');
				}
				
				$update = 0;
				
				$update_all = $this->player->update_all_player_prefs($player);
				
				foreach ($_POST as $key => $value)
				{
					if (substr($key, 0, 2) == 'p_')
					{
						$update_array = array('prefvalue_value' => $value);
						
						$new_key = substr_replace($key, '', 0, 2);
						
						$update += $this->player->update_player_pref($player, $new_key, $update_array);
					}
					else
					{
						$array[$key] = $value;
						
						if ($key == 'password' || $key == 'security_answer')
						{
							if (!empty($value))
							{
								$array[$key] = sha1($value);
							}
							else
							{
								unset($array[$key]);
							}
						}
						
						if ($key == 'timezones')
						{
							$array['timezone'] = $value;
							unset($array['timezones']);
						}
					}
				}
				
				/* set the last update */
				$array['last_update'] = now();
				
				$old_loa = $array['loa_old'];
				$old_status = $array['status_old'];
				
				/* submit needs to be removed */
				unset($array['submit']);
				unset($array['loa_old']);
				unset($array['status_old']);
				
				if ($old_status != 'inactive' && $array['status'] == 'inactive')
				{
					$array['leave_date'] = now();
				}
				
				if ($old_status == 'inactive' && $array['status'] != 'inactive')
				{
					$array['leave_date'] = NULL;
				}
				
				if ($player == $this->session->userdata('player_id'))
				{
					$this->session->set_userdata('timezone', $array['timezone']);
					$this->session->set_userdata('dst', $array['daylight_savings']);
					$this->session->set_userdata('language', $array['language']);
				}
				
				$update += $this->player->update_player($player, $array);
				
				if ($update > 0)
				{
					if ($array['loa'] != $old_loa)
					{
						$loa = $this->player->get_last_loa($player, TRUE);
				
						if ($loa->num_rows() > 0)
						{
							$row = $loa->row();
							
							$loa_array = array('loa_end_date' => now());
							
							$this->player->update_loa_record($row->loa_id, $loa_array);
						}
						else
						{
							if ($array['loa'] != 'active')
							{
								$loa_array = array(
									'loa_player' => $player,
									'loa_start_date' => now(),
									'loa_type' => $array['loa'],
									'loa_duration' => '',
									'loa_reason' => ''
								);
								
								$this->player->create_loa_record($loa_array);
							}
						}
					}
					
					$message = sprintf(
						lang('flash_success'),
						ucfirst(lang('labels_account')),
						lang('actions_updated'),
						''
					);

					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
				else
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('labels_account')),
						lang('actions_updated'),
						''
					);

					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
		}
		
		/* load the resources */
		$this->load->helper('directory');
		$this->load->model('access_model', 'access');
		
		/* grab the player details */
		$details = $this->player->get_player($id);
		
		if ($details !== FALSE)
		{
			$data['inputs'] = array(
				'id' => $details->player_id,
				'timezone' => $details->timezone,
				'language' => $details->language,
				'loa' => $details->loa,
				'status' => $details->status,
				'question' => $details->security_question,
				'role' => $details->access_role,
				'name' => array(
					'name' => 'name',
					'id' => 'name',
					'value' => $details->name),
				'email' => array(
					'name' => 'email',
					'id' => 'email',
					'value' => $details->email),
				'password' => array(
					'name' => 'password',
					'id' => 'password'),
				'dob' => array(
					'name' => 'date_of_birth',
					'id' => 'date_of_birth',
					'value' => $details->date_of_birth),
				'im' => array(
					'name' => 'instant_message',
					'id' => 'instant_message',
					'value' => $details->instant_message,
					'rows' => 4),
				'location' => array(
					'name' => 'location',
					'id' => 'location',
					'value' => $details->location),
				'bio' => array(
					'name' => 'bio',
					'id' => 'bio',
					'value' => $details->bio,
					'rows' => 10),
				'interests' => array(
					'name' => 'interests',
					'id' => 'interests',
					'value' => $details->interests,
					'rows' => 5),
				'answer' => array(
					'name' => 'security_answer',
					'id' => 'security_answer'),
				'dst_y' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_y',
					'value' => 'TRUE',
					'checked' => ($details->daylight_savings == 'TRUE') ? TRUE : FALSE),
				'dst_n' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_n',
					'value' => 'FALSE',
					'checked' => ($details->daylight_savings == 'FALSE') ? TRUE : FALSE),
				'admin_y' => array(
					'name' => 'is_sysadmin',
					'id' => 'admin_y',
					'value' => 'y',
					'checked' => ($details->is_sysadmin == 'y') ? TRUE : FALSE),
				'admin_n' => array(
					'name' => 'is_sysadmin',
					'id' => 'admin_n',
					'value' => 'n',
					'checked' => ($details->is_sysadmin == 'n') ? TRUE : FALSE),
				'gm_y' => array(
					'name' => 'is_game_master',
					'id' => 'gm_y',
					'value' => 'y',
					'checked' => ($details->is_game_master == 'y') ? TRUE : FALSE),
				'gm_n' => array(
					'name' => 'is_game_master',
					'id' => 'gm_n',
					'value' => 'n',
					'checked' => ($details->is_game_master == 'n') ? TRUE : FALSE),
				'webmaster_y' => array(
					'name' => 'is_webmaster',
					'id' => 'webmaster_y',
					'value' => 'y',
					'checked' => ($details->is_webmaster == 'y') ? TRUE : FALSE),
				'webmaster_n' => array(
					'name' => 'is_webmaster',
					'id' => 'webmaster_n',
					'value' => 'n',
					'checked' => ($details->is_webmaster == 'n') ? TRUE : FALSE),
				'mod_posts_y' => array(
					'name' => 'moderate_posts',
					'id' => 'mod_posts_y',
					'value' => 'y',
					'checked' => ($details->moderate_posts == 'y') ? TRUE : FALSE),
				'mod_posts_n' => array(
					'name' => 'moderate_posts',
					'id' => 'mod_posts_n',
					'value' => 'n',
					'checked' => ($details->moderate_posts == 'n') ? TRUE : FALSE),
				'mod_logs_y' => array(
					'name' => 'moderate_logs',
					'id' => 'mod_logs_y',
					'value' => 'y',
					'checked' => ($details->moderate_logs == 'y') ? TRUE : FALSE),
				'mod_logs_n' => array(
					'name' => 'moderate_logs',
					'id' => 'mod_logs_n',
					'value' => 'n',
					'checked' => ($details->moderate_logs == 'n') ? TRUE : FALSE),
				'mod_news_y' => array(
					'name' => 'moderate_news',
					'id' => 'mod_news_y',
					'value' => 'y',
					'checked' => ($details->moderate_news == 'y') ? TRUE : FALSE),
				'mod_news_n' => array(
					'name' => 'moderate_news',
					'id' => 'mod_news_n',
					'value' => 'n',
					'checked' => ($details->moderate_news == 'n') ? TRUE : FALSE),
				'mod_pcomment_y' => array(
					'name' => 'moderate_post_comments',
					'id' => 'mod_pcomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_post_comments == 'y') ? TRUE : FALSE),
				'mod_pcomment_n' => array(
					'name' => 'moderate_post_comments',
					'id' => 'mod_pcomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_post_comments == 'n') ? TRUE : FALSE),
				'mod_lcomment_y' => array(
					'name' => 'moderate_log_comments',
					'id' => 'mod_lcomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_log_comments == 'y') ? TRUE : FALSE),
				'mod_lcomment_n' => array(
					'name' => 'moderate_log_comments',
					'id' => 'mod_lcomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_log_comments == 'n') ? TRUE : FALSE),
				'mod_ncomment_y' => array(
					'name' => 'moderate_news_comments',
					'id' => 'mod_ncomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_news_comments == 'y') ? TRUE : FALSE),
				'mod_ncomment_n' => array(
					'name' => 'moderate_news_comments',
					'id' => 'mod_ncomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_news_comments == 'n') ? TRUE : FALSE),
			);
		}
		
		$prefs = $this->sys->get_preferences();
		
		if ($prefs->num_rows() > 0)
		{
			foreach ($prefs->result() as $p)
			{
				$data['prefs'][$p->pref_id] = array(
					'input' => array(
						'name' => 'p_'. $p->pref_key,
						'id' => 'p_'. $p->pref_key,
						'value' => 'y',
						'checked' => ($this->player->get_pref($p->pref_key, $id) == 'y') ? TRUE : FALSE),
					'label' => $p->pref_label
				);
			}
		}
		
		/* grab the directory map of the language folder */
		$dir = directory_map(APPFOLDER .'/language', TRUE);
		
		/* loop through the directory map and create the dropdown array */
		foreach ($dir as $key => $value)
		{
			if ($value != 'index.html')
			{
				$data['values']['language'][$value] = ucwords($value);
			}
		}
		
		$roles = $this->access->get_roles();
		
		if ($roles->num_rows() > 0)
		{
			foreach ($roles->result() as $r)
			{
				$data['values']['roles'][$r->role_id] = $r->role_name;
			}
		}
		
		$data['values']['loa'] = array(
			'active' => ucfirst(lang('status_active')),
			'loa' => ucwords(lang('status_loa')),
			'eloa' => ucwords(lang('status_eloa')),
		);
		
		$data['values']['status'] = array(
			'active' => ucfirst(lang('status_active')),
			'inactive' => ucwords(lang('status_inactive')),
			'pending' => ucwords(lang('status_pending')),
		);
		
		/* get the questions from the database */
		$questions = $this->sys->get_security_questions();
		
		/* build the array with the questions */
		if ($questions->num_rows() > 0)
		{
			foreach ($questions->result() as $q)
			{
				$data['values']['questions'][$q->question_id] = $q->question_value;
			}
		}
		
		$data['header'] = ucwords(lang('labels_user') .' '. lang('labels_account'));
		
		$data['level'] = $level;
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_update'))),
		);
		
		$data['images'] = array(
			'user' => array(
				'src' => img_location('user.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image img_inline_left'),
			'display' => array(
				'src' => img_location('display.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image img_inline_left'),
		);
		
		$data['label'] = array(
			'admin' => ucfirst(lang('labels_admin')),
			'basicinfo' => ucwords(lang('labels_basic') .' '. lang('labels_info')),
			'bio' => ucfirst(lang('labels_biography')),
			'characters' => ucwords(lang('actions_manage') .' '. lang('labels_account') 
				.' '. lang('global_characters') .' '. RARROW),
			'display' => ucwords(lang('actions_change') .' '. lang('labels_display')
				.' '. lang('labels_preferences') .' '. RARROW),
			'dob' => lang('labels_dob'),
			'dst' => ucwords(lang('labels_dst')),
			'email' => ucwords(lang('labels_email_address')),
			'gm' => ucwords(lang('global_game_master')),
			'im' => ucwords(lang('labels_im')),
			'im_inst' => lang('text_im_instructions'),
			'interests' => ucfirst(lang('labels_interests')),
			'language' => ucfirst(lang('labels_language')),
			'location' => ucfirst(lang('labels_location')),
			'mod_c_logs' => ucwords(lang('global_log') .' '. lang('labels_comments')),
			'mod_c_news' => ucwords(lang('global_news') .' '. lang('labels_comments')),
			'mod_c_posts' => ucwords(lang('global_post') .' '. lang('labels_comments')),
			'mod_logs' => ucwords(lang('global_personallogs')),
			'mod_news' => ucwords(lang('global_newsitems')),
			'mod_posts' => ucwords(lang('global_missionposts')),
			'moderate' => ucfirst(lang('actions_moderate')),
			'mybio' => ucwords(lang('labels_my') .' '. lang('labels_bio')),
			'myprefs' => ucwords(lang('labels_my') .' '. lang('labels_preferences')),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'password' => ucfirst(lang('labels_password')),
			'playersettings' => ucwords(lang('global_player') .' '. lang('labels_settings')),
			'role' => ucwords(lang('labels_access') .' '. lang('labels_role')),
			'secanswer' => ucwords(lang('labels_security') .' '. lang('labels_answer')),
			'secquestion' => ucwords(lang('labels_security') .' '. lang('labels_question')),
			'sectext' => lang('text_security_question'),
			'status' => ucfirst(lang('labels_status')),
			'sysadmin' => ucwords(lang('global_sysadmin')),
			'text_credentials_1' => lang('text_user_credential_confirm_1'),
			'text_credentials_2' => lang('text_user_credential_confirm_2'),
			'datetime' => ucwords(lang('time_dates') .' '. AMP .' '. lang('labels_times')),
			'timezone' => ucfirst(lang('labels_timezone')),
			'type' => ucwords(lang('global_player') .' '. lang('labels_type')),
			'webmaster' => ucfirst(lang('global_webmaster')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('user_account', $this->skin, 'admin');
		$js_loc = js_location('user_account_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function all()
	{
		$this->auth->check_access('user/account');
		
		$level = $this->auth->get_access_level('user/account');
		
		if ($level < 2)
		{
			redirect('admin/error/1');
		}
		
		if (isset($_POST['submit']))
		{
			$action = $this->uri->segment(3);
			
			switch ($action)
			{
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->player->delete_player($id);
					
					if ($delete > 0)
					{
						$chars = $this->char->get_player_characters($id, '', 'array');
						
						if (count($chars) > 0)
						{
							$update_array = array('player' => NULL);
							
							foreach ($chars as $c)
							{
								$update = $this->char->update_character($c, $update_array);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_player')),
							lang('actions_deleted'),
							''
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_player')),
							lang('actions_deleted'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$players = $this->player->get_players('');
		
		if ($players->num_rows() > 0)
		{
			foreach ($players->result() as $p)
			{
				$data['players'][$p->status][$p->player_id] = array(
					'id' => $p->player_id,
					'main_char' => $this->char->get_character_name($p->main_char, TRUE),
					'email' => $p->email,
					'name' => $p->name,
					'left' => (!empty($p->leave_date)) ? timespan($p->leave_date, now()) : '',
				);
			}
		}
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('labels_users'));
		
		$data['images'] = array(
			'loading' => array(
				'src' => img_location('loading-circle-large.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
			'view' => array(
				'src' => img_location('user-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view')),
				'class' => 'image'),
			'delete' => array(
				'src' => img_location('user-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'edit' => array(
				'src' => img_location('user-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'active' => ucwords(lang('status_active') .' '. lang('global_players')),
			'ago' => lang('time_ago'),
			'character' => ucwords(lang('labels_main') .' '. lang('global_character')),
			'inactive' => ucwords(lang('status_inactive') .' '. lang('global_players')),
			'left' => ucfirst(lang('labels_left')),
			'name' => ucfirst(lang('labels_name')),
			'pending' => ucwords(lang('status_pending') .' '. lang('global_players')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('user_all', $this->skin, 'admin');
		$js_loc = js_location('user_all_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function characterlink()
	{
		$this->auth->check_access('user/account');
		
		$level = $this->auth->get_access_level('user/account');
		
		if ($level == 2)
		{
			$player = $this->uri->segment(3, 0, TRUE);
			$data['player'] = $player;
			
			switch ($this->uri->segment(4))
			{
				case 'add':
					$id = $this->uri->segment(5, 0, TRUE);
					
					/* get all the characters and make sure it isn't blank */
					$chars_raw = $this->char->get_player_characters($player, '', 'array');
					$chars = ($chars_raw !== FALSE) ? $chars_raw : array();
					
					$type = array(
						'active' => 0,
						'npc' => 0
					);
					
					foreach ($chars as $c)
					{
						if ($this->char->get_character($c, 'crew_type') == 'npc')
						{
							++$type['npc'];
						}
						elseif ($this->char->get_character($c, 'crew_type') == 'active')
						{
							++$type['active'];
						}
					}
					
					$key = array_search($id, $chars);
					
					if ($key === FALSE)
					{
						/* set up the data array with the player info */
						$data_array = array('data_player' => $data['player']);
						
						/* update all the character data to point to the player */
						$update_data = $this->char->update_character_data_all($id, 'data_char', $data_array);
					
						$c_type = $this->char->get_character($id, 'crew_type');
						
						if (($c_type == 'npc' && $type['npc'] >= $this->options['allowed_chars_npc']) ||
							($c_type == 'active' && $type['active'] >= $this->options['allowed_chars_playing']))
						{
							$msg = sprintf(
								lang('flash_additional_char_quota'),
								($c_type == 'npc') ? strtoupper($c_type) : $c_type,
								lang('global_characters')
							);
							
							$message = sprintf(
								lang('flash_additional_char_quota'),
								($c_type == 'npc') ? strtoupper($c_type) : $c_type,
								lang('global_characters')
							);
							
							$player_update = 0;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
							
							/* set the deactivate date and player ID */
							$char_activate = array(
								'date_activate' => now(),
								'player' => $player,
							);
							
							/* run the update */
							$char_update = $this->char->update_character($id, $char_activate);
							
							/* push the item we're adding onto the array */
							$chars[] = $id;
							
							/* put the characters into a string */
							$chars_string = implode(',', $chars);
							
							/* create an array for updating the player record */
							$update_array = array('last_update' => now());
							
							/* get the player's main character */
							$main = $this->player->get_player($player, 'main_char');
							
							if ($chars_raw === FALSE || empty($main))
							{ /* if they don't have any characters or don't have a main character */
								$update_array['main_char'] = $id;
							}
							
							/* run the update */
							$player_update = $this->player->update_player($player, $update_array);
						}
						
						if ($player_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					}
					
					break;
					
				case 'remove':
					$id = $this->uri->segment(5, 0, TRUE);
					
					/* get an array of the player's characters */
					$chars = $this->char->get_player_characters($player, 'active_npc', 'array');
					
					/* new main is NULL until something overwrites it in the event the main char is removed */
					$newmain = NULL;
					
					if (count($chars) > 0)
					{
						foreach ($chars as $c)
						{
							if ($c != $id)
							{
								$ctemp = $this->char->get_character($c, 'crew_type');
								
								if ($ctemp == 'active' && is_null($newmain))
								{
									$newmain = $c;
								}
							}
						}
					}
					
					/* search the array */
					$key = array_search($id, $chars);
					
					if ($key !== FALSE)
					{
						/* set up the data array with the player info */
						$data_array = array('data_player' => NULL);
						
						/* update all the character data to point to the player */
						$update_data = $this->char->update_character_data_all($id, 'data_char', $data_array);
					
						$main = $this->player->get_player($data['player'], 'main_char');
						
						/* set the deactivate date and player ID */
						$char_deactivate = array(
							'date_deactivate' => now(),
							'player' => NULL,
						);
						
						/* run the update */
						$char_update = $this->char->update_character($id, $char_deactivate);
						
						/* unset the item we're removing */
						unset($chars[$key]);
						
						/* put the characters into a string */
						$chars_string = implode(',', $chars);
						
						/* create an array for updating the player record */
						$update_array = array(
							'last_update' => now(),
							'main_char' => ($main == $id) ? $newmain : $main
						);
						
						/* run the update */
						$player_update = $this->player->update_player($player, $update_array);
						
						if ($player_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
		
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					}
					
					break;
					
				case 'set':
					$id = $this->uri->segment(5, 0, TRUE);
					
					/* grab the current main character */
					$char = $this->player->get_player($player, 'main_char');
					
					if ($char != $id)
					{
						/* create an array for updating the player record */
						$update_array = array(
							'main_char' => $id,
							'last_update' => now()
						);
						
						/* run the update */
						$player_update = $this->player->update_player($player, $update_array);
						
						if ($player_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_player') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
		
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					}
					
					break;
			}
			
			if ($player == 0)
			{
				$all = $this->player->get_players();
				
				if ($all->num_rows() > 0)
				{
					foreach ($all->result() as $a)
					{
						$data['all'][$a->player_id] = (!empty($a->name)) ? $a->name : $a->email;
					}
				}
			}
			else
			{
				/* load the resources */
				$this->load->model('positions_model', 'pos');
				
				$all = $this->char->get_player_characters($player, '', 'array');
				
				/* get the player's current characters */
				$chars = ($all !== FALSE) ? $all : array();
				
				/* get all characters that don't have a player assigned to them */
				$unassigned = $this->char->get_all_characters('no_player');
				
				$playerinfo = $this->player->get_player($player);
				
				$data['p_name'] = $playerinfo->name;
				$data['p_email'] = $playerinfo->email;
				
				$data['count_active'] = 0;
				$data['count_npc'] = 0;
				
				if (count($chars) > 0)
				{
					foreach ($chars as $c)
					{
						$d = $this->char->get_character($c, array('crew_type', 'position_1'));
						
						$data['chars'][$c] = array(
							'name' => $this->char->get_character_name($c, TRUE),
							'position' => $this->pos->get_position($d['position_1'], 'pos_name'),
							'type' => ($d['crew_type'] == 'npc') ? strtoupper($d['crew_type']) : ucfirst($d['crew_type']),
							'main' => ($this->player->get_main_character($player) != $c) ? FALSE : TRUE,
						);
						
						if ($d['crew_type'] == 'npc')
						{
							++$data['count_npc'];
						}
						elseif ($d['crew_type'] == 'active')
						{
							++$data['count_active'];
						}
					}
				}
				else
				{
					$data['chars'] = array();
				}
				
				if ($unassigned->num_rows() > 0)
				{
					foreach ($unassigned->result() as $u)
					{
						$data['unassigned'][$u->crew_type][$u->charid] = array(
							'name' => $this->char->get_character_name($u->charid, TRUE),
							'position' => $this->pos->get_position($u->position_1, 'pos_name')
						);
					}
				}
			}
			
			$data['header'] = ucwords(lang('labels_link') .' '. lang('global_characters')) .' '. 
				lang('labels_to') .' '. ucfirst(lang('labels_account'));
			$data['text'] = sprintf(
				lang('text_link_characters'),
				lang('global_player'),
				lang('global_characters'),
				lang('global_characters'),
				lang('global_player'),
				lang('global_character'),
				lang('global_character'),
				lang('global_player'),
				lang('global_character'),
				lang('global_player')
			);
			
			$data['buttons'] = array(
				'update' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_update'))),
			);
			
			$data['images'] = array(
				'remove' => array(
					'src' => img_location('user-delete.png', $this->skin, 'admin'),
					'alt' => lang('actions_remove'),
					'class' => 'image'),
				'star' => array(
					'src' => img_location('icon-star.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'add' => array(
					'src' => img_location('user-add.png', $this->skin, 'admin'),
					'alt' => lang('actions_add'),
					'class' => 'image'),
				'main' => array(
					'src' => img_location('icon-green-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'npc' => array(
					'src' => img_location('icon-gray-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'active' => array(
					'src' => img_location('icon-blue-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'inactive' => array(
					'src' => img_location('icon-black-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
			);
			
			$data['label'] = array(
				'add' => ucwords(lang('actions_add') .' '. lang('global_character')),
				'allchars' => LARROW .' '. ucwords(lang('labels_all') .' '. lang('global_players')),
				'chars_nonplaying' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
				'chars_playing' => ucwords(lang('status_playing') .' '. lang('global_characters')),
				'current' => ucwords(lang('status_current') .' '. lang('global_characters')),
				'email' => ucwords(lang('labels_email_address')),
				'name' => ucfirst(lang('labels_name')),
				'nocharacters' => ucfirst(lang('labels_no') .' '. lang('global_characters') .' '. lang('actions_found')),
				'player' => ucwords(lang('global_player') .' '. lang('labels_info')),
				'select' => ucfirst(lang('labels_please') .' '. lang('actions_select') .' '. 
					lang('labels_a') .' '. lang('global_player')),
				'remove' => ucfirst(lang('actions_remove')),
			);
			
			/* figure out where the view files should be coming from */
			$view_loc = view_location('user_characterlink', $this->skin, 'admin');
			$js_loc = js_location('user_characterlink_js', $this->skin, 'admin');
			
			/* write the data to the template */
			$this->template->write('title', $data['header']);
			$this->template->write_view('content', $view_loc, $data);
			$this->template->write_view('javascript', $js_loc);
			
			/* render the template */
			$this->template->render();
		}
		else
		{
			redirect('admin/error/1');
		}
	}
	
	function nominate()
	{
		$this->auth->check_access();
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'queue':
					if ($this->auth->get_access_level() > 1)
					{
						$action = $this->input->post('action', TRUE);
						
						$id = $this->input->post('id', TRUE);
						$id = (is_numeric($id)) ? $id : FALSE;
						
						switch ($action)
						{
							case 'approve':
								$award_update = array('queue_status' => 'accepted');
								
								$update = $this->awards->update_queue_record($id, $award_update);
								
								$nom = $this->sys->get_item('awards_queue', 'queue_id', $id);
								
								$received = array(
									'awardrec_player' => $nom->queue_receive_player,
									'awardrec_character' => $nom->queue_receive_character,
									'awardrec_award' => $nom->queue_award,
									'awardrec_date' => now(),
									'awardrec_reason' => $nom->queue_reason,
									'awardrec_nominated_by' => $nom->queue_nominate
								);
								
								$insert = $this->awards->add_nominated_award($received);
								
								if ($update > 0 && $insert > 0)
								{
									$message = sprintf(
										lang('flash_success'),
										ucfirst(lang('global_award') .' '. lang('labels_nomination')),
										lang('actions_approved'),
										''
									);
				
									$flash['status'] = 'success';
									$flash['message'] = text_output($message);
								}
								else
								{
									$message = sprintf(
										lang('flash_failure'),
										ucfirst(lang('global_award') .' '. lang('labels_nomination')),
										lang('actions_approved'),
										''
									);
				
									$flash['status'] = 'error';
									$flash['message'] = text_output($message);
								}
								
								/* write everything to the template */
								$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
								
								break;
								
							case 'reject':
								$award_update = array('queue_status' => 'rejected');
								
								$update = $this->awards->update_queue_record($id, $award_update);
								
								if ($update > 0)
								{
									$message = sprintf(
										lang('flash_success'),
										ucfirst(lang('global_award') .' '. lang('labels_nomination')),
										lang('actions_rejected'),
										''
									);
				
									$flash['status'] = 'success';
									$flash['message'] = text_output($message);
								}
								else
								{
									$message = sprintf(
										lang('flash_failure'),
										ucfirst(lang('global_award') .' '. lang('labels_nomination')),
										lang('actions_rejected'),
										''
									);
				
									$flash['status'] = 'error';
									$flash['message'] = text_output($message);
								}
								
								/* write everything to the template */
								$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
								
								break;
						}
					}
					
					break;
					
				default:
					$character = $this->input->post('character', TRUE);
					$awardid = $this->input->post('award', TRUE);
					
					$award = $this->awards->get_award($awardid);
					
					$insert_array = array(
						'queue_receive_character' => ($award->award_cat == 'ooc') ? 0 : $character,
						'queue_receive_player' => $this->char->get_character($character, 'player'),
						'queue_nominate' => $this->session->userdata('main_char'),
						'queue_award' => $awardid,
						'queue_reason' => $this->input->post('reason', TRUE),
						'queue_status' => 'pending',
						'queue_date' => now()
					);
					
					$insert = $this->awards->add_award_nomination($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_award') .' '. lang('labels_nomination')),
							lang('actions_submitted'),
							''
						);
		
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						$email_data = array(
							'receive' => ($award->award_cat == 'ooc') ? $insert_array['queue_receive_player'] : $character,
							'cat' => $award->award_cat,
							'reason' => $insert_array['queue_reason'],
							'award' => $insert_array['queue_award'],
							'nominate' => $insert_array['queue_nominate']
						);
						
						$email = ($this->options['system_email'] == 'on') ? $this->_email('nominate', $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_award') .' '. lang('labels_nomination')),
							lang('actions_submitted'),
							''
						);
		
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
			}
		}
		
		/* grab all the awards */
		$awards = $this->awards->get_all_awards();
		
		if ($awards->num_rows() > 0)
		{
			$data['awards'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose') 
				.' '. lang('order_one'));
				
			foreach ($awards->result() as $a)
			{
				$data['awards'][$a->award_id] = $a->award_name;
			}
		}
		
		if ($this->auth->get_access_level() > 1)
		{
			$noms = $this->awards->get_award_noms();
			
			if ($noms->num_rows() > 0)
			{
				$datestring = $this->options['date_format'];
				
				foreach ($noms->result() as $n)
				{
					$nid = $n->queue_id;
					$date = gmt_to_local($n->queue_date, $this->timezone, $this->dst);
					
					$data['nominations'][$nid] = array(
						'awardee' => $this->char->get_character_name($n->queue_receive_character, TRUE),
						'nominator' => $this->char->get_character_name($n->queue_nominate, TRUE),
						'award' => $this->awards->get_award($n->queue_award, 'award_name'),
						'reason' => $n->queue_reason,
						'date' => mdate($datestring, $date),
						'id' => $n->queue_id
					);
				}
			}
		}
		
		$data['header'] = ucwords(lang('labels_crew') .' '. lang('global_award') .' '. lang('labels_nominations'));
		$data['text'] = sprintf(
			lang('text_award_nomination'),
			lang('global_award'),
			lang('global_character')
		);
		
		$data['inputs'] = array(
			'reason' => array(
				'name' => 'reason',
				'id' => 'reason',
				'rows' => 6),
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		$data['images'] = array(
			'loading' => array(
				'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_loading') .'...')),
			'reject' => array(
				'src' => img_location('award-reject.png', $this->skin, 'admin'),
				'alt' => lang('actions_reject'),
				'title' => ucfirst(lang('actions_reject')),
				'class' => 'image'),
			'accept' => array(
				'src' => img_location('award-approve.png', $this->skin, 'admin'),
				'alt' => lang('actions_approve'),
				'title' => ucfirst(lang('actions_approve')),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'award' => ucfirst(lang('global_award')),
			'awardee' => ucfirst(lang('global_character')),
			'by' => lang('labels_by'),
			'character' => ucfirst(lang('global_character')),
			'choose' => ucfirst(lang('labels_please') .' '. lang('actions_choose')
				.' '. lang('labels_an') .' '. lang('global_award')),
			'nominate' => ucfirst(lang('actions_nominate')),
			'nominatequeue' => ucwords(lang('labels_nomination') .' '. lang('labels_queue')),
			'nonominations' => lang('error_no_award_nominations'),
			'on' => lang('labels_on'),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		$js_data['tab'] = ($this->uri->segment(3) == 'queue') ? 1 : 0;
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('user_nominate', $this->skin, 'admin');
		$js_loc = js_location('user_nominate_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function options()
	{
		$this->auth->check_access('user/account');
		
		/* set the user id */
		$id = $this->session->userdata('player_id');
		
		/* set the tab */
		$js_data['tab'] = 0;
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'links':
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 5) == 'link_')
						{
							$newkey = substr_replace($key, '', 0, 5);
							$link[$newkey] = $value;
							
							$menus = $this->menu_model->get_menu_item($value);
			
							if ($menus->num_rows() > 0)
							{
								$item = $menus->row();
								
								$session_array[] = anchor($item->menu_link, $item->menu_name);
							}
						}
					}
					
					$update_array = array(
						'my_links' => implode(',', $link),
						'last_update' => now()
					);
					
					$update = $this->player->update_player($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_player') .' '. lang('labels_menu')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* change the user's session with the new rank info */
						$this->session->set_userdata('my_links', $session_array);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_player') .' '. lang('labels_menu')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					$js_data['tab'] = 0;
					
					break;
					
				case 'ranks':
					$rank = $this->input->post('rank', TRUE);
					
					$update_array = array(
						'display_rank' => $rank,
						'last_update' => now()
					);
					
					$update = $this->player->update_player($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_player') .' '. lang('global_rank')
								.' '. lang('labels_preference')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* change the user's session with the new rank info */
						$this->session->set_userdata('display_rank', $rank);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_player') .' '. lang('global_rank')
								.' '. lang('labels_preference')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					$js_data['tab'] = 2;
					
					break;
					
				case 'skins':
					$skin_admin = $this->input->post('skin_admin', TRUE);
					$skin_main = $this->input->post('skin_main', TRUE);
					$skin_wiki = $this->input->post('skin_wiki', TRUE);
					
					$update_array = array(
						'skin_admin' => $skin_admin,
						'skin_main' => $skin_main,
						'skin_wiki' => $skin_wiki,
						'last_update' => now()
					);
					
					$update = $this->player->update_player($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_player') .' '. lang('labels_skin')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* change the user's session with the new info */
						if ($skin_admin != $this->session->userdata('skin_admin'))
						{
							$this->session->set_userdata('skin_admin', $skin_admin);
						}
						
						if ($skin_main != $this->session->userdata('skin_main'))
						{
							$this->session->set_userdata('skin_main', $skin_main);
						}
						
						if ($skin_wiki != $this->session->userdata('skin_wiki'))
						{
							$this->session->set_userdata('skin_wiki', $skin_wiki);
						}
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_player') .' '. lang('labels_skin')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					$js_data['tab'] = 1;
					
					break;
			}
		}
		
		/* load the resources */
		$this->load->model('ranks_model', 'ranks');
		
		/* grab the player details */
		$player = $this->player->get_player($id);
		
		/*
		|---------------------------------------------------------------
		| LINKS
		|---------------------------------------------------------------
		*/
		$menusecs = $this->menu_model->get_menu_categories();
		
		if ($menusecs->num_rows() > 0)
		{
			foreach ($menusecs->result() as $sec)
			{
				$menuitems = $this->menu_model->get_menu_items('', $sec->menucat_menu_cat);
				
				if ($menuitems->num_rows() > 0)
				{
					$data['links'][0] = ucfirst(lang('labels_please') .' '. lang('actions_choose')
						.' '. lang('order_one'));
						
					foreach ($menuitems->result() as $item)
					{
						$menucat = $sec->menucat_menu_cat;
						$cat = ($menucat == 'acp') ? strtoupper($menucat) : ucfirst($menucat);
						
						if ($item->menu_type != 'main')
						{
							if (
								(
									$item->menu_use_access == 'y' && 
									array_key_exists($item->menu_access, $this->session->userdata('access'))
								) || 
									$item->menu_use_access == 'n'
								)
							{
								$data['links'][$cat][$item->menu_id] = $item->menu_name;
							}
						}
					}
				}
			}
		}
		
		$links = explode(',', $player->my_links);
		$data['defaults']['links'] = array(
			1 => (isset($links[0])) ? $links[0] : 0,
			2 => (isset($links[1])) ? $links[1] : 0,
			3 => (isset($links[2])) ? $links[2] : 0,
			4 => (isset($links[3])) ? $links[3] : 0,
			5 => (isset($links[4])) ? $links[4] : 0,
		);
		
		/*
		|---------------------------------------------------------------
		| SKINS
		|---------------------------------------------------------------
		*/
		$s_access = $this->auth->check_access('site/catalogueskins', FALSE);
		$skin_access = ($s_access === TRUE) ? array('active', 'development') : 'active';
		
		$skins = $this->sys->get_all_skins();
		$data['defaults']['main'] = $player->skin_main;
		$data['defaults']['admin'] = $player->skin_admin;
		$data['defaults']['wiki'] = $player->skin_wiki;
		
		if ($skins->num_rows() > 0)
		{
			foreach ($skins->result() as $skin)
			{
				$sections = $this->sys->get_skin_sections($skin->skin_location, $skin_access);
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $section)
					{
						$data['themes'][$section->skinsec_section][$skin->skin_location] = $skin->skin_name;
					}
				}
			}
		}
		
		$where = array(
			'main' => array(
				'skinsec_section' => 'main',
				'skinsec_skin' => $this->session->userdata('skin_main')),
			'admin' => array(
				'skinsec_section' => 'admin',
				'skinsec_skin' => $this->session->userdata('skin_admin')),
			'wiki' => array(
				'skinsec_section' => 'wiki',
				'skinsec_skin' => $this->session->userdata('skin_wiki')),
		);
		
		/* grab the position details */
		$item_m = $this->sys->get_skinsec($where['main']);
		$item_a = $this->sys->get_skinsec($where['admin']);
		$item_w = $this->sys->get_skinsec($where['wiki']);
		
		$data['skin_main'] = ($item_m !== FALSE) ? array('src' => base_url() . APPFOLDER .'/views/'. $this->session->userdata('skin_main') .'/'. $item_m->skinsec_image_preview) : '';
		$data['skin_admin'] = ($item_a !== FALSE) ? array('src' => base_url() . APPFOLDER .'/views/'. $this->session->userdata('skin_admin') .'/'. $item_a->skinsec_image_preview) : '';
		$data['skin_wiki'] = ($item_w !== FALSE) ? array('src' => base_url() . APPFOLDER .'/views/'. $this->session->userdata('skin_wiki') .'/'. $item_w->skinsec_image_preview) : '';
		
		/*
		|---------------------------------------------------------------
		| RANKS
		|---------------------------------------------------------------
		*/
		$r_access = $this->auth->check_access('site/catalogueranks', FALSE);
		$rank_access = ($r_access === TRUE) ? array('active', 'development') : 'active';
		
		$ranks = $this->ranks->get_all_rank_sets($rank_access);
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $r)
			{
				$data['ranks'][] = array(
					'id' => $r->rankcat_id,
					'name' => $r->rankcat_name,
					'preview' => array(
						'src' => rank_location($r->rankcat_location, 'preview', $r->rankcat_extension),
						'alt' => ''),
					'input' => array(
						'name' => 'rank',
						'id' => 'rank_'. $r->rankcat_id,
						'value' => $r->rankcat_location,
						'checked' => ($this->session->userdata('display_rank') == $r->rankcat_location) ? TRUE : FALSE),
				);
			}
		}
		
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_options'));
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_update'))),
		);
		
		$data['images'] = array(
			'loading' => array(
				'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_loading'))),
		);
		
		$data['label'] = array(
			'mylink_1' => ucwords(lang('labels_my') .' '. lang('labels_link') .' #1'),
			'mylink_2' => ucwords(lang('labels_my') .' '. lang('labels_link') .' #2'),
			'mylink_3' => ucwords(lang('labels_my') .' '. lang('labels_link') .' #3'),
			'mylink_4' => ucwords(lang('labels_my') .' '. lang('labels_link') .' #4'),
			'mylink_5' => ucwords(lang('labels_my') .' '. lang('labels_link') .' #5'),
			'mylinks' => ucwords(lang('labels_my') .' '. lang('labels_links')),
			'myranks' => ucwords(lang('labels_my') .' '. lang('global_ranks')),
			'myskins' => ucwords(lang('labels_my') .' '. lang('labels_skins')),
			'skin_admin' => ucwords(lang('labels_admin') .' '. lang('labels_site')),
			'skin_main' => ucwords(lang('labels_main') .' '. lang('labels_site')),
			'skin_wiki' => ucfirst(lang('labels_wiki')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('user_options', $this->skin, 'admin');
		$js_loc = js_location('user_options_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function status()
	{
		$this->auth->check_access('user/account');
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			$status = strtolower($this->input->post('status', TRUE));
			
			$update_data = array('loa' => $status);
			
			$update = $this->player->update_player($this->session->userdata('player_id'), $update_data);
			
			if ($update > 0)
			{
				$loa = $this->player->get_last_loa($this->session->userdata('player_id'), TRUE);
				
				if ($loa->num_rows() > 0)
				{
					$row = $loa->row();
					
					$loa_array = array('loa_end_date' => now());
					
					$this->player->update_loa_record($row->loa_id, $loa_array);
				}
				else
				{
					if ($status != 'active')
					{
						$loa_array = array(
							'loa_player' => $this->session->userdata('player_id'),
							'loa_start_date' => now(),
							'loa_type' => $status,
							'loa_duration' => $this->input->post('duration', TRUE),
							'loa_reason' => $this->input->post('reason', TRUE)
						);
						
						$this->player->create_loa_record($loa_array);
					}
				}
				
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('labels_notification')),
					lang('actions_submitted'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
					
				$email_data = array(
					'requestor' => $this->session->userdata('mainchar'),
					'reason' => $this->input->post('reason', TRUE),
					'duration' => $this->input->post('duration', TRUE),
					'status' => $this->input->post('status', TRUE)
				);
				
				$email = ($this->options['system_email'] == 'on') ? $this->_email('status', $email_data) : FALSE;
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('labels_notification')),
					lang('actions_submitted'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		$data['header'] = ucwords(lang('actions_request') .' '. lang('abbr_loa'));
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		/* grab the loa status of the player */
		$loa = $this->player->get_loa($this->session->userdata('player_id'));
		
		$data['inputs'] = array(
			'reason' => array(
				'name' => 'reason',
				'id' => 'reason',
				'rows' => 6),
			'duration' => array(
				'name' => 'duration',
				'id' => 'duration',
				'rows' => 2),
			'loa' => ($loa != 'active') ? strtoupper($loa) : $loa
		);
		
		$data['values']['loa'] = array(
			'active' => ucfirst(lang('status_active')),
			'LOA' => ucfirst(lang('status_loa')),
			'ELOA' => ucfirst(lang('status_eloa')),
		);
		
		$data['label'] = array(
			'duration' => ucfirst(lang('labels_duration')),
			'reason' => ucfirst(lang('labels_reason')),
			'status' => ucfirst(lang('labels_status')),
			'text' => lang('text_loa_request'),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('user_status', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function _email($type = '', $data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* define the variables */
		$email = FALSE;
		
		switch ($type)
		{
			case 'nominate':
				/* load the resources */
				$this->load->model('awards_model', 'awards');
				
				$award = $this->awards->get_award($data['award'], 'award_name');
				
				/* set some variables */
				$subject = lang('email_subject_award_nomination');
				
				/* set who the email is coming from */
				$from_name = $this->char->get_character_name($data['nominate'], TRUE, TRUE);
				$from_email = $this->player->get_email_address('character', $data['nominate']);
				
				if ($data['cat'] == 'ooc')
				{
					$player = $this->player->get_player($data['receive']);
					$to_name = (empty($player->name)) ? $player->email : $player->name;
				}
				else
				{
					$to_name = $this->char->get_character_name($data['receive'], TRUE, TRUE);
				}
				
				/* set the content */
				$content = sprintf(
					lang('email_content_award_nomination'),
					$from_name,
					$to_name,
					$award,
					$to_name,
					$from_name,
					$data['reason']
				);
				
				/* set the email data */
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content,
					'email_from' => '',
					'email_subject' => ''
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('user_nominate', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* make a string of email addresses */
				$to = implode(',', $this->player->get_emails_with_access('user/nominate', 2));
				
				/* set the parameters for sending the email */
				$this->email->from($from_email, $from_name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
				
				break;
				
			case 'status':
				/* set some variables */
				$subject = lang('email_subject_user_status_change');
				
				/* set who the email is coming from */
				$from_name = $this->char->get_character_name($data['requestor'], TRUE, TRUE);
				$from_email = $this->player->get_email_address('character', $data['requestor']);
				
				/* set the content */
				$content = sprintf(
					lang('email_content_user_status_change'),
					$from_name,
					$data['status'],
					$data['status'],
					$data['duration'],
					$data['reason']
				);
				
				/* set the email data */
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('user_status_change', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* make a string of email addresses */
				$to = implode(',', $this->player->get_gm_emails());
				
				/* set the parameters for sending the email */
				$this->email->from($from_email, $from_name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
				
				break;
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
}

/* End of file user_base.php */
/* Location: ./application/controllers/user_base.php */