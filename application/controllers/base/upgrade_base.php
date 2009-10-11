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

# TODO: remove the debug helper

/**
 * For upgrading characters, we need to create an array whose key
 * is the old character ID and the value is the new character ID
 * so when we upgrade posts and logs we can put the proper character
 * ID into the database so people don't have to manually update
 * every post and log in the system.
 * 
 * Characters/users need to be upgraded last so we can translate the
 * IDs and then go back and update posts, logs and news items
 */

class Upgrade_base extends Controller {
	
	function Upgrade_base()
	{
		parent::Controller();
		
		/* load the system and archive models */
		$this->load->model('system_model', 'sys');
		$this->load->model('archive_model', 'arc');
		
		/* set the template */
		$this->template->set_template('update');
		$this->template->set_master_template('_base/template_update.php');
		
		/* write the common elements to the template */
		$this->template->write('title', APP_NAME .' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('app');
		$this->lang->load('install');
		
		$this->load->helper('debug');
	}

	function index()
	{
		/* run the methods */
		$installed = $this->sys->check_install_status();
		$sms = $this->arc->get_sms_version();
		$sms_ver = str_replace('.', '', $sms);
		$status = 0;
		
		$status = ($installed === TRUE) ? 1 : $status;
		$status = ($sms_ver < 260) ? 2 : $status;
		$status = ($sms === FALSE) ? 3 : $status;
		
		$data['status'] = $status;
		
		$data['label'] = array();
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('upgrade_index', '_base', 'update');
		$js_loc = js_location('upgrade_index_js', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('upgrade_index_title'));
		$this->template->write('label', lang('upgrade_index_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
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
		*/
		
		$id = $this->uri->segment(3);
		
		switch ($id)
		{
			case 1:
				echo "SMS prior to 2.6.0";
				break;
				
			case 2:
				echo "SMS is not installed";
				break;
				
			case 3:
				echo "Nova is already installed";
				break;
		}
	}
	
	function step()
	{
		/* load the resources */
		$this->load->dbforge();
		$this->config->load('sms');
		
		/* set the variables */
		$step = $this->uri->segment(3, 1);
		$upgrade = $this->config->item('sms');
		
		switch ($step)
		{
			case 1:
				# backup sms database
				
				break;
				
			case 2:
				/*
				 * CREATE THE NOVA TABLES
				 */
				
				if (phpversion() >= 5)
				{
					# TODO need to figure out the FTP library stuff for chmodding the logs and images folders
					
					/* load the resources */
					$this->load->library('ftp');
					
					/*$this->ftp->connect();
					
					$this->ftp->chmod(BASEPATH .'logs/', DIR_WRITE_MODE);
					$this->ftp->chmod(APPPATH .'assets/images/characters/', DIR_WRITE_MODE);
					
					$this->ftp->close();*/
				}
				 
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
				 
				/* load the helpers */
				$this->load->helper('string');
				
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
					
					/* start the count */
					$count = 0;
					
					foreach ($update as $key => $value)
					{ /* loop through the update the settings */
						$count += $this->settings_model->update_setting($key, $value);
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
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_5', '_base', 'update');
				$js_loc = js_location('upgrade_step_5_js', '_base', 'update');
				
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
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_6', '_base', 'update');
				$js_loc = js_location('upgrade_step_6_js', '_base', 'update');
				
				/* set the title */
				$this->template->write('title', lang('upg_step6_title'));
				$this->template->write('label', lang('upg_step6_label'));
				
				break;
				
			case 7:
				/** MISSIONS **/
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
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_7', '_base', 'update');
				$js_loc = js_location('upgrade_step_7_js', '_base', 'update');
				
				/* set the title */
				$this->template->write('title', lang('upg_step7_title'));
				$this->template->write('label', lang('upg_step7_label'));
				
				break;
				
			case 8:
				/** NEWS **/
				if ($upgrade['news'] === TRUE)
				{
					
				}
				else
				{
					$message = lang('upg_step8_noupgrade');
				}
				
				$data['label']['text'] = $message;
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_8', '_base', 'update');
				$js_loc = js_location('upgrade_step_8_js', '_base', 'update');
				
				/* set the title */
				$this->template->write('title', lang('upg_step8_title'));
				$this->template->write('label', lang('upg_step8_label'));
				
				break;
				
			case 9:
				/** PERSONAL LOGS **/
				if ($upgrade['logs'] === TRUE)
				{
					
				}
				else
				{
					// personal logs were not upgraded
				}
				
				break;
				
			case 10:
				/** MISSION POSTS **/
				if ($upgrade['posts'] === TRUE)
				{
					
				}
				else
				{
					// mission posts were not upgraded
				}
				
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
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('upgrade_step_11', '_base', 'update');
				$js_loc = js_location('upgrade_step_11_js', '_base', 'update');
				
				/* set the title */
				$this->template->write('title', lang('upg_step11_title'));
				$this->template->write('label', lang('upg_step11_label'));
				
				break;
				
			case 12:
				/** TOUR ITEMS **/
				if ($upgrade['tour'] === TRUE)
				{
					
				}
				else
				{
					// mission posts were not upgraded
				}
				
				break;
				
			case 13:
				/* get the crew */
				if ($crew->num_rows() > 0)
				{
					foreach ($crew->result() as $c)
					{
						$array[$c->email]['player'] = array(
							'name' => $c->realName,
							'email' => $c->email,
							'join_date' => $c->joinDate,
							'old_id' => $c->crewid
						);
						
						$array[$c->email]['characters'][] = array(
							'old_id' => $c->crewid,
							'f_name' => $c->firstName,
							'm_name' => $c->middleName,
							'l_name' => $c->lastName,
							'suffix' => $c->suffix,
							'history' => $c->history,
						);
					}
				}
			
				break;
				
			case 14:
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
	
	function _backup_sql($prefix = '', $action = 'download', $name = 'sms_backup')
	{
		# TODO: need to figure out the best way to make filenames unique
		
		/* load the utility class */
		$this->load->dbutil();
		
		/* get an array of the tables */
		$fields = $this->db->list_tables();
		
		/* go through all the tables to find out if its part of the system or not */
		foreach ($fields as $key => $value)
		{
			if (substr($value, 0, 4) != $prefix)
			{
				unset($fields[$key]);
			}
		}
		
		/* preferences for the backup */
		$prefs = array(
			'tables'		=> $fields,
			'format'		=> 'zip',
			'filename'		=> $name .'.sql'
		);
		
		/* backup the database and assign it to a variable */
		$backup =& $this->dbutil->backup($prefs);
		
		if ($action == 'download')
		{
			/* load the download helper and send the file to the desktop */
			$this->load->helper('download');
			force_download($name .'.zip', $backup);
		}
		elseif ($action == 'save')
		{
			/* load the file helper and write the file to your server */
			$this->load->helper('file');
			write_file(APPPATH .'assets/backups/'. $name .'.zip', $backup);
		}
	}
}

/* End of file upgrade_base.php */
/* Location: controllers/base/upgrade_base.php */