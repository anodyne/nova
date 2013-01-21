<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Upgrade controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_upgrade extends CI_Controller {
	
	/**
	 * @var	bool	Is the system installed?
	 */
	public $installed = false;
	
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
		$this->load->model('settings_model', 'settings');
		$this->load->model('system_model', 'sys');
		$this->nova->lang('install');
		$this->lang->load('app');
		
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
		// load the resources
		$this->load->model('archive_model', 'arc');
		
		// list all the tables in the database
		$tables = $this->db->list_tables();
		
		// make sure there are SMS tables
		foreach ($tables as $key => $t)
		{
			if (substr($t, 0, 4) != 'sms_')
			{
				unset($tables[$key]);
			}
		}
		
		// if there aren't SMS tables, redirect to the error page
		if (count($tables) == 0)
		{
			redirect('upgrade/error/2');
		}
		
		$sms = $this->arc->get_sms_version();
		$sms_ver = str_replace('.', '', $sms);
		$sms_const = str_replace('.', '', SMS_UPGRADE_VERSION);
		$status = 0;
		
		$status = ( ! $sms) ? 1 : $status;
		$status = ($sms_ver < $sms_const) ? 2 : $status;
		$status = ($this->installed) ? 3 : $status;
		
		if ($status > 0)
		{
			$flash['status'] = error;
			$flash['message'] = false;
			
			switch ($status)
			{
				case 1:
					$flash['message'] = sprintf(
						lang('upg_error_1'),
						SMS_UPGRADE_VERSION,
						SMS_UPGRADE_VERSION
					);
				break;
				
				case 2:
					$flash['message'] = lang('upg_error_2');
				break;
				
				case 3:
					$flash['message'] = lang('upg_error_3');
				break;
				
				case 4:
					$flash['message'] = sprintf(
						lang('upg_error_4'),
						strtoupper(GENRE)
					);
				break;
			}
			
			$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
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
		
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'name' => 'next',
			'value' => 'next',
			'id' => 'next',
			'content' => ucwords(lang('button_begin'))
		);
		
		$this->_regions['content'] = Location::view('upgrade_index', '_base', 'update', $data);
		$this->_regions['javascript'] = Location::js('upgrade_index_js', '_base', 'update');
		$this->_regions['controls'] = form_open('upgrade/verify').form_button($next).form_close();
		$this->_regions['title'].= lang('upg_index_title');
		$this->_regions['label'] = lang('upg_index_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * Error page for the upgrade controller. The following error codes can be
	 * displayed through this page:
	 *
	 *     0 - no errors
	 *     1 - SMS prior to 2.6.9 installed
	 *     2 - SMS not installed
	 *     3 - Nova already installed
	 *     4 - DS9 genre not being used (shouldn't matter for 2.0)
	 */
	public function error($id = 0)
	{
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
		
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'name' => 'next',
			'value' => 'next',
			'id' => 'next',
			'content' => ucwords(lang('button_upgrade'))
		);
		
		$flash['status'] = 'error';
		$flash['message'] = $label['error_'.$id];
		
		$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
		
		$this->_regions['controls'] = form_open('upgrade/index').form_button($next).form_close();
		$this->_regions['title'].= lang('upg_error_title');
		$this->_regions['label'] = lang('upg_error_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function step($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// is installation allowed?
		$allowed = true;
		
		if (GENRE == '')
		{
			// installation not allowed
			$allowed = false;
			
			$flash['status'] = 'error';
			$flash['message'] = lang('error_no_genre');
			
			$this->_regions['flash_message'] = Location::view('flash', '_base', 'update', $flash);
		}
		
		switch ($step)
		{
			case 0:
				$data['message'] = nl2br(lang('upg_step0_message'));
				
				$this->_regions['content'] = Location::view('upgrade_step0', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('upgrade_step0_js', '_base', 'update');
				$this->_regions['title'].= lang('upg_title');
				$this->_regions['label'] = lang('upg_step0_label');
				
				if ($allowed)
				{
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'name' => 'next',
						'value' => 'next',
						'id' => 'next',
						'content' => ucwords(lang('upg_start'))
					);
					
					$this->_regions['controls'] = form_open('upgrade/step/1').form_button($next).form_close();
				}
			break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// load the forge
					$this->load->dbforge();
					
					// update the character set
					$this->sys->update_database_charset();
					
					// pull in the field information
					include_once MODPATH.'assets/install/fields.php';
					
					foreach ($data as $key => $value)
					{
						$this->dbforge->add_field($$value['fields']);
						$this->dbforge->add_key($value['id'], true);
						
						if (isset($value['index']))
						{
							foreach ($value['index'] as $index)
							{
								$this->dbforge->add_key($index);
							}
						}
						
						$this->dbforge->create_table($key, true);
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from inserting the tables
					$data = null;
					
					// pull in the basic data
					include_once MODPATH.'assets/install/data.php';
					
					$insert = array();
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$this->db->insert($value, $v);
						}
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from insert the data
					$data = null;
					
					// pull in the genre data
					include_once MODPATH.'assets/install/genres/'.GENRE.'.php';
					
					$genre = array();
					
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$this->db->insert($key_d, $v);
						}
					}
					
					if (APP_DATA_DEV === true)
					{
						// pause the script for a second
						sleep(1);
						
						// wipe out the data from insert the data
						$data = null;
						
						// pull in the development test data
						include_once MODPATH.'assets/install/dev.php';
						
						$insert = array();
						
						foreach ($data as $value)
						{
							foreach ($$value as $k => $v)
							{
								$this->db->insert($value, $v);
							}
						}
					}
				}
				
				// do the quick installs
				$this->_install_ranks();
				$this->_install_skins();
				
				$data['label'] = array(
					'message' => lang('upg_step1_message'),
				);
				
				// set the loading image
				$data['loading'] = array(
					'src' => MODFOLDER.'/core/views/_base/images/loading-circle-large.gif',
					'class' => 'image',
				);
				
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'start',
					'content' => ucwords(lang('global_upgrade'))
				);
				
				$this->_regions['content'] = Location::view('upgrade_step1', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('upgrade_step1_js', '_base', 'update');
				$this->_regions['controls'] = form_button($next).form_close();
				$this->_regions['title'].= lang('upg_title');
				$this->_regions['label'] = lang('upg_step1_label');
			break;
				
			case 2:
				// set the loading image
				$data['loading'] = array(
					'src' => MODFOLDER.'/core/views/_base/images/loading-circle-large.gif',
					'class' => 'image',
				);
				
				$data['message'] = lang('upg_step2_message');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'start',
					'content' => ucwords(lang('global_run'))
				);
				
				$this->_regions['content'] = Location::view('upgrade_step2', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('upgrade_step2_js', '_base', 'update');
				$this->_regions['controls'] = form_button($next).form_close();
				$this->_regions['title'].= lang('upg_title');
				$this->_regions['label'] = lang('upg_step2_label');
			break;
				
			case 3:
				if (isset($_POST['submit']))
				{
					// do the registration
					$this->_register();
				}
				
				$this->load->model('users_model', 'user');
				
				// an empty array for user info
				$data['options'] = array();
				
				// get all active users
				$all = $this->user->get_users();
				
				if ($all->num_rows() > 0)
				{
					foreach ($all->result() as $a)
					{
						$data['options'][$a->userid] = $a->name.' ('.$a->email.')';
					}
				}
				
				// set the loading image
				$data['loading'] = array(
					'src' => MODFOLDER.'/core/views/_base/images/loading-circle-large.gif',
					'class' => 'image',
				);
				
				$data['message'] = nl2br(lang('upg_step3_message'));
				$data['password'] = nl2br(lang('upg_step3_password'));
				$data['admin'] = nl2br(lang('upg_step3_admin'));
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'start',
					'content' => ucwords(lang('global_finalize'))
				);
				
				$this->_regions['content'] = Location::view('upgrade_step3', '_base', 'update', $data);
				$this->_regions['javascript'] = Location::js('upgrade_step3_js', '_base', 'update');
				$this->_regions['controls'] = form_button($next).form_close();
				$this->_regions['title'].= lang('upg_title');
				$this->_regions['label'] = lang('upg_step3_label');
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
			'back' => lang('upg_verify_back'),
			'text' => lang('verify_text')
		);
		
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'name' => 'next',
			'value' => 'next',
			'id' => 'next',
			'content' => ucwords(lang('button_next'))
		);
		
		$this->_regions['content'] = Location::view('upgrade_verify', '_base', 'update', $data);
		$this->_regions['javascript'] = Location::js('verify_js', '_base', 'update');
		$this->_regions['controls'] = form_open('upgrade/step/0').form_button($next).form_close();
		$this->_regions['title'].= lang('verify_title');
		$this->_regions['label'] = lang('verify_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _install_ranks()
	{
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
			
			foreach ($dir as $key => $value)
			{
				if (file_exists(APPPATH .'assets/common/'. GENRE .'/ranks/'. $value .'/rank.yml'))
				{
					$contents = file_get_contents(APPPATH .'assets/common/'. GENRE .'/ranks/'. $value .'/rank.yml');
					
					$array = yayparser($contents);
					
					$set = array(
						'rankcat_name'		=> $array['rank'],
						'rankcat_location'	=> $array['location'],
						'rankcat_credits'	=> $array['credits'],
						'rankcat_preview'	=> $array['preview'],
						'rankcat_blank'		=> $array['blank'],
						'rankcat_extension'	=> $array['extension'],
						'rankcat_url'		=> $array['url'],
					);
					
					$this->ranks->add_rank_set($set);
				}
			}
		}
	}
	
	protected function _install_skins()
	{
		$this->load->helper('directory');
		$this->load->helper('yayparser');
		
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
		
		$pop = array('_base', '_base_override', 'index.html', 'template.php');
		
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
				$contents = file_get_contents(APPPATH .'views/'. $value .'/skin.yml');
				
				$array = yayparser($contents);
				
				$skin = array(
					'skin_name'		=> $array['skin'],
					'skin_location'	=> $array['location'],
					'skin_credits'	=> $array['credits']
				);
				
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
					
					$this->sys->add_skin_section($section);
				}
			}
		}
	}
	
	private function _register()
	{
		$this->load->library('xmlrpc');
		$this->load->library('email');
		
		// set up the server and method for the request
		$this->xmlrpc->server(REGISTER, 80);
		$this->xmlrpc->method('Do_Registration');
		
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
