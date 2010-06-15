<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Login Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

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
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= 'Login';
		$data->header = 'Login';
		
		// inputs
		$data->inputs = array(
			'button' => array(
				'class' => 'button-main'),
			'email' => array(
				'id' => 'email',
				'placeholder' => ucwords(__('label.email_address'))),
			'password' => array(
				'id' => 'password',
				'placeholder' => ucfirst(__('label.password'))),
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
			$email = trim(security:xss_clean($_POST['email']));
			$password = trim(security:xss_clean($_POST['password']));
			$remember = trim(security:xss_clean($_POST['rememberme']));
			
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
			
			// success!
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
		# code...
	}
}