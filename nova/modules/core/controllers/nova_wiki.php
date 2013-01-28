<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Wiki controller
 *
 * @package		Thresher
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_wiki.php';

abstract class Nova_wiki extends Nova_controller_wiki {
	
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		// pull the system page
		$syspage = $this->wiki->get_system_page('index');
		
		// send the system page to the view
		$data['header'] = $syspage->draft_title;
		$data['syspage'] = $syspage->draft_content;
		
		// build the page title
		$pagetitle = ucwords(lang('global_wiki').' - '.lang('labels_main').' '.lang('labels_page'));
		
		// set the input data
		$data['inputs'] = array(
			'search' => array(
				'name' => 'input',
				'id' => 'input',
				'placeholder' => ucwords(lang('actions_search').' '.lang('global_wiki').' '.lang('labels_pages'))),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'search',
				'value' => 'search',
				'content' => ucwords(lang('actions_search')))
		);
		
		$data['component'] = array(
			'title' => ucwords(lang('labels_title')),
			'content' => ucwords(lang('labels_content')),
		);
		
		$data['label'] = array(
			'type' => ucwords(lang('labels_type')),
			'search_in' => ucwords(lang('actions_search').' '.lang('labels_in')),
			'search_for' => ucwords(lang('actions_search').' '.lang('labels_for')),
			'search' => ucfirst(lang('actions_search')),
		);
		
		$data['images'] = array(
			'search' => array(
				'src' => Location::img('magnifier.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_search'))),
		);
		
		$this->_regions['content'] = Location::view('wiki_index', $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_index_js', $this->skin, 'wiki');
		$this->_regions['title'].= $pagetitle;
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function categories()
	{
		// check the user's access
		$data['access'] = (Auth::is_logged_in()) ? Auth::check_access('wiki/categories', false) : false;
		
		// pull the system page
		$syspage = $this->wiki->get_system_page('categories');
		
		// send the system page to the view
		$data['title'] = $syspage->draft_title;
		$data['syspage'] = $syspage->draft_content;
		
		// grab the categories
		$categories = $this->wiki->get_categories();
		
		// create the uncategorized item first
		$data['categories'][0] = ucfirst(lang('labels_uncategorized'));
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $c)
			{
				$data['categories'][$c->wikicat_id] = $c->wikicat_name;
			}
		}
		
		// set the header
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
		
		$this->_regions['content'] = Location::view('wiki_categories', $this->skin, 'wiki', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function category($id = 0)
	{
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		// get the category name
		$category = $this->wiki->get_category($id, 'wikicat_name');
		$category = ($category === false) ? ucfirst(lang('labels_uncategorized')) : $category;
		
		// grab the pages
		$pages = $this->wiki->get_pages($id);
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $p)
			{
				if ($p->page_type == 'standard')
				{
					$data['pages'][$p->page_id]['id'] = $p->page_id;
					$data['pages'][$p->page_id]['title'] = $p->draft_title;
					$data['pages'][$p->page_id]['author'] = $this->char->get_character_name($p->draft_author_character, true, true, true);
					$data['pages'][$p->page_id]['summary'] = $p->draft_summary;
				}
			}
		}
		
		// set the header
		$data['header'] = ucfirst(lang('labels_category')) .' - '. $category;
		
		$data['label'] = array(
			'nopages' => sprintf(
				lang('error_not_found'),
				lang('global_wiki') .' '. lang('labels_pages')
			),
		);
		
		// pull the system page
		$syspage = $this->wiki->get_system_page('category');
		
		// send the system page to the view
		$data['syspage'] = $syspage->draft_content;
		
		$this->_regions['content'] = Location::view('wiki_category', $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_category_js', $this->skin, 'wiki');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	/**
	 * Error page that used by the new page restriction code.
	 *
	 * 1 - This is a restricted wiki page that you are not authorized to view
	 * 2 - This draft is associated with a restricted wiki page that you are not authorized to view
	 * 3 - You do not have permissions to view old drafts
	 *
	 * @since	2.0
	 * @param	integer	the error code
	 * @return	void
	 */
	public function error($code = 0)
	{
		// sanity check
		$code = (is_numeric($code)) ? $code : false;
		
		// set the header
		$data['header'] = ucfirst(lang('error_pagetitle'));
		
		// build the error message
		$data['message'] = sprintf(
			lang('error_wiki_'.$code),
			lang('global_game_master')
		);
		
		$this->_regions['content'] = Location::view('wiki_error', $this->skin, 'wiki', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function managecategories()
	{
		Auth::check_access('wiki/categories');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'wikicat_name' => $this->input->post('name', true),
						'wikicat_desc' => $this->input->post('desc', true),
					);
					
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
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
				
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
				break;
					
				case 'edit':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					$update_array = array(
						'wikicat_name' => $this->input->post('name', true),
						'wikicat_desc' => $this->input->post('desc', true)
					);
					
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
				break;
			}
			
			// write the flash message to its region
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'wiki', $flash);
		}
		
		// grab the categories
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
				'src' => Location::img('icon-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'wiki'),
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'wiki'),
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
			'add' => ucwords(lang('actions_add').' '.lang('global_wiki').' '.lang('labels_category') .' '. RARROW),
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
		
		$this->_regions['content'] = Location::view('wiki_managecats', $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_managecats_js', $this->skin, 'wiki');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function managepages()
	{
		Auth::check_access('wiki/page');
		
		if (isset($_POST['submit']))
		{
			$level = Auth::get_access_level('wiki/page');
			
			if ($level == 3)
			{
				switch ($this->uri->segment(3))
				{
					case 'deletepage':
						$id = $this->input->post('id', true);
					
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
					break;
					
					case 'deletedraft':
						$id = $this->input->post('id', true);
					
						$delete = $this->wiki->delete_draft($id);
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('global_wiki') .' '. lang('labels_draft')),
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
								ucfirst(lang('global_wiki') .' '. lang('labels_draft')),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					break;
					
					case 'cleanup':
						// get the timeframe
						$timeframe = $this->input->post('time');
						
						// calculate the date we need to use
						$threshold = (is_numeric($timeframe)) ? now() - ($timeframe * 86400) : false;
						
						// start by getting all the pages
						$pages = $this->wiki->get_pages();
						
						// set the delete start number
						$delete = 0;
						
						if ($pages->num_rows() > 0)
						{
							// create an array for storing the "safe" drafts
							$safe = array();
							
							foreach ($pages->result() as $p)
							{
								// get a list of all the "safe" drafts
								$safe[] = $p->page_draft;
							}
							
							// get all the drafts
							$drafts = $this->wiki->get_drafts(NULL);
							
							if ($drafts->num_rows() > 0)
							{
								foreach ($drafts->result() as $d)
								{
									if ( ! in_array($d->draft_id, $safe))
									{
										if ($timeframe == 'all')
										{
											$delete += $this->wiki->delete_draft($d->draft_id);
										}
										else
										{
											if ($d->draft_created_at < $threshold)
											{
												$delete += $this->wiki->delete_draft($d->draft_id);
											}
										}
									}
								}
							}
						}
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success_plural'),
								$delete.' '.lang('global_wiki') .' '. lang('labels_drafts'),
								lang('actions_removed'),
								''
							);
	
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);
						}
						else
						{
							$message = sprintf(
								lang('flash_success_plural'),
								$delete.' '.lang('global_wiki') .' '. lang('labels_drafts'),
								lang('actions_removed'),
								''
							);
	
							$flash['status'] = 'info';
							$flash['message'] = text_output($message);
						}
					break;
					
					case 'revert':
						// get the POST variables
						$page = $this->input->post('page', true);
						$draft = $this->input->post('draft', true);
						
						// get the draft we're reverting to
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
							
							// optimize the table
							$this->sys->optimize_table('wiki_drafts');
							
							$update_array = array(
								'page_draft' => $draftid,
								'page_updated_by_user' => $this->session->userdata('userid'),
								'page_updated_by_character' => $this->session->userdata('main_char'),
								'page_updated_at' => now()
							);
							
							$update = $this->wiki->update_page($page, $update_array);
							
							if ($insert > 0 and $update > 0)
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
					break;
				}
				
				// set the region
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'wiki', $flash);
			}
		}
		
		// grab the pages
		$pages = $this->wiki->get_pages(NULL, 'wiki_drafts.draft_created_at', 'desc');
		
		// get all the page restrictions
		$restr = $this->wiki->get_page_restrictions();
		
		// set up the restrictions array
		$restrictions = array();
		
		if ($restr->num_rows() > 0)
		{
			foreach ($restr->result() as $r)
			{
				$restrictions[] = $r->restr_page;
			}
		}
		
		// set the date format
		$datestring = $this->options['date_format'];
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $p)
			{
				// set the date
				$created = gmt_to_local($p->page_created_at, $this->timezone, $this->dst);
				$updated = gmt_to_local($p->page_updated_at, $this->timezone, $this->dst);
			
				$data['pages'][$p->page_id]['id'] = $p->page_id;
				$data['pages'][$p->page_id]['title'] = $p->draft_title;
				$data['pages'][$p->page_id]['type'] = $p->page_type;
				$data['pages'][$p->page_id]['created'] = ($p->page_created_by_user == 0) 
					? ucfirst(lang('labels_system')) 
					: $this->char->get_character_name($p->page_created_by_character, true, false, true);
				$data['pages'][$p->page_id]['updated'] = ( ! empty($p->page_updated_by_character)) 
					? $this->char->get_character_name($p->page_updated_by_character, true, false, true) 
					: false;
				$data['pages'][$p->page_id]['created_date'] = mdate($datestring, $created);
				$data['pages'][$p->page_id]['updated_date'] = mdate($datestring, $updated);
				$data['pages'][$p->page_id]['restrictions'] = (in_array($p->page_id, $restrictions)) ? 'restricted' : false;
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage').' '.lang('global_wiki').' '.lang('labels_pages'));
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image subnav-icon'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_edit'))),
			'clean' => array(
				'src' => Location::img('broom.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image subnav-icon'),
			'history' => array(
				'src' => Location::img('clock-history.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_history'))),
			'lock' => array(
				'src' => Location::img('lock.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_restrictions'))),
			'info' => array(
				'src' => Location::img('information.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_information'))),
			'view' => array(
				'src' => Location::img('magnifier.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_view'))),
			'eye' => array(
				'src' => Location::img('eye.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image subnav-icon-right'),
			'loading' => array(
				'src' => Location::img('loading.gif', $this->skin, 'wiki'),
				'alt' => lang('actions_loading')),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('status_new').' '.lang('labels_page')),
			'clean' => ucwords(lang('actions_cleanup').' '.lang('labels_drafts')),
			'created' => ucfirst(lang('actions_created') .' '. lang('labels_by')),
			'loading' => ucfirst(lang('actions_loading')).'...',
			'name' => ucwords(lang('labels_page') .' '. lang('labels_name')),
			'nopages' => sprintf(lang('error_not_found'), lang('global_wiki').' '.lang('labels_pages')),
			'on' => lang('labels_on'),
			'pages' => ucfirst(lang('labels_pages')),
			'restrict'=> ucfirst(lang('labels_restricted')),
			'restrict_label_help'=> lang('wiki_restrict_label_help'),
			'restrict_label_help_title' => lang('wiki_restrict_page_help_title'),
			'show' => ucwords(lang('actions_show').' '.lang('labels_filters')),
			'show_all' => ucfirst(lang('labels_all')),
			'show_std' => ucfirst(lang('labels_standard')),
			'system' => ucfirst(lang('labels_system')),
			'system_label_help' => lang('wiki_system_label_help'),
			'system_label_help_title' => lang('wiki_system_page_help_title'),
			'updated' => ucfirst(lang('order_last').' '.lang('actions_updated').' '.lang('labels_by')),
		);
		
		$this->_regions['content'] = Location::view('wiki_managepages', $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_managepages_js', $this->skin, 'wiki');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function page($id = 0)
	{
		Auth::check_access('wiki/page');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(4))
			{
				case 'create':
					$page_array = array(
						'page_created_at' => now(),
						'page_created_by_user' => $this->session->userdata('userid'),
						'page_created_by_character' => $this->session->userdata('main_char'),
						'page_comments' => $this->input->post('comments', true)
					);
					
					$insert = $this->wiki->create_page($page_array);
					$pageid = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('wiki_pages');
					
					$categories = (isset($_POST['categories'])) ? explode(',', $_POST['categories']) : array();
					
					foreach ($categories as $key => $c)
					{
						if (empty($c))
						{
							unset($categories[$key]);
						}
					}
					
					$categories = implode(',', $categories);
					
					// create the array of draft data
					$draft_array = array(
						'draft_author_user' => $this->session->userdata('userid'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', true),
						'draft_title' => $this->input->post('title', true),
						'draft_created_at' => now(),
						'draft_page' => $pageid,
						'draft_categories' => $categories,
						'draft_summary' => $this->input->post('summary', true),
					);
					
					// put the draft information into the database
					$insert += $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('wiki_drafts');
					
					// update the page with the draft ID
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
					$categories = (isset($_POST['categories'])) ? explode(',', $_POST['categories']) : array();
					
					foreach ($categories as $key => $c)
					{
						if (empty($c))
						{
							unset($categories[$key]);
						}
					}
					
					$categories = implode(',', $categories);
					
					// create the array of draft data
					$draft_array = array(
						'draft_author_user' => $this->session->userdata('userid'),
						'draft_author_character' => $this->session->userdata('main_char'),
						'draft_content' => $this->input->post('content', true),
						'draft_title' => $this->input->post('title', true),
						'draft_created_at' => now(),
						'draft_page' => $id,
						'draft_categories' => $categories,
						'draft_summary' => $this->input->post('summary', true),
						'draft_changed_comments' => $this->input->post('changes', true),
					);
					
					// put the draft information into the database
					$insert = $this->wiki->create_draft($draft_array);
					$draftid = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('wiki_drafts');
					
					// get the comments item
					$comments = $this->input->post('comments', true);
					
					// create the array of page data
					$page_array = array(
						'page_updated_at' => now(),
						'page_updated_by_user' => $this->session->userdata('userid'),
						'page_updated_by_character' => $this->session->userdata('main_char'),
						'page_comments' => ($comments === false) ? 'closed' : $comments,
						'page_draft' => $draftid
					);
					
					// put the page information into the database
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
			
			// set the region
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'wiki', $flash);
		}
		
		if ($id == 0)
		{
			// set the field information
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
					'checked' => true),
				'comments_closed' => array(
					'name' => 'comments',
					'id' => 'comments_closed',
					'value' => 'closed'),
				'summary' => array(
					'name' => 'summary',
					'id' => 'summary',
					'class' => 'full-width',
					'rows' => 2),
				'categories' => '',
				'category_string' => '',
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
			
			// set the header
			$data['header'] = ucwords(lang('actions_create') .' '. lang('global_wiki') .' '. lang('labels_page'));
			
			// set the view location
			$view_loc = 'wiki_page_create';
		}
		else
		{
			// grab the page information and latest draft
			$page = $this->wiki->get_page($id);
			
			if ($page->num_rows() > 0)
			{
				foreach ($page->result() as $p)
				{
					$data['inputs'] = array(
						'title' => array(
							'name' => 'title',
							'id' => 'title',
							'value' => ( ! empty($p->draft_title)) ? $p->draft_title : ''),
						'content' => array(
							'name' => 'content',
							'id' => 'content',
							'class' => 'markitup',
							'rows' => 30,
							'value' => ( ! empty($p->draft_content)) ? $p->draft_content : ''),
						'comments_open' => array(
							'name' => 'comments',
							'id' => 'comments_open',
							'value' => 'open',
							'checked' => ($p->page_comments == 'open') ? true : false),
						'comments_closed' => array(
							'name' => 'comments',
							'id' => 'comments_closed',
							'value' => 'closed',
							'checked' => ($p->page_comments == 'closed') ? true : false),
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
							'value' => ( ! empty($p->draft_summary)) ? $p->draft_summary : ''),
						'categories' => ( ! empty($p->draft_categories)) ? explode(',', $p->draft_categories) : '',
						'category_string' => ( ! empty($p->draft_categories)) ? $p->draft_categories : '',
					);
				}
			}
			
			// set the id
			$data['id'] = $id;
			
			// what type of page is it?
			$data['type'] = $p->page_type;
			
			// build the category list
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
						'checked' => (in_array($c->wikicat_id, $cats)) ? true : false,
					);
				}
			}
			
			// set the header
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_wiki') .' '. lang('labels_page'));
			
			// set the view file location
			$view_loc = 'wiki_page_edit';
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
			'addcategory' => ucwords(lang('actions_add').' '.lang('labels_categories').'...'),
			'back' => LARROW .' '. ucwords(lang('actions_manage') .' '. lang('global_wiki') .' '. lang('labels_pages')),
			'categories' => ucfirst(lang('labels_categories')),
			'changes' => ucfirst(lang('actions_changes')),
			'closed' => ucfirst(lang('status_closed')),
			'comments' => ucfirst(lang('labels_comments')),
			'open' => ucfirst(lang('status_open')),
			'pleaseadd' => sprintf(lang('wiki_add_categories'), lang('labels_categories')),
			'pleaseadd_supp' => sprintf(lang('wiki_add_categories_supp'), lang('labels_category')),
			'summary' => ucfirst(lang('labels_summary')),
			'title' => ucfirst(lang('labels_title')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_page_js', $this->skin, 'wiki');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function recent($type = 'updates')
	{
		switch ($type)
		{
			case 'updates':
			default:
				// grab the recently updated items
				$updated = $this->wiki->get_recently_updated(100);
				
				if ($updated->num_rows() > 0)
				{
					foreach ($updated->result() as $u)
					{
						$data['recent']['updates'][] = array(
							'id' => $u->page_id,
							'title' => $u->draft_title,
							'author' => $this->char->get_character_name($u->page_updated_by_character, true, false, true),
							'timespan' => timespan_short($u->page_updated_at, now()),
							'comments' => $u->draft_changed_comments,
							'type' => $u->page_type,
						);
					}
				}
				
				$data['header'] = ucwords(lang('global_wiki') .' - '. lang('status_recently') .' '. lang('actions_updated'));
			break;
				
			case 'created':
				// grab the recently created items
				$created = $this->wiki->get_recently_created(100);
				
				if ($created->num_rows() > 0)
				{
					foreach ($created->result() as $c)
					{
						$data['recent']['created'][] = array(
							'id' => $c->page_id,
							'title' => $c->draft_title,
							'author' => $this->char->get_character_name($c->page_created_by_character, true, false, true),
							'timespan' => timespan_short($c->page_created_at, now()),
							'summary' => $c->draft_summary,
							'type' => $c->page_type,
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
			'system' => ucfirst(lang('labels_system')),
			'update_summary' => ucwords(lang('actions_update') .' '. lang('labels_summary')),
		);
		
		$data['images'] = array(
			'feed' => array(
				'src' => Location::img('feed.png', $this->skin, 'wiki'),
				'alt' => ''),
		);
		
		$this->_regions['content'] = Location::view('wiki_recent', $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_recent_js', $this->skin, 'wiki');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function view($type= 'page', $id = 0, $action = false)
	{
		// check to see if they have access
		$access = (Auth::is_logged_in()) ? Auth::check_access('wiki/page', false) : false;
		$data['access'] = $access;
		
		// get the access level
		$level = (Auth::is_logged_in()) ? Auth::get_access_level('wiki/page') : false;
		$data['level'] = $level;
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		// assign the config array to a variable
		$c = $this->config->item('thresher');
		
		// load the library and pass the config items in
		$this->load->library('thresher', $c);
		
		if (isset($_POST['submit']) and Auth::is_logged_in())
		{
			if ($action == 'comment')
			{
				$comment_text = $this->input->post('comment_text');
				
				if ( ! empty($comment_text))
				{
					$status = $this->user->checking_moderation('wiki_comment', $this->session->userdata('userid'));
					
					$insert = array(
						'wcomment_content' => $comment_text,
						'wcomment_page' => $id,
						'wcomment_date' => now(),
						'wcomment_author_character' => $this->session->userdata('main_char'),
						'wcomment_author_user' => $this->session->userdata('userid'),
						'wcomment_status' => $status
					);
					
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
						$email = ($this->options['system_email'] == 'on') ? $this->_email($emailaction, $email_data) : false;
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
				
				// set the region
				$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'wiki', $flash);
			}
		}
		
		switch ($action)
		{
			case 'comment':
				$js_data['tab'] = 2;
			break;
				
			default:
				$js_data['tab'] = 0;
			break;
		}
		
		// set the date format
		$datestring = $this->options['date_format'];
		
		if ($type == 'draft')
		{
			if ($access)
			{
				// grab the information about the page
				$draft = $this->wiki->get_draft($id);
				
				// get the draft object
				$d = ($draft->num_rows() > 0) ? $draft->row() : false;
				
				if ($d !== false)
				{
					// check page restrictions
					$restrict = $this->wiki->get_page_restrictions($d->draft_page);
					
					if ($restrict->num_rows() > 0)
					{
						// get the row that contains the data
						$r = $restrict->row();
						
						// make an array of the restrictions
						$allowed = explode(',', $r->restrictions);
						
						if ($level < 3)
						{
							if ( ! Auth::is_logged_in() or ! in_array($this->session->userdata('role'), $allowed))
							{
								redirect('wiki/error/2');
							}
						}
					}
					
					// set the date
					$created = gmt_to_local($d->draft_created_at, $this->timezone, $this->dst);
					
					$data['header'] = ucfirst(lang('labels_draft')) .' - '. $d->draft_title;
					
					$count = substr_count($d->draft_categories, ',');
					
					if ($count === 0 and empty($d->draft_categories))
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
						'created' => $this->char->get_character_name($d->draft_author_character, true, false, true),
						'created_date' => mdate($datestring, $created),
						'page' => $d->draft_page,
						'categories' => $string,
					);
				}
				
				// set the view location
				$view_loc = 'wiki_view_draft';
			}
			else
			{
				redirect('wiki/error/3');
			}
		}
		else
		{
			// check page restrictions
			$restrict = $this->wiki->get_page_restrictions($id);
			
			if ($restrict->num_rows() > 0)
			{
				// get the row that contains the data
				$r = $restrict->row();
				
				// make an array of the restrictions
				$allowed = explode(',', $r->restrictions);
				
				if ($level < 3)
				{
					if ( ! Auth::is_logged_in() or ! in_array($this->session->userdata('role'), $allowed))
					{
						redirect('wiki/error/1');
					}
				}
			}
			
			$data['id'] = $id;
			
			/*
			|---------------------------------------------------------------
			| PAGE
			|---------------------------------------------------------------
			*/
			
			// grab the information about the page
			$page = $this->wiki->get_page($id);
			
			// empty variables to catch errors
			$data['header'] = '';
			
			if ($page->num_rows() > 0)
			{
				// get the row
				$p = $page->row();
				
				// set the date
				$created = gmt_to_local($p->page_created_at, $this->timezone, $this->dst);
				$updated = gmt_to_local($p->page_updated_at, $this->timezone, $this->dst);
				
				$data['header'] = $p->draft_title;

				$count = substr_count($p->draft_categories, ',');
				
				if ($count === 0 and empty($p->draft_categories))
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
					'created' => ($p->page_created_by_character != 0) 
						? $this->char->get_character_name($p->page_created_by_character, true, false, true)
						: ucfirst(lang('labels_system')),
					'updated' => ( ! empty($p->page_updated_by_character)) ? $this->char->get_character_name($p->page_updated_by_character, true, false, true) : false,
					'created_date' => mdate($datestring, $created),
					'updated_date' => mdate($datestring, $updated),
					'categories' => $string,
					'summary' => $p->draft_summary,
				);
				
				// pass the type of page to the js view
				$js_data['type'] = $p->page_type;
			}
			
			if (Auth::is_logged_in())
			{
				if ($level == 3 or $level == 2 or ($level == 1 and (is_object($p) and $p->page_created_by_user == $this->session->userdata('userid'))))
				{
					$data['edit'] = true;
				}
				else
				{
					$data['edit'] = false;
				}
			}
			else
			{
				$data['edit'] = false;
			}
			
			/*
			|---------------------------------------------------------------
			| HISTORY
			|---------------------------------------------------------------
			*/
			
			// grab the information about the page
			$drafts = $this->wiki->get_drafts($id);
			
			if ($drafts->num_rows() > 0)
			{
				foreach ($drafts->result() as $d)
				{
					$created = gmt_to_local($d->draft_created_at, $this->timezone, $this->dst);
					
					$page = $this->wiki->get_page($d->draft_page);
					$row = ($page->num_rows() > 0) ? $page->row() : false;
					
					$data['history'][$d->draft_id] = array(
						'draft' => $d->draft_id,
						'title' => $d->draft_title,
						'content' => $this->thresher->parse($d->draft_content),
						'created' => ($d->draft_author_character != 0) 
							? $this->char->get_character_name($d->draft_author_character, false, false, true) 
							: ucfirst(lang('labels_system')),
						'created_date' => mdate($datestring, $created),
						'old_id' => ( ! empty($d->draft_id_old)) ? $d->draft_id_old : false,
						'page' => $d->draft_page,
						'changes' => $d->draft_changed_comments,
						'page_draft' => ($row !== false) ? $row->page_draft : false,
					);
				}
			}
			
			/*
			|---------------------------------------------------------------
			| COMMENTS
			|---------------------------------------------------------------
			*/
			
			// get all the comments
			$comments = $this->wiki->get_comments($id);
			
			if ($comments->num_rows() > 0)
			{
				foreach ($comments->result() as $cm)
				{
					$date = gmt_to_local($cm->wcomment_date, $this->timezone, $this->dst);
					
					$data['comments'][$cm->wcomment_id]['author'] = $this->char->get_character_name($cm->wcomment_author_character, true, false, true);
					$data['comments'][$cm->wcomment_id]['content'] = $cm->wcomment_content;
					$data['comments'][$cm->wcomment_id]['date'] = mdate($datestring, $date);
				}
			}
			
			$data['comment_count'] = $comments->num_rows();
			
			// set the view location
			$view_loc = 'wiki_view_page';
		}
		
		$data['images'] = array(
			'view' => array(
				'src' => Location::img('magnifier.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('actions_view'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image subnav-icon'),
			'comment' => array(
				'src' => Location::img('comment-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'class' => 'image subnav-icon'),
			'page' => array(
				'src' => Location::img('page.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_page'))),
			'history' => array(
				'src' => Location::img('clock-history.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_history'))),
			'comments' => array(
				'src' => Location::img('comment-add.png', $this->skin, 'wiki'),
				'alt' => '',
				'title' => ucfirst(lang('labels_comments'))),
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
			'edit' => ucfirst(lang('actions_edit')),
			'history' => ucfirst(lang('labels_history')),
			'nocomments' => sprintf(
				lang('error_not_found'),
				lang('labels_comments')
			),
			'nodraft' => sprintf(
				lang('error_not_found'),
				lang('labels_page') .' '. lang('labels_draft')
			),
			'nohistory' => sprintf(
				lang('error_not_found'),
				lang('labels_page') .' '. lang('labels_history')
			),
			'nopage' => sprintf(
				lang('error_not_found'),
				lang('labels_page')
			),
			'on' => lang('labels_on'),
			'page' => ucfirst(lang('labels_page')),
			'reverted' => lang('actions_reverted'),
			'to' => lang('labels_to'),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'wiki', $data);
		$this->_regions['javascript'] = Location::js('wiki_view_js', $this->skin, 'wiki', $js_data);
		$this->_regions['title'].= ucfirst(lang('global_wiki')).' - '.$data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _email($type, $data)
	{
		// load the libraries
		$this->load->library('email');
		$this->load->library('parser');
		
		$email = false;
		
		// run the methods
		$page = $this->wiki->get_page($data['page']);
		$row = $page->row();
		$name = $this->char->get_character_name($data['author']);
		$from = $this->user->get_email_address('character', $data['author']);
		
		switch ($type)
		{
			case 'comment':
				// get all the contributors of a wiki page
				$cont = $this->wiki->get_all_contributors($data['page']);
				
				foreach ($cont as $c)
				{
					$pref = $this->user->get_pref('email_new_wiki_comments', $c);
					
					if ($pref == 'y')
					{
						$to_array[] = $this->user->get_email_address('user', $c);
					}
				}
				
				// set the to string
				$to = implode(',', $to_array);
				
				// set the content
				$content = sprintf(
					lang('email_content_wiki_comment_added'),
					"<strong>". $row->draft_title ."</strong>",
					$data['comment']
				);
				
				// create the array passing the data to the email
				$email_data = array(
					'email_subject' => lang('email_subject_wiki_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('wiki_comment', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'comment_pending':
				// run the methods
				$to = implode(',', $this->user->get_emails_with_access('manage/comments'));
				
				// set the content
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_wiki'),
					"<strong>". $row->draft_title ."</strong>",
					$data['comment'],
					site_url('login/index')
				);
				
				// create the array passing the data to the email
				$email_data = array(
					'email_subject' => lang('email_subject_comment_pending'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from */
				$em_loc = Location::email('comment_pending', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
		}
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
}
