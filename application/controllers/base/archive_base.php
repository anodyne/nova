<?php
/*
|---------------------------------------------------------------
| ARCHIVE CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/archive.php
| System Version: 1.0
|
| Controller that handles the ARCHIVE section of the admin system.
|
*/

class Archive_base extends Controller {

	/* set the variables */
	var $settings;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Archive_base()
	{
		parent::Controller();
		
		/* load the system model */
		$this->load->model('system_model', 'sys');
		$installed = $this->sys->check_install_status();
		
		if ($installed === FALSE)
		{ /* check whether the system is installed */
			redirect('install/index', 'refresh');
		}
		
		/* load the session library */
		$this->load->library('session');
		
		/* load the models */
		$this->load->model('characters_model', 'char');
		$this->load->model('players_model', 'player');
		
		/* check to see if they are logged in */
		$this->auth->is_logged_in();
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_main',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'show_news',
			'use_sample_post',
			'default_email_name',
			'default_email_address',
			'email_subject',
			'system_email'
		);
		
		/* grab the settings */
		$this->settings = $this->settings_model->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->settings['skin_main'];
		$this->rank = $this->settings['display_rank'];
		$this->timezone = $this->settings['timezone'];
		$this->dst = $this->settings['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			$this->skin = $this->session->userdata('skin_main');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_main.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'main'), TRUE);
		$this->template->write('title', $this->settings['sim_name'] . ' :: ');
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			/* create the user panels */
			$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
			$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
			$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
	}

	function index()
	{
		/* figure out where the view should be coming from */
		$view_loc = view_location('wiki_index', $this->skin, 'wiki', APPPATH);
		
		/* write the data to the template */
		$this->template->write('title', lang('title_wiki_index'));
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function character()
	{
		# code...
	}
	
	function siteglobals()
	{
		# code...
	}
	
	function specs()
	{
		# code...
	}
}

/* End of file archive.php */
/* Location: ./application/controllers/base/archive_base.php */