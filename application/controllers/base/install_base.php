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
			2 - you must be a sysadmin to update the genre
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
			'options_database' => lang('install_index_options_database'),
			'options_genre' => lang('install_index_options_genre'),
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
	
	function changedb()
	{
		if (isset($_POST['submit']))
		{
			/* figure out what action we need to take */
			$action = $this->uri->segment(3);
			
			switch ($action)
			{
				case 'change':
					/* load the resources */
					$this->load->dbforge();
					
					/* get the type of modification we're making */
					$type = $this->uri->segment(4);
					
					switch ($type)
					{
						case 'table':
							/* get the table name */
							$table = $this->input->post('table_name', TRUE);
							
							/* add an id field to keep everything happy */
							$this->dbforge->add_field('id');
							
							/* add the table */
							$add = $this->dbforge->create_table($table, TRUE);
							
							if ($add === FALSE)
							{
								/* set the flash message */
								$flash['status'] = 'error';
								$flash['message'] = sprintf(
									lang_output('install_changedb_table_failure'),
									$this->db->dbprefix . $table
								);
							}
							else
							{
								/* set the flash message */
								$flash['status'] = 'success';
								$flash['message'] = sprintf(
									lang_output('install_changedb_table_success'),
									$this->db->dbprefix . $table
								);
							}
							
							break;
							
						case 'field':
							/* get the table name */
							$table = $this->input->post('table_name', TRUE);
							$name = $this->input->post('field_name', TRUE);
							$ftype = $this->input->post('field_type', TRUE);
							$constraint = $this->input->post('field_constraint', TRUE);
							$fvalue = $this->input->post('field_value', TRUE);
							
							if ($table !== 0)
							{
								$fields = array(
									$name => array(
										'type' => strtoupper($ftype),
										'constraint' => $constraint,
										'default' => (!empty($fvalue)) ? $fvalue : '',
									),
								);
								
								/* add an id field to keep everything happy */
								$add = $this->dbforge->add_column($table, $fields);
							}
							
							if (isset($add))
							{
								if ($add === FALSE)
								{
									/* set the flash message */
									$flash['status'] = 'error';
									$flash['message'] = sprintf(
										lang_output('install_changedb_field_failure'),
										$name,
										$this->db->dbprefix . $table
									);
								}
								else
								{
									/* set the flash message */
									$flash['status'] = 'success';
									$flash['message'] = sprintf(
										lang_output('install_changedb_field_success'),
										$name,
										$this->db->dbprefix . $table
									);
								}
							}
							else
							{
								/* set the flash message */
								$flash['status'] = 'error';
								$flash['message'] = lang_output('install_changedb_field_notable');
							}
							
							break;
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
					
					/* figure out where the view file should be coming from */
					$view_loc = view_location('changedb', '_base', 'install');
					
					break;
					
				case 'verify':
					/* load the resources */
					$this->load->model('system_model', 'sys');
					
					/* set the POST variables */
					$email = $this->input->post('email', TRUE);
					$password = $this->input->post('password', TRUE);
					
					/* verify their email/password combo is right */
					$verify = $this->auth->verify($email, $password);
					
					/* get their user ID */
					$user = $this->sys->get_item('users', 'email', $email, 'userid');
					
					/* verify they're a sys admin */
					$sysadmin = $this->auth->is_sysadmin($user);
					
					if ($verify == 0 && $sysadmin === TRUE)
					{
						/* get the database tables */
						$tables = $this->db->list_tables();
						
						$prefixlen = strpos($this->db->dbprefix, '_');
						
						/* create a blank array */
						$data['options'][0] = lang('install_changedb_choose');
						
						/* make sure we're only dealing with the nova tables */
						foreach ($tables as $key => $value)
						{
							if (substr($value, 0, $prefixlen) != $this->db->dbprefix)
							{
								/* remove the prefix from what will be the field value */
								$k = str_replace($this->db->dbprefix, '', $value);
								
								/* assign each table to the options array */
								$data['options'][$k] = $value;
							}
						}
						
						/* figure out where the view file should be coming from */
						$view_loc = view_location('changedb_main', '_base', 'install');
					}
					else
					{
						/* set the flash message */
						$flash['status'] = 'error';
						$flash['message'] = lang_output('error_verify_'. $verify);
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
						
						/* figure out where the view file should be coming from */
						$view_loc = view_location('changedb', '_base', 'install');
					}
					
					break;
			}
		}
		else
		{
			/* figure out where the view file should be coming from */
			$view_loc = view_location('changedb', '_base', 'install');
		}
		
		$data['inputs'] = array(
			'email' => array(
				'name' => 'email',
				'id' => 'email'),
			'password' => array(
				'name' => 'password',
				'id' => 'password'),
			'table_name' => array(
				'name' => 'table_name',
				'id' => 'table_name'),
			'field_name' => array(
				'name' => 'field_name',
				'id' => 'field_name'),
			'field_type' => array(
				'name' => 'field_type',
				'id' => 'field_type'),
			'field_constraint' => array(
				'name' => 'field_constraint',
				'id' => 'field_constraint'),
			'field_value' => array(
				'name' => 'field_value',
				'id' => 'field_value'),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('button_submit'))
			)
		);
		
		$data['label'] = array(
			'email' => ucwords(lang('global_email')),
			'password' => ucwords(lang('global_password')),
			'header_table' => lang('install_changedb_header_table'),
			'header_field' => lang('install_changedb_header_field'),
			'inst' => lang('install_changedb_inst'),
			'inst_table' => lang('install_changedb_inst_table'),
			'inst_field' => lang('install_changedb_inst_field'),
			'text' => sprintf(
				lang('global_content_sysadmin'),
				lang('global_update'),
				lang('global_update')),
			'prefix' => $this->db->dbprefix,
			'ftable' => lang('install_changedb_table'),
			'fname' => lang('install_changedb_name'),
			'fconstraint' => lang('install_changedb_constraint'),
			'fvalue' => lang('install_changedb_value'),
			'ftype' => lang('install_changedb_type'),
			'back' => lang('button_back_install'),
		);
		
		/* figure out where the view file should be coming from */
		$js_loc = js_location('genre_js', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_changedb_title'));
		$this->template->write('label', lang('install_changedb_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function genre()
	{
		if (isset($_POST['submit']))
		{
			/* figure out what action we need to take */
			$action = $this->uri->segment(3);
			
			switch ($action)
			{
				case 'change':
					/* load the resources */
					$this->load->dbforge();
					
					/* get the file to use */
					$file = $this->input->post('genre', TRUE);
					
					/* get the selected genre */
					$under = strpos($file, '_');
					$selected_genre = strtolower(substr($file, 0, $under));
					
					/* pull in the install fields asset file */
					include_once(APPPATH .'assets/install/fields.php');
					
					/* build an array of genre tables that need to be added */
					$tables = array(
						'departments_'. $selected_genre => array(
							'id' => 'dept_id',
							'fields' => $fields_departments),
						'positions_'. $selected_genre => array(
							'id' => 'pos_id',
							'fields' => $fields_positions),
						'ranks_'. $selected_genre => array(
							'id' => 'rank_id',
							'fields' => $fields_ranks),
					);
					
					foreach ($tables as $key => $value)
					{
						$this->dbforge->add_field($value['fields']);
						$this->dbforge->add_key($value['id'], TRUE);
						$this->dbforge->create_table($key, TRUE);
					}
					
					/* pull in the install genre data asset file */
					include_once(APPPATH .'assets/install/genres/'. $file);
					
					/* put the genre data in the newly created tables */
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$this->db->insert($key_d, $v);
						}
					}
					
					/* set the flash message */
					$flash['status'] = 'info';
					$flash['message'] = '<span class="icon ui-icon ui-icon-check"></span>';
					$flash['message'].= lang_output('install_genre_success');
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
					
					/* figure out where the view file should be coming from */
					$view_loc = view_location('genre', '_base', 'install');
					
					break;
					
				case 'verify':
					/* load the resources */
					$this->load->model('system_model', 'sys');
					
					/* set the POST variables */
					$email = $this->input->post('email', TRUE);
					$password = $this->input->post('password', TRUE);
					
					/* verify their email/password combo is right */
					$verify = $this->auth->verify($email, $password);
					
					/* get their user ID */
					$user = $this->sys->get_item('users', 'email', $email, 'userid');
					
					/* verify they're a sys admin */
					$sysadmin = $this->auth->is_sysadmin($user);
					
					if ($verify == 0 && $sysadmin === TRUE)
					{
						/* load the resources */
						$this->load->helper('directory');
						
						/* grab the files from the directory */
						$genre_files = directory_map(APPPATH .'assets/install/genres/', TRUE);
						
						/* grab the genre and find out it's length */
						$genre = strtolower(GENRE);
						$genrelen = strlen($genre);
						
						foreach ($genre_files as $key => $g)
						{
							/* if the file is index.html or the current genre's data file, ignore it */
							if ($g == 'index.html' || substr($g, 0, $genrelen) == $genre)
							{
								unset($genre_files[$key]);
							}
						}
						
						/* send the list of genres to the view */
						$data['files'] = $genre_files;
						
						/* figure out where the view file should be coming from */
						$view_loc = view_location('genre_main', '_base', 'install');
					}
					else
					{
						/* set the flash message */
						$flash['status'] = 'error';
						$flash['message'] = lang_output('error_verify_'. $verify);
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
						
						/* figure out where the view file should be coming from */
						$view_loc = view_location('genre', '_base', 'install');
					}
					
					break;
			}
		}
		else
		{
			/* figure out where the view file should be coming from */
			$view_loc = view_location('genre', '_base', 'install');
		}
		
		$data['inputs'] = array(
			'email' => array(
				'name' => 'email',
				'id' => 'email'),
			'password' => array(
				'name' => 'password',
				'id' => 'password'),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('button_submit'))
			)
		);
		
		$data['label'] = array(
			'email' => ucwords(lang('global_email')),
			'password' => ucwords(lang('global_password')),
			'text' => sprintf(
				lang('global_content_sysadmin'),
				lang('global_update'),
				lang('global_update')),
			'genre' => lang('global_genre'),
			'genre_inst' => lang('install_genre_inst'),
			'back' => lang('button_back_install'),
		);
		
		/* figure out where the view file should be coming from */
		$js_loc = js_location('genre_js', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('install_genre_title'));
		$this->template->write('label', lang('install_genre_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function readme()
	{
		/* figure out where the view file should be coming from */
		$view_loc = view_location('readme', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', APP_NAME .' '. lang('global_readme_title'));
		$this->template->write('label', APP_NAME .' '. lang('global_readme_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		
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
			/* load the resources */
			$this->load->model('system_model', 'sys');
			
			/* set the POST variables */
			$email = $this->input->post('email', TRUE);
			$password = $this->input->post('password', TRUE);
			
			/* verify their email/password combo is right */
			$verify = $this->auth->verify($email, $password);
			
			/* get their user ID */
			$user = $this->sys->get_item('users', 'email', $email, 'userid');
			
			/* verify they're a sys admin */
			$sysadmin = $this->auth->is_sysadmin($user);
			
			if ($verify == 0 && $sysadmin === TRUE)
			{
				/* remove the data */
				$this->_destroy_data();
				
				/* set the flash info */
				$flash['status'] = 'success';
				$flash['message'] = lang_output('install_remove_success');
			}
			else
			{
				/* set the flash info */
				$flash['status'] = 'error';
				$flash['message'] = lang_output('error_verify_'. $verify);
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
			'content' => ucwords(lang('button_clear'))
		);
		
		$data['label'] = array(
			'back' => lang('button_back_install'),
			'email' => lang('global_email'),
			'password' => lang('global_password'),
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
					'content' => ucwords(lang('button_next'))
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
					'content' => ucwords(lang('button_next'))
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
					'content' => ucwords(lang('button_next'))
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
					'user' => lang('install_step3_user'),
					'name' => lang('install_step3_name'),
					'email' => lang('global_email'),
					'password' => lang('global_password'),
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
				$this->load->model('users_model', 'user');
				$this->load->model('characters_model', 'char');
				$this->load->model('positions_model', 'pos');
				$this->load->model('system_model', 'sys');
				$this->load->model('ranks_model', 'ranks');
				
				if ($submit != FALSE)
				{
					$insert = array();
					
					/* build the create user array */
					$create_user = array(
						'name'				=> $this->input->post('real_name', TRUE),
						'email'				=> $this->input->post('email', TRUE),
						'password'			=> $this->auth->hash($this->input->post('password', TRUE)),
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
					
					/* insert the user data */
					$c_user = $this->user->create_user($create_user);
					$insert[] = $c_user;
					
					/* get the ID from the user insert */
					$p_id = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('users');
					
					/* create the user prefs */
					$prefs = $this->user->create_user_prefs($p_id);
					$insert[] = $prefs;
					
					/* build the create character array */
					$create_character = array(
						'user'			=> $p_id,
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
					
					/* optimize the table */
					$this->sys->optimize_table('characters');
					
					$characters = array('main_char' => $c_id);
					
					/* update the users table */
					$this->user->update_user($p_id, $characters);
					
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
					'content' => ucwords(lang('button_next'))
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
					'on' => ucfirst(lang('global_on')),
					'off' => ucfirst(lang('global_off'))
				);
				
				$data['updates_v'] = array(
					'all' => lang('install_step4_updates_all'),
					'major' => lang('install_step4_updates_maj'),
					'minor' => lang('install_step4_updates_min'),
					'update' => lang('install_step4_updates_incr'),
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
				
				if (ini_get('allow_url_fopen') != 1)
				{
					$flash['status'] = 'info';
					$flash['message'] = lang_output('install_step4_filehandle');
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/install/pages/flash', $flash);
				}
				
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
					
					/* install the skins and ranks */
					$this->_install_ranks();
					$this->_install_skins();
					
					/* do the product registration */
					//$this->_register();
					
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
					'site' => lang('button_site'),
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
			'back' => lang('button_back_install'),
			'text' => lang('verify_text')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('verify', '_base', 'install');
		
		/* set the title */
		$this->template->write('title', lang('verify_title'));
		$this->template->write('label', lang('verify_title'));
				
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
	
	function _install_ranks()
	{
		/* load the resources */
		$this->load->helper('directory');
		$this->load->helper('yayparser');
		$this->load->model('ranks_model', 'ranks');
		
		$dir = directory_map(APPPATH .'assets/common/'. GENRE .'/ranks/', TRUE);
		
		$ranks = $this->ranks->get_all_rank_sets('');
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $rank)
			{
				$key = array_search($rank->rankcat_location, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			/* create an array of items that shouldn't be included in the dir listing */
			$pop = array('index.html');
			
			/* make sure the items aren't in the listing */
			foreach ($pop as $value)
			{
				$key = array_search($value, $dir);
				
				if ($key !== FALSE)
				{
					unset($dir[$key]);
				}
			}
			
			/* make sure these are items that can use quick install */
			foreach ($dir as $key => $value)
			{
				if (file_exists(APPPATH .'assets/common/'. GENRE .'/ranks/'. $value .'/rank.yml'))
				{
					/* get the contents of the file */
					$contents = file_get_contents(APPPATH .'assets/common/'. GENRE .'/ranks/'. $selection .'/rank.yml');
					
					/* parse the contents of the yaml file */
					$array = yayparser($contents);
					
					/* create the skin array */
					$set = array(
						'rankcat_name'		=> $array['rank'],
						'rankcat_location'	=> $array['location'],
						'rankcat_credits'	=> $array['credits'],
						'rankcat_preview'	=> $array['preview'],
						'rankcat_blank'		=> $array['blank'],
						'rankcat_extension'	=> $array['extension'],
						'rankcat_url'		=> $array['url'],
					);
					
					/* insert the record */
					$this->ranks->add_rank_set($set);
				}
			}
		}
	}
	
	function _install_skins()
	{
		/* load the resources */
		$this->load->helper('directory');
		$this->load->helper('yayparser');
		
		/* map the views directory */
		$viewdirs = directory_map(APPPATH .'views/', TRUE);
		
		$skins = $this->sys->get_all_skins();
		
		if ($skins->num_rows() > 0)
		{
			foreach ($skins->result() as $skin)
			{
				$key = array_search($skin->skin_location, $viewdirs);
				
				if ($key !== FALSE)
				{
					unset($viewdirs[$key]);
				}
			}
		}
		
		/* create an array of items that shouldn't be included in the dir listing */
		$pop = array('_base', '_base_override', 'index.html', 'template.php');
		
		/* make sure the items aren't in the listing */
		foreach ($pop as $value)
		{
			$key = array_search($value, $viewdirs);
			
			if ($key !== FALSE)
			{
				unset($viewdirs[$key]);
			}
		}
		
		foreach ($viewdirs as $key => $value)
		{
			if (file_exists(APPPATH .'views/'. $value .'/skin.yml'))
			{
				/* get the contents of the file */
				$contents = file_get_contents(APPPATH .'views/'. $value .'/skin.yml');
				
				/* parse the contents of the yaml file */
				$array = yayparser($contents);
				
				/* create the skin array */
				$skin = array(
					'skin_name'		=> $array['skin'],
					'skin_location'	=> $array['location'],
					'skin_credits'	=> $array['credits']
				);
				
				/* insert the record */
				$this->sys->add_skin($skin);

				foreach ($array['sections'] as $v)
				{
					$section = array(
						'skinsec_section'			=> $v['type'],
						'skinsec_skin'				=> $array['location'],
						'skinsec_image_preview'		=> $v['preview'],
						'skinsec_status'			=> 'active',
						'skinsec_default'			=> 'n'
					);
					
					/* insert the record */
					$this->sys->add_skin_section($section);
				}
			}
		}
	}
	
	function _register()
	{
		/* load the resources */
		$this->load->library('xmlrpc');
		
		/* set up the server and method for the request */
		$this->xmlrpc->server('http://localhost/anodyne/code/www/index.php/utility/do_registration', 80);
		$this->xmlrpc->method('Do_Registration');
		
		/* build the request */
		$request = array(
			APP_NAME,
			APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
			base_url(),
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['SERVER_ADDR'],
			phpversion(),
			$this->db->platform(),
			$this->db->version(),
			'install',
			'install'
		);
		
		/* send the request */
		$this->xmlrpc->request($request);
	}
}

/* End of file install_base.php */
/* Location: ./application/controllers/base/install_base.php */