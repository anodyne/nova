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
		//$output = Model_Character::find(356);
		$output = Model_User::find(2);
		
		//echo Debug::vars($output->name(), $output->name(false), $output->name(true, true), $output->user->get_status());
		echo Debug::vars($output->characters);
		exit;
	}
}
