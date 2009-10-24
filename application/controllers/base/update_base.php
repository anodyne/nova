<?php
/*
|---------------------------------------------------------------
| UPDATE CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/update_base.php
| System Version: 1.0
|
| Controller that handles the updating of the system.
|
*/

# TODO: remove the debug helper

class Update_base extends Controller {
	
	var $options;
	var $version;
	
	function Update_base()
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
		
		/* set the template */
		$this->template->set_template('update');
		$this->template->set_master_template('_base/template_update.php');
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'sim_name',
			'date_format',
			'updates'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* write the common elements to the template */
		$this->template->write('title', APP_NAME .' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		$this->lang->load('install');
		
		/* set the version of nova */
		$this->version = APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE;
		
		$this->load->helper('debug');
	}

	function index()
	{
		if (isset($_POST['submit']))
		{
			/* set the POST variables */
			$email = $this->input->post('email', TRUE);
			$password = sha1($this->input->post('password', TRUE));
			
			/* verify their email/password combo is right */
			$verify = $this->auth->verify($email, $password);
			
			/* get their player ID */
			$player = $this->sys->get_item('players', 'email', $email, 'player_id');
			
			/* verify they're a sys admin */
			$sysadmin = $this->auth->is_sysadmin($player);
			
			if ($verify == 0 && $sysadmin === TRUE)
			{
				$this->session->set_flashdata('verified', 'yes');
				
				redirect('update/main');
			}
			else
			{
				$flash['status'] = 'error';
				
				if ($sysadmin === FALSE)
				{
					$flash['message'] = lang_output('error_update_2');
				}
				
				if ($verify > 0)
				{
					$flash['message'] = lang_output('error_login_'. $verify);
				}
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
			}
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
				'content' => ucwords(lang('actions_submit'))
			)
		);
		
		$data['label'] = array(
			'email' => ucwords(lang('labels_email_address')),
			'password' => ucwords(lang('labels_password')),
			'text' => lang('update_text_index'),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_index', '_base', 'update');
		$js_loc = js_location('update_index_js', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('update_title_index'));
		$this->template->write('label', lang('update_title_index'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function error()
	{
		/*
			0 - no error
			1 - sms version not compatible
		*/
		
		/*
			1 - maintenance mode is not active ... system cannot be updated!
			2 - you are not a system administrator, you cannot update the system
			3 - you are not a system administrator, you cannot modify the database
			4 - the table you are trying to create already exists
			5 - you must be logged in to update the system
			6 - SMS is not install (upgrade only)
			7 - you do not have SMS 2.6.0 or higher (upgrade only)
		*/
	}
	
	function main()
	{
		/*if ($this->session->flashdata('verified') == 'yes')
		{*/
			/* load the resources */
			$this->load->library('simplepie');
			
			/* get the system information */
			$system = $this->sys->get_system_info();
			
			/* build the array of version info */
			$version = array(
				'files' => array(
					'full'		=> $this->version,
					'major'		=> APP_VERSION_MAJOR,
					'minor'		=> APP_VERSION_MINOR,
					'update'	=> APP_VERSION_UPDATE
				),
				'database' => array(
					'full'		=> $system->sys_version_major .'.'. $system->sys_version_minor .'.'. $system->sys_version_update,
					'major'		=> $system->sys_version_major,
					'minor'		=> $system->sys_version_minor,
					'update'	=> $system->sys_version_update
				),
			);
			
			/* grab the information from the version feed */
			$this->simplepie->set_feed_url(base_url() . APPFOLDER .'/assets/version.xml');
			$this->simplepie->enable_cache(FALSE);
			$this->simplepie->init();
			$this->simplepie->handle_content_type();
			
			/* get the items from the feed */
			$items = $this->simplepie->get_items();
			
			$type = $this->options['updates'];
			
			foreach ($items as $i)
			{ /* loop through and figure out what we should be displaying */
				switch ($type)
				{
					case 'major':
						$major = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'major');
						$major = $major[0]['data'];
						
						if ($major > $version['files']['major'] || $major > $version['database']['major'])
						{
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
						}
					
						break;
						
					case 'minor':
						$major = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'major');
						$minor = $i->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'minor');
						
						$major = $major[0]['data'];
						$minor = $minor[0]['data'];
						
						if ($minor > $version['files']['minor'] || $minor > $version['database']['minor'])
						{
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
						}
						elseif (($minor < $version['files']['minor'] || $major > $version['files']['major']) &&
								($minor < $version['database']['minor'] || $major > $version['database']['major']))
						{
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
						}
					
						break;
						
					case 'all':
						if ($i->get_title() != $version['files']['full'] && $i->get_title() != $version['database']['full'])
						{
							$update['version'] = $i->get_title();
							$update['description'] = $i->get_description();
						}
							
						break;
				}
			}
			
			if ($version['database']['full'] > $version['files']['full'])
			{
				$flash['status'] = 'info';
				$flash['message'] = '<span class="icon ui-icon ui-icon-info"></span>';
				$flash['message'].= sprintf(
					lang_output('update_outofdate_files'),
					$version['files']['full'],
					$version['database']['full']
				);
			}
			elseif ($version['database']['full'] < $version['files']['full'])
			{
				$flash['status'] = 'info';
				$flash['message'] = '<span class="icon ui-icon ui-icon-info"></span>';
				$flash['message'].= sprintf(
					lang_output('update_outofdate_database'),
					$version['database']['full'],
					$version['files']['full']
				);
			}
			elseif (isset($update))
			{
				$flash['status'] = 'info';
				$flash['message'] = '<span class="icon ui-icon ui-icon-info"></span>';
				$flash['message'].= sprintf(
					lang_output('update_available'),
					APP_NAME,
					$update['version'],
					APP_NAME
				);
			}
			else
			{
				$flash['status'] = '';
				$flash['message'] = '';
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
		/*}
		else
		{
			redirect('update/error/2');
		}*/
		
		$data['label'] = array(
			'notes' => (isset($update)) ? $update['description'] : '',
			'whatsnew' => lang('update_header_whatsnew'),
			'update'
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_main', '_base', 'update');
		$js_loc = js_location('update_main_js', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('update_title_index'));
		$this->template->write('label', lang('update_title_index'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function readme()
	{
		/* figure out where the view file should be coming from */
		$view_loc = view_location('readme', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('title_update_readme'));
		$this->template->write('label', APP_NAME .' '. lang('title_update_readme'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function run()
	{
		$step = $this->uri->segment(3, 1, TRUE);
		
		switch ($step)
		{
			case 1:
				/* load the resources */
				$this->load->helper('utility');
				
				/* set the prefix */
				$prefix = $this->db->dbprefix;
				
				/* check the database size and the server memory limit */
				$db_size = file_size($this->sys->get_database_size());
				$memory = check_memory($db_size);
				
				if ($memory === TRUE)
				{ /* if there's enough memory, continue */
					$fields = $this->db->list_tables();
					
					/* get the length of the prefix */
					$length = strlen($prefix);
					
					foreach ($fields as $key => $value)
					{
						if (substr($value, 0, $length) != $prefix)
						{
							unset($fields[$key]);
						}
					}
					
					if (count($fields) > 0)
					{
						/* grab today's date info */
						$today = getdate();
						
						/* set the filename */
						$filename = $prefix . $today['year'] . $today['mon'] . $today['mday'];
						
						/* backup the data */
						$this->_backup_sql($prefix, 'save', $filename);
						
						if (is_file(APPPATH .'assets/backups/'. $filename .'.zip'))
						{
							// success
						}
						else
						{
							// failure
						}
					}
					else
					{
						# TODO: need message if there are no fields
					}
				}
				else
				{
					# TODO: need message if they don't have enough memory
				}
				
				$data['inputs'] = array(
					'submit' => array(
						'type' => 'submit',
						'class' => 'button',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('actions_submit'))
					)
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_run_1', '_base', 'update');
				
				break;
				
			case 2:
				include_once(APPPATH .'assets/update/versions.php');
				
				$version = str_replace('.', '', $this->version);
				
				foreach ($version_array as $k => $v)
				{
					if ($v < $version)
					{
						unset($version_array[$k]);
					}
				}
				
				foreach ($version_array as $value)
				{
					include_once(APPPATH .'assets/update/update_' . $value . '.php');
				}
				
				/* update the system info */
				$this->sys->update_system_info($system_info);
				
				/* update the players to be first launch */
				$this->load->model('players_model', 'player');
				$players = array('is_firstlaunch' => 'y');
				$this->player->update_all_players($players, '');
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_run_2', '_base', 'update');
				
				break;
		}
		
		/* set the title */
		$this->template->write('title', lang('title_update_readme'));
		$this->template->write('label', APP_NAME .' '. lang('title_update_readme'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
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
			'back' => lang('upd_verify_back'),
			'text' => lang('upd_verify_text')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_verify', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('upd_verify_title'));
		$this->template->write('label', lang('upd_verify_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
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

/* End of file update_base.php */
/* Location: controllers/base/update_base.php */