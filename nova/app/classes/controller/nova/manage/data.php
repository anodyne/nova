<?php

class Controller_Nova_Manage_Data extends Controller_Nova_Admin_Manage {
	
	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		// create a new content view
		$this->_data = View::factory(Location::view('admin_index', $this->skin, 'pages'));
		
		$this->_data->reset = false;
		
		// content
		//$this->_data->title = ucfirst(___("admin"));
		$this->_data->title = 'Data';
		$this->_data->header = 'Data';
		$this->_data->message = 'Data';
	}
}
