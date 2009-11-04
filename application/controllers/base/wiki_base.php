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

# TODO: remove the debug helper

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
		
		/* load the libraries */
		$this->load->library('session');
		$this->load->library('thresher');
		
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
		
		$this->load->helper('debug');
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
		# TODO: need to have an 'uncategorized' section to catch anything that doesn't have a category
		
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
		$this->auth->check_access('wiki/page');
		
		if (isset($_POST['submit']))
		{
			$level = $this->auth->get_access_level('wiki/page');
			
			if ($level == 3)
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
				$data['pages'][$p->page_id]['updated'] = (!empty($p->page_updated_by_character)) ? $this->char->get_character_name($p->page_updated_by_character, TRUE) : FALSE;
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
		$this->auth->check_access('wiki/page');
		
		/* set the variables */
		$id = $this->uri->segment(3, 0, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(4))
			{
				case 'create':
					/* create the array of page data */
					$page_array = array(
						'page_created_at' => now(),
						'page_created_by_player' => $this->session->userdata('player_id'),
						'page_created_by_character' => $this->session->userdata('main_char'),
						'page_comments' => $this->input->post('comments', TRUE)
					);
					
					/* put the page information into the database */
					$insert = $this->wiki->create_page($page_array);
					$pageid = $this->db->insert_id();
					
					/* create the array of draft data */
					$draft_array = array(
						'draft_author_player' => $this->session->userdata('player_id'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', TRUE),
						'draft_title' => $this->input->post('title', TRUE),
						'draft_created_at' => now(),
						'draft_page' => $pageid,
						'draft_categories' => ''
					);
					
					/* put the draft information into the database */
					$insert += $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					/* update the page with the draft ID */
					$this->wiki->update_page($pageid, array('page_draft' => $draftid));
					
					if ($insert > 1)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_page')),
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
							ucfirst(lang('global_wiki') .' '. lang('labels_page')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
					
				case 'edit':
					/* create the array of draft data */
					$draft_array = array(
						'draft_author_player' => $this->session->userdata('player_id'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', TRUE),
						'draft_title' => $this->input->post('title', TRUE),
						'draft_created_at' => now(),
						'draft_page' => $id,
						'draft_categories' => ''
					);
					
					/* put the draft information into the database */
					$insert = $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					/* create the array of page data */
					$page_array = array(
						'page_updated_at' => now(),
						'page_updated_by_player' => $this->session->userdata('player_id'),
						'page_updated_by_character' => $this->session->userdata('main_char'),
						'page_comments' => $this->input->post('comments', TRUE),
						'page_draft' => $draftid
					);
					
					/* put the page information into the database */
					$update = $this->wiki->update_page($id, $page_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_page')),
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
							ucfirst(lang('global_wiki') .' '. lang('labels_page')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				
					break;
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
		}
		
		if ($id == 0)
		{
			/* set the field information */
			$data['inputs'] = array(
				'title' => array(
					'name' => 'title',
					'id' => 'title'),
				'content' => array(
					'name' => 'content',
					'id' => 'content',
					'class' => 'markitup',
					'rows' => 30),
				'comments_open' => array(
					'name' => 'comments',
					'id' => 'comments_open',
					'value' => 'open',
					'checked' => TRUE),
				'comments_closed' => array(
					'name' => 'comments',
					'id' => 'comments_closed',
					'value' => 'closed'),
			);
			
			/* set the header */
			$data['header'] = ucwords(lang('actions_create') .' '. lang('global_wiki') .' '. lang('labels_page'));
			
			/* figure out where the view files should be coming from */
			$view_loc = view_location('wiki_page_create', $this->skin, 'wiki');
		}
		else
		{
			/* grab the page information and latest draft */
			$page = $this->wiki->get_page($id);
			
			if ($page->num_rows() > 0)
			{
				foreach ($page->result() as $p)
				{
					/* set the field information */
					$data['inputs'] = array(
						'title' => array(
							'name' => 'title',
							'id' => 'title',
							'value' => (!empty($p->draft_title)) ? $p->draft_title : ''),
						'content' => array(
							'name' => 'content',
							'id' => 'content',
							'class' => 'markitup',
							'rows' => 30,
							'value' => (!empty($p->draft_content)) ? $p->draft_content : ''),
						'comments_open' => array(
							'name' => 'comments',
							'id' => 'comments_open',
							'value' => 'open',
							'checked' => ($p->page_comments == 'open') ? TRUE : FALSE),
						'comments_closed' => array(
							'name' => 'comments',
							'id' => 'comments_closed',
							'value' => 'closed',
							'checked' => ($p->page_comments == 'closed') ? TRUE : FALSE),
					);
				}
			}
			
			/* set the id */
			$data['id'] = $id;
			
			/* set the header */
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_wiki') .' '. lang('labels_page'));
			
			/* figure out where the view files should be coming from */
			$view_loc = view_location('wiki_page_edit', $this->skin, 'wiki');
		}
		
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
				'content' => ucwords(lang('actions_create')))
		);
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_pages')),
			'closed' => ucfirst(lang('status_closed')),
			'comments' => ucfirst(lang('labels_comments')),
			'open' => ucfirst(lang('status_open')),
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
		$this->auth->check_access('wiki/page', FALSE);
		
		/* set the variables */
		$type = $this->uri->segment(3, 'page');
		$id = $this->uri->segment(4, 0, TRUE);
		
		/* assign the config array to a variable */
		$c = $this->config->item('thresher');
		
		/* load the library and pass the config items in */
		$this->load->library('thresher', $c);
		
		if (isset($_POST))
		{
			if ($type == 'revert')
			{
				/* get the POST variables */
				$page = $this->input->post('page', TRUE);
				$draft = $this->input->post('draft', TRUE);
				
				/* get the draft we're reverting to */
				$draft = $this->wiki->get_draft($draft);
				
				if ($draft->num_rows() > 0)
				{
					$row = $draft->row();
					
					$insert_array = array(
						'draft_id_old' => $row->draft_id,
						'draft_title' => $row->draft_title,
						'draft_author_player' => $this->session->userdata('player_id'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $row->draft_content,
						'draft_page' => $page,
						'draft_created_at' => now(),
						'draft_categories' => ''
					);
					
					$insert = $this->wiki->create_draft($insert_array);
					$draftid = $this->db->insert_id();
					
					$update_array = array(
						'page_draft' => $draftid,
						'page_updated_by_player' => $this->session->userdata('player_id'),
						'page_updated_by_character' => $this->session->userdata('main_char'),
						'page_updated_at' => now()
					);
					
					$update = $this->wiki->update_page($page, $update_array);
					
					if ($insert > 0 && $update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_wiki') .' '. lang('labels_page')),
							lang('actions_reverted'),
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
							lang('actions_reverted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				}
				else
				{
					$message = sprintf(
						lang('error_not_found'),
						lang('labels_draft')
					);

					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
			}
		}
		
		/* set the date format */
		$datestring = $this->options['date_format'];
		
		if ($type == 'draft')
		{
			/* grab the information about the page */
			$draft = $this->wiki->get_draft($id);
			
			if ($draft->num_rows() > 0)
			{
				foreach ($draft->result() as $d)
				{
					/* set the date */
					$created = gmt_to_local($d->draft_created_at, $this->timezone, $this->dst);
					
					$data['header'] = ucfirst(lang('labels_draft')) .' - '. $d->draft_title;
					
					$data['draft'] = array(
						'content' => $this->thresher->parse($d->draft_content),
						'created' => $this->char->get_character_name($d->draft_author_character, TRUE),
						'created_date' => mdate($datestring, $created),
						'page' => $d->draft_page,
					);
				}
			}
			
			$view_loc = view_location('wiki_view_draft', $this->skin, 'wiki');
		}
		else
		{
			/*
			|---------------------------------------------------------------
			| PAGE
			|---------------------------------------------------------------
			*/
			
			/* grab the information about the page */
			$page = $this->wiki->get_page($id);
			
			if ($page->num_rows() > 0)
			{
				foreach ($page->result() as $p)
				{
					/* set the date */
					$created = gmt_to_local($p->page_created_at, $this->timezone, $this->dst);
					$updated = gmt_to_local($p->page_updated_at, $this->timezone, $this->dst);
					
					$data['header'] = $p->draft_title;
					
					$data['page'] = array(
						'content' => $this->thresher->parse($p->draft_content),
						'created' => $this->char->get_character_name($p->page_created_by_character, TRUE),
						'updated' => (!empty($p->page_updated_by_character)) ? $this->char->get_character_name($p->page_updated_by_character, TRUE) : FALSE,
						'created_date' => mdate($datestring, $created),
						'updated_date' => mdate($datestring, $updated)
					);
				}
			}
			
			/*
			|---------------------------------------------------------------
			| HISTORY
			|---------------------------------------------------------------
			*/
			
			/* grab the information about the page */
			$drafts = $this->wiki->get_drafts($id);
			
			if ($drafts->num_rows() > 0)
			{
				foreach ($drafts->result() as $d)
				{
					$created = gmt_to_local($d->draft_created_at, $this->timezone, $this->dst);
					
					$data['history'][$d->draft_id] = array(
						'draft' => $d->draft_id,
						'title' => $d->draft_title,
						'content' => $this->thresher->parse($d->draft_content),
						'created' => $this->char->get_character_name($d->draft_author_character),
						'created_date' => mdate($datestring, $created),
						'old_id' => (!empty($d->draft_id_old)) ? $d->draft_id_old : FALSE,
						'page' => $d->draft_page,
					);
				}
			}
			
			/*
			|---------------------------------------------------------------
			| COMMENTS
			|---------------------------------------------------------------
			*/
			
			/* get all the comments */
			$comments = $this->wiki->get_comments($id);
			
			if ($comments->num_rows() > 0)
			{
				foreach ($comments->result() as $cm)
				{
					$date = gmt_to_local($cm->wcomments_date, $this->timezone, $this->dst);
					
					$data['comments'][$cm->wcomments_id]['author'] = $this->char->get_character_name($cm->wcomments_author_character, TRUE);
					$data['comments'][$cm->wcomments_id]['content'] = $cm->wcomments_content;
					$data['comments'][$cm->wcomments_id]['date'] = mdate($datestring, $date);
				}
			}
			
			$data['comment_count'] = $comments->num_rows();
			
			$view_loc = view_location('wiki_view_page', $this->skin, 'wiki');
		}
		
		$data['images'] = array(
			'revert' => array(
				'src' => img_location('page-revert.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_revert'))),
			'view' => array(
				'src' => img_location('page-view.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_view'))),
		);
		
		$data['label'] = array(
			'back_page' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_wiki') .' '. lang('labels_page')),
			'by' => lang('labels_by'),
			'comments' => ucfirst(lang('labels_comments')),
			'created' => lang('actions_created'),
			'draft' => ucfirst(lang('labels_draft')),
			'history' => ucfirst(lang('labels_history')),
			'nocomments' => sprintf(
				lang('error_not_found'),
				lang('labels_comments')
			),
			'nohistory' => sprintf(
				lang('error_not_found'),
				lang('labels_page') .' '. lang('labels_history')
			),
			'on' => lang('labels_on'),
			'page' => ucfirst(lang('labels_page')),
			'reverted' => lang('actions_reverted'),
			'to' => lang('labels_to'),
		);
		
		/* figure out where the view files should be coming from */
		$js_loc = js_location('wiki_view_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file wiki_base.php */
/* Location: ./application/controllers/wiki_base.php */