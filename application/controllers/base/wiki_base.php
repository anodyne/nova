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
		$this->load->model('wiki_model', 'wiki');
		
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
	
	function categories()
	{
		/* grab the categories */
		$categories = $this->wiki->get_categories();
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $c)
			{
				$data['categories'][$c->wikicat_id] = $c->wikicat_name;
			}
		}
		
		/* set the header */
		$data['header'] = ucwords(lang('global_wiki') .' '. lang('labels_categories'));
		
		$data['label'] = array(
			'nocats' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_categories')
			),
			'text' => sprintf(
				lang('wiki_categories_text'),
				lang('labels_categories'),
				lang('global_wiki'),
				lang('labels_category')
			),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_categories', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function category()
	{
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id !== FALSE)
		{
			$pages = $this->wiki->get_pages($id);
			
			if ($pages->num_rows() > 0)
			{
				foreach ($pages->result() as $p)
				{
					$data['pages'][$p->page_id]['id'] = $p->page_id;
					$data['pages'][$p->page_id]['title'] = $p->draft_title;
					$data['pages'][$p->page_id]['author'] = $p->draft_author;
				}
			}
		}
		
		/* set the header */
		$data['header'] = ucwords(lang('global_wiki') .' '. lang('labels_category'));
		
		$data['label'] = array(
			'nopages' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_pages')
			),
			'text' => sprintf(
				lang('wiki_categories_text'),
				lang('labels_categories'),
				lang('global_wiki'),
				lang('labels_category')
			),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_category', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function history()
	{
		# display the history for a wiki page based on what's passed through the URL
	}
	
	function managecategories()
	{
		$this->auth->check_access('wiki/categories');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array('wikicat_name' => $this->input->post('name', TRUE));
					
					/* insert the record */
					$insert = $this->wiki->create_category($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
					
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
				
					/* insert the record */
					$delete = $this->wiki->delete_category($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$update_array = array('wikicat_name' => $this->input->post('name', TRUE));
					
					/* insert the record */
					$update = $this->wiki->update_category($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_wiki') .' '. lang('labels_category')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
					
					break;
			}
		}
		
		/* grab the categories */
		$categories = $this->wiki->get_categories();
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $c)
			{
				$data['categories'][$c->wikicat_id]['id'] = $c->wikicat_id;
				$data['categories'][$c->wikicat_id]['name'] = $c->wikicat_name;
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_categories'));
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('icon-add.png', $this->skin, 'wiki'),
				'alt' => ''),
			'delete' => array(
				'src' => img_location('icon-delete.png', $this->skin, 'wiki'),
				'alt' => ''),
			'edit' => array(
				'src' => img_location('icon-edit.png', $this->skin, 'wiki'),
				'alt' => ''),
		);
		
		$data['inputs'] = array(
			'name' => array(
				'name' => 'name',
				'id' => 'name'),
		);
		
		$data['label'] = array(
			'catname' => ucwords(lang('labels_category') .' '. lang('labels_name')),
			'name' => ucfirst(lang('labels_name')),
			'add' => ucwords(lang('actions_add') .' '. lang('global_wiki') .' '.
				lang('labels_category') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete'))
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update'))),
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'add',
				'content' => ucwords(lang('actions_add')))
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_managecats', $this->skin, 'wiki');
		$js_loc = js_location('wiki_managecats_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function managepages()
	{
		$this->auth->check_access('wiki/pages');
		
		if (isset($_POST['submit']))
		{
			$level = $this->auth->get_access_level('wiki/pages');
			
			if ($level == 2)
			{
				switch ($this->uri->segment(3))
				{
					case 'delete':
						$id = $this->input->post('id', TRUE);
					
						/* insert the record */
						$delete = $this->wiki->delete_page($id);
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('global_wiki') .' '. lang('labels_page')),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('global_wiki') .' '. lang('labels_page')),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
						
						/* write everything to the template */
						$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
						
						break;
				}
			}
		}
		
		/* grab the pages */
		$pages = $this->wiki->get_pages();
		
		/* set the date format */
		$datestring = $this->options['date_format'];
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $p)
			{
				/* set the date */
				$created = gmt_to_local($p->page_created_at, $this->timezone, $this->dst);
				$updated = gmt_to_local($p->page_updated_at, $this->timezone, $this->dst);
			
				$data['pages'][$p->page_id]['id'] = $p->page_id;
				$data['pages'][$p->page_id]['title'] = $p->draft_title;
				$data['pages'][$p->page_id]['created'] = $this->char->get_character_name($p->page_created_by_character, TRUE);
				$data['pages'][$p->page_id]['updated'] = $this->char->get_character_name($p->page_updated_by_character, TRUE);
				$data['pages'][$p->page_id]['created_date'] = mdate($datestring, $created);
				$data['pages'][$p->page_id]['updated_date'] = mdate($datestring, $updated);
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_pages'));
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('page-add.png', $this->skin, 'wiki'),
				'alt' => ''),
			'delete' => array(
				'src' => img_location('page-delete.png', $this->skin, 'wiki'),
				'alt' => ''),
			'edit' => array(
				'src' => img_location('page-edit.png', $this->skin, 'wiki'),
				'alt' => ''),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_create') .' '. lang('status_new') .' '. 
				lang('global_wiki') .' '. lang('labels_page') .' '. RARROW),
			'created' => ucwords(lang('actions_created') .' '. lang('labels_by')),
			'name' => ucwords(lang('labels_page') .' '. lang('labels_name')),
			'nopages' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_pages')
			),
			'updated' => ucwords(lang('actions_updated') .' '. lang('labels_by')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_managepages', $this->skin, 'wiki');
		$js_loc = js_location('wiki_managepages_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function page()
	{
		$this->auth->check_access('wiki/pages');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id === FALSE || $id === 0)
		{
			$data['inputs'] = array(
				'title' => array(
					'name' => 'title',
					'id' => 'title'),
				'content' => array(
					'name' => 'content',
					'id' => 'content',
					'rows' => 30),
			);
			
			$data['header'] = ucwords(lang('actions_create') .' '. lang('global_wiki') .' '. lang('labels_page'));
			
			/* figure out where the view files should be coming from */
			$view_loc = view_location('wiki_page_create', $this->skin, 'wiki');
		}
		else
		{
			# edit a page
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_pages'));
			
			/* figure out where the view files should be coming from */
			$view_loc = view_location('wiki_managepages', $this->skin, 'wiki');
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('page-add.png', $this->skin, 'wiki'),
				'alt' => ''),
			'delete' => array(
				'src' => img_location('page-delete.png', $this->skin, 'wiki'),
				'alt' => ''),
			'edit' => array(
				'src' => img_location('page-edit.png', $this->skin, 'wiki'),
				'alt' => ''),
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update'))),
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'add',
				'content' => ucwords(lang('actions_add')))
		);
		
		$data['label'] = array(
			'content' => ucfirst(lang('labels_content')),
			'title' => ucfirst(lang('labels_title')),
		);
		
		/* figure out where the view files should be coming from */
		$js_loc = js_location('wiki_page_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function view()
	{
		# display the wiki page based on what's passed in the URL
	}
	
	function _revert_draft($article = '', $draft = '')
	{
		# private function to revert to a previous draft
		# protected
	}
}

/* End of file wiki_base.php */
/* Location: ./application/controllers/wiki_base.php */