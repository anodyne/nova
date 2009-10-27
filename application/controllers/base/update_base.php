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
			'updates',
			'maintenance'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* write the common elements to the template */
		$this->template->write('title', APP_NAME .' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('install');
		$this->lang->load('app', $this->session->userdata('language'));
				
		/* set the version of nova */
		$this->version = APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE;
	}

	function index()
	{
		/* check to see if the system is installed */
		$data['installed'] = $this->sys->check_install_status();
		
		/* set the error code */
		$code = 0;
		
		/* go through and check for errors */
		$code = ($data['installed'] === FALSE) ? 1 : $code;
		$code = ($this->options['maintenance'] == 'off') ? 2 : $code;
		
		if ($code > 0)
		{ /* if there's an error, redirect */
			redirect('update/error/'. $code);
		}
		
		$data['label'] = array(
			'options_check' => lang('upd_index_options_update'),
			'options_readme' => lang('upd_index_options_readme'),
			'options_tour' => lang('upd_index_options_tour'),
			'options_update' => lang('upd_index_options_update'),
			'options_verify' => lang('upd_index_options_verify'),
			'options_guide' => lang('upd_index_options_upd_guide'),
			'firststeps' => lang('upd_index_options_firststeps'),
			'whatsnext' => lang('upd_index_options_whatsnext'),
			'intro' => lang('global_content_index'),
			'header' => lang('upd_index_header'),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_index', '_base', 'update');
		$js_loc = js_location('update_index_js', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('upd_index_title'));
		$this->template->write('label', lang('upd_index_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function check()
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
				/* do the version check */
				$update = $this->_check_version($this->version);
				
				/* set the flash variable */
				$flash = $update['flash'];
				
				$data['label'] = array(
					'whatsnew' => lang('upd_header_whatsnew'),
					'notes' => (is_array($update['update'])) ? $update['update']['description'] : '',
					'files' => lang('upd_check_header_files'),
					'files_text' => lang('upd_check_text_files'),
					'files_go' => lang('upd_check_go_files'),
					'start' => lang('upd_check_header_start'),
					'start_text' => lang('upd_check_text_start'),
					'start_go' => anchor('update/step/1', lang('upd_check_go_start'), array('id' => 'next')),
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_check_main', '_base', 'update');
				$js_loc = js_location('update_check_js', '_base', 'update');
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
					'email' => ucwords(lang('install_step3_email')),
					'password' => ucwords(lang('install_step3_password')),
					'text' => lang('upd_text_sysadmin'),
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_check', '_base', 'update');
				$js_loc = js_location('update_check_js', '_base', 'update');
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
		}
		else
		{
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
				'email' => ucwords(lang('install_step3_email')),
				'password' => ucwords(lang('install_step3_password')),
				'text' => lang('upd_text_sysadmin'),
			);
			
			/* figure out where the view file should be coming from */
			$view_loc = view_location('update_check', '_base', 'update');
			$js_loc = js_location('update_check_js', '_base', 'update');
		}
		
		/* set the title */
		$this->template->write('title', lang('upd_index_title'));
		$this->template->write('label', lang('upd_index_title'));
				
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
			1 - nova is not installed
			2 - maintenance mode is not active ... system cannot be updated
			3 - you are not a system admin, make sure you're logged in
		*/
		
		$data['id'] = $this->uri->segment(3, 0);
		
		$data['label'] = array(
			'error_1' => lang('upd_error_1'),
			'error_2' => lang('upd_error_2'),
			'error_3' => lang('upd_error_3'),
			'back' => lang('upd_error_back'),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_error', '_base', 'update');
		
		/* set the title */
		$this->template->write('title', lang('upd_error_title'));
		$this->template->write('label', lang('upd_error_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
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
	
	function step()
	{
		/* set the step */
		$step = $this->uri->segment(3, 1, TRUE);
		
		switch ($step)
		{
			case 1:
				/* clear the memory limit to attempt the backup */
				ini_set('memory_limit', -1);
				
				/* load the resources */
				$this->load->helper('utility');
				
				/* set the prefix */
				$prefix = $this->db->dbprefix;
				
				/* check the database size and the server memory limit */
				$db_size = file_size($this->sys->get_database_size());
				$memory = check_memory($db_size);
				
				if ($memory === TRUE)
				{ /* if there's enough memory, continue */
					/* grab today's date info */
					$today = getdate();
					
					/* set the filename */
					$filename = $prefix . $today['year'] . $today['mon'] . $today['mday'];
						
					$backup = backup_database($prefix, 'save', $filename);
					
					if ($backup === TRUE)
					{
						if (is_file(APPPATH .'assets/backups/'. $filename .'.zip'))
						{
							$message = lang('upd_step1_success');
						}
						else
						{
							$message = lang('upd_step1_failure');
						}
					}
					else
					{
						$message = lang('upd_step1_nofields');
						$data['next']['disabled'] = TRUE;
					}
				}
				else
				{
					$message = lang('upd_step1_memory');
				}
				
				$data['next'] = array(
					'type' => 'submit',
					'class' => 'button',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('install_label_next'))
				);
				
				$data['label']['text'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('update_step_1', '_base', 'update');
				$js_loc = js_location('update_step_1_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upd_step1_title'));
				$this->template->write('label', lang('upd_step1_title'));
				
				break;
				
			case 2:
				/* pull in the versions file */
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
				
				$data['label'] = array(
					'text' => sprintf(
						lang('upd_step2_success'),
						$system_versions['version']
					),
					'back' => lang('upd_step2_site')
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_step_2', '_base', 'update');
				$js_loc = js_location('update_step_1_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upd_step2_title'));
				$this->template->write('label', lang('upd_step2_title'));
				
				break;
		}
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
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
	
	function _check_version($current = '')
	{
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
		
		/* grab the updates setting */
		$type = $this->options['updates'];
		
		$update = FALSE;
		
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
		
		$retval = array(
			'flash' => $flash,
			'update' => $update
		);
		
		return $retval;
	}
}

/* End of file update_base.php */
/* Location: controllers/base/update_base.php */