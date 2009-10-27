<?php
/*
|---------------------------------------------------------------
| INSTALL CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/install_base.php
| System Version: 1.0
|
| Controller that handles the installation of the system.
|
*/

class Install_base extends Controller {

	function Install_base()
	{
		parent::Controller();
		
		/* set the template */
		$this->template->set_template('install');
		$this->template->set_master_template('_base/template_install.php');
		
		/* write the common elements to the template */
		$this->template->write('title', APP_NAME .' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('install');
	}

	function index()
	{
		/*
			0 - no errors
			1 - system is already installed!
		*/
		
		$this->load->model('system_model', 'sys');
		
		$data['installed'] = $this->sys->check_install_status();
		
		$error = $this->uri->segment(4, 0, TRUE);
		
		if ($error > 0 || $data['installed'] === TRUE)
		{
			$error = ($error == 1 || $data['installed'] === TRUE) ? 1 : $error;
			
			$flash['status'] = ($error == 1) ? 'info' : 'error';
			$flash['message'] = '<span class="icon ui-icon ui-icon-info"></span>';
			$flash['message'].= lang_output('install_error_'. $error);
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
		}
		
		$data['label'] = array(
			'options_install' => lang('install_index_options_install'),
			'options_readme' => lang('install_index_options_readme'),
			'options_remove' => lang('install_index_options_remove'),
			'options_tour' => lang('install_index_options_tour'),
			'options_update' => lang('install_index_options_update'),
			'options_upgrade' => lang('install_index_options_upgrade'),
			'options_verify' => lang('install_index_options_verify'),
			'options_guide' => lang('install_index_options_guide'),
			'welcome' => lang('install_index_header_welcome'),			
			'whattodo' => lang('install_index_header_whattodo'),
			'firststeps' => lang('install_index_options_firststeps'),
			'whatsnext' => lang('install_index_options_whatsnext'),
			'intro' => lang('global_content_index'),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('main', '_base', 'install');
		$js_loc = js_location('main_js', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_index_title'));
		$this->template->write('label', lang('install_index_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function genre()
	{
		$data = FALSE;
		
		if (isset($_POST['submit']))
		{
			$email = $this->input->post('email');
			$password = sha1($this->input->post('password'));
			
			$this->load->model('players_model', 'players');
			$verify = $this->players->verify_login_details($email, $password);
			
			if ($verify->num_rows() > 0)
			{
				foreach ($verify->result() as $row)
				{
					$verify_admin = $this->players->verify_sysadmin($row->player_id);
				
					if ($verify_admin->num_rows() > 0)
					{
						redirect('install/genre/change', 'refresh');
					}
					else
					{
						$data['error'] = lang_output('error_not_sysadmin_genre', 'h3', 'error');
					}
				}
			}
			else
			{
				$data['error'] = lang_output('login_error_incorrect', 'h3', 'error');
			}
		}
		
		if ($this->uri->segment(3) == 'change')
		{
			/* pull in the install genre data asset file */
			include_once(APPPATH . 'assets/install/install_genre_' . GENRE . '.php');
			
			/* build the genre tables */
			foreach ($tables as $key_t => $value_t)
			{
				$this->dbforge->add_field($$value_t['fields']);
				$this->dbforge->add_key($value_t['id'], TRUE);
				$this->dbforge->create_table($key_t);
			}
			
			/* pause between executing scripts */
			sleep(1);
			
			/* insert the genre data */
			foreach ($data as $key_d => $value_d)
			{
				$this->db->insert($value_d, $$value_d);
			}
			
			/* pull in the view */
			$this->layout->view('_base/install/pages/genre_change');
		}
		else
		{
			/* pull in the view */
			$this->layout->view('_base/install/pages/genre', $data);
		}
	}
	
	function readme()
	{
		$data['label'] = array(
			'back' => lang('install_label_back')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('readme', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_readme_title'));
		$this->template->write('label', APP_NAME .' '. lang('install_readme_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function remove()
	{
		$flash['status'] = 'info';
		$flash['message'] = '<span class="icon ui-icon ui-icon-info"></span>';
		$flash['message'].= lang_output('install_remove_warning');
		
		if (isset($_POST['submit']))
		{
			$email = $this->input->post('email');
			$password = sha1($this->input->post('password'));
			
			$this->load->model('players_model', 'players');
			$verify = $this->players->verify_login_details($email, $password);
			
			if ($verify->num_rows() > 0)
			{
				foreach ($verify->result() as $row)
				{
					$verify_admin = $this->players->verify_sysadmin($row->player_id);
				
					if ($verify_admin->num_rows() >= 1)
					{
						$this->_destroy_data();
						
						$flash['status'] = 'success';
						$flash['message'] = lang_output('install_remove_success');
					}
					else
					{
						$flash['status'] = 'error';
						$flash['message'] = lang_output('error_not_sysadmin_remove');
					}
				}
			}
			else
			{
				$flash['status'] = 'error';
				$flash['message'] = lang_output('error_incorrect_credentials');
			}
			
			/* add redirect */
			$this->template->add_redirect('install/index', 15);
		}
		
		/* write everything to the template */
		$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
		
		$data['button_clear'] = array(
			'type' => 'submit',
			'class' => 'button',
			'name' => 'submit',
			'value' => 'clear',
			'id' => 'clear',
			'content' => ucwords(lang('install_remove_button_clear'))
		);
		
		$data['label'] = array(
			'back' => lang('install_label_back'),
			'email' => lang('install_step3_email'),
			'password' => lang('install_step3_password'),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('remove', '_base', 'install');
		$js_loc = js_location('install_remove_js', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_remove_title'));
		$this->template->write('label', lang('install_remove_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function step()
	{
		/* change the time limit to make sure we don't return any fatal errors */
		set_time_limit(0);
		
		/* load the resources */
		$this->load->model('system_model', 'sys');
		$this->load->dbforge();
		
		$install_status = $this->sys->check_install_status();
		
		$step = $this->uri->segment(3, 1, TRUE);
		
		if ($install_status === TRUE && $step === FALSE)
		{ /* make sure the system isn't already installed */
			redirect('install/index/error/1', 'refresh');
		}
		
		switch ($step)
		{
			case 1:
				/* update the character set and collation */
				$charset = $this->sys->update_database_charset();
				
				/* pull in the install fields asset file */
				include_once(APPPATH .'assets/install/fields.php');
				
				/* create an array for storing the results of the creation process */
				$table = array();
				
				foreach ($data as $key => $value)
				{
					$this->dbforge->add_field($$value['fields']);
					$this->dbforge->add_key($value['id'], TRUE);
					$table[] = $this->dbforge->create_table($key, TRUE);
				}
				
				foreach ($table as $key => $t)
				{
					if ($t === TRUE)
					{
						unset($table[$key]);
					}
				}
				
				$message = (count($table) > 0) ? lang('install_step1_failure') : lang('install_step1_success');
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				if (count($table) > 0)
				{
					$data['next']['disabled'] = 'disabled';
				}
				
				$data['label']['inst_step1'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('step_1', '_base', 'install');
				$js_loc = js_location('step_1_js', '_base', 'install');
				
				/* set the title and label */
				$this->template->write('title', lang('install_step1_title'));
				$this->template->write('label', lang('install_step1_label'));
				
				break;
				
			case 2:
				/* load the helpers */
				$this->load->helper('string');
				
				/* pull in the install data asset file */
				include_once(APPPATH .'assets/install/data_'. APP_DATA_SRC .'.php');
				
				$insert = array();
				
				foreach ($data as $value)
				{
					foreach ($$value as $k => $v)
					{
						$insert[] = $this->db->insert($value, $v);
					}
				}
				
				foreach ($insert as $key => $i)
				{
					if ($i === TRUE)
					{
						unset($insert[$key]);
					}
				}
				
				$message = (count($insert) > 0) ? lang('install_step2_failure') : lang('install_step2_success');
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				if (count($insert) > 0)
				{
					$data['next']['disabled'] = 'disabled';
				}
				
				$data['label']['inst_step2'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('step_2', '_base', 'install');
				$js_loc = js_location('step_2_js', '_base', 'install');
				
				/* set the title and label */
				$this->template->write('title', lang('install_step2_title'));
				$this->template->write('label', lang('install_step2_label'));
				
				break;
				
			case 3:
				/* pull in the install genre data asset file */
				include_once(APPPATH .'assets/install/genres/'. GENRE .'_data.php');
				
				$genre = array();
				
				foreach ($data as $key_d => $value_d)
				{
					foreach ($$value_d as $k => $v)
					{
						$genre[] = $this->db->insert($key_d, $v);
					}
				}
				
				foreach ($genre as $key => $g)
				{
					if ($g === TRUE)
					{
						unset($genre[$key]);
					}
				}
				
				$message = (count($genre) > 0) ? lang('install_step3_failure') : lang('install_step3_success');
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				if (count($genre) > 0)
				{
					$data['next']['disabled'] = 'disabled';
				}
					
				$data['inputs'] = array(
					'name' => array(
						'name' => 'real_name',
						'id' => 'real_name'),
					'dob' => array(
						'name' => 'dob',
						'id' => 'dob'),
					'email' => array(
						'name' => 'email',
						'id' => 'email'),
					'password' => array(
						'name' => 'password',
						'id' => 'password'),
					'security_answer' => array(
						'name' => 'security_answer',
						'id' => 'security_answer'),
					'first_name' => array(
						'name' => 'first_name',
						'id' => 'first_name'),
					'last_name' => array(
						'name' => 'last_name',
						'id' => 'last_name')
				);
				
				/* load the models */
				$this->load->model('ranks_model', 'rank');
				$this->load->model('system_model', 'sys');
				
				/* run the methods */
				$questions = $this->sys->get_security_questions();
				$ext = $this->rank->get_rankcat('default', 'rankcat_location', 'rankcat_extension');
				$rank = $this->rank->get_rank(1, 'rank_image');
				
				if ($questions->num_rows() > 0)
				{
					$data['questions'][0] = lang('login_questions_selectone');
					
					foreach ($questions->result() as $item)
					{
						$data['questions'][$item->question_id] = $item->question_value;
					}
				}
				
				$data['loading'] = array(
					'src' => img_location('loading-circle-small.gif', '_base', 'install'),
					'alt' => '',
					'class' => 'image'
				);
				
				$data['default_rank'] = array(
					'src' => base_url() . rank_location('default', $rank, $ext)
				);
		
				$data['label'] = array(
					'player' => lang('install_step3_player'),
					'name' => lang('install_step3_name'),
					'email' => lang('install_step3_email'),
					'password' => lang('install_step3_password'),
					'dob' => lang('install_step3_dob'),
					'question' => lang('install_step3_question'),
					'answer' => lang('install_step3_answer'),
					'remember' => lang('text_security_question'),
					'timezone' => lang('install_step3_timezone'),
					'character' => lang('install_step3_character'),
					'fname' => lang('install_step3_fname'),
					'lname' => lang('install_step3_lname'),
					'rank' => lang('install_step3_rank'),
					'position' => lang('install_step3_position'),
					'inst_step3' => $message,
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('step_3', '_base', 'install');
				$js_loc = js_location('step_3_js', '_base', 'install');
				
				/* set the title */
				$this->template->write('title', lang('install_step3_title'));
				$this->template->write('label', lang('install_step3_label'));
				
				break;
				
			case 4:
				/* set the variables */
				$submit = $this->input->post('next');
				
				/* load the models */
				$this->load->model('players_model');
				$this->load->model('characters_model', 'char');
				$this->load->model('positions_model', 'pos');
				$this->load->model('system_model', 'sys');
				$this->load->model('ranks_model', 'ranks');
				
				if ($submit != FALSE)
				{
					$insert = array();
					
					/* build the create player array */
					$create_player = array(
						'name'				=> $this->input->post('real_name', TRUE),
						'email'				=> $this->input->post('email', TRUE),
						'password'			=> sha1($this->input->post('password', TRUE)),
						'date_of_birth'		=> $this->input->post('dob', TRUE),
						'access_role'		=> 1,
						'is_sysadmin'		=> 'y',
						'is_game_master'	=> 'y',
						'is_webmaster'		=> 'y',
						'join_date'			=> now(),
						'security_question'	=> $this->input->post('security_question', TRUE),
						'security_answer'	=> sha1($this->input->post('security_answer', TRUE)),
						'timezone'			=> $this->input->post('timezones', TRUE),
						'skin_main'			=> $this->sys->get_skinsec_default('main'),
						'skin_admin'		=> $this->sys->get_skinsec_default('admin'),
						'skin_wiki'			=> $this->sys->get_skinsec_default('wiki'),
						'display_rank'		=> $this->ranks->get_rank_default()
					);
					
					/* insert the player data */
					$c_player = $this->players_model->create_player($create_player);
					$insert[] = $c_player;
					
					/* get the ID from the player insert */
					$p_id = $this->db->insert_id();
					
					/* create the player prefs */
					$prefs = $this->players_model->create_player_prefs($p_id);
					$insert[] = $prefs;
					
					/* build the create character array */
					$create_character = array(
						'player'		=> $p_id,
						'first_name'	=> $this->input->post('first_name', TRUE),
						'last_name'		=> $this->input->post('last_name', TRUE),
						'position_1'	=> $this->input->post('position', TRUE),
						'rank'			=> $this->input->post('rank', TRUE),
						'date_activate'	=> now(),
						'crew_type'		=> 'active',
					);
					
					/* insert the character data */
					$c_character = $this->char->create_character($create_character);
					$insert[] = $c_character;
					
					/* get the ID from the character insert */
					$c_id = $this->db->insert_id();
					
					$characters = array('main_char' => $c_id);
					
					/* update the players table */
					$this->players_model->update_player($p_id, $characters);
					
					/* build the COC array */
					$create_coc = array(
						'coc_crew' => $c_id,
						'coc_order' => 1);
					
					/* insert the COC data */
					$c_coc = $this->char->create_coc_entry($create_coc);
					$insert[] = $c_coc;
					
					/* create the character bio data */
					$c_data = $this->char->create_character_data_fields($c_id, $p_id);
					$insert[] = $c_data;
					
					/* update the open positions */
					$open = $this->pos->update_open_slots($create_character['position_1'], 'add_crew');
					
					/* update my links */
					$my_links = $this->sys->update_my_links();
				}
				
				foreach ($insert as $key => $i)
				{
					if ($i === TRUE || $i > 0)
					{
						unset($insert[$key]);
					}
				}
				
				$message = (count($insert) > 0) ? lang('install_step4_failure') : lang('install_step4_success');
				
				/* the next button */
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				if (count($insert) > 0)
				{
					$data['next']['disabled'] = 'disabled';
				}
					
				/* fields */
				$data['inputs'] = array(
					'sim_name' => array(
						'name' => 's_sim_name',
						'id' => 's_sim_name'),
					'email_subject' => array(
						'name' => 's_email_subject',
						'id' => 's_email_subject',
						'value' => ''),
					'num_chars' => array(
						'name' => 's_allowed_chars_playing',
						'value' => $this->settings->get_setting('allowed_chars_playing'),
						'class' => 'small'),
					'num_npc' => array(
						'name' => 's_allowed_chars_npc',
						'value' => $this->settings->get_setting('allowed_chars_npc'),
						'class' => 'small'),
				);
				
				$data['email_v'] = array(
					'on' => ucfirst(lang('install_label_on')),
					'off' => ucfirst(lang('install_label_off'))
				);
				
				$data['updates_v'] = array(
					'all' => lang('install_step4_updates_all'),
					'major' => lang('install_step4_updates_maj'),
					'minor' => lang('install_step4_updates_min'),
					'none' => lang('install_step4_updates_none')
				);
				
				$data['dates_v'] = array(
					'%D %M %j%S, %Y @ %g:%i%a'	=> 'Mon Jan 1st, 2009 @ 12:01am',
					'%D %M %j, %Y @ %g:%i%a'	=> 'Mon Jan 1, 2009 @ 12:01am',
					'%l %F %j%S, %Y @ %g:%i%a'	=> 'Monday January 1st, 2009 @ 12:01am',
					'%l %F %j, %Y @ %g:%i%a'	=> 'Monday January 1, 2009 @ 12:01am',
					'%m/%d/%Y @ %g:%i%a'		=> '01/01/2009 @ 12:01am',
					'%d %M %Y @ %g:%i%a'		=> '01 Jan 2009 @ 12:01am',
				);
				
				$data['label'] = array(
					'simname' => lang('install_step4_simname'),
					'sysemail' => lang('install_step4_sysemail'),
					'emailsubject' => lang('install_step4_emailsubject'),
					'updates' => lang('install_step4_updates'),
					'characters' => lang('install_step4_chars'),
					'npcs' => lang('install_step4_npcs'),
					'dates' => lang('install_step4_dates'),
					'inst_step4' => $message,
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('step_4', '_base', 'install');
				$js_loc = js_location('step_4_js', '_base', 'install');
				
				/* set the title */
				$this->template->write('title', lang('install_step4_title'));
				$this->template->write('label', lang('install_step4_label'));
				
				break;
				
			case 5:
				/* set the variables */
				$submit = $this->input->post('next');
				$data = FALSE;
				
				if ($submit != FALSE)
				{
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 2) == 's_')
						{ /* update only the items that should be updated */
							$field = substr_replace($key, '', 0, 2);
							$array = array('setting_value' => $value);
							
							$update += $this->settings->update_setting($field, $array);
						}
					}
					
					if (phpversion() >= 5)
					{
						/* load the resources */
						$this->load->library('ftp');
						
						if ($this->ftp->hostname != 'ftp.example.com')
						{
							$this->ftp->connect();
							
							$this->ftp->chmod(BASEPATH .'logs/', DIR_WRITE_MODE);
							$this->ftp->chmod(APPPATH .'assets/backups/', DIR_WRITE_MODE);
							$this->ftp->chmod(APPPATH .'assets/images/characters/', DIR_WRITE_MODE);
							$this->ftp->chmod(APPPATH .'assets/images/awards/', DIR_WRITE_MODE);
							$this->ftp->chmod(APPPATH .'assets/images/tour/', DIR_WRITE_MODE);
							$this->ftp->chmod(APPPATH .'assets/images/missions/', DIR_WRITE_MODE);
							
							$this->ftp->close();
						}
					}
				}
				
				$message = ($update > 0) ? lang('install_step5_success') : lang('install_step5_failure');
				
				$data['label'] = array(
					'site' => lang('install_label_site'),
					'inst_step5' => $message,
				);
					
				/* figure out where the view file should be coming from */
				$view_loc = view_location('step_5', '_base', 'install');
				$js_loc = js_location('step_5_js', '_base', 'install');
				
				/* set the title */
				$this->template->write('title', lang('install_step5_title'));
				$this->template->write('label', lang('install_step5_label'));
				
				break;
		}
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		if (isset($js_loc))
		{
			$this->template->write_view('javascript', $js_loc);
		}
		
		/* render the template */
		$this->template->render();
	}
	
	function verify()
	{
		/* load the resources */
		$this->load->helper('utility');
		
		/* load the verification data */
		$data['table'] = verify_server();
		
		$data['label'] = array(
			'back' => lang('install_label_back'),
			'text' => lang('install_verify_text')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('verify', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_verify_title'));
		$this->template->write('label', lang('install_verify_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function _destroy_data()
	{
		/* load the forge */
		$this->load->dbforge();
		
		/* get an array of the tables */
		$fields = $this->db->list_tables();
		
		/* get the prefix length */
		$prefix_len = strlen($this->db->dbprefix);
		
		/* go through all the tables to find out if its part of the system or not */
		foreach ($fields as $key => $value)
		{
			if (substr($value, 0, $prefix_len) != $this->db->dbprefix)
			{
				unset($fields[$key]);
			}
			else
			{
				$fields[$key] = substr_replace($value, '', 0, $prefix_len);
			}
		}
		
		foreach ($fields as $v)
		{ /* loop through the array of tables and drop them */
			$this->dbforge->drop_table($v);
		}
	}
}

/* End of file install_base.php */
/* Location: ./application/controllers/base/install_base.php */