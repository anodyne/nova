<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Manage Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Nova_Admin_Manage extends Controller_Nova_Base {
	
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
		
		// set the values to be passed to the views
		$vars = array(
			'skin' 			=> $this->skin,
			'sec' 			=> 'admin',
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the shell
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
	
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('admin_index', $this->skin, 'pages'));
		
		$this->_data->reset = false;
		
		// content
		$this->_data->title = 'Manage';
		$this->_data->header = 'Manage';
		$this->_data->message = 'Manage';
	}
}
