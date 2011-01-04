<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Error Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */

class Controller_Nova_Error extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// set the shell
		$this->template = View::factory('_common/layouts/error');
		
		// set the variables in the template
		$this->template->title 		= 'Error';
		$this->template->content	= false;
	}
	
	public function action_404()
	{
		$this->template->content = View::factory('_common/error_404');
		
		// send the response
		$this->request->response = $this->template;
	}
}
