<?php
/*
|---------------------------------------------------------------
| MAIN CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/main_base.php
| System Version: 1.0
|
| Controller that handles the MAIN section of the system.
|
*/

class Main_base extends Controller {
	
	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;
	
	function Main_base()
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
		$this->auth->is_logged_in();
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_main',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'show_news',
			'use_sample_post',
			'default_email_name',
			'default_email_address',
			'email_subject',
			'system_email'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_main'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			$this->skin = $this->session->userdata('skin_main');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_main.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'main'), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			/* create the user panels */
			$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
			$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
			$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
			$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		}
	}

	function index()
	{
		/* load the models */
		$this->load->model('news_model', 'news');
		
		/* run any model or lib methods */
		$news = $this->news->get_news_items(5, $this->session->userdata('player_id'));
		
		if ($news->num_rows() > 0 && $this->options['show_news'] == 'y')
		{
			$i = 1;
			$datestring = $this->options['date_format']; /* set the datestring */
			
			foreach ($news->result() as $row)
			{ /* populate the news item data */
				$date = gmt_to_local($row->news_date, $this->timezone, $this->dst);
				
				$data['news'][$i]['id'] = $row->news_id;
				$data['news'][$i]['title'] = $row->news_title;
				$data['news'][$i]['content'] = $row->news_content;
				$data['news'][$i]['date'] = mdate($datestring, $date);
				$data['news'][$i]['category'] = $row->newscat_name;
				$data['news'][$i]['author'] = $this->char->get_character_name($row->news_author_character, TRUE);
				
				++$i;
			}
		}
		
		/* header and welcome message */
		$data['header'] = $this->msgs->get_message('welcome_head');
		$data['msg_welcome'] = $this->msgs->get_message('welcome_msg');
		
		/* labels */
		$data['label'] = array(
			'news' => ucwords(lang('status_latest') .' '. lang('global_news')),
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'by' => lang('labels_by'),
			'in' => lang('labels_in'),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('main_index', $this->skin, 'main');
		$js_loc = js_location('main_index_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', ucfirst(lang('labels_main')));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function contact()
	{
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off_disabled');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			/* set the variables */
			$array = array(
				'to'		=> $this->input->post('to'),
				'name'		=> $this->input->post('name'),
				'email'		=> $this->input->post('email'),
				'subject'	=> $this->input->post('subject'),
				'message'	=> $this->input->post('message')
			);
			
			if ($array['to'] == FALSE || $array['email'] == FALSE || $array['message'] == FALSE || $array['to'] == '0')
			{
				$flash['status'] = 'error';
				
				if ($array['to'] == '0')
				{
					$flash['message'] = lang_output('flash_contact_recipient');
				}
				else
				{
					$message = sprintf(
						lang('flash_empty_fields'),
						lang('flash_fields_all'),
						lang('actions_send'),
						lang('labels_email')
					);
					
					$flash['message'] = text_output($message);
				}
			}
			else
			{
				/* execute the email method */
				$email = ($this->options['system_email'] == 'on') ? $this->_email('contact', $array) : FALSE;
				
				if ($email === FALSE)
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
						lang('actions_sent')
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
				}
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		/*set the title, header and content variables */
		$data['header'] = ucwords(lang('actions_contact') .' '. lang('labels_us'));
		$data['msg'] = $this->msgs->get_message('contact');
		
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'disabled' => ($this->options['system_email'] == 'off') ? 'disabled' : '',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		$data['inputs'] = array(
			'name' => array(
				'name' => 'name',
				'id' => 'name'),
			'email' => array(
				'name' => 'email',
				'id' => 'email'),
			'subject' => array(
				'name' => 'subject',
				'id' => 'subject'),
			'message' => array(
				'name' => 'message',
				'id' => 'message',
				'rows' => 12)
		);
		
		$data['values']['to'] = array(
			0 => ucwords(lang('labels_please') .' '. 
				lang('actions_choose') .' '. lang('order_one')),
			1 => ucwords(lang('global_game_master')),
			2 => ucwords(lang('global_command_staff')),
			3 => ucwords(lang('global_webmaster')),
		);
		
		$data['label'] = array(
			'send' => ucwords(lang('actions_send') .' '. lang('labels_to')),
			'name' => ucwords(lang('labels_name')),
			'email' => ucwords(lang('labels_email_address')),
			'subject' => ucwords(lang('labels_subject')),
			'message' => ucwords(lang('labels_message')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('main_contact', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function credits()
	{
		$this->load->model('ranks_model', 'ranks');
		
		/* run the methods */
		$skin_info = $this->sys->get_skin_info($this->skin);
		$rank_info = $this->ranks->get_rankcat($this->rank, 'rankcat_location', 'rankcat_credits');
		
		/* data used by the view */
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_credits'));
		$data['msg_credits'] = $this->msgs->get_message('credits');
		$data['msg_credits_perm'] = $this->msgs->get_message('credits_perm');
		$data['msg_credits_perm'].= "\r\n\r\n". $skin_info->skin_credits;
		$data['msg_credits_perm'].= "\r\n\r\n". $rank_info;
		
		if ($this->auth->is_logged_in() === TRUE && $this->auth->check_access('site/messages', FALSE) === TRUE)
		{
			$data['edit_valid'] = TRUE;
		}
		else
		{
			$data['edit_valid'] = FALSE;
		}
		
		$data['label'] = array(
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('main_credits', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function join()
	{
		/* load the models */
		$this->load->model('positions_model', 'pos');
		$this->load->model('depts_model', 'dept');
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('utility');
		
		/* set the variables */
		$agree = $this->input->post('agree', TRUE);
		$submit = $this->input->post('submit', TRUE);
		$selected_pos = $this->input->post('position', TRUE);
		
		$data['selected_position'] = (is_numeric($selected_pos) && $selected_pos > 0) ? $selected_pos : 0;
		$desc = $this->pos->get_position($data['selected_position'], 'pos_desc');
		$data['pos_desc'] = ($desc !== FALSE) ? $desc : FALSE;
		
		if ($submit != FALSE)
		{
			/* player POST variables */
			$email = $this->input->post('email', TRUE);
			$real_name = $this->input->post('name',TRUE);
			$im = $this->input->post('instant_message', TRUE);
			$dob = $this->input->post('date_of_birth', TRUE);
			$password = $this->input->post('password', TRUE);
			
			/* character POST variables */
			$first_name = $this->input->post('first_name',TRUE);
			$middle_name = $this->input->post('middle_name', TRUE);
			$last_name = $this->input->post('last_name', TRUE);
			$suffix = $this->input->post('suffix',TRUE);
			$position = $this->input->post('position_1',TRUE);
			
			if ($position == 0 || $first_name == '')
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
				/* load the additional models */
				$this->load->model('applications_model', 'apps');
				
				/* grab the player id */
				$check_player = $this->player->check_email($email);
				
				if ($check_player === FALSE)
				{
					/* build the players data array */
					$player_array = array(
						'name' => $real_name,
						'email' => $email,
						'password' => sha1($password),
						'instant_message' => $im,
						'date_of_birth' => $dob,
						'join_date' => now(),
						'status' => 'pending',
						'skin_main' => $this->sys->get_skinsec_default('main'),
						'skin_admin' => $this->sys->get_skinsec_default('admin'),
						'skin_wiki' => $this->sys->get_skinsec_default('wiki'),
						'display_rank' => $this->ranks->get_rank_default(),
					);
				
					/* create the player */
					$players = $this->player->create_player($player_array);
					$player_id = $this->db->insert_id();
					$prefs = $this->player->create_player_prefs($player_id);
				}
				
				/* set the player id */
				$player = (!isset($player_id)) ? $check_player : $player_id;
				
				/* build the characters data array */
				$character_array = array(
					'player' => $player,
					'first_name' => $first_name,
					'middle_name' => $middle_name,
					'last_name' => $last_name,
					'suffix' => $suffix,
					'position_1' => $position,
					'crew_type' => 'pending'
				);
				
				/* create the character */
				$character = $this->char->create_character($character_array);
				$character_id = $this->db->insert_id();
				
				$name = array($first_name, $middle_name, $last_name, $suffix);
				
				/* build the apps data array */
				$app_array = array(
					'app_email' => $email,
					'app_player' => $player,
					'app_player_name' => $real_name,
					'app_character' => $character_id,
					'app_character_name' => parse_name($name),
					'app_position' => $this->pos->get_position($position, 'pos_name'),
					'app_date' => now()
				);
				
				/* create new application record */
				$apps = $this->apps->insert_application($app_array);
				
				foreach ($_POST as $key => $value)
				{
					if (is_numeric($key))
					{
						/* build the array */
						$array = array(
							'data_field' => $key,
							'data_char' => $character_id,
							'data_player' => $player,
							'data_value' => $value,
							'data_updated' => now()
						);
						
						/* insert the data */
						$this->char->create_character_data($array);
					}
				}
				
				if ($character < 1 && $players < 1)
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
					
					/* execute the email method */
					$email_user = ($this->options['system_email'] == 'on') ? $this->_email('join_player', $user_data) : FALSE;
					
					$gm_data = array(
						'email' => $email,
						'name' => $real_name,
						'id' => $character_id,
						'player' => $player
					);
					
					/* execute the email method */
					$email_gm = ($this->options['system_email'] == 'on') ? $this->_email('join_gm', $gm_data) : FALSE;
					
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
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		elseif ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		if ($agree == FALSE && $submit == FALSE)
		{ /* if they try to come straight to the join page, make them agree */
			$data['msg'] = $this->msgs->get_message('join_disclaimer');
			
			if ($this->uri->segment(3) != FALSE)
			{
				$data['position'] = $this->uri->segment(3);
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('main_join_1', $this->skin, 'main');
		}
		else
		{
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
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('main_join_2', $this->skin, 'main');
			
			/* inputs */
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
					'rows' => 14),
			);
			
			/* get the sample post question */
			$data['sample_post_msg'] = $this->msgs->get_message('join_post');
			
			$data['label'] = array(
				'player_info' => ucwords(lang('global_player') .' '. lang('labels_information')),
				'name' => ucwords(lang('labels_name')),
				'email' => ucwords(lang('labels_email_address')),
				'password' => ucwords(lang('labels_password')),
				'dob' => lang('labels_dob'),
				'im' => ucwords(lang('labels_im')),
				'im_inst' => lang('text_im_instructions'),
				'fname' => ucwords(lang('order_first') .' '. lang('labels_name')),
				'mname' => ucwords(lang('order_middle') .' '. lang('labels_name')),
				'lname' => ucwords(lang('order_last') .' '. lang('labels_name')),
				'suffix' => ucfirst(lang('labels_suffix')),
				'position' => ucwords(lang('global_position')),
				'other' => ucfirst(lang('labels_other')),
				'samplepost' => ucwords(lang('labels_sample_post')),
				'character' => ucfirst(lang('global_character')),
			);
		}
		
		/* submit button */
		$data['button'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
			'agree' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'button_agree',
				'value' => 'agree',
				'content' => ucwords(lang('actions_agree')))
		);
		
		$data['header'] = ucfirst(lang('actions_join'));
		
		$data['loading'] = array(
			'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
			'alt' => lang('actions_loading'),
			'class' => 'image'
		);
		
		$js_loc = js_location('main_join_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function news()
	{
		/* set any variables */
		$category = $this->uri->segment(3, 0, TRUE);
		
		/* load the models */
		$this->load->model('news_model', 'news');
		
		/* load the helpers */
		$this->load->helper('text');
		
		/* grab the data from the models */
		$news = $this->news->get_category_news($category, $this->session->userdata('player_id'));
		$newscat = $this->news->get_news_category($category);
		$categories = $this->news->get_news_categories();
		
		$data['label'] = array(
			'categories' => ucfirst(lang('labels_categories')),
			'all_news' => ucwords(lang('labels_all') .' '. lang('global_news')),
			'comments' => lang('labels_comments'),
			'category' => ucfirst(lang('labels_category')) .':',
			'author' => ucfirst(lang('labels_author')) .':',
			'posted_on' => ucfirst(lang('actions_posted') .' '. lang('labels_on')) .':',
			'loading' => ucfirst(lang('actions_loading'))
		);
		
		if ($category >= 1)
		{ /* build the page title based on the category */
			foreach ($newscat->result() as $cat)
			{
				$data['header'] = lang('global_news') .' '. NDASH .' '. $cat->newscat_name;
			}
		}
		else
		{
			$data['header'] = $data['label']['all_news'];
		}
		
		if ($categories->num_rows() > 0)
		{ /* get the list of news categories */
			$j = 1;
			
			foreach ($categories->result() as $item)
			{
				$data['categories'][$j]['id'] = $item->newscat_id;
				$data['categories'][$j]['name'] = $item->newscat_name;
				
				++$j;
			}
		}
		
		if ($news->num_rows() > 0)
		{ /* loop through the news data and assign them to variables */
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
				$data['news'][$i]['author'] = $this->char->get_character_name($row->news_author_character, TRUE);
				$data['news'][$i]['comment_count'] = $this->news->count_news_comments($row->news_id);
				
				++$i;
			}
		}
		else
		{
			$data['msg'] = lang_output('error_msg_no_news', 'h3', 'orange');
		}
		
		/* set the info for the loader image */
		$data['loader'] = array(
			'src' => img_location('loader.gif', $this->skin, 'main'),
			'alt' => '',
			'class' => 'image');
			
		/* figure out where the view should be coming from */
		$view_loc = view_location('main_news', $this->skin, 'main');
		$js_loc = js_location('main_news_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', ucfirst(lang('global_news')));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewnews()
	{
		/* load the models */
		$this->load->model('news_model', 'news');
		
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($this->session->userdata('player_id') !== FALSE && isset($_POST['submit']))
		{
			$comment_text = $this->input->post('comment_text');
			
			if (!empty($comment_text))
			{
				$status = $this->player->checking_moderation('news_comment', $this->session->userdata('player_id'));
				
				/* build the insert array */
				$insert = array(
					'ncomment_content' => $comment_text,
					'ncomment_news' => $id,
					'ncomment_date' => now(),
					'ncomment_author_character' => $this->session->userdata('main_char'),
					'ncomment_author_player' => $this->session->userdata('player_id'),
					'ncomment_status' => $status
				);
				
				/* insert the data */
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
						/* set the array of data for the email */
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'news_item' => $id,
							'comment' => $comment_text);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('news_comment_pending', $email_data) : FALSE;
					}
					else
					{
						/* get the player id */
						$player = $this->player->get_player_id($this->news->get_news_author($id));
						
						/* get the author's preference */
						$pref = $this->player->get_pref('email_new_news_comments', $player);
						
						if ($pref == 'y')
						{
							/* set the array of data for the email */
							$email_data = array(
								'author' => $this->session->userdata('main_char'),
								'news_item' => $id,
								'comment' => $comment_text);
							
							/* send the email */
							$email = ($this->options['system_email'] == 'on') ? $this->_email('news_comment', $email_data) : FALSE;
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
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/main/pages/flash', $flash);
		}
		
		/* get the news item */
		$query = $this->news->get_news_item($id);
		$comments = $this->news->get_news_comments($id);
		
		/* set the date format */
		$datestring = $this->options['date_format'];
		
		if ($query->num_rows() > 0)
		{
			$row = $query->row();
			
			/* set the date */
			$date = gmt_to_local($row->news_date, $this->timezone, $this->dst);
			
			if ($row->news_date < $row->news_last_update)
			{
				$edited = gmt_to_local($row->news_last_update, $this->timezone, $this->dst);
				$data['update'] = mdate($datestring, $edited);
			}
			
			/* grab the next and previous IDs */
			$next = $this->news->get_link_id($id, 'next', $this->session->userdata('player_id'));
			$prev = $this->news->get_link_id($id, 'prev', $this->session->userdata('player_id'));
			
			/* set the data being sent to the view */
			$data['id'] = $row->news_id;
			$data['title'] = $row->news_title;
			$data['content'] = $row->news_content;
			$data['date'] = mdate($datestring, $date);
			$data['author'] = $this->char->get_character_name($row->news_author_character, TRUE);
			$data['category'] = $row->newscat_name;
			$data['tags'] = $row->news_tags;
			$data['news_id'] = $id;
			$data['private'] = $row->news_private;
			
			/* determine if they can edit the log */
			if ($this->auth->is_logged_in() === TRUE && ( ($this->auth->get_access_level('manage/news') == 2) ||
				($this->auth->get_access_level('manage/news') == 1 && $this->session->userdata('player_id') == $row->news_author_player)))
			{
				$data['edit_valid'] = TRUE;
			}
			else
			{
				$data['edit_valid'] = FALSE;
			}
			
			if ($next !== FALSE)
			{ /* if there is a next ID, set it */
				$data['next'] = $next;
			}
			
			if ($prev !== FALSE)
			{ /* if there is a previous ID, set it */
				$data['prev'] = $prev;
			}
			
			/* input parameters */
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
			
			/* image parameters */
			$data['images'] = array(
				'next' => array(
					'src' => img_location('next.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_next')),
					'class' => 'image'),
				'prev' => array(
					'src' => img_location('previous.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_previous')),
					'class' => 'image'),
				'feed' => array(
					'src' => img_location('feed.png', $this->skin, 'main'),
					'alt' => lang('labels_subscribe'),
					'class' => 'image'),
				'comment' => array(
					'src' => img_location('comment-add.png', $this->skin, 'main'),
					'alt' => '',
					'class' => 'inline_img_left image'),
				'edit' => array(
					'src' => img_location('write-news-edit.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_edit')),
					'title' => ucfirst(lang('actions_edit')),
					'class' => 'image'),
			);
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('main_viewnews', $this->skin, 'main');
			$js_loc = js_location('main_viewnews_js', $this->skin, 'main');
		}
		else
		{
			if ($id === FALSE)
			{
				$data['title'] = lang('error_title_invalid_id');
				$data['msg_error'] = lang('error_msg_news_id_numeric');
			}
			elseif ($query->num_rows() == 0)
			{
				$data['title'] = lang('error_title_id_not_found');
				$data['msg_error'] = lang('error_msg_news_not_found');
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('error', $this->skin, 'main');
		}
		
		/* grab the comment count */
		$data['comment_count'] = $comments->num_rows();
		
		if ($comments->num_rows() > 0)
		{
			$i = 1;
			
			foreach ($comments->result() as $c)
			{
				$date = gmt_to_local($c->ncomment_date, $this->timezone, $this->dst);
				
				$data['comments'][$i]['author'] = $this->char->get_character_name($c->ncomment_author_character, TRUE);
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
		
		/* write the data to the template */
		$this->template->write('title', ucwords(lang('actions_view') .' '. lang('global_news')));
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
		
		/* define the variables */
		$email = FALSE;
		
		switch ($type)
		{
			case 'contact':
				/* set the email data */
				$email_data = array(
					'email_subject' => $data['subject'],
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br($data['message'])
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('main_contact', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				switch ($data['to'])
				{ /* figure out who the emails are going to */
					case 1:
						/* get the game masters */
						$gm = $this->player->get_gm_emails();
						
						/* set the TO variable */
						$to = implode(',', $gm);
						
						break;
						
					case 2:
						/* get the command staff */	
						$command = $this->player->get_command_staff_emails();
						
						/* set the TO variable */
						$to = implode(',', $command);
						
						break;
						
					case 3:
						/* get the webmasters */
						$webmaster = $this->player->get_webmasters_emails();
						
						/* set the TO variable */
						$to = implode(',', $webmaster);
						
						break;
				}
				
				/* set the parameters for sending the email */
				$this->email->from($data['email'], $data['name']);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $data['subject']);
				$this->email->message($message);
				
				break;
				
			case 'news_comment':
				/* load the models */
				$this->load->model('news_model', 'news');
				
				/* run the methods */
				$news = $this->news->get_news_item($data['news_item']);
				$row = $news->row();
				$name = $this->char->get_character_name($data['author']);
				$from = $this->player->get_email_address('character', $data['author']);
				$to = $this->player->get_email_address('character', $row->news_author);
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_news_comment_added'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_news_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('main_news_comment', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'news_comment_pending':
				/* load the models */
				$this->load->model('news_model', 'news');
				
				/* run the methods */
				$news = $this->news->get_news_item($data['news_item']);
				$row = $news->row();
				$name = $this->char->get_character_name($data['author']);
				$from = $this->player->get_email_address('character', $data['author']);
				$to = implode(',', $this->player->get_emails_with_access('manage/comments'));
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_newsitems'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment'],
					site_url('login/index')
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_comment_pending'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('comment_pending', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'join_player':
				/* set the content */	
				$content = sprintf(
					lang('email_content_join_player'),
					$this->options['sim_name'],
					$data['email'],
					$data['password']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_join_player'),
					'email_from' => ucfirst(lang('time_from')) .': '. $this->options['default_email_name'] .' - '. $this->options['default_email_address'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content 
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('main_join_player', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($this->options['default_email_address'], $this->options['default_email_name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'join_gm':
				/* load the models */
				$this->load->model('positions_model', 'pos');
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_join_gm'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br(lang('email_content_join_gm'))
				);
				
				$email_data['basic_title'] = lang('tabs_player_basic');
				
				/* build the player data array */
				$player_data = $this->player->get_user_details($data['player']);
				$p_data = $player_data->row();
				
				$email_data['player'] = array(
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
				$gm = $this->player->get_gm_emails();
				
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

/* End of file main_base.php */
/* Location: ./application/controllers/base/main_base.php */