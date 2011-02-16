<?php defined('SYSPATH') OR die('No direct access allowed.');

class Controller_Aboutnova extends Controller_Nova_Main
{
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory('aboutnova');
		
		// content
		$this->template->title.= __('About Nova');
		
		// send the response
		$this->request->response = $this->template;
	}
}