<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		3.0
 */

class Controller_Nova_Main extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_main',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Model_Settings::get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the values to be passed to the views
		$vars = array(
			'skin' => $this->skin,
			'sec' => 'main'
		);
		
		// set the shell
		$this->template = View::factory(Location::file('main', $this->skin, 'structure'), $vars);
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory(Location::file('main', $this->skin, 'templates'), $vars);
		$this->template->layout->navmain 			= Menu::build('main', 'main');
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		
		$this->template->layout->panel				= View::factory(Location::file('panel', $this->skin, 'partials'));
		$this->template->layout->panel->panel1		= false;
		$this->template->layout->panel->panel2		= false;
		$this->template->layout->panel->panel3		= false;
		$this->template->layout->panel->workflow	= false;
		
		$this->template->layout->navsub 			= View::factory(Location::file('navsub', $this->skin, 'partials'));
		$this->template->layout->navsub->menu		= Menu::build('sub', 'main');
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= View::factory(Location::file('footer', $this->skin, 'partials'));
		$this->template->layout->footer->extra 		= Model_Messages::get_message('footer');
	}
	
	public function after()
	{
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_index', $this->skin, 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		# TODO: when widgets are worked on, this will need to uncommented
		// get all of the widgets for the page
		//$widgets = Jelly::query('cataloguewidget')->where('page', '=', 'main/index')->select();
		$widgets = array();
		
		// set the widgets array
		$data->widgets = array();
		
		if (count($widgets) > 0)
		{
			// loop through the widgets and pass the info to the view
			foreach ($widgets as $w)
			{
				$data->widgets[$w->zone] = $w;
			}
		}
		
		// content
		$this->template->title.= ucfirst(___("main"));
		$data->header = Model_Messages::get_message('welcome_head');
		$data->message = Model_Messages::get_message('welcome_msg');
	}
	
	public function action_credits()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_credits', $this->skin, 'pages'));
		
		// assign the object a shorter variable to use in the method
		$this->data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(___("site credits"));
		$this->data->header = ucwords(___("site credits"));
		
		// non-editable credits
		$credits_perm = Model_Messages::get_message('credits_perm');
		$credits_perm.= "\r\n\r\n".Model_CatalogueSkinSec::get_default('main')->skins->credits;
		$credits_perm.= "\r\n\r\n".Model_CatalogueRank::get_default()->credits;
		
		// credits
		$this->data->credits_perm = nl2br($credits_perm);
		$this->data->credits = Model_Messages::get_message('credits');
		
		// should we show an edit link?
		$this->data->edit = (Auth::is_logged_in() and Auth::check_access('site/messages', false)) ? true : false;
		
		# TODO: remove this after the site messages management stuff is done
		$this->data->edit = false;
	}

	public function action_test()
	{
		/*// checking a POST
		if (HTTP_Request::POST == $this->request->method())
		{
			// do something
		}
		*/
		Event::trigger('post_execute');
	}
}
