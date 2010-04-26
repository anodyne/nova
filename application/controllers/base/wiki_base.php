<?php
/*
|---------------------------------------------------------------
| WIKI CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/wiki_base.php
| System Version: 1.0.3
|
| Changes: updated Thresher to use the proper template regions
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
		
		/* load the libraries */
		$this->load->library('session');
		$this->load->library('thresher');
		
		/* load the models */
		$this->load->model('characters_model', 'char');
		$this->load->model('users_model', 'user');
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
			'system_email',
			'email_subject'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_wiki'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_wiki');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (bool) $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_template('wiki');
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
		/* grab the recently updated items */
		$updated = $this->wiki->get_recently_updated();
		
		if ($updated->num_rows() > 0)
		{
			foreach ($updated->result() as $u)
			{
				$data['recent']['updates'][] = array(
					'id' => $u->page_id,
					'title' => $u->draft_title,
					'author' => $this->char->get_character_name($u->page_updated_by_character),
					'timespan' => timespan_short($u->page_updated_at, now()),
					'comments' => $u->draft_changed_comments,
				);
			}
		}
		
		/* grab the recently updated items */
		$created = $this->wiki->get_recently_created();
		
		if ($created->num_rows() > 0)
		{
			foreach ($created->result() as $c)
			{
				$data['recent']['created'][] = array(
					'id' => $c->page_id,
					'title' => $c->draft_title,
					'author' => $this->char->get_character_name($c->page_created_by_character),
					'timespan' => timespan_short($c->page_created_at, now()),
					'summary' => $c->draft_summary,
				);
			}
		}
		
		$data['header'] = ucwords(lang('global_wiki') .' - '. lang('labels_main') .' '. lang('labels_page'));
		
		$data['text'] = $this->msgs->get_message('wiki_main');
		
		$data['label'] = array(
			'ago' => lang('time_ago'),
			'by' => lang('labels_by'),
			'page' => ucfirst(lang('labels_page')),
			'recent_created' => ucwords(lang('status_recently') .' '. lang('actions_created')),
			'recent_updates' => ucwords(lang('status_recently') .' '. lang('actions_updated')),
			'summary' => ucfirst(lang('labels_summary')),
			'updates' => ucwords(lang('actions_update') .' '. lang('labels_summary')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_index', $this->skin, 'wiki');
		$js_loc = js_location('wiki_index_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function categories()
	{
		/* check the user's access */
		$data['access'] = ($this->auth->is_logged_in()) ? $this->auth->check_access('wiki/categories', FALSE) : FALSE;
		
		/* grab the categories */
		$categories = $this->wiki->get_categories();
		
		/* create the uncategorized item first */
		$data['categories'][0] = ucfirst(lang('labels_uncategorized'));
		
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
			'edit' => '[ '. ucwords(lang('actions_edit') .' '. lang('labels_categories')) .' ]',
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
		$id = $this->uri->segment(3, 0, TRUE);
		
		/* get the category name */
		$category = $this->wiki->get_category($id, 'wikicat_name');
		$category = ($category === FALSE) ? ucfirst(lang('labels_uncategorized')) : $category;
		
		/* grab the pages */
		$pages = $this->wiki->get_pages($id);
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $p)
			{
				$data['pages'][$p->page_id]['id'] = $p->page_id;
				$data['pages'][$p->page_id]['title'] = $p->draft_title;
				$data['pages'][$p->page_id]['author'] = $this->char->get_character_name($p->draft_author_character);
				$data['pages'][$p->page_id]['summary'] = $p->draft_summary;
			}
		}
		
		/* set the header */
		$data['header'] = ucfirst(lang('labels_category')) .' - '. $category;
		
		$data['label'] = array(
			'nopages' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_pages')
			),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_category', $this->skin, 'wiki');
		$js_loc = js_location('wiki_category_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function managecategories()
	{
		$this->auth->check_access('wiki/categories');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'wikicat_name' => $this->input->post('name', TRUE),
						'wikicat_desc' => $this->input->post('desc', TRUE),
					);
					
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
					
					$update_array = array(
						'wikicat_name' => $this->input->post('name', TRUE),
						'wikicat_desc' => $this->input->post('desc', TRUE)
					);
					
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
				$data['categories'][$c->wikicat_id]['desc'] = $c->wikicat_desc;
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_categories'));
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('category-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'delete' => array(
				'src' => img_location('category-delete.png', $this->skin, 'wiki'),
				'alt' => ''),
			'edit' => array(
				'src' => img_location('category-edit.png', $this->skin, 'wiki'),
				'alt' => ''),
		);
		
		$data['inputs'] = array(
			'name' => array(
				'name' => 'name',
				'id' => 'name'),
			'desc' => array(
				'name' => 'desc',
				'id' => 'desc',
				'rows' => 3),
		);
		
		$data['label'] = array(
			'catdesc' => ucfirst(lang('labels_desc')),
			'catname' => ucfirst(lang('labels_name')),
			'name' => ucfirst(lang('labels_name')),
			'desc' => ucfirst(lang('labels_desc')),
			'add' => ucwords(lang('actions_add') .' '. lang('global_wiki') .' '.
				lang('labels_category') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'nocats' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_categories')
			),
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
				'alt' => '',
				'class' => 'image inline_img_left'),
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
						'page_created_by_user' => $this->session->userdata('userid'),
						'page_created_by_character' => $this->session->userdata('main_char'),
						'page_comments' => $this->input->post('comments', TRUE)
					);
					
					/* put the page information into the database */
					$insert = $this->wiki->create_page($page_array);
					$pageid = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('wiki_pages');
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 4) == 'cat_')
						{
							$category_array[$key] = $value;
						}
					}
					
					$category_string = (isset($category_array) && is_array($category_array)) ? implode(',', $category_array) : '';
					
					/* create the array of draft data */
					$draft_array = array(
						'draft_author_user' => $this->session->userdata('userid'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', TRUE),
						'draft_title' => $this->input->post('title', TRUE),
						'draft_created_at' => now(),
						'draft_page' => $pageid,
						'draft_categories' => $category_string,
						'draft_summary' => $this->input->post('summary', TRUE),
					);
					
					/* put the draft information into the database */
					$insert += $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('wiki_drafts');
					
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
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 4) == 'cat_')
						{
							$category_array[$key] = $value;
						}
					}
					
					$category_string = implode(',', $category_array);
					
					/* create the array of draft data */
					$draft_array = array(
						'draft_author_user' => $this->session->userdata('userid'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', TRUE),
						'draft_title' => $this->input->post('title', TRUE),
						'draft_created_at' => now(),
						'draft_page' => $id,
						'draft_categories' => $category_string,
						'draft_summary' => $this->input->post('summary', TRUE),
						'draft_changed_comments' => $this->input->post('changes', TRUE),
					);
					
					/* put the draft information into the database */
					$insert = $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('wiki_drafts');
					
					/* create the array of page data */
					$page_array = array(
						'page_updated_at' => now(),
						'page_updated_by_user' => $this->session->userdata('userid'),
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
				'summary' => array(
					'name' => 'summary',
					'id' => 'summary',
					'class' => 'full-width',
					'rows' => 2),
			);
			
			$categories = $this->wiki->get_categories();
			
			if ($categories->num_rows() > 0)
			{
				foreach ($categories->result() as $c)
				{
					$data['cats'][] = array(
						'id' => $c->wikicat_id,
						'name' => $c->wikicat_name,
						'desc' => $c->wikicat_desc,
					);
				}
			}
			
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
						'changes' => array(
							'name' => 'changes',
							'id' => 'changes',
							'class' => 'full-width',
							'rows' => 2),
						'summary' => array(
							'name' => 'summary',
							'id' => 'summary',
							'class' => 'full-width',
							'rows' => 2,
							'value' => (!empty($p->draft_summary)) ? $p->draft_summary : ''),
					);
				}
			}
			
			/* set the id */
			$data['id'] = $id;
			
			/* build the category list */
			$cats = explode(',', $p->draft_categories);
			
			$categories = $this->wiki->get_categories();
			
			if ($categories->num_rows() > 0)
			{
				foreach ($categories->result() as $c)
				{
					$data['cats'][] = array(
						'id' => $c->wikicat_id,
						'name' => $c->wikicat_name,
						'desc' => $c->wikicat_desc,
						'checked' => (in_array($c->wikicat_id, $cats)) ? TRUE : FALSE,
					);
				}
			}
			
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
			'back' => LARROW .' '. ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_pages')),
			'categories' => ucfirst(lang('labels_categories')),
			'changes' => ucfirst(lang('actions_changes')),
			'closed' => ucfirst(lang('status_closed')),
			'comments' => ucfirst(lang('labels_comments')),
			'open' => ucfirst(lang('status_open')),
			'summary' => ucfirst(lang('labels_summary')),
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
	
	function recent()
	{
		/* set the uri segments */
		$type = $this->uri->segment(3);
		
		switch ($type)
		{
			case 'updates':
			default:
				/* grab the recently updated items */
				$updated = $this->wiki->get_recently_updated(100);
				
				if ($updated->num_rows() > 0)
				{
					foreach ($updated->result() as $u)
					{
						$data['recent']['updates'][] = array(
							'id' => $u->page_id,
							'title' => $u->draft_title,
							'author' => $this->char->get_character_name($u->page_updated_by_character),
							'timespan' => timespan_short($u->page_updated_at, now()),
							'comments' => $u->draft_changed_comments,
						);
					}
				}
				
				$data['header'] = ucwords(lang('global_wiki') .' - '. lang('status_recently') .' '. lang('actions_updated'));
				
				break;
				
			case 'created':
				/* grab the recently updated items */
				$created = $this->wiki->get_recently_created(100);
				
				if ($created->num_rows() > 0)
				{
					foreach ($created->result() as $c)
					{
						$data['recent']['created'][] = array(
							'id' => $c->page_id,
							'title' => $c->draft_title,
							'author' => $this->char->get_character_name($c->page_created_by_character),
							'timespan' => timespan_short($c->page_created_at, now()),
							'summary' => $c->draft_summary,
						);
					}
				}
				
				$data['header'] = ucwords(lang('global_wiki') .' - '. lang('status_recently') .' '. lang('actions_created'));
				
				break;
		}
		
		$data['label'] = array(
			'ago' => lang('time_ago'),
			'by' => lang('labels_by'),
			'page' => ucfirst(lang('labels_page')),
			'created' => ucwords(lang('actions_show') .' '. lang('status_recently') .' '. lang('actions_created')),
			'updates' => ucwords(lang('actions_show') .' '. lang('status_recently') .' '. lang('actions_updated')),
			'summary' => ucfirst(lang('labels_summary')),
			'update_summary' => ucwords(lang('actions_update') .' '. lang('labels_summary')),
		);
		
		/* figure out where the view files should be coming from */
		$view_loc = view_location('wiki_recent', $this->skin, 'wiki');
		$js_loc = js_location('wiki_recent_js', $this->skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		$this->template->write('title', $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function view()
	{
		/* check to see if they have access */
		$access = ($this->auth->is_logged_in()) ? $this->auth->check_access('wiki/page', FALSE) : FALSE;
		
		/* get the access level */
		$level = ($this->auth->is_logged_in()) ? $this->auth->get_access_level('wiki/page') : FALSE;
		
		/* set the variables */
		$type = $this->uri->segment(3, 'page');
		$id = $this->uri->segment(4, 0, TRUE);
		$action = $this->uri->segment(5, FALSE);
		
		/* assign the config array to a variable */
		$c = $this->config->item('thresher');
		
		/* load the library and pass the config items in */
		$this->load->library('thresher', $c);
		
		if (isset($_POST['submit']) && $this->auth->is_logged_in())
		{
			if ($action == 'revert')
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
						'draft_author_user' => $this->session->userdata('userid'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_summary' => $row->draft_summary,
						'draft_content' => $row->draft_content,
						'draft_page' => $page,
						'draft_created_at' => now(),
						'draft_categories' => $row->draft_categories,
						'draft_changed_comments' => lang('wiki_reverted')
					);
					
					$insert = $this->wiki->create_draft($insert_array);
					$draftid = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('wiki_drafts');
					
					$update_array = array(
						'page_draft' => $draftid,
						'page_updated_by_user' => $this->session->userdata('userid'),
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
			
			if ($action == 'comment')
			{
				$comment_text = $this->input->post('comment_text');
				
				if (!empty($comment_text))
				{
					$status = $this->user->checking_moderation('wiki_comment', $this->session->userdata('userid'));
					
					/* build the insert array */
					$insert = array(
						'wcomment_content' => $comment_text,
						'wcomment_page' => $id,
						'wcomment_date' => now(),
						'wcomment_author_character' => $this->session->userdata('main_char'),
						'wcomment_author_user' => $this->session->userdata('userid'),
						'wcomment_status' => $status
					);
					
					/* insert the data */
					$add = $this->wiki->create_comment($insert);
					
					if ($add > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_comment')),
							lang('actions_added'),
							''
						);
						
						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* set the array of data for the email */
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'page' => $id,
							'comment' => $comment_text);
							
						$emailaction = ($status == 'pending') ? 'comment_pending' : 'comment';
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email($emailaction, $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_comment')),
							lang('actions_added'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				}
				else
				{
					$flash['status'] = 'error';
					$flash['message'] = lang_output('flash_add_comment_empty_body');
				}
				
				/* write everything to the template */
				$this->template->write_view('flash_message', '_base/wiki/pages/flash', $flash);
			}
		}
		
		switch ($action)
		{
			case 'comment':
				$js_data['tab'] = 2;
				break;
				
			case 'revert':
				$js_data['tab'] = 1;
				break;
				
			default:
				$js_data['tab'] = 0;
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
					
					$count = substr_count($d->draft_categories, ',');
					
					if ($count === 0 && empty($d->draft_categories))
					{
						$string = sprintf(
							lang('error_not_found'),
							lang('labels_categories')
						);
					}
					else
					{
						$categories = explode(',', $d->draft_categories);
						
						foreach ($categories as $c)
						{
							$name = $this->wiki->get_category($c, 'wikicat_name');
							
							$cat[] = anchor('wiki/category/'. $c, $name);
						}
						
						$string = implode(' | ', $cat);
					}
					
					$data['draft'] = array(
						'content' => $this->thresher->parse($d->draft_content),
						'created' => $this->char->get_character_name($d->draft_author_character, TRUE),
						'created_date' => mdate($datestring, $created),
						'page' => $d->draft_page,
						'categories' => $string,
					);
				}
			}
			
			$view_loc = view_location('wiki_view_draft', $this->skin, 'wiki');
		}
		else
		{
			$data['id'] = $id;
			
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

					$count = substr_count($p->draft_categories, ',');
					
					if ($count === 0 && empty($p->draft_categories))
					{
						$string = sprintf(
							lang('error_not_found'),
							lang('labels_categories')
						);
					}
					else
					{
						$categories = explode(',', $p->draft_categories);
						
						foreach ($categories as $c)
						{
							$name = $this->wiki->get_category($c, 'wikicat_name');
							
							$cat[] = anchor('wiki/category/'. $c, $name);
						}
						
						$string = implode(' | ', $cat);
					}
					
					$data['page'] = array(
						'content' => $this->thresher->parse($p->draft_content),
						'created' => $this->char->get_character_name($p->page_created_by_character, TRUE),
						'updated' => (!empty($p->page_updated_by_character)) ? $this->char->get_character_name($p->page_updated_by_character, TRUE) : FALSE,
						'created_date' => mdate($datestring, $created),
						'updated_date' => mdate($datestring, $updated),
						'categories' => $string,
						'summary' => $p->draft_summary,
					);
				}
			}
			
			if ($this->auth->is_logged_in())
			{
				if ($level == 3 || $level == 2 || ($level == 1 && ($p->page_created_by_user == $this->session->userdata('userid'))))
				{
					$data['edit'] = TRUE;
				}
				else
				{
					$data['edit'] = FALSE;
				}
			}
			else
			{
				$data['edit'] = FALSE;
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
					
					$page = $this->wiki->get_page($d->draft_page);
					$row = ($page->num_rows() > 0) ? $page->row() : FALSE;
					
					$data['history'][$d->draft_id] = array(
						'draft' => $d->draft_id,
						'title' => $d->draft_title,
						'content' => $this->thresher->parse($d->draft_content),
						'created' => $this->char->get_character_name($d->draft_author_character),
						'created_date' => mdate($datestring, $created),
						'old_id' => (!empty($d->draft_id_old)) ? $d->draft_id_old : FALSE,
						'page' => $d->draft_page,
						'changes' => $d->draft_changed_comments,
						'page_draft' => ($row !== FALSE) ? $row->page_draft : FALSE,
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
					$date = gmt_to_local($cm->wcomment_date, $this->timezone, $this->dst);
					
					$data['comments'][$cm->wcomment_id]['author'] = $this->char->get_character_name($cm->wcomment_author_character, TRUE);
					$data['comments'][$cm->wcomment_id]['content'] = $cm->wcomment_content;
					$data['comments'][$cm->wcomment_id]['date'] = mdate($datestring, $date);
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
			'comment' => array(
				'src' => img_location('comment-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'inline_img_left image'),
		);
		
		$data['label'] = array(
			'addcomment' => ucfirst(lang('actions_add')) .' '. lang('labels_a') .' '. ucfirst(lang('labels_comment')),
			'back_page' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_wiki') .' '. lang('labels_page')),
			'by' => lang('labels_by'),
			'categories' => ucfirst(lang('labels_categories')) .':',
			'comments' => ucfirst(lang('labels_comments')),
			'created' => lang('actions_created'),
			'draft' => ucfirst(lang('labels_draft')),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
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
		$this->template->write_view('javascript', $js_loc, $js_data);
		$this->template->write('title', ucfirst(lang('global_wiki')) .' - '. $data['header']);
		
		/* render the template */
		$this->template->render();
	}
	
	function _email($type = '', $data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* define the variables */
		$email = FALSE;
		
		/* run the methods */
		$page = $this->wiki->get_page($data['page']);
		$row = $page->row();
		$name = $this->char->get_character_name($data['author']);
		$from = $this->user->get_email_address('character', $data['author']);
		
		switch ($type)
		{
			case 'comment':
				/* get all the contributors of a wiki page */
				$cont = $this->wiki->get_all_contributors($data['page']);
				
				foreach ($cont as $c)
				{
					$pref = $this->user->get_pref('email_new_wiki_comments', $c);
					
					if ($pref == 'y')
					{
						$to_array[] = $this->user->get_email_address('user', $c);
					}
				}
				
				/* set the to string */
				$to = implode(',', $to_array);
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_wiki_comment_added'),
					"<strong>". $row->draft_title ."</strong>",
					$data['comment']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_wiki_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('wiki_comment', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'comment_pending':
				/* run the methods */
				$to = implode(',', $this->user->get_emails_with_access('manage/comments'));
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_wiki'),
					"<strong>". $row->draft_title ."</strong>",
					$data['comment'],
					site_url('login/index')
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_comment_pending'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('comment_pending', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
}

/* End of file wiki_base.php */
/* Location: ./application/controllers/wiki_base.php */