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
		
		// pull the settings and put them into the options variable
		$this->options = $this->mSettings->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin	= $this->options['skin_main'];
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', array('skin' => $this->skin, 'sec' => 'login'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options['sim_name'].' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_login', array('skin' => $this->skin, 'sec' => 'login'));
		$this->template->layout->nav_main 		= FALSE
		$this->template->layout->nav_sub 		= FALSE;
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
	}
	
	public function action_index()
	{
		// send the response
		$this->request->response = $this->template;
	}
}