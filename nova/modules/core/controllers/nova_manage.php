<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Manage controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_manage extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
		
		// load the user agent library
		$this->load->library('user_agent');
	}

	public function awards($action = false, $award = false)
	{
		// check access
		Auth::check_access();
		
		// load the resources
		$this->load->model('awards_model', 'awards');
		
		// sanity check
		$award = (is_numeric($award)) ? $award : false;
		
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'add':
					$insert_array = array(
						'award_name' => $this->input->post('award_name', true),
						'award_order' => $this->input->post('award_order', true),
						'award_display' => $this->input->post('award_display', true),
						'award_cat' => $this->input->post('award_cat', true),
						'award_desc' => $this->input->post('award_desc', true),
						'award_image' => $this->input->post('award_image', true),
					);
					
					// insert the record
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
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
				break;
					
				case 'edit':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 6) == 'award_')
						{
							$award_data[$key] = $value;
						}
					}
					
					$update = $this->awards->update_award($id, $award_data);
					
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($action == 'add' or $action == 'edit')
		{
			$item = ($action == 'edit') ? $this->sys->get_item('awards', 'award_id', $award) : false;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_award'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->award_name : '';
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'award_name',
					'value' => ( ! $item) ? '' : $item->award_name),
				'order' => array(
					'name' => 'award_order',
					'class' => 'small',
					'value' => ( ! $item) ? 99 : $item->award_order),
				'desc' => array(
					'name' => 'award_desc',
					'rows' => 10,
					'value' => ( ! $item) ? '' : $item->award_desc),
				'images' => array(
					'name' => 'award_image',
					'id' => 'images',
					'value' => ($action == 'edit') ? $item->award_image : ''),
				'display_y' => array(
					'name' => 'award_display',
					'id' => 'display_y',
					'value' => 'y',
					'checked' => ($item !== false and $item->award_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'award_display',
					'id' => 'display_n',
					'value' => 'n',
					'checked' => ($item !== false and $item->award_display == 'n') ? true : false),
				'cat' => ( ! $item) ? '' : $item->award_cat,
				'submit' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			if ( ! $item)
			{
				$data['inputs']['display_y']['checked'] = true;
			}
			
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
							'src' => Location::asset('images/awards', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $award : 'add';
			$data['id'] = $award;
			
			$view_loc = 'manage_awards_action';
		}
		else
		{
			// grab all the awards from the database
			$awards = $this->awards->get_all_awards('asc', '');
			
			if ($awards->num_rows() > 0)
			{
				foreach ($awards->result() as $a)
				{
					$data['awards'][$a->award_id] = array(
						'id' => $a->award_id,
						'img' => array(
							'src' => Location::asset('images/awards', $a->award_image),
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
			
			$view_loc = 'manage_awards';
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_add'))),
			'upload' => array(
				'src' => Location::img('image-upload.png', $this->skin, 'admin'),
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
			'noawards' => sprintf(lang('error_not_found'), lang('global_awards')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_awards_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function comments($type = 'posts', $section = 'activated', $offset = 0)
	{
		Auth::check_access();
		
		// arrays to check against
		$types = array('posts', 'logs', 'news', 'wiki');
		$values = array('activated', 'pending', 'edit');
		
		// sanity checks
		$type = (in_array($type, $types)) ? $type : 'posts';
		$section = (in_array($section, $values)) ? $section : 'activated';
		$offset = (is_numeric($offset)) ? $offset : 0;
		
		// load the resources
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('news_model', 'news');
		$this->load->model('wiki_model', 'wiki');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(6))
			{
				case 'approve':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
						
						// send the email
						$email = ($this->options['system_email'] == 'on') ? $this->_email($email_type, $email_data) : false;
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
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
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
					
					$id = false;
					
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
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					$delete = 0;
					
					switch ($type)
					{
						case 'posts':
							$update_array = array('pcomment_content' => $this->input->post('pcomment_content', true));
							$update = $this->posts->update_post_comment($id, $update_array);
							$item = ucfirst(lang('global_missionpost'));
						break;
							
						case 'logs':
							$update_array = array('lcomment_content' => $this->input->post('lcomment_content', true));
							$update = $this->logs->update_log_comment($id, $update_array);
							$item = ucfirst(lang('global_personllog'));
						break;
							
						case 'news':
							$update_array = array('ncomment_content' => $this->input->post('ncomment_content', true));
							$update = $this->news->update_news_comment($id, $update_array);
							$item = ucfirst(lang('global_newsitem'));
						break;
							
						case 'wiki':
							$update_array = array('wcomment_content' => $this->input->post('wcomment_content', true));
							$update = $this->wiki->update_comment($id, $update_array);
							$item = ucfirst(lang('global_wiki'));
						break;
					}
					
					$id = false;
					
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
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$p_activated = ($section == 'activated' and $type == 'posts') ? $offset : 0;
		$p_pending = ($section == 'pending' and $type == 'posts') ? $offset : 0;
		
		$l_activated = ($section == 'activated' and $type == 'logs') ? $offset : 0;
		$l_pending = ($section == 'pending' and $type == 'logs') ? $offset : 0;
		
		$n_activated = ($section == 'activated' and $type == 'news') ? $offset : 0;
		$n_pending = ($section == 'pending' and $type == 'news') ? $offset : 0;
		
		$w_activated = ($section == 'activated' and $type == 'wiki') ? $offset : 0;
		$w_pending = ($section == 'pending' and $type == 'wiki') ? $offset : 0;
		
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
				'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
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
			default:
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
		}
		
		$js_data['section'] = ($section == 'pending') ? 1 : 0;
		
		$this->_regions['content'] = Location::view('manage_comments', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_comments_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function decks($deck = false)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('tour_model', 'tour');
		$this->load->model('specs_model', 'specs');
		
		// sanity check
		$deck = (is_numeric($deck)) ? $deck : false;
		
		if (isset($_POST['submit']))
		{
			$name = $this->input->post('deck_name', true);
			$content = $this->input->post('deck_content', true);
			$item = $this->input->post('deck_item', true);
			$id = $this->input->post('id', true);
			
			$update_array = array(
				'deck_name' => $name,
				'deck_content' => $content,
				'deck_item' => $item,
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
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($deck == 0)
		{
			// get the specification items
			$specs = $this->specs->get_spec_items(null);
			
			if ($specs->num_rows() > 0)
			{
				foreach ($specs->result() as $s)
				{
					$data['specs'][$s->specs_id] = $s->specs_name;
				}
			}
		}
		else
		{
			$decks = $this->tour->get_decks($deck);
			
			if ($decks->num_rows() > 0)
			{
				foreach ($decks->result() as $deck)
				{
					$data['decks'][$deck->deck_id] = $deck->deck_name;
				}
			}
		}
		
		$data['header'] = ucwords(lang('global_deck') .' '. lang('labels_listings'));
		
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
		
		// get the specification items
		$specs = $this->specs->get_spec_items(null);
		
		$data['values']['specs'][0] = ucwords(lang('actions_choose').' '.lang('labels_a').' '.lang('global_specification').' '.lang('labels_item'));
		
		if ($specs->num_rows() > 0)
		{
			foreach ($specs->result() as $s)
			{
				$data['values']['specs'][$s->specs_id] = $s->specs_name;
			}
		}
		
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
			'src' => Location::img('loading-bar.gif', $this->skin, 'admin'),
			'alt' => '',
			'class' => 'image'
		);
		
		$data['label'] = array(
			'processing' => ucfirst(lang('actions_processing')) .'...',
			'back' => LARROW.' '.ucfirst(lang('actions_back')).' '.lang('labels_to').' '.
				ucwords(lang('labels_all').' '.lang('global_deck').' '.lang('labels_listings')),
		);
		
		$this->_regions['content'] = Location::view('manage_decks', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_decks_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function depts()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('depts_model', 'dept');
		
		// set the variables
		$section = $this->uri->segment(4, 'assigned');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'dept_name' => $this->input->post('dept_name', true),
						'dept_type' => $this->input->post('dept_type', true),
						'dept_order' => $this->input->post('dept_order', true),
						'dept_display' => $this->input->post('dept_display', true),
						'dept_desc' => $this->input->post('dept_desc', true),
						'dept_parent' => $this->input->post('dept_parent', true),
						'dept_manifest' => $this->input->post('dept_manifest', true),
					);
					
					// insert the record
					$insert = $this->dept->add_dept($insert_array);
					
					// optimize the table
					$this->sys->optimize_table('departments_'.GENRE);
					
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
				break;
					
				case 'edit':
					// grab the ID
					$id = $this->input->post('id', true);
					$id = ( ! is_numeric($id)) ? false : $id;
					
					// build the array to update the record with
					$update_array = array(
						'dept_name' => $this->input->post('dept_name', true),
						'dept_type' => $this->input->post('dept_type', true),
						'dept_order' => $this->input->post('dept_order', true),
						'dept_display' => $this->input->post('dept_display', true),
						'dept_desc' => $this->input->post('dept_desc', true),
						'dept_parent' => $this->input->post('dept_parent', true),
						'dept_manifest' => $this->input->post('dept_manifest', true),
					);
					
					// update the record
					$update = $this->dept->update_dept($id, $update_array);
					
					// optimize the table
					$this->sys->optimize_table('departments_'.GENRE);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_department')),
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
							ucfirst(lang('global_department')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$all = $this->input->post('delete', true);
					$deptid = $this->input->post('dept', true);
					$id = $this->input->post('id', true);
					$subdept = (isset($_POST['subdept'])) ? $this->input->post('subdept', true) : false;
					
					// load the positions model
					$this->load->model('positions_model', 'pos');
					
					// grab the positions for the department
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
					
					if ($subdept !== false)
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
					
					// delete the department
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
				break;
					
				case 'duplicate':
					$id = $this->input->post('id', true);
					
					// load the positions model
					$this->load->model('positions_model', 'pos');
					
					// get the department information
					$dpt = $this->dept->get_dept($id);
					
					// clear out the department id
					unset($dpt->dept_id);
					
					// make sure the manifest and parent values are reset
					$dpt->dept_manifest = 0;
					$dpt->dept_parent = 0;
					
					// create the new department
					$insert = $this->dept->add_dept($dpt);
					$deptid = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('departments_'.GENRE);
					
					// get all positions for the original department
					$positions = $this->pos->get_dept_positions($id, null);
					
					if ($positions->num_rows() > 0)
					{
						foreach ($positions->result() as $p)
						{
							// put the data into an array
							$insert_array = array(
								'pos_name' => $p->pos_name,
								'pos_desc' => $p->pos_desc,
								'pos_dept' => $deptid,
								'pos_order' => $p->pos_order,
								'pos_open' => $p->pos_open,
								'pos_display' => $p->pos_display,
								'pos_type' => $p->pos_type,
							);
							
							// create the position
							$insert += $this->pos->add_position($insert_array);
						}
					}
					
					// total count
					$count = 1 + $positions->num_rows();
					
					if ($insert == $count)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_department')),
							lang('actions_duplicated'),
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
							lang('actions_duplicated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$departments = $this->dept->get_all_depts('asc', '');
		$manifests = $this->dept->get_all_manifests(null);
		
		if ($departments->num_rows() > 0)
		{
			foreach ($departments->result() as $d)
			{
				// make sure we have the manifest ID set properly
				$manifest = ($d->dept_manifest === null) ? 0 : $d->dept_manifest;
				
				$data['depts'][$manifest][$d->dept_id] = $d;
				
				$subs = $this->dept->get_sub_depts($d->dept_id);
				
				if ($subs->num_rows() > 0)
				{
					foreach ($subs->result() as $s)
					{
						$data['subs'][$d->dept_id][$s->dept_id]['data'] = $s;
						$data['subs'][$d->dept_id][$s->dept_id]['parent'] = $this->dept->get_dept($s->dept_parent, 'dept_name');
					}
				}
			}
			
			if ($manifests->num_rows() > 0)
			{
				foreach ($manifests->result() as $m)
				{
					$data['manifests'][$m->manifest_id] = $m->manifest_name;
				}
			}
			
			$data['manifests'][0] = ucwords(lang('labels_unassigned').' '.lang('global_departments'));
		}
		
		$data['parent'][0] = ucfirst(lang('labels_none'));
		$data['manifest'][0] = ucfirst(lang('labels_none'));
		
		$data['header'] = ucfirst(lang('global_departments'));
		$data['text'] = sprintf(
			lang('text_manage_depts'),
			lang('global_departments'),
			lang('global_positions'),
			lang('global_departments'),
			lang('global_departments'),
			lang('global_department'),
			lang('global_positions'),
			lang('global_department'),
			lang('global_departments'),
			lang('global_positions'),
			lang('global_characters')
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
			'parent' => ucwords(lang('labels_parent') .' '. lang('global_department')),
			'assigned' => ucwords(lang('actions_assigned').' '.lang('global_departments')),
			'unassigned' => ucwords(lang('labels_unassigned').' '.lang('global_departments')),
			'manifest' => ucfirst(lang('labels_manifest')),
			'no_unassigned' => sprintf(lang('error_not_found'), lang('labels_unassigned').' '.lang('global_departments')),
			'sub_of' => ucfirst(lang('global_subdepartment').' '.lang('labels_of').' '),
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
			'duplicate' => array(
				'src' => Location::img('icon-duplicate.png', $this->skin, 'admin'),
				'alt' => lang('actions_duplicate'),
				'title' => ucfirst(lang('actions_duplicate')),
				'class' => 'image'),
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update'))),
		);
		
		$js_data['tab'] = ($section == 'assigned') ? 0 : 1;
		
		$this->_regions['content'] = Location::view('manage_depts', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_depts_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function docked($section = 'active', $id = false)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('docking_model', 'docking');
		$this->load->helper('utility');
		
		if (isset($_POST['submit']))
		{
			switch ($section)
			{
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					$delete = $this->docking->delete_docked_item($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docked') .' '. lang('labels_item')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						$this->docking->delete_docking_field_data($id, 'data_docking_item');
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('actions_docked') .' '. lang('labels_item')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					foreach ($_POST as $key => $value)
					{
						if ( ! is_numeric($key))
						{
							$update_array[$key] = $value;
						}
					}
					
					// take unnecessary items off the array
					unset($update_array['submit']);
					unset($update_array['action_id']);
					
					$action_id = $this->input->post('action_id', true);
					
					// put the record into the database
					$update = $this->docking->update_docking_record($update_array, $action_id);
					
					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							$array = array(
								'data_field' => $key,
								'data_docking_item' => $action_id,
								'data_value' => $value,
								'data_updated' => now()
							);
							
							$this->docking->update_docking_data($array, $action_id, $key);
						}
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docked') .' '. lang('labels_item')),
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
							ucfirst(lang('actions_docked') .' '. lang('labels_item')),
							lang('actions_updated'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'pending':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					$action = $this->input->post('action', true);
					
					if ($action == 'approve')
					{
						$update_array = array('docking_status' => 'active');
						
						$update = $this->docking->update_docking_record($update_array, $id);
						
						// grab the message
						$message = $this->msgs->get_message('docking_accept_message');
						
						$item = $this->docking->get_docked_item($id);
						
						// set the arguments for the message
						$args = array(
							'gm_name' => ( ! empty($item->docking_gm_name)) ? $item->docking_gm_name : $item->docking_gm_email,
							'sim_name' => $item->docking_sim_name,
							'sim' => $this->options['sim_name']
						);
						
						// parse the message with the args
						$content = parse_dynamic_message($message, $args);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('actions_docked') .' '. lang('labels_item')),
								lang('actions_approved'),
								''
							);
			
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);

							$currentUser = $this->user->get_user($this->session->userdata('userid'));
							
							$emailData = array(
								'message'	=> $content,
								'email' 	=> $item->docking_gm_email,
								'name' 		=> $item->docking_gm_name,
								'sim' 		=> $item->docking_sim_name,
								'fromEmail' => $currentUser->email,
								'fromName'	=> $this->char->get_character_name($currentUser->main_char, true, true),
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('docking_accept', $emailData) : false;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('actions_docked') .' '. lang('labels_item')),
								lang('actions_approved'),
								''
							);
			
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
					elseif ($action == 'reject')
					{
						// grab the message
						$message = $this->msgs->get_message('docking_reject_message');
						
						// grab the info for the item being rejected
						$item = $this->docking->get_docked_item($id);
						
						// set the arguments for the message
						$args = array(
							'gm_name' => ( ! empty($item->docking_gm_name)) ? $item->docking_gm_name : $item->docking_gm_email,
							'sim_name' => $item->docking_sim_name,
							'sim' => $this->options['sim_name']
						);
						
						// parse the message with the args
						$content = parse_dynamic_message($message, $args);
						
						// delete the record and its data
						$delete = $this->docking->delete_docked_item($id);
						$delete+= $this->docking->delete_docking_field_data($id, 'data_docking_item');
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('actions_docked') .' '. lang('labels_item')),
								lang('actions_rejected'),
								''
							);
			
							$flash['status'] = 'success';
							$flash['message'] = text_output($message);

							$currentUser = $this->user->get_user($this->session->userdata('userid'));
							
							$emailData = array(
								'message'	=> $content,
								'email' 	=> $item->docking_gm_email,
								'name' 		=> $item->docking_gm_name,
								'sim' 		=> $item->docking_sim_name,
								'fromEmail' => $currentUser->email,
								'fromName'	=> $this->char->get_character_name($currentUser->main_char, true, true),
							);
							
							$email = ($this->options['system_email'] == 'on') ? $this->_email('docking_reject', $emailData) : false;
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('actions_docked') .' '. lang('labels_item')),
								lang('actions_rejected'),
								''
							);
			
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($section == 'edit')
		{
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			// grab the post data
			$row = $this->docking->get_docked_item($id);
			
			// set the data used by the view
			$data['inputs'] = array(
				'sim_name' => array(
					'name' => 'docking_sim_name',
					'id' => 'sim_name',
					'value' => $row->docking_sim_name),
				'sim_url' => array(
					'name' => 'docking_sim_url',
					'id' => 'sim_url',
					'value' => $row->docking_sim_url),
				'gm_name' => array(
					'name' => 'docking_gm_name',
					'id' => 'gm_name',
					'value' => $row->docking_gm_name),
				'gm_email' => array(
					'name' => 'docking_gm_email',
					'id' => 'gm_email',
					'value' => $row->docking_gm_email),
			);
			
			$data['values'] = array(
				'active' => ucfirst(lang('status_active')),
				'inactive' => ucfirst(lang('status_inactive')),
				'pending' => ucfirst(lang('status_pending')),
			);
			
			// grab the join fields
			$sections = $this->docking->get_docking_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$sid = $sec->section_id;
					
					// set the section name
					$data['docking'][$sid]['name'] = $sec->section_name;
					
					// grab the fields for the given section
					$fields = $this->docking->get_docking_fields($sec->section_id);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$f_id = $field->field_id;
							
							// set the page label
							$data['docking'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
							
							$field_data = $this->docking->get_field_data($f_id, $id);

							$frow = ($field_data->num_rows() > 0) ? $field_data->row() : false;
							
							switch ($field->field_type)
							{
								case 'text':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $frow->data_value
									);
									
									$data['docking'][$sid]['fields'][$f_id]['input'] = form_input($input);
								break;
									
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $frow->data_value,
										'rows' => $field->field_rows
									);
									
									$data['docking'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
								break;
									
								case 'select':
									$value = false;
									$values = false;
									$input = false;
								
									$values = $this->docking->get_docking_values($field->field_id);
									
									if ($values->num_rows() > 0)
									{
										foreach ($values->result() as $value)
										{
											$input[$value->value_field_value] = $value->value_content;
										}
									}
									
									$data['docking'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input, $frow->data_value);
								break;
							}
						}
					}
				}
			}
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('actions_docked') .' '. lang('labels_item'));
			$data['id'] = $id;
			$data['status'] = $row->docking_status;
			
			$js_data['tab'] = 0;
			
			// figure out where the view should be coming from
			$view_loc = 'manage_docked_edit';
		}
		else
		{
			$items = $this->docking->get_docked_items();
			
			if ($items->num_rows() > 0)
			{
				foreach ($items->result() as $i)
				{
					$data['docking'][$i->docking_status][$i->docking_id] = array(
						'sim_name' => $i->docking_sim_name,
						'sim_url' => $i->docking_sim_url,
						'gm_name' => $i->docking_gm_name,
						'id' => $i->docking_id
					);
				}
			}
			
			$data['header'] = ucwords(lang('actions_docked') .' '. lang('labels_items'));
			
			$data['count'] = (isset($data['docking']['pending'])) ? count($data['docking']['pending']) : 0;
			
			// figure out where the view should be coming from
			$view_loc = 'manage_docked';
			
			switch ($section)
			{
				case 'active':
				default:
					$js_data['tab'] = 0;
				break;
					
				case 'inactive':
					$js_data['tab'] = 1;
				break;
					
				case 'pending':
					$js_data['tab'] = 2;
				break;
			}
		}
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucfirst(lang('actions_update'))),
		);
		
		$data['images'] = array(
			'accept' => array(
				'src' => Location::img('icon-check.png', $this->skin, 'admin'),
				'alt' => lang('actions_accept'),
				'class' => 'image',
				'title' => ucfirst(lang('actions_accept'))),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'class' => 'image',
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'class' => 'image',
				'title' => ucfirst(lang('actions_edit'))),
			'reject' => array(
				'src' => Location::img('icon-slash.png', $this->skin, 'admin'),
				'alt' => lang('actions_reject'),
				'class' => 'image',
				'title' => ucfirst(lang('actions_reject'))),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'class' => 'image',
				'title' => ucfirst(lang('actions_view'))),
		);
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('actions_docked') .' '. lang('labels_items')),
			'email' => ucwords(lang('labels_email_address')),
			'gm_info' => ucwords(lang('global_game_master') .' '. lang('labels_information')),
			'info' => ucwords(lang('global_sim') .' '. lang('labels_information')),
			'name' => ucfirst(lang('labels_name')),
			'noitems' => sprintf(lang('error_not_found'), lang('actions_docked') .' '. lang('labels_items')),
			'sim_name' => ucwords(lang('global_sim') .' '. lang('labels_name')),
			'sim_url' => ucfirst(lang('global_sim') .' '. lang('abbr_url')),
			'status' => ucfirst(lang('labels_status')),
			'status_active' => ucwords(lang('status_active') .' '. lang('labels_items')),
			'status_inactive' => ucwords(lang('status_inactive') .' '. lang('labels_items')),
			'status_pending' => ucwords(lang('status_pending') .' '. lang('labels_items')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_docked_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function logs($section = 'activated', $offset = 0)
	{
		Auth::check_access();
		$level = Auth::get_access_level();
		
		$this->load->model('personallogs_model', 'logs');
		
		// arrays to check uri against
		$values = array('activated', 'saved', 'pending', 'edit');
		
		// sanity checks
		$section = (in_array($section, $values)) ? $section : 'activated';
		$offset = (is_numeric($offset)) ? $offset : 0;
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					if ($level == 2)
					{
						$id = $this->input->post('id', true);
						$id = (is_numeric($id)) ? $id : false;
						
						// set the array data
						$approve_array = array('log_status' => 'activated');
						
						// approve the post
						$approve = $this->logs->update_log($id, $approve_array);
						
						$message = sprintf(
							($approve > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_personallog')),
							lang('actions_approved'),
							''
						);
						$flash['status'] = ($approve > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
						
						if ($approve > 0)
						{
							// grab the post details
							$row = $this->logs->get_log($id);
							
							// set the array of data for the email
							$email_data = array(
								'author' => $row->log_author_character,
								'title' => $row->log_title,
								'content' => $row->log_content
							);
							
							// send the email
							$email = ($this->options['system_email'] == 'on') ? $this->_email('log', $email_data) : false;
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// get the log we're trying to delete
					$item = $this->logs->get_log($id);
					
					// make sure the user is allowed to be deleting the log
					if (($level == 1 and ($item->log_author_user == $this->session->userdata('userid'))) or $level == 2)
					{
						$delete = $this->logs->delete_log($id);
						
						$message = sprintf(
							($delete > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_personallog')),
							lang('actions_deleted'),
							''
						);
						$flash['status'] = ($delete > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, true);
					
					// get the log we're trying to delete
					$item = $this->logs->get_log($id);
					
					// make sure the user is allowed to be deleting the log
					if (($level == 1 and ($item->log_author_user == $this->session->userdata('userid'))) or $level == 2)
					{
						$update_array = array(
							'log_title' => $this->input->post('log_title', true),
							'log_tags' => $this->input->post('log_tags', true),
							'log_content' => $this->input->post('log_content', true),
							'log_status' => $this->input->post('log_status', true),
							'log_author_user' => $this->user->get_userid($this->input->post('log_author')),
							'log_author_character' => $this->input->post('log_author', true),
							'log_last_update' => now()
						);
						
						$update = $this->logs->update_log($id, $update_array);
						
						$message = sprintf(
							($update > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_personallog')),
							lang('actions_updated'),
							''
						);
						$flash['status'] = ($update > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($section == 'edit')
		{
			// grab the ID from the URL
			$id = $this->uri->segment(4, 0, true);
			
			// grab the post data
			$row = $this->logs->get_log($id);
			
			if ($level < 2)
			{
				if ($this->session->userdata('userid') != $row->log_author_user or $row->log_status == 'pending')
				{
					redirect('admin/error/6');
				}
			}
			
			// get all characters
			$all = $this->char->get_all_characters('user_npc');
			
			if ($all->num_rows() > 0)
			{
				foreach ($all->result() as $a)
				{
					if ($a->crew_type == 'active' or $a->crew_type == 'npc')
					{
						if ($a->crew_type == 'active')
						{
							$label = ucwords(lang('status_playing') .' '. lang('global_characters'));
						}
						else
						{
							$label = ucwords(lang('abbr_npcs'));
						}
						
						// toss them in the array
						$data['all'][$label][$a->charid] = $this->char->get_character_name($a->charid, true);
					}
				}
			}
			
			// set the data used by the view
			$data['inputs'] = array(
				'title' => array(
					'name' => 'log_title',
					'value' => $row->log_title),
				'content' => array(
					'name' => 'log_content',
					'id' => 'content-textarea',
					'rows' => 20,
					'value' => $row->log_content),
				'tags' => array(
					'name' => 'log_tags',
					'value' => $row->log_tags),
				'author' => $row->log_author_character,
				'character' => $this->char->get_character_name($row->log_author_character, true),
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
			
			$js_data['tab'] = 0;
			
			// figure out where the view should be coming from
			$view_loc = 'manage_logs_edit';
		}
		else
		{
			switch ($section)
			{
				case 'activated':
				default:
					$js_data['tab'] = 0;
				break;
					
				case 'saved':
					$js_data['tab'] = 1;
				break;
					
				case 'pending':
					$js_data['tab'] = 2;
				break;
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
			
			// figure out where the view should be coming from
			$view_loc = 'manage_logs';
		}
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_logs_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function missiongroups()
	{
		Auth::check_access('manage/missions');
		
		// load the resources
		$this->load->model('missions_model', 'mis');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $value;
					}
					
					unset($insert_array['submit']);
					
					// insert the record
					$insert = $this->mis->add_mission_group($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missiongroup')),
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
							ucfirst(lang('global_missiongroup')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					$delete = $this->mis->delete_mission_group($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missiongroup')),
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
							ucfirst(lang('global_missiongroup')),
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
					
					foreach ($_POST as $key => $value)
					{
						$update_array[$key] = $value;
					}
					
					unset($update_array['submit']);
					unset($update_array['id']);
					
					// insert the record
					$update = $this->mis->update_mission_group($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_missiongroup')),
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
							ucfirst(lang('global_missiongroup')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab the mission groups
		$groups = $this->mis->get_all_mission_groups();
		
		if ($groups->num_rows() > 0)
		{
			foreach ($groups->result() as $g)
			{
				$data['groups'][$g->misgroup_id] = array(
					'id' => $g->misgroup_id,
					'name' => $g->misgroup_name,
					'desc' => $g->misgroup_desc,
				);
				
				$subgroups = $this->mis->get_all_mission_groups($g->misgroup_id);
				
				if ($subgroups->num_rows() > 0)
				{
					foreach ($subgroups->result() as $s)
					{
						$data['groups'][$g->misgroup_id]['children'][$s->misgroup_id] = array(
							'id' => $s->misgroup_id,
							'name' => $s->misgroup_name,
							'desc' => $s->misgroup_desc,
						);
					}
				}
			}
		}
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_missiongroups'));
		$data['text'] = sprintf(
			lang('text_mission_groups'),
			ucfirst(lang('global_mission')),
			lang('global_missions'),
			lang('global_missions'),
			ucfirst(lang('global_mission')),
			lang('global_missions')
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_update'))),
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_add')))
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit'))),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view'))),
		);
		
		$data['label'] = array(
			'addgroup' => ucwords(lang('actions_add') .' '. lang('global_missiongroup') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'delete' => ucfirst(lang('actions_delete')),
			'order' => ucfirst(lang('labels_order')),
			'desc' => ucfirst(lang('labels_desc')),
			'parent' => ucwords(lang('labels_parent').' '.lang('global_missiongroup')),
			'nogroups' => sprintf(lang('error_not_found'), lang('global_missiongroups')),
		);
		
		$this->_regions['content'] = Location::view('manage_missiongroups', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_missiongroups_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function missions($action = false, $id = false)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('missions_model', 'mis');
		$this->load->model('posts_model', 'posts');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		$js_data['tab'] = 0;
		
		if (isset($_POST['submit']))
		{
			$status = $this->uri->segment(5);
			
			// grab the date info
			$today = getdate();
			
			// make sure things are formatted properly
			$hours = ($today['hours'] < 10) ? '0'. $today['hours'] : $today['hours'];
			$minutes = ($today['minutes'] < 10) ? '0'. $today['minutes'] : $today['minutes'];
			$seconds = ($today['seconds'] < 10) ? '0'. $today['seconds'] : $today['seconds'];
			
			// set the current time
			$time = ' '. $hours .':'. $minutes .':'. $seconds;
			
			switch ($this->uri->segment(3))
			{
				case 'add':
					$start = (empty($_POST['mission_start'])) ? '' : human_to_unix($this->input->post('mission_start', true) . $time);
					$end = (empty($_POST['mission_end'])) ? '' : human_to_unix($this->input->post('mission_end', true) . $time);
					
					$insert_array = array(
						'mission_title' => $this->input->post('mission_title', true),
						'mission_status' => $this->input->post('mission_status', true),
						'mission_order' => $this->input->post('mission_order', true),
						'mission_desc' => $this->input->post('mission_desc', true),
						'mission_images' => $this->input->post('mission_images', true),
						'mission_start' => $start,
						'mission_end' => $end,
						'mission_notes' => $this->input->post('mission_notes', true),
						'mission_summary' => $this->input->post('mission_summary', true),
						'mission_group' => $this->input->post('mission_group', true),
					);
					
					// insert the record
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
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
				break;
					
				case 'edit':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== false)
						{
							$loc_pos = substr($key, 0, $loc);
							
							$new_key = 'mission_'. substr($key, ($loc+1));
							
							if (substr($key, ($loc+1)) == 'start' or substr($key, ($loc+1)) == 'end')
							{
								$mission[$new_key] = human_to_unix($value . $time);
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
						if ($oldstatus == 'upcoming' and $mission['mission_status'] == 'current')
						{
							$mission['mission_start'] = now();
						}
						if ($oldstatus == 'current' and $mission['mission_status'] == 'completed')
						{
							$mission['mission_end'] = now();
						}
					}
					
					// check to see if we should update when the mission notes were updated
					if ($mission['mission_oldnotes'] != $mission['mission_notes'])
					{
						$mission['mission_notes_updated'] = now();
					}

					unset($mission['mission_oldstatus']); // remove the old status variable
					unset($mission['mission_oldnotes']); // remove the old notes variable
					
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			
			switch ($status)
			{
				case 'current':
				default:
					$js_data['tab'] = 0;
				break;
					
				case 'upcoming':
					$js_data['tab'] = 1;
				break;
					
				case 'completed':
					$js_data['tab'] = 2;
				break;
			}
		}
		
		$data['label'] = array();
		
		if ($action == 'add' or $action == 'edit')
		{
			// set the date
			$today = getdate();
			$year = $today['year'];
			$month = (strlen($today['mon']) < 2) ? '0'. $today['mon'] : $today['mon'];
			$day = (strlen($today['mday']) < 2) ? '0'. $today['mday'] : $today['mday'];
			$date = $year .'-'. $month .'-'. $day .' 00:00:00';
			
			$item = $this->mis->get_mission($id);
			
			$start = ($item === false) ? $date : '';
			$start = (empty($item->mission_start)) ? '' : unix_to_human($item->mission_start);
			$start = ( ! empty($start)) ? substr_replace($start, '', strpos($start, ' ')) : '';
			
			$end = ($item === false or empty($item->mission_end)) ? '' : unix_to_human($item->mission_end);
			$end = ( ! empty($end)) ? substr_replace($end, '', strpos($end, ' ')) : '';
			
			$js_data['start'] = $start;
			$js_data['end'] = $end;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_mission'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->mission_title : '';
			
			$data['inputs'] = array(
				'title' => array(
					'name' => 'mission_title',
					'value' => ($item === false) ? '' : $item->mission_title),
				'order' => array(
					'name' => 'mission_order',
					'class' => 'small',
					'value' => ($item === false) ? 99 : $item->mission_order),
				'start' => array(
					'name' => 'mission_start',
					'class' => 'medium datepick'),
				'end' => array(
					'name' => 'mission_end',
					'class' => 'medium datepick'),
				'desc' => array(
					'name' => 'mission_desc',
					'rows' => 6,
					'value' => ($item == false) ? '' : $item->mission_desc),
				'status' => ($item === false) ? '' : $item->mission_status,
				'summary' => array(
					'name' => 'mission_summary',
					'rows' => 12,
					'value' => ($item == false) ? '' : $item->mission_summary),
				'notes' => array(
					'name' => 'mission_notes',
					'rows' => 12,
					'value' => ($item == false) ? '' : $item->mission_notes),
				'group' => ($item === false) ? '' : $item->mission_group,
				'images' => ( ! empty($item->mission_images)) ? explode(',', $item->mission_images) : '',
			);
			
			$groups = $this->mis->get_all_mission_groups();
			
			if ($groups->num_rows() > 0)
			{
				$data['groups'][0] = ucwords(lang('labels_no') .' '. lang('global_missiongroup'));
				
				foreach ($groups->result() as $g)
				{
					$data['groups'][$g->misgroup_id] = $g->misgroup_name;
					
					$subgroup = $this->mis->get_all_mission_groups($g->misgroup_id);
					
					if ($subgroup->num_rows() > 0)
					{
						foreach ($subgroup->result() as $s)
						{
							$data['groups'][$s->misgroup_id] = $s->misgroup_name.' ('.$g->misgroup_name.')';
						}
					}
				}
			}
			
			$data['directory'] = array();
		
			$dir = $this->sys->get_uploaded_images('mission');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					$data['directory'][$d->upload_id] = array(
						'image' => array(
							'src' => Location::asset('images/missions', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = 'manage_missions_action';
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
					
					if ( ! empty($mission->mission_start))
					{
						$start = gmt_to_local($mission->mission_start, $this->timezone, $this->dst);
					}
					
					if ( ! empty($mission->mission_end))
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
			
			$js_data['start'] = false;
			$js_data['end'] = false;
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_missions'));
			
			$view_loc = 'manage_missions';
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
			'error' => sprintf(lang('error_not_found'), lang('global_missions')),
			'add' => ucwords(lang('actions_add') .' '. lang('global_mission')) .' '. RARROW,
			'posts' => ucfirst(lang('global_posts')) .': ',
			'info' => ucfirst(lang('labels_info')),
			'images' => ucfirst(lang('labels_images')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucfirst(lang('global_missions')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
			'group' => ucwords(lang('global_missiongroup')),
			'nogroups' => sprintf(lang('error_not_found'), lang('global_missiongroups')),
			'managegroups' => '[ '. ucwords(lang('actions_manage') .' '. lang('global_missiongroups')) .' ]',
			'images_later' => sprintf(lang('add_images_later'), lang('global_mission')),
			'available_images' => ucwords(lang('labels_available').' '.lang('labels_images')),
			'mission_images' => ucwords(lang('global_mission').' '.lang('labels_images')),
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
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => lang('actions_delete'),
				'title' => ucfirst(lang('actions_delete'))),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => lang('actions_edit'),
				'title' => ucfirst(lang('actions_edit'))),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view'))),
			'upload' => array(
				'src' => Location::img('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
			'loading' => array(
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('global_mission')
		);
				
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
				'content' => ucwords(lang('actions_submit'))),
			'use' => array(
				'type' => 'submit',
				'class' => 'button-sec add',
				'name' => 'use',
				'value' => 'use',
				'content' => ucwords(lang('actions_use') .' '. lang('labels_image'))),
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'rel' => $id,
				'content' => ucwords(lang('actions_update'))),
		);
		
		$js_data['id'] = $id;
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_missions_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function news($section = 'activated', $offset = 0)
	{
		Auth::check_access();
		$level = Auth::get_access_level();
		
		$this->load->model('news_model', 'news');
		
		// array to check the values in the uri against
		$values = array('activated', 'saved', 'pending', 'edit');
		
		// sanity checks
		$section = (in_array($section, $values)) ? $section : false;
		$offset = (is_numeric($offset)) ? $offset : 0;
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					if ($level == 2)
					{
						$id = $this->input->post('id', true);
						$id = (is_numeric($id)) ? $id : false;
						
						// set the array data
						$approve_array = array('news_status' => 'activated');
						
						// approve the post
						$approve = $this->news->update_news_item($id, $approve_array);
						
						$message = sprintf(
							($approve > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_newsitem')),
							lang('actions_approved'),
							''
						);
						$flash['status'] = ($approve > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
						
						if ($approve > 0)
						{
							// grab the post details
							$row = $this->news->get_news_item($id);
							
							// set the array of data for the email
							$email_data = array(
								'author' => $row->news_author_character,
								'title' => $row->news_title,
								'category' => $this->news->get_news_category($row->news_cat, 'newscat_name'),
								'content' => $row->news_content
							);
							
							// send the email
							$email = ($this->options['system_email'] == 'on') ? $this->_email('news', $email_data) : false;
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// get the news item
					$item = $this->news->get_news_item($id);
					
					if (($level == 1 and ($item->news_author_user == $this->session->userdata('userid'))) or $level == 2)
					{
						$delete = $this->news->delete_news_item($id);
						
						$message = sprintf(
							($delete > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_newsitem')),
							lang('actions_deleted'),
							''
						);
						$flash['status'] = ($delete > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, true);
					
					// get the news item
					$item = $this->news->get_news_item($id);
					
					if (($level == 1 and ($item->news_author_user == $this->session->userdata('userid'))) or $level == 2)
					{
						$update_array = array(
							'news_title' => $this->input->post('news_title', true),
							'news_tags' => $this->input->post('news_tags', true),
							'news_content' => $this->input->post('news_content', true),
							'news_author_character' => $this->input->post('news_author', true),
							'news_author_user' => $this->user->get_userid($this->input->post('news_author')),
							'news_status' => $this->input->post('news_status', true),
							'news_cat' => $this->input->post('news_cat', true),
							'news_private' => $this->input->post('news_private', true),
							'news_last_update' => now()
						);
						
						$update = $this->news->update_news_item($id, $update_array);
						
						$message = sprintf(
							($update > 0) ? lang('flash_success') : lang('flash_failure'),
							ucfirst(lang('global_newsitem')),
							lang('actions_updated'),
							''
						);
						$flash['status'] = ($update > 0) ? 'success' : 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($section == 'edit')
		{
			// grab the ID from the URL
			$id = $this->uri->segment(4, 0, true);
			
			// grab the post data
			$row = $this->news->get_news_item($id);
			$cats = $this->news->get_news_categories();
			
			if ($level < 2)
			{
				if ($this->session->userdata('userid') != $row->news_author_user or $row->news_status == 'pending')
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
			
			// get all characters
			$all = $this->char->get_all_characters('active');
			
			if ($all->num_rows() > 0)
			{
				foreach ($all->result() as $a)
				{
					$data['all'][$a->charid] = $this->char->get_character_name($a->charid, true);
				}
			}
			
			// set the data used by the view
			$data['inputs'] = array(
				'title' => array(
					'name' => 'news_title',
					'value' => $row->news_title),
				'content' => array(
					'name' => 'news_content',
					'id' => 'content-textarea',
					'rows' => 20,
					'value' => $row->news_content),
				'tags' => array(
					'name' => 'news_tags',
					'value' => $row->news_tags),
				'author' => $row->news_author_character,
				'character' => $this->char->get_character_name($row->news_author_character, true),
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
			
			$js_data['tab'] = 0;
			
			// figure out where the view should be coming from
			$view_loc = 'manage_news_edit';
		}
		else
		{
			switch ($section)
			{
				case 'activated':
				default:
					$js_data['tab'] = 0;
				break;
					
				case 'saved':
					$js_data['tab'] = 1;
				break;
					
				case 'pending':
					$js_data['tab'] = 2;
				break;
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
			
			// figure out where the view should be coming from
			$view_loc = 'manage_news';
		}
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_news_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function newscats()
	{
		Auth::check_access();
		
		$this->load->model('news_model', 'news');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'newscat_name' => $this->input->post('newscat_name', true),
						'newscat_display' => 'y',
					);
					
					// insert the record
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
				break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== false)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if ( ! in_array($loc_pos, $delete))
							{ // if the item is being deleted don't add it to the update array
								$new_key = 'newscat_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{
						$update += $this->news->update_news_category($a, $b);
					}
					
					foreach ($delete as $del)
					{
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
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
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left')
		);
		
		$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_news') .' '. lang('labels_categories'));
		$data['text'] = sprintf(
			lang('text_manage_newscats'),
			ucfirst(lang('global_newsitems')),
			lang('globals_news'),
			lang('global_newsitems'),
			lang('global_newsitems')
		);
		
		$this->_regions['content'] = Location::view('manage_newscats', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_newscats_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function positions()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('positions_model', 'pos');
		$this->load->model('depts_model', 'dept');
		$this->load->library('parser');
		
		// set the variables
		$g_dept = $this->uri->segment(3, 1, true);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(4))
			{
				case 'add':
					$insert_array = array(
						'pos_name' => $this->input->post('pos_name', true),
						'pos_type' => $this->input->post('pos_type', true),
						'pos_dept' => $this->input->post('pos_dept', true),
						'pos_order' => $this->input->post('pos_order', true),
						'pos_display' => $this->input->post('pos_display', true),
						'pos_open' => $this->input->post('pos_open', true),
						'pos_desc' => $this->input->post('pos_desc', true),
						'pos_top_open' => $this->input->post('pos_top_open', true),
					);
					
					// insert the record
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
				break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== false)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if ( ! in_array($loc_pos, $delete))
							{ // if the item is being deleted don't add it to the update array
								$new_key = 'pos_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{
						$update += $this->pos->update_position($a, $b);
					}
					
					foreach ($delete as $del)
					{
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// get the positions for the current department
		$positions = $this->pos->get_dept_positions($g_dept, '');
		
		// get all the departments
		$departments = $this->dept->get_all_depts('asc', null);
		
		if ($departments->num_rows() > 0)
		{
			foreach ($departments->result() as $d)
			{
				$name = ($d->dept_manifest > 0 and $d->dept_manifest !== null)
					? $this->dept->get_manifest($d->dept_manifest, 'manifest_name')
					: ucwords(lang('labels_unassigned').' '.lang('global_departments'));
					
				$data['depts'][$d->dept_manifest]['name'] = $name;
				$data['depts'][$d->dept_manifest]['items'][$d->dept_id] = array(
					'name' => $d->dept_name,
					'desc' => $d->dept_desc,
				);
				
				$data['deptnames'][$d->dept_id] = $d->dept_name;
				
				$subd = $this->dept->get_sub_depts($d->dept_id, 'asc', null);
				
				if ($subd->num_rows() > 0)
				{
					foreach ($subd->result() as $s)
					{
						$data['depts'][$d->dept_manifest]['items'][$s->dept_id] = array(
							'name' => $s->dept_name,
							'desc' => $s->dept_desc,
						);
						$data['deptnames'][$s->dept_id] = $s->dept_name;
					}
				}
			}
		}
		
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
					'delete' => array(
						'name' => 'delete[]',
						'id' => $p->pos_id .'_id',
						'value' => $p->pos_id
					),
				);
				
				$additional_data = array(
					'id' => $p->pos_id,
					'dept' => $p->pos_dept,
					'desc' => array(
						'name' => 'desc',
						'id' => $p->pos_id.'_desc',
						'value' => $p->pos_desc,
						'rows' => 4
					),
					'display' => $p->pos_display,
					'display_options' => array(
						'y' => ucwords(lang('labels_yes')),
						'n' => ucwords(lang('labels_no')),
					),
					'order' => array(
						'name' => 'order',
						'id' => $p->pos_id.'_order',
						'value' => $p->pos_order,
						'class' => 'small'
					),
					'type' => $p->pos_type,
					'type_options' => array(
						'senior' => ucwords(lang('labels_senior')),
						'officer' => ucwords(lang('labels_officer')),
						'enlisted' => ucwords(lang('labels_enlisted')),
						'other' => ucwords(lang('labels_other')),
					),
					'submit' => array(
						'type' => 'submit',
						'class' => 'button-main',
						'name' => 'additional',
						'id' => $p->pos_id,
						'value' => 'submit',
						'content' => ucwords(lang('actions_submit'))
					),
					'label' => array(
						'dept' => ucfirst(lang('global_department')),
						'desc' => ucfirst(lang('labels_desc')),
						'display' => ucfirst(lang('labels_display')),
						'order' => ucfirst(lang('labels_order')),
						'type' => ucfirst(lang('labels_type')),
					),
				);
				
				// the additional information view
				$loc = Location::view('manage_positions_additional', $this->skin, 'admin', $additional_data);
				
				// parse the content and make sure it uses single quotes
				$data['additional'][$p->pos_id] = str_replace('"', "'", $this->parser->parse_string($loc, $additional_data, true));
				
				$data['values']['top_open'] = array(
					'y' => ucwords(lang('labels_yes')),
					'n' => ucwords(lang('labels_no')),
				);
				
				$data['positions'][$p->pos_id]['id'] = $p->pos_id;
				$data['positions'][$p->pos_id]['name'] = $p->pos_name;
				$data['positions'][$p->pos_id]['open'] = $p->pos_open;
				$data['positions'][$p->pos_id]['top_open'] = $p->pos_top_open;
			}
		}
				
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
			'add_position' => ucwords(lang('actions_add').' '.lang('global_position') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'open' => ucwords(lang('status_open') .' '. lang('labels_slots')),
			'delete' => ucfirst(lang('actions_delete')),
			'depts' => ucfirst(lang('global_departments')),
			'more' => ucfirst(lang('labels_more')),
			'top_open' => ucwords(lang('labels_top').' '.lang('status_open').' '.lang('global_position')),
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
		);
		
		$data['buttons'] = array(
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'update',
				'content' => ucwords(lang('actions_update')))
		);
		
		$js_data['position_update_text'] = sprintf(
			lang('flash_success'),
			ucfirst(lang('global_position')),
			lang('actions_updated'),
			''
		);
		
		$this->_regions['content'] = Location::view('manage_positions', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_positions_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function posts()
	{
		Auth::check_access();
		$level = Auth::get_access_level();
		
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		$values = array('activated', 'saved', 'pending', 'edit');
		$section = $this->uri->segment(3, 'activated', false, $values);
		$offset = $this->uri->segment(4, 0, true);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'approve':
					if ($level == 2)
					{
						$id = $this->input->post('id', true);
						$id = (is_numeric($id)) ? $id : false;
						
						// set the array data
						$approve_array = array('post_status' => 'activated');
						
						// approve the post
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
							
							// grab the post details
							$row = $this->posts->get_post($id);
							
							// set the array of data for the email
							$email_data = array(
								'authors' => $row->post_authors,
								'title' => $row->post_title,
								'timeline' => $row->post_timeline,
								'location' => $row->post_location,
								'content' => $row->post_content,
								'mission' => $this->mis->get_mission($row->post_mission, 'mission_title')
							);
							
							// send the email
							$email = ($this->options['system_email'] == 'on') ? $this->_email('post', $email_data) : false;
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
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
				break;
					
				case 'update':
					$id = $this->uri->segment(4, 0, true);
					
					$update_array = array(
						'post_title' => $this->input->post('post_title', true),
						'post_location' => $this->input->post('post_location', true),
						'post_timeline' => $this->input->post('post_timeline', true),
						'post_tags' => $this->input->post('post_tags', true),
						'post_content' => $this->input->post('post_content', true),
						'post_mission' => $this->input->post('post_mission', true),
						'post_status' => $this->input->post('post_status', true),
						'post_last_update' => now(),
					);
					
					$authors = $this->input->post('authors', true);
					
					foreach ($authors as $a => $b)
					{
						if (empty($b))
						{
							unset($authors[$a]);
						}
						
						// get the user ID
						$uid = $this->sys->get_item('characters', 'charid', $b, 'user');
						
						// put the users into an array
						$users[] = ($uid !== false) ? $uid : null;
					}
					
					foreach ($users as $k => $v)
					{
						if ( ! is_numeric($v) or $v < 1)
						{
							unset($users[$k]);
						}
					}
					
					$authors = implode(',', $authors);
					$authors_users = implode(',', $users);
					
					$update_array['post_authors'] = $authors;
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($section == 'edit')
		{
			// grab the ID from the URL
			$id = $this->uri->segment(4, 0, true);
			
			// grab the post data
			$row = $this->posts->get_post($id);
			
			if ((int) Auth::get_access_level() < 2)
			{
				$valid = array();
				
				foreach ($this->session->userdata('characters') as $check)
				{
					// make an array of the post authors
					$authors = explode(',', $row->post_authors);
					
					if ( ! in_array($check, $authors))
					{
						$valid[] = false;
					}
					else
					{
						$valid[] = true;
					}
				}
				
				if ( ! in_array(true, $valid) or $row->post_status == 'pending')
				{
					redirect('admin/error/6');
				}
			}
			
			// get all characters
			$all = $this->char->get_all_characters('user_npc', array('rank' => 'asc'));
			
			// get the current missions
			$missions = $this->mis->get_all_missions();
			
			if ($all->num_rows() > 0)
			{
				foreach ($all->result() as $a)
				{
					if (in_array($a->charid, $this->session->userdata('characters')))
					{
						$label = ucwords(lang('labels_my') .' '. lang('global_characters'));
					}
					else
					{
						if ($a->crew_type == 'active' or $a->crew_type == 'npc')
						{
							if ($a->crew_type == 'active' and !in_array($a->charid, $this->session->userdata('characters')))
							{
								$label = ucwords(lang('status_playing') .' '. lang('global_characters'));
							}
							else
							{
								if ($a->user > 0)
								{
									$label = ucwords(lang('labels_linked') .' '. lang('abbr_npcs'));
								}
								else
								{
									$label = ucwords(lang('labels_unlinked') .' '. lang('abbr_npcs'));
								}
							}
						}
					}
					
					// if it's a linked NPC, show the main character that owns the NPC
					$add = ($label == ucwords(lang('labels_linked') .' '. lang('abbr_npcs')))
						? " (".ucfirst(lang('labels_linked').' '.lang('labels_to').' ').$this->char->get_character_name($this->user->get_main_character($a->user), true).")"
						: false;
					
					// toss them in the array
					$allchars[$label][$a->charid] = $this->char->get_character_name($a->charid, true).$add;
				}
				
				$data['all_characters'] = array();
				
				$key = ucwords(lang('labels_my') .' '. lang('global_characters'));
				if (isset($allchars[$key]))
				{
					$data['all_characters'][$key] = $allchars[$key];
				}
				
				$key = ucwords(lang('status_playing') .' '. lang('global_characters'));
				if (isset($allchars[$key]))
				{
					$data['all_characters'][$key] = $allchars[$key];
				}
				
				$key = ucwords(lang('labels_linked') .' '. lang('abbr_npcs'));
				if (isset($allchars[$key]))
				{
					$data['all_characters'][$key] = $allchars[$key];
				}
				
				$key = ucwords(lang('labels_unlinked') .' '. lang('abbr_npcs'));
				if (isset($allchars[$key]))
				{
					$data['all_characters'][$key] = $allchars[$key];
				}
			}
			else
			{
				$data['all_characters'] = false;
			}
			
			// prep the data for sending to the js view
			$js_data['tab'] = 0;
			
			$data['authors_selected'] = array();
			
			if ($row !== false)
			{
				// set the list of selected authors
				$data['authors_selected'] = explode(',', $row->post_authors);
			}
			
			// set the data used by the view
			$data['inputs'] = array(
				'title' => array(
					'name' => 'post_title',
					'value' => $row->post_title),
				'content' => array(
					'name' => 'post_content',
					'id' => 'content-textarea',
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
				'authors' => ucfirst(lang('labels_authors')),
				'date' => ucfirst(lang('labels_date')),
				'chosen_incompat' => lang('chosen_incompat'),
				'select' => ucwords(lang('labels_please').' '.lang('actions_select')).' '.lang('labels_the').' '.ucfirst(lang('labels_authors')),
			);
			
			// figure out where the view should be coming from
			$view_loc = 'manage_posts_edit';
		}
		else
		{
			switch ($section)
			{
				case 'activated':
				default:
					$js_data['tab'] = 0;
				break;
					
				case 'saved':
					$js_data['tab'] = 1;
				break;
					
				case 'pending':
					$js_data['tab'] = 2;
				break;
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
			
			$js_data['remove'] = false;
			
			// figure out where the view should be coming from
			$view_loc = 'manage_posts';
		}
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_posts_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function ranks()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		
		// set the variables
		$set = $this->uri->segment(3, 'default');
		$class = $this->uri->segment(4, 1, true);
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(5))
			{
				case 'add':
					$insert_array = array(
						'rank_name' => $this->input->post('rank_name', true),
						'rank_order' => $this->input->post('rank_order', true),
						'rank_display' => $this->input->post('rank_display', true),
						'rank_class' => $this->input->post('rank_class', true),
						'rank_short_name' => $this->input->post('rank_short_name', true),
						'rank_image' => $this->input->post('rank_image', true),
					);
					
					// insert the record
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
				break;
					
				case 'edit':
					$array = array();
					$delete = (isset($_POST['delete'])) ? $_POST['delete'] : array();
					$update = 0;
					
					foreach ($_POST as $key => $value)
					{
						$loc = strpos($key, '_');
						
						if ($loc !== false)
						{
							$loc_pos = substr($key, 0, $loc);
							
							if ( ! in_array($loc_pos, $delete))
							{ // if the item is being deleted don't add it to the update array
								$new_key = 'rank_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{
						$update += $this->ranks->update_rank($a, $b);
					}
					
					foreach ($delete as $del)
					{
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$info = $this->ranks->get_rankcat($set);
		$ranks = $this->ranks->get_ranks($class, '');
		
		// grab all the rank sets
		$setstatus = (Auth::check_access('site/catalogueranks', false)) ? array('active','development') : 'active';
		$allranks = $this->ranks->get_all_rank_sets($setstatus);
		$allclasses = $this->ranks->get_group_ranks(0, 'rank_order');
		
		if ($allranks->num_rows() > 0)
		{
			foreach ($allranks->result() as $allrank)
			{
				$data['allranks'][$allrank->rankcat_location] = array(
					'src' => Location::rank(
						$allrank->rankcat_location,
						$allrank->rankcat_preview,
						''),
					'alt' => $allrank->rankcat_name
				);
				
				if ($allclasses->num_rows() > 0)
				{
					foreach ($allclasses->result() as $allclass)
					{
						if ($allclass->rank_class > 0 and $allrank->rankcat_location == $set)
						{
							$data['allclasses'][$allclass->rank_class] = array(
								'src' => Location::rank(
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
						'src' => Location::rank($info->rankcat_location, $rank->rank_image, $info->rankcat_extension),
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
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left'),
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
		
		$this->_regions['content'] = Location::view('manage_ranks', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_ranks_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function specs()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('specs_model', 'specs');
		$this->load->model('tour_model', 'tour');
		
		// set the variables
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4, false, true);
		
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
						
						if (substr($key, 0, 6) == 'specs_')
						{
							$specs[$key] = $value;
						}
					}
					
					$insert = $this->specs->add_spec_item($specs);
					$insert_id = $this->db->insert_id();
					
					// optimize the table
					$this->sys->optimize_table('specs');
					
					foreach ($fields as $k => $v)
					{
						$v['data_item'] = $insert_id;
						
						$insert += $this->specs->add_spec_field_data($v);
					}
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
					// delete the spec item
					$delete = $this->specs->delete_spec_item($id);
					
					// delete any decks for that item
					$decks = $this->tour->delete_deck($id, true);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
						
						$this->specs->delete_spec_field_data($id, 'data_item');
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
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
					
					foreach ($_POST as $key => $value)
					{
						if (is_numeric($key))
						{
							$fields[$key] = array(
								'data_value' => $value,
								'data_updated' => now()
							);
						}
						
						if (substr($key, 0, 6) == 'specs_')
						{
							$specs[$key] = $value;
						}
					}
					
					$update = $this->specs->update_spec_item($id, $specs);
					
					foreach ($fields as $k => $v)
					{
						$update += $this->specs->update_spec_data($id, $k, $v);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_item')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($action == 'add' or $action == 'edit')
		{
			$item = ($action == 'edit') ? $this->specs->get_spec_item($id) : false;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_specification') .' '. lang('labels_item'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->specs_name : '';
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'specs_name',
					'value' => ($item === false) ? '' : $item->specs_name),
				'order' => array(
					'name' => 'specs_order',
					'class' => 'small',
					'value' => ($item === false) ? '' : $item->specs_order),
				'display_y' => array(
					'name' => 'specs_display',
					'id' => 'display_y',
					'value' => 'y',
					'checked' => ($item !== false and $item->specs_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'specs_display',
					'id' => 'display_n',
					'value' => 'n',
					'checked' => ($item !== false and $item->specs_display == 'n') ? true : false),
				'summary' => array(
					'name' => 'specs_summary',
					'rows' => 6,
					'value' => ($item === false) ? '' : $item->specs_summary),
				'images' => ( ! empty($item->specs_images)) ? explode(',', $item->specs_images) : '',
			);
			
			if ($item === false)
			{
				$data['inputs']['display_y']['checked'] = true;
			}
			
			$sections = $this->specs->get_spec_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$sid = $sec->section_id;
					
					// set the section name
					$data['specs'][$sid]['name'] = $sec->section_name;
					
					// grab the fields for the given section
					$fields = $this->specs->get_spec_fields($sec->section_id);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$f_id = $field->field_id;
							
							// set the page label
							$data['specs'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
							
							switch ($field->field_type)
							{
								case 'text':
									$row = $this->specs->get_field_data($id, $f_id);
									
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => ($row !== false) ? $row->data_value : ''
									);
									
									$data['specs'][$sid]['fields'][$f_id]['input'] = form_input($input);
								break;
									
								case 'textarea':
									$row = $this->specs->get_field_data($id, $f_id);
									
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => ($row !== false) ? $row->data_value : '',
										'rows' => $field->field_rows
									);
									
									$data['specs'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
								break;
									
								case 'select':
									$value = false;
									$values = false;
									$input = false;
								
									$values = $this->specs->get_spec_values($field->field_id);
									
									$row = $this->specs->get_field_data($id, $f_id);
									$default = ($row !== false) ? $row->data_value : '';
									
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
			
			$data['directory'] = array();
		
			$dir = $this->sys->get_uploaded_images('specs');
			
			if ($dir->num_rows() > 0)
			{
				foreach ($dir->result() as $d)
				{
					$data['directory'][$d->upload_id] = array(
						'image' => array(
							'src' => Location::asset('images/specs', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = 'manage_specs_action';
		}
		else
		{
			$specs = $this->specs->get_spec_items('');
			
			if ($specs->num_rows() > 0)
			{
				foreach ($specs->result() as $s)
				{
					$sid = $s->specs_id;
					
					$data['specs'][$sid] = array(
						'id' => $sid,
						'name' => $s->specs_name,
						'summary' => $s->specs_summary
					);
				}
			}
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_specification') .' '. lang('labels_items'));
			$data['text'] = lang('text_manage_specs');
			
			$view_loc = 'manage_specs';
		}
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_edit')),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_delete')),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_add')),
				'title' => ucfirst(lang('actions_add')),
				'class' => 'image inline_img_left'),
			'upload' => array(
				'src' => Location::img('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
			'loading' => array(
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
		);
		
		$data['image_instructions'] = sprintf(
			lang('text_image_select'),
			lang('global_specification') .' '. lang('labels_items')
		);
		
		$data['label'] = array(
			'form' => ucwords(lang('actions_manage') .' '. lang('global_specs') .' '. lang('labels_form') .' '. RARROW),
			'images' => ucfirst(lang('labels_images')),
			'info' => ucfirst(lang('labels_info')),
			'summary' => ucfirst(lang('labels_summary')) .':',
			'add' => ucwords(lang('actions_add') .' '. lang('global_specification') .' '. lang('labels_item') .' '. RARROW),
			'no_specs' => sprintf(lang('error_not_found'), lang('global_specification') .' '. lang('labels_items')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'summary' => ucfirst(lang('labels_summary')) .': ',
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('global_specification') .' '. lang('labels_items')),
			'images_later' => sprintf(lang('add_images_later'), lang('global_specification') .' '. lang('labels_item')),
			'specitem_empty_fields' => lang('specitem_empty_fields'),
			'available_images' => ucwords(lang('labels_available').' '.lang('labels_images')),
			'spec_images' => ucwords(lang('global_specification').' '.lang('labels_item').' '.lang('labels_images')),
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
			'use' => array(
				'type' => 'submit',
				'class' => 'button-sec add',
				'name' => 'use',
				'value' => 'use',
				'content' => ucwords(lang('actions_use') .' '. lang('labels_image'))),
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'rel' => $id,
				'content' => ucwords(lang('actions_update'))),
		);
		
		$js_data['id'] = $id;
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_specs_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function tour()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('tour_model', 'tour');
		$this->load->model('specs_model', 'specs');
		
		// set the variables
		$action = $this->uri->segment(3);
		$id = $this->uri->segment(4, false, true);
		
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
					
					// optimize the table
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
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
						
						$this->tour->delete_tour_field_data($id, 'data_tour_item');
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
				break;
					
				case 'edit':
					$id = $this->input->post('id', true);
					$id = (is_numeric($id)) ? $id : false;
					
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
						$update += $this->tour->update_tour_data($id, $k, $v);
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		if ($action == 'add' or $action == 'edit')
		{
			$item = ($action == 'edit') ? $this->sys->get_item('tour', 'tour_id', $id) : false;
			
			$data['header'] = ucwords(lang('actions_'. $action) .' '. lang('global_touritem'));
			$data['header'].= ($action == 'edit') ? ' - '. $item->tour_name : '';
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'tour_name',
					'value' => ($item === false) ? '' : $item->tour_name),
				'order' => array(
					'name' => 'tour_order',
					'class' => 'small',
					'value' => ($item === false) ? '' : $item->tour_order),
				'display_y' => array(
					'name' => 'tour_display',
					'id' => 'display_y',
					'value' => 'y',
					'checked' => ($item !== false and $item->tour_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'tour_display',
					'id' => 'display_n',
					'value' => 'n',
					'checked' => ($item !== false and $item->tour_display == 'n') ? true : false),
				'summary' => array(
					'name' => 'tour_summary',
					'rows' => 6,
					'value' => ($item === false) ? '' : $item->tour_summary),
				'images' => ( ! empty($item->tour_images)) ? explode(',', $item->tour_images) : '',
				'spec_item' => ($item === false) ? false : $item->tour_spec_item,
			);
			
			if ($item === false)
			{
				$data['inputs']['display_y']['checked'] = true;
			}
			
			// get the spec items
			$specs = $this->specs->get_spec_items();
			
			// build the array for the dropdown
			if ($specs->num_rows() > 0)
			{
				$data['specs'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')) .' '. lang('labels_an') .' '. ucfirst(lang('labels_item'));
				
				foreach ($specs->result() as $s)
				{
					$data['specs'][$s->specs_id] = $s->specs_name;
				}
			}
			
			$tour = $this->tour->get_tour_fields();
		
			if ($tour->num_rows() > 0)
			{
				foreach ($tour->result() as $field)
				{
					$tid = $field->field_id;
					
					// set the page label
					$data['inputs']['fields'][$tid]['field_label'] = $field->field_label_page;
					
					switch ($field->field_type)
					{
						case 'text':
							$row = $this->tour->get_tour_data($id, $tid);
							
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => ($row === false) ? '' : $row->data_value
							);
							
							$data['inputs']['fields'][$tid]['input'] = form_input($input);
						break;
							
						case 'textarea':
							$row = $this->tour->get_tour_data($id, $tid);
							
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => ($row === false) ? '' : $row->data_value,
								'rows' => $field->field_rows
							);
							
							$data['inputs']['fields'][$tid]['input'] = form_textarea($input);
						break;
							
						case 'select':
							$value = false;
							$values = false;
							$input = false;
						
							$values = $this->tour->get_tour_values($tid);
							
							$row = $this->tour->get_tour_data($id, $tid);
							$default = ($row === false) ? '' : $row->data_value;
							
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
							'src' => Location::asset('images/tour', $d->upload_filename),
							'alt' => $d->upload_filename,
							'class' => 'image image-height-100'),
						'file' => $d->upload_filename,
						'id' => $d->upload_id
					);
				}
			}
			
			$data['form'] = ($action == 'edit') ? 'edit/'. $id : 'add';
			$data['id'] = $id;
			
			$view_loc = 'manage_tour_action';
		}
		else
		{
			// run the methods
			$tour = $this->tour->get_tour_items('');
			$specs = $this->specs->get_spec_items();
			
			if ($tour->num_rows() > 0)
			{
				$data['items'][0] = ucwords(lang('labels_general') .' '. lang('labels_items'));
			}
			
			if ($specs->num_rows() > 0)
			{
				foreach ($specs->result() as $s)
				{
					$data['items'][$s->specs_id] = $s->specs_name;
				}
			}
			
			if ($tour->num_rows() > 0)
			{
				// set the tour array
				$data['tour'] = array();
				
				foreach ($tour->result() as $item)
				{
					// make sure we have the right tour spec item for the array
					$specitem = ( ! empty($item->tour_spec_item)) ? $item->tour_spec_item : 0;
					
					// set the order
					$order = $item->tour_order;
					
					// make sure all of the items will show up
					$order = (isset($data['tour'][$specitem][$order])) ? null : $order;
					
					$data['tour'][$specitem][$order]['id'] = $item->tour_id;
					$data['tour'][$specitem][$order]['name'] = $item->tour_name;
					$data['tour'][$specitem][$order]['summary'] = $item->tour_summary;
				}
			}
			
			$data['header'] = ucwords(lang('actions_manage') .' '. lang('global_touritems'));
			$data['text'] = lang('text_manage_specs');
			
			$view_loc = 'manage_tour';
		}
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_edit')),
				'title' => ucfirst(lang('actions_edit')),
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_delete')),
				'title' => ucfirst(lang('actions_delete')),
				'class' => 'image'),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => ucfirst(lang('actions_add')),
				'title' => ucfirst(lang('actions_add')),
				'class' => 'image inline_img_left'),
			'upload' => array(
				'src' => Location::img('image-upload.png', $this->skin, 'admin'),
				'alt' => lang('actions_upload'),
				'class' => 'image'),
			'loading' => array(
				'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
				'alt' => lang('actions_loading'),
				'class' => 'image'),
			'help' => array(
				'src' => Location::img('help.png', $this->skin, 'admin'),
				'alt' => '[?]',
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
			'no_tour' => sprintf(lang('error_not_found'), lang('global_touritems')),
			'upload' => ucwords(lang('actions_upload') .' '. lang('labels_images') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'order' => ucfirst(lang('labels_order')),
			'display' => ucfirst(lang('labels_display')),
			'on' => ucfirst(lang('labels_on')),
			'off' => ucfirst(lang('labels_off')),
			'spec_item' => ucwords(lang('global_specification') .' '. lang('labels_item')),
			'summary' => ucfirst(lang('labels_summary')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('global_touritems')),
			'images_later' => sprintf(lang('add_images_later'), lang('global_touritem')),
			'specitem_select' => lang('specitem_select'),
			'available_images' => ucwords(lang('labels_available').' '.lang('labels_images')),
			'tour_images' => ucwords(lang('global_touritem').' '.lang('labels_images')),
		);
		
		$data['buttons'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
			'use' => array(
				'type' => 'submit',
				'class' => 'button-sec add',
				'name' => 'use',
				'value' => 'use',
				'content' => ucwords(lang('actions_use') .' '. lang('labels_image'))),
			'update' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'id' => 'update',
				'rel' => $id,
				'content' => ucwords(lang('actions_update'))),
		);
		
		$js_data['id'] = $id;
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('manage_tour_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	protected function _comments_ajax($offset = 0, $type = '', $status = 'activated')
	{
		// load the resources
		$this->load->library('pagination');
		$this->load->helper('text');
		
		switch ($type)
		{
			case 'posts':
				$this->load->model('posts_model', 'posts');
				
				$config['base_url'] = site_url('manage/comments/posts/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$posts = $this->posts->get_post_comments('', $status, 'pcomment_date', 'desc');
				
				$data['entries'] = null;
				
				if ($posts->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($posts->result() as $p)
					{
						$date = gmt_to_local($p->pcomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$p->pcomment_id]['id'] = $p->pcomment_id;
						$data['entries'][$p->pcomment_id]['content'] = ($p->pcomment_status == 'pending') 
							? $p->pcomment_content 
							: word_limiter($p->pcomment_content, 25);
						$data['entries'][$p->pcomment_id]['author'] = $this->char->get_authors($p->pcomment_author_character, true);
						$data['entries'][$p->pcomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$p->pcomment_id]['source'] = anchor('sim/viewpost/'. $p->pcomment_post, $this->posts->get_post($p->pcomment_post, 'post_title'));
						$data['entries'][$p->pcomment_id]['status'] = $p->pcomment_status;
					}
				}
		
				$config['total_rows'] = $this->posts->count_all_post_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
				
				$data['subheader'] = 'header_posts';
			break;
				
			case 'logs':
				$this->load->model('personallogs_model', 'logs');
				
				$config['base_url'] = site_url('manage/comments/logs/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$logs = $this->logs->get_log_comments('', $status, 'lcomment_date', 'desc');
				
				$data['entries'] = null;
				
				if ($logs->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($logs->result() as $l)
					{
						$date = gmt_to_local($l->lcomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$l->lcomment_id]['id'] = $l->lcomment_id;
						$data['entries'][$l->lcomment_id]['content'] = ($l->lcomment_status == 'pending') 
							? $l->lcomment_content 
							: word_limiter($l->lcomment_content, 25);
						$data['entries'][$l->lcomment_id]['author'] = $this->char->get_authors($l->lcomment_author_character, true);
						$data['entries'][$l->lcomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$l->lcomment_id]['source'] = anchor('sim/viewlog/'. $l->lcomment_log, $this->logs->get_log($l->lcomment_log, 'log_title'));
						$data['entries'][$l->lcomment_id]['status'] = $l->lcomment_status;
					}
				}
		
				$config['total_rows'] = $this->logs->count_all_log_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_logs';
			break;
				
			case 'news':
				$this->load->model('news_model', 'news');
				
				$config['base_url'] = site_url('manage/comments/news/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$news = $this->news->get_news_comments('', $status, 'ncomment_date', 'desc');
				
				$data['entries'] = null;
				
				if ($news->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($news->result() as $n)
					{
						$date = gmt_to_local($n->ncomment_date, $this->timezone, $this->dst);
								
						$data['entries'][$n->ncomment_id]['id'] = $n->ncomment_id;
						$data['entries'][$n->ncomment_id]['content'] = ($n->ncomment_status == 'pending') 
							? $n->ncomment_content 
							: word_limiter($n->ncomment_content, 25);
						$data['entries'][$n->ncomment_id]['author'] = $this->char->get_authors($n->ncomment_author_character, true);
						$data['entries'][$n->ncomment_id]['date'] = mdate($datestring, $date);
						$data['entries'][$n->ncomment_id]['source'] = anchor('main/viewnews/'. $n->ncomment_news, $this->news->get_news_item($n->ncomment_news, 'news_title'));
						$data['entries'][$n->ncomment_id]['status'] = $n->ncomment_status;
					}
				}
		
				$config['total_rows'] = $this->news->count_news_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_news';
			break;
				
			case 'wiki':
				$this->load->model('wiki_model', 'wiki');
				
				$config['base_url'] = site_url('manage/comments/wiki/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 5 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$wiki = $this->wiki->get_comments('', $status);
				
				$data['entries'] = null;
				
				if ($wiki->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($wiki->result() as $w)
					{
						// set the comment ID
						$wid = $w->wcomment_id;
						
						// set the date
						$date = gmt_to_local($w->wcomment_date, $this->timezone, $this->dst);
						
						// grab the wiki page info
						$page = $this->wiki->get_page($w->wcomment_page);
						
						if ($page->num_rows() > 0)
						{
							$row = $page->row();
								
							$data['entries'][$wid]['id'] = $wid;
							$data['entries'][$wid]['content'] = ($w->wcomment_status == 'pending') 
								? $w->wcomment_content 
								: word_limiter($w->wcomment_content, 25);
							$data['entries'][$wid]['author'] = $this->char->get_authors($w->wcomment_author_character, true);
							$data['entries'][$wid]['date'] = mdate($datestring, $date);
							$data['entries'][$wid]['source'] = anchor('wiki/view/page/'. $row->page_id, $row->draft_title);
							$data['entries'][$wid]['status'] = $w->wcomment_status;
						}
					}
				}
		
				$config['total_rows'] = $this->wiki->count_all_comments($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
			    
			    $data['subheader'] = 'header_wiki';
			break;
		}
		
		$data['status'] = $status;
		$data['page'] = $offset;
		$data['type'] = $type;
		
		$data['images'] = array(
	    	'edit' => array(
	    		'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
	    		'alt' => ucfirst(lang('actions_edit')),
	    		'title' => ucfirst(lang('actions_edit')),
	    		'class' => 'image'),
	    	'delete' => array(
	    		'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
	    		'alt' => ucfirst(lang('actions_delete')),
	    		'title' => ucfirst(lang('actions_delete')),
	    		'class' => 'image'),
	    	'approve' => array(
	    		'src' => Location::img('icon-check.png', $this->skin, 'admin'),
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
	    
	    // figure out where the view is coming from
	    $message = Location::view('manage_comments_ajax', $this->skin, 'admin', $data);

	    return $message;
	}
	
	protected function _email($type, $data)
	{
		// load the libraries
		$this->load->library('email');
		$this->load->library('parser');
		
		// define the variables
		$email = false;
		
		switch ($type)
		{
			case 'news':
				// set some variables
				$from_name = $this->char->get_character_name($data['author'], true, true);
				$from_email = $this->user->get_email_address('character', $data['author']);
				$subject = $data['category'] .' - '. $data['title'];
				
				// set the content
				$content = sprintf(
					lang('email_content_news_item'),
					$from_name,
					$data['content']
				);
				
				// set the email data
				$email_data = array(
					'email_subject' => $subject,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('write_newsitem', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// get the email addresses
				$emails = $this->user->get_crew_emails(true, 'email_news_items');
				
				// make a string of email addresses
				$to = implode(',', $emails);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $from_name);
				$this->email->to($to);
				$this->email->reply_to($from_email);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
			break;
				
			case 'log':
				// set some variables
				$from_name = $this->char->get_character_name($data['author'], true, true);
				$from_email = $this->user->get_email_address('character', $data['author']);
				$subject = $from_name ."'s ". lang('email_subject_personal_log') ." - ". $data['title'];
				
				// set the content
				$content = sprintf(
					lang('email_content_personal_log'),
					$from_name,
					$data['content']
				);
				
				// set the email data
				$email_data = array(
					'email_subject' => $subject,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('write_personallog', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// get the email addresses
				$emails = $this->user->get_crew_emails(true, 'email_personal_logs');
				
				// make a string of email addresses
				$to = implode(',', $emails);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $from_name);
				$this->email->to($to);
				$this->email->reply_to($from_email);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
			break;
				
			case 'post':
				// set some variables
				$subject = $data['mission'] ." - ". $data['title'];
				$mission = lang('email_content_post_mission') . $data['mission'];
				$authors = lang('email_content_post_author') . $this->char->get_authors($data['authors'], true);
				$timeline = lang('email_content_post_timeline') . $data['timeline'];
				$location = lang('email_content_post_location') . $data['location'];
				
				// figure out who it needs to come from
				$my_chars = array();
				
				// find out how many of the submitter's characters are in the string
				foreach ($this->session->userdata('characters') as $value)
				{
					if (strstr($data['authors'], $value) !== false)
					{
						$my_chars[] = $value;
					}
				}
				
				// set who the email is coming from
				$from_name = $this->char->get_character_name($my_chars[0], true, true);
				$from_email = $this->user->get_email_address('character', $my_chars[0]);
				
				// set the content
				$content = sprintf(
					lang('email_content_mission_post'),
					$authors,
					$mission,
					$location,
					$timeline,
					$data['content']
				);
				
				// set the email data
				$email_data = array(
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('write_missionpost', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// get the email addresses
				$emails = $this->user->get_crew_emails(true, 'email_mission_posts');
				
				// make a string of email addresses
				$to = implode(',', $emails);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $from_name);
				$this->email->to($to);
				$this->email->reply_to($from_email);
				$this->email->subject($this->options['email_subject'] .' '. $subject);
				$this->email->message($message);
			break;
				
			case 'log_comment':
				// load the models
				$this->load->model('personallogs_model', 'logs');
				
				// run the methods
				$row = $this->logs->get_log($data['log']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->log_author);
				
				// set the content	
				$content = sprintf(
					lang('email_content_log_comment_added'),
					"<strong>". $row->log_title ."</strong>",
					$data['comment']
				);
				
				// create the array passing the data to the email
				$email_data = array(
					'email_subject' => lang('email_subject_log_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('sim_log_comment', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'news_comment':
				// load the models
				$this->load->model('news_model', 'news');
				
				// run the methods
				$row = $this->news->get_news_item($data['news_item']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->news_author_character);
				
				// set the content	
				$content = sprintf(
					lang('email_content_news_comment_added'),
					"<strong>". $row->news_title ."</strong>",
					$data['comment']
				);
				
				// create the array passing the data to the email
				$email_data = array(
					'email_subject' => lang('email_subject_news_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				// where should the email be coming from
				$em_loc = Location::email('main_news_comment', $this->email->mailtype);
				
				// parse the message
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				// set the parameters for sending the email
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
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
					
					if ($pref == 'n' or $pref == '')
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
				
				$em_loc = Location::email('sim_post_comment', $this->email->mailtype);
				
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				$this->email->from(Util::email_sender(), $name);
				$this->email->to($to);
				$this->email->reply_to($from);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'wiki_comment':
				// load the models
				$this->load->model('wiki_model', 'wiki');
				
				// run the methods
				$page = $this->wiki->get_page($data['page']);
				$row = $page->row();
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				
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
				
			case 'docking_accept':
				$cc = implode(',', $this->user->get_emails_with_access('manage/docked'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_docking_approved') .' - '. $data['sim'],
					'email_from' => ucfirst(lang('time_from')) .': '. $this->options['sim_name'] .' - '. $this->options['default_email_address'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = Location::email('docked_action', $this->email->mailtype);
				
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				$this->email->from(Util::email_sender(), $this->options['sim_name']);
				$this->email->to($data['email']);
				$this->email->reply_to($data['fromEmail']);
				$this->email->cc($cc);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'docking_reject':
				$cc = implode(',', $this->user->get_emails_with_access('manage/docked'));
				
				$email_data = array(
					'email_subject' => lang('email_subject_docking_rejected') .' - '. $data['sim'],
					'email_from' => ucfirst(lang('time_from')) .': '. $this->options['sim_name'] .' - '. $this->options['default_email_address'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($data['message']) : $data['message']
				);
				
				$em_loc = Location::email('docked_action', $this->email->mailtype);
				
				$message = $this->parser->parse_string($em_loc, $email_data, true);
				
				$this->email->from(Util::email_sender(), $this->options['sim_name']);
				$this->email->to($data['email']);
				$this->email->reply_to($data['fromEmail']);
				$this->email->cc($cc);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
		}
		
		// send the email
		$email = $this->email->send();
		
		return $email;
	}
	
	protected function _entries_ajax($offset = 0, $status = 'activated', $section = '')
	{
		// load the resources
		$this->load->library('pagination');
		
		switch ($section)
		{
			case 'posts':
				$this->load->model('missions_model', 'mis');
				$this->load->model('posts_model', 'posts');
				
				$config['base_url'] = site_url('manage/posts/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$posts = (int) Auth::get_access_level('manage/posts') == 1
					? $this->posts->get_character_posts($this->session->userdata('characters'), $config['per_page'], $status, $offset)
					: $this->posts->get_post_list('', 'desc', $config['per_page'], $offset, $status);
				
				$data['entries'] = null;
				
				if ($posts->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($posts->result() as $p)
					{
						$date = gmt_to_local($p->post_date, $this->timezone, $this->dst);
						
						$data['entries'][$p->post_id]['id'] = $p->post_id;
						$data['entries'][$p->post_id]['title'] = $p->post_title;
						$data['entries'][$p->post_id]['author'] = $this->char->get_authors($p->post_authors, true, true);
						$data['entries'][$p->post_id]['date'] = mdate($datestring, $date);
						$data['entries'][$p->post_id]['mission'] = $this->mis->get_mission($p->post_mission, 'mission_title');
						$data['entries'][$p->post_id]['status'] = $p->post_status;
					}
				}
				
				// make sure we're calculating the number of rows correctly
				$config['total_rows'] = ((int) Auth::get_access_level('manage/posts') == 1)
					? $this->posts->count_character_posts($this->session->userdata('characters'), $status)
					: $this->posts->count_all_posts('', $status);
				
			    // initialize the pagination library
				$this->pagination->initialize($config);
				
				// create the page links
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				$data['section'] = $section;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => Location::img('icon-check.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => Location::img('icon-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				// figure out where the view is coming from
	    		$loc = 'manage_posts_ajax';
			break;
				
			case 'logs':
				$this->load->model('personallogs_model', 'logs');
				
				$config['base_url'] = site_url('manage/logs/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$logs = $this->logs->get_log_list($config['per_page'], $offset, $status);
				
				$data['entries'] = null;
				
				if ($logs->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($logs->result() as $l)
					{
						if (Auth::get_access_level('manage/logs') == 1)
						{
							if ($this->session->userdata('userid') == $l->log_author_user)
							{
								$date = gmt_to_local($l->log_date, $this->timezone, $this->dst);
								
								$data['entries'][$l->log_id]['id'] = $l->log_id;
								$data['entries'][$l->log_id]['title'] = $l->log_title;
								$data['entries'][$l->log_id]['author'] = $this->char->get_character_name($l->log_author_character, true, false, true);
								$data['entries'][$l->log_id]['date'] = mdate($datestring, $date);
								$data['entries'][$l->log_id]['status'] = $l->log_status;
							}
						}
						elseif (Auth::get_access_level('manage/logs') == 2)
						{
							$date = gmt_to_local($l->log_date, $this->timezone, $this->dst);
							
							$data['entries'][$l->log_id]['id'] = $l->log_id;
							$data['entries'][$l->log_id]['title'] = $l->log_title;
							$data['entries'][$l->log_id]['author'] = $this->char->get_character_name($l->log_author_character, true, false, true);
							$data['entries'][$l->log_id]['date'] = mdate($datestring, $date);
							$data['entries'][$l->log_id]['status'] = $l->log_status;
						}
					}
				}
		
				$config['total_rows'] = $this->logs->count_all_logs($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => Location::img('icon-check.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => Location::img('icon-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				// figure out where the view is coming from
	    		$loc = 'manage_logs_ajax';
	    	break;
				
			case 'news':
				$this->load->model('news_model', 'news');
				
				$config['base_url'] = site_url('manage/news/'. $status .'/');
				$config['uri_segment'] = ($offset > 0) ? 4 : false;
				$config['per_page'] = 15;
				$config['full_tag_open'] = '<p class="fontMedium bold">';
				$config['full_tag_close'] = '</p>';
				
				$news = $this->news->get_news_list($config['per_page'], $offset, $status);
				
				$data['entries'] = null;
				
				if ($news->num_rows() > 0)
				{
					$datestring = $this->options['date_format'];
					
					foreach ($news->result() as $n)
					{
						if (Auth::get_access_level('manage/news') == 1)
						{
							if ($this->session->userdata('userid') == $n->news_author_user)
							{
								$date = gmt_to_local($n->news_date, $this->timezone, $this->dst);
								$nid = $n->news_id;
								
								$data['entries'][$nid]['id'] = $nid;
								$data['entries'][$nid]['title'] = $n->news_title;
								$data['entries'][$nid]['author'] = $this->char->get_character_name($n->news_author_character, true, false, true);
								$data['entries'][$nid]['date'] = mdate($datestring, $date);
								$data['entries'][$nid]['category'] = $n->newscat_name;
								$data['entries'][$nid]['status'] = $n->news_status;
							}
						}
						elseif (Auth::get_access_level('manage/logs') == 2)
						{
							$date = gmt_to_local($n->news_date, $this->timezone, $this->dst);
							$nid = $n->news_id;
							
							$data['entries'][$nid]['id'] = $nid;
							$data['entries'][$nid]['title'] = $n->news_title;
							$data['entries'][$nid]['author'] = $this->char->get_character_name($n->news_author_character, true, false, true);
							$data['entries'][$nid]['date'] = mdate($datestring, $date);
							$data['entries'][$nid]['category'] = $n->newscat_name;
							$data['entries'][$nid]['status'] = $n->news_status;
						}
					}
				}
		
				$config['total_rows'] = $this->news->count_news_items($status);
				
			    $this->pagination->initialize($config);
			    
			    // create the page links
				$data['pagination'] = $this->pagination->create_links();
				
				$data['status'] = $status;
				$data['page'] = $offset;
				
				$data['images'] = array(
			    	'edit' => array(
			    		'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_edit')),
			    		'class' => 'image'),
			    	'delete' => array(
			    		'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_delete')),
			    		'class' => 'image'),
			    	'approve' => array(
			    		'src' => Location::img('icon-check.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_approve')),
			    		'class' => 'image'),
			    	'view' => array(
			    		'src' => Location::img('icon-view.png', $this->skin, 'admin'),
			    		'alt' => ucfirst(lang('actions_view')),
			    		'class' => 'image'),
			    );
				
				// figure out where the view is coming from
	    		$loc = 'manage_news_ajax';
			break;
		}
		
		$data['label'] = array(
	    	'mission' => ucfirst(lang('global_mission')),
	    	'by' => lang('labels_by'),
	    	'category' => ucfirst(lang('labels_category')) .':',
	    	'date' => ucfirst(lang('labels_date')),
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
	    
	    // parse the message
		$message = Location::view($loc, $this->skin, 'admin', $data);

	    return $message;
	}
}
