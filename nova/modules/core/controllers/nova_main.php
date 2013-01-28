<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Main controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_main.php';

abstract class Nova_main extends Nova_controller_main {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_regions['nav_sub'] = Menu::build('sub', 'main');
	}

	public function index()
	{
		// should we show the news?
		$data['lists']['news'] = ($this->options['show_news'] == 'y') ? self::_show_news() : false;
		
		// should we show personal logs?
		$data['lists']['logs'] = ($this->options['show_logs'] == 'y') ? self::_show_logs() : false;
		
		// should we show mission posts?
		$data['lists']['posts'] = ($this->options['show_posts'] == 'y') ? self::_show_posts() : false;
		
		// make sure only real content is in the set of lists
		foreach ($data['lists'] as $key => $list)
		{
			if ($list === false)
			{
				unset($data['lists'][$key]);
			}
		}
		
		// header and welcome message
		$data['header'] = $this->msgs->get_message('welcome_head');
		$data['msg_welcome'] = $this->msgs->get_message('welcome_msg');
		
		// labels
		$data['label'] = array(
			'logs' => ucwords(lang('status_latest') .' '. lang('global_personallogs')),
			'news' => ucwords(lang('status_latest') .' '. lang('global_newsitems')),
			'posts' => ucwords(lang('status_latest') .' '. lang('global_missionposts')),
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'by' => lang('labels_by'),
			'in' => lang('labels_in'),
			'mission' => ucfirst(lang('global_mission')),
		);
		
		$this->_regions['content'] = Location::view('main_index', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('main_index_js', $this->skin, 'main');
		$this->_regions['title'].= ucfirst(lang('labels_main'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function contact()
	{
		// load the validation library
		$this->load->library('form_validation');
		
		// make sure the error messages are using the proper syntax
		$this->form_validation->set_error_delimiters('<span class="red bold error-icon">', '</span><br />');
		
		// set the validation rules
		$this->form_validation->set_rules('name', 'lang:labels_name', 'required');
		$this->form_validation->set_rules('email', 'lang:labels_email_address', 'required|valid_email');
		$this->form_validation->set_rules('subject', 'lang:labels_subject', 'required');
		$this->form_validation->set_rules('message', 'lang:labels_message', 'required');
		
		if (isset($_POST['submit']))
		{
			$array = array(
				'name'		=> $this->input->post('name'),
				'email'		=> $this->input->post('email'),
				'subject'	=> $this->input->post('subject'),
				'message'	=> $this->input->post('message')
			);
			
			if ($this->form_validation->run())
			{
				$email = ($this->options['system_email'] == 'on') ? $this->_email('contact', $array) : false;
				
				if ( ! $email)
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('labels_contact')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
				else
				{
					$message = sprintf(
						lang('flash_success'),
						ucfirst(lang('labels_contact')),
						lang('actions_sent'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
				
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'main', $flash);
			}
		}
		
		// set the title, header and content variables
		$data['header'] = ucwords(lang('actions_contact').' '.lang('labels_us'));
		$data['msg'] = $this->msgs->get_message('contact');
		
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		if ($this->options['system_email'] == 'off')
		{
			$data['button']['submit']['disabled'] = 'disabled';
		}
		
		$data['inputs'] = array(
			'name' => array(
				'name' => 'name',
				'id' => 'name',
				'value' => set_value('name')),
			'email' => array(
				'name' => 'email',
				'id' => 'email',
				'value' => set_value('email')),
			'subject' => array(
				'name' => 'subject',
				'id' => 'subject',
				'value' => set_value('subject')),
			'message' => array(
				'name' => 'message',
				'id' => 'message',
				'rows' => 12,
				'value' => set_value('message'))
		);
		
		$data['label'] = array(
			'send' => ucwords(lang('actions_send') .' '. lang('labels_to')),
			'name' => ucwords(lang('labels_name')),
			'email' => ucwords(lang('labels_email_address')),
			'subject' => ucwords(lang('labels_subject')),
			'message' => ucwords(lang('labels_message')),
			'nosubmit' => lang('flash_system_email_off_disabled'),
		);
		
		$this->_regions['content'] = Location::view('main_contact', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function credits()
	{
		$this->load->model('ranks_model', 'ranks');
		
		// run the methods
		$skin_info = $this->sys->get_skin_info($this->skin);
		$rank_info = $this->ranks->get_rankcat($this->rank, 'rankcat_location', 'rankcat_credits');
		
		// data used by the view
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_credits'));
		$data['msg_credits'] = $this->msgs->get_message('credits');
		$data['msg_credits_perm'] = $this->msgs->get_message('credits_perm');
		$data['msg_credits_perm'].= "\r\n\r\n". $skin_info->skin_credits;
		$data['msg_credits_perm'].= "\r\n\r\n". $rank_info;
		
		$data['edit_valid'] = (Auth::is_logged_in() and Auth::check_access('site/messages', false)) ? true : false;
		
		$data['label'] = array(
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
		);
		
		$this->_regions['content'] = Location::view('main_credits', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function join()
	{
		$this->load->model('positions_model', 'pos');
		$this->load->model('depts_model', 'dept');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		$agree = $this->input->post('agree', true);
		$submit = $this->input->post('submit', true);
		$selected_pos = $this->input->post('position', true);
		
		$data['selected_position'] = (is_numeric($selected_pos) and $selected_pos > 0) ? $selected_pos : 0;
		$desc = $this->pos->get_position($data['selected_position'], 'pos_desc');
		$data['pos_desc'] = ($desc !== false) ? $desc : false;
		
		if ($submit !== false)
		{
			// user POST variables
			$email = $this->input->post('email', true);
			$real_name = $this->input->post('name',true);
			$im = $this->input->post('instant_message', true);
			$dob = $this->input->post('date_of_birth', true);
			$password = $this->input->post('password', true);
			
			// character POST variables
			$first_name = $this->input->post('first_name',true);
			$middle_name = $this->input->post('middle_name', true);
			$last_name = $this->input->post('last_name', true);
			$suffix = $this->input->post('suffix',true);
			$position = $this->input->post('position_1',true);
			
			if ($position == 0 or $first_name == '' or empty($password) or empty($email))
			{
				$message = sprintf(
					lang('flash_empty_fields'),
					lang('flash_fields_join'),
					lang('actions_submit'),
					lang('actions_join') .' '. lang('actions_request')
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			else
			{
				// check the ban list
				$ban['ip'] = $this->sys->get_item('bans', 'ban_ip', $this->input->ip_address());
				$ban['email'] = $this->sys->get_item('bans', 'ban_email', $email);
				
				if ($ban['ip'] !== false or $ban['email'] !== false)
				{
					$message = sprintf(
						lang('text_ban_join'),
						lang('global_sim'),
						lang('global_game_master')
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
				else
				{
					// load the additional models
					$this->load->model('applications_model', 'apps');
					
					// grab the user id
					$check_user = $this->user->check_email($email);
					
					if ($check_user === false)
					{
						// build the users data array
						$user_array = array(
							'name' => $real_name,
							'email' => $email,
							'password' => Auth::hash($password),
							'instant_message' => $im,
							'date_of_birth' => $dob,
							'join_date' => now(),
							'status' => 'pending',
							'skin_main' => $this->sys->get_skinsec_default('main'),
							'skin_admin' => $this->sys->get_skinsec_default('admin'),
							'skin_wiki' => $this->sys->get_skinsec_default('wiki'),
							'display_rank' => $this->ranks->get_rank_default(),
						);
					
						// create the user
						$users = $this->user->create_user($user_array);
						$user_id = $this->db->insert_id();
						$prefs = $this->user->create_user_prefs($user_id);
						$my_links = $this->sys->update_my_links($user_id);
					}
					
					// set the user id
					$user = ($check_user === false) ? $user_id : $check_user;
					
					// build the characters data array
					$character_array = array(
						'user' => $user,
						'first_name' => $first_name,
						'middle_name' => $middle_name,
						'last_name' => $last_name,
						'suffix' => $suffix,
						'position_1' => $position,
						'crew_type' => 'pending'
					);
					
					// create the character
					$character = $this->char->create_character($character_array);
					$character_id = $this->db->insert_id();
					
					// update the main character if this is their first app
					if ($check_user === false)
					{
						$main_char = array('main_char' => $character_id);
						$update_main = $this->user->update_user($user, $main_char);
					}
					
					// optimize the tables
					$this->sys->optimize_table('characters');
					$this->sys->optimize_table('users');
					
					$name = array($first_name, $middle_name, $last_name, $suffix);
					
					// build the apps data array
					$app_array = array(
						'app_email' => $email,
						'app_ip' => $this->input->ip_address(),
						'app_user' => $user,
						'app_user_name' => $real_name,
						'app_character' => $character_id,
						'app_character_name' => parse_name($name),
						'app_position' => $this->pos->get_position($position, 'pos_name'),
						'app_date' => now()
					);
					
					// create new application record
					$apps = $this->apps->insert_application($app_array);
					
					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							// build the array
							$array = array(
								'data_field' => $key,
								'data_char' => $character_id,
								'data_user' => $user,
								'data_value' => $value,
								'data_updated' => now()
							);
							
							// insert the data
							$this->char->create_character_data($array);
						}
					}
					
					if ($character < 1 and $users < 1)
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('actions_join') .' '. lang('actions_request')),
							lang('actions_submitted'),
							lang('flash_additional_contact_gm')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$user_data = array(
							'email' => $email,
							'password' => $password,
							'name' => $real_name
						);
						
						// execute the email method
						$email_user = ($this->options['system_email'] == 'on') ? $this->_email('join_user', $user_data) : false;
						
						$gm_data = array(
							'email' => $email,
							'name' => $real_name,
							'id' => $character_id,
							'user' => $user,
							'sample_post' => $this->input->post('sample_post'),
							'ipaddr' => $this->input->ip_address()
						);
						
						// execute the email method
						$email_gm = ($this->options['system_email'] == 'on') ? $this->_email('join_gm', $gm_data) : false;
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_join') .' '. lang('actions_request')),
							lang('actions_submitted'),
							''
						);
						
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
				}
			}
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'main', $flash);
		}
		elseif ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'main', $flash);
		}
		
		if ($agree == false and $submit == false)
		{
			$data['msg'] = $this->msgs->get_message('join_disclaimer');
			
			if ($this->uri->segment(3) != false)
			{
				$data['position'] = $this->uri->segment(3);
			}
			
			$view_loc = 'main_join_1';
		}
		else
		{
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
										'value' => $field->field_value
									);
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_input($input);
								break;
									
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value,
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
			
			// get the join instructions
			$data['msg'] = $this->msgs->get_message('join_instructions');
			
			// figure out where the view should be coming from
			$view_loc = 'main_join_2';
			
			// inputs
			$data['inputs'] = array(
				'name' => array(
					'name' => 'name',
					'id' => 'name'),
				'email' => array(
					'name' => 'email',
					'id' => 'email'),
				'password' => array(
					'name' => 'password',
					'id' => 'password'),
				'dob' => array(
					'name' => 'date_of_birth',
					'id' => 'date_of_birth'),
				'im' => array(
					'name' => 'instant_message',
					'id' => 'instant_message',
					'rows' => 4),
				'first_name' => array(
					'name' => 'first_name',
					'id' => 'first_name'),
				'middle_name' => array(
					'name' => 'middle_name',
					'id' => 'middle_name'),
				'last_name' => array(
					'name' => 'last_name',
					'id' => 'last_name'),
				'suffix' => array(
					'name' => 'suffix',
					'id' => 'suffix',
					'class' => 'medium'),
				'sample_post' => array(
					'name' => 'sample_post',
					'id' => 'sample_post',
					'rows' => 30),
			);
			
			// get the sample post question
			$data['sample_post_msg'] = $this->msgs->get_message('join_post');
			
			$data['label'] = array(
				'user_info' => ucwords(lang('global_user') .' '. lang('labels_information')),
				'name' => ucwords(lang('labels_name')),
				'email' => ucwords(lang('labels_email_address')),
				'password' => ucwords(lang('labels_password')),
				'dob' => lang('labels_dob'),
				'im' => ucwords(lang('labels_im')),
				'im_inst' => lang('text_im_instructions'),
				'fname' => ucwords(lang('order_first') .' '. lang('labels_name')),
				'mname' => ucwords(lang('order_middle') .' '. lang('labels_name')),
				'next' => ucwords(lang('actions_next') .' '. lang('labels_step')) .' '. RARROW,
				'lname' => ucwords(lang('order_last') .' '. lang('labels_name')),
				'suffix' => ucfirst(lang('labels_suffix')),
				'position' => ucwords(lang('global_position')),
				'other' => ucfirst(lang('labels_other')),
				'samplepost' => ucwords(lang('labels_sample_post')),
				'character' => ucfirst(lang('global_character')),
				'character_info' => ucwords(lang('global_character') .' '. lang('labels_info')),
			);
		}
		
		// submit button
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'submitJoin',
				'content' => ucwords(lang('actions_submit'))),
			'next' => array(
				'type' => 'submit',
				'class' => 'button-sec',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'nextTab',
				'content' => ucwords(lang('actions_next') .' '. lang('labels_step'))),
			'agree' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'button_agree',
				'value' => 'agree',
				'content' => ucwords(lang('actions_agree')))
		);
		
		$data['header'] = ucfirst(lang('actions_join'));
		
		$data['loading'] = array(
			'src' => Location::img('loading-circle.gif', $this->skin, 'main'),
			'alt' => lang('actions_loading'),
			'class' => 'image'
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('main_join_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function news()
	{
		$this->load->model('news_model', 'news');
		$this->load->helper('text');
		
		$category = $this->uri->segment(3, 0, true);
		
		// grab the data from the models
		$news = $this->news->get_category_news($category, $this->session->userdata('userid'));
		$newscat = $this->news->get_news_category($category);
		$categories = $this->news->get_news_categories();
		
		if ($category >= 1)
		{
			foreach ($newscat->result() as $cat)
			{
				$data['header'] = lang('global_news') .' '. NDASH .' '. $cat->newscat_name;
			}
		}
		else
		{
			$data['header'] = ucwords(lang('labels_all') .' '. lang('global_news'));
		}
		
		if ($categories->num_rows() > 0)
		{
			$j = 1;
			
			foreach ($categories->result() as $item)
			{
				$data['categories'][$j]['id'] = $item->newscat_id;
				$data['categories'][$j]['name'] = $item->newscat_name;
				
				++$j;
			}
		}
		
		if ($news->num_rows() > 0)
		{
			$i = 1;
			$datestring = $this->options['date_format'];
			
			foreach ($news->result() as $row)
			{
				$date = gmt_to_local($row->news_date, $this->timezone, $this->dst);
				
				$data['news'][$i]['id'] = $row->news_id;
				$data['news'][$i]['title'] = $row->news_title;
				$data['news'][$i]['content'] = $row->news_content;
				$data['news'][$i]['date'] = mdate($datestring, $date);
				$data['news'][$i]['cat_id'] = $row->news_cat;
				$data['news'][$i]['category'] = $row->newscat_name;
				$data['news'][$i]['author'] = $this->char->get_character_name($row->news_author_character, true, false, true);
				$data['news'][$i]['comment_count'] = $this->news->count_news_comments($row->news_id);
				
				++$i;
			}
		}
		
		// set the info for the loader image
		$data['loader'] = array(
			'src' => Location::img('loader.gif', $this->skin, 'main'),
			'alt' => '',
			'class' => 'image'
		);
		
		$data['label'] = array(
			'categories' => ucfirst(lang('labels_categories')),
			'createnews' => sprintf(
				lang('text_create_news'),
				lang('global_newsitem'),
				anchor('write/index', ucwords(lang('labels_writing') .' '. lang('labels_controlpanel')))
			),
			'all_news' => ucwords(lang('labels_all') .' '. lang('global_news')),
			'comments' => lang('labels_comments'),
			'category' => ucfirst(lang('labels_category')) .':',
			'author' => ucfirst(lang('labels_author')) .':',
			'posted_on' => ucfirst(lang('actions_posted') .' '. lang('labels_on')) .':',
			'loading' => ucfirst(lang('actions_loading')),
			'nonews' => sprintf(lang('error_not_found'), lang('global_newsitems')),
		);
		
		$this->_regions['content'] = Location::view('main_news', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('main_news_js', $this->skin, 'main');
		$this->_regions['title'].= ucfirst(lang('global_news'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function rules()
	{
		// header and message
		$data['header'] = ucfirst(lang('labels_rules'));
		$data['message'] = $this->msgs->get_message('rules');
		
		$this->_regions['content'] = Location::view('main_rules', $this->skin, 'main', $data);
		$this->_regions['title'].= ucfirst(lang('labels_rules'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function viewnews()
	{
		$this->load->model('news_model', 'news');
		
		$id = $this->uri->segment(3, false, true);
		
		if (Auth::is_logged_in() and isset($_POST['submit']))
		{
			$comment_text = $this->input->post('comment_text');
			
			if ( ! empty($comment_text))
			{
				$status = $this->user->checking_moderation('news_comment', $this->session->userdata('userid'));
				
				// build the insert array
				$insert = array(
					'ncomment_content' => $comment_text,
					'ncomment_news' => $id,
					'ncomment_date' => now(),
					'ncomment_author_character' => $this->session->userdata('main_char'),
					'ncomment_author_user' => $this->session->userdata('userid'),
					'ncomment_status' => $status
				);
				
				// insert the data
				$add = $this->news->add_news_comment($insert);
				
				if ($add > 0)
				{
					$message = sprintf(
						lang('flash_success'),
						ucfirst(lang('labels_comment')),
						lang('actions_added'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
					
					if ($status == 'pending')
					{
						// set the array of data for the email
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'news_item' => $id,
							'comment' => $comment_text);
						
						// send the email
						$email = ($this->options['system_email'] == 'on') ? $this->_email('news_comment_pending', $email_data) : false;
					}
					else
					{
						// get the user id
						$user = $this->news->get_news_item($id, 'news_author_user');
						
						// get the author's preference
						$pref = $this->user->get_pref('email_new_news_comments', $user);
						
						if ($pref == 'y')
						{
							// set the array of data for the email
							$email_data = array(
								'author' => $this->session->userdata('main_char'),
								'news_item' => $id,
								'comment' => $comment_text);
							
							// send the email
							$email = ($this->options['system_email'] == 'on') ? $this->_email('news_comment', $email_data) : false;
						}
					}
				}
				else
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('labels_comment')),
						lang('actions_added'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
			}
			else
			{
				$flash['status'] = 'error';
				$flash['message'] = lang_output('flash_add_comment_empty_body');
			}
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'main', $flash);
		}
		
		// get the news item
		$row = $this->news->get_news_item($id);
		$comments = $this->news->get_news_comments($id);
		
		// set the date format
		$datestring = $this->options['date_format'];
		
		if ($row !== false)
		{
			// set the date
			$date = gmt_to_local($row->news_date, $this->timezone, $this->dst);
			
			if ($row->news_date < $row->news_last_update)
			{
				$edited = gmt_to_local($row->news_last_update, $this->timezone, $this->dst);
				$data['update'] = mdate($datestring, $edited);
			}
			
			// grab the next and previous IDs
			$next = $this->news->get_link_id($id, 'next', $this->session->userdata('userid'));
			$prev = $this->news->get_link_id($id, 'prev', $this->session->userdata('userid'));
			
			// set the data being sent to the view
			$data['id'] = $row->news_id;
			$data['title'] = $row->news_title;
			$data['content'] = $row->news_content;
			$data['date'] = mdate($datestring, $date);
			$data['author'] = $this->char->get_character_name($row->news_author_character, true, false, true);
			$data['category'] = $row->newscat_name;
			$data['tags'] = $row->news_tags;
			$data['news_id'] = $id;
			$data['private'] = $row->news_private;
			
			// determine if they can edit the log
			if (Auth::is_logged_in() === true and ( (Auth::get_access_level('manage/news') == 2) or
				(Auth::get_access_level('manage/news') == 1 and $this->session->userdata('userid') == $row->news_author_user)))
			{
				$data['edit_valid'] = true;
			}
			else
			{
				$data['edit_valid'] = false;
			}
			
			if ($next !== false)
			{
				$data['next'] = $next;
			}
			
			if ($prev !== false)
			{
				$data['prev'] = $prev;
			}
			
			// input parameters
			$data['inputs'] = array(
				'comment_text' => array(
					'name' => 'comment_text',
					'id' => 'comment_text',
					'rows' => 10),
				'comment_button' => array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// image parameters
			$data['images'] = array(
				'next' => array(
					'src' => Location::img('next.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_next')),
					'class' => 'image'),
				'prev' => array(
					'src' => Location::img('previous.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('status_previous')),
					'class' => 'image'),
				'feed' => array(
					'src' => Location::img('feed.png', $this->skin, 'main'),
					'alt' => lang('labels_subscribe'),
					'class' => 'image'),
				'comment' => array(
					'src' => Location::img('comment-add.png', $this->skin, 'main'),
					'alt' => '',
					'class' => 'inline_img_left image'),
				'edit' => array(
					'src' => Location::img('write-news-edit.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_edit')),
					'title' => ucfirst(lang('actions_edit')),
					'class' => 'image'),
			);
			
			// figure out where the view should be coming from
			$view_loc = 'main_viewnews';
			$js_loc = 'main_viewnews_js';
		}
		else
		{
			if ($id === false)
			{
				$data['header'] = lang('error_title_invalid_id');
				$data['msg_error'] = lang('error_msg_news_id_numeric');
			}
			elseif ( ! $row)
			{
				$data['header'] = lang('error_title_id_not_found');
				$data['msg_error'] = lang('error_msg_news_not_found');
			}
			
			// figure out where the view should be coming from
			$view_loc = 'error';
			$js_loc = false;
		}
		
		// grab the comment count
		$data['comment_count'] = $comments->num_rows();
		
		if ($comments->num_rows() > 0)
		{
			$i = 1;
			
			foreach ($comments->result() as $c)
			{
				$date = gmt_to_local($c->ncomment_date, $this->timezone, $this->dst);
				
				$data['comments'][$i]['author'] = $this->char->get_character_name($c->ncomment_author_character, true, false, true);
				$data['comments'][$i]['content'] = $c->ncomment_content;
				$data['comments'][$i]['date'] = mdate($datestring, $date);
				
				++$i;
			}
		}
		
		$data['label'] = array(
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'by' => lang('labels_by'),
			'category' => ucfirst(lang('labels_category')) .':',
			'tags' => ucfirst(lang('labels_tags')) .':',
			'addcomment' => ucfirst(lang('actions_add')) .' '. lang('labels_a') .' '.
				ucfirst(lang('labels_comment')),
			'comments' => ucfirst(lang('labels_comments')),
			'on' => lang('labels_on'),
			'edited' => ucfirst(lang('actions_edited')),
			'error_pagetitle' => lang('error_pagetitle'),
			'error_private_news' => lang('error_private_news'),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'main', $data);
		$this->_regions['javascript'] = ($js_loc) ? Location::js($js_loc, $this->skin, 'main') : false;
		$this->_regions['title'].= ucwords(lang('actions_view').' '.lang('global_news'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * Handles the compilation and sending of emails for the main controller
	 *
	 * @access	protected
	 * @param	string	the type of email to be sent
	 * @param	array 	the data array of information for the email
	 * @return	boolean	whether the email was successfully sent
	 */
	protected function _email($type, $data)
	{
		$this->load->library('email');
		$this->load->library('parser');
		
		$email = false;
		
		switch ($type)
		{
			case 'contact':
				// set the email data
				$email_data = array(
					'email_subject' => $data['subject'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br($data['message'])
				);
				
				// where should the email be coming from
				$loc = Location::email('main_contact', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($loc, $email_data, true);
				
				// get the game masters
				$gm = $this->user->get_gm_emails();
				
				// set the TO variable
				$to = implode(',', $gm);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $data['name']);
				$this->email->to($to);
				$this->email->reply_to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $data['subject']);
				$this->email->message($message);
			break;
				
			case 'news_comment':
				// load the resources
				$this->load->model('news_model', 'news');
				
				// get all the information from the database
				$row = $this->news->get_news_item($data['news_item']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->news_author_character);
				
				// build the content of the message
				$content = sprintf(
					lang('email_content_news_comment_added'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment']
				);
				
				// compile the data for the message
				$email_data = array(
					'email_subject' => lang('email_subject_news_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$loc = Location::email('main_news_comment', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'news_comment_pending':
				// load the resources
				$this->load->model('news_model', 'news');
				
				// get all the information from the database
				$row = $this->news->get_news_item($data['news_item']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = implode(',', $this->user->get_emails_with_access('manage/comments'));
				
				// set the content of the message
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_newsitems'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment'],
					site_url('login/index')
				);
				
				// compile the information together for the message
				$email_data = array(
					'email_subject' => lang('email_subject_comment_pending'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$loc = Location::email('comment_pending', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'join_user':
				// build the content of the message
				$content = sprintf(
					lang('email_content_join_user'),
					$this->options['sim_name'],
					$data['email'],
					$data['password']
				);
				
				// compile the information for the email
				$email_data = array(
					'email_subject' => lang('email_subject_join_user'),
					'email_from' => ucfirst(lang('time_from')) .': '. $this->options['default_email_name'] .' - '. $this->options['default_email_address'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content 
				);
				
				// where should the email be coming from
				$loc = Location::email('main_join_user', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $this->options['default_email_name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'join_gm':
				// load the resources
				$this->load->model('positions_model', 'pos');
				
				// compile the information for the email
				$email_data = array(
					'email_subject' => lang('email_subject_join_gm'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br(lang('email_content_join_gm')),
					'basic_title' => ucwords(lang('labels_basic').' '.lang('labels_info')),
				);
				
				// build the user data array
				$p_data = $this->user->get_user($data['user']);
				$email_data['user'] = array(
					array(
						'label' => ucfirst(lang('labels_name')),
						'data' => $data['name']),
					array(
						'label' => ucwords(lang('labels_email_address')),
						'data' => $data['email']),
					array(
						'label' => ucwords(lang('labels_ipaddr')),
						'data' => $data['ipaddr']),
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
				
				$email_data['sample_post_label'] = ucwords(lang('labels_sample_post'));
				$email_data['sample_post'] = ($this->email->mailtype == 'html') ? nl2br($data['sample_post']) : $data['sample_post'];
				
				// where should the email be coming from
				$em_loc = Location::email('main_join_gm', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the TO variable
				$to = implode(',', $this->user->get_emails_with_access('characters/index'));
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $data['name']);
				$this->email->to($to);
				$this->email->reply_to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
		}
		
		$email = $this->email->send();
		
		return $email;
	}
	
	protected function _show_logs()
	{
		// load the personal logs model
		$this->load->model('personallogs_model', 'logs');
		
		// load the text helper
		$this->load->helper('text');
		
		// fetch the last 5 personal logs
		$logs = $this->logs->get_log_list(5);
		
		if ($logs->num_rows() > 0)
		{
			$i = 1;
			$datestring = $this->options['date_format'];
			
			foreach ($logs->result() as $row)
			{
				$date = gmt_to_local($row->log_date, $this->timezone, $this->dst);
				
				$items[$i]['id'] = $row->log_id;
				$items[$i]['title'] = $row->log_title;
				$items[$i]['content'] = word_limiter(strip_tags($row->log_content, '<br><br/><br />'), 50);
				$items[$i]['date'] = mdate($datestring, $date);
				$items[$i]['author'] = $this->char->get_character_name($row->log_author_character, true, false, true);
				
				++$i;
			}
			
			return $items;
		}
		
		return false;
	}
	
	protected function _show_news()
	{
		// load the news model
		$this->load->model('news_model', 'news');
		
		// fetch the last 5 news items
		$news = $this->news->get_news_items(5, $this->session->userdata('userid'));
		
		if ($news->num_rows() > 0)
		{
			$i = 1;
			$datestring = $this->options['date_format'];
			
			foreach ($news->result() as $row)
			{
				$date = gmt_to_local($row->news_date, $this->timezone, $this->dst);
				
				$items[$i]['id'] = $row->news_id;
				$items[$i]['title'] = $row->news_title;
				$items[$i]['content'] = $row->news_content;
				$items[$i]['date'] = mdate($datestring, $date);
				$items[$i]['category'] = $row->newscat_name;
				$items[$i]['author'] = $this->char->get_character_name($row->news_author_character, true, false, true);
				
				++$i;
			}
			
			return $items;
		}
		
		return false;
	}
	
	protected function _show_posts()
	{
		// load the missions and posts models
		$this->load->model('missions_model', 'mis');
		$this->load->model('posts_model', 'posts');
		
		// load the text helper
		$this->load->helper('text');
		
		// fetch the last 5 posts
		$posts = $this->posts->get_post_list('', 'desc', 5, 0, 'activated');
		
		if ($posts->num_rows() > 0)
		{
			$i = 1;
			$datestring = $this->options['date_format'];
			
			foreach ($posts->result() as $row)
			{
				$date = gmt_to_local($row->post_date, $this->timezone, $this->dst);
				
				$items[$i]['id'] = $row->post_id;
				$items[$i]['title'] = $row->post_title;
				$items[$i]['content'] = word_limiter(strip_tags($row->post_content, '<br><br/><br />'), 50);
				$items[$i]['date'] = mdate($datestring, $date);
				$items[$i]['authors'] = $this->char->get_authors($row->post_authors, true, true);
				$items[$i]['mission'] = anchor('sim/missions/id/'.$row->post_mission, $this->mis->get_mission($row->post_mission, 'mission_title'));
				
				++$i;
			}
			
			return $items;
		}
		
		return false;
	}
}
