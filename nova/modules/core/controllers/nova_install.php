<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Install controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_install extends CI_Controller {
	
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
		
		if ( ! file_exists(APPPATH.'config/database.php') and $this->uri->segment(2) != 'setupconfig')
		{
			redirect('install/setupconfig');
		}
		
		if (file_exists(APPPATH.'config/database.php') and $this->uri->segment(2) != 'setupconfig')
		{
			$this->load->database();
			$this->load->model('system_model', 'sys');
			
			$this->installed = $this->sys->check_install_status();
		}
		else
		{
			// change the session class to NOT use the database for now
			$this->config->set_item('sess_use_database', false);
			
			$this->load->library('session');
		}
		
		// load the install language file
		$this->lang->load('app');
		$this->nova->lang('install');
		
		// set the template file
		Template::$file = '_base/template_install';
		
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
		$data['label'] = array(
			'choose' => lang('install_options_choose'),
			'text_db' => lang('install_options_db_text'),
			'text_fresh' => lang('install_options_fresh_text'),
			'text_genre' => lang('install_options_genre_text'),
			'text_remove' => lang('install_options_remove_text'),
			'text_upd' => lang('install_options_upd_text'),
			'text_upg' => lang('install_options_upg_text'),
			'title_db' => lang('install_options_db_title'),
			'title_fresh' => lang('install_options_fresh_title'),
			'title_genre' => lang('install_options_genre_title'),
			'title_remove' => lang('install_options_remove_title'),
			'title_upd' => lang('install_options_upd_title'),
			'title_upg' => lang('install_options_upg_title'),
			'title_site' => lang('global_back_site'),
		);
		
		$data['installed'] = $this->installed;
		
		$this->_regions['content'] = Location::view('index', '_base', 'install', $data);
		$this->_regions['title'].= lang('install_index_title');
		$this->_regions['label'] = lang('install_index_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}

	public function changedb($action = false, $type = false)
	{
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'change':
					$this->load->dbforge();
					
					switch ($type)
					{
						case 'table':
							$table = $this->input->post('table_name', true);
							
							$this->dbforge->add_field('id');
							
							$add = $this->dbforge->create_table($table, true);
							
							if ( ! $add)
							{
								$flash['status'] = 'error';
								$flash['message'] = sprintf(
									lang_output('install_changedb_table_failure'),
									$this->db->dbprefix.$table
								);
							}
							else
							{
								$flash['status'] = 'success';
								$flash['message'] = sprintf(
									lang_output('install_changedb_table_success'),
									$this->db->dbprefix.$table
								);
							}
						break;
							
						case 'field':
							$table = $this->input->post('table_name', true);
							$name = $this->input->post('field_name', true);
							$ftype = $this->input->post('field_type', true);
							$constraint = $this->input->post('field_constraint', true);
							$fvalue = $this->input->post('field_value', true);
							
							if ($table !== 0)
							{
								$fields = array(
									$name => array(
										'type' => strtoupper($ftype),
										'constraint' => $constraint,
									),
								);
								
								if (strtolower($ftype) == 'int')
								{
									// do nothing ... for whatever reason i can't do !=
								}
								else
								{
									$fields[$name]['default'] = $fvalue;
								}
								
								$add = $this->dbforge->add_column($table, $fields);
							}
							
							if (isset($add))
							{
								if ( ! $add)
								{
									$flash['status'] = 'error';
									$flash['message'] = sprintf(
										lang_output('install_changedb_field_failure'),
										$name,
										$this->db->dbprefix.$table
									);
								}
								else
								{
									$flash['status'] = 'success';
									$flash['message'] = sprintf(
										lang_output('install_changedb_field_success'),
										$name,
										$this->db->dbprefix.$table
									);
								}
							}
							else
							{
								$flash['status'] = 'error';
								$flash['message'] = lang_output('install_changedb_field_notable');
							}
						break;
					}
					
					// set the flash message
					$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
					
					// the view to use
					$view_loc = 'changedb';
					
					$submit = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('button_submit'))
					);
					
					$this->_regions['controls'] = form_button($submit).form_close();
				break;
					
				case 'verify':
					$this->load->model('system_model', 'sys');
					
					$email = $this->input->post('email', true);
					$password = $this->input->post('password', true);
					
					$verify = Auth::verify($email, $password);
					
					$user = $this->sys->get_item('users', 'email', $email, 'userid');
					
					$sysadmin = Auth::is_sysadmin($user);
					
					if ($verify == 0 and $sysadmin)
					{
						$tables = $this->db->list_tables();
						
						$prefixlen = strpos($this->db->dbprefix, '_');
						
						$data['options'][0] = lang('install_changedb_choose');
						
						// make sure we're only dealing with the nova tables
						foreach ($tables as $key => $value)
						{
							if (substr($value, 0, $prefixlen) != $this->db->dbprefix)
							{
								// remove the prefix from what will be the field value
								$k = str_replace($this->db->dbprefix, '', $value);
								
								// assign each table to the options array
								$data['options'][$k] = $value;
							}
						}
						
						// the view file
						$view_loc = 'changedb_main';
					}
					else
					{
						$flash['status'] = 'error';
						$flash['message'] = lang_output('error_verify_'. $verify);
						
						// set the flash message
						$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
						
						// the view to use
						$view_loc = 'changedb';
						
						$submit = array(
							'type' => 'submit',
							'class' => 'btn-main',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('button_submit'))
						);
						
						$this->_regions['controls'] = form_button($submit).form_close();
					}
				break;
			}
		}
		else
		{
			// the view file to use
			$view_loc = 'changedb';
			
			$submit = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('button_submit'))
			);
			
			$this->_regions['controls'] = form_button($submit).form_close();
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
		
		$this->_regions['content'] = Location::view($view_loc, '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js('genre_js', '_base', 'install');
		$this->_regions['title'].= lang('install_changedb_title');
		$this->_regions['label'] = lang('install_changedb_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function genre($action = false)
	{
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'change':
					$this->load->dbforge();
					
					// get the genre
					$file = $this->input->post('genre', true);
					
					// drop the .php extension off
					$selected_genre = strtolower(substr($file, 0, -4));
					
					include_once MODPATH.'assets/install/fields.php';
					
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
						$this->dbforge->add_key($value['id'], true);
						$verify[$key] = $this->dbforge->create_table($key, true);
					}
					
					include_once MODPATH.'assets/install/genres/'.$file;
					
					// put the genre data in the newly created tables
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$this->db->insert($key_d, $v);
						}
					}
					
					// set the flash message
					$flash['status'] = 'info';
					$flash['message'] = lang_output('install_genre_success');
					
					// set the flash message
					$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
					
					// the view to use
					$view_loc = 'genre';
					
					$submit = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('button_submit'))
					);
					
					$this->_regions['controls'] = form_button($submit).form_close();
				break;
					
				case 'verify':
					$email = $this->input->post('email', true);
					$password = $this->input->post('password', true);
					
					$verify = Auth::verify($email, $password);
					
					$user = $this->sys->get_item('users', 'email', $email, 'userid');
					
					$sysadmin = Auth::is_sysadmin($user);
					
					if ($verify == 0 and $sysadmin)
					{
						$this->load->helper('directory');
						
						// grab the files from the directory
						$genre_files = directory_map(MODPATH.'assets/install/genres/', true);
						
						// grab the genre and find out it's length
						$genre = strtolower(GENRE);
						$genrelen = strlen($genre);
						
						foreach ($genre_files as $key => $g)
						{
							// if the file is index.html or the current genre's data file, ignore it
							if ($g == 'index.html' or substr($g, 0, $genrelen) == $genre)
							{
								unset($genre_files[$key]);
							}
						}
						
						// send the list of genres to the view
						$data['files'] = $genre_files;
						
						// the view to use
						$view_loc = 'genre_main';
						
						$submit = array(
							'type' => 'submit',
							'class' => 'btn-main',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('button_submit'))
						);
						
						$this->_regions['controls'] = form_button($submit).form_close();
					}
					else
					{
						$flash['status'] = 'error';
						$flash['message'] = lang_output('error_verify_'. $verify);
						
						// set the flash message
						$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
						
						// set the view
						$view_loc = 'genre';
						
						$submit = array(
							'type' => 'submit',
							'class' => 'btn-main',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('button_submit'))
						);
						
						$this->_regions['controls'] = form_button($submit).form_close();
					}
				break;
			}
		}
		else
		{
			// set the view
			$view_loc = 'genre';
			
			$submit = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('button_submit'))
			);
			
			$this->_regions['controls'] = form_button($submit).form_close();
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
		
		$this->_regions['content'] = Location::view($view_loc, '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js('genre_js', '_base', 'install');
		$this->_regions['title'].= lang('install_genre_title');
		$this->_regions['label'] = lang('install_genre_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function main($error = 0)
	{
		/**
		 * 0 - no errors
		 * 1 - system is already installed
		 * 2 - you must be a sysadmin to update the genre
		 */
		
		$data['installed'] = $this->installed;
		
		// sanity check
		$error = (is_numeric($error)) ? $error : 0;
		
		if ($error > 0 or $this->installed === true)
		{
			$error = ($error == 1 or $this->installed === true) ? 1 : $error;
			
			$flash['status'] = ($error == 1) ? 'info' : 'error';
			$flash['message'] = lang_output('install_error_'. $error);
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
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
		
		$button = array(
			'name' => 'next',
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'next',
			'content' => lang('button_verify'),
		);
		
		$this->_regions['content'] = Location::view('main', '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js('main_js', '_base', 'install');
		$this->_regions['title'].= lang('install_index_title');
		$this->_regions['label'] = lang('install_index_title');
		$this->_regions['controls'] = form_open('install/verify').form_button($button).form_close();
		
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
	
	public function remove()
	{
		$flash['status'] = 'info';
		$flash['message'] = lang_output('install_remove_warning');
		
		if (isset($_POST['submit']))
		{
			// set the POST variables
			$email = trim($this->security->xss_clean($_POST['email']));
			$password = trim($this->security->xss_clean($_POST['password']));
			
			// verify their email/password combo is right
			$verify = Auth::verify($email, $password);
			
			// get their user ID
			$user = $this->sys->get_item('users', 'email', $email, 'userid');
			
			// verify they're a sys admin
			$sysadmin = Auth::is_sysadmin($user);
			
			if ($verify == 0 and $sysadmin)
			{
				// remove the data
				$this->_destroy_data();
				
				// set the flash info
				$flash['status'] = 'success';
				$flash['message'] = lang_output('install_remove_success');
			}
			else
			{
				// set the flash info
				$flash['status'] = 'error';
				$flash['message'] = lang_output('error_verify_'. $verify);
			}
			
			// the view to use
			$view_loc = 'remove_confirm';
			
			$button = array(
				'name' => 'install',
				'type' => 'submit',
				'id' => 'install',
				'class' => 'btn-main',
				'content' => lang('button_install'),
			);
			
			// build the next step control
			$this->_regions['controls'] = form_open('install/index').form_button($button).form_close();
			$this->_regions['_redirect'] = Template::add_redirect('install/index', 15);
		}
		else
		{
			$clear = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'name' => 'submit',
				'value' => 'clear',
				'id' => 'clear',
				'content' => ucwords(lang('button_clear'))
			);
		
			$view_loc = 'remove';
			
			// build the next step control
			$this->_regions['controls'] = form_button($clear).form_close();
		}
		
		$data['label'] = array(
			'back' => lang('button_back_install'),
			'email' => lang('global_email'),
			'password' => lang('global_password'),
		);
		
		$this->_regions['content'] = Location::view($view_loc, '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js('remove_js', '_base', 'install');
		$this->_regions['title'].= lang('install_remove_title');
		$this->_regions['label'] = lang('install_remove_title');
		$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function setupconfig($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// pass the step over to the view file
		$data['step'] = $step;
		
		if ( ! file_exists(MODPATH.'assets/database/db.mysql.php'))
		{
			$data['message'] = sprintf(
				lang('setup.text.no_config'),
				MODFOLDER.'/assets/database/db.mysql.php'
			);
		}
		else
		{
			if (file_exists(APPPATH.'config/database.php') and $this->uri->segment(3) != 4)
			{
				$data['message'] = sprintf(
					lang('setup.text.config_exists'),
					APPFOLDER.'/config'
				);
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.1', '<'))
				{
					$data['message'] = sprintf(
						lang('setup.text.php'),
						PHP_VERSION
					);
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data['message'] = sprintf(
								lang('setup.text.step0'),
								MODFOLDER.'/assets/database/db.mysql.php',
								APPFOLDER.'/config'
							);
							
							$next = array(
								'name' => 'next',
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
								'content' => lang('button_next'),
							);
							
							if (extension_loaded('mysql'))
							{
								$this->_regions['controls'] = form_open('install/setupconfig/1').form_button($next).form_close();
							}
							else
							{
								$flash['status'] = 'error';
								$flash['message'] = lang('setup.text.nodb');
								
								$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
							}
						break;
						
						case 1:
							$next = array(
								'name' => 'next',
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
								'content' => lang('button_next'),
							);
							
							$data['message'] = lang('setup.text.connection');
							
							$this->_regions['controls'] = form_button($next).form_close();
						break;
						
						case 2:
							// set the variables to use
							$dbName		= trim($this->security->xss_clean($_POST['dbName']));
							$dbUser		= trim($this->security->xss_clean($_POST['dbUser']));
							$dbPass		= trim($this->security->xss_clean($_POST['dbPass']));
							$dbHost		= trim($this->security->xss_clean($_POST['dbHost']));
							$prefix		= trim($this->security->xss_clean($_POST['prefix']));
							
							// set the session variables
							$this->session->set_userdata('dbName', $dbName);
							$this->session->set_userdata('dbUser', $dbUser);
							$this->session->set_userdata('dbPass', $dbPass);
							$this->session->set_userdata('dbHost', $dbHost);
							$this->session->set_userdata('prefix', $prefix);
							
							// set the temporary db config
							$config = array(
								'hostname' => $this->session->userdata('dbHost'),
								'username' => $this->session->userdata('dbUser'),
								'password' => $this->session->userdata('dbPass'),
								'database' => $this->session->userdata('dbName'),
								'dbdriver' => 'mysql',
								'dbprefix' => $this->session->userdata('prefix'),
								'pconnect' => false,
								'db_debug' => true,
								'cache_on' => false,
								'cachedir' => '',
								'char_set' => 'utf8',
								'dbcollat' => 'utf8_general_ci'
							);
							
							// load the database
							$this->load->database($config);
							
							try {
								$tables = $this->db->list_tables();
								
								if (is_array($tables))
								{
									$data['message'] = lang('setup.text.step2success');
									
									$next = array(
										'name' => 'next',
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
										'content' => lang('button_next'),
									);
									
									$this->_regions['controls'] = form_open('install/setupconfig/3').form_button($next).form_close();
								}
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$data['message'] = lang('setup.text.step2nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data['message'] = lang('setup.text.step2userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data['message'] = sprintf(
										lang('setup.text.step2dbname'),
										$dbName,
										$dbName
									);
								}
								else
								{
									$data['message'] = lang('setup.text.step2gen');
								}
								
								$next = array(
									'name' => 'next',
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
									'content' => lang('button_startover'),
								);
								
								$this->_regions['controls'] = form_open('install/setupconfig/1').form_button($next).form_close();
							}
						break;
							
						case 3:
							// grab the disabled functions
							$disabled = explode(',', ini_get('disable_functions'));
							
							// make sure everything is trimmed properly
							foreach ($disabled as $key => $value)
							{
								$disabled[$key] = trim($value);
							}
							
							// what we need
							$need = array('fopen', 'fwrite', 'file');
							
							// check to make sure we have what we need
							$check = array_intersect($disabled, $need);
							
							// pull in the mysql file
							$file = file(MODPATH.'assets/database/db.mysql.php');
							
							if (is_array($file))
							{
								foreach ($file as $line_num => $line)
								{
									switch (substr($line, 16, 8))
									{
										case "hostname":
											$file[$line_num] = str_replace("localhost", $this->session->userdata('dbHost'), $line);
										break;
										
										case "username":
											$file[$line_num] = str_replace("novauser", $this->session->userdata('dbUser'), $line);
										break;
										
										case "password":
											$file[$line_num] = str_replace("novapass", $this->session->userdata('dbPass'), $line);
										break;
										
										case "database":
											$file[$line_num] = str_replace("novadb", $this->session->userdata('dbName'), $line);
										break;
										
										case "dbprefix":
											$file[$line_num] = str_replace("nova_", $this->session->userdata('prefix'), $line);
										break;
									}
								}
								
								$code = false;
								
								foreach ($file as $value)
								{
									$code.= htmlentities($value);
								}
							}
							else
							{
								$code = htmlentities("<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

\$active_group = 'default';
\$active_record = true; /** DO NOT CHANGE THIS - DOING SO WILL BREAK THE SYSTEM! **/

\$db['default']['hostname'] = '".$this->session->userdata('dbHost')."';
\$db['default']['username'] = '".$this->session->userdata('dbUser')."';
\$db['default']['password'] = '".$this->session->userdata('dbPass')."';
\$db['default']['database'] = '".$this->session->userdata('dbName')."';
\$db['default']['dbdriver'] = 'mysql';
\$db['default']['dbprefix'] = '".$this->session->userdata('prefix')."';
\$db['default']['pconnect'] = true;
\$db['default']['db_debug'] = NOVA_DB_DEBUG;
\$db['default']['cache_on'] = false;
\$db['default']['cachedir'] = '';
\$db['default']['char_set'] = 'utf8';
\$db['default']['dbcollat'] = 'utf8_general_ci';
");
							}
							
							if (count($check) == 0)
							{
								// make sure the config directory has the proper permissions
								chmod(APPPATH.'config', 0777);
								
								// open the file
								$handle = fopen(APPPATH.'config/database.php', 'w');
								
								// figure out if the write was successful
								$write = false;
							
								// write the file line by line
								foreach ($file as $line)
								{
									$write = fwrite($handle, $line);
								}
								
								// close the file
								fclose($handle);
								
								try {
									chmod(APPPATH.'config/database.php', 0666);
								} catch (Exception $e) {
									log_message('error', 'Could not change file permissions for the database configuration file to 0666. Please do so manually.');
								}
								
								if ($write)
								{
									$data['message'] = lang('setup.text.step3write');
									
									$this->session->sess_destroy();
									
									$next = array(
										'name' => 'next',
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
										'content' => lang('button_install'),
									);
									
									$this->_regions['controls'] = form_open('install/index').form_button($next).form_close();
								}
								else
								{
									$data['code'] = $code;
									
									$data['message'] = sprintf(
										lang('setup.text.step3nowrite'),
										APPFOLDER.'/config'
									);
									
									$next = array(
										'name' => 'next',
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
										'content' => lang('button_retest'),
									);
									
									$this->_regions['controls'] = form_open('install/setupconfig/4').form_button($next).form_close();
								}
							}
							else
							{
								$data['code'] = $code;
								
								$data['message'] = sprintf(
									lang('setup.text.step3nowrite'),
									APPFOLDER.'/config'
								);
								
								$next = array(
									'name' => 'next',
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
									'content' => lang('button_retest'),
								);
								
								$this->_regions['controls'] = form_open('install/setupconfig/4').form_button($next).form_close();
							}
						break;
							
						case 4:
							// set the temporary db config
							$config = array(
								'hostname' => $this->session->userdata('dbHost'),
								'username' => $this->session->userdata('dbUser'),
								'password' => $this->session->userdata('dbPass'),
								'database' => $this->session->userdata('dbName'),
								'dbdriver' => 'mysql',
								'dbprefix' => $this->session->userdata('prefix'),
								'pconnect' => false,
								'db_debug' => true,
								'cache_on' => false,
								'cachedir' => '',
								'char_set' => 'utf8',
								'dbcollat' => 'utf8_general_ci'
							);
							
							// load the database
							$this->load->database($config);
							
							try {
								$tables = $this->db->list_tables();
								
								if (is_array($tables))
								{
									$data['message'] = lang('setup.text.step4success');
									
									$next = array(
										'name' => 'next',
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
										'content' => lang('button_install'),
									);
									
									$this->_regions['controls'] = form_open('install/index').form_button($next).form_close();
								}
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$data['message'] = lang('setup.text.step2nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data['message'] = lang('setup.text.step2userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data['message'] = sprintf(
										lang('setup.text.step2dbname'),
										$dbName,
										$dbName
									);
								}
								else
								{
									$data['message'] = lang('setup.text.step2gen');
								}
								
								$next = array(
									'name' => 'next',
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
									'content' => lang('button_startover'),
								);
								
								$this->_regions['controls'] = form_open('install/setupconfig/1').form_button($next).form_close();
							}
						break;
					}
				}
			}
		}
		
		$this->_regions['content'] = Location::view('setupconfig', '_base', 'install', $data);
		$this->_regions['title'].= lang('setup.title.config');
		$this->_regions['label'] = lang('setup.title.config');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function step($step = 1)
	{
		// change the time limit to make sure we don't return any fatal errors
		set_time_limit(0);
		
		$this->load->dbforge();
		
		// sanity check
		$step = (is_numeric($step)) ? $step : 1;
		
		if ($this->installed and ! $step)
		{
			redirect('install/index/error/1', 'refresh');
		}
		
		switch ($step)
		{
			case 1:
				// update the character set and collation
				$charset = $this->sys->update_database_charset();
				
				// pull in the install fields asset file
				include_once MODPATH.'assets/install/fields.php';
				
				// create an array for storing the results of the creation process
				$table = array();
				
				foreach ($data as $key => $value)
				{
					$this->dbforge->add_field($$value['fields']);
					$this->dbforge->add_key($value['id'], true);
					$table[] = $this->dbforge->create_table($key, true);
				}
				
				foreach ($table as $key => $t)
				{
					if ($t)
					{
						unset($table[$key]);
					}
				}
				
				$message = (count($table) > 0) ? lang('install_step1_failure') : lang('install_step1_success');
				
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('button_next'))
				);
				
				if (count($table) > 0)
				{
					$next['disabled'] = 'disabled';
				}
				
				$data['label']['inst_step1'] = $message;
				
				// the view files
				$view_loc = 'step_1';
				$js_loc = 'step_1_js';
				
				$this->_regions['controls'] = form_open('install/step/2').form_button($next).form_close();
				$this->_regions['title'].= lang('install_step1_title');
				$this->_regions['label'] = lang('install_step1_label');
			break;
				
			case 2:
				// pull in the install data asset file
				include_once MODPATH.'assets/install/data.php';
				
				$insert = array();
				
				foreach ($data as $value)
				{
					foreach ($$value as $k => $v)
					{
						$insert[] = $this->db->insert($value, $v);
					}
				}
				
				if (APP_DATA_DEV !== false)
				{
					// pull in the dev data
					include_once MODPATH.'assets/install/dev.php';
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$insert[] = $this->db->insert($value, $v);
						}
					}
				}
				
				foreach ($insert as $key => $i)
				{
					if ($i === true)
					{
						unset($insert[$key]);
					}
				}
				
				$message = (count($insert) > 0) ? lang('install_step2_failure') : lang('install_step2_success');
				
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('button_next'))
				);
				
				if (count($insert) > 0 or GENRE == '')
				{
					$next['disabled'] = 'disabled';
				}
				
				if (GENRE == '')
				{
					$flash['message'] = lang_output('error_install_no_genre');
					$flash['status'] = 'error';
					
					// set the flash message
					$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
				}
				
				$data['label']['inst_step2'] = $message;
				
				// the view files
				$view_loc = 'step_2';
				$js_loc = 'step_2_js';
				
				$this->_regions['controls'] = form_open('install/step/3').form_button($next).form_close();
				$this->_regions['title'].= lang('install_step2_title');
				$this->_regions['label'] = lang('install_step2_label');
			break;
				
			case 3:
				// pull in the install genre data asset file
				include_once MODPATH.'assets/install/genres/'.GENRE.'.php';
				
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
					if ($g)
					{
						unset($genre[$key]);
					}
				}
				
				$message = (count($genre) > 0) ? lang('install_step3_failure') : lang('install_step3_success');
				
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('button_next'))
				);
				
				if (count($genre) > 0)
				{
					$next['disabled'] = 'disabled';
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
				
				$this->load->model('ranks_model', 'rank');
				
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
					'src' => Location::img('loading-circle-small.gif', '_base', 'install'),
					'alt' => '',
					'class' => 'image'
				);
				
				$data['default_rank'] = array(
					'src' => base_url().Location::rank('default', $rank, $ext)
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
				
				// the view files
				$view_loc = 'step_3';
				$js_loc = 'step_3_js';
				
				$this->_regions['controls'] = form_button($next).form_close();
				$this->_regions['title'].= lang('install_step3_title');
				$this->_regions['label'] = lang('install_step3_label');
			break;
				
			case 4:
				// set the variables
				$submit = $this->input->post('next');
				
				// load the models
				$this->load->model('users_model', 'user');
				$this->load->model('characters_model', 'char');
				$this->load->model('positions_model', 'pos');
				$this->load->model('ranks_model', 'ranks');
				$this->load->model('settings_model', 'settings');
				$this->load->model('access_model', 'access');
				
				if ($submit !== false)
				{
					$insert = array();
					
					// build the create user array
					$create_user = array(
						'name'				=> $this->input->post('real_name', true),
						'email'				=> $this->input->post('email', true),
						'password'			=> Auth::hash($this->input->post('password', true)),
						'date_of_birth'		=> $this->input->post('dob', true),
						'access_role'		=> Access_Model::SYSADMIN,
						'is_sysadmin'		=> 'y',
						'is_game_master'	=> 'y',
						'is_webmaster'		=> 'y',
						'join_date'			=> now(),
						'security_question'	=> $this->input->post('security_question', true),
						'security_answer'	=> sha1($this->input->post('security_answer', true)),
						'timezone'			=> $this->input->post('timezones', true),
						'skin_main'			=> $this->sys->get_skinsec_default('main'),
						'skin_admin'		=> $this->sys->get_skinsec_default('admin'),
						'skin_wiki'			=> $this->sys->get_skinsec_default('wiki'),
						'display_rank'		=> $this->ranks->get_rank_default()
					);
					
					// insert the user data
					$c_user = $this->user->create_user($create_user);
					$insert[] = $c_user;
					
					// get the ID from the user insert
					$p_id = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('users');
					
					// create the user prefs
					$prefs = $this->user->create_user_prefs($p_id);
					$insert[] = $prefs;
					
					// build the create character array
					$create_character = array(
						'user'			=> $p_id,
						'first_name'	=> $this->input->post('first_name', true),
						'last_name'		=> $this->input->post('last_name', true),
						'position_1'	=> $this->input->post('position', true),
						'rank'			=> $this->input->post('rank', true),
						'date_activate'	=> now(),
						'crew_type'		=> 'active',
					);
					
					// insert the character data
					$c_character = $this->char->create_character($create_character);
					$insert[] = $c_character;
					
					// get the ID from the character insert
					$c_id = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('characters');
					
					$characters = array('main_char' => $c_id);
					
					// update the users table
					$this->user->update_user($p_id, $characters);
					
					// build the COC array
					$create_coc = array(
						'coc_crew' => $c_id,
						'coc_order' => 1);
					
					// insert the COC data
					$c_coc = $this->char->create_coc_entry($create_coc);
					$insert[] = $c_coc;
					
					// create the character bio data
					$c_data = $this->char->create_character_data_fields($c_id, $p_id);
					$insert[] = $c_data;
					
					// update the open positions
					$open = $this->pos->update_open_slots($create_character['position_1'], 'add_crew');
					
					// update my links
					$my_links = $this->sys->update_my_links();
				}
				
				foreach ($insert as $key => $i)
				{
					if ($i or $i > 0)
					{
						unset($insert[$key]);
					}
				}
				
				$message = (count($insert) > 0) ? lang('install_step4_failure') : lang('install_step4_success');
				
				// the next button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('button_next'))
				);
				
				if (count($insert) > 0)
				{
					$next['disabled'] = 'disabled';
				}
					
				// fields
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
					
					// set the flash message
					$this->_regions['flash_message'] = Location::view('flash', '_base', 'install', $flash);
				}
				
				// the view files
				$view_loc = 'step_4';
				$js_loc = 'step_4_js';
				
				$this->_regions['controls'] = form_button($next).form_close();
				$this->_regions['title'].= lang('install_step4_title');
				$this->_regions['label'] = lang('install_step4_label');
			break;
				
			case 5:
				$this->load->library('ftp');
				$this->load->model('settings_model', 'settings');
				$this->load->model('messages_model', 'msgs');
				
				// set the variables
				$submit = $this->input->post('next');
				$data = false;
				
				if ($submit !== false)
				{
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 2) == 's_')
						{
							$field = substr_replace($key, '', 0, 2);
							$array = array('setting_value' => $value);
							
							$update += $this->settings->update_setting($field, $array);
						}
					}
					
					// update the welcome page header
					$name = $this->settings->get_setting('sim_name');
					
					if ( ! empty($name))
					{
						$update_data = array('message_content' => 'Welcome to the '. $name .'!');
						$this->msgs->update_message($update_data, 'welcome_head');
					}
					
					// install the skins and ranks
					$this->_install_ranks();
					$this->_install_skins();
					
					// do the product registration
					$this->_register();
					
					if ($this->ftp->hostname != 'ftp.example.com')
					{
						$this->ftp->connect();
						
						$this->ftp->chmod(APPPATH.'logs/', DIR_WRITE_MODE);
						$this->ftp->chmod(APPPATH.'assets/backups/', DIR_WRITE_MODE);
						$this->ftp->chmod(APPPATH.'assets/images/characters/', DIR_WRITE_MODE);
						$this->ftp->chmod(APPPATH.'assets/images/awards/', DIR_WRITE_MODE);
						$this->ftp->chmod(APPPATH.'assets/images/tour/', DIR_WRITE_MODE);
						$this->ftp->chmod(APPPATH.'assets/images/missions/', DIR_WRITE_MODE);
						
						$this->ftp->close();
					}
				}
				
				$message = ($update > 0) ? lang('install_step5_success') : lang('install_step5_failure');
				
				$data['label'] = array(
					'site' => lang('button_site'),
					'inst_step5' => $message,
				);
					
				// the view files
				$view_loc = 'step_5';
				$js_loc = 'step_5_js';
				
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'name' => 'next',
					'value' => 'next',
					'id' => 'next',
					'content' => ucwords(lang('button_site'))
				);
				
				$this->_regions['controls'] = form_open('main/index').form_button($next).form_close();
				$this->_regions['title'].= lang('install_step5_title');
				$this->_regions['label'] = lang('install_step5_label');
			break;
		}
		
		$this->_regions['content'] = Location::view($view_loc, '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js($js_loc, '_base', 'install');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function verify()
	{
		$this->load->helper('utility');
		
		$data['table'] = verify_server();
		
		$data['label'] = array(
			'back' => lang('button_back_install'),
			'text' => lang('verify_text')
		);
		
		$button = array(
			'name' => 'install',
			'type' => 'submit',
			'id' => 'install',
			'class' => 'btn-main',
			'content' => lang('button_begin_install'),
		);
		
		$this->_regions['content'] = Location::view('verify', '_base', 'install', $data);
		$this->_regions['javascript'] = Location::js('verify_js', '_base', 'install');
		$this->_regions['controls'] = form_open('install/step/1').form_button($button).form_close();
		$this->_regions['title'].= lang('verify_title');
		$this->_regions['label'] = lang('verify_title');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * Quick install for ranks
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function _install_ranks()
	{
		// load the resources
		$this->load->helper('directory');
		$this->load->helper('yayparser');
		$this->load->model('ranks_model', 'ranks');
		
		$dir = directory_map(APPPATH.'assets/common/'.GENRE.'/ranks/', true);
		
		$ranks = $this->ranks->get_all_rank_sets('');
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $rank)
			{
				$key = array_search($rank->rankcat_location, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// create an array of items that shouldn't be included in the dir listing
			$pop = array('index.html');
			
			// make sure the items aren't in the listing
			foreach ($pop as $value)
			{
				$key = array_search($value, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// make sure these are items that can use quick install
			foreach ($dir as $key => $value)
			{
				if (file_exists(APPPATH.'assets/common/'.GENRE.'/ranks/'.$value.'/rank.yml'))
				{
					// get the contents of the file
					$contents = file_get_contents(APPPATH.'assets/common/'.GENRE.'/ranks/'.$value.'/rank.yml');
					
					// parse the contents of the yaml file
					$array = yayparser($contents);
					
					// create the skin array
					$set = array(
						'rankcat_name'		=> $array['rank'],
						'rankcat_location'	=> $array['location'],
						'rankcat_credits'	=> $array['credits'],
						'rankcat_preview'	=> $array['preview'],
						'rankcat_blank'		=> $array['blank'],
						'rankcat_extension'	=> $array['extension'],
						'rankcat_url'		=> $array['url'],
						'rankcat_genre'		=> $array['genre'],
					);
					
					$this->ranks->add_rank_set($set);
				}
			}
		}
	}
	
	/**
	 * Quick Install for skins
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function _install_skins()
	{
		// load the resources
		$this->load->helper('directory');
		$this->load->helper('yayparser');
		
		// map the views directory
		$viewdirs = directory_map(APPPATH .'views/', true);
		
		$skins = $this->sys->get_all_skins();
		
		if ($skins->num_rows() > 0)
		{
			foreach ($skins->result() as $skin)
			{
				$key = array_search($skin->skin_location, $viewdirs);
				
				if ($key !== false)
				{
					unset($viewdirs[$key]);
				}
			}
		}
		
		// create an array of items that shouldn't be included in the dir listing
		$pop = array('_base_override', 'index.html', 'template.php');
		
		// make sure the items aren't in the listing
		foreach ($pop as $value)
		{
			$key = array_search($value, $viewdirs);
			
			if ($key !== false)
			{
				unset($viewdirs[$key]);
			}
		}
		
		foreach ($viewdirs as $key => $value)
		{
			if (file_exists(APPPATH .'views/'. $value .'/skin.yml'))
			{
				// get the contents of the file
				$contents = file_get_contents(APPPATH.'views/'.$value.'/skin.yml');
				
				// parse the contents of the yaml file
				$array = yayparser($contents);
				
				// create the skin array
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
	
	/**
	 * Uninstall the system
	 *
	 * @access	private
	 * @return	void
	 */
	private function _destroy_data()
	{
		$this->load->dbforge();
		
		$tables = $this->db->list_tables();
		
		$prefix_len = strlen($this->db->dbprefix);
		
		foreach ($tables as $key => $value)
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
		
		foreach ($tables as $v)
		{
			$this->dbforge->drop_table($v);
		}
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
			'install'
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
