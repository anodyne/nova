<?php
/**
 * Update controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		1.0.6
 *
 * Updated the update process to try and grab the directory listing and use
 *	that as a baseline first instead of the versions file, fixed a bug where
 *	some users were getting errors while updating the system
 */

# TODO: need to change the locations of the update files to the assets module

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
		
		/* load the resources */
		$this->load->model('system_model', 'sys');
		
		/* check to see if the system is installed */
		$d['installed'] = $this->sys->check_install_status();
		
		/* build the options menu */
		$this->template->write_view('update_options', '_base/update/pages/_options', $d);
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
		{
			$flash['status'] = '';
			$flash['message'] = '';
			
			if ($code == 1)
			{
				$flash['status'] = 'error';
				$flash['message'] = lang('upd_error_1');
			}
			elseif ($code == 2)
			{
				$flash['status'] = 'info';
				$flash['message'] = lang('upd_error_2');
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
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
		
		/* build the next step control */
		$control = '<a href="'. site_url('update/verify') .'" class="btn">'. lang('upd_index_options_verify') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('upd_index_title'));
		$this->template->write('label', lang('upd_index_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function check()
	{
		if (isset($_POST['submit']))
		{
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
				/* do the version check */
				$update = $this->_check_version();
				
				
				if ($update['flash']['message'] != '')
				{
					$flash = $update['flash'];
					$data['link'] = FALSE;
				}
				else
				{
					$flash['status'] = 'info';
					$flash['message'] = sprintf(
						lang('update_text_no_updates'),
						APP_NAME
					);
					$data['link'] = text_output(anchor('update/index', lang('button_back_update')), 'p', 'fontMedium bold');
				}
				
				$data['label'] = array(
					'whatsnew' => lang('upd_header_whatsnew'),
					'notes' => (is_array($update['update'])) ? $update['update']['notes'] : '',
					'files' => lang('upd_check_header_files'),
					'files_text' => lang('upd_check_text_files'),
					'files_go' => $update['update']['link'],
					'start' => lang('upd_check_header_start'),
					'start_text' => lang('upd_check_text_start'),
					'start_go' => anchor('update/step/1', lang('upd_check_go_start'), array('id' => 'next')),
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_check_main', '_base', 'update');
				$js_loc = js_location('update_check_js', '_base', 'update');
				
				/* build the next step control */
				$control = '';
			}
			else
			{
				$flash['status'] = 'error';
				
				if ($sysadmin === FALSE)
				{
					$flash['message'] = lang('error_update_2');
				}
				
				if ($verify > 0)
				{
					$flash['message'] = lang('error_login_'. $verify);
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
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_check', '_base', 'update');
				$js_loc = js_location('update_check_js', '_base', 'update');
				
				/* build the next step control */
				$control = form_button($data['inputs']['submit']) . form_close();
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
				'email' => ucwords(lang('global_email')),
				'password' => ucwords(lang('global_password')),
				'text' => sprintf(
					lang('global_content_sysadmin'),
					lang('global_update'),
					lang('global_update')),
			);
			
			/* figure out where the view file should be coming from */
			$view_loc = view_location('update_check', '_base', 'update');
			$js_loc = js_location('update_check_js', '_base', 'update');
			
			/* build the next step control */
			$control = form_button($data['inputs']['submit']) . form_close();
		}
		
		/* set the title */
		$this->template->write('title', lang('upd_index_title'));
		$this->template->write('label', lang('upd_index_title'));
				
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
			0 - no error
			1 - nova is not installed
			2 - maintenance mode is not active ... system cannot be updated
			3 - you are not a system admin, make sure you're logged in
		*/
		
		$id = $this->uri->segment(3, 0);
		
		$label = array(
			'error_1' => lang('upd_error_1'),
			'error_2' => lang('upd_error_2'),
			'error_3' => lang('upd_error_3'),
		);
		
		$flash['status'] = 'error';
		$flash['message'] = $label['error_'. $id];
		
		/* write everything to the template */
		$this->template->write_view('flash_message', '_base/update/pages/flash', $flash);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_error', '_base', 'update');
		
		$control = '<a href="'. site_url('update/index') .'" class="btn">'. lang('button_back_update') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('upd_error_title'));
		$this->template->write('label', lang('upd_error_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function readme()
	{
		/* figure out where the view file should be coming from */
		$view_loc = view_location('readme', '_base', 'update');
		
		$control = '';
		
		/* set the title */
		$this->template->write('title', APP_NAME .' '. lang('global_readme_title'));
		$this->template->write('label', APP_NAME .' '. lang('global_readme_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc);
		$this->template->write('controls', $control);
		
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
				
				$data['label']['text'] = $message;
				
				/* figure out where the view files should be coming from */
				$view_loc = view_location('update_step_1', '_base', 'update');
				$js_loc = js_location('update_step_1_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upd_step1_title'));
				$this->template->write('label', lang('upd_step1_title'));
				
				$control = '<a href="'. site_url('update/step/2') .'" class="btn" id="next">'. lang('button_next') .'</a>';
			break;
				
			case 2:
				/* load the resources */
				$this->load->helper('directory');
				
				/* grab the version from the database */
				$item = $this->sys->get_item('system_info', 'sys_id', 1);
				
				/* build the version string */
				$version = $item->sys_version_major . $item->sys_version_minor . $item->sys_version_update;
				
				/* grab the directory listing */
				$dir = directory_map(APPFOLDER .'/assets/update');
				
				if (is_array($dir))
				{
					// sort the array
					sort($dir);
					
					foreach ($dir as $key => $value)
					{
						if ($value == 'index.html' || $value == 'versions.php')
						{
							unset($dir[$key]);
						}
						else
						{
							$file = substr($value, 7, -4);
							
							if ($file < $version)
							{
								unset($dir[$key]);
							}
						}
					}
					
					/* loop through and do the update */
					foreach ($dir as $d)
					{
						include_once(APPPATH .'assets/update/'. $d);
						
						/* pause the script for 1 second */
						sleep(1);
					}
				}
				else
				{
					/* pull in the versions file */
					include_once(APPPATH .'assets/update/versions.php');
					
					/* make sure we're not doing more work than we need to */
					foreach ($version_array as $k => $v)
					{
						if ($v < $version)
						{
							unset($version_array[$k]);
						}
					}
					
					/* loop through and do the update */
					foreach ($version_array as $value)
					{
						include_once(APPPATH .'assets/update/update_' . $value . '.php');
						
						/* pause the script for 1 second */
						sleep(1);
					}
				}
				
				/* update the system info */
				$this->sys->update_system_info($system_info);
				
				/* do the product registration */
				$this->_register();
				
				/* update the users to be first launch */
				$this->load->model('users_model', 'user');
				$users = array('is_firstlaunch' => 'y');
				$this->user->update_all_users($users, '');
				
				$data['label'] = array(
					'text' => sprintf(
						lang('upd_step2_success'),
						$system_versions['version']
					),
					'back' => lang('upd_step2_site')
				);
				
				/* figure out where the view file should be coming from */
				$view_loc = view_location('update_step_2', '_base', 'update');
				$js_loc = js_location('update_step_2_js', '_base', 'update');
				
				/* set the title and label */
				$this->template->write('title', lang('upd_step2_title'));
				$this->template->write('label', lang('upd_step2_title'));
				
				$control = '<a href="'. site_url('main/index') .'" class="btn" id="next">'. lang('upd_step2_site') .'</a>';
			break;
		}
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('controls', $control);
		
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
			'text' => lang('verify_text')
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('update_verify', '_base', 'update');
		
		/* build the next step control */
		$control = '<a href="'. site_url('update/check') .'" class="btn">'. lang('upd_index_options_update') .'</a>';
		
		/* set the title */
		$this->template->write('title', lang('verify_title'));
		$this->template->write('label', lang('verify_title'));
				
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write('controls', $control);
		
		/* render the template */
		$this->template->render();
	}
	
	function _check_version()
	{
		if (ini_get('allow_url_fopen'))
		{
			/* load the resources */
			$this->load->helper('yayparser');
			
			/* get the contents of the file */
			$contents = file_get_contents(VERSION_FEED);
					
			/* parse the contents of the yaml file */
			$array = yayparser($contents);
			
			/* get the system information */
			$system = $this->sys->get_system_info();
			
			/* build the array of version info */
			$version = array(
				'files' => array(
					'full'		=> APP_VERSION_MAJOR .'.'. APP_VERSION_MINOR .'.'. APP_VERSION_UPDATE,
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
			
			$update = FALSE;
			
			if (version_compare($version['files']['full'], $array['version'], '<') || version_compare($version['database']['full'], $array['version'], '<'))
			{
				$update['version']		= $array['version'];
				$update['notes']		= $array['notes'];
				$update['severity']		= $array['severity'];
				$update['link']			= $array['link'];
			}
			
			if (version_compare($version['database']['full'], $version['files']['full'], '>'))
			{
				$flash['status'] = 'info';
				$flash['message'] = sprintf(
					lang('update_outofdate_files'),
					$version['files']['full'],
					$version['database']['full']
				);
			}
			elseif (version_compare($version['database']['full'], $version['files']['full'], '<'))
			{
				$flash['status'] = 'info';
				$flash['message'] = sprintf(
					lang('update_outofdate_database'),
					$version['database']['full'],
					$version['files']['full']
				);
			}
			elseif ($update !== FALSE)
			{
				$yourversion = sprintf(
					lang('update_your_version'),
					APP_NAME,
					$version['files']['full']);
					
				$flash['status'] = 'info';
				$flash['message'] = sprintf(
					lang('update_available'),
					APP_NAME,
					$update['version'],
					$yourversion
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
		
		return FALSE;
	}
	
	function _register()
	{
		/* load the resources */
		$this->load->library('xmlrpc');
		$this->load->library('email');
		
		/* set up the server and method for the request */
		$this->xmlrpc->server('http://www.anodyne-productions.com/index.php/utility/do_registration', 80);
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
			'update'
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
		
		$items = array(
			'php'					=> PHP_VERSION,
			'pcre_utf8'				=> (bool) @preg_match('/^.$/u', 'ñ'),
			'pcre_unicode'			=> (bool) @preg_match('/^\pL$/u', 'ñ'),
			'spl'					=> (bool) function_exists('spl_autoload_register'),
			'reflection'			=> (bool) class_exists('ReflectionClass'),
			'filters'				=> (bool) function_exists('filter_list'),
			'iconv'					=> (bool) extension_loaded('iconv'),
			'mbstring'				=> (bool) extension_loaded('mbstring'),
			'mb_overload'			=> (bool) ini_get('mbstring.func_overload') & MB_OVERLOAD_STRING,
			'curl'					=> (bool) extension_loaded('curl'),
			'mcrypt'				=> (bool) extension_loaded('mcrypt'),
			'gd'					=> (bool) function_exists('gd_info'),
			'pdo'					=> (bool) class_exists('PDO'),
			'fopen'					=> (bool) ini_get('allow_url_fopen'),
			'url_include'			=> (bool) ini_get('allow_url_include'),
			'register_globals'		=> (bool) ini_get('register_globals'),
			'memory'				=> ini_get('memory_limit'),
			'xmlrpc'				=> (bool) extension_loaded('xmlrpc'),
			'disabled_functions'	=> ini_get('disable_functions'),
			'disabled_classes'		=> ini_get('disable_classes'),
			'server_os'				=> PHP_OS,
		);
		
		$insert = "INSERT INTO www_nova2_survey (url, php, pcre_utf8, pcre_unicode, spl, reflection, filters, iconv, mbstring, mb_overload, curl, mcrypt, gd, pdo, fopen, url_include, register_globals, memory, xmlrpc, disabled_functions, disabled_classes, server_os, date) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %d);";
		
		$message = sprintf(
			$insert,
			$this->db->escape(base_url()),
			$this->db->escape($items['php']),
			$this->db->escape($items['pcre_utf8']),
			$this->db->escape($items['pcre_unicode']),
			$this->db->escape($items['spl']),
			$this->db->escape($items['reflection']),
			$this->db->escape($items['filters']),
			$this->db->escape($items['iconv']),
			$this->db->escape($items['mbstring']),
			$this->db->escape($items['mb_overload']),
			$this->db->escape($items['curl']),
			$this->db->escape($items['mcrypt']),
			$this->db->escape($items['gd']),
			$this->db->escape($items['pdo']),
			$this->db->escape($items['fopen']),
			$this->db->escape($items['url_include']),
			$this->db->escape($items['register_globals']),
			$this->db->escape($items['memory']),
			$this->db->escape($items['xmlrpc']),
			$this->db->escape($items['disabled_functions']),
			$this->db->escape($items['disabled_classes']),
			$this->db->escape($items['server_os']),
			$this->db->escape(now())
		);
		
		$this->email->from('nova.survey@example.com');
		$this->email->to('anodyne.nova@gmail.com');
		$this->email->subject('Nova 2 Survey');
		$this->email->message($message);
		
		$email = $this->email->send();
	}
}
