<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Update controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_update extends CI_Controller {
	
	/**
	 * @var	bool	Is the system installed?
	 */
	public $installed = false;
	
	/**
	 * @var	string	The version of the system
	 */
	public $version;
	
	/**
	 * @var	array 	The options array that stores all the settings from the database
	 */
	public $options;
	
	/**
	 * @var	array 	Variable to store all the information about template regions
	 */
	protected $_regions = array();
	
	public function __construct()
	{
		parent::__construct();
		
		// load the nova core module
		$this->load->module('core', 'nova', MODPATH);
		
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			redirect('install/setupconfig');
		}
		
		$this->load->database();
		$this->load->library('session');
		$this->load->model('settings_model', 'settings');
		$this->load->model('system_model', 'sys');
		$this->nova->lang('install');
		$this->lang->load('app', $this->session->userdata('language'));
		
		// set the version
		$this->version = APP_VERSION_MAJOR.'.'.APP_VERSION_MINOR.'.'.APP_VERSION_UPDATE;
		
		// an array of items to pull from the settings table
		$settings_array = array(
			'sim_name',
			'date_format',
			'updates',
			'maintenance'
		);
		
		// grab the settings
		$this->options = $this->settings->get_settings($settings_array);

		// check if nova is installed
		$this->installed = $this->sys->check_install_status();
		
		// set the template file
		Template::$file = '_base/template_update';
		
		// set the module
		Template::$data['module'] = 'core';
		
		// assign all of the items to the template with false values to prevent errors
		$this->_regions = array(
			'label'			=> false,
			'content'		=> false,
			'controls'		=> false,
			'javascript'	=> false,
			'flash_message'	=> false,
			'_redirect'		=> false,
			'title'			=> APP_NAME.' :: ',
		);
	}

	public function index()
	{
		$code = 0;

		// check for errors
		$code = ( ! $this->installed) ? 1 : $code;
		$code = ($this->options['maintenance'] == 'off') ? 2 : $code;
		
		if ($code > 0)
		{
			$flash['status'] = ($code == 1) ? 'error' : 'info';
			$flash['message'] = lang('upd_error_'.$code);
			
			$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
		}
		
		$data['installed'] = $this->installed;
		
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
		
		$next = array(
			'name' => 'next',
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'next',
			'content' => lang('button_verify'),
		);
		
		$this->_regions['content'] = Location::view('update_index', '_base', 'update', $data);
		$this->_regions['javascript'] = Location::js('update_index_js', '_base', 'update');
		$this->_regions['title'].= lang('upd_index_title');
		$this->_regions['label'] = lang('upd_index_title');
		$this->_regions['controls'] = form_open('update/verify').form_button($next).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function check()
	{
		if (isset($_POST['submit']))
		{
			$email = $this->input->post('email', true);
			$password = $this->input->post('password', true);
			
			$verify = Auth::verify($email, $password);
			
			$user = $this->sys->get_item('users', 'email', $email, 'userid');
			
			$sysadmin = Auth::is_sysadmin($user);
			
			if ($verify == 0 and $sysadmin)
			{
				$update = $this->_check_version();
				
				if ($update['flash']['message'] != '')
				{
					$flash = $update['flash'];
					$data['link'] = false;
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
				
				// the view files
				$view_loc = 'update_check_main';
				$js_loc = 'update_check_js';
			}
			else
			{
				$flash['status'] = 'error';
				
				if ( ! $sysadmin)
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
						'class' => 'btn-main',
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
				
				// the views
				$view_loc = 'update_check';
				$js_loc = 'update_check_js';
				
				$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			}
			
			$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
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
					'class' => 'btn-main',
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
			
			// the views
			$view_loc = 'update_check';
			$js_loc = 'update_check_js';
			
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		}
		
		$this->_regions['content'] = Location::view($view_loc, '_base', 'update', $data);
		$this->_regions['javascript'] = Location::js($js_loc, '_base', 'update');
		$this->_regions['title'].= lang('upd_index_title');
		$this->_regions['label'] = lang('upd_index_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function error($id = 0)
	{
		/**
		 * 0 - no error
		 * 1 - nova is not installed
		 * 2 - maintenance mode is not active
		 * 3 - you are not a system admin, make sure you're logged in
		 */
		
		$label = array(
			'error_1' => lang('upd_error_1'),
			'error_2' => lang('upd_error_2'),
			'error_3' => lang('upd_error_3'),
		);
		
		$flash['status'] = 'error';
		$flash['message'] = $label['error_'.$id];
		
		$next = array(
			'name' => 'next',
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'next',
			'content' => lang('button_update'),
		);
		
		$this->_regions['content'] = Location::view('update_error', '_base', 'update', false);
		$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
		$this->_regions['controls'] = form_open('update/index').form_button($next).form_close();
		$this->_regions['title'].= lang('upd_error_title');
		$this->_regions['label'] = lang('upd_error_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function readme()
	{
		$this->_regions['content'] = Location::view('readme', '_base', 'install', 'foo');
		$this->_regions['title'].= APP_NAME.' '.lang('global_readme_title');
		$this->_regions['label'] = APP_NAME.' '.lang('global_readme_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function step($step = 1)
	{
		// sanity check
		$step = (is_numeric($step)) ? $step : 1;
		
		switch ($step)
		{
			case 1:
				ini_set('memory_limit', -1);
				
				$this->load->helper('utility');
				
				// check the database size and the server memory limit
				$db_size = file_size($this->sys->get_database_size());
				$memory = check_memory($db_size);
				
				if ($memory)
				{
					$today = getdate();
					
					$filename = $this->db->dbprefix.$today['year'].$today['mon'].$today['mday'];
						
					$backup = backup_database($this->db->dbprefix, 'save', $filename);
					
					if ($backup)
					{
						if (is_file(APPPATH.'assets/backups/'.$filename.'.zip'))
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
						$data['next']['disabled'] = true;
					}
				}
				else
				{
					$message = lang('upd_step1_memory');
				}
				
				$data['label']['text'] = $message;
				
				$next = array(
					'name' => 'next',
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
					'content' => lang('button_next'),
				);
				
				$this->_regions['content'] = Location::view('update_step_1', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('update_step_1_js', '_base', 'update');
				$this->_regions['controls'] = form_open('update/step/2').form_button($next).form_close();
				$this->_regions['title'].= lang('upd_step1_title');
				$this->_regions['label'] = lang('upd_step1_title');
			break;
				
			case 2:
				$this->load->helper('directory');
				
				$item = $this->sys->get_item('system_info', 'sys_id', 1);
				
				$version = $item->sys_version_major.$item->sys_version_minor.$item->sys_version_update;
				
				$dir = directory_map(MODFOLDER.'/assets/update');
				
				if (is_array($dir))
				{
					sort($dir);
					
					foreach ($dir as $key => $value)
					{
						if ($value == 'index.html' or $value == 'versions.php')
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
					
					foreach ($dir as $d)
					{
						include_once(MODPATH.'assets/update/'.$d);
						
						sleep(1);
					}
				}
				else
				{
					include_once(MODPATH.'assets/update/versions.php');
					
					foreach ($version_array as $k => $v)
					{
						if ($v < $version)
						{
							unset($version_array[$k]);
						}
					}
					
					foreach ($version_array as $value)
					{
						include_once(MODPATH.'assets/update/update_' .$value.'.php');
						
						sleep(1);
					}
				}

				// update the system info table
				$this->sys->update_system_info($system_info);
				
				$this->_register();
				
				// update the users to be first launch
				$this->load->model('users_model', 'user');
				$users = array('is_firstlaunch' => 'y');
				$this->user->update_all_users($users, '');
				
				$data['label'] = array(
					'text' => sprintf(
						lang('upd_step2_success'),
						$system_info['sys_version_major'].$system_info['sys_version_minor'].$system_info['sys_version_update']
					),
					'back' => lang('upd_step2_site')
				);
				
				$next = array(
					'name' => 'next',
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
					'content' => lang('upd_step2_site'),
				);
				
				$this->_regions['content'] = Location::view('update_step_2', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('update_step_2_js', '_base', 'update');
				$this->_regions['controls'] = form_open('main/index').form_button($next).form_close();
				$this->_regions['title'].= lang('upd_step2_title');
				$this->_regions['label'] = lang('upd_step2_title');
			break;
		}
		
		Template::assign($this->_regions);
		
		Template::render();
	}

	public function verify()
	{
		$this->load->helper('utility');
		
		$data['table'] = verify_server();
		
		$data['label'] = array(
			'back' => lang('upd_verify_back'),
			'text' => lang('verify_text')
		);
		
		$button = array(
			'name' => 'install',
			'type' => 'submit',
			'id' => 'install',
			'class' => 'btn-main',
			'content' => lang('button_begin_update'),
		);
		
		$this->_regions['content'] = Location::view('update_verify', '_base', 'update', $data);
		$this->_regions['javascript'] = Location::js('verify_js', '_base', 'update');
		$this->_regions['controls'] = form_open('update/check').form_button($button).form_close();
		$this->_regions['title'].= lang('verify_title');
		$this->_regions['label'] = lang('verify_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * Check for the latest version of the system
	 *
	 * @access	private
	 * @return	array 	the array of version information and messages
	 */
	private function _check_version()
	{
		if (ini_get('allow_url_fopen'))
		{
			$this->load->helper('yayparser');
			
			$contents = file_get_contents(VERSION_FEED);
			
			$array = yayparser($contents);
			
			$system = $this->sys->get_system_info();
			
			$version = array(
				'files' => array(
					'full'		=> APP_VERSION_MAJOR.'.'.APP_VERSION_MINOR.'.'.APP_VERSION_UPDATE,
					'major'		=> APP_VERSION_MAJOR,
					'minor'		=> APP_VERSION_MINOR,
					'update'	=> APP_VERSION_UPDATE
				),
				'database' => array(
					'full'		=> $system->sys_version_major.'.'.$system->sys_version_minor.'.'.$system->sys_version_update,
					'major'		=> $system->sys_version_major,
					'minor'		=> $system->sys_version_minor,
					'update'	=> $system->sys_version_update
				),
			);
			
			$update = false;
			
			if (version_compare($version['files']['full'], $array['version'], '<') or version_compare($version['database']['full'], $array['version'], '<'))
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
			elseif ($update !== false)
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
		
		return false;
	}
	
	/**
	 * Register Nova
	 *
	 * @access	private
	 * @return	void
	 */
	private function _register()
	{
		$this->load->library('xmlrpc');
		$this->load->library('email');
		
		// set up the server and method for the request
		$this->xmlrpc->server(REGISTER, 80);
		$this->xmlrpc->method('Do_Registration');
		
		// build the request
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
		
		// compile the request
		$this->xmlrpc->request($request);
		
		if (extension_loaded('xmlrpc'))
		{
			if ( ! $this->xmlrpc->send_request())
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
			
			$this->email->from(Util::email_sender());
			$this->email->to('anodyne.nova@gmail.com');
			$this->email->subject('Nova Registration');
			$this->email->message($message);
			
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
		
		$this->email->from(Util::email_sender());
		$this->email->to('anodyne.nova@gmail.com');
		$this->email->subject('Nova 2 Survey');
		$this->email->message($message);
		
		$email = $this->email->send();
	}
}
