<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Login Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Login extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_login',
			'default_email_name',
			'default_email_address'
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->options->skin_login;
		$this->timezone	= $this->options->timezone;
		$this->dst		= $this->options->daylight_savings;
		
		// set the values to be passed to the views
		$vars = array(
			'template' => array(
				'skin' => $this->skin,
				'sec' => 'login'),
			'layout' => array(
				'skin'	=> $this->skin,
				'sec'	=> 'login',
				'name'	=> $this->options->sim_name),
		);
		
		// set the shell
		$this->template = View::factory('_common/layouts/login', $vars['template']);
		
		// set the variables in the template
		$this->template->title 				= $this->options->sim_name.' :: ';
		$this->template->javascript			= FALSE;
		$this->template->layout				= View::factory($this->skin.'/template_login', $vars['layout']);
		$this->template->layout->flash		= FALSE;
		$this->template->layout->content	= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('login_index', $this->skin, 'login', 'pages'));
		
		// javascript view
		$this->template->javascript = View::factory(Location::view('login_index_js', $this->skin, 'login', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// grab the UID
		$uid = Jelly::query('system', 1)->select()->uid;
		
		// is the session data for a lockout available?
		$lockout = $this->session->get('nova_'.$uid.'_lockout_time');
		
		// there is lockout data
		if ($lockout !== NULL)
		{
			// find out how long it's been
			$timeframe = date::now() - $lockout;
			
			// if it hasn't been long enough, show an error
			if ($timeframe < Auth::$lockout_time)
			{
				// find out how much time is left
				$timeleft = Auth::$lockout_time - $timeframe;
				
				$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->template->layout->flash->status = 'error';
				$this->template->layout->flash->message = __('error.login_6', array(':minutes' => round(ceil($timeleft/60), 0), ':extra' => ''));
			}
		}
		
		// content
		$this->template->title.= ucwords(__("log in"));
		$data->header = ucwords(__("log in"));
		$data->text = __("login.index_text");
		
		// inputs
		$data->inputs = array(
			'button' => array(
				'class' => 'btn-main'),
			'email' => array(
				'id' => 'email',
				'placeholder' => ucwords(__("email address"))),
			'password' => array(
				'id' => 'password',
				'placeholder' => ucfirst(__("password"))),
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
			$email = trim(Security::xss_clean($_POST['email']));
			$password = trim(Security::xss_clean($_POST['password']));
			$remember = (isset($_POST['remember'])) ? trim(Security::xss_clean($_POST['remember'])) : FALSE;
			
			// do the login
			$login = Auth::login($email, $password, $remember);
			
			if ($login > 0)
			{
				// redirect to the error page
				$this->request->redirect('login/error/'.$login);
			}
			
			// create a new content view
			$this->template->layout->content = View::factory(Location::view('login_success', $this->skin, 'login', 'pages'));
			
			// javascript view
			$this->template->javascript = View::factory(Location::view('login_success_js', $this->skin, 'login', 'js'));
			
			# TODO: change this to redirect to the admin index when it's been built
			// set the redirect
			$this->template->redirect = array('time' => 5, 'url' => url::site('main/index'));
			//$this->template->redirect = array('time' => 5, 'url' => url::site('admin/index'));
			
			// assign the object a shorter variable to use in the method
			$data = $this->template->layout->content;
			
			// set the content
			$data->header = ucwords(__("logging in"));
			$data->message = __("login.success", array(':acp' => html::anchor('main/index', ucwords(__("control panel")))));
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
		$this->template->layout->content = View::factory(Location::view('login_error', $this->skin, 'login', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__("error"));
		$data->header = ucfirst(__("error"));
		
		// set the error message
		switch ($error)
		{
			case 5:
				$this->request->redirect('login/maintenance');
			break;
			
			case 6:
				$data->message = __("error.login_".$error, array(':minutes' => (Auth::$lockout_time/60), ':extra' => ''));
			break;
			
			default:
				$data->message = __("error.login_".$error);
			break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_logout()
	{
		// destroy the session data
		Auth::logout();
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('login_logout', $this->skin, 'login', 'pages'));
		
		// javascript view
		$this->template->javascript = View::factory(Location::view('login_logout_js', $this->skin, 'login', 'js'));
		
		// set the redirect
		$this->template->_redirect = array('time' => 5, 'url' => url::site('main/index'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__("logout"));
		$data->header = ucwords(__("logging out"));
		$data->message = __("login.logout", array(
			':login' => html::anchor('login/index', __("log in again")),
			':main' => html::anchor('main/index', __("main site")))
		);
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_maintenance()
	{
		if (file_exists(APPPATH.'views/maintenance'.EXT))
		{
			// use the non-templated maintenance page
			$this->template = View::factory('maintenance');
			
			// send the response
			$this->request->response = $this->template;
		}
		else
		{
			$this->request->redirect('login/error/5');
		}
	}
	
	public function action_reset()
	{
		if (isset($_POST['submit']))
		{
			// set the variables
			$email		= trim(Security::xss_clean($_POST['email']));
			$question	= trim(Security::xss_clean($_POST['question']));
			$answer		= trim(Security::xss_clean($_POST['answer']));
			
			// get the user details
			$info = Jelly::query('user')->where('email', '=', $email)->select();
			
			if (count($info) == 1)
			{
				// grab the user object
				$user = $info->current();
				
				// make sure the security question matches
				if ($user->security_question->id == $question)
				{
					// make sure the security answer matches
					if (sha1($answer) == $user->security_answer)
					{
						// generate a new password
						$newpass = Text::random('alnum');
						
						// update the user's record
						$user->password = Auth::hash($newpass);
						$user->password_reset = 1;
						$user->save();
						
						// make sure the record was saved
						if ($user->saved())
						{
							// set the data for the email
							$emaildata = new stdClass;
							$emaildata->email = $email;
							$emaildata->password = $newpass;
							$emaildata->name = $user->name;
							
							// send the email
							$email = $this->_email('reset', $emaildata);
							
							// set the flash message
							$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
							$this->template->layout->flash->status = 'success';
							$this->template->layout->flash->message = __("error.login.reset_success");
						}
						else
						{
							$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
							$this->template->layout->flash->status = 'error';
							$this->template->layout->flash->message = __("error.login.reset_failure");
						}
					}
					else
					{
						$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
						$this->template->layout->flash->status = 'error';
						$this->template->layout->flash->message = __("error.login.wrong_security_answer");
					}
				}
				else
				{
					$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
					$this->template->layout->flash->status = 'error';
					$this->template->layout->flash->message = __("error.login.wrong_security_question");
				}
			}
			elseif (count($info) > 1)
			{
				$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->template->layout->flash->status = 'error';
				$this->template->layout->flash->message = __("error.login_4");
			}
			elseif (count($info) < 1)
			{
				$this->template->layout->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->template->layout->flash->status = 'error';
				$this->template->layout->flash->message = __("error.login_2");
			}
		}
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('login_reset', $this->skin, 'login', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// set the title
		$this->template->title.= ucwords(__("reset password"));
		
		// set the header
		$data->header = ucwords(__("reset password"));
		
		// set the page as enabled
		$data->enabled = TRUE;
		
		if ($this->options->system_email == 'off')
		{
			// set the message
			$data->message = __("error.email_disabled_failure");
			$data->message_class = 'fontMedium warning';
			
			// disabled
			$data->enabled = FALSE;
		}
		else
		{
			// set the message
			$data->message = __("login.reset_message");
			$data->message_class = FALSE;
			
			// get the security questions
			$questions = Jelly::query('securityquestion')->select();
			
			// set the initial question
			$data->questions = array(
				0 => ucfirst(__("Please select your security question"))
			);
			
			// pull in the questions from the database
			if (count($questions) > 0)
			{
				foreach ($questions as $q)
				{
					$data->questions[$q->id] = $q->value;
				}
			}
			
			// set the button options
			$data->button = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'submit'),
			);
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	protected function _email($type, $data)
	{
		// set the email variable that'll be returned
		$email = FALSE;
		
		// make sure system email is turned on
		if ($this->options->system_email == 'on')
		{
			// set up the mailer
			$mailer = Email::setup_mailer();
			
			// create a new message
			$message = Email::setup_message();
			
			switch ($type)
			{
				case 'reset':
					// data for the view files
					$view = new stdClass;
					$view->subject = __("email.subject.reset_password");
					$view->content = __("email.content.reset_password", array(':password' => $data->password, ':site' => url::site('login/index')));
					
					// set the html version
					$html = View::factory(Location::view('login_reset_em_html', $this->skin, 'login', 'email'), $view);
					
					// set the text version
					$text = View::factory(Location::view('login_reset_em_text', $this->skin, 'login', 'email'), $view);
					
					// set the message data
					$message->setSubject(__("email.subject.reset_password"));
					$message->setFrom(array($this->options->default_email_address => $this->options->default_email_name));
					$message->setTo($data->email);
					$message->setBody($html->render(), 'text/html');
					$message->addPart($text->render(), 'text/plain');
				break;
			}
			
			// send the message
			$email = $mailer->send($message);
		}
		
		return $email;
	}
}