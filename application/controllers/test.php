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
		$this->load->model('wiki_model', 'wiki');
		
		$this->load->helper('debug');
		
		$foo = $this->wiki->get_all_contributors(1);
		
		print_var($foo);
	}

	function memory()
	{
		$this->load->model('system_model', 'sys');
		$this->load->helper('utility');
		
		$dbsize = file_size($this->sys->get_database_size());
		$check = check_memory($dbsize);
		
		$this->output->enable_profiler(true);
	}
	
	function ftp()
	{
		/* load the resources */
		$this->load->library('ftp');
		
		//$this->ftp->connect();
		
		//$this->ftp->chmod('core/logs/', DIR_WRITE_MODE);
		//$this->ftp->chmod(APPFOLDER .'/assets/images/characters/', DIR_WRITE_MODE);
		
		//$this->ftp->move("test.txt", "core/logs/test.txt");
		
		echo '<pre>';
		//print_r($this->ftp->list_files('core/logs/'));
		echo '</pre>';
		
		//$this->ftp->close();
	}
	
	function config()
	{
		echo '<pre>';
		var_dump($this->db->dbprefix);
		echo '</pre>';
	}
	
	function sessions()
	{
		$this->load->model('players_model');
		$this->load->helper('debug');
		
		$online = $this->players_model->get_online_players();
		
		print_var($online);
	}
	
	function classvars()
	{
		$this->load->model('positions_model', 'pos');
		
		$foo = array('pos_name', 'pos_open');
		
		$details = $this->pos->get_position_details(1);
		$position = $this->pos->get_position(1, $foo);
		
		echo $details->pos_name;
		echo '<br />';
		echo $position['pos_name'] .' - '. $position['pos_open'];
	}
	
	function skinsec()
	{
		/* load the resources */
		$this->load->model('system_model', 'sys');
		
		/* set the POST variables */
		$location = 'redmond';
		$section = 'main';
		
		$where = array(
			'skinsec_section' => $section,
			'skinsec_skin' => $location
		);
		
		/* grab the position details */
		$item = $this->sys->get_skinsec($where);
		
		/* set the output */
		$output = ($item !== FALSE) ? array('src' => base_url() .'views/'. $location .'/'. $section .'/'. $item->skinsec_image_preview) : '';
		
		var_dump($output);
		
		//echo img($output);
	}
	
	function values()
	{
		echo '<pre>';
		print_r(ini_get_all());
		echo '</pre>';
	}
}