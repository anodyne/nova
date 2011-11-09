<?php
/**
 * Admin Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Nova_Admin extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_admin',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Model_Settings::get_settings($this->settingsArray);
		
		// set the variables
		$this->skin			= $this->session->get('skin_admin', $this->options->skin_admin);
		$this->rank			= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		$this->dst			= $this->session->get('dst', (bool) $this->options->daylight_savings);
		$this->_headers		= Model_SiteContent::get_section_content('header', $this->request->controller());
		$this->_messages	= Model_SiteContent::get_section_content('message', $this->request->controller());
		$this->_titles		= Model_SiteContent::get_section_content('title', $this->request->controller());
		$this->images		= Utility::get_image_index($this->skin);
		
		// set the values to be passed to the template
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'admin',
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the structure file
		$this->template = View::factory(Location::file('admin', $this->skin, 'structure'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory(Location::file('admin', $this->skin, 'templates'), $vars);
		$this->template->layout->navmain 			= Menu::classic('main', 'main');
		//$this->template->layout->navmain_dropdown 	= Menu::dropdown('main');
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
		
		$this->template->layout->panel				= View::factory(Location::file('panel', $this->skin, 'partials'));
		$this->template->layout->panel->panel1		= false;
		$this->template->layout->panel->panel2		= false;
		$this->template->layout->panel->panel3		= false;
		$this->template->layout->panel->workflow	= false;
		
		$this->template->layout->navsub 			= View::factory(Location::file('navsub', $this->skin, 'partials'));
		$this->template->layout->navsub->menu		= Menu::classic('sub', 'main');
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= View::factory(Location::file('footer', $this->skin, 'partials'));
		$this->template->layout->footer->extra 		= Model_SiteContent::get_content('footer');
	}
	
	public function index()
	{
		if (isset($_POST['submit']))
		{
			$validate = Validate::factory($_POST)
				->rule('password', 'not_empty')
				->rule('password_confirm', 'matches', array('password'));
				
			if ($validate->check())
			{
				// get the data
				$newpassword = trim(Security::xss_clean($_POST['password']));
				
				$change = Jelly::factory('user', $this->session->get('userid'));
				$change->password = Auth::hash($newpassword);
				$change->password_reset = 0;
				$change->save();
				
				if ($change->saved())
				{
					// show the flash message
					$this->template->layout->flash = View::factory('admin/pages/flash');
					$this->template->layout->flash->status = 'success';
					$this->template->layout->flash->message = __('Password was successfully changed.');
					
					// clear the session variable
					$this->session->delete('password_reset');
				}
				else
				{
					// show the flash message
					$this->template->layout->flash = View::factory('admin/pages/flash');
					$this->template->layout->flash->status = 'error';
					$this->template->layout->flash->message = __('Password was not successfully changed. Please try again.');
				}
			}
			else
			{
				$errors = $validate->errors('validate');
			}
		}
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('admin_index', $this->skin, 'admin', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('admin_index_js', $this->skin, 'admin', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// no reset by default
		$data->reset = false;
		
		if ($this->session->get('password_reset'))
		{
			$data->reset = true;
			
			// set the validation errors
			$data->errors = (isset($errors)) ? $errors : false;
		}
		
		// content
		$this->template->title.= ucfirst(__("admin"));
		//$data->header = Jelly::query('message', 'welcome_head')->limit(1)->select()->value;
		//$data->message = Jelly::query('message', 'welcome_msg')->limit(1)->select()->value;
		
		// send the response
		//$this->response->body($this->template);
	}
	
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('admin_index', $this->skin, 'pages'));
		
		$this->_data->reset = false;
		
		// content
		//$this->_data->title = ucfirst(___("admin"));
		$this->_data->title = "";
		$this->_data->header = "Model_SiteContent::get_content('welcome_head')";
		$this->_data->message = "Model_SiteContent::get_content('welcome_msg')";
	}
	
	public function action_manage($action = 'index')
	{
		$request = Request::factory('admin/manage/'.$action)->execute();
	}
}
