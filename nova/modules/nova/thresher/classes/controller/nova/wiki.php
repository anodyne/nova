<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Wiki Controller
 *
 * @package		Thresher
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Wiki extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_wiki';
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_wiki', $this->options->skin_wiki);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the shell
		$this->template = View::factory('_common/layouts/wiki', array('skin' => $this->skin, 'sec' => 'wiki'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options->sim_name.' :: ';
		$this->template->javascript				= false;
		$this->template->layout					= View::factory($this->skin.'/template_wiki', array('skin' => $this->skin, 'sec' => 'wiki'));
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'wiki');
		$this->template->layout->ajax 			= false;
		$this->template->layout->flash_message	= false;
		$this->template->layout->content		= false;
		$this->template->layout->panel_1		= false;
		$this->template->layout->panel_2		= false;
		$this->template->layout->panel_3		= false;
		$this->template->layout->panel_workflow	= false;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_index', $this->skin, 'main', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('main_index_js', $this->skin, 'main', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= 'Main';
		$data->header = Jelly::query('message', 'welcome_head')->limit(1)->select()->value;
		$data->message = Jelly::query('message', 'welcome_msg')->limit(1)->select()->value;
		
		// send the response
		$this->request->response = $this->template;
	}
}