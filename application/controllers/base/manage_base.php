<?php
/*
|---------------------------------------------------------------
| ADMIN - MANAGE CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/manage_base.php
| System Version: 1.0
|
| Controller that handles the MANAGE section of the admin system.
|
*/

class Manage_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Manage_base()
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
		$this->auth->is_logged_in(TRUE);
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_admin',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'system_email',
			'post_count_format'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_admin'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_admin');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_template('admin');
		$this->template->set_master_template($this->skin .'/template_admin.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('adminsub', 'manage'), TRUE);
		$this->template->write('panel_1', $this->user_panel->panel_1(), TRUE);
		$this->template->write('panel_2', $this->user_panel->panel_2(), TRUE);
		$this->template->write('panel_3', $this->user_panel->panel_3(), TRUE);
		$this->template->write('panel_workflow', $this->user_panel->panel_workflow(), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
	}

	function index()
	{
		/* nothing goes here... */
	}
	
	function awards()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		
		/* set the variables */
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'award_name' => $this->input->post('award_name', TRUE),
						'award_order' => $this->input->post('award_order', TRUE),
						'award_display' => $this->input->post('award_display', TRUE),
						'award_cat' => $this->input->post('award_cat', TRUE),
						'award_desc' => $this->input->post('award_desc', TRUE),
						'award_image' => $this->input->post('award_image', TRUE),
					);
					
					/* insert the record */
					$insert = $this->awards->add_award($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_award')),
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
							ucfirst(lang('global_award')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->awards->delete_award($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_award')),
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
							ucfirst(lang('global_award')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 6) == 'award_')
						{
							$award[$key] = $value;
						}
					}
					
					$update = $this->awards->update_award($id, $award);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_award')),
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
							ucfirst(lang('global_award')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		if ($action == 'add' || $action == 'edit')
		{
			$item = ($action == 'edit') ? $this->sys->get_item('awards', 'award_id', $id) : FALSE;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_award'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->award_name : '';
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'award_name',
					'value' => ($item === FALSE) ? '' : $item->award_name),
				'order' => array(
					'name' => 'award_order',
					'class' => 'small',
					'value' => ($item === FALSE) ? 99 : $item->award_order),
				'desc' => array(
					'name' => 'award_desc',
					'rows' => 10,
					'value' => ($item === FALSE) ? '' : $item->award_desc),
				'images' => array(
					'name' => 'award_image',
					'id' => 'images',
					'value' => ($action == 'edit') ? $item->award_image : ''),
				'display_y' => array(
					'name' => 'award_display',
					'id' => 'display_y',
					'value' => 'y',
					'checked' => ($item !== FALSE && $item->award_display == 'y') ? TRUE : FALSE),
				'display_n' => array(
					'name' => 'award_display',
					'id' => 'display_n',
					'value' => 'n',
					'checked' => ($item !== FALSE && $item->award_display == 'n') ? TRUE : FALSE),
				'cat' => ($item === FALSE) ? '' : $item->award_cat,
				'submit' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			$data['values']['cat'] = array(
				'ic' => ucwords(lang('labels_ic')),
				'ooc' => ucwords(lang('labels_ooc')),
				'both' => ucfirst(lang('labels_both'))
			);
			
			$data['values']['display'] = array(
				'y' => ucwords(lang('labels_yes')),
				'n' => ucwords(lang('labels_no')),
			);
			
			$data['directory'] = array();
		
			$dir = $this->sys->get_uploaded_images('award');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					$data['directory'][$d->upload_id] = array(
						'image' => array(
							'src' => asset_location('images/awards', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = view_location('manage_awards_action', $this->skin, 'admin');
		}
		else
		{
			/* grab all the awards from the database */
			$awards = $this->awards->get_all_awards('asc', '');
			
			if ($awards->num_rows() > 0)
			{
				foreach ($awards->result() as $a)
				{
					$data['awards'][$a->award_id] = array(
						'id' => $a->award_id,
						'img' => array(
							'src' => asset_location('images/awards', $a->award_image),
							'alt' => $a->award_name,
							'class' => 'image'),
						'name' => $a->award_name,
						'delete' => array(
							'name' => 'delete[]',
							'value' => $a->award_id,
							'id' => $a->award_id .'_id'),
						'desc' => $a->award_desc,
					);
				}
			}
			
			$data['header'] = ucfirst(lang('global_awards'));
			
			$view_loc = view_location('manage_awards', $this->skin, 'admin');
		}
		
		/* figure out where the view should be coming from */
		$js_loc = js_location('manage_awards_js', $this->skin, 'admin');
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('award-add.png', $this->skin, 'admin'),
				'alt' => ''),
			'delete' => array(
				'src' => img_location('award-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => img_location('award-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_add'))),
			'upload' => array(
				'src' => img_location('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
		);
		
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('global_award')
		);
		
		$data['label'] = array(
			'addaward' => ucwords(lang('actions_add') .' '. lang('global_award') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'delete' => ucfirst(lang('actions_delete')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'more' => ucfirst(lang('labels_more')),
			'image' => ucfirst(lang('labels_image')),
			'category' => ucfirst(lang('labels_category')),
			'desc' => ucfirst(lang('labels_desc')),
			'info' => ucfirst(lang('labels_info')),
			'images' => ucfirst(lang('labels_images')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucfirst(lang('global_awards')),
			'cat' => ucfirst(lang('labels_category')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function comments()
	{
		$this->auth->check_access();
		
		$types = array('posts', 'logs', 'news', 'wiki');
		$values = array('activated', 'pending', 'edit');
		$type = $this->uri->segment(3, 'posts', FALSE, $types);
		$section = $this->uri->segment(4, 'activated', FALSE, $values);
		$offset = $this->uri->segment(5, 0, TRUE);
		
		/* load the resources */
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('news_model', 'news');
		$this->load->model('wiki_model', 'wiki');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(6))
			{
				case 'approve':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					switch ($type)
					{
						case 'posts':
							$approve_array = array('pcomment_status' => 'activated');
							
							$approve = $this->posts->update_post_comment($id, $approve_array);
							$item = ucfirst(lang('global_missionpost'));
							
							$row = $this->posts->get_post_comment($id);
							
							$email_type = 'post_comment';
							
							$email_data = array(
								'author' => $row->pcomment_author_character,
								'post' => $row->pcomment_post,
								'comment' => $row->pcomment_content
							);
							
							break;
							
						case 'logs':
							$approve_array = array('lcomment_status' => 'activated');
							
							$approve = $this->logs->update_log_comment($id, $approve_array);
							$item = ucfirst(lang('global_personallog'));
							
							$row = $this->logs->get_log_comment($id);
							
							$email_type = 'log_comment';
							
							$email_data = array(
								'author' => $row->lcomment_author_character,
								'log' => $row->lcomment_log,
								'comment' => $row->lcomment_content
							);
							
							break;
							
						case 'news':
							$approve_array = array('ncomment_status' => 'activated');
							
							$approve = $this->news->update_news_comment($id, $approve_array);
							$item = ucfirst(lang('global_newsitem'));
							
							$row = $this->news->get_news_comment($id);
							
							$email_type = 'news_comment';
							
							$email_data = array(
								'author' => $row->ncomment_author_character,
								'news_item' => $row->ncomment_news,
								'comment' => $row->ncomment_content
							);
							
							break;
							
						case 'wiki':
							$approve_array = array('wcomment_status' => 'activated');
							
							$approve = $this->wiki->update_comment($id, $approve_array);
							$item = ucfirst(lang('global_wiki'));
							
							$row = $this->wiki->get_comment($id);
							
							$email_type = 'wiki_comment';
							
							$email_data = array(
								'author' => $row->wcomment_author_character,
								'page' => $row->wcomment_page,
								'comment' => $row->wcomment_content
							);
							
							break;
					}
					
					if ($approve > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							$item .' '. lang('labels_comment'),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email($email_type, $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							$item .' '. lang('labels_comment'),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					$delete = 0;
					
					switch ($type)
					{
						case 'posts':
							$delete = $this->posts->delete_post_comment($id);
							$item = ucfirst(lang('global_missionpost'));
							
							break;
							
						case 'logs':
							$delete = $this->logs->delete_log_comment($id);
							$item = ucfirst(lang('global_personllog'));
							
							break;
							
						case 'news':
							$delete = $this->news->delete_news_comment($id);
							$item = ucfirst(lang('global_newsitem'));
							
							break;
							
						case 'wiki':
							$delete = $this->wiki->delete_comment($id);
							$item = ucfirst(lang('global_wiki'));
							
							break;
					}
					
					$id = FALSE;
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							$item .' '. lang('labels_comment'),
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
							$item .' '. lang('labels_comment'),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
					
				case 'edit':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					$delete = 0;
					
					switch ($type)
					{
						case 'posts':
							$update_array = array('pcomment_content' => $this->input->post('pcomment_content', TRUE));
							
							$update = $this->posts->update_post_comment($id, $update_array);
							$item = ucfirst(lang('global_missionpost'));
							
							break;
							
						case 'logs':
							$update_array = array('lcomment_content' => $this->input->post('lcomment_content', TRUE));
							
							$update = $this->logs->update_log_comment($id, $update_array);
							$item = ucfirst(lang('global_personllog'));
							
							break;
							
						case 'news':
							$update_array = array('ncomment_content' => $this->input->post('ncomment_content', TRUE));
							
							$update = $this->news->update_news_comment($id, $update_array);
							$item = ucfirst(lang('global_newsitem'));
							
							break;
							
						case 'wiki':
							$update_array = array('wcomment_content' => $this->input->post('wcomment_content', TRUE));
							
							$update = $this->wiki->update_comment($id, $update_array);
							$item = ucfirst(lang('global_wiki'));
							
							break;
					}
					
					$id = FALSE;
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							$item .' '. lang('labels_comment'),
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
							$item .' '. lang('labels_comment'),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					break;
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		$p_activated = ($section == 'activated' && $type == 'posts') ? $offset : 0;
		$p_pending = ($section == 'pending' && $type == 'posts') ? $offset : 0;
		
		$l_activated = ($section == 'activated' && $type == 'logs') ? $offset : 0;
		$l_pending = ($section == 'pending' && $type == 'logs') ? $offset : 0;
		
		$n_activated = ($section == 'activated' && $type == 'news') ? $offset : 0;
		$n_pending = ($section == 'pending' && $type == 'news') ? $offset : 0;
		
		$w_activated = ($section == 'activated' && $type == 'wiki') ? $offset : 0;
		$w_pending = ($section == 'pending' && $type == 'wiki') ? $offset : 0;
		
		$data['posts'] = array(
			'activated' => $this->_comments_ajax($p_activated, 'posts'),
			'pending' => $this->_comments_ajax($p_pending, 'posts', 'pending'),
		);
		$data['logs'] = array(
			'activated' => $this->_comments_ajax($l_activated, 'logs'),
			'pending' => $this->_comments_ajax($l_pending, 'logs', 'pending'),
		);
		$data['news'] = array(
			'activated' => $this->_comments_ajax($n_activated, 'news'),
			'pending' => $this->_comments_ajax($n_pending, 'news', 'pending'),
		);
		$data['wiki'] = array(
			'activated' => $this->_comments_ajax($w_activated, 'wiki'),
			'pending' => $this->_comments_ajax($w_pending, 'wiki', 'pending'),
		);
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('labels_comments'));
		
		$data['images'] = array(
			'loading' => array(
				'src' => img_location('loading-bar.gif', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
		);
		
		$data['label'] = array(
			'loading' => ucfirst(lang('actions_loading')) .'...',
			'activated' => ucfirst(lang('status_activated')),
			'pending' => ucfirst(lang('status_pending')),
			'posts' => ucwords(lang('global_post') .' '. lang('labels_comments')),
			'logs' => ucwords(lang('global_log') .' '. lang('labels_comments')),
			'news' => ucwords(lang('global_news') .' '. lang('labels_comments')),
			'wiki' => ucwords(lang('global_wiki') .' '. lang('labels_comments')),
		);
		
		switch ($type)
		{
			case 'posts':
				$js_data['type'] = 0;
				break;
				
			case 'logs':
				$js_data['type'] = 1;
				break;
				
			case 'news':
				$js_data['type'] = 2;
				break;
				
			case 'wiki':
				$js_data['type'] = 3;
				break;
				
			default:
				$js_data['type'] = 0;
		}
		
		$js_data['section'] = ($section == 'pending') ? 1 : 0;
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_comments', $this->skin, 'admin');
		$js_loc = js_location('manage_comments_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function decks()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		if (isset($_POST['submit']))
		{
			$name = $this->input->post('deck_name', TRUE);
			$content = $this->input->post('deck_content', TRUE);
			$id = $this->input->post('id', TRUE);
			
			$update_array = array(
				'deck_name' => $name,
				'deck_content' => $content
			);
			
			$update = $this->tour->update_deck($id, $update_array);
			
			if ($update > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_deck')),
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
					ucfirst(lang('global_deck')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		$decks = $this->tour->get_decks();
		
		if ($decks->num_rows() > 0)
		{
			foreach ($decks->result() as $deck)
			{
				$data['decks'][$deck->deck_id] = $deck->deck_name;
			}
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_decks', $this->skin, 'admin');
		$js_loc = js_location('manage_decks_js', $this->skin, 'admin');
		
		$data['header'] = ucwords(lang('global_deck') .' '. lang('labels_listing'));
		$data['text'] = sprintf(
			lang('text_manage_decks'),
			lang('global_deck'),
			lang('global_deck'),
			lang('global_deck')
		);
		
		$data['inputs']['deck'] = array(
			'name' => 'deck',
			'id' => 'deck'
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'content' => ucwords(lang('actions_update'))),
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'add',
				'id' => 'add',
				'content' => ucwords(lang('actions_add'))),
		);
		
		$data['loading'] = array(
			'src' => img_location('loading-bar.gif', $this->skin, 'admin'),
			'alt' => '',
			'class' => 'image'
		);
		
		$data['label'] = array(
			'processing' => ucfirst(lang('actions_processing')) .'...',
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function depts()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'dept_name' => $this->input->post('dept_name', TRUE),
						'dept_type' => $this->input->post('dept_type', TRUE),
						'dept_order' => $this->input->post('dept_order', TRUE),
						'dept_display' => $this->input->post('dept_display', TRUE),
						'dept_desc' => $this->input->post('dept_desc', TRUE),
						'dept_parent' => $this->input->post('dept_parent', TRUE),
					);
					
					/* insert the record */
					$insert = $this->dept->add_dept($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_department')),
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
							ucfirst(lang('global_department')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$array = array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== FALSE)
						{
							$loc_pos = substr($key, 0, $loc);
							
							$new_key = 'dept_'. substr($key, ($loc+1));
							$array[$loc_pos][$new_key] = $value;
						}
					}
					
					foreach ($array as $a => $b)
					{ /* update the positions */
						$update += $this->dept->update_dept($a, $b);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_departments')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_departments')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'delete':
					$all = $this->input->post('delete', TRUE);
					$deptid = $this->input->post('dept', TRUE);
					$id = $this->input->post('id', TRUE);
					$subdept = (isset($_POST['subdept'])) ? $this->input->post('subdept', TRUE) : FALSE;
					
					/* load the positions model */
					$this->load->model('positions_model', 'pos');
					
					/* grab the positions for the department */
					$positions = $this->pos->get_dept_positions($id, '');
					
					if ($all == 'y')
					{
						if ($positions->num_rows() > 0)
						{
							foreach ($positions->result() as $p)
							{
								$this->pos->delete_position($p->pos_id);
							}
						}
					}
					else
					{
						if ($positions->num_rows() > 0)
						{
							foreach ($positions->result() as $p)
							{
								$update = array('pos_dept' => $deptid);
								
								$this->pos->update_position($p->pos_id, $update);
							}
						}
					}
					
					if ($subdept !== FALSE)
					{
						$subs = $this->dept->get_sub_depts($id, 'asc', '');
						
						if ($subs->num_rows() > 0)
						{
							$where = array('dept_parent' => $subdept);
							
							foreach ($subs->result() as $sub)
							{
								$this->dept->update_dept($sub->dept_id, $where);
							}
						}
					}
					
					/* delete the department */
					$delete = $this->dept->delete_dept($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_department')),
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
							ucfirst(lang('global_department')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$departments = $this->dept->get_all_depts('asc', '');
		
		$data['parent'][0] = ucfirst(lang('labels_none'));
		
		if ($departments->num_rows() > 0)
		{
			foreach ($departments->result() as $department)
			{
				$dept[$department->dept_id] = $department->dept_name;
				$data['parent'][$department->dept_id] = $department->dept_name;
				
				$sub = $this->dept->get_sub_depts($department->dept_id, 'asc', '');
				
				if ($sub->num_rows() > 0)
				{
					foreach ($sub->result() as $s)
					{
						$dept[$s->dept_id] = $s->dept_name;
					}
				}
			}
			
			foreach ($dept as $key => $value)
			{
				$item = $this->dept->get_dept($key);
				
				if ($item !== FALSE)
				{
					$data['inputs'][$item->dept_id] = array(
						'name' => array(
							'name' => $item->dept_id .'_name',
							'id' => $item->dept_id .'_name',
							'value' => $item->dept_name
						),
						'desc' => array(
							'name' => $item->dept_id .'_desc',
							'id' => $item->dept_id .'_desc',
							'value' => $item->dept_desc,
							'rows' => 6
						),
						'order' => array(
							'name' => $item->dept_id .'_order',
							'id' => $item->dept_id .'_order',
							'value' => $item->dept_order,
							'class' => 'small'
						),
						'delete' => array(
							'name' => 'delete[]',
							'id' => $item->dept_id .'_id',
							'value' => $item->dept_id
						)
					);
					
					$data['values'][$item->dept_id]['display'] = array(
						'y' => ucwords(lang('labels_yes')),
						'n' => ucwords(lang('labels_no')),
					);
					
					$data['values'][$item->dept_id]['type'] = array(
						'playing' => ucwords(lang('status_playing')),
						'nonplaying' => ucwords(lang('status_nonplaying')),
					);
					
					$data['depts'][$item->dept_id]['id'] = $item->dept_id;
					$data['depts'][$item->dept_id]['display'] = $item->dept_display;
					$data['depts'][$item->dept_id]['type'] = $item->dept_type;
					$data['depts'][$item->dept_id]['parent'] = $item->dept_parent;
				}
			}
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_depts', $this->skin, 'admin');
		$js_loc = js_location('manage_depts_js', $this->skin, 'admin');
		
		$data['header'] = ucfirst(lang('global_departments'));
		$data['text'] = sprintf(
			lang('text_manage_depts'),
			lang('global_departments'),
			lang('global_positions'),
			lang('global_departments'),
			lang('global_department'),
			lang('global_departments')
		);
		
		$data['label'] = array(
			'add_dept' => ucwords(lang('actions_add') .' '.
				lang('global_department') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'delete' => ucfirst(lang('actions_delete')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'type' => ucfirst(lang('labels_type')),
			'desc' => ucfirst(lang('labels_desc')),
			'parent' => ucwords(lang('labels_parent') .' '. lang('global_department'))
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => ''),
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update'))),
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function logs()
	{
		$this->auth->check_access();
		
		$this->load->model('personallogs_model', 'logs');
		
		$values = array('activated', 'saved', 'pending', 'edit');
		$section = $this->uri->segment(3, 'activated', FALSE, $values);
		$offset = $this->uri->segment(4, 0, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					/* set the array data */
					$approve_array = array('log_status' => 'activated');
					
					/* approve the post */
					$approve = $this->logs->update_log($id, $approve_array);
					
					if ($approve > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_personallog')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* grab the post details */
						$row = $this->logs->get_log($id);
						
						/* set the array of data for the email */
						$email_data = array(
							'author' => $row->log_author_character,
							'title' => $row->log_title,
							'content' => $row->log_content
						);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('log', $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_personallog')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
							
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->logs->delete_log($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_personallog')),
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
							ucfirst(lang('global_personallog')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, TRUE);
					
					$update_array = array(
						'log_title' => $this->input->post('log_title', TRUE),
						'log_tags' => $this->input->post('log_tags', TRUE),
						'log_content' => $this->input->post('log_content', TRUE),
						'log_status' => $this->input->post('log_status', TRUE),
						'log_author_user' => $this->user->get_user_id($this->input->post('log_author')),
						'log_author_character' => $this->input->post('log_author', TRUE),
						'log_last_update' => now()
					);
					
					$update = $this->logs->update_log($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_personallog')),
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
							ucfirst(lang('global_personallog')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		if ($section == 'edit')
		{
			/* grab the ID from the URL */
			$id = $this->uri->segment(4, 0, TRUE);
			
			/* grab the post data */
			$row = $this->logs->get_log($id);
			
			if ($this->auth->get_access_level() < 2)
			{
				if ($this->session->userdata('userid') != $row->log_author_user || $row->log_status == 'pending')
				{
					redirect('admin/error/6');
				}
			}
			
			/* get all characters */
			$all = $this->char->get_all_characters('user_npc');
			
			if ($all->num_rows() > 0)
			{
				foreach ($all->result() as $a)
				{
					if ($a->crew_type == 'active' || $a->crew_type == 'npc')
					{ /* split the characters out between active and npcs */
						if ($a->crew_type == 'active')
						{
							$label = ucwords(lang('status_playing') .' '. lang('global_characters'));
						}
						else
						{
							$label = ucwords(lang('abbr_npcs'));
						}
						
						/* toss them in the array */
						$data['all'][$label][$a->charid] = $this->char->get_character_name($a->charid, TRUE);
					}
				}
			}
			
			/* set the data used by the view */
			$data['inputs'] = array(
				'title' => array(
					'name' => 'log_title',
					'value' => $row->log_title),
				'content' => array(
					'name' => 'log_content',
					'rows' => 20,
					'value' => $row->log_content),
				'tags' => array(
					'name' => 'log_tags',
					'value' => $row->log_tags),
				'author' => $row->log_author_character,
				'character' => $this->char->get_character_name($row->log_author_character, TRUE),
				'status' => $row->log_status,
			);
			
			$data['status'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'saved' => ucfirst(lang('status_saved')),
				'pending' => ucfirst(lang('status_pending')),
			);
			
			$data['buttons'] = array(
				'update' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'update',
					'content' => ucfirst(lang('actions_update'))),
			);
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_personallogs'));
			$data['id'] = $id;
			
			$data['label'] = array(
				'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to')
					.' '. ucwords(lang('global_personallogs')),
				'status' => ucfirst(lang('labels_status')),
				'title' => ucfirst(lang('labels_title')),
				'content' => ucfirst(lang('labels_content')),
				'tags' => ucfirst(lang('labels_tags')),
				'tags_inst' => ucfirst(lang('tags_separated')),
				'addauthor' => ucwords(lang('actions_add') .' '. lang('labels_author')),
				'author' => ucwords(lang('labels_author'))
			);
			
			$js_data = FALSE;
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_logs_edit', $this->skin, 'admin');
			$js_loc = js_location('manage_logs_js', $this->skin, 'admin');
		}
		else
		{
			switch ($section)
			{
				case 'activated':
					$js_data['tab'] = 0;
					break;
					
				case 'saved':
					$js_data['tab'] = 1;
					break;
					
				case 'pending':
					$js_data['tab'] = 2;
					break;
					
				default:
					$js_data['tab'] = 0;
			}
			
			$offset_activated = ($section == 'activated') ? $offset : 0;
			$offset_saved = ($section == 'saved') ? $offset : 0;
			$offset_pending = ($section == 'pending') ? $offset : 0;
			
			$data['activated'] = $this->_entries_ajax($offset_activated, 'activated', 'logs');
			$data['saved'] = $this->_entries_ajax($offset_saved, 'saved', 'logs');
			$data['pending'] = $this->_entries_ajax($offset_pending, 'pending', 'logs');
	
		    $data['label'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'pending' => ucfirst(lang('status_pending')),
				'saved' => ucfirst(lang('status_saved')),
			);
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_personallogs'));
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_logs', $this->skin, 'admin');
			$js_loc = js_location('manage_logs_js', $this->skin, 'admin');
		}
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function missions()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('missions_model', 'mis');
		$this->load->model('posts_model', 'posts');
		
		/* set the variables */
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4);
		
		$js_data['tab'] = 0;
		
		if (isset($_POST['submit']))
		{
			$status = $this->uri->segment(5);
			
			switch ($this->uri->segment(3))
			{
				case 'add':
					$start = (empty($_POST['mission_start'])) ? '' : human_to_unix($this->input->post('mission_start', TRUE));
					$end = (empty($_POST['mission_end'])) ? '' : human_to_unix($this->input->post('mission_end', TRUE));
					
					$insert_array = array(
						'mission_title' => $this->input->post('mission_title', TRUE),
						'mission_status' => $this->input->post('mission_status', TRUE),
						'mission_order' => $this->input->post('mission_order', TRUE),
						'mission_desc' => $this->input->post('mission_desc', TRUE),
						'mission_images' => $this->input->post('mission_images', TRUE),
						'mission_start' => $start,
						'mission_end' => $end,
						'mission_notes' => $this->input->post('mission_notes', TRUE),
						'mission_summary' => $this->input->post('mission_summary', TRUE),
					);
					
					/* insert the record */
					$insert = $this->mis->add_mission($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_mission')),
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
							ucfirst(lang('global_mission')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->mis->delete_mission($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_mission')),
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
							ucfirst(lang('global_mission')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== FALSE)
						{
							$loc_pos = substr($key, 0, $loc);
							
							$new_key = 'mission_'. substr($key, ($loc+1));
							
							if (substr($key, ($loc+1)) == 'start' || substr($key, ($loc+1)) == 'end')
							{
								$mission[$new_key] = human_to_unix($value);
							}
							else
							{
								$mission[$new_key] = $value;
							}
						}
					}
					
					$oldstatus = $mission['mission_oldstatus'];
					
					if ($oldstatus != $mission['mission_status'])
					{
						if ($oldstatus == 'upcoming' && $mission['mission_status'] == 'current')
						{
							$mission['mission_start'] = now();
						}
						if ($oldstatus == 'current' && $mission['mission_status'] == 'completed')
						{
							$mission['mission_end'] = now();
						}
					}
					
					unset($mission['mission_oldstatus']); /* remove the old status variable */
					$mission['mission_notes_updated'] = now(); /* add the mission notes updated field */
					
					$update = $this->mis->update_mission($id, $mission);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_mission')),
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
							ucfirst(lang('global_mission')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
			
			switch ($status)
			{
				case 'current':
					$js_data['tab'] = 0;
					break;
					
				case 'upcoming':
					$js_data['tab'] = 1;
					break;
					
				case 'completed':
					$js_data['tab'] = 2;
					break;
					
				default:
					$js_data['tab'] = 0;
			}
		}
		
		$data['label'] = array();
		
		if ($action == 'add' || $action == 'edit')
		{
			/* set the date */
			$today = getdate();
			$year = $today['year'];
			$month = (strlen($today['mon']) < 2) ? '0'. $today['mon'] : $today['mon'];
			$day = (strlen($today['mday']) < 2) ? '0'. $today['mday'] : $today['mday'];
			$date = $year .'-'. $month .'-'. $day .' 00:00:00';
			
			$item = $this->mis->get_mission($id);
			
			$start = ($item === FALSE) ? $date : '';
			$start = (empty($item->mission_start)) ? '' : unix_to_human($item->mission_start);
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_mission'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->mission_title : '';
			
			$data['inputs'] = array(
				'title' => array(
					'name' => 'mission_title',
					'value' => ($item === FALSE) ? '' : $item->mission_title),
				'order' => array(
					'name' => 'mission_order',
					'class' => 'small',
					'value' => ($item === FALSE) ? 99 : $item->mission_order),
				'start' => array(
					'name' => 'mission_start',
					'class' => 'datepick medium',
					'value' => $start),
				'end' => array(
					'name' => 'mission_end',
					'class' => 'datepick medium',
					'value' => ($item === FALSE || empty($item->mission_end)) ? '' : unix_to_human($item->mission_end)),
				'desc' => array(
					'name' => 'mission_desc',
					'rows' => 6,
					'value' => ($item == FALSE) ? '' : $item->mission_desc),
				'images' => array(
					'name' => 'mission_images',
					'id' => 'images',
					'rows' => 4,
					'value' => ($action == 'edit') ? $item->mission_images : ''),
				'status' => ($item === FALSE) ? '' : $item->mission_status,
				'summary' => array(
					'name' => 'mission_summary',
					'rows' => 12,
					'value' => ($item == FALSE) ? '' : $item->mission_summary),
				'notes' => array(
					'name' => 'mission_notes',
					'rows' => 12,
					'value' => ($item == FALSE) ? '' : $item->mission_notes),
			);
			
			$data['directory'] = array();
		
			$dir = $this->sys->get_uploaded_images('mission');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					$data['directory'][$d->upload_id] = array(
						'image' => array(
							'src' => asset_location('images/missions', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = view_location('manage_missions_action', $this->skin, 'admin');
		}
		else
		{
			$missions = $this->mis->get_all_missions();
			
			$data['label']['s_current'] = ucwords(lang('status_current') .' '. lang('global_missions'));
			$data['label']['s_completed'] = ucwords(lang('status_completed') .' '. lang('global_missions'));
			$data['label']['s_upcoming'] = ucwords(lang('status_upcoming') .' '. lang('global_missions'));
			
			if ($missions->num_rows() > 0)
			{
				$datestring = $this->options['date_format'];
				
				foreach ($missions->result() as $mission)
				{
					$mid = $mission->mission_id;
					$status = $mission->mission_status;
					
					$start = '';
					$end = '';
					$timespan = '';
					
					if (!empty($mission->mission_start))
					{
						$start = gmt_to_local($mission->mission_start, $this->timezone, $this->dst);
					}
					
					if (!empty($mission->mission_end))
					{
						$end = gmt_to_local($mission->mission_end, $this->timezone, $this->dst);
					}
					
					$data['missions'][$status][$mid] = array(
						'id' => $mid,
						'title' => $mission->mission_title,
						'desc' => $mission->mission_desc,
						'start' => $start,
						'end' => $end,
						'timespan' => $timespan,
						'posts' => $this->posts->count_mission_posts($mid, $this->options['post_count_format'])
					);
				}
				
				if (isset($data['missions']['current']))
				{
					$mis_label_current = (count($data['missions']['current']) > 1) ? lang('global_missions') : lang('global_mission');
					
					$data['label']['s_current'] = ucwords(lang('status_current') .' '. $mis_label_current);
				}
				
				if (isset($data['missions']['completed']))
				{
					$mis_label_completed = (count($data['missions']['completed']) > 1) ? lang('global_missions') : lang('global_mission');
					
					$data['label']['s_completed'] = ucwords(lang('status_completed') .' '. $mis_label_completed);
				}
				
				if (isset($data['missions']['upcoming']))
				{
					$mis_label_upcoming = (count($data['missions']['upcoming']) > 1) ? lang('global_missions') : lang('global_mission');
					
					$data['label']['s_upcoming'] = ucwords(lang('status_upcoming') .' '. $mis_label_upcoming);
				}
			}
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_missions'));
			
			$view_loc = view_location('manage_missions', $this->skin, 'admin');
		}
		
		$data['label'] += array(
			'title' => ucfirst(lang('labels_title')),
			'more' => ucfirst(lang('labels_more')),
			'start' => ucwords(lang('status_start') .' '. lang('labels_date')),
			'end' => ucwords(lang('status_end') .' '. lang('labels_date')),
			'delete' => ucfirst(lang('actions_delete')) .'?',
			'order' => ucfirst(lang('labels_order')),
			'desc' => ucfirst(lang('labels_desc')),
			'status' => ucfirst(lang('labels_status')),
			'images' => ucfirst(lang('labels_images')),
			'notes' => ucfirst(lang('labels_notes')),
			'summary' => ucfirst(lang('labels_summary')),
			'current' => ucwords(lang('status_current') .' '. lang('global_missions')),
			'upcoming' => ucwords(lang('status_upcoming') .' '. lang('global_missions')),
			'completed' => ucwords(lang('status_completed') .' '. lang('global_missions')),
			'error' => lang('error_no_missions'),
			'add' => ucwords(lang('actions_add') .' '. lang('global_mission')) .' '. RARROW,
			'posts' => ucfirst(lang('global_posts')) .': ',
			'info' => ucfirst(lang('labels_info')),
			'images' => ucfirst(lang('labels_images')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucfirst(lang('global_missions')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
		);
		
		$data['values'] = array(
			'status' => array(
				'current' => ucwords(lang('status_current') .' '. lang('global_mission')),
				'completed' => ucwords(lang('status_completed') .' '. lang('global_mission')),
				'upcoming' => ucwords(lang('status_upcoming') .' '. lang('global_mission')),
			),
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('icon-add.png', $this->skin, 'admin'),
				'alt' => ''),
			'delete' => array(
				'src' => img_location('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => img_location('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit'))),
			'view' => array(
				'src' => img_location('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view'))),
			'upload' => array(
				'src' => img_location('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
		);
		
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('global_mission')
		);
				
		/* figure out where the view should be coming from */
		$js_loc = js_location('manage_missions_js', $this->skin, 'admin');
		
		$data['text'] = sprintf(
			lang('text_manage_missions'),
			lang('global_missions'),
			lang('global_missions'),
			lang('global_missions'),
			lang('global_mission'),
			lang('global_mission'),
			lang('global_missionposts')
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function news()
	{
		$this->auth->check_access();
		
		$this->load->model('news_model', 'news');
		
		$values = array('activated', 'saved', 'pending', 'edit');
		$section = $this->uri->segment(3, 'activated', FALSE, $values);
		$offset = $this->uri->segment(4, 0, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					/* set the array data */
					$approve_array = array('news_status' => 'activated');
					
					/* approve the post */
					$approve = $this->news->update_news_item($id, $approve_array);
					
					if ($approve > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_newsitem')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* grab the post details */
						$row = $this->news->get_news_item($id);
						
						/* set the array of data for the email */
						$email_data = array(
							'author' => $row->news_author_character,
							'title' => $row->news_title,
							'category' => $this->news->get_news_category($row->news_cat, 'newscat_name'),
							'content' => $row->news_content
						);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('news', $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_personallog')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
							
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->news->delete_news_item($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_newsitem')),
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
							ucfirst(lang('global_newsitem')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, TRUE);
					
					$update_array = array(
						'news_title' => $this->input->post('news_title', TRUE),
						'news_tags' => $this->input->post('news_tags', TRUE),
						'news_content' => $this->input->post('news_content', TRUE),
						'news_author_character' => $this->input->post('news_author', TRUE),
						'news_author_user' => $this->user->get_user_id($this->input->post('news_author')),
						'news_status' => $this->input->post('news_status', TRUE),
						'news_cat' => $this->input->post('news_cat', TRUE),
						'news_private' => $this->input->post('news_private', TRUE),
						'news_last_update' => now()
					);
					
					$update = $this->news->update_news_item($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_newsitem')),
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
							ucfirst(lang('global_newsitem')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		if ($section == 'edit')
		{
			/* grab the ID from the URL */
			$id = $this->uri->segment(4, 0, TRUE);
			
			/* grab the post data */
			$row = $this->news->get_news_item($id);
			$cats = $this->news->get_news_categories();
			
			if ($this->auth->get_access_level() < 2)
			{
				if ($this->session->userdata('userid') != $row->news_author_user || $row->news_status == 'pending')
				{
					redirect('admin/error/6');
				}
			}
			
			if ($cats->num_rows() > 0)
			{
				foreach ($cats->result() as $c)
				{
					$data['categories'][$c->newscat_id] = $c->newscat_name;
				}
			}
			
			/* get all characters */
			$all = $this->char->get_all_characters('active');
			
			if ($all->num_rows() > 0)
			{
				foreach ($all->result() as $a)
				{
					$data['all'][$a->charid] = $this->char->get_character_name($a->charid, TRUE);
				}
			}
			
			/* set the data used by the view */
			$data['inputs'] = array(
				'title' => array(
					'name' => 'news_title',
					'value' => $row->news_title),
				'content' => array(
					'name' => 'news_content',
					'rows' => 20,
					'value' => $row->news_content),
				'tags' => array(
					'name' => 'news_tags',
					'value' => $row->news_tags),
				'author' => $row->news_author_character,
				'character' => $this->char->get_character_name($row->news_author_character, TRUE),
				'status' => $row->news_status,
				'category' => $row->news_cat,
				'category_name' => $this->news->get_news_category($row->news_cat, 'newscat_name'),
				'private' => $row->news_private,
				'private_long' => ($row->news_private == 'y') ? ucfirst(lang('labels_yes')) : ucfirst(lang('labels_no'))
			);
			
			$data['status'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'saved' => ucfirst(lang('status_saved')),
				'pending' => ucfirst(lang('status_pending')),
			);
			
			$data['private'] = array(
				'y' => ucfirst(lang('labels_yes')),
				'n' => ucfirst(lang('labels_no')),
			);
			
			$data['buttons'] = array(
				'update' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'update',
					'content' => ucfirst(lang('actions_update'))),
			);
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_newsitem'));
			$data['id'] = $id;
			
			$data['label'] = array(
				'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to')
					.' '. ucwords(lang('global_newsitems')),
				'status' => ucfirst(lang('labels_status')),
				'title' => ucfirst(lang('labels_title')),
				'content' => ucfirst(lang('labels_content')),
				'tags' => ucfirst(lang('labels_tags')),
				'tags_inst' => ucfirst(lang('tags_separated')),
				'author' => ucwords(lang('labels_author')),
				'category' => ucfirst(lang('labels_category')),
				'private' => ucfirst(lang('labels_private'))
			);
			
			$js_data = FALSE;
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_news_edit', $this->skin, 'admin');
			$js_loc = js_location('manage_news_js', $this->skin, 'admin');
		}
		else
		{
			switch ($section)
			{
				case 'activated':
					$js_data['tab'] = 0;
					break;
					
				case 'saved':
					$js_data['tab'] = 1;
					break;
					
				case 'pending':
					$js_data['tab'] = 2;
					break;
					
				default:
					$js_data['tab'] = 0;
			}
			
			$offset_activated = ($section == 'activated') ? $offset : 0;
			$offset_saved = ($section == 'saved') ? $offset : 0;
			$offset_pending = ($section == 'pending') ? $offset : 0;
			
			$data['activated'] = $this->_entries_ajax($offset_activated, 'activated', 'news');
			$data['saved'] = $this->_entries_ajax($offset_saved, 'saved', 'news');
			$data['pending'] = $this->_entries_ajax($offset_pending, 'pending', 'news');
	
		    $data['label'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'pending' => ucfirst(lang('status_pending')),
				'saved' => ucfirst(lang('status_saved')),
			);
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_newsitems'));
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_news', $this->skin, 'admin');
			$js_loc = js_location('manage_news_js', $this->skin, 'admin');
		}
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function newscats()
	{
		$this->auth->check_access();
		
		$this->load->model('news_model', 'news');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'newscat_name' => $this->input->post('newscat_name', TRUE),
						'newscat_display' => 'y',
					);
					
					/* insert the record */
					$insert = $this->news->add_news_category($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_news') .' '. lang('labels_category')),
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
							ucfirst(lang('global_news') .' '. lang('labels_category')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== FALSE)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if (!in_array($loc_pos, $delete))
							{ /* if the item is being deleted don't add it to the update array */
								$new_key = 'newscat_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{ /* update the positions */
						$update += $this->news->update_news_category($a, $b);
					}
					
					foreach ($delete as $del)
					{ /* delete the positions marked for deletion */
						$delete = $this->news->delete_news_category($del);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_news') .' '. lang('labels_categories')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_news') .' '. lang('labels_categories')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$cats = $this->news->get_news_categories('');
		
		if ($cats->num_rows() > 0)
		{
			foreach ($cats->result() as $c)
			{
				$cid = $c->newscat_id;
				
				$data['categories'][$cid] = array(
					'id' => $cid,
					'name' => array(
						'name' => $cid .'_name',
						'value' => $c->newscat_name),
					'display' => $c->newscat_display,
					'delete' => array(
						'name' => 'delete[]',
						'value' => $cid,
						'id' => $cid .'_id'),
				);
			}
		}
		
		$data['values']['display'] = array(
			'y' => ucfirst(lang('labels_yes')),
			'n' => ucfirst(lang('labels_no')),
		);
		
		$data['label'] = array(
			'name' => ucfirst(lang('labels_name')),
			'add' => ucwords(lang('actions_add') .' '. lang('global_news') .' '.
				lang('labels_category') .' '. RARROW),
			'display' => ucfirst(lang('labels_display')),
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
		
		$data['inputs']['name'] = array(
			'name' => 'newscat_name'
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('category-add.png', $this->skin, 'admin'),
				'alt' => '')
		);
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_news') .' '. lang('labels_categories'));
		$data['text'] = sprintf(
			lang('text_manage_newscats'),
			ucfirst(lang('global_newsitems')),
			lang('globals_news'),
			lang('global_newsitems'),
			lang('global_newsitems')
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_newscats', $this->skin, 'admin');
		$js_loc = js_location('manage_newscats_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function positions()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('positions_model', 'pos');
		$this->load->model('depts_model', 'dept');
		
		/* set the variables */
		$g_dept = $this->uri->segment(3, 1, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(4))
			{
				case 'add':
					$insert_array = array(
						'pos_name' => $this->input->post('pos_name', TRUE),
						'pos_type' => $this->input->post('pos_type', TRUE),
						'pos_dept' => $this->input->post('pos_dept', TRUE),
						'pos_order' => $this->input->post('pos_order', TRUE),
						'pos_display' => $this->input->post('pos_display', TRUE),
						'pos_open' => $this->input->post('pos_open', TRUE),
						'pos_desc' => $this->input->post('pos_desc', TRUE),
					);
					
					/* insert the record */
					$insert = $this->pos->add_position($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_position')),
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
							ucfirst(lang('global_position')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== FALSE)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if (!in_array($loc_pos, $delete))
							{ /* if the item is being deleted don't add it to the update array */
								$new_key = 'pos_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{ /* update the positions */
						$update += $this->pos->update_position($a, $b);
					}
					
					foreach ($delete as $del)
					{ /* delete the positions marked for deletion */
						$delete = $this->pos->delete_position($del);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_positions')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_positions')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$positions = $this->pos->get_dept_positions($g_dept, '');
		$departments = $this->dept->get_all_depts('asc', '');
		
		if ($departments->num_rows() > 0)
		{
			foreach ($departments->result() as $dept)
			{
				$data['depts'][$dept->dept_id] = $dept->dept_name;
				
				$subd = $this->dept->get_sub_depts($dept->dept_id, 'asc', '');
				
				if ($subd->num_rows() > 0)
				{
					foreach ($subd->result() as $sub)
					{
						$data['depts'][$sub->dept_id] = $sub->dept_name;
					}
				}
			}
		}
		
		$data['dept_count'] = count($data['depts']);
		
		if ($positions->num_rows() > 0)
		{
			foreach ($positions->result() as $p)
			{
				$data['inputs']['position'][$p->pos_id] = array(
					'name' => array(
						'name' => $p->pos_id .'_name',
						'id' => $p->pos_id .'_name',
						'value' => $p->pos_name
					),
					'desc' => array(
						'name' => $p->pos_id .'_desc',
						'id' => $p->pos_id .'_desc',
						'value' => $p->pos_desc,
						'rows' => 4
					),
					'order' => array(
						'name' => $p->pos_id .'_order',
						'id' => $p->pos_id .'_order',
						'value' => $p->pos_order,
						'class' => 'small'
					),
					'delete' => array(
						'name' => 'delete[]',
						'id' => $p->pos_id .'_id',
						'value' => $p->pos_id
					)
				);
				
				$data['values']['position'][$p->pos_id]['display'] = array(
					'y' => ucwords(lang('labels_yes')),
					'n' => ucwords(lang('labels_no')),
				);
				
				$data['values']['position'][$p->pos_id]['type'] = array(
					'senior' => ucwords(lang('labels_senior')),
					'officer' => ucwords(lang('labels_officer')),
					'enlisted' => ucwords(lang('labels_enlisted')),
					'other' => ucwords(lang('labels_other')),
				);
				
				$data['positions'][$p->pos_id]['id'] = $p->pos_id;
				$data['positions'][$p->pos_id]['open'] = $p->pos_open;
				$data['positions'][$p->pos_id]['display'] = $p->pos_display;
				$data['positions'][$p->pos_id]['dept'] = $p->pos_dept;
				$data['positions'][$p->pos_id]['type'] = $p->pos_type;
			}
		}
				
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_positions', $this->skin, 'admin');
		$js_loc = js_location('manage_positions_js', $this->skin, 'admin');
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_positions'));
		$data['text'] = sprintf(
			lang('text_manage_positions'),
			ucfirst(lang('global_positions')),
			lang('global_positions'),
			lang('global_position'),
			lang('global_positions'),
			lang('global_positions')
		);
		$data['g_dept'] = $g_dept;
		
		$data['label'] = array(
			'add_position' => ucwords(lang('actions_add') .' '.
				lang('global_position') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'open' => ucwords(lang('status_open') .' '. lang('labels_slots')),
			'delete' => ucfirst(lang('actions_delete')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'type' => ucfirst(lang('labels_type')),
			'desc' => ucfirst(lang('labels_desc')),
			'dept' => ucfirst(lang('global_department')),
			'depts' => ucfirst(lang('global_departments')) .':',
			'more' => ucfirst(lang('labels_more'))
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => ''),
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update')))
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function posts()
	{
		$this->auth->check_access();
		
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		$values = array('activated', 'saved', 'pending', 'edit');
		$section = $this->uri->segment(3, 'activated', FALSE, $values);
		$offset = $this->uri->segment(4, 0, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					/* set the array data */
					$approve_array = array('post_status' => 'activated');
					
					/* approve the post */
					$approve = $this->posts->update_post($id, $approve_array);
					
					if ($approve > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missionpost')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						/* grab the post details */
						$row = $this->posts->get_post($id);
						
						/* set the array of data for the email */
						$email_data = array(
							'authors' => $row->post_authors,
							'title' => $row->post_title,
							'timeline' => $row->post_timeline,
							'location' => $row->post_location,
							'content' => $row->post_content,
							'mission' => $this->mis->get_mission($row->post_mission, 'mission_title')
						);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('post', $email_data) : FALSE;
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_missionpost')),
							lang('actions_approved'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
							
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->posts->delete_post($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missionpost')),
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
							ucfirst(lang('global_missionpost')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, TRUE);
					
					$update_array = array(
						'post_title' => $this->input->post('post_title', TRUE),
						'post_location' => $this->input->post('post_location', TRUE),
						'post_timeline' => $this->input->post('post_timeline', TRUE),
						'post_tags' => $this->input->post('post_tags', TRUE),
						'post_content' => $this->input->post('post_content', TRUE),
						'post_mission' => $this->input->post('post_mission', TRUE),
						'post_status' => $this->input->post('post_status', TRUE),
						'post_last_update' => now(),
					);
					
					$to = explode(',', $_POST['to']);
					
					foreach ($to as $a => $b)
					{
						if (empty($b))
						{
							unset($to[$a]);
						}
						
						/* get the user ID */
						$uid = $this->sys->get_item('characters', 'charid', $b, 'user');
						
						/* put the users into an array */
						$users[] = ($uid !== FALSE) ? $uid : NULL;
					}
					
					foreach ($users as $k => $v)
					{
						if (!is_numeric($v) || $v < 1)
						{
							unset($users[$k]);
						}
					}
					
					$authors = implode(',', $to);
					$authors_users = implode(',', $users);
					
					$update_array['post_authors'] = $this->input->xss_clean($authors);
					$update_array['post_authors_users'] = $authors_users;
					
					$update = $this->posts->update_post($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missionpost')),
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
							ucfirst(lang('global_missionpost')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		if ($section == 'edit')
		{
			/* grab the ID from the URL */
			$id = $this->uri->segment(4, 0, TRUE);
			
			/* grab the post data */
			$row = $this->posts->get_post($id);
			
			if ($this->auth->get_access_level() < 2)
			{
				$valid = array();
				
				foreach ($this->session->userdata('characters') as $check)
				{
					if (strstr($row->post_authors, $check) === FALSE)
					{
						$valid[] = FALSE;
					}
					else
					{
						$valid[] = TRUE;
					}
				}
				
				if (!in_array(TRUE, $valid) || $row->post_status == 'pending')
				{
					redirect('admin/error/6');
				}
			}
			
			/* get all characters */
			$all = $this->char->get_all_characters('user_npc');
			
			/* get the current missions */
			$missions = $this->mis->get_all_missions();
			
			if ($all->num_rows() > 0)
			{ /* get the rest of the potential authors */
				$data['all'][0] = ucwords(lang('labels_please') .' '. lang('actions_select')
					.' '. lang('labels_an') .' '. lang('labels_author'));
				
				foreach ($all->result() as $a)
				{
					if ($a->crew_type == 'active' || $a->crew_type == 'npc')
					{ /* split the characters out between active and npcs */
						if ($a->crew_type == 'active')
						{
							$label = ucwords(lang('status_playing') .' '. lang('global_characters'));
						}
						else
						{
							$label = ucwords(lang('abbr_npcs'));
						}
						
						/* toss them in the array */
						$data['all'][$label][$a->charid] = $this->char->get_character_name($a->charid, TRUE);
					}
				}
			}
			
			/* build the remove image */
			$remove = array(
				'src' => img_location('minus-circle.png', $this->skin, 'admin'),
				'class' => 'image fontSmall inline_img_left',
				'alt' => ucfirst(lang('actions_remove'))
			);
			
			/* prep the data for sending to the js view */
			$js_data['remove'] = img($remove);
			
			if ($row !== FALSE)
			{
				/* set the hidden TO field */
				$data['to'] = $row->post_authors;
				
				/* set the recipients list */
				$to_array = explode(',', $data['to']);
				
				$i = 1;
				foreach ($to_array as $value)
				{
					$to_name = $this->char->get_character_name($value, TRUE);
					
					$data['recipient_list'][$i] = '<span class="'. $value .'">';
					$data['recipient_list'][$i].= '<a href="#" id="remove_author" class="image" myID="'. $value .'" myName="'.  $to_name .'">';
					$data['recipient_list'][$i].= img($remove) .'</a>';
					$data['recipient_list'][$i].= $to_name .'<br /></span>';
					
					++$i;
				}
			}
			
			/* set the data used by the view */
			$data['inputs'] = array(
				'title' => array(
					'name' => 'post_title',
					'value' => $row->post_title),
				'content' => array(
					'name' => 'post_content',
					'rows' => 20,
					'value' => $row->post_content),
				'tags' => array(
					'name' => 'post_tags',
					'value' => $row->post_tags),
				'timeline' => array(
					'name' => 'post_timeline',
					'value' => $row->post_timeline),
				'location' => array(
					'name' => 'post_location',
					'value' => $row->post_location),
				'mission' => $row->post_mission,
				'mission_name' => $this->mis->get_mission($row->post_mission, 'mission_title'),
				'status' => $row->post_status,
			);
			
			if ($missions->num_rows() > 0)
			{
				foreach ($missions->result() as $mission)
				{
					$data['missions'][$mission->mission_id] = $mission->mission_title;
				}
			}
			
			$data['status'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'saved' => ucfirst(lang('status_saved')),
				'pending' => ucfirst(lang('status_pending')),
			);
			
			$data['buttons'] = array(
				'update' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'update',
					'content' => ucfirst(lang('actions_update'))),
			);
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_missionpost'));
			$data['id'] = $id;
			
			$data['label'] = array(
				'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to')
					.' '. ucwords(lang('global_missionposts')),
				'mission' => ucfirst(lang('global_mission')),
				'status' => ucfirst(lang('labels_status')),
				'title' => ucfirst(lang('labels_title')),
				'location' => ucfirst(lang('labels_location')),
				'timeline' => ucfirst(lang('labels_timeline')),
				'content' => ucfirst(lang('labels_content')),
				'tags' => ucfirst(lang('labels_tags')),
				'tags_inst' => ucfirst(lang('tags_separated')),
				'addauthor' => ucwords(lang('actions_add') .' '. lang('labels_author')),
				'authors' => ucfirst(lang('labels_authors'))
			);
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_posts_edit', $this->skin, 'admin');
			$js_loc = js_location('manage_posts_js', $this->skin, 'admin');
		}
		else
		{
			switch ($section)
			{
				case 'activated':
					$js_data['tab'] = 0;
					break;
					
				case 'saved':
					$js_data['tab'] = 1;
					break;
					
				case 'pending':
					$js_data['tab'] = 2;
					break;
					
				default:
					$js_data['tab'] = 0;
			}
			
			$offset_activated = ($section == 'activated') ? $offset : 0;
			$offset_saved = ($section == 'saved') ? $offset : 0;
			$offset_pending = ($section == 'pending') ? $offset : 0;
			
			$data['activated'] = $this->_entries_ajax($offset_activated, 'activated', 'posts');
			$data['saved'] = $this->_entries_ajax($offset_saved, 'saved', 'posts');
			$data['pending'] = $this->_entries_ajax($offset_pending, 'pending', 'posts');
	
		    $data['label'] = array(
				'activated' => ucfirst(lang('status_activated')),
				'pending' => ucfirst(lang('status_pending')),
				'saved' => ucfirst(lang('status_saved')),
			);
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_missionposts'));
			
			$js_data['remove'] = FALSE;
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('manage_posts', $this->skin, 'admin');
			$js_loc = js_location('manage_posts_js', $this->skin, 'admin');
		}
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function ranks()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('ranks_model', 'ranks');
		
		/* set the variables */
		$set = $this->uri->segment(3, 1, TRUE);
		$class = $this->uri->segment(4, 1, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'add':
					$insert_array = array(
						'rank_name' => $this->input->post('rank_name', TRUE),
						'rank_order' => $this->input->post('rank_order', TRUE),
						'rank_display' => $this->input->post('rank_display', TRUE),
						'rank_class' => $this->input->post('rank_class', TRUE),
						'rank_short_name' => $this->input->post('rank_short_name', TRUE),
						'rank_image' => $this->input->post('rank_image', TRUE),
					);
					
					/* insert the record */
					$insert = $this->ranks->add_rank($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_rank')),
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
							ucfirst(lang('global_rank')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== FALSE)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if (!in_array($loc_pos, $delete))
							{ /* if the item is being deleted don't add it to the update array */
								$new_key = 'rank_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{ /* update the positions */
						$update += $this->ranks->update_rank($a, $b);
					}
					
					foreach ($delete as $del)
					{ /* delete the positions marked for deletion */
						$delete = $this->ranks->delete_rank($del);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_ranks')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure_plural'),
							ucfirst(lang('global_ranks')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		$info = $this->ranks->get_rankcat($set, 'rankcat_id');
		$ranks = $this->ranks->get_ranks($class, '');
		
		/* grab all the rank sets */
		$setstatus = ($this->auth->check_access('site/catalogueranks', FALSE) === TRUE) ? array('active','development') : 'active';
		$allranks = $this->ranks->get_all_rank_sets($setstatus);
		$allclasses = $this->ranks->get_group_ranks();
		
		if ($allranks->num_rows() > 0)
		{ /* build the array with rank set data */
			foreach ($allranks->result() as $allrank)
			{
				$data['allranks'][$allrank->rankcat_id] = array(
					'src' => rank_location(
						$allrank->rankcat_location,
						$allrank->rankcat_preview,
						''),
					'alt' => $allrank->rankcat_name
				);
				
				if ($allclasses->num_rows() > 0)
				{ /* build the array with rank class data */
					foreach ($allclasses->result() as $allclass)
					{
						if ($allclass->rank_class > 0 && $allrank->rankcat_id == $set)
						{
							$data['allclasses'][$allclass->rank_class] = array(
								'src' => rank_location(
									$allrank->rankcat_location,
									$allclass->rank_image,
									$allrank->rankcat_extension),
								'alt' => $allclass->rank_class
							);
						}
					}
				}
			}
		}
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $rank)
			{
				$data['ranks'][$rank->rank_id] = array(
					'id' => $rank->rank_id,
					'img' => array(
						'src' => rank_location($info->rankcat_location, $rank->rank_image, $info->rankcat_extension),
						'alt' => $rank->rank_name),
					'name' => array(
						'name' => $rank->rank_id .'_name',
						'value' => $rank->rank_name),
					'shortname' => array(
						'name' => $rank->rank_id .'_short_name',
						'value' => $rank->rank_short_name,
						'class' => 'medium'),
					'delete' => array(
						'id' => $rank->rank_id .'_id',
						'name' => 'delete[]',
						'value' => $rank->rank_id),
					'order' => array(
						'name' => $rank->rank_id .'_order',
						'value' => $rank->rank_order,
						'class' => 'small'),
					'class' => array(
						'name' => $rank->rank_id .'_class',
						'value' => $rank->rank_class,
						'class' => 'small'),
					'display' => $rank->rank_display,
					'image' => array(
						'name' => $rank->rank_id .'_image',
						'value' => $rank->rank_image,
						'class' => 'medium'),
				);
			}
		}
		
		$data['values']['display'] = array(
			'y' => ucwords(lang('labels_yes')),
			'n' => ucwords(lang('labels_no')),
		);
		
		$data['set'] = $set;
		$data['class'] = $class;
		$data['ext'] = $info->rankcat_extension;
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_ranks', $this->skin, 'admin');
		$js_loc = js_location('manage_ranks_js', $this->skin, 'admin');
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_ranks'));
		$data['text'] = sprintf(
			lang('text_manage_ranks'),
			lang('global_ranks'),
			lang('global_characters'),
			lang('global_sim'),
			lang('global_ranks'),
			lang('global_ranks'),
			lang('global_rank'),
			lang('global_rank') .' '. lang('labels_sets'),
			lang('labels_classes'),
			lang('global_rank') .' '. lang('labels_set'),
			lang('labels_class')
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_update')))
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => img_location('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => ''),
		);
		
		$data['label'] = array(
			'addrank' => ucwords(lang('actions_add') .' '.
				lang('global_rank') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'shortname' => ucwords(lang('labels_shortname')),
			'delete' => ucfirst(lang('actions_delete')),
			'order' => ucfirst(lang('labels_order')),
			'class' => ucfirst(lang('labels_class')),
			'classes' => ucwords(lang('global_rank') .' '. lang('labels_classes')),
			'display' => ucfirst(lang('labels_display')),
			'more' => ucfirst(lang('labels_more')),
			'image' => ucfirst(lang('labels_image')),
			'sets' => ucwords(lang('global_rank') .' '. lang('labels_sets'))
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function specs()
	{
		/* check access */
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		if (isset($_POST['submit']))
		{
			$update = 0;
			
			foreach ($_POST as $k => $v)
			{
				$key = $this->input->xss_clean($k);
				$value = $this->input->xss_clean($v);
				
				if (is_numeric($key))
				{
					$field_data = $this->specs->get_field_data($key);
					$row = ($field_data->num_rows() > 0) ? $field_data->row() : FALSE;
					
					if ($row->data_value != $value)
					{
						$specs = array(
							'data_value' => $value,
							'data_updated' => now()
						);
						
						$update += $this->specs->update_spec_field_data($key, $specs, 'data_field');
					}
				}
			}
			
			if ($update > 0)
			{
				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('global_specifications')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure_plural'),
					ucfirst(lang('global_specifications')),
					lang('actions_updated'),
					''
				);

				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			/* write everything to the template */
			$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
		}
		
		$sections = $this->specs->get_spec_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$sid = $sec->section_id; /* section id */
				
				/* set the section name */
				$data['specs'][$sid]['name'] = $sec->section_name;
				
				/* grab the fields for the given section */
				$fields = $this->specs->get_spec_fields($sec->section_id);
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						$f_id = $field->field_id; /* field id */
						
						/* set the page label */
						$data['specs'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
						
						switch ($field->field_type)
						{
							case 'text':
								$field_data = $this->specs->get_field_data($field->field_id);
								$row = ($field_data->num_rows() > 0) ? $field_data->row() : FALSE;
								
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => ($row !== FALSE) ? $row->data_value : ''
								);
								
								$data['specs'][$sid]['fields'][$f_id]['input'] = form_input($input);
								
								break;
								
							case 'textarea':
								$field_data = $this->specs->get_field_data($field->field_id);
								$row = ($field_data->num_rows() > 0) ? $field_data->row() : FALSE;
								
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => ($row !== FALSE) ? $row->data_value : '',
									'rows' => $field->field_rows
								);
								
								$data['specs'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
								
								break;
								
							case 'select':
								$value = FALSE;
								$values = FALSE;
								$input = FALSE;
							
								$values = $this->specs->get_spec_values($field->field_id);
								
								$field_data = $this->specs->get_field_data($field->field_id);
								$row = ($field_data->num_rows() > 0) ? $field_data->row() : FALSE;
								$default = ($row !== FALSE) ? $row->data_value : '';
								
								if ($values->num_rows() > 0)
								{
									foreach ($values->result() as $value)
									{
										$input[$value->value_field_value] = $value->value_content;
									}
								}
								
								$data['specs'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input, $default);
								break;
						}
					}
				}
			}
		}
				
		/* figure out where the view should be coming from */
		$view_loc = view_location('manage_specs', $this->skin, 'admin');
		$js_loc = js_location('manage_specs_js', $this->skin, 'admin');
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_specifications'));
		$data['text'] = lang('text_manage_specs');
		
		$data['images'] = array(
			'form' => array(
				'src' => img_location('forms-field.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
		);
		
		$data['button_submit'] = array(
			'type' => 'submit',
			'class' => 'button-main',
			'name' => 'submit',
			'value' => 'submit',
			'content' => ucwords(lang('actions_submit'))
		);
		
		$data['label'] = array(
			'no_specs' => lang('error_no_specs'),
			'specsform' => ucwords(lang('actions_manage') .' '. lang('global_specs') .' '. 
				lang('labels_form') .' '. RARROW),
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function tour()
	{
		$this->auth->check_access();
		
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		/* set the variables */
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4, 0, TRUE);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							$fields[] = array(
								'data_field' => $key,
								'data_value' => $value,
								'data_updated' => now()
							);
						}
						
						if (substr($key, 0, 5) == 'tour_')
						{
							$tour[$key] = $value;
						}
					}
					
					$insert = $this->tour->add_tour_item($tour);
					$insert_id = $this->db->insert_id();
					
					/* optimize the table */
					$this->sys->optimize_table('tour');
					
					foreach ($fields as $k => $v)
					{
						$v['data_tour_item'] = $insert_id;
						
						$insert += $this->tour->add_tour_field_data($v);
					}
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_touritem')),
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
							ucfirst(lang('global_touritem')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					$delete = $this->tour->delete_tour_item($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_touritem')),
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
							ucfirst(lang('global_touritem')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
					
				case 'edit':
					$id = $this->input->post('id', TRUE);
					$id = (is_numeric($id)) ? $id : FALSE;
					
					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							$fields[$key] = array(
								'data_value' => $value,
								'data_updated' => now()
							);
						}
						
						if (substr($key, 0, 5) == 'tour_')
						{
							$tour[$key] = $value;
						}
					}
					
					$update = $this->tour->update_tour_item($id, $tour);
					
					foreach ($fields as $k => $v)
					{
						$update += $this->tour->update_tour_data($k, $v);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_touritem')),
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
							ucfirst(lang('global_touritem')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					
					/* write everything to the template */
					$this->template->write_view('flash_message', '_base/admin/pages/flash', $flash);
					
					break;
			}
		}
		
		if ($action == 'add' || $action == 'edit')
		{
			$item = ($action == 'edit') ? $this->sys->get_item('tour', 'tour_id', $id) : FALSE;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_touritem'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->tour_name : '';
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'tour_name',
					'value' => ($item === FALSE) ? '' : $item->tour_name),
				'order' => array(
					'name' => 'tour_order',
					'class' => 'small',
					'value' => ($item === FALSE) ? '' : $item->tour_order),
				'display_y' => array(
					'name' => 'tour_display',
					'id' => 'display_y',
					'value' => 'y',
					'checked' => ($item !== FALSE && $item->tour_display == 'y') ? TRUE : FALSE),
				'display_n' => array(
					'name' => 'tour_display',
					'id' => 'display_n',
					'value' => 'n',
					'checked' => ($item !== FALSE && $item->tour_display == 'n') ? TRUE : FALSE),
				'images' => array(
					'name' => 'tour_images',
					'id' => 'images',
					'rows' => 4,
					'value' => ($action == 'edit') ? $item->tour_images : ''),
				'summary' => array(
					'name' => 'tour_summary',
					'rows' => 6,
					'value' => ($item === FALSE) ? '' : $item->tour_summary),
				'submit' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			$tour = $this->tour->get_tour_fields();
		
			if ($tour->num_rows() > 0)
			{
				foreach ($tour->result() as $field)
				{
					$tid = $field->field_id;
					
					/* set the page label */
					$data['inputs']['fields'][$tid]['field_label'] = $field->field_label_page;
					
					switch ($field->field_type)
					{
						case 'text':
							$row = $this->tour->get_tour_data($id, $tid);
							
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => ($row === FALSE) ? '' : $row->data_value
							);
							
							$data['inputs']['fields'][$tid]['input'] = form_input($input);
							
							break;
							
						case 'textarea':
							$row = $this->tour->get_tour_data($id, $tid);
							
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => ($row === FALSE) ? '' : $row->data_value,
								'rows' => $field->field_rows
							);
							
							$data['inputs']['fields'][$tid]['input'] = form_textarea($input);
							
							break;
							
						case 'select':
							$value = FALSE;
							$values = FALSE;
							$input = FALSE;
						
							$values = $this->tour->get_tour_values($tid);
							
							$row = $this->tour->get_tour_data($id, $tid);
							$default = ($row === FALSE) ? '' : $row->data_value;
							
							if ($values->num_rows() > 0)
							{
								foreach ($values->result() as $value)
								{
									$input[$value->value_field_value] = $value->value_content;
								}
							}
							
							$data['inputs']['fields'][$tid]['input'] = form_dropdown($tid, $input, $default);
							
							break;
					}
				}
			}
			
			$data['directory'] = array();
		
			$dir = $this->sys->get_uploaded_images('tour');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					$data['directory'][$d->upload_id] = array(
						'image' => array(
							'src' => asset_location('images/tour', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = view_location('manage_tour_action', $this->skin, 'admin');
		}
		else
		{
			$tour = $this->tour->get_tour_items('');
			
			if ($tour->num_rows() > 0)
			{
				foreach ($tour->result() as $t)
				{
					$tid = $t->tour_id;
					
					$data['tour'][$tid] = array(
						'id' => $tid,
						'name' => $t->tour_name,
						'summary' => $t->tour_summary
					);
				}
			}
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_touritems'));
			$data['text'] = lang('text_manage_specs');
			
			$view_loc = view_location('manage_tour', $this->skin, 'admin');
		}
		
		$data['images'] = array(
			'form' => array(
				'src' => img_location('forms-field.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'edit' => array(
				'src' => img_location('tour-edit.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_edit')),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
			'delete' => array(
				'src' => img_location('tour-delete.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_delete')),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'add' => array(
				'src' => img_location('tour-add.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_add')),
				'title' => ucfirst(lang('actions_add')),
				'class' => ''),
			'upload' => array(
				'src' => img_location('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
		);
		
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('global_touritem')
		);
		
		$data['label'] = array(
			'form' => ucwords(lang('actions_manage') .' '. lang('global_tour') .' '. lang('labels_form') .' '. RARROW),
			'images' => ucfirst(lang('labels_images')),
			'info' => ucfirst(lang('labels_info')),
			'summary' => ucfirst(lang('labels_summary')) .':',
			'add' => ucwords(lang('actions_add') .' '. lang('global_touritem') .' '. RARROW),
			'no_tour' => lang('error_no_tour'),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'summary' => ucfirst(lang('labels_summary')) .': ',
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('global_touritems')),
		);
		
		/* figure out where the view should be coming from */
		$js_loc = js_location('manage_tour_js', $this->skin, 'admin');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function _comments_ajax($offset = 0, $type = '', $status = 'activated')
	{
		/* load the resources */
		$this->load->library('pagination');
		$this->load->library('parser');
		$this->load->helper('text');
		
		switch ($type)
		{
			case 'posts':
				$this->load->model('posts_model', 'posts');
				
				$config['base_url'] = site_url('manage/comments/posts/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$posts = $this->posts->get_post_comments('', $status, 'pcomment_date', 'desc');
				
				$data['entries'] = NULL;
				
				if ($posts->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($posts->result() as $p)
					{
						$date = gmt_to_local($p->pcomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$p->pcomment_id]['id'] = $p->pcomment_id;
						$data['entries'][$p->pcomment_id]['content'] = ($p->pcomment_status == 'pending') ? $p->pcomment_content : word_limiter($p->pcomment_content, 25);
						$data['entries'][$p->pcomment_id]['author'] = $this->char->get_authors($p->pcomment_author_character, TRUE);
						$data['entries'][$p->pcomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$p->pcomment_id]['source'] = anchor('sim/viewpost/'. $p->pcomment_post, $this->posts->get_post($p->pcomment_post, 'post_title'));
						$data['entries'][$p->pcomment_id]['status'] = $p->pcomment_status;
					}
				}
		
				$config['total_rows'] = $this->posts->count_all_post_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
				
				$data['subheader'] = 'header_posts';
				
				break;
				
			case 'logs':
				$this->load->model('personallogs_model', 'logs');
				
				$config['base_url'] = site_url('manage/comments/logs/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$logs = $this->logs->get_log_comments('', $status, 'lcomment_date', 'desc');
				
				$data['entries'] = NULL;
				
				if ($logs->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($logs->result() as $l)
					{
						$date = gmt_to_local($l->lcomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$l->lcomment_id]['id'] = $l->lcomment_id;
						$data['entries'][$l->lcomment_id]['content'] = ($l->lcomment_status == 'pending') ? $l->lcomment_content : word_limiter($l->lcomment_content, 25);
						$data['entries'][$l->lcomment_id]['author'] = $this->char->get_authors($l->lcomment_author_character, TRUE);
						$data['entries'][$l->lcomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$l->lcomment_id]['source'] = anchor('sim/viewlog/'. $l->lcomment_log, $this->logs->get_log($l->lcomment_log, 'log_title'));
						$data['entries'][$l->lcomment_id]['status'] = $l->lcomment_status;
					}
				}
		
				$config['total_rows'] = $this->logs->count_all_log_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_logs';
				
				break;
				
			case 'news':
				$this->load->model('news_model', 'news');
				
				$config['base_url'] = site_url('manage/comments/news/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$news = $this->news->get_news_comments('', $status, 'ncomment_date', 'desc');
				
				$data['entries'] = NULL;
				
				if ($news->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($news->result() as $n)
					{
						$date = gmt_to_local($n->ncomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$n->ncomment_id]['id'] = $n->ncomment_id;
						$data['entries'][$n->ncomment_id]['content'] = ($n->ncomment_status == 'pending') ? $n->ncomment_content : word_limiter($n->ncomment_content, 25);
						$data['entries'][$n->ncomment_id]['author'] = $this->char->get_authors($n->ncomment_author_character, TRUE);
						$data['entries'][$n->ncomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$n->ncomment_id]['source'] = anchor('main/viewnews/'. $n->ncomment_news, $this->news->get_news_item($n->ncomment_news, 'news_title'));
						$data['entries'][$n->ncomment_id]['status'] = $n->ncomment_status;
					}
				}
		
				$config['total_rows'] = $this->news->count_news_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_news';
				
				break;
				
			case 'wiki':
				$this->load->model('wiki_model', 'wiki');
				
				$config['base_url'] = site_url('manage/comments/wiki/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$wiki = $this->wiki->get_comments('', $status);
				
				$data['entries'] = NULL;
				
				if ($wiki->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($wiki->result() as $w)
					{
						/* set the comment ID */
						$wid = $w->wcomment_id;
						
						/* set the date */
						$date = gmt_to_local($w->wcomment_date, $this->timezone, $this->dst);
						
						/* grab the wiki page info */
						$page = $this->wiki->get_page($w->wcomment_page);
						
						if ($page->num_rows() > 0)
						{
							$row = $page->row();
								
							$data['entries'][$wid]['id'] = $wid;
							$data['entries'][$wid]['content'] = ($w->wcomment_status == 'pending') ? $w->wcomment_content : word_limiter($w->wcomment_content, 25);
							$data['entries'][$wid]['author'] = $this->char->get_authors($w->wcomment_author_character, TRUE);
							$data['entries'][$wid]['date'] = mdate($datestring, $date);
							$data['entries'][$wid]['source'] = anchor('wiki/view/page/'. $row->page_id, $row->draft_title);
							$data['entries'][$wid]['status'] = $w->wcomment_status;
						}
					}
				}
		
				$config['total_rows'] = $this->wiki->count_all_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_wiki';
				
				break;
		}
		
		$data['status'] = $status;
		$data['page'] = $offset;
		$data['type'] = $type;
		
		$data['images'] = array(
	    	'edit' => array(
	    		'src' => img_location('comment-edit.png', $this->skin, 'admin'),
	    		'alt' => ucfirst(lang('actions_edit')),
	    		'title' => ucfirst(lang('actions_edit')),
	    		'class' => 'image'),
	    	'delete' => array(
	    		'src' => img_location('comment-delete.png', $this->skin, 'admin'),
	    		'alt' => ucfirst(lang('actions_delete')),
	    		'title' => ucfirst(lang('actions_delete')),
	    		'class' => 'image'),
	    	'approve' => array(
	    		'src' => img_location('comment-approve.png', $this->skin, 'admin'),
	    		'alt' => ucfirst(lang('actions_approve')),
	    		'title' => ucfirst(lang('actions_approve')),
	    		'class' => 'image'),
	    );
		
		$data['label'] = array(
	    	'mission' => ucfirst(lang('global_mission')),
	    	'on' => lang('labels_on'),
	    	'header_posts' => ucwords($status .' '. lang('global_missionpost') .' '.
	    		lang('labels_comments')),
	    	'header_logs' => ucwords($status .' '. lang('global_personallog') .' '.
	    		lang('labels_comments')),
	    	'header_news' => ucwords($status .' '. lang('global_news') .' '.
	    		lang('labels_comments')),
	    	'header_wiki' => ucwords($status .' '. lang('global_wiki') .' '.
	    		lang('labels_comments')),
	    	'error' => ucfirst(lang('labels_no') .' '. lang('labels_comments') .' '.
	    		lang('actions_found')),
	    );
	    
	    /* figure out where the view is coming from */
	    $loc = view_location('manage_comments_ajax', $this->skin, 'admin');
	    
	    /* parse the message */
		$message = $this->parser->parse($loc, $data, TRUE);

	    return $message;
	}
	
	function _email($type = '', $data = '')
	{
		/* load the libraries */
		$this->load->library('email');
		$this->load->library('parser');
		
		/* load the language file */
		$this->lang->load('email');
		
		/* define the variables */
		$email = FALSE;
		
		switch ($type)
		{
			case 'news':
				/* set some variables */
				$from_name = $this->char->get_character_name($data['author'], TRUE, TRUE);
				$from_email = $this->user->get_email_address('character', $data['author']);
				$subject = $data['category'] .' - '. $data['title'];
				
				/* set the content */
				$content = sprintf(
					lang('email_content_news_item'),
					$from_name,
					$data['content']
				);
				
				/* set the email data */
				$email_data = array(
					'email_subject' => $subject,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('write_newsitem', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* get the email addresses */
				$emails = $this->user->get_crew_emails(TRUE, 'email_news_items');
				
				/* make a string of email addresses */
				$to = implode(',', $emails);
				
				/* set the parameters for sending the email */
				$this->email->from($from_email, $from_name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
				
				break;
				
			case 'log':
				/* set some variables */
				$from_name = $this->char->get_character_name($data['author'], TRUE, TRUE);
				$from_email = $this->user->get_email_address('character', $data['author']);
				$subject = $from_name ."'s ". lang('email_subject_personal_log') ." - ". $data['title'];
				
				/* set the content */
				$content = sprintf(
					lang('email_content_personal_log'),
					$from_name,
					$data['content']
				);
				
				/* set the email data */
				$email_data = array(
					'email_subject' => $subject,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('write_personallog', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* get the email addresses */
				$emails = $this->user->get_crew_emails(TRUE, 'email_personal_logs');
				
				/* make a string of email addresses */
				$to = implode(',', $emails);
				
				/* set the parameters for sending the email */
				$this->email->from($from_email, $from_name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
				
				break;
				
			case 'post':
				/* set some variables */
				$subject = $data['mission'] ." - ". $data['title'];
				$mission = lang('email_content_post_mission') . $data['mission'];
				$authors = lang('email_content_post_author') . $this->char->get_authors($data['authors'], TRUE);
				$timeline = lang('email_content_post_timeline') . $data['timeline'];
				$location = lang('email_content_post_location') . $data['location'];
				
				/* figure out who it needs to come from */
				$my_chars = array();
				
				/* find out how many of the submitter's characters are in the string */
				foreach ($this->session->userdata('characters') as $value)
				{
					if (strstr($data['authors'], $value) !== FALSE)
					{
						$my_chars[] = $value;
					}
				}
				
				/* set who the email is coming from */
				$from_name = $this->char->get_character_name($my_chars[0], TRUE, TRUE);
				$from_email = $this->user->get_email_address('character', $my_chars[0]);
				
				/* set the content */
				$content = sprintf(
					lang('email_content_mission_post'),
					$authors,
					$mission,
					$location,
					$timeline,
					$data['content']
				);
				
				/* set the email data */
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('write_missionpost', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* get the email addresses */
				$emails = $this->user->get_crew_emails(TRUE, 'email_mission_posts');
				
				/* make a string of email addresses */
				$to = implode(',', $emails);
				
				/* set the parameters for sending the email */
				$this->email->from($from_email, $from_name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
				
				break;
				
			case 'log_comment':
				/* load the models */
				$this->load->model('personallogs_model', 'logs');
				
				/* run the methods */
				$row = $this->logs->get_log($data['log']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->log_author);
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_log_comment_added'),
					"<strong>". $row->log_title ."</strong>",
					$data['comment']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_log_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('sim_log_comment', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'news_comment':
				/* load the models */
				$this->load->model('news_model', 'news');
				
				/* run the methods */
				$row = $this->news->get_news_item($data['news_item']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->news_author_character);
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_news_comment_added'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_news_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('main_news_comment', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'post_comment':
				$this->load->model('posts_model', 'posts');
				
				$row = $this->posts->get_post($data['post']);
				
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				
				$authors = $this->posts->get_author_emails($data['post']);
				
				foreach ($authors as $key => $value)
				{
					$user = $this->user->get_user_id_from_email($value);
					
					$pref = $this->user->get_pref('email_new_post_comments', $user);
					
					if ($pref == 'n' || $pref == '')
					{
						unset($authors[$key]);
					}
				}
				
				$to = implode(',', $authors);
				
				$content = sprintf(
					lang('email_content_post_comment_added'),
					"<strong>". $row->post_title ."</strong>",
					$data['comment']
				);
				
				$email_data = array(
					'email_subject' => lang('email_subject_post_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				$em_loc = email_location('sim_post_comment', $this->email->mailtype);
				
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
				
				break;
				
			case 'wiki_comment':
				/* load the models */
				$this->load->model('wiki_model', 'wiki');
				
				/* run the methods */
				$page = $this->wiki->get_page($data['page']);
				$row = $page->row();
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				
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
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
	
	function _entries_ajax($offset = 0, $status = 'activated', $section = '')
	{
		/* load the resources */
		$this->load->library('pagination');
		$this->load->library('parser');
		
		switch ($section)
		{
			case 'posts':
				$this->load->model('missions_model', 'mis');
				$this->load->model('posts_model', 'posts');
				
				$config['base_url'] = site_url('manage/posts/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$posts = $this->posts->get_post_list('', 'desc', $config['per_page'], $offset, $status);
				
				$data['entries'] = NULL;
				
				if ($posts->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($posts->result() as $p)
					{
						if ($this->auth->get_access_level('manage/posts') == 1)
						{
							$valid = array();
							
							foreach ($this->session->userdata('characters') as $c)
							{
								if (strstr($p->post_authors, $c))
								{
									$valid[] = TRUE;
								}
								else
								{
									$valid[] = FALSE;
								}
							}
							
							if (in_array(TRUE, $valid))
							{
								$date = gmt_to_local($p->post_date, $this->timezone, $this->dst);
								
								$data['entries'][$p->post_id]['id'] = $p->post_id;
								$data['entries'][$p->post_id]['title'] = $p->post_title;
								$data['entries'][$p->post_id]['author'] = $this->char->get_authors($p->post_authors, TRUE);
								$data['entries'][$p->post_id]['date'] = mdate($datestring, $date);
								$data['entries'][$p->post_id]['mission'] = $this->mis->get_mission($p->post_mission, 'mission_title');
								$data['entries'][$p->post_id]['status'] = $p->post_status;
							}
						}
						elseif ($this->auth->get_access_level('manage/posts') == 2)
						{
							$date = gmt_to_local($p->post_date, $this->timezone, $this->dst);
							
							$data['entries'][$p->post_id]['id'] = $p->post_id;
							$data['entries'][$p->post_id]['title'] = $p->post_title;
							$data['entries'][$p->post_id]['author'] = $this->char->get_authors($p->post_authors, TRUE);
							$data['entries'][$p->post_id]['date'] = mdate($datestring, $date);
							$data['entries'][$p->post_id]['mission'] = $this->mis->get_mission($p->post_mission, 'mission_title');
							$data['entries'][$p->post_id]['status'] = $p->post_status;
						}
					}
				}
		
				$config['total_rows'] = $this->posts->count_all_posts('', $status);
				
			    /* initialize the pagination library */
				$this->pagination->initialize($config);
				
				/* create the page links */
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				$data['section'] = $section;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => img_location('write-post-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => img_location('write-post-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => img_location('write-post-approve.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => img_location('write-post-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				/* figure out where the view is coming from */
	    		$loc = view_location('manage_posts_ajax', $this->skin, 'admin');
		
				break;
				
			case 'logs':
				$this->load->model('personallogs_model', 'logs');
				
				$config['base_url'] = site_url('manage/logs/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$logs = $this->logs->get_log_list($config['per_page'], $offset, $status);
				
				$data['entries'] = NULL;
				
				if ($logs->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($logs->result() as $l)
					{
						if ($this->auth->get_access_level('manage/logs') == 1)
						{
							if ($this->session->userdata('userid') == $l->log_author_user)
							{
								$date = gmt_to_local($l->log_date, $this->timezone, $this->dst);
								
								$data['entries'][$l->log_id]['id'] = $l->log_id;
								$data['entries'][$l->log_id]['title'] = $l->log_title;
								$data['entries'][$l->log_id]['author'] = $this->char->get_character_name($l->log_author_character, TRUE);
								$data['entries'][$l->log_id]['date'] = mdate($datestring, $date);
								$data['entries'][$l->log_id]['status'] = $l->log_status;
							}
						}
						elseif ($this->auth->get_access_level('manage/logs') == 2)
						{
							$date = gmt_to_local($l->log_date, $this->timezone, $this->dst);
							
							$data['entries'][$l->log_id]['id'] = $l->log_id;
							$data['entries'][$l->log_id]['title'] = $l->log_title;
							$data['entries'][$l->log_id]['author'] = $this->char->get_character_name($l->log_author_character, TRUE);
							$data['entries'][$l->log_id]['date'] = mdate($datestring, $date);
							$data['entries'][$l->log_id]['status'] = $l->log_status;
						}
					}
				}
		
				$config['total_rows'] = $this->logs->count_all_logs($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => img_location('write-log-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => img_location('write-log-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => img_location('write-log-approve.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => img_location('write-log-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				/* figure out where the view is coming from */
	    		$loc = view_location('manage_logs_ajax', $this->skin, 'admin');
	    		
	    		break;
				
			case 'news':
				$this->load->model('news_model', 'news');
				
				$config['base_url'] = site_url('manage/news/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : FALSE;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$news = $this->news->get_news_list($config['per_page'], $offset, $status);
				
				$data['entries'] = NULL;
				
				if ($news->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($news->result() as $n)
					{
						if ($this->auth->get_access_level('manage/news') == 1)
						{
							if ($this->session->userdata('userid') == $n->news_author_user)
							{
								$date = gmt_to_local($n->news_date, $this->timezone, $this->dst);
								$nid = $n->news_id;
								
								$data['entries'][$nid]['id'] = $nid;
								$data['entries'][$nid]['title'] = $n->news_title;
								$data['entries'][$nid]['author'] = $this->char->get_character_name($n->news_author_character, TRUE);
								$data['entries'][$nid]['date'] = mdate($datestring, $date);
								$data['entries'][$nid]['category'] = $n->newscat_name;
								$data['entries'][$nid]['status'] = $n->news_status;
							}
						}
						elseif ($this->auth->get_access_level('manage/logs') == 2)
						{
							$date = gmt_to_local($n->news_date, $this->timezone, $this->dst);
							$nid = $n->news_id;
							
							$data['entries'][$nid]['id'] = $nid;
							$data['entries'][$nid]['title'] = $n->news_title;
							$data['entries'][$nid]['author'] = $this->char->get_character_name($n->news_author_character, TRUE);
							$data['entries'][$nid]['date'] = mdate($datestring, $date);
							$data['entries'][$nid]['category'] = $n->newscat_name;
							$data['entries'][$nid]['status'] = $n->news_status;
						}
					}
				}
		
				$config['total_rows'] = $this->news->count_news_items($status);
				
			    $this->pagination->initialize($config);
			    
			    /* create the page links */
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => img_location('write-news-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => img_location('write-news-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => img_location('write-news-approve.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => img_location('write-news-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				/* figure out where the view is coming from */
	    		$loc = view_location('manage_news_ajax', $this->skin, 'admin');
		
				break;
		}
		
		$data['label'] = array(
	    	'mission' => ucfirst(lang('global_mission')),
	    	'by' => lang('labels_by'),
	    	'category' => ucfirst(lang('labels_category')) .':',
	    	'header_posts' => ucwords($status .' '. lang('global_missionposts')),
	    	'header_logs' => ucwords($status .' '. lang('global_personallogs')),
	    	'header_news' => ucwords($status .' '. lang('global_newsitems')),
	    	'error_posts' => ucfirst(lang('labels_no') .' '. lang('global_missionposts') .' '.
	    		lang('actions_found')),
			'error_logs' => ucfirst(lang('labels_no') .' '. lang('global_personallogs') .' '.
	    		lang('actions_found')),
	    	'error_news' => ucfirst(lang('labels_no') .' '. lang('global_newsitems') .' '.
	    		lang('actions_found')),
	    );
	    
	    /* parse the message */
		$message = $this->parser->parse($loc, $data, TRUE);

	    return $message;
	}
}

/* End of file manage_base.php */
/* Location: ./application/controllers/manage_base.php */