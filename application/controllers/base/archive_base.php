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
	var $options;
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
		$this->load->model('users_model', 'user');
		
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
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_admin');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (bool) $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_main.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'main'), TRUE);
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
		/* load the resources */
		$this->load->model('archive_model', 'arc');
		
		/* run the methods */
		$sms = $this->arc->get_sms_version();
		
		if ($sms === FALSE)
		{
			$data['message'] = 'SMS is not installed in this database and the archive feature cannot be used!';
		}
		else
		{
			$data['message'] = "Please select what you would like to view:\r\n\r\n";
			$data['message'].= anchor('archive/database', 'Database Entries') ."\r\n";
			$data['message'].= anchor('archive/decks', 'Deck Listing');
		}
		
		$data['header'] = 'SMS Archives';
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('archive_index', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', 'SMS Archives');
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function database()
	{
		/* load the resources */
		$this->load->model('archive_model', 'arc');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id === FALSE)
		{
			/* run the methods */
			$entries = $this->arc->get_all_db_entries();
			
			if ($entries->num_rows() > 0)
			{
				foreach ($entries->result() as $e)
				{
					$data['entries'][$e->dbid] = array(
						'title' => $e->dbTitle,
						'desc' => $e->dbDesc,
						'type' => $e->dbType
					);
				}
			}
			
			$data['header'] = 'Archives - Database Entries';
		}
		else
		{
			/* run the methods */
			$entry = $this->arc->get_db_entry($id);
			
			if ($entry->num_rows() > 0)
			{
				$e = $entry->row();
				
				$data['entry'] = array(
					'title' => $e->dbTitle,
					'desc' => $e->dbDesc,
					'content' => $e->dbContent
				);
			}
			
			$data['header'] = 'Archives - Database Entry - '. $e->dbTitle;
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('archive_database', $this->skin, 'main');
		$js_loc = js_location('archive_database_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function decks()
	{
		/* load the resources */
		$this->load->model('archive_model', 'arc');
		
		/* run the methods */
		$decks = $this->arc->get_deck_listing();
		
		if ($decks->num_rows() > 0)
		{
			foreach ($decks->result() as $d)
			{
				$data['decks'][$d->deckid] = $d->deckContent;
			}
		}
		
		$data['header'] = 'Archives - Deck Listing';
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('archive_decks', $this->skin, 'main');
		$js_loc = js_location('archive_decks_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', 'Archives - Deck Listing');
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file archive.php */
/* Location: ./application/controllers/base/archive_base.php */