<?php
/*
|---------------------------------------------------------------
| UPGRADE CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/upgrade_base.php
| System Version: 1.0
|
| Controller that handles the upgrading SMS to Nova
|
*/

class Upgrade_base extends Controller {
	
	function Upgrade_base()
	{
		parent::Controller();
		
		/* load the system and archive models */
		$this->load->model('system_model', 'sys');
		
		/* set the template */
		$this->template->set_template('update');
		$this->template->set_master_template('_base/template_update.php');
		
		/* write the common elements to the template */
		$this->template->write('title', APP_NAME .' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('app');
		$this->lang->load('install');
		
		/* load the resources */
		$this->load->model('system_model', 'sys');
		
		/* check to see if the system is installed */
		$d['installed'] = $this->sys->check_install_status();
		
		/* build the options menu */
		$this->template->write_view('update_options', '_base/update/pages/_options_upgrade', $d);
	}

	function index()
	{
		/* load the resources */
		$this->load->model('archive_model', 'arc');
		
		/* run the methods */
		$installed = $this->sys->check_install_status();
		$data['installed'] = $installed;
		
		/* grab the tables */
		$tables = $this->db->list_tables();
		
		/* make sure there are SMS tables */
		foreach ($tables as $key => $t)
		{
			if (substr($t, 0, 4) != 'sms_')
			{
				unset($tables[$key]);
			}
		}
		
		/* if there aren't SMS tables, redirect to the error page */
		if (count($tables) == 0)
		{
			redirect('upgrade/error/2');
		}
		
		/* grab the SMS version */
		$sms = $this->arc->get_sms_version();
		$sms_ver = str_replace('.', '', $sms);
		$sms_const = str_replace('.', '', SMS_UPGRADE_VERSION);
		$status = 0;
		
		/* determine the status */
		$status = (GENRE != 'ds9') ? 4 : $status;
		$status = ($sms === FALSE) ? 1 : $status;
		$status = ($sms_ver < $sms_const) ? 2 : $status;
		$status = ($installed === TRUE) ? 3 : $status;
		
		if ($status > 0)
		{
			$flash['status'] = '';
			$flash['message'] = '';
			
			if ($status == 1)
			{
				$flash['status'] = 'error';
				$flash['message'] = sprintf(
					lang('upg_error_1'),
					SMS_UPGRADE_VERSION,
					SMS_UPGRADE_VERSION
				);
			}
			elseif ($status == 2)
			{
				$flash['status'] = 'error';
				$flash['message'] = lang('upg_error_2');
			}
			elseif ($status == 3)
			{
				$flash['status'] = 'error';
				$flash['message'] = lang('upg_error_3');
			}
			elseif ($status == 4)
			{
				$flash['status'] = 'error';
				$flash['message'] = sprintf(
					lang('upg_error_4'),
					strtoupper(GENRE)
				);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
		}
		
		$data['label'] = array(
			'text' => lang('upg_info'),
			'intro' => lang('global_content_index'),
			'title' => lang('upg_index_header'),
			'options_readme' => lang('install_index_options_readme'),
			'options_tour' => lang('install_index_options_tour'),
			'options_verify' => lang('install_index_options_verify'),
			'options_guide' => lang('install_index_options_upg_guide'),
			'firststeps' => lang('install_index_options_firststeps'),
			'whatsnext' => lang('install_index_options_whatsnext'),
			'intro' => lang('global_content_index'),
		);
		
		$data['next'] = array(
			'type' => 'submit',
			'class' => 'button',
			'name' => 'next',
			'value' => 'next',
			'id' => 'next',
			'content' => ucwords(lang('button_begin'))
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('upgrade_index', '_base', 'update');
		$js_loc = js_location('upgrade_index_js', '_base', 'update');
		
		/* build the next step control */
		$control = '<a href="'. site_url('upgrade/verify') .'" class="btn">'. lang('install_index_options_verify') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('upg_index_title'));
		$this->template->write('label', lang('upg_index_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function error()
	{
		/*
			0 - no errors
			1 - sms prior to 2.6.0
			2 - sms not installed
			3 - system already installed
			4 - ds9 genre not being used
		*/
		
		$id = $this->uri->segment(3, 0);
		
		$label = array(
			'error_1' => sprintf(
				lang('upg_error_1'),
				SMS_UPGRADE_VERSION,
				SMS_UPGRADE_VERSION
			),
			'error_2' => lang('upg_error_2'),
			'error_3' => lang('upg_error_3'),
			'error_4' => sprintf(
				lang('upg_error_4'),
				strtoupper(GENRE)
			),
			'back' => lang('upg_verify_back'),
		);
		
		$flash['status'] = 'error';
		$flash['message'] = $label['error_'. $id];
		
		/* write everything to the template */
		$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('upgrade_error', '_base', 'update');
		
		$control = '<a href="'. site_url('upgrade/index') .'" class="btn">'. lang('button_back_upgrade') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('upg_error_title'));
		$this->template->write('label', lang('upg_error_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function info()
	{
		$data['label'] = array(
			'text' => lang('upg_info')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('upgrade_info', '_base', 'update');
		$js_loc = js_location('upgrade_info_js', '_base', 'update');
		
		/* build the next step control */
		$control = '<a href="'. site_url('upgrade/step/1') .'" class="btn" id="next">'. lang('button_begin') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('upg_more_info'));
		$this->template->write('label', lang('upg_more_info'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function readme()
	{
		/* figure out where the view file should be coming from */
		$view_loc = view_location('readme', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', APP_NAME .' '. lang('global_readme_title'));
		$this->template->write('label', APP_NAME .' '. lang('global_readme_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function step()
	{
		/* change the time limit */
		set_time_limit(0);
		
		/* load the resources */
		$this->load->dbforge();
		$this->config->load('sms');
		
		/* set the variables */
		$step = $this->uri->segment(3, 1);
		$upgrade = $this->config->item('sms');
		
		switch ($step)
		{
			case 1:
				/* clear the memory limit to attempt the backup */
				ini_set('memory_limit', -1);
				
				/* load the resources */
				$this->load->helper('utility');
				
				/* set the prefix */
				$prefix = 'sms_';
				
				/* check the database size and the server memory limit */
				$db_size = file_size($this->sys->get_database_size());
				$memory = check_memory($db_size);
				
				if ($memory === TRUE)
				{ /* if there's enough memory, continue */
					$backup = backup_database($prefix, 'save');
					
					if ($backup === TRUE)
					{
						if (is_file(APPPATH .'assets/backups/sms_backup.zip'))
						{
							$message = lang('upg_step1_success');
						}
						else
						{
							$message = lang('upg_step1_failure');
						}
					}
					else
					{
						$message = lang('upg_step1_nofields');
						$data['next']['disabled'] = TRUE;
					}
				}
				else
				{
					$message = lang('upg_step1_memory');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('upgrade_step_1', '_base', 'update');
				$js_loc = js_location('upgrade_step_1_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/2') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title and label */
				$this->template->write('title', lang('upg_step1_title'));
				$this->template->write('label', lang('upg_step1_label'));
				
				break;
				
			case 2:
				/*
				 * CREATE THE NOVA TABLES
				 */
				
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
				
				$message = (count($table) > 0) ? lang('upg_step2_failure') : lang('upg_step2_success');
				
				if (count($table) > 0)
				{
					$control = '';
				}
				else
				{
					/* build the next step control */
					$control = '<a href="'. site_url('upgrade/step/3') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('upgrade_step_2', '_base', 'update');
				$js_loc = js_location('upgrade_step_2_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upg_step2_title'));
				$this->template->write('label', lang('upg_step2_label'));
				
				break;
				
			case 3:
				/* 
				 * INSERT BASIC NOVA DATA
				 */
				 
				/* pull in the install data asset file */
				include_once(APPPATH .'assets/install/data_basic.php');
				
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
				
				$message = (count($insert) > 0) ? lang('upg_step3_failure') : lang('upg_step3_success');
				
				if (count($insert) > 0)
				{
					$control = '';
				}
				else
				{
					/* build the next step control */
					$control = '<a href="'. site_url('upgrade/step/4') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('upgrade_step_3', '_base', 'update');
				$js_loc = js_location('upgrade_step_3_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upg_step3_title'));
				$this->template->write('label', lang('upg_step3_label'));
				
				break;
				
			case 4:
				/*
				 * INSERT NOVA GENRE DATA
				 */
				 
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
				
				$message = (count($genre) > 0) ? lang('upg_step4_failure') : lang('upg_step4_success');
				
				if (count($genre) > 0)
				{
					$control = '';
				}
				else
				{
					/* build the next step control */
					$control = '<a href="'. site_url('upgrade/step/5') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				}
					
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_4', '_base', 'update');
				$js_loc = js_location('upgrade_step_4_js', '_base', 'update');
				
				/* set the title */
				$this->template->write('title', lang('upg_step4_title'));
				$this->template->write('label', lang('upg_step4_label'));
				
				break;
				
			case 5:
				/*
				 * GLOBALS
				 */
				 
				if ($upgrade['settings'] === TRUE)
				{
					/* first we have to make sure they haven't changed their globals table */
					if ($this->db->table_exists('sms_settings'))
					{
						$query = $this->db->query('SELECT * FROM sms_settings WHERE globalid = 1');
					}
					else
					{
						$query = $this->db->query('SELECT * FROM sms_globals WHERE globalid = 1');
					}
					
					/* get the row object */
					$row = $query->row();
					
					/* build the array of what we're going to upgrade */
					$update = array(
						'sim_name' => array(
							'setting_value' => $row->shipPrefix .' '. $row->shipName .' '. $row->shipRegistry),
						'sim_year' => array(
							'setting_value' => $row->simmYear),
						'posting_requirement' => array(
							'setting_value' => $row->postCountDefault),
						'post_count_format' => array(
							'setting_value' => ($row->jpCount == 'y') ? 'multiple' : 'single'),
						'email_subject' => array(
							'setting_value' => $row->emailSubject)
					);
					
					/* grab the site messages */
					$query = $this->db->query('SELECT * FROM sms_messages WHERE messageid = 1');
					$row = $query->row();
					
					/* build the array of messages we're going to update */
					$messages = array(
						'welcome_msg' => array(
							'message_content' => $row->welcomeMessage),
						'sim' => array(
							'message_content' => $row->simmMessage),
						'join_disclaimer' => array(
							'message_content' => $row->joinDisclaimer),
						'accept_message' => array(
							'message_content' => $row->acceptMessage),
						'reject_message' => array(
							'message_content' => $row->rejectMessage),
						'join_post' => array(
							'message_content' => $row->samplePostQuestion),
					);
					
					/* start the count */
					$count = 0;
					
					foreach ($update as $key => $value)
					{ /* loop through and update the settings */
						$count += $this->settings->update_setting($key, $value);
					}
					
					foreach ($messages as $key => $value)
					{ /* loop through and update the messages */
						$count += $this->msgs->update_message($value, $key);
					}
					
					/* set the message */
					$message = (count($count) < 1) ? lang('upg_step5_failure') : lang('upg_step5_success');
				}
				else
				{
					/* set the message */
					$message = lang('upg_step5_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_5', '_base', 'update');
				$js_loc = js_location('upgrade_step_5_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/6') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step5_title'));
				$this->template->write('label', lang('upg_step5_label'));
				
				break;
				
			case 6:
				/*
				 * AWARDS
				 */
				 
				if ($upgrade['awards'] === TRUE)
				{
					/* load the resources */
					$this->load->model('awards_model', 'awards');
					
					/* drop the nova version of the table */
					$this->dbforge->drop_table('awards');
					
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'awards SELECT * FROM sms_awards');
					
					$query = $this->db->query('SELECT * FROM sms_awards');
					$awd_before = $query->num_rows();
					
					/* rename the fields to appropriate names */
					$fields = array(
						'awardid' => array(
							'name' => 'award_id',
							'type' => 'INT',
							'constraint' => 5),
						'awardName' => array(
							'name' => 'award_name',
							'type' => 'VARCHAR',
							'constraint' => 255),
						'awardImage' => array(
							'name' => 'award_image',
							'type' => 'VARCHAR',
							'constraint' => 100),
						'awardOrder' => array(
							'name' => 'award_order',
							'type' => 'INT',
							'constraint' => 5),
						'awardDesc' => array(
							'name' => 'award_desc',
							'type' => 'TEXT'),
						'awardCat' => array(
							'name' => 'award_cat',
							'type' => 'ENUM',
							'constraint' => "'ic','ooc','both'",
							'default' => 'ic'),
					);
					
					$this->dbforge->modify_column('awards', $fields);
					
					/* add the award_display column */
					$add = array(
						'award_display' => array(
							'type' => 'ENUM',
							'constraint' => "'y','n'",
							'default' => 'y')
					);
					
					$this->dbforge->add_column('awards', $add);
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'awards MODIFY COLUMN `award_id` INT(5) auto_increment primary key');
					
					$query = $this->awards->get_all_awards('asc', '');
					$awd_after = $query->num_rows();
					
					/* set the message */
					$message = ($awd_before = $awd_after) ? lang('upg_step6_success') : lang('upg_step6_failure');
				}
				else
				{
					$message = lang('upg_step6_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_6', '_base', 'update');
				$js_loc = js_location('upgrade_step_6_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/7') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step6_title'));
				$this->template->write('label', lang('upg_step6_label'));
				
				break;
				
			case 7:
				/*
				 * MISSIONS
				 */
				if ($upgrade['missions'] === TRUE)
				{
					/* load the resources */
					$this->load->model('missions_model', 'mis');
					
					/* drop the nova version of the table */
					$this->dbforge->drop_table('missions');
					
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'missions SELECT * FROM sms_missions');
					
					$query = $this->db->query('SELECT * FROM sms_missions');
					$mis_before = $query->num_rows();
					
					/* rename the fields to appropriate names */
					$fields = array(
						'missionid' => array(
							'name' => 'mission_id',
							'type' => 'INT',
							'constraint' => 8),
						'missionOrder' => array(
							'name' => 'mission_order',
							'type' => 'INT',
							'constraint' => 5),
						'missionTitle' => array(
							'name' => 'mission_title',
							'type' => 'VARCHAR',
							'constraint' => 150),
						'missionImage' => array(
							'name' => 'mission_images',
							'type' => 'TEXT'),
						'missionStatus' => array(
							'name' => 'mission_status',
							'type' => 'ENUM',
							'constraint' => "'upcoming','current','completed'",
							'default' => 'upcoming'),
						'missionStart' => array(
							'name' => 'mission_start',
							'type' => 'BIGINT',
							'constraint' => 20),
						'missionEnd' => array(
							'name' => 'mission_end',
							'type' => 'BIGINT',
							'constraint' => 20),
						'missionDesc' => array(
							'name' => 'mission_desc',
							'type' => 'TEXT'),
						'missionSummary' => array(
							'name' => 'mission_summary',
							'type' => 'TEXT'),
						'missionNotes' => array(
							'name' => 'mission_notes',
							'type' => 'TEXT'),
					);
					
					$this->dbforge->modify_column('missions', $fields);
					
					/* add the award_display column */
					$add = array(
						'mission_notes_updated' => array(
							'type' => 'BIGINT',
							'constraint' => 20)
					);
					
					$this->dbforge->add_column('missions', $add);
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'missions MODIFY COLUMN `mission_id` INT(8) auto_increment primary key');
					
					$query = $this->mis->get_all_missions();
					$mis_after = $query->num_rows();
					
					/* set the message */
					$message = ($mis_before = $mis_after) ? lang('upg_step7_success') : lang('upg_step7_failure');
				}
				else
				{
					$message = lang('upg_step7_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_7', '_base', 'update');
				$js_loc = js_location('upgrade_step_7_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/8') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step7_title'));
				$this->template->write('label', lang('upg_step7_label'));
				
				break;
				
			case 8:
				/*
				 * NEWS CATEGORIES & ITEMS
				 */
				if ($upgrade['news'] === TRUE)
				{
					/* load the resources */
					$this->load->model('news_model', 'news');
					
					/* drop the nova version of the table */
					$this->dbforge->drop_table('news');
					$this->dbforge->drop_table('news_categories');
					
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'news_categories SELECT * FROM sms_news_categories');
					
					/* rename the fields to appropriate names */
					$fields = array(
						'catid' => array(
							'name' => 'newscat_id',
							'type' => 'INT',
							'constraint' => 5),
						'catName' => array(
							'name' => 'newscat_name',
							'type' => 'VARCHAR',
							'constraint' => 150),
						'catVisible' => array(
							'name' => 'newscat_display',
							'type' => 'ENUM',
							'constraint' => "'y','n'",
							'default' => 'y'),
					);
					
					$this->dbforge->modify_column('news_categories', $fields);
					
					/* remove the user level column */
					$this->dbforge->drop_column('news_categories', 'catUserLevel');
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'news_categories MODIFY COLUMN `newscat_id` INT(5) auto_increment primary key');
					
					/*
					 * NEWS ITEMS
					 */
					 
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'news SELECT * FROM sms_news');
					
					$query = $this->db->query('SELECT * FROM sms_news');
					$news_before = $query->num_rows();
					
					/* rename the fields to appropriate names */
					$fields = array(
						'newsid' => array(
							'name' => 'news_id',
							'type' => 'INT',
							'constraint' => 8),
						'newsCat' => array(
							'name' => 'news_cat',
							'type' => 'INT',
							'constraint' => 3),
						'newsAuthor' => array(
							'name' => 'news_author_character',
							'type' => 'INT',
							'constraint' => 5),
						'newsPosted' => array(
							'name' => 'news_date',
							'type' => 'BIGINT',
							'constraint' => 20),
						'newsTitle' => array(
							'name' => 'news_title',
							'type' => 'VARCHAR',
							'constraint' => 150,
							'default' => 'upcoming'),
						'newsContent' => array(
							'name' => 'news_content',
							'type' => 'TEXT'),
						'newsStatus' => array(
							'name' => 'news_status',
							'type' => 'ENUM',
							'constraint' => "'activated','saved','pending'",
							'default' => 'activated'),
						'newsPrivate' => array(
							'name' => 'news_private',
							'type' => 'ENUM',
							'constraint' => "'y','n'",
							'default' => 'n'),
					);
					
					$this->dbforge->modify_column('news', $fields);
					
					/* add the award_display column */
					$add = array(
						'news_author_user' => array(
							'type' => 'INT',
							'constraint' => 5),
						'news_tags' => array(
							'type' => 'TEXT'),
						'news_last_update' => array(
							'type' => 'BIGINT',
							'constraint' => 20)
					);
					
					$this->dbforge->add_column('news', $add);
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'news MODIFY COLUMN `news_id` INT(8) auto_increment primary key');
					
					$news_after = $this->news->count_news_items('');
					
					/* set the message */
					$message = ($news_before = $news_after) ? lang('upg_step8_success') : lang('upg_step8_failure');
				}
				else
				{
					$message = lang('upg_step8_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_8', '_base', 'update');
				$js_loc = js_location('upgrade_step_8_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/9') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step8_title'));
				$this->template->write('label', lang('upg_step8_label'));
				
				break;
				
			case 9:
				/*
				 * PERSONAL LOGS
				 */
				if ($upgrade['logs'] === TRUE)
				{
					/* load the resources */
					$this->load->model('personallogs_model', 'logs');
					
					/* drop the nova version of the table */
					$this->dbforge->drop_table('personallogs');
					
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'personallogs SELECT * FROM sms_personallogs');
					
					$query = $this->db->query('SELECT * FROM sms_personallogs');
					$logs_before = $query->num_rows();
					
					/* rename the fields to appropriate names */
					$fields = array(
						'logid' => array(
							'name' => 'log_id',
							'type' => 'INT',
							'constraint' => 5),
						'logAuthor' => array(
							'name' => 'log_author_character',
							'type' => 'INT',
							'constraint' => 5),
						'logPosted' => array(
							'name' => 'log_date',
							'type' => 'BIGINT',
							'constraint' => 20),
						'logTitle' => array(
							'name' => 'log_title',
							'type' => 'VARCHAR',
							'constraint' => 150,
							'default' => 'upcoming'),
						'logContent' => array(
							'name' => 'log_content',
							'type' => 'TEXT'),
						'logStatus' => array(
							'name' => 'log_status',
							'type' => 'ENUM',
							'constraint' => "'activated','saved','pending'",
							'default' => 'activated'),
					);
					
					$this->dbforge->modify_column('personallogs', $fields);
					
					/* add the award_display column */
					$add = array(
						'log_author_user' => array(
							'type' => 'INT',
							'constraint' => 5),
						'log_tags' => array(
							'type' => 'TEXT'),
						'log_last_update' => array(
							'type' => 'BIGINT',
							'constraint' => 20)
					);
					
					$this->dbforge->add_column('personallogs', $add);
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'personallogs MODIFY COLUMN `log_id` INT(5) auto_increment primary key');
					
					$logs_after = $this->logs->count_all_logs('');
					
					/* set the message */
					$message = ($logs_before = $logs_after) ? lang('upg_step9_success') : lang('upg_step9_failure');
				}
				else
				{
					$message = lang('upg_step9_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_9', '_base', 'update');
				$js_loc = js_location('upgrade_step_9_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/10') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step9_title'));
				$this->template->write('label', lang('upg_step9_label'));
				
				break;
				
			case 10:
				/*
				 * MISSION POSTS
				 */
				if ($upgrade['posts'] === TRUE)
				{
					/* load the resources */
					$this->load->model('posts_model', 'posts');
					
					/* drop the nova version of the table */
					$this->dbforge->drop_table('posts');
					
					/* copy the sms version of the table along with all its data */
					$this->db->query('CREATE TABLE '. $this->db->dbprefix .'posts SELECT * FROM sms_posts');
					
					$query = $this->db->query('SELECT * FROM sms_posts');
					$posts_before = $query->num_rows();
					
					/* rename the fields to appropriate names */
					$fields = array(
						'postid' => array(
							'name' => 'post_id',
							'type' => 'INT',
							'constraint' => 8),
						'postAuthor' => array(
							'name' => 'post_authors',
							'type' => 'TEXT'),
						'postPosted' => array(
							'name' => 'post_date',
							'type' => 'BIGINT',
							'constraint' => 20),
						'postTitle' => array(
							'name' => 'post_title',
							'type' => 'VARCHAR',
							'constraint' => 150,
							'default' => ''),
						'postContent' => array(
							'name' => 'post_content',
							'type' => 'TEXT'),
						'postStatus' => array(
							'name' => 'post_status',
							'type' => 'ENUM',
							'constraint' => "'activated','saved','pending'",
							'default' => 'activated'),
						'postLocation' => array(
							'name' => 'post_location',
							'type' => 'VARCHAR',
							'constraint' => 150,
							'default' => ''),
						'postTimeline' => array(
							'name' => 'post_timeline',
							'type' => 'VARCHAR',
							'constraint' => 150,
							'default' => ''),
						'postMission' => array(
							'name' => 'post_mission',
							'type' => 'INT',
							'constraint' => 8),
						'postSave' => array(
							'name' => 'post_saved',
							'type' => 'INT',
							'constraint' => 11),
					);
					
					$this->dbforge->modify_column('posts', $fields);
					
					/* add the award_display column */
					$add = array(
						'post_authors_users' => array(
							'type' => 'TEXT'),
						'post_tags' => array(
							'type' => 'TEXT'),
						'post_last_update' => array(
							'type' => 'BIGINT',
							'constraint' => 20)
					);
					
					$this->dbforge->add_column('posts', $add);
					
					/* remove the tag column */
					$this->dbforge->drop_column('posts', 'postTag');
					
					/* make award_id auto increment and the primary key */
					$this->db->query('ALTER TABLE '. $this->db->dbprefix .'posts MODIFY COLUMN `post_id` INT(8) auto_increment primary key');
					
					$posts_after = $this->posts->count_all_posts('', '');
					
					/* set the message */
					$message = ($posts_before = $posts_after) ? lang('upg_step10_success') : lang('upg_step10_failure');
				}
				else
				{
					$message = lang('upg_step10_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_10', '_base', 'update');
				$js_loc = js_location('upgrade_step_10_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/11') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step10_title'));
				$this->template->write('label', lang('upg_step10_label'));
				
				break;
				
			case 11:
				/*
				 * SPECIFICATIONS
				 */
				if ($upgrade['specs'] === TRUE)
				{
					/* load the resources */
					$this->load->model('specs_model', 'specs');
					
					$query = $this->db->query('SELECT * FROM sms_specs WHERE specid = 1');
					$row = $query->row();
					
					$specs = array(
						1 => array(
							'data_value' => $row->shipClass,
							'data_updated' => now()),
						2 => array(
							'data_value' => $row->shipRole,
							'data_updated' => now()),
						3 => array(
							'data_value' => $row->duration,
							'data_updated' => now()),
						4 => array(
							'data_value' => $row->refit .' '. $row->refitUnit,
							'data_updated' => now()),
						5 => array(
							'data_value' => $row->resupply .' '. $row->resupplyUnit,
							'data_updated' => now()),
						6 => array(
							'data_value' => $row->length,
							'data_updated' => now()),
						7 => array(
							'data_value' => $row->width,
							'data_updated' => now()),
						8 => array(
							'data_value' => $row->height,
							'data_updated' => now()),
						9 => array(
							'data_value' => $row->decks,
							'data_updated' => now()),
						10 => array(
							'data_value' => $row->complimentOfficers,
							'data_updated' => now()),
						11 => array(
							'data_value' => $row->complimentEnlisted,
							'data_updated' => now()),
						12 => array(
							'data_value' => $row->complimentMarines,
							'data_updated' => now()),
						13 => array(
							'data_value' => $row->complimentCivilians,
							'data_updated' => now()),
						14 => array(
							'data_value' => $row->complimentEmergency,
							'data_updated' => now()),
						15 => array(
							'data_value' => $row->warpCruise,
							'data_updated' => now()),
						16 => array(
							'data_value' => $row->warpMaxCruise .' '. $row->warpMaxTime,
							'data_updated' => now()),
						17 => array(
							'data_value' => $row->warpEmergency .' '. $row->warpEmergencyTime,
							'data_updated' => now()),
						18 => array(
							'data_value' => $row->shields,
							'data_updated' => now()),
						19 => array(
							'data_value' => $row->defensive,
							'data_updated' => now()),
						20 => array(
							'data_value' => $row->phasers ."\r\n\r\n". $row->torpedoLaunchers ."\r\n\r\n". $row->torpedoCompliment,
							'data_updated' => now()),
						21 => array(
							'data_value' => $row->shuttlebays,
							'data_updated' => now()),
						22 => array(
							'data_value' => $row->shuttles,
							'data_updated' => now()),
						23 => array(
							'data_value' => $row->fighters,
							'data_updated' => now()),
						24 => array(
							'data_value' => $row->runabouts,
							'data_updated' => now()),
					);
					
					$count = 0;
					
					foreach ($specs as $key => $value)
					{
						$count += $this->specs->update_spec_field_data($key, $value);
					}
					
					/* set the message */
					$message = ($count == 24) ? lang('upg_step11_success') : lang('upg_step11_failure');
				}
				else
				{
					$message = lang('upg_step11_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_11', '_base', 'update');
				$js_loc = js_location('upgrade_step_11_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/12') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step11_title'));
				$this->template->write('label', lang('upg_step11_label'));
				
				break;
				
			case 12:
				/*
				 * TOUR ITEMS
				 */
				if ($upgrade['tour'] === TRUE)
				{
					/* load the resources */
					$this->load->model('tour_model', 'tour');
					
					$query = $this->db->query('SELECT * FROM sms_tour');
					$before_count = $query->num_rows();
					
					$count = 0;
					
					if ($query->num_rows() > 0)
					{
						foreach ($query->result() as $t)
						{
							$images = array($t->tourPicture1, $t->tourPicture2, $t->tourPicture3);
							
							foreach ($images as $key => $value)
							{
								if (empty($value))
								{
									unset($images[$key]);
								}
							}
							
							/* make the array a string */
							$images = implode(',', $images);
							
							/* insert the main tour item */
							$tour = array(
								'tour_name' => $t->tourName,
								'tour_images' => $images,
								'tour_order' => $t->tourOrder,
								'tour_display' => $t->tourDisplay,
								'tour_summary' => $t->tourSummary
							);
							
							$count += $this->tour->add_tour_item($tour);
							$tid = $this->db->insert_id();
							
							/* optimize the table */
							$this->sys->optimize_table('tour');
							
							/* insert the supplemental data */
							$tourdata = array(
								array(
									'data_tour_item' => $tid,
									'data_field' => 1,
									'data_value' => $t->tourLocation,
									'data_updated' => now()),
								array(
									'data_tour_item' => $tid,
									'data_field' => 2,
									'data_value' => $t->tourDesc,
									'data_updated' => now()),
							);
							
							/* put the data into the table */
							$this->tour->add_tour_field_data($tourdata[0]);
							$this->tour->add_tour_field_data($tourdata[1]);
						}
					}
					
					/* set the message */
					$message = ($count == $before_count) ? lang('upg_step12_success') : lang('upg_step12_failure');
				}
				else
				{
					$message = lang('upg_step12_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_12', '_base', 'update');
				$js_loc = js_location('upgrade_step_12_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/13') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step12_title'));
				$this->template->write('label', lang('upg_step12_label'));
				
				break;
				
			case 13:
				/*
				 * CHARACTERS & USERS
				 */
				$this->load->model('characters_model', 'char');
				$this->load->model('users_model', 'user');
				$this->load->helper('utility');
				
				$crew = $this->db->query('SELECT * FROM sms_crew');
				
				$userarray = array();
					
				/* get the crew */
				if ($crew->num_rows() > 0)
				{
					$password = $this->auth->hash($this->config->item('sms_password'));
					$email = $this->config->item('sms_email');
					
					/* info for the languages field */
					$insert = array(
						'field_type' => 'text',
						'field_name' => 'languages',
						'field_fid' => 'languages',
						'field_class' => '',
						'field_label_page' => 'Languages',
						'field_value' => NULL,
						'field_order' => 4,
						'field_display' => 'y',
						'field_section' => 4
					);
					
					/* add the languages field */
					$this->char->add_bio_field($insert);
					
					foreach ($crew->result() as $c)
					{
						if ($c->crewType != 'npc' || !empty($c->email))
						{
							/* set the values (newer items will overwrite older items) */
							$users[$c->email]['name'] = $c->realName;
							$users[$c->email]['password'] = $password;
							$users[$c->email]['email'] = $c->email;
							$users[$c->email]['leave_date'] = $c->leaveDate;
							$users[$c->email]['status'] = $c->crewType;
							$users[$c->email]['moderate_posts'] = $c->moderatePosts;
							$users[$c->email]['moderate_logs'] = $c->moderateLogs;
							$users[$c->email]['moderate_news'] = $c->moderateNews;
							$users[$c->email]['password_reset'] = 1;
							$users[$c->email]['access_role'] = ($c->email == $email) ? 1 : 4;
							$users[$c->email]['is_sysadmin'] = ($c->email == $email) ? 'y' : 'n';
							$users[$c->email]['is_game_master'] = ($c->email == $email) ? 'y' : 'n';
							
							if (!isset($users[$c->email]['main_char']))
							{
								$users[$c->email]['main_char'] = $c->crewid;
							}
							else
							{
								if ($c->crewType == 'active')
								{
									$users[$c->email]['main_char'] = $c->crewid;
								}
							}
							
							if (!isset($users[$c->email]['last_post']))
							{
								$users[$c->email]['last_post'] = $c->lastPost;
							}
							else
							{
								if ($c->crewType == 'active')
								{
									$users[$c->email]['last_post'] = $c->lastPost;
								}
							}
							
							if (!isset($characters[$c->email]['user']['join_date']))
							{ /* we want to take the first join date and nothing else */
								$users[$c->email]['join_date'] = $c->joinDate;
							}
						}
					}
					
					/* pause the script */
					sleep(2);
					
					/* start the character ID array off */
					$charIDs = array('' => 0);
					
					foreach ($users as $email => $p)
					{
						/* create the user */
						$this->user->create_user($p);
						
						/* grab the insert id */
						$pid = $this->db->insert_id();
						
						/* create the user prefs */
						$this->user->create_user_prefs($pid);
						
						/* keep track of the user ids */
						$charIDs[$email] = $pid;
					}
					
					/* optimize the table */
					$this->sys->optimize_table('users');
					
					/* pause the script */
					sleep(2);
					
					foreach ($crew->result() as $c)
					{
						$characters[$c->email][] = array(
							'basic' => array(
								'charid' => $c->crewid,
								'user' => (!empty($c->email)) ? $charIDs[$c->email] : '',
								'first_name' => $c->firstName,
								'middle_name' => $c->middleName,
								'last_name' => $c->lastName,
								'suffix' => '',
								'crew_type' => $c->crewType,
								'images' => $c->image,
								'date_activate' => $c->joinDate,
								'date_deactivate' => $c->leaveDate,
								'rank' => $c->rankid,
								'position_1' => sms_position_translation($c->positionid),
								'position_2' => sms_position_translation($c->positionid2),
								'last_post' => $c->lastPost
							),
							'data' => array(
								1 => array(
									'data_value' => $c->gender,
									'data_updated' => now()),
								2 => array(
									'data_value' => $c->species,
									'data_updated' => now()),
								3 => array(
									'data_value' => $c->age,
									'data_updated' => now()),
								4 => array(
									'data_value' => $c->heightFeet ."' ". $c->heightInches .'"',
									'data_updated' => now()),
								5 => array(
									'data_value' => $c->weight .' lbs',
									'data_updated' => now()),
								6 => array(
									'data_value' => $c->hairColor,
									'data_updated' => now()),
								7 => array(
									'data_value' => $c->eyeColor,
									'data_updated' => now()),
								8 => array(
									'data_value' => $c->physicalDesc,
									'data_updated' => now()),
								9 => array(
									'data_value' => $c->personalityOverview,
									'data_updated' => now()),
								10 => array(
									'data_value' => $c->strengths,
									'data_updated' => now()),
								11 => array(
									'data_value' => $c->ambitions,
									'data_updated' => now()),
								12 => array(
									'data_value' => $c->hobbies,
									'data_updated' => now()),
								13 => array(
									'data_value' => $c->spouse,
									'data_updated' => now()),
								14 => array(
									'data_value' => $c->children,
									'data_updated' => now()),
								15 => array(
									'data_value' => $c->father,
									'data_updated' => now()),
								16 => array(
									'data_value' => $c->mother,
									'data_updated' => now()),
								17 => array(
									'data_value' => $c->brothers,
									'data_updated' => now()),
								18 => array(
									'data_value' => $c->sisters,
									'data_updated' => now()),
								19 => array(
									'data_value' => $c->otherFamily,
									'data_updated' => now()),
								20 => array(
									'data_value' => $c->history,
									'data_updated' => now()),
								21 => array(
									'data_value' => $c->serviceRecord,
									'data_updated' => now()),
								22 => array(
									'data_value' => $c->languages,
									'data_updated' => now()),
							),
						);
					}
					
					/* pause the script */
					sleep(2);
					
					foreach ($characters as $email => $value)
					{
						$count = count($value);
						
						for ($i = 0; $i < $count; $i++)
						{
							/* create the character */
							$this->char->create_character($value[$i]['basic']);
							
							/* grab the insert id */
							$cid = $this->db->insert_id();
							
							/* create the empty data fields */
							$this->char->create_character_data_fields($cid, $charIDs[$email]);
							
							foreach ($value[$i]['data'] as $k => $v)
							{ /* update the character data */
								$this->char->update_character_data($k, $cid, $v);
							}
						}
					}
					
					/* optimize the table */
					$this->sys->optimize_table('characters');
					
					/* count the characters */
					$count = $this->char->count_characters('', '');
					
					/* make sure the message is right */
					$message = ($count == $crew->num_rows()) ? lang('upg_step13_success') : lang('upg_step13_failure');
				}
				
				$data['label']['text'] = $message;
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_13', '_base', 'update');
				$js_loc = js_location('upgrade_step_13_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('upgrade/step/14') .'" class="btn" id="next">'. lang('button_next') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step13_title'));
				$this->template->write('label', lang('upg_step13_label'));
			
				break;
				
			case 14:
				/*
				 * FINALIZE
				 */
				$this->load->model('awards_model', 'awards');
				$this->load->model('characters_model', 'char');
				$this->load->model('users_model', 'user');
				$this->load->model('news_model', 'news');
				$this->load->model('personallogs_model', 'logs');
				$this->load->model('posts_model', 'posts');
				$this->load->model('menu_model');
				$this->load->model('ranks_model', 'ranks');
				
				/* update the my links id numbers */
				$this->sys->update_my_links('');
				
				/* update all users skin and rank defaults */
				$defaults = array(
					'skin_main'			=> $this->sys->get_skinsec_default('main'),
					'skin_admin'		=> $this->sys->get_skinsec_default('admin'),
					'skin_wiki'			=> $this->sys->get_skinsec_default('wiki'),
					'display_rank'		=> $this->ranks->get_rank_default()
				);
				
				/* do the update to all users */
				$this->user->update_all_users($defaults);
				
				/* update the welcome page header */
				$name = $this->settings->get_setting('sim_name');
				
				if (!empty($name))
				{
					$update_data = array('message_content' => 'Welcome to the '. $name .'!');
					$this->msgs->update_message($update_data, 'welcome_head');
				}
				
				/* do the product registration */
				$this->_register();
				
				/* install the skins and ranks */
				$this->_install_ranks();
				$this->_install_skins();
				
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
				
				/* grab the crew */
				$crew = $this->db->query('SELECT * FROM sms_crew');
				
				/* build the array for the new menu item */
				$menu = array(
					'menu_name' => 'SMS Archives',
					'menu_group' => 1,
					'menu_order' => 0,
					'menu_need_login' => 'y',
					'menu_type' => 'sub',
					'menu_cat' => 'main',
					'menu_sim_type' => 1,
					'menu_link' => 'archive/index'
				);
				
				/* insert the new menu item */
				$this->menu_model->add_menu_item($menu);
				
				if ($crew->num_rows() > 0)
				{
					foreach ($crew->result() as $c)
					{
						$user = $this->sys->get_item('characters', 'charid', $c->crewid, 'user');
						
						if ($user !== NULL && $user > 0)
						{
							/* update the news items */
							$news = array('news_author_user' => $user);
							$this->news->update_news_item($c->crewid, $news, 'news_author_character');
							
							/* update the personal logs */
							$log = array('log_author_user' => $user);
							$this->logs->update_log($c->crewid, $log, 'log_author_character');
						}
						
						if (!empty($c->awards))
						{
							$awards = explode(';', $c->awards);
							
							foreach ($awards as $a)
							{
								if (strstr($a, '|') !== FALSE)
								{
									$x = explode('|', $a);
									
									$array = array(
										'awardrec_character' => $c->crewid,
										'awardrec_award' => $x[0],
										'awardrec_date' => $x[1],
										'awardrec_reason' => $x[2]
									);
									
									$this->awards->add_nominated_award($array);
								}
								else
								{
									$array = array(
										'awardrec_character' => $c->crewid,
										'awardrec_award' => $a
									);
									
									$this->awards->add_nominated_award($array);
								}
							}
						}
					}
				}
				
				/* get all the posts */
				$posts = $this->posts->get_post_list('');
				
				if ($posts->num_rows() > 0)
				{
					foreach ($posts->result() as $p)
					{
						/* grab the authors and put them into an array */
						$authors = explode(',', $p->post_authors);
						
						/* make sure we have an array */
						$array = array();
						
						foreach ($authors as $a)
						{
							/* get the user id */
							$user = $this->sys->get_item('characters', 'charid', $a, 'user');
							
							/* if the user variable isn't empty and it isn't in the array already */
							if ($user !== FALSE && !in_array($user, $array))
							{
								$array[] = $user;
							}
						}
						
						/* create a string from the array */
						$users = implode(',', $array);
						
						/* update the post */
						$this->posts->update_post($p->post_id, array('post_authors_users' => $users));
					}
				}
				
				$data['label']['text'] = lang('upg_step14_success');
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_14', '_base', 'update');
				$js_loc = js_location('upgrade_step_14_js', '_base', 'update');
				
				/* build the next step control */
				$control = '<a href="'. site_url('login/index') .'" class="btn" id="next">'. lang('button_login') .'</a>';
				
				/* set the title */
				$this->template->write('title', lang('upg_step14_title'));
				$this->template->write('label', lang('upg_step14_label'));
				
				break;
		}
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write('controls', $control);
		
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
			'back' => lang('upg_verify_back'),
			'text' => lang('verify_text')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('upgrade_verify', '_base', 'update');
		
		/* build the next step control */
		$control = '<a href="'. site_url('upgrade/info') .'" class="btn">'. lang('upg_more_info') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('verify_title'));
		$this->template->write('label', lang('verify_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
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
		$this->load->library('email');
		
		/* set up the server and method for the request */
		$this->xmlrpc->server('http://www.anodyne-productions.com/ano.php/utility/do_registration', 80);
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
			'upgrade'
		);
		
		/* compile the request */
		$this->xmlrpc->request($request);
		
		if (extension_loaded('xmlrpc'))
		{
			/* send the request or log the message if it doesn't work */
			if (!$this->xmlrpc->send_request())
			{
				log_message('error', $this->xmlrpc->display_error());
			}
		}
		else
		{
			$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, db_platform, db_version, type, date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %d);";
			
			$message = sprintf(
				$insert,
				$this->db->escape($request[0]),
				$this->db->escape($request[1]),
				$this->db->escape($request[2]),
				$this->db->escape($request[3]),
				$this->db->escape($request[4]),
				$this->db->escape($request[5]),
				$this->db->escape($request[6]),
				$this->db->escape($request[7]),
				$this->db->escape($request[8]),
				$this->db->escape(now())
			);
			
			/* set the parameters for sending the email */
			$this->email->from('nova.registration@example.com');
			$this->email->to('anodyne.nova@gmail.com');
			$this->email->subject('Nova Registration');
			$this->email->message($message);
			
			/* send the email */
			$email = $this->email->send();
		}
	}
}

/* End of file upgrade_base.php */
/* Location: controllers/base/upgrade_base.php */