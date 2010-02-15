<?php
/*
|---------------------------------------------------------------
| ADMIN - CHARACTERS CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/characters_base.php
| System Version: 1.0
|
| Controller that handles the CHARACTERS section of the admin system.
|
*/

class Characters_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Characters_base()
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
		$this->load->model('users_model', 'user');
		
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
			'allowed_chars_playing',
			'email_subject'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (strtoupper($this->options['daylight_savings']) == 'TRUE') ? TRUE : FALSE;
		
		if ($this->auth->is_logged_in() === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_admin');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (strtoupper($this->session->userdata('dst')) == 'TRUE') ? TRUE : FALSE;
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_template('admin');
		$this->template->set_master_template($this->skin .'/template_admin.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('adminsub', 'characters'), TRUE);
		$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
		$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
		$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
	}

	function index()
	{
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('applications_model', 'apps');
		$this->load->model('depts_model', 'dept');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					/* get the user id */
					$userid = $this->char->get_character($id, array('user', 'crew_type'));
					
					if ($userid !== FALSE)
					{
						/* grab the user data */
						$user = $this->user->get_user($userid['user']);
						
						/* temp variable for setting a new main character */
						$newmain = NULL;
						
						if ($user !== FALSE)
						{
							$characters = $user->characters;
							$main = $user->main_char;
							
							if (strstr($characters, $id) !== FALSE)
							{ /* if the ID is in the characters string, remove it */
								$carray = explode(',', $characters);
								
								foreach ($carray as $key => $value)
								{
									if ($value == $id)
									{
										unset($carray[$key]);
									}
									else
									{ /* if we're removing a main character, replace it with the first active one */
										$type = $this->char->get_character($value, 'crew_type');
										
										if ($type == 'active' && is_null($newmain))
										{
											$newmain = $value;
										}
									}
								}
								
								$newchars = implode(',', $carray);
							}
							else
							{
								$newchars = $characters;
							}
							
							/* set the array to update the users table */
							$update_array = array('main_char' => ($main == $id) ? $newmain : $main);
							
							$update = $this->user->update_user($userid, $update_array);
						}
						
						if ($userid['crew_type'] == 'pending')
						{
							$this->load->model('applications_model', 'apps');
							
							$a_update = array('app_action' => 'deleted');
							
							$app_update = $this->apps->update_application($id, $a_update);
						}
					}
					
					/* delete the data from the data table */
					$delete = $this->char->delete_character_data($id, 'data_char');
					
					/* delete the data from the characters table */
					$delete += $this->char->delete_character($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_character')),
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
							ucfirst(lang('global_character')),
							lang('actions_deleted'),
							''
						);
		
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'pending':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$action = $this->input->post('action', TRUE);
					
					$info = $this->char->get_character($id);
					$user = $this->user->get_user($info->user);
					$characters = $this->char->get_user_characters($info->user, 'active', 'array');
					$count = count($characters);
					
					if ($action == 'approve')
					{
						$c_update = array(
							'position_1' => $this->input->post('position', TRUE),
							'rank' => $this->input->post('rank', TRUE),
							'crew_type' => 'active',
							'date_activate' => (empty($info->date_activate)) ? now() : $info->date_activate,
							'user' => ($count >= $this->options['allowed_chars_playing']) ? NULL : $info->user, 
						);
						
						$update = $this->char->update_character($id, $c_update);
						
						/* grab the info about the position */
						$pos = $this->pos->get_position($c_update['position_1']);
						
						/* set the proper number of open slots */
						$open = ($pos->pos_open > 0) ? $pos->pos_open - 1 : 0;
						
						/* make sure we're setting the new pos_open field */
						$position_update = array('pos_open' => $open);
						
						/* update the number of open slots for the position */
						$pos_update = $this->pos->update_position($c_update['position_1'], $position_update);
						
						/* grab the message */
						$message = $this->msgs->get_message('accept_message');
						
						/* set the arguments for the message */
						$args = array(
							'name' => (!empty($user->name)) ? $user->name : $user->email,
							'character' => $this->char->get_character_name($id),
							'position' => $this->pos->get_position($c_update['position_1'], 'pos_name'),
							'rank' => $this->ranks->get_rank($c_update['rank'], 'rank_name'),
							'sim' => $this->options['sim_name'],
							'ship' => $this->options['sim_name']
						);
						
						/* parse the message with the args */
						$content = parse_dynamic_message($message, $args);
						
						if ($user->status != 'active')
						{ /* updated the users table if necessary */
							$p_update = array(
								'status' => 'active',
								'leave_date' => NULL,
								'access_role' => $this->input->post('role', TRUE)
							);
							
							$update += $this->user->update_user($user->userid, $p_update);
						}
						
						/* update the applications table */
						$a_update = array(
							'app_action' => 'accepted',
							'app_message' => $content
						);
						
						$this->apps->update_application($id, $a_update);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('global_character')),
								lang('actions_approved'),
								''
							);
			
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
							
							$email_data = array(
								'message' => $content,
								'email' => $user->email,
								'name' => $user->name,
								'character' => $args['character']
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('accept', $email_data) : FALSE;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('global_character')),
								lang('actions_approved'),
								''
							);
			
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
					elseif ($action == 'reject')
					{
						$delete = $this->char->delete_character_data($id, 'data_char');
					
						$delete = $this->char->delete_character($id);
						
						if ($user->status == 'pending')
						{ /* if the user is pending, it means they should only have one character */
							$delete += $this->user->delete_user($user->userid);
						}
						
						/* grab the message */
						$message = $this->msgs->get_message('reject_message');
						
						/* set the arguments for the message */
						$args = array(
							'name' => (!empty($user->name)) ? $user->name : $user->email,
							'character' => $this->char->get_character_name($id),
							'position' => $this->pos->get_position($info->position_1, 'pos_name'),
							'sim' => $this->options['sim_name'],
							'ship' => $this->options['sim_name']
						);
						
						/* parse the message with the args */
						$content = parse_dynamic_message($message, $args);
						
						/* update the applications table */
						$a_update = array(
							'app_action' => 'rejected',
							'app_message' => $content
						);
						
						$this->apps->update_application($id, $a_update);
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('global_character')),
								lang('actions_rejected'),
								''
							);
			
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
							
							$email_data = array(
								'message' => $content,
								'email' => $user->email,
								'name' => $user->name,
								'character' => $args['character']
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('reject', $email_data) : FALSE;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('global_character')),
								lang('actions_rejected'),
								''
							);
			
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$all = $this->char->get_all_characters('all');
		
		$depts = $this->dept->get_all_depts('asc', '');
		
		if ($depts->num_rows() > 0)
		{
			foreach ($depts->result() as $d)
			{
				$data['characters'][$d->dept_id]['dept'] = $d->dept_name;
			}
		}
		
		$data['count'] = array(
			'active' => 0,
			'inactive' => 0,
			'pending' => 0
		);
		
		if ($all->num_rows() > 0)
		{
			foreach ($all->result() as $a)
			{
				if ($a->crew_type != 'npc')
				{
					$name = array(
						($a->crew_type != 'pending') ? $this->ranks->get_rank($a->rank, 'rank_name') : '',
						$a->first_name,
						$a->middle_name,
						$a->last_name,
						$a->suffix
					);
					
					$pos = $this->pos->get_position($a->position_1);
					
					if (array_key_exists($pos->pos_dept, $data['characters']) === FALSE)
					{
						$cdept = $this->dept->get_dept($pos->pos_dept, 'dept_parent');
					}
					else
					{
						$cdept = $pos->pos_dept;
					}
					
					$p = $this->user->get_user($a->user, array('status', 'email'));
					
					$data['characters'][$cdept]['chars'][$a->crew_type][$a->charid] = array(
						'id' => $a->charid,
						'uid' => $a->user,
						'name' => parse_name($name),
						'position_1' => $pos->pos_name,
						'position_2' => $this->pos->get_position($a->position_2, 'pos_name'),
						'pstatus' => $p['status'],
						'email' => $p['email']
					);
					
					++$data['count'][$a->crew_type];
				}
			}
		}
		
		/* sort the keys */
		ksort($data['characters']);
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('global_characters'));
		
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
			'approve' => array(
				'src' => img_location('user-accept.png', $this->skin, 'admin'),
				'alt' => lang('actions_accept'),
				'title' => ucfirst(lang('actions_accept')),
				'class' => 'image'),
			'reject' => array(
				'src' => img_location('user-reject.png', $this->skin, 'admin'),
				'alt' => lang('actions_reject'),
				'title' => ucfirst(lang('actions_reject')),
				'class' => 'image'),
			'add' => array(
				'src' => img_location('user-add.png', $this->skin, 'admin'),
				'alt' => lang('actions_create'),
				'title' => ucfirst(lang('actions_create')),
				'class' => 'image inline_img_left'),
			'new' => array(
				'src' => img_location('icon-green-small.png', $this->skin, 'admin'),
				'alt' => lang('status_new'),
				'class' => 'image'),
			'account' => array(
				'src' => img_location('user-account.png', $this->skin, 'admin'),
				'alt' => lang('labels_account'),
				'title' => ucfirst(lang('labels_account')),
				'class' => 'image'),
			'assign' => array(
				'src' => img_location('user-assign.png', $this->skin, 'admin'),
				'alt' => lang('actions_assign'),
				'title' => ucfirst(lang('actions_assign')),
				'class' => 'image'),
		);
		
		$data['levelcheck'] = array(
			'account' => $this->auth->get_access_level('user/account'),
			'bio' => $this->auth->get_access_level('characters/bio'),
		);
		
		$data['label'] = array(
			'active' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'create' => ucwords(lang('actions_create') .' '. lang('status_new')
				.' '. lang('global_character') .' '. RARROW),
			'inactive' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'loading' => ucfirst(lang('actions_loading') .'...'),
			'newuser' => ucwords(lang('status_new') .' '. lang('global_user')),
			'noactive' => ucfirst(lang('labels_no') .' '. lang('status_active')
				.' '. lang('global_characters') .' '. lang('actions_found')),
			'noinactive' => ucfirst(lang('labels_no') .' '. lang('status_inactive')
				.' '. lang('global_characters') .' '. lang('actions_found')),
			'nopending' => ucfirst(lang('labels_no') .' '. lang('status_pending')
				.' '. lang('global_characters') .' '. lang('actions_found')),
			'nouser' => ucfirst(lang('labels_no') .' '. lang('global_user')
				.' '. lang('actions_assigned') .'!'),
			'pending' => ucwords(lang('status_pending') .' '. lang('global_characters')),
		);
		
		switch ($this->uri->segment(3))
		{
			case 'inactive':
				$js_data['tab'] = 1;
				break;
				
			case 'pending':
				$js_data['tab'] = 2;
				break;
				
			default:
				$js_data['tab'] = 0;
		}
		
		$js_data['tab'] = ($data['count']['pending'] > 0) ? 2 : $js_data['tab'];
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_index', $this->skin, 'admin');
		$js_loc = js_location('characters_index_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function awards()
	{
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if (isset($_POST['submit']))
		{
			/* set the character ID and do some sanity checking */
			$id = $this->input->post('id', TRUE);
			$id = (is_numeric($id)) ? $id : FALSE;
			
			/* set the award id */
			$award = $this->input->post('award', TRUE);
			
			/* get info about the award */
			$info = $this->awards->get_award($award);
			
			/* build the insert array */
			$insert_array = array(
				'awardrec_award' => $award,
				'awardrec_character' => ($info->award_cat == 'ooc') ? 0 : $id,
				'awardrec_user' => $this->char->get_character($id, 'user'),
				'awardrec_reason' => $this->input->post('reason', TRUE),
				'awardrec_date' => now(),
				'awardrec_nominated_by' => $this->session->userdata('main_char'),
			);
			
			/* add the record to the database */
			$insert = $this->awards->add_nominated_award($insert_array);
			
			if ($insert > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_award')),
					lang('actions_given'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_award')),
					lang('actions_given'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		if ($id === FALSE)
		{
			$characters = $this->char->get_all_characters('all');
			
			if ($characters->num_rows() > 0)
			{
				foreach ($characters->result() as $c)
				{
					$args = array(
						$this->ranks->get_rank($c->rank, 'rank_name'),
						$c->first_name,
						$c->middle_name,
						$c->last_name,
						$c->suffix
					);
					
					$data['characters'][$c->crew_type][$c->charid] = array(
						'name' => parse_name($args),
						'id' => $c->charid
					);
				}
			}
		}
		else
		{
			$info = $this->char->get_character($id);
			
			$type = ($info->crew_type == 'npc') ? 'ic' : '';
			
			/* grab all the awards */
			$awards = $this->awards->get_all_awards('asc', 'y', $type);
			
			if ($awards->num_rows() > 0)
			{
				$data['awards'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose') 
					.' '. lang('order_one'));
					
				foreach ($awards->result() as $a)
				{
					$data['awards'][$a->award_id] = $a->award_name;
				}
			}
			
			/* get the character's awards */
			$charawards = $this->awards->get_awards_for_id($id);
			
			if ($charawards->num_rows() > 0)
			{
				foreach ($charawards->result() as $c)
				{
					$award = $this->awards->get_award($c->awardrec_award, array('award_name', 'award_image'));
					$date = gmt_to_local($c->awardrec_date, $this->timezone, $this->dst);
					
					$data['character']['awards'][$c->awardrec_id]['id'] = $c->awardrec_id;
					$data['character']['awards'][$c->awardrec_id]['award'] = $award['award_name'];
					$data['character']['awards'][$c->awardrec_id]['reason'] = $c->awardrec_reason;
					$data['character']['awards'][$c->awardrec_id]['date'] = mdate($this->options['date_format'], $date);
					$data['character']['awards'][$c->awardrec_id]['image'] = array(
						'src' => asset_location('images/awards', $award['award_image']),
						'alt' => '',
						'class' => 'image award-small'
					);
				}
			}
			
			if (!empty($info->user))
			{
				$where = array(
					'awardrec_character' => 0
				);
				
				$userawards = $this->awards->get_user_awards($info->user, 0, $where);
				
				if ($userawards->num_rows() > 0)
				{
					foreach ($userawards->result() as $p)
					{
						$date = gmt_to_local($p->awardrec_date, $this->timezone, $this->dst);
						
						$data['user']['awards'][$p->awardrec_id]['id'] = $p->awardrec_id;
						$data['user']['awards'][$p->awardrec_id]['award'] = $p->award_name;
						$data['user']['awards'][$p->awardrec_id]['reason'] = $p->awardrec_reason;
						$data['user']['awards'][$p->awardrec_id]['date'] = mdate($this->options['date_format'], $date);
						$data['user']['awards'][$p->awardrec_id]['image'] = array(
							'src' => asset_location('images/awards', $p->award_image),
							'alt' => '',
							'class' => 'image award-small'
						);
					}
				}
			}
			
			$data['inputs'] = array(
				'reason' => array(
					'name' => 'reason',
					'id' => 'reason',
					'rows' => 6),
			);
			
			$name = array(
				$this->ranks->get_rank($info->rank, 'rank_name'),
				$info->first_name,
				$info->middle_name,
				$info->last_name,
				$info->suffix
			);
			
			$data['name'] = parse_name($name);
			$data['id'] = $id;
		}
		
		$data['header'] = ucwords(lang('actions_give') .'/'. ucfirst(lang('actions_remove')) .' '. lang('global_awards'));
		
		$data['images'] = array(
			'remove' => array(
				'src' => img_location('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_remove'),
				'title' => ucfirst(lang('actions_remove')),
				'class' => 'image'),
			'loading' => array(
				'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_loading') .'...')),
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		$data['label'] = array(
			'active' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'all' => ucwords(lang('labels_all') .' '. lang('actions_received') .' '. lang('global_awards')),
			'award' => ucfirst(lang('global_award')),
			'awardee' => ucfirst(lang('global_character')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_character') .' '. lang('labels_list')),
			'character' => ucfirst(lang('global_character')),
			'choose' => ucfirst(lang('labels_please') .' '. lang('actions_choose')
				.' '. lang('labels_an') .' '. lang('global_award')),
			'give' => ucwords(lang('actions_give') .' '. lang('global_awards')),
			'given' => ucfirst(lang('actions_given') .' '. lang('labels_on')),
			'inactive' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'ic' => ucwords(lang('labels_ic') .' '. lang('global_awards')),
			'no_awards' => lang('error_no_awards'),
			'no_awards_to_give' => lang('error_no_awards_to_give'),
			'nochars' => ucfirst(lang('labels_no') .' '. lang('global_characters') .' '. lang('labels_to') .' '. lang('labels_display')),
			'npc' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
			'ooc' => ucwords(lang('labels_ooc') .' '. lang('global_awards')),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_awards', $this->skin, 'admin');
		$js_loc = js_location('characters_awards_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function bio()
	{
		$this->auth->check_access();
		
		/* grab the level and character ID */
		$data['level'] = $this->auth->get_access_level();
		$data['id'] = $this->uri->segment(3, FALSE, TRUE);
		
		/*
		 * level 1 - edit own characters
		 * level 2 - edit own characters and npcs
		 * level 3 - edit all characters
		 */
		if ($data['level'] == 1 && !in_array($data['id'], $this->session->userdata('characters')) ||
				$data['level'] == 2 && (!in_array($data['id'], $this->session->userdata('characters')) ||
				$this->char->get_character($data['id'], 'crew_type') != 'npc'))
		{
			redirect('admin/error/1');
		}
		
		/* load the resources */
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('directory');
		
		if (isset($_POST['submit']))
		{
			/* get the user ID and figure out if it should be NULL or not */
			$user = $this->char->get_character($data['id'], array('user', 'crew_type'));
			$p = (empty($user['user'])) ? NULL : $user['user'];
			
			foreach ($_POST as $key => $value)
			{
				if (is_numeric($key))
				{
					/* build the array */
					$array['fields'][$key] = array(
						'data_field' => $key,
						'data_char' => $data['id'],
						'data_user' => $p,
						'data_value' => $value,
						'data_updated' => now()
					);
				}
				else
				{
					$array['character'][$key] = $value;
				}
			}
			
			$position1_old = $array['character']['position_1_old'];
			$position2_old = $array['character']['position_2_old'];
			
			/* get rid of the submit button data and old position refs */
			unset($array['character']['submit']);
			unset($array['character']['position_1_old']);
			unset($array['character']['position_2_old']);
			
			if ($array['character']['crew_type'] == 'inactive' && $user['crew_type'] != 'inactive')
			{ /* set the deactivate date */
				$array['character']['date_deactivate'] = now();
			}
			
			if ($array['character']['crew_type'] != 'inactive' && $user['crew_type'] == 'inactive')
			{ /* wipe out the deactivate date if they're being reactivated */
				$array['character']['date_deactivate'] = NULL;
			}
			
			/* update the characters table */
			$update = $this->char->update_character($data['id'], $array['character']);
			
			foreach ($array['fields'] as $k => $v)
			{
				$update += $this->char->update_character_data($k, $data['id'], $v);
			}
			
			if ($update > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_character')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
				
				/* update the positions */
				if ($array['character']['position_1'] != $position1_old)
				{
					$posnew = $this->pos->get_position($array['character']['position_1']);
					$posold = $this->pos->get_position($position1_old);
					
					if ($posnew !== FALSE)
					{
						/* build the update array */
						$position_update['new'] = array('pos_open' => ($posnew->pos_open == 0) ? 0 : ($posnew->pos_open - 1));
						
						/* update the new position */
						$posnew_update = $this->pos->update_position($array['character']['position_1'], $position_update['new']);
					}
					
					if ($posold !== FALSE)
					{
						/* build the update array */
						$position_update['old'] = array('pos_open' => $posold->pos_open + 1);
						
						/* update the new position */
						$posold_update = $this->pos->update_position($position1_old, $position_update['old']);
					}
				}
				
				if ($array['character']['position_2'] != $position2_old)
				{
					$posnew = $this->pos->get_position($array['character']['position_2']);
					$posold = $this->pos->get_position($position2_old);
					
					if ($posnew !== FALSE)
					{
						/* build the update array */
						$position_update['new'] = array('pos_open' => ($posnew->pos_open == 0) ? 0 : ($posnew->pos_open - 1));
						
						/* update the new position */
						$posnew_update = $this->pos->update_position($array['character']['position_2'], $position_update['new']);
					}
					
					if ($posold !== FALSE)
					{
						/* build the update array */
						$position_update['old'] = array('pos_open' => $posold->pos_open + 1);
						
						/* update the new position */
						$posold_update = $this->pos->update_position($position2_old, $position_update['old']);
					}
				}
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_character')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		if ($data['id'] === FALSE && count($this->session->userdata('characters')) > 1)
		{
			/* load the resources */
			$this->load->helper('utility');
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_bio'));
			
			foreach ($this->session->userdata('characters') as $c)
			{
				$character = $this->char->get_character($c);
				
				$name = array(
					$this->ranks->get_rank($character->rank, 'rank_name'),
					$character->first_name,
					$character->middle_name,
					$character->last_name,
					$character->suffix
				);
				
				$data['characters'][$character->crew_type][$c] = parse_name($name);
			}
		}
		else
		{
			$data['id'] = $this->session->userdata('main_char');
			
			/* grab the character info */
			$char = $this->char->get_character($data['id']);
			
			/* grab the join fields */
			$sections = $this->char->get_bio_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$sid = $sec->section_id; /* section id */
					
					/* set the section name */
					$data['join'][$sid]['name'] = $sec->section_name;
					
					/* grab the fields for the given section */
					$fields = $this->char->get_bio_fields($sec->section_id);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$f_id = $field->field_id; /* field id */
							
							/* set the page label */
							$data['join'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
							
							$info = $this->char->get_field_data($field->field_id, $data['id']);
							$row = ($info->num_rows() > 0) ? $info->row() : FALSE;
							
							switch ($field->field_type)
							{
								case 'text':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => ($row !== FALSE) ? $row->data_value : '',
									);
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_input($input);
									
									break;
									
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => ($row !== FALSE) ? $row->data_value : '',
										'rows' => $field->field_rows
									);
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
									
									break;
									
								case 'select':
									$value = FALSE;
									$values = FALSE;
									$input = FALSE;
								
									$values = $this->char->get_bio_values($field->field_id);
									$data_val = ($row !== FALSE) ? $row->data_value : '';
									
									if ($values->num_rows() > 0)
									{
										foreach ($values->result() as $value)
										{
											$input[$value->value_field_value] = $value->value_content;
										}
									}
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input, $data_val);
									break;
							}
						}
					}
				}
			}
			
			$pos1 = $this->pos->get_position($char->position_1);
			$pos2 = $this->pos->get_position($char->position_2);
			$rank = $this->ranks->get_rank($char->rank);
			$rankcat = $this->ranks->get_rankcat($this->rank);
			
			/* inputs */
			$data['inputs'] = array(
				'first_name' => array(
					'name' => 'first_name',
					'id' => 'first_name',
					'value' => $char->first_name),
				'middle_name' => array(
					'name' => 'middle_name',
					'id' => 'middle_name',
					'value' => $char->middle_name),
				'last_name' => array(
					'name' => 'last_name',
					'id' => 'last_name',
					'value' => $char->last_name),
				'suffix' => array(
					'name' => 'suffix',
					'id' => 'suffix',
					'class' => 'medium',
					'value' => $char->suffix),
				'position1_id' => $char->position_1,
				'position2_id' => $char->position_2,
				'position1_name' => ($pos1 !== FALSE) ? $pos1->pos_name : '',
				'position2_name' => ($pos2 !== FALSE) ? $pos2->pos_name : '',
				'position1_desc' => ($pos1 !== FALSE) ? $pos1->pos_desc : '',
				'position2_desc' => ($pos2 !== FALSE) ? $pos2->pos_desc : '',
				'rank_id' => $char->rank,
				'rank_name' => $rank->rank_name,
				'rank' => array(
					'src' => rank_location($this->rank, $rank->rank_image, $rankcat->rankcat_extension),
					'alt' => $rank->rank_name,
					'class' => 'image'),
				'crew_type' => $char->crew_type,
				'images' => array(
					'name' => 'images',
					'id' => 'images',
					'rows' => 4,
					'value' => $char->images),
			);
			
			$data['values']['crew_type'] = array(
				'active' => ucwords(lang('status_playing') .' '. lang('global_character')),
				'npc' => ucwords(lang('status_nonplaying') .' '. lang('global_character')),
				'inactive' => ucwords(lang('status_inactive') .' '. lang('global_character')),
				'pending' => ucwords(lang('status_pending') .' '. lang('global_character')),
			);
			
			$data['directory'] = array();
			
			$dir = $this->sys->get_uploaded_images('bio');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					if ($d->upload_user == $this->session->userdata('userid'))
					{
						$data['myuploads'][$d->upload_id] = array(
							'image' => array(
								'src' => asset_location('images/characters', $d->upload_filename),
								'alt' => $d->upload_filename,
								'class' => 'image image-height-100'),
							'file' => $d->upload_filename,
							'id' => $d->upload_id
						);
					}
					else
					{
						$data['directory'][$d->upload_id] = array(
							'image' => array(
								'src' => asset_location('images/characters', $d->upload_filename),
								'alt' => $d->upload_filename,
								'class' => 'image image-height-100'),
							'file' => $d->upload_filename,
							'id' => $d->upload_id
						);
					}
				}
			}
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_bio')) .' - '. $this->char->get_character_name($data['id']);
		}
			
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('labels_bio')
		);
		
		/* submit button */
		$data['button'] = array(
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
				'alt' => lang('actions_loading'),
				'class' => 'image'),
			'upload' => array(
				'src' => img_location('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'character' => ucfirst(lang('global_character')),
			'choose_char' => ucwords(lang('actions_choose') .' '. lang('labels_a') .' '. lang('global_character') .' '. lang('labels_to')
				.' '. lang('actions_edit')),
			'fname' => ucwords(lang('order_first') .' '. lang('labels_name')),
			'images' => ucfirst(lang('labels_images')),
			'info' => ucfirst(lang('labels_info')),
			'lname' => ucwords(lang('order_last') .' '. lang('labels_name')),
			'mname' => ucwords(lang('order_middle') .' '. lang('labels_name')),
			'myuploads' => ucwords(lang('labels_my') .' '. lang('labels_uploads')),
			'other' => ucfirst(lang('labels_other')),
			'position1' => ucwords(lang('order_first') .' '. lang('global_position')),
			'position2' => ucwords(lang('order_second') .' '. lang('global_position')),
			'rank' => ucfirst(lang('global_rank')),
			'suffix' => ucfirst(lang('labels_suffix')),
			'type' => ucwords(lang('global_character') .' '. lang('labels_type')),
			'type_active' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'type_inactive' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'type_npc' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_bio', $this->skin, 'admin');
		$js_loc = js_location('characters_bio_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function coc()
	{
		$this->auth->check_access();
		
		/* get the chain of command listing */
		$coc = $this->char->get_coc();
		
		if ($coc->num_rows() > 0)
		{
			foreach ($coc->result() as $c)
			{
				$data['coc'][$c->coc_crew] = $this->char->get_character_name($c->coc_crew, TRUE);
			}
		}
		
		$data['header'] = lang('labels_coc');
		$data['text'] = lang('text_manage_coc');
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'content' => ucwords(lang('actions_update'))),
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'add',
				'id' => 'add',
				'content' => ucwords(lang('actions_add'))),
		);
		
		$data['loading'] = array(
			'src' => img_location('loading-bar.gif', $this->skin, 'admin'),
			'alt' => '',
			'class' => 'image'
		);
		
		$data['label'] = array(
			'processing' => ucfirst(lang('actions_processing')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_coc', $this->skin, 'admin');
		$js_loc = js_location('characters_coc_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function create()
	{
		$this->auth->check_access();
		
		/* grab the level and character ID */
		$level = $this->auth->get_access_level();
		
		/* load the resources */
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('applications_model', 'apps');
		$this->load->helper('utility');
		
		if (isset($_POST['submit']))
		{
			foreach ($_POST as $key => $value)
			{
				if (is_numeric($key))
				{
					/* build the array */
					$array['fields'][$key] = array(
						'data_field' => $key,
						'data_value' => $value,
						'data_updated' => now()
					);
				}
				else
				{
					if ($key == 'type')
					{
						if ($value == 'npc')
						{
							$array['character']['crew_type'] = 'npc';
						}
						else
						{
							if ($level == 2 && $value == 'pc')
							{
								$array['character']['crew_type'] = 'active';
							}
							else
							{
								$array['character']['user'] = $this->session->userdata('userid');
								$array['character']['crew_type'] = 'pending';
							}
						}
					}
					else
					{
						$array['character'][$key] = $value;
					}
				}
			}
			
			/* get rid of the submit button data and the type value */
			unset($array['character']['submit']);
			
			/* create the character record and grab the insert ID */
			$update = $this->char->create_character($array['character']);
			$cid = $this->db->insert_id();
			
			/* optimize the database */
			$this->sys->optimize_table('characters');
			
			if ($array['character']['crew_type'] == 'active' || $array['character']['crew_type'] == 'pending')
			{
				$name = array(
					$array['character']['first_name'],
					$array['character']['middle_name'],
					$array['character']['last_name'],
					$array['character']['suffix'],
				);
				
				$a_update = array(
					'app_character' => $cid,
					'app_character_name' => parse_name($name),
					'app_position' => $this->pos->get_position($array['character']['position_1'], 'pos_name'),
					'app_date' => now(),
					'app_action' => ($array['character']['crew_type'] == 'pending') ? '' : 'created',
				);
				
				$this->apps->insert_application($a_update);
			}
			
			/* create the fields in the data table */
			$create = $this->char->create_character_data_fields($cid, NULL);
			
			foreach ($array['fields'] as $k => $v)
			{
				$update += $this->char->update_character_data($k, $cid, $v);
			}
			
			if ($update > 0)
			{
				if ($array['character']['crew_type'] == 'pending')
				{
					$user = $this->user->get_user($array['character']['user']);
					
					$gm_data = array(
						'email' => $user->email,
						'name' => $user->name,
						'id' => $cid,
						'user' => $array['character']['user']
					);
					
					/* execute the email method */
					$email_gm = ($this->options['system_email'] == 'on') ? $this->_email('pending', $gm_data) : FALSE;
				}
					
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_character')),
					lang('actions_created'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_character')),
					lang('actions_created'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		/* grab the join fields */
		$sections = $this->char->get_bio_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$sid = $sec->section_id; /* section id */
				
				/* set the section name */
				$data['join'][$sid]['name'] = $sec->section_name;
				
				/* grab the fields for the given section */
				$fields = $this->char->get_bio_fields($sec->section_id);
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						$f_id = $field->field_id; /* field id */
						
						/* set the page label */
						$data['join'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
						
						switch ($field->field_type)
						{
							case 'text':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => '',
								);
								
								$data['join'][$sid]['fields'][$f_id]['input'] = form_input($input);
								
								break;
								
							case 'textarea':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => '',
									'rows' => $field->field_rows
								);
								
								$data['join'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
								
								break;
								
							case 'select':
								$value = FALSE;
								$values = FALSE;
								$input = FALSE;
							
								$values = $this->char->get_bio_values($field->field_id);
								
								if ($values->num_rows() > 0)
								{
									foreach ($values->result() as $value)
									{
										$input[$value->value_field_value] = $value->value_content;
									}
								}
								
								$data['join'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input);
								break;
						}
					}
				}
			}
		}
		
		$rank = $this->ranks->get_rank(1);
		$rankcat = $this->ranks->get_rankcat($this->rank, 'rankcat_location');
		
		/* inputs */
		$data['inputs'] = array(
			'first_name' => array(
				'name' => 'first_name',
				'id' => 'first_name',
				'value' => ''),
			'middle_name' => array(
				'name' => 'middle_name',
				'id' => 'middle_name',
				'value' => ''),
			'last_name' => array(
				'name' => 'last_name',
				'id' => 'last_name',
				'value' => ''),
			'suffix' => array(
				'name' => 'suffix',
				'id' => 'suffix',
				'class' => 'medium',
				'value' => ''),
			'position1_id' => 0,
			'position2_id' => 0,
			'position1_name' => '',
			'position2_name' => '',
			'position1_desc' => '',
			'position2_desc' => '',
			'rank_id' => 0,
			'rank' => array(
				'src' => rank_location($this->rank, $rank->rank_image, $rankcat->rankcat_extension),
				'alt' => $rank->rank_name,
				'class' => 'image'),
		);
		
		$data['type'] = array(
			'pc' => ucwords(lang('status_playing') .' '. lang('global_character')),
			'npc' => ucwords(lang('status_nonplaying') .' '. lang('global_character')),
		);
		
		$data['header'] = ucwords(lang('actions_create') .' '. lang('global_character'));
		
		/* submit button */
		$data['button'] = array(
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
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'character' => ucfirst(lang('global_character')),
			'fname' => ucwords(lang('order_first') .' '. lang('labels_name')),
			'lname' => ucwords(lang('order_last') .' '. lang('labels_name')),
			'mname' => ucwords(lang('order_middle') .' '. lang('labels_name')),
			'other' => ucfirst(lang('labels_other')),
			'position1' => ucwords(lang('order_first') .' '. lang('global_position')),
			'position2' => ucwords(lang('order_second') .' '. lang('global_position')),
			'rank' => ucfirst(lang('global_rank')),
			'suffix' => ucfirst(lang('labels_suffix')),
			'type' => ucwords(lang('global_character') .' '. lang('labels_type'))
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_create', $this->skin, 'admin');
		$js_loc = js_location('characters_create_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function npcs()
	{
		$this->auth->check_access();
		
		/* set the level variable */
		$level = $this->auth->get_access_level();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					/* get the user id */
					$userid = $this->char->get_character($id, 'user');
					
					if ($userid !== FALSE)
					{
						/* grab the user data */
						$user = $this->user->get_user($userid);
						
						/* temp variable for setting a new main character */
						$newmain = NULL;
						
						if ($user !== FALSE)
						{
							$characters = $user->characters;
							$main = $user->main_char;
							
							if (strstr($characters, $id) !== FALSE)
							{ /* if the ID is in the characters string, remove it */
								$carray = explode(',', $characters);
								
								foreach ($carray as $key => $value)
								{
									if ($value == $id)
									{
										unset($carray[$key]);
									}
									else
									{ /* if we're removing a main character, replace it with the first active one */
										$type = $this->char->get_character($value, 'crew_type');
										
										if ($type == 'active' && is_null($newmain))
										{
											$newmain = $value;
										}
									}
								}
								
								$newchars = implode(',', $carray);
							}
							else
							{
								$newchars = $characters;
							}
							
							/* set the array to update the users table */
							$update_array = array(
								'characters' => $newchars,
								'main_char' => ($main == $id) ? $newmain : $main
							);
							
							$update = $this->user->update_user($userid, $update_array);
						}
					}
					
					/* delete the data from the data table */
					$delete = $this->char->delete_character_data($id, 'data_char');
					
					/* delete the data from the characters table */
					$delete += $this->char->delete_character($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_character')),
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
							ucfirst(lang('global_character')),
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
		
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		switch ($level)
		{
			case 1:
				/* get the user's main character information */
				$me = $this->char->get_character($this->session->userdata('main_char'));
				
				/* grab the department their primary position is in */
				$dept = $this->pos->get_position($me->position_1, 'pos_dept');
				
				/* get an array of department positions */
				$positions = $this->pos->get_dept_positions($dept, 'y', 'array');
				
				/* get the department info */
				$depts = $this->dept->get_dept($dept);
				
				/* build the array of departments */
				$data['characters'][$depts->dept_id]['dept'] = $depts->dept_name;
				
				/* get all the NPCs */
				$all = $this->char->get_all_characters('npc');
				
				break;
				
			case 2:
				/* get the user's main character information */
				$me = $this->char->get_character($this->session->userdata('main_char'));
				
				/* grab the department their primary position is in */
				$dept[] = $this->pos->get_position($me->position_1, 'pos_dept');
				
				if (!empty($me->position_2))
				{
					$dept[] = $this->pos->get_position($me->position_2, 'pos_dept');
				}
				
				/* set up an empty positions array */
				$positions = array();
				
				foreach ($dept as $d)
				{
					/* pull the positions */
					$array = $this->pos->get_dept_positions($d, 'y', 'array');
					
					/* merge the array onto what's already there */
					$positions = array_merge($positions, $array);
					
					/* get the department info */
					$depts = $this->dept->get_dept($d);
					
					/* build the array of departments */
					$data['characters'][$d]['dept'] = $depts->dept_name;
				}
				
				/* get all the NPCs */
				$all = $this->char->get_all_characters('npc');
				
				break;
				
			case 3:
				/* get all the departments */
				$depts = $this->dept->get_all_depts('asc', '');
				
				/* put the departments into an array */
				if ($depts->num_rows() > 0)
				{
					foreach ($depts->result() as $d)
					{
						$data['characters'][$d->dept_id]['dept'] = $d->dept_name;
					}
				}
				
				/* get all the NPCs */
				$all = $this->char->get_all_characters('npc');
				
				break;
		}
		
		$data['count'] = 0;
		
		if ($all->num_rows() > 0)
		{
			foreach ($all->result() as $a)
			{
				/* build an array of their name */
				$name = array(
					($a->crew_type != 'pending') ? $this->ranks->get_rank($a->rank, 'rank_name') : '',
					$a->first_name,
					$a->middle_name,
					$a->last_name,
					$a->suffix
				);
				
				if ($level == 1)
				{
					$cdept = $dept;
				}
				elseif ($level == 2)
				{
					$pos = $this->pos->get_position($a->position_1);
					
					if (array_key_exists($pos->pos_dept, $data['characters']) === FALSE)
					{
						$cdept = $this->pos->get_position($a->position_2, 'pos_dept');
					}
					else
					{
						$cdept = $pos->pos_dept;
					}
				}
				elseif ($level == 3)
				{
					$pos = $this->pos->get_position($a->position_1);
					
					if (array_key_exists($pos->pos_dept, $data['characters']) === FALSE)
					{
						$cdept = $this->dept->get_dept($pos->pos_dept, 'dept_parent');
					}
					else
					{
						$cdept = $pos->pos_dept;
					}
				}
				
				/* get the user info */
				$p = $this->user->get_user($a->user, array('status', 'email'));
				
				if (
					(($level == 1 || $level == 2) && (in_array($a->position_1, $positions) || in_array($a->position_2, $positions))) || 
					($level == 3)
				)
				{
					$data['characters'][$cdept]['chars'][$a->charid] = array(
						'id' => $a->charid,
						'uid' => $a->user,
						'name' => parse_name($name),
						'position_1' => $pos->pos_name,
						'position_2' => (!empty($a->position_2)) ? $this->pos->get_position($a->position_2, 'pos_name') : '',
						'pstatus' => $p['status'],
						'email' => $p['email']
					);
				}
				
				++$data['count'];
			}
		}
		
		/* sort the keys */
		ksort($data['characters']);
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('abbr_npcs'));
		
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
			'add' => array(
				'src' => img_location('user-add.png', $this->skin, 'admin'),
				'alt' => lang('actions_create'),
				'title' => ucfirst(lang('actions_create')),
				'class' => 'image inline_img_left'),
			'account' => array(
				'src' => img_location('user-account.png', $this->skin, 'admin'),
				'alt' => lang('labels_account'),
				'title' => ucfirst(lang('labels_account')),
				'class' => 'image'),
		);
		
		$data['levelcheck'] = array(
			'account' => $this->auth->get_access_level('user/account'),
			'bio' => $this->auth->get_access_level('characters/bio'),
		);
		
		$data['label'] = array(
			'create' => ucwords(lang('actions_create') .' '. lang('status_new') .' '. 
				lang('global_character') .' '. RARROW),
			'loading' => ucfirst(lang('actions_loading') .'...'),
			'noactive' => ucfirst(lang('labels_no') .' '. lang('status_active')
				.' '. lang('status_nonplaying') .' '. lang('global_characters') .' '. lang('actions_found')),
			'nouser' => ucfirst(lang('labels_no') .' '. lang('global_user')
				.' '. lang('actions_assigned') .'!'),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('characters_npcs', $this->skin, 'admin');
		$js_loc = js_location('characters_npcs_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function _email($type = '', $data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* load the language file */
		$this->lang->load('email');
		
		/* define the variables */
		$email = FALSE;
		
		switch ($type)
		{
			case 'accept':
				$cc = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_character_approved') .' - '. $data['character'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = email_location('character_action', $this->email->mailtype);
				
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				$this->email->from($data['email'], $data['name']);
				$this->email->to($data['email']);
				$this->email->cc($cc);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'reject':
				$cc = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_character_rejected') .' - '. $data['character'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = email_location('character_action', $this->email->mailtype);
				
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				$this->email->from($data['email'], $data['name']);
				$this->email->to($data['email']);
				$this->email->cc($cc);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'pending':
				/* load the models */
				$this->load->model('positions_model', 'pos');
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_join_gm'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br(lang('email_content_join_gm'))
				);
				
				$email_data['basic_title'] = lang('tabs_user_basic');
				
				/* build the user data array */
				$p_data = $this->user->get_user($data['user']);
				
				$email_data['user'] = array(
					array(
						'label' => lang('labels_name'),
						'data' => $data['name']),
					array(
						'label' => lang('labels_email_address'),
						'data' => $data['email']),
					array(
						'label' => lang('labels_dob'),
						'data' => $p_data->date_of_birth)
				);
				
				/* build the character data array */
				$c_data = $this->char->get_character($data['id']);
				
				$email_data['character'] = array(
					array(
						'label' => ucwords(lang('global_character') .' '. lang('labels_name')),
						'data' => $this->char->get_character_name($data['id'])),
					array(
						'label' => ucfirst(lang('global_position')),
						'data' => $this->pos->get_position($c_data->position_1, 'pos_name')),
				);
				
				/* get the sections */
				$sections = $this->char->get_bio_sections();
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $sec)
					{ /* drop the section name in */
						$email_data['sections'][$sec->section_id]['title'] = $sec->section_name;
						
						/* get the section fields */
						$fields = $this->char->get_bio_fields($sec->section_id);
						
						if ($fields->num_rows() > 0)
						{
							foreach ($fields->result() as $field)
							{ /* get the data for each field */
								$bio_data = $this->char->get_field_data($field->field_id, $data['id']);
								
								if ($bio_data->num_rows() > 0)
								{
									foreach ($bio_data->result() as $item)
									{ /* put the data into an array */
										$email_data['sections'][$sec->section_id]['fields'][] = array(
											'field' => $field->field_label_page,
											'data' => text_output($item->data_value, '')
										);
									}
								}
							}
						}
					}
				}
				
				/* where should the email be coming from */
				$em_loc = email_location('main_join_gm', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* get the game masters email addresses */
				$gm = $this->user->get_gm_emails();
				
				/* set the TO variable */
				$to = implode(',', $gm);
				
				/* set the parameters for sending the email */
				$this->email->from($data['email'], $data['name']);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
}

/* End of file characters_base.php */
/* Location: ./application/controllers/characters_base.php */