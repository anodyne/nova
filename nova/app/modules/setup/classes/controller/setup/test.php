<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Upgrade Controller
 *
 * @package		Upgrade
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Setup_Test extends Controller {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$x = Model_Spec::find('first');
		
		echo Debug::vars($x->desc);
		exit;
	}
}
