<?php
/*
|---------------------------------------------------------------
| LOGIN CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/login_base.php
| System Version: 1.0
|
| Controller that handles logging in to the system.
|
*/

class Login_base extends Controller {
	
	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;
	
	function Login_base()
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
		
		/* load the models */
		$this->load->model('players_model', 'player');
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_login',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'maintenance',
			'email_subject',
			'system_email'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_login'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->session->userdata('player_id') === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_login');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set the template */
		$this->template->set_template('login');
		$this->template->set_master_template($this->skin .'/template_login.php');
		
		/* write the common elements to the template */
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
	}
	
	function index()
	{
		/*
			0 - no errors
			1 - not logged in
			2 - email doesn't exist
			3 - password is wrong
			4 - more than one account found - contact the GM
			5 - maintenance mode
			6 - login lockout
		*/
		
		/* data used by the view */
		$data['header'] = lang('head_login_index');
		$data['instructions'] = lang('login_instructions');
		
		if ($this->options['maintenance'] == 'on')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('error_login_5');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		/* set the number of attempts to zero to start */
		$attempt_num = 0;
		
		/* grab the email from flashdata if it's there */
		$email_flash = $this->session->flashdata('email');
		
		/* if there's something in the flashdata, let's check how many times they've tried */
		if ($email_flash !== FALSE)
		{
			$attempt_num = $this->sys->count_login_attempts($email_flash);
		}
		
		/* get their last login attempt */
		$attempt = $this->sys->get_last_login_attempt($this->input->ip_address(), 'login_ip');
		
		/* make sure we only show this error if they've reached the allowed login attempts */
		if ($attempt !== FALSE && $attempt_num >= $this->auth->allowed_login_attempts)
		{
			$timeframe = now() - $attempt->login_time;
			$timeframe_mins = $timeframe / 60;
		
			if ($timeframe < $this->auth->lockout_time)
			{
				$flash['status'] = 'error';
				$message = sprintf(
					lang('error_login_6'),
					($this->auth->lockout_time / 60),
					sprintf(
						lang('error_last_login_time'),
						$timeframe_mins,
						($timeframe_mins > 0 && $timeframe_mins < 2) ? lang('time_minute') : lang('time_minutes'),
						ceil((30 - $timeframe_mins)),
						((30 - $timeframe_mins) > 0 && (30 - $timeframe_mins) < 2) ? lang('time_minute') : lang('time_minutes')
					)
				);
				$flash['message'] = text_output($message);
			
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
			}
		}
		
		if ($this->uri->segment(4) > 0)
		{
			$flash['status'] = 'error';
			
			if ($this->uri->segment(4) == 6)
			{
				$flash['message'] = sprintf(
					lang('error_login_6'),
					($this->auth->lockout_time / 60),
					'',
					''
				);
			}
			else
			{
				$flash['message'] = lang_output('error_login_' . $this->uri->segment(4));
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		/* inputs */
		$data['inputs'] = array(
			'email' => array(
				'name' => 'email',
				'id' => 'email',
				'autocomplete' => 'off',
				'tabindex' => 1),
			'password' => array(
				'name' => 'password',
				'id' => 'password',
				'tabindex' => 2),
			'remember_me' => array(
				'name' => 'remember',
				'id' => 'remember',
				'value' => 'yes',
				'tabindex' => 3)
		);
		
		/* the login button */
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
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('login_index', $this->skin, 'login');
		$js_loc = js_location('login_index_js', $this->skin, 'login');
		
		/* write the data to the template */
		$this->template->write('title', lang('head_login_index'));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function check_login()
	{
		/* grab the POST data */
		$email = $this->input->post('email');
		$password = sha1($this->input->post('password'));
		$remember = $this->input->post('remember');
		
		/* do the login */
		$login = $this->auth->login($email, $password, $remember);
		
		if ($login > 0)
		{ /* if there is a value greater than zero, redirect to the error page */
			$this->session->set_flashdata('email', $email);
			
			redirect('login/index/error/'. $login, 'refresh');
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('login_success', $this->options['skin_login'], 'login');
		
		/* set the header and message variables */
		$data['header'] = lang('head_login_success');
		$data['message'] = sprintf(
			lang('login_message'),
			anchor('admin/index', lang('labels_controlpanel'))
		);
		
		/* write the data to the template */
		$this->template->write('title', lang('head_login_success'));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->add_redirect('admin/index');
		
		/* render the template */
		$this->template->render();
	}
	
	function logout()
	{
		/* destroy the session data */
		$this->auth->logout();
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('login_logout', $this->skin, 'login');
		
		/* header and message */
		$data['header'] = lang('head_login_logout');
		$data['message'] = sprintf(
			lang('logout_message'),
			anchor('login/index', lang('actions_login') .' '. lang('labels_again')),
			anchor('main/index', lang('labels_main') .' '. lang('labels_site'))
		);
		
		/* write the data to the template */
		$this->template->write('title', lang('head_login_logout'));
		$this->template->write_view('content', $view_loc, $data);
		$this->template->add_redirect('main/index');
		
		/* render the template */
		$this->template->render();
	}
	
	function reset_password()
	{
		/*
			0 - no errors
			1 - email doesn't exist
			2 - question is wrong
			3 - answer is wrong
			4 - more than 1 account w/ email address
		*/
		
		if ($this->options['system_email'] == 'off')
		{ /* make sure the form can't be submitted if system email is off */
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off_disabled');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			/* set the variables */
			$email = $this->input->post('email', TRUE);
			$question = $this->input->post('question', TRUE);
			$answer = $this->input->post('answer', TRUE);
			
			/* run the methods */
			$info = $this->player->get_user_details_by_email($email);
			
			if ($info->num_rows() == 1)
			{
				/* grab the row info */
				$row = $info->row();
				
				if ($row->security_question == $question)
				{
					if (sha1($answer) == $row->security_answer)
					{
						/* execute the reset and send the email */
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
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		/* run the methods */
		$questions = $this->sys->get_security_questions();
		
		$data['questions'][0] = lang('login_questions_selectone');
		
		if ($questions->num_rows() > 0)
		{
			foreach ($questions->result() as $row)
			{
				$data['questions'][$row->question_id] = $row->question_value;
			}
		}
		
		/* define the header and message */
		$data['header'] = lang('head_login_resetpass');
		$data['message'] = lang('login_reset_message');
		
		/* define the input fields */
		$data['inputs'] = array(
			'answer' => array(
				'name' => 'answer',
				'id' => 'answer'),
			'email' => array(
				'name' => 'email',
				'id' => 'email')
		);
		
		/* the submit button */
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
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('login_resetpass', $this->skin, 'login');
		
		/* write the data to the template */
		$this->template->write('title', lang('head_login_resetpass'));
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function _email($type = '', $data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* define the variables */
		$email = FALSE;
		
		switch ($type)
		{
			case 'reset':
				/* set the content */	
				$content = sprintf(
					lang('email_content_password_reset'),
					$data['password'],
					site_url('login/index')
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_password_reset'),
					'email_from' => ucfirst(lang('time_from')) .': '. $data['name'] .' - '. $data['email'],
					'email_content' => nl2br($content)
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('reset_password', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($data['email'], $data['name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
	
	function _reset($email = '')
	{
		/* set the variables */
		$id = FALSE;
		$name = FALSE;
		
		/* run the methods */
		$info = $this->player->get_user_details_by_email($email);
		
		if ($info->num_rows() > 0)
		{ /* set the ID */
			$row = $info->row();
			
			$id = $row->player_id;
			$name = $row->name;
		}
		
		/* load the helpers */
		$this->load->helper('string');
		
		/* generate a password */
		$new_password = random_string('alnum', 8);
		
		/* build the update array */
		$array = array(
			'password_reset' => 1,
			'password' => sha1($new_password)
		);
		
		/* update the player record */
		$update = $this->player->update_player($id, $array);
		
		/* build the data array for the email */
		$data = array(
			'email' => $email,
			'id' => $id,
			'password' => $new_password,
			'name' => $name
		);
		
		/* send the email */
		$email = ($this->options['system_email'] == 'on') ? $this->_email('reset', $data) : FALSE;
		
		return $update;
	}
}

/* End of file login_base.php */
/* Location: ./application/controllers/base/login_base.php */