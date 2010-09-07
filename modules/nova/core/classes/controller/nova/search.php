<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Search Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Search extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_main';
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', array('skin' => $this->skin, 'sec' => 'main'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options->sim_name.' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_main', array('skin' => $this->skin, 'sec' => 'main'));
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'main');
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->content		= FALSE;
		$this->template->layout->panel_1		= FALSE;
		$this->template->layout->panel_2		= FALSE;
		$this->template->layout->panel_3		= FALSE;
		$this->template->layout->panel_workflow	= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('search_index', $this->skin, 'main', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('search_index_js', $this->skin, 'main', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucfirst(__('search'));
		
		// send the response
		$this->request->response = $this->template;
	}
}