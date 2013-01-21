<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_login extends CI_Controller {
	
	/**
	 * @var	array 	The options array that stores all the settings from the database
	 */
	public $options;
	
	/**
	 * @var	string	The current skin
	 */
	public $skin;
	
	/**
	 * @var	string	The current timezone
	 */
	public $timezone;
	
	/**
	 * @var	bool	The current daylight savings time setting
	 */
	public $dst;
	
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
		$this->load->model('system_model', 'sys');
		
		// check to see if the system is installed
		$installed = $this->sys->check_install_status();
		
		if ( ! $installed)
		{
			redirect('install/index', 'refresh');
		}
		
		// these need to be called in later to prevent errors from being thrown
		$this->load->library('session');
		$this->load->model('settings_model', 'settings');
		$this->load->model('users_model', 'user');
		
		// an array of items to pull from the settings table
		$settings_array = array(
			'skin_login',
			'timezone',
			'daylight_savings',
			'sim_name',
			'maintenance',
			'email_subject',
			'system_email'
		);
		
		// grab the settings
		$this->options = $this->settings->get_settings($settings_array);
		
		// set the initial values
		$this->skin = $this->options['skin_login'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		// load the language file
		$this->lang->load('app');
		
		// set the template file
		Template::$file = $this->skin.'/template_login';
		
		// assign all of the items to the template with false values to prevent errors
		$this->_regions = array(
			'content'		=> false,
			'javascript'	=> false,
			'flash_message'	=> false,
			'_redirect'		=> false,
			'title'			=> $this->options['sim_name'].' :: ',
		);
	}
	
	/**
	 * 0 - no errors
	 * 1 - not logged in
	 * 2 - email doesn't exist
	 * 3 - password is wrong
	 * 4 - more than one account found - contact the GM
	 * 5 - maintenance mode
	 * 6 - login lockout
	 * 7 - pending users not allowed
	 */
	public function index()
	{
		$data['header'] = lang('head_login_index');
		$data['instructions'] = lang('login_instructions');
		
		if ($this->options['maintenance'] == 'on')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('error_login_5');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'login', $flash);
		}
		
		// set the number of attempts to zero to start
		$attempt_num = 0;
		
		// grab the email from flashdata if it's there
		$email_flash = $this->session->flashdata('email');
		
		// if there's something in the flashdata, let's check how many times they've tried
		if ($email_flash !== false)
		{
			$attempt_num = $this->sys->count_login_attempts($email_flash);
		}
		
		// get their last login attempt
		$attempt = $this->sys->get_last_login_attempt($this->input->ip_address(), 'login_ip');
		
		// make sure we only show this error if they've reached the allowed login attempts
		if ($attempt !== false and $attempt_num >= Auth::$allowed_login_attempts)
		{
			$timeframe = now() - $attempt->login_time;
			$timeframe_mins = $timeframe / 60;
		
			if ($timeframe < Auth::$lockout_time)
			{
				$flash['status'] = 'error';
				$message = sprintf(
					lang('error_login_6'),
					(Auth::$lockout_time / 60),
					sprintf(
						lang('error_last_login_time'),
						$timeframe_mins,
						($timeframe_mins > 0 and $timeframe_mins < 2) ? lang('time_minute') : lang('time_minutes'),
						ceil((30 - $timeframe_mins)),
						((30 - $timeframe_mins) > 0 and (30 - $timeframe_mins) < 2) ? lang('time_minute') : lang('time_minutes')
					)
				);
				$flash['message'] = text_output($message);
				
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'login', $flash);
			}
		}
		
		if ($this->uri->segment(4) > 0)
		{
			$flash['status'] = 'error';
			
			switch ($this->uri->segment(4))
			{
				case 6:
					$message = sprintf(
						lang('error_login_6'),
						(Auth::$lockout_time / 60),
						'',
						''
					);
					
					$flash['message'] = text_output($message);
				break;
					
				case 7:
					$message = sprintf(
						lang('error_login_7'),
						lang('global_game_master'),
						lang('global_game_master')
					);
					
					$flash['message'] = text_output($message);
				break;
				
				default:
					$flash['message'] = lang_output('error_login_'.$this->uri->segment(4));
				break;
			}
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'login', $flash);
		}
		
		$data['inputs'] = array(
			'email' => array(
				'name' => 'email',
				'id' => 'email',
				'autocomplete' => 'off',
				'tabindex' => 1,
				'placeholder' => ucfirst(lang('labels_email_address')),
				'type' => 'email'),
			'password' => array(
				'name' => 'password',
				'id' => 'password',
				'tabindex' => 2,
				'placeholder' => ucfirst(lang('labels_password'))),
			'remember_me' => array(
				'name' => 'remember',
				'id' => 'remember',
				'value' => 'yes',
				'tabindex' => 3)
		);
		
		$data['button_login'] = array(
			'type' => 'submit',
			'class' => 'button-main',
			'name' => 'login',
			'value' => 'login',
			'tabindex' => 4,
			'content' => ucwords(lang('actions_login'))
		);
		
		$data['label'] = array(
			'email' => ucwords(lang('labels_email_address')),
			'password' => ucfirst(lang('labels_password')),
			'remember' => ucfirst(lang('actions_remember') .' '. lang('labels_me')),
		);
		
		$this->_regions['content'] = Location::view('login_index', $this->skin, 'login', $data);
		$this->_regions['javascript'] = Location::js('login_index_js', $this->skin, 'login');
		$this->_regions['title'].= ucfirst(lang('head_login_index'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function check_login()
	{
		// grab the POST data
		$email = $this->input->post('email');
		$password = Auth::hash($this->input->post('password'));
		$remember = $this->input->post('remember');
		
		// do the login
		$login = Auth::login($email, $password, $remember);
		
		if ($login > 0)
		{
			$this->session->set_flashdata('email', $email);
			
			redirect('login/index/error/'.$login, 'refresh');
		}
		
		$data['header'] = lang('head_login_success');
		$data['message'] = sprintf(
			lang('login_message'),
			anchor('admin/index', lang('labels_controlpanel'))
		);
		
		$this->_regions['content'] = Location::view('login_success', $this->skin, 'login', $data);
		$this->_regions['title'].= ucfirst(lang('head_login_success'));
		$this->_regions['_redirect'] = Template::add_redirect('admin/index');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function logout()
	{
		// destroy the session data
		Auth::logout();
		
		$data['header'] = lang('head_login_logout');
		$data['message'] = sprintf(
			lang('logout_message'),
			anchor('login/index', lang('actions_login') .' '. lang('labels_again')),
			anchor('main/index', lang('labels_main') .' '. lang('labels_site'))
		);
		
		$this->_regions['content'] = Location::view('login_logout', $this->skin, 'login', $data);
		$this->_regions['title'].= ucfirst(lang('head_login_logout'));
		$this->_regions['_redirect'] = Template::add_redirect('main/index');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * 0 - no errors
	 * 1 - email doesn't exist
	 * 2 - question is wrong
	 * 3 - answer is wrong
	 * 4 - more than 1 account w/ email address
	 */
	public function reset_password()
	{
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off_disabled');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'login', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			$email = $this->input->post('email', true);
			$question = $this->input->post('question', true);
			$answer = $this->input->post('answer', true);
			
			if ($question == "0")
			{
				$flash['status'] = 'error';
				$flash['message'] = lang_output('flash_reset_no_question');
			}
			else
			{
				$info = $this->user->get_user_details_by_email($email);
				
				if ($info->num_rows() == 1)
				{
					// grab the row info
					$row = $info->row();
					
					if ($row->security_question == $question)
					{
						if (sha1($answer) == $row->security_answer)
						{
							// execute the reset and send the email
							$reset = $this->_reset($email);
							
							if ($reset == 0)
							{
								$flash['status'] = 'error';
								$flash['message'] = lang_output('flash_reset_fail');
							}
							else
							{
								$flash['status'] = 'success';
								$flash['message'] = lang_output('flash_reset_success');
							}
						}
						else
						{
							$flash['status'] = 'error';
							$flash['message'] = lang_output('flash_reset_error_3');
						}
					}
					else
					{
						$flash['status'] = 'error';
						$flash['message'] = lang_output('flash_reset_error_2');
					}
				}
				elseif ($info->num_rows() > 1)
				{
					$flash['status'] = 'error';
					$flash['message'] = lang_output('flash_reset_error_4');
				}
				elseif ($info->num_rows() < 1)
				{
					$flash['status'] = 'error';
					$flash['message'] = lang_output('flash_reset_error_1');
				}
			}
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'login', $flash);
		}
		
		// run the methods
		$questions = $this->sys->get_security_questions();
		
		$data['questions'][0] = lang('login_questions_selectone');
		
		if ($questions->num_rows() > 0)
		{
			foreach ($questions->result() as $row)
			{
				$data['questions'][$row->question_id] = $row->question_value;
			}
		}
		
		// define the header and message
		$data['header'] = lang('head_login_resetpass');
		$data['message'] = lang('login_reset_message');
		
		$data['inputs'] = array(
			'answer' => array(
				'name' => 'answer',
				'id' => 'answer'),
			'email' => array(
				'name' => 'email',
				'id' => 'email')
		);
		
		$data['button_submit'] = array(
			'type' => 'submit',
			'class' => 'button-main',
			'name' => 'submit',
			'value' => 'submit',
			'content' => ucwords(lang('actions_submit'))
		);
		
		$data['label'] = array(
			'email' => ucwords(lang('labels_email_address')),
			'question' => ucwords(lang('labels_security') .' '. lang('labels_question')),
			'answer' => ucfirst(lang('labels_answer'))
		);
		
		if ($this->options['system_email'] == 'off')
		{
			$data['button_submit']['disabled'] = 'yes';
		}
		
		$this->_regions['content'] = Location::view('login_resetpass', $this->skin, 'login', $data);
		$this->_regions['title'].= ucfirst(lang('head_login_resetpass'));
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _email($type, $data)
	{
		// load the libraries
		$this->load->library('email');
		$this->load->library('parser');
		
		$email = false;
		
		switch ($type)
		{
			case 'reset':
				$content = sprintf(
					lang('email_content_password_reset'),
					$data['password'],
					site_url('login/index')
				);
				
				$email_data = array(
					'email_subject' => lang('email_subject_password_reset'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br($content)
				);
				
				// where should the email be coming from
				$em_loc = Location::email('reset_password', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $data['name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
		}
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
	
	protected function _reset($email)
	{
		$id = false;
		$name = false;
		
		$info = $this->user->get_user_details_by_email($email);
		
		if ($info->num_rows() > 0)
		{
			$row = $info->row();
			
			$id = $row->userid;
			$name = $row->name;
		}
		
		// generate a password
		$new_password = random_string('alnum', 8);
		
		$array = array(
			'password_reset' => 1,
			'password' => Auth::hash($new_password)
		);
		
		// update the user record
		$update = $this->user->update_user($id, $array);
		
		$data = array(
			'email' => $email,
			'id' => $id,
			'password' => $new_password,
			'name' => $name
		);
		
		// send the email
		$email = ($this->options['system_email'] == 'on') ? $this->_email('reset', $data) : false;
		
		return $update;
	}
}
