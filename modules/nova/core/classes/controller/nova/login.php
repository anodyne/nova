<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Login Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

# TODO: change the login redirect to admin/index after the ACP is finished
# TODO: reset password
# TODO: attempted login lockout
# TODO: uncomment login code in install, update and upgrade modules

class Controller_Nova_Login extends Controller_Nova_Base
{
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_login';
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->options->skin_login;
		$this->timezone	= $this->options->timezone;
		$this->dst		= $this->options->daylight_savings;
		
		// set the shell
		$this->template = View::factory('_common/layouts/login', array('skin' => $this->skin, 'sec' => 'login'));
		
		// set the variables in the template
		$this->template->title 					= $this->options->sim_name.' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_login', array('skin' => $this->skin, 'sec' => 'login', 'name' => $this->options->sim_name));
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->content		= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(location::view('login_index', $this->skin, 'login', 'pages'));
		
		// javascript view
		$this->template->javascript = View::factory(location::view('login_index_js', $this->skin, 'login', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(__('log in'));
		$data->header = ucwords(__('log in'));
		
		// inputs
		$data->inputs = array(
			'button' => array(
				'class' => 'button-main'),
			'email' => array(
				'id' => 'email',
				'placeholder' => ucwords(__('email address'))),
			'password' => array(
				'id' => 'password',
				'placeholder' => ucfirst(__('password'))),
			'remember' => array(
				'id' => 'remember'),
		);
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_check()
	{
		if (isset($_POST['submit']))
		{
			// grab the POST data
			$email = trim(security::xss_clean($_POST['email']));
			$password = trim(security::xss_clean($_POST['password']));
			$remember = (isset($_POST['remember'])) ? trim(security::xss_clean($_POST['remember'])) : FALSE;
			
			// do the login
			$login = Auth::login($email, $password, $remember);
			
			if ($login > 0)
			{
				// grab the UID
				$uid = Jelly::select('system', 1)->uid;
				
				// set the email address as session data to check login attempts
				$this->session->set('nova_'.$uid.'_email', $email);
				
				// redirect to the error page
				$this->request->redirect('login/error/'.$login);
			}
			
			// create a new content view
			$this->template->layout->content = View::factory(location::view('login_success', $this->skin, 'login', 'pages'));
			
			// javascript view
			$this->template->javascript = View::factory(location::view('login_index_js', $this->skin, 'login', 'js'));
			
			// set the redirect
			$this->template->_redirect = array('time' => 5, 'url' => url::site('main/index'));
			//$this->template->_redirect = array('time' => 5, 'url' => url::site('admin/index'));
			
			// assign the object a shorter variable to use in the method
			$data = $this->template->layout->content;
			
			// set the content
			$data->header = ucwords(__('logging in'));
			$data->message = __('login.success');
		}
		else
		{
			// if they didn't come from the right place, send them back
			$this->request->redirect('login/index');
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_error($error = 0)
	{
		// create a new content view
		$this->template->layout->content = View::factory(location::view('login_error', $this->skin, 'login', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__('error'));
		$data->header = ucfirst(__('error'));
		
		// set the error message
		switch ($error)
		{
			case 6:
				$data->message = __('error.login_'.$error, array(':minutes' => (Auth::$lockout_time/60), ':extra' => ''));
				break;
			
			default:
				$data->message = __('error.login_'.$error);
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_logout()
	{
		// destroy the session data
		Auth::logout();
		
		// create a new content view
		$this->template->layout->content = View::factory(location::view('login_logout', $this->skin, 'login', 'pages'));
		
		// javascript view
		$this->template->javascript = View::factory(location::view('login_logout_js', $this->skin, 'login', 'js'));
		
		// set the redirect
		$this->template->_redirect = array('time' => 5, 'url' => url::site('main/index'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__('logout'));
		$data->header = ucwords(__('logging out'));
		$data->message = __('login.logout', array(
			':login' => html::anchor('login/index', __('log in again')),
			':main' => html::anchor('main/index', __('main site')))
		);
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function maintenance()
	{
		# code...
	}
	
	public function reset_password()
	{
		/*
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off_disabled');
			
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		if (isset($_POST['submit']))
		{
			$email = $this->input->post('email', TRUE);
			$question = $this->input->post('question', TRUE);
			$answer = $this->input->post('answer', TRUE);
			
			$info = $this->user->get_user_details_by_email($email);
			
			if ($info->num_rows() == 1)
			{
				$row = $info->row();
				
				if ($row->security_question == $question)
				{
					if (sha1($answer) == $row->security_answer)
					{
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
			
			$this->template->write_view('flash_message', '_base/login/pages/flash', $flash);
		}
		
		$questions = $this->sys->get_security_questions();
		
		$data['questions'][0] = lang('login_questions_selectone');
		
		if ($questions->num_rows() > 0)
		{
			foreach ($questions->result() as $row)
			{
				$data['questions'][$row->question_id] = $row->question_value;
			}
		}
		
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
		
		$view_loc = view_location('login_resetpass', $this->skin, 'login');
		
		$this->template->write('title', lang('head_login_resetpass'));
		$this->template->write_view('content', $view_loc, $data);
		
		$this->template->render();
		*/
	}
}