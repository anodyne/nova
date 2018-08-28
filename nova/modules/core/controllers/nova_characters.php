<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Characters controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_characters extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('applications_model', 'apps');
		$this->load->model('depts_model', 'dept');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('access_model', 'access');
		$this->load->helper('utility');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// get the user id
					$userid = $this->char->get_character($id, array('user', 'crew_type'));
					
					if ($userid !== false)
					{
						// grab the user data
						$user = $this->user->get_user($userid['user']);
						
						// temp variable for setting a new main character
						$newmain = null;
						
						if ($user !== false)
						{
							$characters = implode(',', $this->session->userdata('characters'));
							$main = $user->main_char;
							
							if (strstr($characters, $id) !== false)
							{
								$carray = explode(',', $characters);
								
								foreach ($carray as $key => $value)
								{
									if ($value == $id)
									{
										unset($carray[$key]);
									}
									else
									{
										$type = $this->char->get_character($value, 'crew_type');
										
										if ($type == 'active' and is_null($newmain))
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
							
							if ($userid['crew_type'] == 'active')
							{
								// get the character
								$char = $this->char->get_character($id);
								
								// update the slots
								if ($char->position_1 !== null and $char->position_1 > 0)
								{
									$this->pos->update_open_slots($char->position_1, 'remove_crew');
								}
								
								if ($char->position_2 !== null and $char->position_2 > 0)
								{
									$this->pos->update_open_slots($char->position_2, 'remove_crew');
								}
							}
							
							// set the array to update the users table
							$update_array = array('main_char' => ($main == $id) ? $newmain : $main);
							
							$update = $this->user->update_user($userid['user'], $update_array);
						}
						
						if ($userid['crew_type'] == 'pending')
						{
							$this->load->model('applications_model', 'apps');
							
							$a_update = array('app_action' => 'deleted');
							
							$app_update = $this->apps->update_application($id, $a_update);
						}
					}
					
					// delete the data from the data table
					$delete = $this->char->delete_character_data($id, 'data_char');
					
					// delete the data from the characters table
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
				break;
					
				case 'pending':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					$action = $this->input->post('action', true);
					
					$info = $this->char->get_character($id);
					$user = $this->user->get_user($info->user);
					$characters = $this->char->get_user_characters($info->user, 'active', 'array');
					$count = count($characters);
					
					if ($action == 'approve')
					{
						$c_update = array(
							'position_1' => $this->input->post('position', true),
							'rank' => $this->input->post('rank', true),
							'crew_type' => 'active',
							'date_activate' => (empty($info->date_activate)) ? now() : $info->date_activate,
							'user' => ($count > $this->options['allowed_chars_playing']) ? null : $info->user,
						);
						
						$update = $this->char->update_character($id, $c_update);
						
						// grab the info about the position
						$pos = $this->pos->get_position($c_update['position_1']);
						
						// only update the slots if there's a legit position
						if ($pos !== false)
						{
							// set the proper number of open slots
							$open = ($pos->pos_open > 0) ? $pos->pos_open - 1 : 0;
							
							// make sure we're setting the new pos_open field
							$position_update = array('pos_open' => $open);
							
							// update the number of open slots for the position
							$pos_update = $this->pos->update_position($c_update['position_1'], $position_update);
						}
						
						// set the arguments for the message
						$args = array(
							'name' => ( ! empty($user->name)) ? $user->name : $user->email,
							'character' => $this->char->get_character_name($id),
							'position' => $this->pos->get_position($c_update['position_1'], 'pos_name'),
							'rank' => $this->ranks->get_rank($c_update['rank'], 'rank_name'),
							'sim' => $this->options['sim_name'],
							'ship' => $this->options['sim_name']
						);
						
						// parse the message with the args
						$content = parse_dynamic_message($this->input->post('accept', true), $args);
						
						if ($user->status != 'active')
						{
							$role = ($this->input->post('role') != false)
								? $this->input->post('role', true)
								: Access_Model::STANDARD;

							$p_update = array(
								'status' => 'active',
								'leave_date' => null,
								'access_role' => $role
							);
							
							$update += $this->user->update_user($user->userid, $p_update);
						}
						
						// update the applications table
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

							// Get the current user
							$currentUser = $this->user->get_user($this->session->userdata('userid'));
							
							$emailData = array(
								'message' 	=> $content,
								'email' 	=> $user->email,
								'name' 		=> $user->name,
								'character' => $args['character'],
								'fromEmail' => $currentUser->email,
								'fromName'	=> $this->char->get_character_name($this->session->userdata('charid'), true, true),
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('accept', $emailData) : false;
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
						{
							$delete += $this->user->delete_user($user->userid);
						}
						
						// set the arguments for the message
						$args = array(
							'name' => ( ! empty($user->name)) ? $user->name : $user->email,
							'character' => $this->char->get_character_name($id),
							'position' => $this->pos->get_position($info->position_1, 'pos_name'),
							'sim' => $this->options['sim_name'],
							'ship' => $this->options['sim_name']
						);
						
						// parse the message with the args
						$content = parse_dynamic_message($this->input->post('reject', true), $args);
						
						// update the applications table
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

							// Get the current user
							$currentUser = $this->user->get_user($this->session->userdata('userid'));
							
							$emailData = array(
								'message' 	=> $content,
								'email' 	=> $user->email,
								'name' 		=> $user->name,
								'character' => $args['character'],
								'fromEmail' => $currentUser->email,
								'fromName'	=> $this->char->get_character_name($this->session->userdata('charid'), true, true),
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('reject', $emailData) : false;
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
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
						$a->last_name,
						$a->suffix
					);
					
					$pos = $this->pos->get_position($a->position_1);
					
					if ($pos !== false and array_key_exists($pos->pos_dept, $data['characters']) === false)
					{
						$cdept = $this->dept->get_dept($pos->pos_dept, 'dept_parent');
					}
					else
					{
						$cdept = ($pos !== false) ? $pos->pos_dept : '';
					}
					
					$p = $this->user->get_user($a->user, array('status', 'email'));
					
					$data['characters'][$cdept]['chars'][$a->crew_type][$a->charid] = array(
						'id' => $a->charid,
						'uid' => $a->user,
						'name' => parse_name($name),
						'position_1' => ($pos !== false) ? $pos->pos_name : '',
						'position_2' => $this->pos->get_position($a->position_2, 'pos_name'),
						'pstatus' => $p['status'],
						'email' => $p['email']
					);
					
					++$data['count'][$a->crew_type];
				}
			}
		}
		
		// sort the keys
		ksort($data['characters']);
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('global_characters'));
		
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
			'approve' => array(
				'src' => Location::img('icon-check.png', $this->skin, 'admin'),
				'alt' => lang('actions_accept'),
				'title' => ucfirst(lang('actions_accept')),
				'class' => 'image'),
			'reject' => array(
				'src' => Location::img('icon-slash.png', $this->skin, 'admin'),
				'alt' => lang('actions_reject'),
				'title' => ucfirst(lang('actions_reject')),
				'class' => 'image'),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => lang('actions_create'),
				'title' => ucfirst(lang('actions_create')),
				'class' => 'image inline_img_left'),
			'new' => array(
				'src' => Location::img('icon-green-small.png', $this->skin, 'admin'),
				'alt' => lang('status_new'),
				'class' => 'image'),
			'account' => array(
				'src' => Location::img('gear.png', $this->skin, 'admin'),
				'alt' => lang('labels_account'),
				'title' => ucfirst(lang('labels_account')),
				'class' => 'image'),
			'assign' => array(
				'src' => Location::img('icon-star.png', $this->skin, 'admin'),
				'alt' => lang('actions_assign'),
				'title' => ucfirst(lang('actions_assign')),
				'class' => 'image'),
		);
		
		$data['levelcheck'] = array(
			'account' => Auth::get_access_level('user/account'),
			'bio' => Auth::get_access_level('characters/bio'),
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
			break;
		}
		
		$js_data['tab'] = ($data['count']['pending'] > 0) ? 2 : $js_data['tab'];
		
		$this->_regions['content'] = Location::view('characters_index', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_index_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function awards($id = false)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('awards_model', 'awards');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		if (isset($_POST['submit']))
		{
			// set the character ID and do some sanity checking
			$char = $this->input->post('id', true);
			$char = (is_numeric($char)) ? $char : false;
			
			// set the award id
			$award = $this->input->post('award', true);
			
			// get info about the award
			$info = $this->awards->get_award($award);
			
			// build the insert array
			$insert_array = array(
				'awardrec_award' => $award,
				'awardrec_character' => ($info->award_cat == 'ooc') ? 0 : $char,
				'awardrec_user' => $this->char->get_character($char, 'user'),
				'awardrec_reason' => $this->input->post('reason', true),
				'awardrec_date' => now(),
				'awardrec_nominated_by' => $this->session->userdata('main_char'),
			);
			
			// add the record to the database
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
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ( ! $id)
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
			
			// grab all the awards
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
			
			// get the character's awards
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
						'src' => Location::asset('images/awards', $award['award_image']),
						'alt' => '',
						'class' => 'image award-small'
					);
				}
			}
			
			if ( ! empty($info->user))
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
							'src' => Location::asset('images/awards', $p->award_image),
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
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_remove'),
				'title' => ucfirst(lang('actions_remove')),
				'class' => 'image'),
			'loading' => array(
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
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
			'no_awards' => sprintf(lang('error_not_found'), lang('global_awards')),
			'no_awards_to_give' => sprintf(lang('error_not_found'), lang('global_awards')),
			'nochars' => ucfirst(lang('labels_no') .' '. lang('global_characters') .' '. lang('labels_to') .' '. lang('labels_display')),
			'npc' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
			'ooc' => ucwords(lang('labels_ooc') .' '. lang('global_awards')),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		$this->_regions['content'] = Location::view('characters_awards', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_awards_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function bio($id = false)
	{
		Auth::check_access();
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		// grab the access level
		$level = Auth::get_access_level();
		$data['level'] = $level;
		
		if ( ! $id and count($this->session->userdata('characters')) > 1)
		{
			redirect('characters/select');
		}
		elseif ( ! $id and count($this->session->userdata('characters')) <= 1)
		{
			$id = $this->session->userdata('main_char');
		}
		
		$data['id'] = $id;
		
		$allowed = false;
		
		switch ($level)
		{
			case 1:
				$allowed = (in_array($id, $this->session->userdata('characters'))) ? true : false;
			break;
				
			case 2:
				$type = $this->char->get_character($data['id'], 'crew_type');
				
				if (in_array($id, $this->session->userdata('characters')) or $type == 'npc')
				{
					$allowed = true;
				}
			break;
				
			case 3:
				$allowed = true;
			break;
		}
		
		if ( ! $allowed)
		{
			redirect('admin/error/1');
		}
		
		// load the resources
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('access_model', 'access');
		$this->load->helper('directory');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(4))
			{
				default:
					// get the user ID and figure out if it should be null or not
					$user = $this->char->get_character($id, array('user', 'crew_type'));
					$p = (empty($user['user'])) ? null : $user['user'];

					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							// build the array
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

					if ($array['character']['first_name'] == "" and $array['character']['last_name'] == "")
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_charactername'),
							lang('actions_update'),
							lang('global_character')
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						// get rid of the submit button
						unset($array['character']['submit']);
						
						// get the character record
						$c = $this->char->get_character($id);
						
						if (($level == 2 and $c->crew_type == 'npc') or $level == 3)
						{
							$position1_old = $array['character']['position_1_old'];
							$position2_old = $array['character']['position_2_old'];
							$rank_old = $array['character']['rank_old'];
							
							// get rid of the submit button data and old position refs
							unset($array['character']['position_1_old']);
							unset($array['character']['position_2_old']);
							unset($array['character']['rank_old']);
							
							if ($array['character']['rank'] != $rank_old)
							{
								$oldR = $this->ranks->get_rank($rank_old, array('rank_order', 'rank_name'));
								$newR = $this->ranks->get_rank($array['character']['rank'], array('rank_order', 'rank_name'));
								
								$promotion = array(
									'prom_char' => $data['id'],
									'prom_user' => $this->char->get_character($data['id'], 'user'),
									'prom_date' => now(),
									'prom_old_order' => ($oldR['rank_order'] === null) ? 0 : $oldR['rank_order'],
									'prom_old_rank' => ($oldR['rank_name'] === null) ? '' : $oldR['rank_name'],
									'prom_new_order' => ($newR['rank_order'] === null) ? 0 : $newR['rank_order'],
									'prom_new_rank' => ($newR['rank_name'] === null) ? '' : $newR['rank_name'],
								);
								
								$prom = $this->char->create_promotion_record($promotion);
							}
							
							if ($level == 3)
							{
								if ($c->crew_type == 'active')
								{
									// if we've assigned a new position, update the open slots
									if ($array['character']['position_1'] != $position1_old)
									{
										$this->pos->update_open_slots($array['character']['position_1'], 'add_crew');
										$this->pos->update_open_slots($position1_old, 'remove_crew');
									}
									
									// if we've assigned a new position, update the open slots
									if ($array['character']['position_2'] != $position2_old)
									{
										$this->pos->update_open_slots($array['character']['position_2'], 'add_crew');
										$this->pos->update_open_slots($position2_old, 'remove_crew');
									}
								}
							}
						}
						
						// update the characters table
						$update = $this->char->update_character($data['id'], $array['character']);
						
						foreach ($array['fields'] as $k => $v)
						{
							$update += $this->char->update_character_data($k, $data['id'], $v);
						}
						
						$message = sprintf(
							($update > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_character')),
							lang('actions_updated'),
							''
						);
						$flash['status'] = ($update > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'activate':
					if ($level == 3)
					{
						// get the variables we'll be using
						$user = (isset($_POST['user'])) ? $_POST['user'] : false;
						$activate = (isset($_POST['activate_user'])) ? (bool) $this->input->post('activate_user') : false;
						$primary = (isset($_POST['primary'])) ? (bool) $this->input->post('primary', true) : false;
						
						// get the character
						$c = $this->char->get_character($id);
						
						if ($activate)
						{
							$user_update_data['status'] = 'active';
							$user_update_data['leave_date'] = null;
							$user_update_data['access_role'] = Access_Model::STANDARD;
							$user_update_data['last_update'] = now();
						}
						
						if ($primary)
						{
							$user_update_data['main_char'] = $id;
							$user_update_data['last_update'] = now();
						}
						
						// build the data for updating the character
						$character_update_data = array(
							'user' => $user,
							'crew_type' => 'active',
							'date_deactivate' => null,
						);
						
						// update the position listings
						$this->pos->update_open_slots($c->position_1, 'add_crew');
						
						if ($c->position_2 > 0 and $c->position_2 !== null)
						{
							$this->pos->update_open_slots($c->position_2, 'add_crew');
						}
						
						if (isset($user_update_data))
						{
							// update the user
							$update_user = $this->user->update_user($user, $user_update_data);
						}
						
						// update the character
						$update_char = $this->char->update_character($id, $character_update_data);
						
						$message = sprintf(
							($update_char > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_character')),
							lang('actions_activated'),
							''
						);
						$flash['status'] = ($update_char > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'deactivate':
					if ($level == 3)
					{
						// get the variables we'll be using
						$maincharacter = (isset($_POST['main_character'])) ? $_POST['main_character'] : false;
						$deactivate = (isset($_POST['deactivate_user'])) ? (bool) $this->input->post('deactivate_user') : false;
						
						// get the character
						$c = $this->char->get_character($id);
						
						if ($deactivate)
						{
							$user_update_data['status'] = 'inactive';
							$user_update_data['leave_date'] = now();
							$user_update_data['access_role'] = Access_Model::INACTIVE;
							$user_update_data['last_update'] = now();
						}
						
						if ($maincharacter)
						{
							$user_update_data['main_char'] = $maincharacter;
							$user_update_data['last_update'] = now();
						}
						
						// build the data for updating the character
						$character_update_data = array(
							'crew_type' => 'inactive',
							'date_deactivate' => now(),
						);
						
						// update the position listings
						$this->pos->update_open_slots($c->position_1, 'remove_crew');
						
						if ($c->position_2 > 0 and $c->position_2 !== null)
						{
							$this->pos->update_open_slots($c->position_2, 'remove_crew');
						}
						
						if (isset($user_update_data))
						{
							// update the user
							$update_user = $this->user->update_user($c->user, $user_update_data);
						}
						
						// update the character
						$update_char = $this->char->update_character($id, $character_update_data);
						
						$message = sprintf(
							($update_char > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_character')),
							lang('actions_deactivated'),
							''
						);
						$flash['status'] = ($update_char > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'makenpc':
					if ($level == 3)
					{
						// get the variables we'll be using
						$maincharacter = (isset($_POST['main_character'])) ? $_POST['main_character'] : false;
						$deactivate = (isset($_POST['deactivate_user'])) ? (bool) $this->input->post('deactivate_user') : false;
						$assoc = (isset($_POST['remove_user'])) ? (bool) $this->input->post('remove_user') : false;
						
						// get the character
						$c = $this->char->get_character($id);
						
						if ($deactivate)
						{
							$user_update_data['status'] = 'inactive';
							$user_update_data['leave_date'] = now();
							$user_update_data['access_role'] = Access_Model::INACTIVE;
							$user_update_data['last_update'] = now();
						}
						
						if ($maincharacter)
						{
							$user_update_data['main_char'] = $maincharacter;
							$user_update_data['last_update'] = now();
						}
						
						if ($assoc)
						{
							$character_update_data['user'] = null;
							$user_update_data['main_char'] = null;
						}
						
						// build the data for updating the character
						$character_update_data['crew_type'] = 'npc';
						
						// update the position listings
						$this->pos->update_open_slots($c->position_1, 'remove_crew');
						
						if ($c->position_2 > 0 and $c->position_2 !== null)
						{
							$this->pos->update_open_slots($c->position_2, 'remove_crew');
						}
						
						if (isset($user_update_data))
						{
							// update the user
							$update_user = $this->user->update_user($c->user, $user_update_data);
						}
						
						// update the character
						$update_char = $this->char->update_character($id, $character_update_data);
						
						$message = sprintf(
							($update_char > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_character')),
							lang('actions_updated'),
							''
						);
						$flash['status'] = ($update_char > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'makeplaying':
					if ($level == 3)
					{
						// get the variables we'll be using
						$maincharacter = (isset($_POST['main_character'])) ? $_POST['main_character'] : false;
						$user = (isset($_POST['user'])) ? $this->input->post('user') : false;
						
						// get the character
						$c = $this->char->get_character($id);
						
						// get the user we're going to
						$u = $this->user->get_user($user);
						
						if ($u->status == 'inactive')
						{
							$user_update_data['status'] = 'active';
							$user_update_data['leave_date'] = null;
							$user_update_data['last_update'] = now();
							$user_update_data['access_role'] = Access_Model::STANDARD;
						}
						
						if ($maincharacter)
						{
							$user_update_data['main_char'] = $id;
							$user_update_data['last_update'] = now();
						}
						
						// build the data for updating the character
						$character_update_data['crew_type'] = 'active';
						$character_update_data['user'] = $user;
						
						// update the position listings
						$this->pos->update_open_slots($c->position_1, 'add_crew');
						
						if ($c->position_2 > 0 and $c->position_2 !== null)
						{
							$this->pos->update_open_slots($c->position_2, 'add_crew');
						}
						
						if (isset($user_update_data))
						{
							// update the user
							$update_user = $this->user->update_user($user, $user_update_data);
						}
						
						// update the character
						$update_char = $this->char->update_character($id, $character_update_data);
						
						$message = sprintf(
							($update_char > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_character')),
							lang('actions_updated'),
							''
						);
						$flash['status'] = ($update_char > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab the character info
		$char = $this->char->get_character($id);
		
		// grab the join fields
		$sections = $this->char->get_bio_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$sid = $sec->section_id;
				
				// set the section name
				$data['join'][$sid]['name'] = $sec->section_name;
				
				// grab the fields for the given section
				$fields = $this->char->get_bio_fields($sec->section_id);
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						$f_id = $field->field_id;
						
						// set the page label and help
						$data['join'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
						$data['join'][$sid]['fields'][$f_id]['field_help'] = $field->field_help;
						
						$info = $this->char->get_field_data($field->field_id, $data['id']);
						$row = ($info->num_rows() > 0) ? $info->row() : false;
						
						switch ($field->field_type)
						{
							case 'text':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => ($row !== false) ? $row->data_value : '',
								);
								
								$data['join'][$sid]['fields'][$f_id]['input'] = form_input($input);
							break;
								
							case 'textarea':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => ($row !== false) ? $row->data_value : '',
									'rows' => $field->field_rows
								);
								
								$data['join'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
							break;
								
							case 'select':
								$value = false;
								$values = false;
								$input = false;
							
								$values = $this->char->get_bio_values($field->field_id);
								$data_val = ($row !== false) ? $row->data_value : '';
								
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
		
		// inputs
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
			'position1_name' => ($pos1 !== false) ? $pos1->pos_name : '',
			'position2_name' => ($pos2 !== false) ? $pos2->pos_name : '',
			'position1_desc' => ($pos1 !== false) ? $pos1->pos_desc : '',
			'position2_desc' => ($pos2 !== false) ? $pos2->pos_desc : '',
			'rank_id' => $char->rank,
			'rank_name' => ($rank !== false) ? $rank->rank_name : '',
			'rank' => array(
				'src' => ($rank !== false) ? Location::rank($this->rank, $rank->rank_image, $rankcat->rankcat_extension) : '',
				'alt' => ($rank !== false) ? $rank->rank_name : '',
				'class' => 'image'),
			'crew_type' => $char->crew_type,
			'images' => ( ! empty($char->images)) ? explode(',', $char->images) : '',
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
							'src' => Location::asset('images/characters', $d->upload_filename),
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
							'src' => Location::asset('images/characters', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
		}
		
		$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_bio')) .' - '. $this->char->get_character_name($data['id']);
			
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('labels_bio')
		);
		
		// submit button
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
			'use' => array(
				'type' => 'submit',
				'class' => 'button-sec add',
				'name' => 'use',
				'value' => 'use',
				'content' => ucwords(lang('actions_use') .' '. lang('labels_image'))),
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'rel' => $data['id'],
				'content' => ucwords(lang('actions_update'))),
			'activate' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'char-activate',
				'myid' => $id,
				'content' => ucwords(lang('actions_activate').' '.lang('global_character'))),
			'deactivate' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'char-deactivate',
				'myid' => $id,
				'content' => ucwords(lang('actions_deactivate').' '.lang('global_character'))),
			'npc' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'char-npc',
				'myid' => $id,
				'content' => ucwords(lang('actions_make').' '.strtoupper(lang('abbr_npc')))),
			'playing' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'char-playingchar',
				'myid' => $id,
				'content' => ucwords(lang('actions_make').' '.lang('status_playing').' '.lang('global_character'))),
		);
		
		$data['images'] = array(
			'loading' => array(
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
			'upload' => array(
				'src' => Location::img('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
			'loader' => array(
				'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'character' => ucfirst(lang('global_character')),
			'assignment' => ucfirst(lang('assignment')),
			'fname' => ucwords(lang('order_first') .' '. lang('labels_name')),
			'images' => ucfirst(lang('labels_images')),
			'info' => ucfirst(lang('labels_info')),
			'loading' => ucfirst(lang('actions_loading')) .'...',
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
			'change' => ucwords(lang('actions_change').' '.lang('global_character').' '.lang('labels_status')),
			'available_images' => ucwords(lang('labels_available').' '.lang('labels_images')),
			'character_images' => ucwords(lang('global_character').' '.lang('labels_images')),
			'back' => LARROW.' '.ucfirst(lang('labels_all').' '.lang('global_characters')),
		);
		
		$js_data['rankloc'] = $this->rank;
		$js_data['id'] = $data['id'];
		
		$this->_regions['content'] = Location::view('characters_bio', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_bio_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function coc()
	{
		Auth::check_access();
		
		// get the chain of command listing
		$coc = $this->char->get_coc();
		
		if ($coc->num_rows() > 0)
		{
			foreach ($coc->result() as $c)
			{
				$data['coc'][$c->coc_crew] = $this->char->get_character_name($c->coc_crew, true);
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
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => '',
			'class' => 'image'
		);
		
		$data['label'] = array(
			'processing' => ucfirst(lang('actions_processing')),
		);
		
		$this->_regions['content'] = Location::view('characters_coc', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_coc_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function create()
	{
		Auth::check_access();
		
		// grab the level and character ID
		$level = Auth::get_access_level();
		
		// load the resources
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
					// build the array
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
							if ($level == 2 and $value == 'pc')
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
			
			// get rid of the submit button data and the type value
			unset($array['character']['submit']);
			
			// create the character record and grab the insert ID
			$update = $this->char->create_character($array['character']);
			$cid = $this->db->insert_id();
			
			// optimize the database
			$this->sys->optimize_table('characters');
			
			if ($array['character']['crew_type'] == 'active' or $array['character']['crew_type'] == 'pending')
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
			
			// create the fields in the data table
			$create = $this->char->create_character_data_fields($cid);
			
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
					
					// execute the email method
					$email_gm = ($this->options['system_email'] == 'on') ? $this->_email('pending', $gm_data) : false;
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
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab the join fields
		$sections = $this->char->get_bio_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$sid = $sec->section_id;
				
				// set the section name
				$data['join'][$sid]['name'] = $sec->section_name;
				
				// grab the fields for the given section
				$fields = $this->char->get_bio_fields($sec->section_id);
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						$f_id = $field->field_id;
						
						// set the page label
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
								$value = false;
								$values = false;
								$input = false;
							
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
		
		// inputs
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
				'src' => Location::rank($this->rank, $rank->rank_image, $rankcat->rankcat_extension),
				'alt' => $rank->rank_name,
				'class' => 'image'),
		);
		
		$data['type'] = array(
			'pc' => ucwords(lang('status_playing') .' '. lang('global_character')),
			'npc' => ucwords(lang('status_nonplaying') .' '. lang('global_character')),
		);
		
		$data['header'] = ucwords(lang('actions_create') .' '. lang('global_character'));
		
		// submit button
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
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
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
		
		$js_data['rankloc'] = $this->rank;
		
		$this->_regions['content'] = Location::view('characters_create', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_create_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function npcs()
	{
		Auth::check_access();
		
		// set the level variable
		$level = Auth::get_access_level();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// get the user id
					$userid = $this->char->get_character($id, 'user');
					
					// delete the data from the data table
					$delete = $this->char->delete_character_data($id, 'data_char');
					
					// delete the data from the characters table
					$delete += $this->char->delete_character($id);
					
					if ($delete > 0)
					{
						$submsg = sprintf(
							lang('character_change'),
							($userid == $this->session->userdata('userid')) ? ucfirst(lang('labels_you')) : ucfirst(lang('labels_the') .' '. lang('global_user'))
						);
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_character')),
							lang('actions_deleted'),
							($userid == 0 or $userid === null or $userid === false) ? '' : ' '. $submsg
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// load the resources
		$this->load->model('depts_model', 'dept');
		$this->load->model('positions_model', 'pos');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		switch ($level)
		{
			case 1:
				// get the user's main character information
				$me = $this->char->get_character($this->session->userdata('main_char'));
				
				// grab the department their primary position is in
				$dept = $this->pos->get_position($me->position_1, 'pos_dept');
				
				// get an array of department positions
				$positions = $this->pos->get_dept_positions($dept, 'y', 'array');
				
				// get the department info
				$depts = $this->dept->get_dept($dept);
				
				// build the array of departments
				$data['characters'][$depts->dept_id]['dept'] = $depts->dept_name;
				
				// get all the NPCs
				$all = $this->char->get_all_characters('npc');
			break;
				
			case 2:
				// get the user's main character information
				$me = $this->char->get_character($this->session->userdata('main_char'));
				
				// grab the department their primary position is in
				$dept[] = $this->pos->get_position($me->position_1, 'pos_dept');
				
				if ( ! empty($me->position_2))
				{
					$dept[] = $this->pos->get_position($me->position_2, 'pos_dept');
				}
				
				// set up an empty positions array
				$positions = array();
				
				foreach ($dept as $d)
				{
					// pull the positions
					$array = $this->pos->get_dept_positions($d, 'y', 'array');
					
					// merge the array onto what's already there
					$positions = array_merge($positions, $array);
					
					// get the department info
					$depts = $this->dept->get_dept($d);
					
					// build the array of departments
					$data['characters'][$d]['dept'] = $depts->dept_name;
				}
				
				// get all the NPCs
				$all = $this->char->get_all_characters('npc');
			break;
				
			case 3:
				// get all the departments
				$depts = $this->dept->get_all_depts('asc', '');
				
				// put the departments into an array
				if ($depts->num_rows() > 0)
				{
					foreach ($depts->result() as $d)
					{
						$data['characters'][$d->dept_id]['dept'] = $d->dept_name;
					}
				}
				
				// get all the NPCs
				$all = $this->char->get_all_characters('npc');
			break;
		}
		
		$data['count'] = 0;
		
		if ($all->num_rows() > 0)
		{
			foreach ($all->result() as $a)
			{
				// build an array of their name
				$name = array(
					($a->crew_type != 'pending') ? $this->ranks->get_rank($a->rank, 'rank_name') : '',
					$a->first_name,
					$a->last_name,
					$a->suffix
				);
				
				$pos = $this->pos->get_position($a->position_1);
				
				if ($level == 1)
				{
					$cdept = $dept;
				}
				else
				{					
					if ($pos !== false and array_key_exists($pos->pos_dept, $data['characters']) === false)
					{
						$cdept = $this->dept->get_dept($pos->pos_dept, 'dept_parent');
					}
					else
					{
						$cdept = ($pos !== false) ? $pos->pos_dept : '';
					}
				}
				
				// get the user info
				$p = $this->user->get_user($a->user, array('status', 'email'));
				
				if (
					(($level == 1 or $level == 2) and (in_array($a->position_1, $positions) or in_array($a->position_2, $positions))) or 
					($level == 3)
				)
				{
					$data['characters'][$cdept]['chars'][$a->charid] = array(
						'id' => $a->charid,
						'uid' => $a->user,
						'name' => parse_name($name),
						'position_1' => ($pos !== false) ? $pos->pos_name : '',
						'position_2' => ( ! empty($a->position_2)) ? $this->pos->get_position($a->position_2, 'pos_name') : '',
						'pstatus' => $p['status'],
						'email' => $p['email']
					);
				}
				
				++$data['count'];
			}
		}
		
		// sort the keys
		ksort($data['characters']);
		
		$data['header'] = ucwords(lang('labels_all') .' '. lang('abbr_npcs'));
		
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
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => lang('actions_create'),
				'title' => ucfirst(lang('actions_create')),
				'class' => 'image inline_img_left'),
			'account' => array(
				'src' => Location::img('gear.png', $this->skin, 'admin'),
				'alt' => lang('labels_account'),
				'title' => ucfirst(lang('labels_account')),
				'class' => 'image'),
		);
		
		$data['levelcheck'] = array(
			'account' => Auth::get_access_level('user/account'),
			'bio' => Auth::get_access_level('characters/bio'),
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
		
		$this->_regions['content'] = Location::view('characters_npcs', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('characters_npcs_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function select()
	{
		// load the resources
		$this->load->helper('utility');
		$this->load->model('ranks_model', 'ranks');
		
		$data['header'] = ucwords(lang('actions_select') .' '. lang('global_character'));
		
		foreach ($this->session->userdata('characters') as $c)
		{
			$character = $this->char->get_character($c);
			
			$name = array(
				$this->ranks->get_rank($character->rank, 'rank_name'),
				$character->first_name,
				$character->last_name,
				$character->suffix
			);
			
			$data['characters'][$character->crew_type][$c] = parse_name($name);
		}
		
		$data['label'] = array(
			'choose_char' => ucwords(lang('actions_choose') .' '. lang('labels_a') .' '. lang('global_character') .' '. lang('labels_to')
				.' '. lang('actions_edit')),
			'type_active' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'type_inactive' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'type_npc' => ucwords(lang('status_nonplaying') .' '. lang('global_characters')),
		);
		
		$this->_regions['content'] = Location::view('characters_select', $this->skin, 'admin', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _email($type, $data)
	{
		// load the libraries
		$this->load->library('mail');
		$this->load->library('parser');
		
		// define the variables
		$email = false;
		
		switch ($type)
		{
			case 'accept':
				$cc = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_character_approved') .' - '. $data['character'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => ($this->mail->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = Location::email('character_action', $this->mail->mailtype);
				
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				$this->mail->from(Util::email_sender(), $data['name']);
				$this->mail->to($data['email']);
				$this->mail->cc($cc);
				$this->mail->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->mail->message($message);
			break;
				
			case 'reject':
				$cc = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_character_rejected') .' - '. $data['character'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => ($this->mail->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = Location::email('character_action', $this->mail->mailtype);
				
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				$this->mail->from(Util::email_sender(), $data['name']);
				$this->mail->to($data['email']);
				$this->mail->cc($cc);
				$this->mail->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->mail->message($message);
			break;
				
			case 'pending':
				// load the models
				$this->load->model('positions_model', 'pos');
				
				// create the array passing the data to the email
				$email_data = array(
					'email_subject' => lang('email_subject_join_gm'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br(lang('email_content_join_gm'))
				);
				
				$email_data['basic_title'] = lang('tabs_user_basic');
				
				// build the user data array
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
				
				// build the character data array
				$c_data = $this->char->get_character($data['id']);
				
				$email_data['character'] = array(
					array(
						'label' => ucwords(lang('global_character') .' '. lang('labels_name')),
						'data' => $this->char->get_character_name($data['id'])),
					array(
						'label' => ucfirst(lang('global_position')),
						'data' => $this->pos->get_position($c_data->position_1, 'pos_name')),
				);
				
				// get the sections
				$sections = $this->char->get_bio_sections();
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $sec)
					{
						$email_data['sections'][$sec->section_id]['title'] = $sec->section_name;
						
						// get the section fields
						$fields = $this->char->get_bio_fields($sec->section_id);
						
						if ($fields->num_rows() > 0)
						{
							foreach ($fields->result() as $field)
							{
								$bio_data = $this->char->get_field_data($field->field_id, $data['id']);
								
								if ($bio_data->num_rows() > 0)
								{
									foreach ($bio_data->result() as $item)
									{
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
				
				// where should the email be coming from
				$em_loc = Location::email('main_join_gm', $this->mail->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// get the game masters email addresses
				$gm = $this->user->get_gm_emails();
				
				// set the TO variable
				$to = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				// set the parameters for sending the email
				$this->mail->from(Util::email_sender(), $data['name']);
				$this->mail->to($to);
				$this->mail->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->mail->message($message);
			break;
		}
		
		// send the email
		$email = $this->mail->send();
		
		return $email;
	}
}
