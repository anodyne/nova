<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Login Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Nova_Login extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional settings
		$additionalSettings = array(
			'skin_login',
			'default_email_name',
			'default_email_address',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Model_Settings::get_settings($this->settingsArray);
		
		// set the variables
		$this->skin			= $this->session->get('skin_login', $this->options->skin_login);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		$this->dst			= $this->session->get('dst', (bool) $this->options->daylight_savings);
		
		// set the values to be passed to the template
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'login',
			'name'			=> $this->options->sim_name,
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the structure file
		$this->template = View::factory(Location::file('login', $this->skin, 'structure'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory(Location::file('login', $this->skin, 'templates'), $vars);
		$this->template->layout->navmain 			= Menu::classic('main', 'main');
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('login/index', $this->skin, 'pages'));
		
		// grab the UID
		$uid = Model_System::get_uid();
		
		// is the session data for a lockout available?
		$lockout = $this->session->get('nova_'.$uid.'_lockout_time');
		
		// there is lockout data
		if ($lockout !== null)
		{
			// find out how long it's been
			$timeframe = date::now() - $lockout;
			
			// if it hasn't been long enough, show an error
			if ($timeframe < Auth::$lockout_time)
			{
				// find out how much time is left
				$timeleft = Auth::$lockout_time - $timeframe;
				
				$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->_data->flash->status = 'error';
				$this->_data->flash->message = __("You've attempted to log in more times than the system allows. You must wait :minutes minutes before attempting to log in again! :extra", array(':minutes' => round(ceil($timeleft/60), 0), ':extra' => ''));
			}
		}
		
		// inputs
		$this->_data->inputs = array(
			'button' => array(
				'class' => 'login-control-submit hidden'),
			'email' => array(
				'id' => 'email',
				'type' => 'email',
				'placeholder' => ucwords(__("email address"))),
			'password' => array(
				'id' => 'password',
				'placeholder' => ucfirst(__("password"))),
			'remember' => array(
				'id' => 'remember'),
		);
		
		// title, header and message content
		$this->_data->title = 'Log In';
		$this->_data->header = 'Log In';
		$this->_data->message = null;
	}
	
	public function action_check()
	{
		if (HTTP_Request::POST == $this->request->method())
		{
			// grab the POST data
			$email = trim(Security::xss_clean($_POST['email']));
			$password = trim(Security::xss_clean($_POST['password']));
			$remember = (isset($_POST['remember'])) ? trim(Security::xss_clean($_POST['remember'])) : false;
			
			// do the login
			$login = Auth::login($email, $password, $remember);
			
			if ($login > 0)
			{
				// redirect to the error page
				$this->request->redirect('login/error/'.$login);
			}
			
			// create a new content view
			$this->_data = View::factory(Location::view('login/success', $this->skin, 'pages'));
			
			// set the redirect
			$this->_data->redirect = array('time' => 5, 'url' => Url::site('admin/index'));
			
			// set the content
			$this->_data->title = ucwords(__("logging in"));
			$this->_data->header = ucwords(__("logging in"));
		}
		else
		{
			// if they didn't come from the right place, send them back
			$this->request->redirect('login/index');
		}
	}
	
	public function action_error($error = 0)
	{
		// create a new content view
		$this->_data = View::factory(Location::view('login/error', $this->skin, 'pages'));
		
		// content
		$this->_data->title = ucfirst(__("error"));
		$this->_data->header = ucfirst(__("error"));
		
		// set the error message
		switch ($error)
		{
			case 1:
				$this->_data->message = __("You must log in to continue!");
			break;
			
			case 2:
				$this->_data->message = __(":email not found, please try again.", array(':email' => ucfirst(__("email address"))));
			break;
			
			case 3:
				$this->_data->message = __("Your :password doesn't match our records, please try again.", array(':password' => __("password")));
			break;
			
			case 4:
				$this->_data->message = __("Multiple accounts found with your :email. Please contact the :gm to resolve this issue.", 
					array(':email' => __("email address"), ':gm' => __("game master")));
			break;
			
			case 5:
				$this->request->redirect('login/maintenance');
			break;
			
			case 6:
				$this->_data->message = __("You've attempted to log in more times than the system allows. You must wait :minutes minutes before attempting to log in again! :extra", array(':minutes' => (Auth::$lockout_time/60), ':extra' => ''));
			break;
			
			case 7:
				$this->_data->message = __("Your account is currently under review. You will not be allowed to log in until your application has been accepted. Please contact the :gm if you have questions.",
					array(':gm' => __("game master")));
			break;
		}
	}
	
	public function action_logout()
	{
		// destroy the session data
		Auth::logout();
		
		// create a new content view
		$this->_data = View::factory(Location::view('login/logout', $this->skin, 'pages'));
		
		// set the redirect
		$this->_data->redirect = array('time' => 5, 'url' => Url::site('main/index'));
		
		// content
		$this->_data->title = ucfirst(__("logout"));
		$this->_data->header = ucwords(__("logging out"));
	}
	
	public function action_maintenance()
	{
		if (file_exists(APPPATH.'views/maintenance'.EXT))
		{
			// use the non-templated maintenance page
			$this->template = View::factory('maintenance');
			
			// send the response
			$this->response->body($this->template);
		}
		else
		{
			$this->request->redirect('login/error/5');
		}
	}
	
	# TODO: needs to be updated
	
	public function action_reset()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('login/reset', $this->skin, 'pages'));
		
		if (HTTP_Request::POST == $this->request->method())
		{
			// set the variables
			$email		= trim(Security::xss_clean($_POST['email']));
			$question	= trim(Security::xss_clean($_POST['question']));
			$answer		= trim(Security::xss_clean($_POST['answer']));
			
			// get the user details
			$user = Model_User::get('email', $email);
			
			if (count($user) == 1)
			{
				// make sure the security question matches
				if ($user->security_question == $question)
				{
					// make sure the security answer matches
					if (sha1($answer) == $user->security_answer)
					{
						// generate a new password
						$newpass = Text::random('alnum');
						
						// update the user's record
						$user->password = Auth::hash($newpass);
						$user->password_reset = (int) true;
						$saved = $user->save();
						
						// make sure the record was saved
						if ($saved !== false)
						{
							// set the data for the email
							$emaildata = new stdClass;
							$emaildata->email = $email;
							$emaildata->password = $newpass;
							$emaildata->name = $user->name;
							$emaildata->user = $user->id;
							
							// send the email
							$email = $this->_email('reset', $emaildata);
							
							// set the flash message
							$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
							$this->_data->flash->status = 'success';
							$this->_data->flash->message = __("Your password was successfully reset. Make sure you change your password to something you can remember when you log in.");
						}
						else
						{
							$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
							$this->_data->flash->status = 'error';
							$this->_data->flash->message = __("Your password wasn't reset. Please try again. If the problem persists, please contact the system administrator.");
						}
					}
					else
					{
						$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
						$this->_data->flash->status = 'error';
						$this->_data->flash->message = __("The security answer you provided doesn't match our records. Please try again. Remember that you have to type your security answer exactly as you did when you set it.");
					}
				}
				else
				{
					$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
					$this->_data->flash->status = 'error';
					$this->_data->flash->message = __("The security question you selected doesn't match our records. Please try again.");
				}
			}
			elseif (count($info) > 1)
			{
				$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->_data->flash->status = 'error';
				$this->_data->flash->message = __("Multiple accounts found with your :email. Please contact the :gm to resolve this issue.", 
					array(':email' => __("email address"), ':gm' => __("game master")));
			}
			elseif (count($info) < 1)
			{
				$this->_data->flash = View::factory(Location::view('flash', $this->skin, 'login', 'pages'));
				$this->_data->flash->status = 'error';
				$this->_data->flash->message = __(":email not found, please try again.", array(':email' => ucfirst(__("email address"))));
			}
		}
		
		// set the title
		$this->_data->title = ucwords(__("reset password"));
		$this->_data->header = ucwords(__("reset password"));
		
		// set the page as enabled
		$this->_data->enabled = true;
		
		if ($this->options->system_email == 'off')
		{
			// set the message
			$this->_data->message = __("System email has been disabled by the system administrator and this form cannot be submitted.");
			$this->_data->message_class = 'fontMedium warning';
			
			// disabled
			$this->_data->enabled = false;
		}
		else
		{
			// set the message
			$this->_data->message = __("Don't worry, forgetting your password happens to the best of us. Using the fields below, you can request a new password. Simply enter your email address and the security question you set up for your account then your answer to the question. Once I've got that information, I'll be able to reset your password and email you your new one. The first time you log in to the system, you'll be prompted to change your password to something you can remember.");
			$this->_data->message_class = false;
			
			// get the security questions
			$questions = Model_SecurityQuestion::get_questions();
			
			// set the initial question
			$this->_data->questions = array(
				0 => ucfirst(__("Please select your security question"))
			);
			
			// pull in the questions from the database
			if (count($questions) > 0)
			{
				foreach ($questions as $q)
				{
					$this->_data->questions[$q->id] = $q->value;
				}
			}
			
			// set the button options
			$this->_data->button = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'submit'),
			);
		}
	}
	
	protected function _email($type, $data)
	{
		$mailer = false;
		
		// make sure system email is turned on
		if ($this->options->system_email == 'on')
		{
			switch ($type)
			{
				case 'reset':
					// find out how to send the email
					$format = Jelly::query('user', $data->user)->select()->email_format;
					
					// data for the view files
					$view = new stdClass;
					$view->subject = ___(":password Reset", array(':password' => ucfirst(___("password"))));
					$view->content = ___("Your :password has been reset and is listed below. Next time you log in, you will be prompted to change your :password to something else.\r\n\r\nNew password: :newpass\r\n\r\n<a href=':site'>Click here</a> to login to site now.", array(':password' => ___("password"), ':newpass' => $data->password, ':site' => url::site('login/index')));
					
					if ($format == 'html')
					{
						// set the html version
						$html = View::factory(Location::view('login_reset_em_html', $this->skin, 'email'), $view);
					}
					
					// set the text version
					$text = View::factory(Location::view('login_reset_em_text', $this->skin, 'email'), $view);
					
					// set the primary delivery method and type
					$primary_format = ($format == 'html') ? $html->render() : $text->render();
					$primary_type = ($format == 'html') ? 'text/html' : 'text/plain';
					
					// set the message data
					$email = Email::factory()
						->subject($this->options->email_subject.' '.$view->subject)
						->from(array($this->options->default_email_address => $this->options->default_email_name))
						->to($data->email)
						->message($primary_format, $primary_type);
					
					if ($format == 'html')
					{
						$email->raw_message()->addPart($text->render(), 'text/plain');
					}
				break;
			}
			
			// send the message
			$mailer = $email->send($message);
		}
		
		return $mailer;
	}
}
