<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Nova_Main extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional settings
		$additionalSettings = array(
			'skin_main',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Model_Settings::get_settings($this->settingsArray);
		
		// set the variables
		$this->skin			= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank			= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		$this->dst			= $this->session->get('dst', (bool) $this->options->daylight_savings);
		$this->_headers		= Model_SiteContent::get_section_content('header', $this->request->controller());
		$this->_messages	= Model_SiteContent::get_section_content('message', $this->request->controller());
		$this->_titles		= Model_SiteContent::get_section_content('title', $this->request->controller());
		$this->images		= Utility::get_image_index($this->skin);
		
		// set the values to be passed to the template
		$vars = array(
			'skin' => $this->skin,
			'sec' => 'main'
		);
		
		// set the structure file
		$this->template = View::factory(Location::file('main', $this->skin, 'structure'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory(Location::file('main', $this->skin, 'templates'), $vars);
		$this->template->layout->navmain 			= Menu::build('main', 'main');
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
		$this->template->layout->navsub->menu		= Menu::build('sub', 'main');
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= View::factory(Location::file('footer', $this->skin, 'partials'));
		$this->template->layout->footer->extra 		= Model_SiteContent::get_content('footer');
	}
	
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('main_index', $this->skin, 'pages'));
		
		// get all of the widgets for the page
		$widgets = Model_CatalogueWidget::get_all_items();
		
		if (count($widgets) > 0)
		{
			// loop through the widgets and pass the info to the view
			foreach ($widgets as $w)
			{
				$widgets[$w->zone] = $w;
			}
		}
		
		// pass the widgets to the view
		$this->_data->widgets = $widgets;
		
		// title, header and message content
		$this->_data->title = (array_key_exists($this->request->action(), $this->_titles)) 
			? $this->_titles[$this->request->action()] 
			: ucfirst(___("main"));
			
		$this->_data->header = (array_key_exists($this->request->action(), $this->_headers)) 
			? $this->_headers[$this->request->action()] 
			: null;
			
		$this->_data->message = (array_key_exists($this->request->action(), $this->_messages)) 
			? $this->_messages[$this->request->action()] 
			: null;
	}
	
	public function action_credits()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('main_credits', $this->skin, 'pages'));
		
		// non-editable credits
		$credits_perm = Model_SiteContent::get_content('credits_perm');
		$credits_perm.= "\r\n\r\n".Model_CatalogueSkinSec::get_default('main')->skins->credits;
		$credits_perm.= "\r\n\r\n".Model_CatalogueRank::get_default()->credits;
		
		// credits
		$this->_data->credits_perm = nl2br($credits_perm);
		
		# TODO: need to figure out what we're going to do with these kinds of edit links
		
		// should we show an edit link?
		$this->_data->edit = (Auth::is_logged_in() and Auth::check_access('site/messages', false)) ? true : false;
		$this->_data->edit = false;
		
		// title, header and message content
		$this->_data->title = (array_key_exists($this->request->action(), $this->_titles)) 
			? $this->_titles[$this->request->action()] 
			: ucwords(___("site credits"));
			
		$this->_data->header = (array_key_exists($this->request->action(), $this->_headers)) 
			? $this->_headers[$this->request->action()] 
			: ucwords(___("site credits"));
			
		$this->_data->message = (array_key_exists($this->request->action(), $this->_messages)) 
			? $this->_messages[$this->request->action()] 
			: null;
	}
	
	public function action_components()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('main_components', $this->skin, 'pages'));
		
		// title, header and message content
		$this->_data->title = 'Components';
		$this->_data->header = 'Components';
		$this->_data->message = null;
	}

	public function action_test()
	{
		// checking a POST
		if (HTTP_Request::POST == $this->request->method())
		{
			// do something
		}
	}
}
