<?php
/**
 * The Nova API allows third party sites and services to pull information out of
 * Nova to display in other ways.
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		2.0
 */

abstract class Controller_Nova_Api extends Controller_Rest {
	
	/**
	 * The version of the API.
	 */
	public $_api_version = '1.0.0';
	
	/**
	 * The date format used for the API.
	 */
	public $_date_format = 'M d Y H:i';
	
	public function get_info()
	{
		# code...
	}
	
	public function get_character()
	{
		# code...
	}
	
	public function get_characters()
	{
		# code...
	}
	
	public function get_log()
	{
		# code...
	}
	
	public function get_logs()
	{
		# code...
	}
	
	public function get_mission()
	{
		# code...
	}
	
	public function get_news()
	{
		# code...
	}
	
	public function get_allnews()
	{
		# code...
	}
	
	public function get_missionpost()
	{
		# code...
	}
	
	public function get_missionposts()
	{
		# code...
	}
	
	private function get_user()
	{
		# code...
	}
	
	private function get_users()
	{
		# code...
	}
}
