<?php
/**
 * Nova's admin section controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;

class Controller_Admin extends Controller_Base_Admin
{
	/**
	 * Admin Error Codes
	 */
	const OK 				= 0;
	const NOT_ALLOWED 		= 1;

	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	public function action_index()
	{
		$this->_view = 'admin/index';
		
		return;
	}

	public function action_error($error = 0)
	{
		# code...
	}
}
