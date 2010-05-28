<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Ajax Controller
 *
 * @package		Nova Core
 * @subpackage	Controller
 * @author		Anodyne Productions
 * @version		2.0
 */

class Controller_Nova_Ajax extends Controller_Nova_Base
{
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
		$this->template->layout->content		= FALSE;
	}
	
	public function action_info_show_position_desc()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// set the POST variable
		$position = security::xss_clean($_POST['position']);
		$position = (is_numeric($position)) ? $position : FALSE;
		
		// grab the position details
		$item = Jelly::select('position', $position);
		
		// set the output
		$output = (count($item) > 0) ? $item->desc : FALSE;
		
		echo nl2br($output);
	}
	
	function action_info_show_rank_image()
	{
		// we don't need the template, just the output from the method
		$this->template = NULL;
		
		// set the POST variables
		$rank = security::xss_clean($_POST['rank']);
		$location = security::xss_clean($_POST['location']);
		
		// a little sanity check
		$rank = (is_numeric($rank)) ? $rank : FALSE;
		
		// grab the rank catalogue
		$catalogue = Jelly::select('cataloguerank')->where('location', '=', $location)->load();
		
		// pull the rank record
		$rank = Jelly::select('rank', $rank);
		
		// set the output
		$output = (count($rank) > 0) ? location::image($rank->image.$catalogue->extension, NULL, $location, 'rank') : FALSE;
		
		echo html::image($output);
	}
}

// End of file ajax.php
// Location: modules/nova/classes/controller/nova/ajax.php