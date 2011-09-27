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
		$uid = DB::query(Database::SELECT, "SELECT * FROM `nova2_system_info` WHERE sys_id = 1")
			->as_object()
			->execute()
			->current()
			->sys_uid;
			
		$sys = Model_System::find('first');
		
		echo Debug::vars($uid, $sys->uid);
		
		if (count($sys) > 0)
		{
			$sys->uid = $uid;
			$sys->save();
		}
		
		echo Debug::vars($sys->uid);
		
		exit;
	}
	
	public function action_test()
	{
		//$dir = Utility::directory_map(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/', true);
		//$dir = Utility::directory_list(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/');
	}
	
	public function action_dir()
	{
		$dir = new DirectoryIterator(APPPATH.'assets/common/'.Kohana::$config->load('nova.genre').'/ranks/');
		
		foreach ($dir as $fileinfo) {
			
			if ( ! $fileinfo->isDot() and $fileinfo->getType() == 'dir')
			{
				echo $fileinfo->getFilename().'<br>';
			}
		}
	}
}
