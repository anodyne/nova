<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Users controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_user extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function account()
	{
		Auth::check_access();
		
		$level = Auth::get_access_level();
		$id = $this->session->userdata('userid');
		$id = ($level == 2) ? $this->uri->segment(3, $id, true) : $id;
		
		$this->load->model('positions_model', 'pos');
		$this->load->model('access_model', 'access');
		
		$data['my_user'] = ($id == $this->session->userdata('userid'));
		
		if (isset($_POST['submit']))
		{
			/*
			 * level 1 can update everything but status and loa
			 * level 2 can update everything
			 */
			 
			if ($_POST['submit'] == 'Update')
			{
				$user = $this->uri->segment(3, 0, true);
				
				if ($level == 1 and $user != $this->session->userdata('userid'))
				{
					redirect('admin/error/7');
				}
				
				$update = 0;
				
				$update_all = $this->user->update_all_user_prefs($user);
				
				foreach ($_POST as $key => $value)
				{
					if (substr($key, 0, 2) == 'p_')
					{
						$update_array = array('prefvalue_value' => $value);
						
						$new_key = substr_replace($key, '', 0, 2);
						
						$update += $this->user->update_user_pref($user, $new_key, $update_array);
					}
					else
					{
						$array[$key] = $value;
						
						if ($key == 'password' or $key == 'security_answer')
						{
							if ( ! empty($value))
							{
								$array[$key] = ($key == 'password') ? Auth::hash($value) : sha1($value);
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
				
				// set the last update
				$array['last_update'] = now();
				
				// submit needs to be removed
				unset($array['submit']);
				
				if ($level == 2)
				{
					$old_loa = $array['loa_old'];
					
					unset($array['loa_old']);
				}
				
				if ($user == $this->session->userdata('userid'))
				{
					$this->session->set_userdata('timezone', $array['timezone']);
					$this->session->set_userdata('dst', $array['daylight_savings']);
					$this->session->set_userdata('language', $array['language']);
				}
				
				$update += $this->user->update_user($user, $array);
				
				if ($update > 0)
				{
					if ($level == 2)
					{
						if ($array['loa'] != $old_loa)
						{
							$loa = $this->user->get_last_loa($user, true);
				
							if ($loa->num_rows() > 0)
							{
								$row = $loa->row();
							
								$loa_array = array('loa_end_date' => now());
							
								$this->user->update_loa_record($row->loa_id, $loa_array);
							}
							else
							{
								if ($array['loa'] != 'active')
								{
									$loa_array = array(
										'loa_user' => $user,
										'loa_start_date' => now(),
										'loa_type' => $array['loa'],
										'loa_duration' => '',
										'loa_reason' => ''
									);
								
									$this->user->create_loa_record($loa_array);
								}
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
					
					// if a user is updating their own password, update the cookie if it exists
					if ($user == $this->session->userdata('userid') and isset($array['password']))
					{
						// load the cookie helper
						$this->load->helper('cookie');
						
						// grab nova's unique identifier
						$uid = $this->sys->get_nova_uid();
						
						// grab the cookie
						$cookie = get_cookie('nova_'. $uid);
						
						if ($cookie !== false)
						{
							// set the cookie data
							$c_data = array(
								'password' => array(
									'name'   => $uid .'[password]',
									'value'  => $array['password'],
									'expire' => '1209600',
									'prefix' => 'nova_')
							);
							
							// set the cookie
							set_cookie($c_data['password']);
						}
					}
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
				
				// set the flash message
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			}
			
			if ($this->uri->segment(4) == 'deactivate' and $level == 2)
			{
				// grab the user out of the POST array
				$user = $this->input->post('id', true);
				
				// get all the user's active characters
				$characters = $this->char->get_user_characters($user, 'active');
				
				if ($characters->num_rows() > 0)
				{
					foreach ($characters->result() as $c)
					{
						// update the character record
						$this->char->update_character($c->charid, array('crew_type' => 'inactive', 'date_deactivate' => now()));
						
						// update the positions table
						$this->pos->update_open_slots($c->position_1, 'remove_crew');
						$this->pos->update_open_slots($c->position_2, 'remove_crew');
					}
				}
				
				// update the user record
				$useraction = $this->user->update_user($user, array(
					'status' => 'inactive',
					'access_role' => Access_Model::INACTIVE,
					'is_sysadmin' => 'n',
					'is_game_master' => 'n',
					'is_webmaster' => 'n',
					'is_firstlaunch' => 'n',
					'leave_date' => now(),
					'loa' => 'active',
					'last_update' => now()));
				
				$message = sprintf(
					($useraction > 0) ? lang('flash_success') : lang('flash_failure'),
					ucfirst(lang('global_user')),
					lang('actions_deactivated'),
					''
				);

				$flash['status'] = ($useraction > 0) ? 'success' : 'error';
				$flash['message'] = text_output($message);
				
				// set the flash message
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			}
			
			if ($this->uri->segment(4) == 'activate' and $level == 2)
			{
				// grab the user out of the POST array
				$user = $this->input->post('id', true);
				$characters = $this->input->post('characters', true);
				
				if ($characters !== false and count($characters) > 0)
				{
					foreach ($characters as $c)
					{
						// get the character
						$character = $this->char->get_character($c);
						
						$update_array = array(
							'crew_type' => 'active',
							'date_deactivate' => null,
						);
						
						// update the positions table
						$this->pos->update_open_slots($character->position_1, 'add_crew');
						$this->pos->update_open_slots($character->position_2, 'add_crew');
						
						// update the character record
						$this->char->update_character($c, $update_array);
					}
				}
				
				// update the user record
				$useraction = $this->user->update_user($user, array(
					'status' => 'active',
					'access_role' => Access_Model::STANDARD,
					'is_sysadmin' => 'n',
					'is_game_master' => 'n',
					'is_webmaster' => 'n',
					'is_firstlaunch' => 'n',
					'leave_date' => null,
					'loa' => 'active',
					'password_reset' => 1,
					'last_update' => now()));
				
				$message = sprintf(
					($useraction > 0) ? lang('flash_success') : lang('flash_failure'),
					ucfirst(lang('global_user')),
					lang('actions_activated'),
					''
				);

				$flash['status'] = ($useraction > 0) ? 'success' : 'error';
				$flash['message'] = text_output($message);
				
				// set the flash message
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			}
			
			if ($this->uri->segment(4) == 'resetpassword' and $level == 2)
			{
				// grab the user out of the POST array
				$user = $this->input->post('id', true);
				
				// get the user details
				$item = $this->user->get_user($user);
				
				if ($item !== false)
				{
					// generate a password
					$new_password = random_string('alnum', 8);
					
					$array = array(
						'password_reset' => 1,
						'password' => Auth::hash($new_password)
					);
					
					// update the user record
					$update = $this->user->update_user($user, $array);
					
					$emdata = array(
						'email' => $item->email,
						'id' => $user,
						'password' => $new_password,
						'name' => $item->name
					);
					
					// send the email
					$email = ($this->options['system_email'] == 'on') ? $this->_email('reset', $emdata) : false;
				}
				
				$message = sprintf(
					($update > 0) ? lang('flash_success') : lang('flash_failure'),
					ucfirst(lang('global_user').' '.lang('labels_password')),
					lang('actions_reset'),
					''
				);

				$flash['status'] = ($update > 0) ? 'success' : 'error';
				$flash['message'] = text_output($message);
				
				// set the flash message
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			}
		}
		
		// load the resources
		$this->load->helper('directory');
		$this->load->model('access_model', 'access');
		
		// grab the user details
		$details = $this->user->get_user($id);
		
		if ($details !== false)
		{
			$data['inputs'] = array(
				'id' => $details->userid,
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
					'value' => '1',
					'checked' => ($details->daylight_savings == '1') ? true : false),
				'dst_n' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_n',
					'value' => '0',
					'checked' => ($details->daylight_savings == '0') ? true : false),
				'admin_y' => array(
					'name' => 'is_sysadmin',
					'id' => 'admin_y',
					'value' => 'y',
					'checked' => ($details->is_sysadmin == 'y') ? true : false),
				'admin_n' => array(
					'name' => 'is_sysadmin',
					'id' => 'admin_n',
					'value' => 'n',
					'checked' => ($details->is_sysadmin == 'n') ? true : false),
				'gm_y' => array(
					'name' => 'is_game_master',
					'id' => 'gm_y',
					'value' => 'y',
					'checked' => ($details->is_game_master == 'y') ? true : false),
				'gm_n' => array(
					'name' => 'is_game_master',
					'id' => 'gm_n',
					'value' => 'n',
					'checked' => ($details->is_game_master == 'n') ? true : false),
				'webmaster_y' => array(
					'name' => 'is_webmaster',
					'id' => 'webmaster_y',
					'value' => 'y',
					'checked' => ($details->is_webmaster == 'y') ? true : false),
				'webmaster_n' => array(
					'name' => 'is_webmaster',
					'id' => 'webmaster_n',
					'value' => 'n',
					'checked' => ($details->is_webmaster == 'n') ? true : false),
				'mod_posts_y' => array(
					'name' => 'moderate_posts',
					'id' => 'mod_posts_y',
					'value' => 'y',
					'checked' => ($details->moderate_posts == 'y') ? true : false),
				'mod_posts_n' => array(
					'name' => 'moderate_posts',
					'id' => 'mod_posts_n',
					'value' => 'n',
					'checked' => ($details->moderate_posts == 'n') ? true : false),
				'mod_logs_y' => array(
					'name' => 'moderate_logs',
					'id' => 'mod_logs_y',
					'value' => 'y',
					'checked' => ($details->moderate_logs == 'y') ? true : false),
				'mod_logs_n' => array(
					'name' => 'moderate_logs',
					'id' => 'mod_logs_n',
					'value' => 'n',
					'checked' => ($details->moderate_logs == 'n') ? true : false),
				'mod_news_y' => array(
					'name' => 'moderate_news',
					'id' => 'mod_news_y',
					'value' => 'y',
					'checked' => ($details->moderate_news == 'y') ? true : false),
				'mod_news_n' => array(
					'name' => 'moderate_news',
					'id' => 'mod_news_n',
					'value' => 'n',
					'checked' => ($details->moderate_news == 'n') ? true : false),
				'mod_pcomment_y' => array(
					'name' => 'moderate_post_comments',
					'id' => 'mod_pcomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_post_comments == 'y') ? true : false),
				'mod_pcomment_n' => array(
					'name' => 'moderate_post_comments',
					'id' => 'mod_pcomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_post_comments == 'n') ? true : false),
				'mod_lcomment_y' => array(
					'name' => 'moderate_log_comments',
					'id' => 'mod_lcomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_log_comments == 'y') ? true : false),
				'mod_lcomment_n' => array(
					'name' => 'moderate_log_comments',
					'id' => 'mod_lcomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_log_comments == 'n') ? true : false),
				'mod_ncomment_y' => array(
					'name' => 'moderate_news_comments',
					'id' => 'mod_ncomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_news_comments == 'y') ? true : false),
				'mod_ncomment_n' => array(
					'name' => 'moderate_news_comments',
					'id' => 'mod_ncomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_news_comments == 'n') ? true : false),
				'mod_wcomment_y' => array(
					'name' => 'moderate_wiki_comments',
					'id' => 'mod_wcomment_y',
					'value' => 'y',
					'checked' => ($details->moderate_wiki_comments == 'y') ? true : false),
				'mod_wcomment_n' => array(
					'name' => 'moderate_wiki_comments',
					'id' => 'mod_wcomment_n',
					'value' => 'n',
					'checked' => ($details->moderate_wiki_comments == 'n') ? true : false),
			);
			
			$data['button'] = array(
				'user_status' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'id' => ($details->status == 'active') ? 'user-deactivate' : 'user-activate',
					'myid' => $id,
					'content' => ($details->status == 'active') 
						? ucwords(lang('actions_deactivate').' '.lang('global_user'))
						: ucwords(lang('actions_activate').' '.lang('global_user'))
					),
				'password_reset' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'id' => 'reset-password',
					'myid' => $id,
					'content' => ucwords(lang('actions_reset').' '.lang('time_now'))),
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
						'checked' => ($this->user->get_pref($p->pref_key, $id) == 'y') ? true : false),
					'label' => $p->pref_label
				);
			}
		}
		
		// grab the directory map of the language folder
		$dir = directory_map(APPFOLDER .'/language', true);
		
		// loop through the directory map and create the dropdown array
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
		
		// get the questions from the database
		$questions = $this->sys->get_security_questions();
		
		// build the array with the questions
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
				'src' => Location::img('user.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'display' => array(
				'src' => Location::img('display.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
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
			'mod_c_wiki' => ucwords(lang('global_wiki') .' '. lang('labels_comments')),
			'mod_logs' => ucwords(lang('global_personallogs')),
			'mod_news' => ucwords(lang('global_newsitems')),
			'mod_posts' => ucwords(lang('global_missionposts')),
			'moderate' => ucfirst(lang('actions_moderate')),
			'mybio' => ucwords(lang('labels_my') .' '. lang('labels_bio')),
			'myprefs' => ucwords(lang('labels_my') .' '. lang('labels_preferences')),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'password' => ucfirst(lang('labels_password')),
			'usersettings' => ucwords(lang('global_user') .' '. lang('labels_settings')),
			'reset_password' => ucwords(lang('actions_reset').' '.lang('labels_password')),
			'role' => ucwords(lang('labels_access') .' '. lang('labels_role')),
			'secanswer' => ucwords(lang('labels_security') .' '. lang('labels_answer')),
			'secquestion' => ucwords(lang('labels_security') .' '. lang('labels_question')),
			'sectext' => lang('text_security_question'),
			'status' => ucwords(lang('abbr_loa').' '.lang('labels_status')),
			'sysadmin' => ucwords(lang('global_sysadmin')),
			'text_credentials_1' => lang('text_user_credential_confirm_1'),
			'text_credentials_2' => lang('text_user_credential_confirm_2'),
			'datetime' => ucwords(lang('time_dates') .' '. AMP .' '. lang('labels_times')),
			'timezone' => ucfirst(lang('labels_timezone')),
			'type' => ucwords(lang('global_user') .' '. lang('labels_status')),
			'webmaster' => ucfirst(lang('global_webmaster')),
			'yes' => ucfirst(lang('labels_yes')),
			'your_user' => sprintf(lang('account_your_user'), lang('global_user')),
		);
		
		$this->_regions['content'] = Location::view('user_account', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('user_account_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function all()
	{
		Auth::check_access('user/account');
		
		$level = Auth::get_access_level('user/account');
		
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
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// remove the user's prefs
					$delete = $this->user->delete_user_pref_values($id);
					
					// delete the user
					$delete += $this->user->delete_user($id);
					
					if ($delete > 0)
					{
						$chars = $this->char->get_user_characters($id, '', 'array');
						
						if (count($chars) > 0)
						{
							$update_array = array('user' => null);
							
							foreach ($chars as $c)
							{
								$update = $this->char->update_character($c, $update_array);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_user')),
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
							ucfirst(lang('global_user')),
							lang('actions_deleted'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$users = $this->user->get_users('');
		
		if ($users->num_rows() > 0)
		{
			foreach ($users->result() as $p)
			{
				$data['users'][$p->status][$p->userid] = array(
					'id' => $p->userid,
					'main_char' => $this->char->get_character_name($p->main_char, true),
					'email' => $p->email,
					'name' => $p->name,
					'left' => ( ! empty($p->leave_date)) ? timespan($p->leave_date, now()) : '',
				);
			}
		}
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('labels_users'));
		
		$data['images'] = array(
			'loading' => array(
				'src' => Location::img('loading-circle-large.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view')),
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'active' => ucwords(lang('status_active') .' '. lang('global_users')),
			'ago' => lang('time_ago'),
			'character' => ucwords(lang('labels_main') .' '. lang('global_character')),
			'inactive' => ucwords(lang('status_inactive') .' '. lang('global_users')),
			'left' => ucfirst(lang('labels_left')),
			'name' => ucfirst(lang('labels_name')),
			'pending' => ucwords(lang('status_pending') .' '. lang('global_users')),
			'loading' => ucfirst(lang('actions_loading')).'...',
		);
		
		$this->_regions['content'] = Location::view('user_all', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('user_all_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function characterlink($user = 0)
	{
		Auth::check_access('user/account');
		
		$level = Auth::get_access_level('user/account');
		
		if ($level == 2)
		{
			// sanity check
			$data['user'] = (is_numeric($user)) ? $user : 0;
			
			switch ($this->uri->segment(4))
			{
				case 'add':
					$id = $this->uri->segment(5, 0, true);
					
					// get all the characters and make sure it isn't blank
					$chars_raw = $this->char->get_user_characters($user, '', 'array');
					$chars = ($chars_raw !== false) ? $chars_raw : array();
					
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
					
					if ( ! $key)
					{
						// set up the data array with the user info
						$data_array = array('data_user' => $data['user']);
						
						// update all the character data to point to the user
						$update_data = $this->char->update_character_data_all($id, 'data_char', $data_array);
					
						$c_type = $this->char->get_character($id, 'crew_type');
						
						if (($c_type == 'npc' and $type['npc'] >= $this->options['allowed_chars_npc']) or
							($c_type == 'active' and $type['active'] >= $this->options['allowed_chars_playing']))
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
							
							$user_update = 0;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
							
							// set the deactivate date and user ID
							$char_activate = array(
								'date_activate' => now(),
								'user' => $user,
							);
							
							// run the update
							$char_update = $this->char->update_character($id, $char_activate);
							
							// push the item we're adding onto the array
							$chars[] = $id;
							
							// put the characters into a string
							$chars_string = implode(',', $chars);
							
							// create an array for updating the user record
							$update_array = array('last_update' => now());
							
							// get the user's main character
							$main = $this->user->get_user($user, 'main_char');
							
							if ($chars_raw === false or empty($main))
							{
								$update_array['main_char'] = $id;
							}
							
							// run the update
							$user_update = $this->user->update_user($user, $update_array);
						}
						
						if ($user_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout_alt')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'remove':
					$id = $this->uri->segment(5, 0, true);
					
					// get an array of the user's characters
					$chars = $this->char->get_user_characters($user, 'active_npc', 'array');
					
					// new main is null until something overwrites it in the event the main char is removed
					$newmain = null;
					
					if (count($chars) > 0)
					{
						foreach ($chars as $c)
						{
							if ($c != $id)
							{
								$ctemp = $this->char->get_character($c, 'crew_type');
								
								if ($ctemp == 'active' and is_null($newmain))
								{
									$newmain = $c;
								}
							}
						}
					}
					
					// search the array
					$key = array_search($id, $chars);
					
					if ($key !== false)
					{
						// set up the data array with the user info
						$data_array = array('data_user' => null);
						
						// update all the character data to point to the user
						$update_data = $this->char->update_character_data_all($id, 'data_char', $data_array);
					
						$main = $this->user->get_user($data['user'], 'main_char');
						
						// set the deactivate date and user ID
						$char_deactivate = array(
							'date_deactivate' => now(),
							'user' => null,
						);
						
						// run the update
						$char_update = $this->char->update_character($id, $char_deactivate);
						
						// unset the item we're removing
						unset($chars[$key]);
						
						// put the characters into a string
						$chars_string = implode(',', $chars);
						
						// create an array for updating the user record
						$update_array = array(
							'last_update' => now(),
							'main_char' => ($main == $id) ? $newmain : $main
						);
						
						// run the update
						$user_update = $this->user->update_user($user, $update_array);
						
						if ($user_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout_alt')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
		
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'set':
					$id = $this->uri->segment(5, 0, true);
					
					// grab the current main character
					$char = $this->user->get_user($user, 'main_char');
					
					if ($char != $id)
					{
						// create an array for updating the user record
						$update_array = array(
							'main_char' => $id,
							'last_update' => now()
						);
						
						// run the update
						$user_update = $this->user->update_user($user, $update_array);
						
						if ($user_update > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								' '. lang('text_logout_alt')
							);
		
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure_plural'),
								ucfirst(lang('global_user') .' '. lang('global_characters')),
								lang('actions_updated'),
								''
							);
		
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
						
						// set the flash message
						$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
					}
				break;
			}
			
			if ($user == 0)
			{
				$all = $this->user->get_users();
				
				if ($all->num_rows() > 0)
				{
					foreach ($all->result() as $a)
					{
						$data['all'][$a->userid] = ( ! empty($a->name)) ? $a->name : $a->email;
					}
				}
			}
			else
			{
				// load the resources
				$this->load->model('positions_model', 'pos');
				
				$all = $this->char->get_user_characters($user, '', 'array');
				
				// get the user's current characters
				$chars = ($all !== false) ? $all : array();
				
				// get all characters that don't have a user assigned to them
				$unassigned = $this->char->get_all_characters('no_user');
				
				$userinfo = $this->user->get_user($user);
				
				$data['p_name'] = $userinfo->name;
				$data['p_email'] = $userinfo->email;
				
				$data['count_active'] = 0;
				$data['count_npc'] = 0;
				
				if (count($chars) > 0)
				{
					foreach ($chars as $c)
					{
						$d = $this->char->get_character($c, array('crew_type', 'position_1'));
						
						$data['chars'][$c] = array(
							'name' => $this->char->get_character_name($c, true),
							'position' => $this->pos->get_position($d['position_1'], 'pos_name'),
							'type' => ($d['crew_type'] == 'npc') ? strtoupper($d['crew_type']) : ucfirst($d['crew_type']),
							'main' => ($this->user->get_main_character($user) != $c) ? false : true,
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
							'name' => $this->char->get_character_name($u->charid, true),
							'position' => $this->pos->get_position($u->position_1, 'pos_name')
						);
					}
				}
			}
			
			$data['header'] = ucwords(lang('labels_link') .' '. lang('global_characters')) .' '. 
				lang('labels_to') .' '. ucfirst(lang('labels_account'));
			
			$data['text'] = sprintf(
				lang('text_link_characters'),
				lang('global_user'),
				lang('global_characters'),
				lang('global_characters'),
				lang('global_user'),
				lang('global_character'),
				lang('global_character'),
				lang('global_user'),
				lang('global_character'),
				lang('global_user')
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
					'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
					'alt' => lang('actions_remove'),
					'class' => 'image'),
				'star' => array(
					'src' => Location::img('icon-star.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'add' => array(
					'src' => Location::img('icon-add.png', $this->skin, 'admin'),
					'alt' => lang('actions_add'),
					'class' => 'image'),
				'main' => array(
					'src' => Location::img('icon-green-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'npc' => array(
					'src' => Location::img('icon-gray-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'active' => array(
					'src' => Location::img('icon-blue-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'inactive' => array(
					'src' => Location::img('icon-black-small.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
			);
			
			$data['label'] = array(
				'add' => ucwords(lang('actions_add') .' '. lang('global_character')),
				'allchars' => LARROW .' '. ucwords(lang('labels_all') .' '. lang('global_users')),
				'chars_nonplaying' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
				'chars_playing' => ucwords(lang('status_playing') .' '. lang('global_characters')),
				'current' => ucwords(lang('status_current') .' '. lang('global_characters')),
				'email' => ucwords(lang('labels_email_address')),
				'name' => ucfirst(lang('labels_name')),
				'nocharacters' => ucfirst(lang('labels_no') .' '. lang('global_characters') .' '. lang('actions_found')),
				'user' => ucwords(lang('global_user') .' '. lang('labels_info')),
				'select' => ucfirst(lang('labels_please') .' '. lang('actions_select') .' '. 
					lang('labels_a') .' '. lang('global_user')),
				'remove' => ucfirst(lang('actions_remove')),
			);
			
			$this->_regions['content'] = Location::view('user_characterlink', $this->skin, 'admin', $data);
			$this->_regions['javascript'] = Location::js('user_characterlink_js', $this->skin, 'admin');
			$this->_regions['title'].= $data['header'];
			
			Template::assign($this->_regions);
			
			Template::render();
		}
		else
		{
			redirect('admin/error/1');
		}
	}
	
	public function nominate()
	{
		Auth::check_access();
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// load the resources
		$this->load->model('awards_model', 'awards');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'queue':
					if (Auth::get_access_level() > 1)
					{
						$action = $this->input->post('action', true);
						
						$id = $this->input->post('id', true);
						$id = (is_numeric($id)) ? $id : false;
						
						switch ($action)
						{
							case 'approve':
								$award_update = array('queue_status' => 'accepted');
								
								$update = $this->awards->update_queue_record($id, $award_update);
								
								$nom = $this->sys->get_item('awards_queue', 'queue_id', $id);
								
								$received = array(
									'awardrec_user' => $nom->queue_receive_user,
									'awardrec_character' => $nom->queue_receive_character,
									'awardrec_award' => $nom->queue_award,
									'awardrec_date' => now(),
									'awardrec_reason' => $nom->queue_reason,
									'awardrec_nominated_by' => $nom->queue_nominate
								);
								
								$insert = $this->awards->add_nominated_award($received);
								
								if ($update > 0 and $insert > 0)
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
							break;
						}
					}
				break;
					
				default:
					$character = $this->input->post('character', true);
					$awardid = $this->input->post('award', true);
					
					$award = $this->awards->get_award($awardid);
					
					$insert_array = array(
						'queue_receive_character' => ($award->award_cat == 'ooc') ? 0 : $character,
						'queue_receive_user' => $this->char->get_character($character, 'user'),
						'queue_nominate' => $this->session->userdata('main_char'),
						'queue_award' => $awardid,
						'queue_reason' => $this->input->post('reason', true),
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
							'receive' => ($award->award_cat == 'ooc') ? $insert_array['queue_receive_user'] : $character,
							'cat' => $award->award_cat,
							'reason' => $insert_array['queue_reason'],
							'award' => $insert_array['queue_award'],
							'nominate' => $insert_array['queue_nominate']
						);
						
						$email = ($this->options['system_email'] == 'on') ? $this->_email('nominate', $email_data) : false;
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab all the awards
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
		
		if (Auth::get_access_level() > 1)
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
						'awardee' => $this->char->get_character_name($n->queue_receive_character, true),
						'nominator' => $this->char->get_character_name($n->queue_nominate, true),
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
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_loading') .'...')),
			'reject' => array(
				'src' => Location::img('icon-slash.png', $this->skin, 'admin'),
				'alt' => lang('actions_reject'),
				'title' => ucfirst(lang('actions_reject')),
				'class' => 'image'),
			'accept' => array(
				'src' => Location::img('icon-check.png', $this->skin, 'admin'),
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
			'noawards' => sprintf(lang('error_not_found'), lang('global_awards')),
			'nominate' => ucfirst(lang('actions_nominate')),
			'nominatequeue' => ucwords(lang('labels_nomination') .' '. lang('labels_queue')),
			'nonominations' => sprintf(lang('error_not_found'), lang('global_award').' '.lang('labels_nominations')),
			'on' => lang('labels_on'),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		$js_data['tab'] = ($this->uri->segment(3) == 'queue') ? 1 : 0;
		
		$this->_regions['content'] = Location::view('user_nominate', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('user_nominate_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function options()
	{
		Auth::check_access('user/account');
		
		// set the user id
		$id = $this->session->userdata('userid');
		
		// set the tab
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
					
					$update = $this->user->update_user($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_user') .' '. lang('labels_menu')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						// change the user's session with the new rank info
						$this->session->set_userdata('my_links', $session_array);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_user') .' '. lang('labels_menu')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$js_data['tab'] = 2;
				break;
					
				case 'ranks':
					$rank = $this->input->post('rank', true);
					
					$update_array = array(
						'display_rank' => $rank,
						'last_update' => now()
					);
					
					$update = $this->user->update_user($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_user') .' '. lang('global_rank')
								.' '. lang('labels_preference')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						// change the user's session with the new rank info
						$this->session->set_userdata('display_rank', $rank);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_user') .' '. lang('global_rank')
								.' '. lang('labels_preference')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$js_data['tab'] = 1;
				break;
					
				case 'skins':
					$skin_admin = $this->input->post('skin_admin', true);
					$skin_main = $this->input->post('skin_main', true);
					$skin_wiki = $this->input->post('skin_wiki', true);
					
					$update_array = array(
						'skin_admin' => $skin_admin,
						'skin_main' => $skin_main,
						'skin_wiki' => $skin_wiki,
						'last_update' => now()
					);
					
					$update = $this->user->update_user($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_user') .' '. lang('labels_skin')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							lang('flash_additional_refresh')
						);
	
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						// change the user's session with the new info
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
							ucfirst(lang('global_user') .' '. lang('labels_skin')
								.' '. lang('labels_preferences')),
							lang('actions_updated'),
							''
						);
	
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$js_data['tab'] = 0;
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		
		// grab the user details
		$user = $this->user->get_user($id);
		
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
									$item->menu_use_access == 'y' and 
									array_key_exists($item->menu_access, $this->session->userdata('access'))
								) or 
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
		
		$links = explode(',', $user->my_links);
		
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
		
		$skins = $this->sys->get_all_skins();
	
		if ($skins->num_rows() > 0)
		{
			foreach ($skins->result() as $skin)
			{
				$skinaccess = (Auth::check_access('site/catalogueskins', false))
					? array('active', 'development')
					: 'active';
				
				$sections = $this->sys->get_skin_sections($skin->skin_location, $skinaccess);
			
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $section)
					{
						$data['themes'][$section->skinsec_section][$skin->skin_location] = $skin->skin_name;
					}
				}
			}
		}
	
		$data['default']['skin_main'] = $this->session->userdata('skin_main');
		$data['default']['skin_admin'] = $this->session->userdata('skin_admin');
		$data['default']['skin_wiki'] = $this->session->userdata('skin_wiki');
		
		/*
		|---------------------------------------------------------------
		| RANKS
		|---------------------------------------------------------------
		*/
		
		$r_access = Auth::check_access('site/catalogueranks', false);
		$rank_access = ($r_access === true) ? array('active', 'development') : 'active';
		
		$ranks = $this->ranks->get_all_rank_sets($rank_access);
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $r)
			{
				$data['ranks'][] = array(
					'id' => $r->rankcat_id,
					'name' => $r->rankcat_name,
					'preview' => array(
						'src' => Location::rank($r->rankcat_location, 'preview', $r->rankcat_extension),
						'alt' => ''),
					'input' => array(
						'name' => 'rank',
						'id' => 'rank_'. $r->rankcat_id,
						'value' => $r->rankcat_location,
						'checked' => ($this->session->userdata('display_rank') == $r->rankcat_location) ? true : false),
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
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_loading'))),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
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
			'skin_wiki' => ucfirst(lang('global_wiki')),
			'skins_text' => sprintf(lang('text_skins_user'), site_url('site/settings')),
		);
		
		$this->_regions['content'] = Location::view('user_options', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('user_options_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function status()
	{
		Auth::check_access('user/account');
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			$status = strtolower($this->input->post('status', true));
			
			$update_data = array('loa' => $status);
			
			$update = $this->user->update_user($this->session->userdata('userid'), $update_data);
			
			if ($update > 0)
			{
				$loa = $this->user->get_last_loa($this->session->userdata('userid'), true);
				
				if ($loa->num_rows() > 0)
				{
					$row = $loa->row();
					
					$loa_array = array('loa_end_date' => now());
					
					$this->user->update_loa_record($row->loa_id, $loa_array);
				}
				else
				{
					if ($status != 'active')
					{
						$loa_array = array(
							'loa_user' => $this->session->userdata('userid'),
							'loa_start_date' => now(),
							'loa_type' => $status,
							'loa_duration' => $this->input->post('duration', true),
							'loa_reason' => $this->input->post('reason', true)
						);
						
						$this->user->create_loa_record($loa_array);
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
					'requestor' => $this->session->userdata('main_char'),
					'reason' => $this->input->post('reason', true),
					'duration' => $this->input->post('duration', true),
					'status' => $this->input->post('status', true)
				);
				
				$email = ($this->options['system_email'] == 'on') ? $this->_email('status', $email_data) : false;
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
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
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
		
		// grab the loa status of the user
		$loa = $this->user->get_loa($this->session->userdata('userid'));
		
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
		
		$this->_regions['content'] = Location::view('user_status', $this->skin, 'admin', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _email($type, $data)
	{
		// load the libraries
		$this->load->library('email');
		$this->load->library('parser');
		
		// define the variables
		$email = false;
		
		switch ($type)
		{
			case 'nominate':
				// load the resources
				$this->load->model('awards_model', 'awards');
				
				$award = $this->awards->get_award($data['award'], 'award_name');
				
				// set some variables
				$subject = lang('email_subject_award_nomination');
				
				// set who the email is coming from
				$from_name = $this->char->get_character_name($data['nominate'], true, true);
				$from_email = $this->user->get_email_address('character', $data['nominate']);
				
				if ($data['cat'] == 'ooc')
				{
					$user = $this->user->get_user($data['receive']);
					$to_name = (empty($user->name)) ? $user->email : $user->name;
				}
				else
				{
					$to_name = $this->char->get_character_name($data['receive'], true, true);
				}
				
				// set the content
				$content = sprintf(
					lang('email_content_award_nomination'),
					$from_name,
					$to_name,
					$award,
					$to_name,
					$from_name,
					$data['reason']
				);
				
				// set the email data
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content,
					'email_from' => '',
					'email_subject' => ''
				);
				
				// where should the email be coming from
				$em_loc = Location::email('user_nominate', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// make a string of email addresses
				$to = implode(',', $this->user->get_emails_with_access('user/nominate', 2));
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $from_name);
				$this->email->to($to);
				$this->email->reply_to($from_email);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
			break;
			
			case 'reset':
				$content = sprintf(
					lang('email_content_password_reset'),
					$data['password'],
					site_url('login/index')
				);
				
				$email_data = array(
					'email_subject' => lang('email_subject_password_reset'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br($content)
				);
				
				// where should the email be coming from
				$em_loc = Location::email('reset_password', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $data['name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'status':
				// set some variables
				$subject = lang('email_subject_user_status_change');
				
				// set who the email is coming from
				$from_name = $this->char->get_character_name($data['requestor'], true, true);
				$from_email = $this->user->get_email_address('character', $data['requestor']);
				
				// set the content
				$content = sprintf(
					lang('email_content_user_status_change'),
					$from_name,
					$data['status'],
					$data['status'],
					$data['duration'],
					$data['reason']
				);
				
				// set the email data
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content,
					'email_subject' => $subject,
					'email_from' => $from_name,
				);
				
				// where should the email be coming from
				$em_loc = Location::email('user_status_change', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, false);
				
				// make a string of email addresses
				$to = implode(',', $this->user->get_gm_emails());
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $from_name);
				$this->email->to($to);
				$this->email->reply_to($from_email);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
			break;
		}
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
}
