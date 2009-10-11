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
	var $globals;
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
		
		/* an array of the global we want to retrieve */
		$globals_array = array(
			'skin_wiki',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name'
		);
		
		/* grab the globals */
		$this->globals = $this->globals_model->get_globals($globals_array);
		
		/* load the session library */
		$this->load->library('session');
		
		/* set the variables */
		$this->skin = $this->globals['skin_wiki'];
		$this->rank = $this->globals['display_rank'];
		$this->timezone = $this->globals['timezone'];
		$this->dst = $this->globals['daylight_savings'];
		
		if ($this->session->userdata('player_id') === TRUE)
		{ /* if there's a session, set the variables appropriately */
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
		$this->template->write('nav_sub', $this->menu->build('nav', 'wiki'), TRUE);
		$this->template->write('title', $this->globals['sim_name'] . ' :: ');
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