<?php

require_once MODPATH.'core/libraries/Nova_main_controller'.EXT;

class About extends Nova_main_controller {
	
	public function __construct()
	{
		parent::__construct();
		
		Template::assign('nav_sub', Menu::build('sub', 'main'));
	}
	
	public function index()
	{
		Template::assign('content', 'Hey there!');
		Template::assign('title', 'Title');
		
		Template::render();
	}
}
