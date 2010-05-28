<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Form Controller
 *
 * @package		Nova Core
 * @subpackage	Controller
 * @author		Anodyne Productions
 * @version		2.0
 */

class Controller_Nova_Form extends Controller_Nova_Base
{
	# TODO: how do we set the skin?
	# TODO: how do we set the layout?
	# TODO: how do we set the menus?
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_main';
		
		// pull the settings and put them into the options variable
		$this->options = $this->mSettings->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options['skin_main']);
		$this->rank		= $this->session->get('display_rank', $this->options['display_rank']);
		$this->timezone	= $this->session->get('timezone', $this->options['timezone']);
		$this->dst		= $this->session->get('dst', $this->options['daylight_savings']);
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', array('skin' => $this->skin, 'sec' => 'main'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options['sim_name'].' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_main', array('skin' => $this->skin, 'sec' => 'main'));
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'main');
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
	}
	
	public function action_display()
	{
		# code...
	}
	
	public function action_edit()
	{
		# code...
	}
	
	public function action_manage()
	{
		# code...
	}
	
	public function action_managesections()
	{
		# code...
	}
	
	public function action_managetabs()
	{
		# code...
	}
	
	public function action_view()
	{
		# code...
	}
}

// End of file form.php
// Location: modules/nova/classes/controller/nova/form.php