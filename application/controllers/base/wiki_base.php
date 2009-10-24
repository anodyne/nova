<?php
/*
|---------------------------------------------------------------
| WIKI CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/wiki_base.php
| System Version: 1.0
|
| Controller that handles the WIKI section of the system.
|
*/

class Wiki_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;
	
	function Wiki_base()
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
			'skin_wiki',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'system_email'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_wiki'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			$this->skin = $this->session->userdata('skin_wiki');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_wiki.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'wiki'), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			/* create the user panels */
			$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
			$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
			$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
			$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		}
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
	
	function page()
	{
		# display the wiki page based on what's passed through the URL
	}
	
	function history()
	{
		# display the history for a wiki page based on what's passed through the URL
	}
	
	function categories()
	{
		# manage the categories
		# protected
	}
	
	function options()
	{
		# set the wiki options
		# protected
	}
	
	function writepage()
	{
		# write a new page
		# protected
	}
	
	function writedraft()
	{
		# write a new draft
		# protected
	}
	
	function editpage()
	{
		# edit a page
		# protected
	}
	
	function editdraft()
	{
		# edit a page draft
		# protected
	}
	
	function _revert_draft()
	{
		# private function to revert to a previous draft
		# protected
	}
}

/* End of file wiki_base.php */
/* Location: ./application/controllers/wiki_base.php */