<?php

class Test extends Controller {
	
	function Test()
	{
		parent::Controller();
		
		/* load the session library */
		$this->load->library('session');
	}
	
	function index()
	{
		$password1 = $this->auth->hash('alpha311');
		$password2 = $this->auth->hash('alpha312');
	}
}