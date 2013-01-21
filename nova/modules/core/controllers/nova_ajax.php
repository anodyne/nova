<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Ajax controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

abstract class Nova_ajax extends CI_Controller {
	
	/**
	 * Variable to store all the information about template regions
	 */
	protected $_regions = array();
	
	public function __construct()
	{
		parent::__construct();
		
		// load the resources
		$this->load->database();
		$this->load->library('session');
		$this->load->model('system_model', 'sys');
	
		// check to see if they are logged in
		Auth::is_logged_in();
		
		// set and load the language file needed
		$this->lang->load('app', $this->session->userdata('language'));
		
		// set the template file
		Template::$file = '_base/template_ajax';
		
		// set the module
		Template::$data['module'] = 'core';
		
		// set the default regions
		$this->_regions['content'] = false;
		$this->_regions['controls'] = false;
	}
	
	public function add_bio_field()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_bio') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_bio_field');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'field_name',
					'class' => 'hud'),
				'id' => array(
					'name' => 'field_fid',
					'class' => 'hud'),
				'class' => array(
					'name' => 'field_class',
					'class' => 'hud'),
				'label' => array(
					'name' => 'field_label_page',
					'class' => 'hud'),
				'rows' => array(
					'name' => 'field_rows',
					'class' => 'hud small'),
				'order' => array(
					'name' => 'field_order',
					'class' => 'hud small'),
				'display_y' => array(
					'name' => 'field_display',
					'id' => 'field_display_y',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'field_display',
					'id' => 'field_display_n',
					'value' => 'n'),
				'select' => array(
					'name' => 'select_values',
					'rows' => 8,
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['values']['type'] = array(
				'text' => ucwords(lang('labels_text') .' '. lang('labels_field')),
				'textarea' => ucwords(lang('labels_text') .' '. lang('labels_area')),
				'select' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu'))
			);
			
			$sections = $this->char->get_bio_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$data['values']['section'][$sec->section_id] = $sec->section_name;
				}
			}
			
			$data['label'] = array(
				'class' => ucfirst(lang('labels_class')),
				'display' => ucfirst(lang('labels_display')),
				'dropdown_select' => lang('text_dropdown_select'),
				'html' => lang('misc_html_attr'),
				'id' => lang('abbr_id'),
				'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'rows' => lang('misc_textarea_rows'),
				'section' => ucfirst(lang('labels_section')),
				'select' => lang('misc_select'),
				'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_bio_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_bio_field_value()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$value = $this->input->post('value', true);
			$content = $this->input->post('content', true);
			$field = $this->input->post('field', true);
			$order = 0;
			
			$values = $this->char->get_bio_values($field);
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->value_order + 1;
				
			}
			
			$insert_array = array(
				'value_content' => $content,
				'value_order' => $order,
				'value_field' => $field,
				'value_field_value' => $value
			);
				
			$insert = $this->char->add_bio_field_value($insert_array);
			$insert_id = $this->db->insert_id();
			
			// optimize the table
			$this->sys->optimize_table('characters_values');
			
			if ($insert > 0)
			{
				$output = '<li class="ui-state-default" id="value_'. $insert_id .'"><div class="float_right"><a href="#" class="remove image" name="remove" id="'. $insert_id .'">x</a></div><a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="'. $insert_id .'"/>'. $content .'</a></li>';
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_created'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_admin');
				
				$output = Location::view('flash', $skin, 'admin', $flash);
			}
			
			echo $output;
		}
	}
	
	public function add_bio_sec()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$tabs = $this->char->get_bio_tabs();
			
			$data['values']['tabs'][0] = ucwords(lang('labels_please').' '.lang('actions_choose').' '.lang('order_one'));
			
			if ($tabs->num_rows() > 0)
			{
				foreach ($tabs->result() as $t)
				{
					$data['values']['tabs'][$t->tab_id] = $t->tab_name;
				}
			}
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_bio') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_bio_sec');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
				'tab' => ucfirst(lang('labels_tab')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_bio_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_bio_tab()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_bio') .' '. lang('labels_tab'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_bio_tab');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'tab_name',
					'class' => 'hud'),
				'link' => array(
					'name' => 'tab_link_id',
					'class' => 'hud medium'),
				'order' => array(
					'name' => 'tab_order',
					'class' => 'hud small'),
				'display_y' => array(
					'name' => 'tab_display',
					'id' => 'tab_display_y',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'tab_display',
					'id' => 'tab_display_n',
					'value' => 'n'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'display' => ucfirst(lang('labels_display')),
				'link' => ucfirst(lang('labels_link') .' '. lang('abbr_id')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_bio_tab', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_catalogue()
	{
		$type = $this->uri->segment(3);
		
		// figure out the skin
		$skin = $this->session->userdata('skin_admin');
		
		switch ($type)
		{
			case 'ranks':
				$allowed = Auth::check_access('site/catalogueranks', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'add_catalogue_ranks';
					
					$data['inputs'] = array(
						'name' => array(
							'name' => 'rank_name',
							'class' => 'hud'),
						'location' => array(
							'name' => 'rank_location',
							'class' => 'hud'),
						'preview' => array(
							'name' => 'rank_preview',
							'class' => 'hud',
							'value' => 'preview.png'),
						'blank' => array(
							'name' => 'rank_blank',
							'class' => 'hud',
							'value' => 'blank.png'),
						'extension' => array(
							'name' => 'rank_extension',
							'class' => 'hud',
							'value' => '.png'),
						'genre' => array(
							'name' => 'rank_genre',
							'class' => 'hud',
							'value' => GENRE),
						'credits' => array(
							'name' => 'rank_credits',
							'class' => 'hud',
							'rows' => 4),
						'default_y' => array(
							'name' => 'rank_default',
							'id' => 'rank_default_y',
							'value' => 'y'),
						'default_n' => array(
							'name' => 'rank_default',
							'id' => 'rank_default_n',
							'value' => 'n',
							'checked' => true),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_add')),
						ucwords(lang('global_rank') .' '. lang('labels_set'))
					);
					
					$data['values']['status'] = array(
						'active' => ucfirst(lang('status_active')),
						'inactive' => ucfirst(lang('status_inactive')),
						'development' => lang('misc_development')
					);
				}
			break;
				
			case 'skins':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'add_catalogue_skins';
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_add')),
						ucwords(lang('labels_skin'))
					);
					
					$data['inputs'] = array(
						'name' => array(
							'name' => 'skin_name',
							'class' => 'hud'),
						'location' => array(
							'name' => 'skin_location',
							'class' => 'hud'),
						'credits' => array(
							'name' => 'skin_credits',
							'class' => 'hud',
							'rows' => 4),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
				}
			break;
				
			case 'skinsecs':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'add_catalogue_skinsec';
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_add')),
						ucwords(lang('labels_skin') .' '. lang('labels_section'))
					);
					
					$data['inputs'] = array(
						'preview' => array(
							'name' => 'preview',
							'class' => 'hud',
							'value' => 'preview.png'),
						'default_y' => array(
							'name' => 'default',
							'id' => 'skin_default_y',
							'value' => 'y'),
						'default_n' => array(
							'name' => 'default',
							'id' => 'skin_default_n',
							'value' => 'n',
							'checked' => true),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
					
					$data['values']['section'] = array(
						'main' => ucfirst(lang('labels_main')),
						'admin' => ucfirst(lang('labels_admin')),
						'wiki' => ucfirst(lang('global_wiki')),
						'login' => ucfirst(lang('labels_login')),
					);
					
					$data['values']['status'] = array(
						'active' => ucfirst(lang('status_active')),
						'inactive' => ucfirst(lang('status_inactive')),
						'development' => lang('misc_development')
					);
					
					$skins = $this->sys->get_all_skins();
					
					if ($skins->num_rows() > 0)
					{
						foreach ($skins->result() as $s)
						{
							$data['skins'][$s->skin_location] = $s->skin_name;
						}
					}
				}
			break;
		}
		
		// data being sent to the facebox
		$data['header'] = $head;
		
		$data['label'] = array(
			'blank' => ucwords(lang('labels_blank') .' '. lang('labels_image')),
			'credits' => ucfirst(lang('labels_credits')),
			'default_rank' => ucwords(lang('labels_default') .' '. lang('global_rank') .' '. lang('labels_set')),
			'default_theme' => ucwords(lang('labels_default') .' '. lang('labels_section')),
			'display' => ucfirst(lang('labels_display')),
			'extension' => ucwords(lang('labels_image') .' '. lang('labels_extension')),
			'genre' => ucfirst(lang('labels_genre')),
			'location' => lang('misc_server_dir'),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'order' => ucfirst(lang('labels_order')),
			'preview' => ucwords(lang('labels_preview') .' '. lang('labels_image')),
			'section' => ucfirst(lang('labels_section')),
			'skin' => ucfirst(lang('labels_skin')),
			'status' => ucfirst(lang('labels_status')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		$this->_regions['content'] = Location::ajax($view, $skin, 'admin', $data);
		$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function add_coc_entry()
	{
		$allowed = Auth::check_access('characters/coc', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$values = $this->char->get_coc();
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->coc_order + 1;
			}
			
			$user = $this->input->post('user', true);
			
			$insert_array = array(
				'coc_crew' => $user,
				'coc_order' => (isset($order)) ? $order : 0,
			);
				
			$insert = $this->char->create_coc_entry($insert_array);
			
			if ($insert > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_character')),
					lang('actions_added'),
					''
				);
	
				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_character')),
					lang('actions_added'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function add_comment_log()
	{
		$allowed = Auth::is_logged_in();
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_personallog') .' '. lang('labels_comment'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['log_id'] = $this->uri->segment(3, 0);
			
			// input parameters
			$data['inputs'] = array(
				'comment_text' => array(
					'name' => 'comment_text',
					'id' => 'comment_text',
					'rows' => 10,
					'class' => 'hud'),
				'comment_button' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_main');
			
			$this->_regions['content'] = Location::ajax('add_log_comment', $skin, 'main', $data);
			$this->_regions['controls'] = form_button($data['inputs']['comment_button']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_comment_news()
	{
		$allowed = Auth::is_logged_in();
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_newsitem') .' '. lang('labels_comment'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['news_id'] = $this->uri->segment(3, 0);
			
			// input parameters
			$data['inputs'] = array(
				'comment_text' => array(
					'name' => 'comment_text',
					'id' => 'comment_text',
					'rows' => 10,
					'class' => 'hud'),
				'comment_button' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_main');
			
			$this->_regions['content'] = Location::ajax('add_news_comment', $skin, 'main', $data);
			$this->_regions['controls'] = form_button($data['inputs']['comment_button']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_comment_post()
	{
		$allowed = Auth::is_logged_in();
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_missionpost') .' '. lang('labels_comment'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['post_id'] = $this->uri->segment(3, 0);
			
			// input parameters
			$data['inputs'] = array(
				'comment_text' => array(
					'name' => 'comment_text',
					'id' => 'comment_text',
					'rows' => 10,
					'class' => 'hud'),
				'comment_button' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_main');
			
			$this->_regions['content'] = Location::ajax('add_post_comment', $skin, 'main', $data);
			$this->_regions['controls'] = form_button($data['inputs']['comment_button']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_comment_wiki()
	{
		$allowed = Auth::check_access('wiki/page', false);
		$level = Auth::get_access_level('wiki/page');
		
		if ($allowed and $level >= 1)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_wiki') .' '. lang('labels_comment'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0);
			
			// input parameters
			$data['inputs'] = array(
				'comment_text' => array(
					'name' => 'comment_text',
					'id' => 'comment_text',
					'rows' => 10,
					'class' => 'hud'),
				'comment_button' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('add_wiki_comment', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['comment_button']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_deck()
	{
		$allowed = Auth::check_access('manage/decks', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$values = $this->tour->get_decks();
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->deck_order + 1;
			}
			
			$deck = $this->input->post('deck', true);
			$item = $this->input->post('item', true);
			
			$insert_array = array(
				'deck_name' => $deck,
				'deck_order' => (isset($order)) ? $order : 0,
				'deck_content' => '',
				'deck_item' => $item,
			);
				
			$insert = $this->tour->add_deck($insert_array);
			$insert_id = $this->db->insert_id();
			
			// optimize the table
			$this->sys->optimize_table('tour_decks');
			
			if ($insert > 0)
			{
				$output = '<li class="ui-state-default" id="decks_'. $insert_id .'"><div class="float_right"><a href="#" class="remove image" name="remove" id="'. $insert_id .'">x</a></div><a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="'. $insert_id .'"/>'. $deck .'</a></li>';
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_deck')),
					lang('actions_added'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_admin');
					
				$output = Location::view('flash', $skin, 'admin', $flash);
			}
			
			echo $output;
		}
	}
	
	public function add_dept()
	{
		$allowed = Auth::check_access('manage/depts', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_department'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'dept_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'dept_order',
					'class' => 'hud small',
					'value' => 99),
				'desc' => array(
					'name' => 'dept_desc',
					'class' => 'hud',
					'rows' => 6),
				'display_y' => array(
					'name' => 'dept_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'dept_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$depts = $this->dept->get_all_depts('asc', '');
			
			$data['values']['depts'][0] = ucfirst(lang('labels_none'));
			$data['values']['manifest'][0] = ucfirst(lang('labels_none'));
			
			if ($depts->num_rows() > 0)
			{
				foreach ($depts->result() as $dept)
				{
					$data['values']['depts'][$dept->dept_id] = $dept->dept_name;
				}
			}
			
			$manifests = $this->dept->get_all_manifests(null);
			
			if ($manifests->num_rows() > 0)
			{
				foreach ($manifests->result() as $m)
				{
					$data['values']['manifest'][$m->manifest_id] = $m->manifest_name;
				}
			}
			
			$data['values']['type'] = array(
				'playing' => ucfirst(lang('status_playing')),
				'nonplaying' => ucfirst(lang('status_nonplaying'))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'type' => ucfirst(lang('labels_type')),
				'desc' => ucfirst(lang('labels_desc')),
				'display' => ucfirst(lang('labels_display')),
				'on' => ucfirst(lang('labels_on')),
				'off' => ucfirst(lang('labels_off')),
				'order' => ucfirst(lang('labels_order')),
				'parent' => ucwords(lang('labels_parent') .' '. lang('global_department')),
				'manifest' => ucfirst(lang('labels_manifest')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_dept', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_docking_field()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('actions_docking') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_docking_field');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'field_name',
					'class' => 'hud'),
				'id' => array(
					'name' => 'field_fid',
					'class' => 'hud'),
				'class' => array(
					'name' => 'field_class',
					'class' => 'hud'),
				'label' => array(
					'name' => 'field_label_page',
					'class' => 'hud'),
				'rows' => array(
					'name' => 'field_rows',
					'class' => 'hud small'),
				'order' => array(
					'name' => 'field_order',
					'class' => 'hud small'),
				'display_y' => array(
					'name' => 'field_display',
					'id' => 'field_display_y',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'field_display',
					'id' => 'field_display_n',
					'value' => 'n'),
				'select' => array(
					'name' => 'select_values',
					'rows' => 8,
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['values']['type'] = array(
				'text' => ucwords(lang('labels_text') .' '. lang('labels_field')),
				'textarea' => ucwords(lang('labels_text') .' '. lang('labels_area')),
				'select' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu'))
			);
			
			$sections = $this->docking->get_docking_sections();
			
			$data['values']['section'][0] = false;
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$data['values']['section'][$sec->section_id] = $sec->section_name;
				}
			}
			
			$data['label'] = array(
				'class' => ucfirst(lang('labels_class')),
				'display' => ucfirst(lang('labels_display')),
				'dropdown_select' => lang('text_dropdown_select'),
				'html' => lang('misc_html_attr'),
				'id' => lang('abbr_id'),
				'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'rows' => lang('misc_textarea_rows'),
				'section' => ucfirst(lang('labels_section')),
				'select' => lang('misc_select'),
				'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_docking_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_docking_field_value()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$value = $this->input->post('value', true);
			$content = $this->input->post('content', true);
			$field = $this->input->post('field', true);
			
			$values = $this->docking->get_docking_values($field);
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->value_order + 1;
			}
			
			$insert_array = array(
				'value_content' => $content,
				'value_order' => (isset($order)) ? $order : 0,
				'value_field' => $field,
				'value_field_value' => $value
			);
				
			$insert = $this->docking->add_docking_field_value($insert_array);
			$insert_id = $this->db->insert_id();
			
			// optimize the table
			$this->sys->optimize_table('docking_values');
			
			if ($insert > 0)
			{
				$output = '<li class="ui-state-default" id="value_'. $insert_id .'"><div class="float_right"><a href="#" class="remove image" name="remove" id="'. $insert_id .'">x</a></div><a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="'. $insert_id .'"/>'. $content .'</a></li>';
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('actions_docking') .' '. lang('labels_form') .' '. lang('labels_field')),
					lang('actions_created'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_admin');
					
				$output = Location::view('flash', $skin, 'admin', $flash);
			}
			
			echo $output;
		}
	}
	
	public function add_docking_sec()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('actions_docking') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_docking_sec');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_docking_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_menu_cat()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_menu') .' '. lang('labels_category'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_menucat');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'menucat_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'menucat_order',
					'class' => 'hud small',
					'value' => 99),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$cats = $this->menu_model->get_all_item_categories();
			
			if ($cats->num_rows() > 0)
			{
				foreach ($cats->result() as $cat)
				{
					$data['cats'][$cat->menu_cat] = ucfirst($cat->menu_cat);
				}
			}
			
			$data['label'] = array(
				'category' => ucfirst(lang('labels_category')),
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
				'type' => ucfirst(lang('labels_type'))
			);
			
			$data['types'] = array(
				'sub' => ucwords(lang('labels_sub') .' '. lang('labels_navigation')),
				'adminsub' => ucwords(lang('labels_admin') .' '. lang('labels_sub') .' '. lang('labels_navigation')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_menu_cat', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_menu_item()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_menu'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_menu');
			$data['tab'] = $this->uri->segment(3, 0, true);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'menu_name',
					'class' => 'hud'),
				'group' => array(
					'name' => 'menu_group',
					'class' => 'hud small',
					'value' => 0),
				'order' => array(
					'name' => 'menu_order',
					'class' => 'hud small',
					'value' => 99),
				'link' => array(
					'name' => 'menu_link',
					'class' => 'hud'),
				'link_type_on' => array(
					'name' => 'menu_link_type',
					'id' => 'link_type_on',
					'class' => 'hud',
					'value' => 'onsite',
					'checked' => true),
				'link_type_off' => array(
					'name' => 'menu_link_type',
					'id' => 'link_type_off',
					'class' => 'hud',
					'value' => 'offsite'),
				'use_access_y' => array(
					'name' => 'menu_use_access',
					'id' => 'use_access_y',
					'class' => 'hud',
					'value' => 'y'),
				'use_access_n' => array(
					'name' => 'menu_use_access',
					'id' => 'use_access_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => true),
				'display_y' => array(
					'name' => 'menu_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'menu_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n'),
				'access' => array(
					'name' => 'menu_access',
					'class' => 'hud'),
				'access_level' => array(
					'name' => 'menu_access_level',
					'class' => 'hud small',
					'value' => 0),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$sim = $this->sys->get_sim_types();
			
			if ($sim->num_rows() > 0)
			{
				foreach ($sim->result() as $s)
				{
					$data['values']['sim_type'][$s->simtype_id] = ucfirst($s->simtype_name);
				}
			}
			
			$data['values']['login'] = array(
				'none' => ucfirst(lang('labels_no') .' '. lang('labels_requirement')),
				'y' => lang('misc_login_y'),
				'n' => lang('misc_login_n'),
			);
			
			$data['values']['type'] = array(
				'' => ucwords(lang('labels_please') .' '. lang('actions_choose')
					.' '. lang('order_one')),
				'main' => ucwords(lang('labels_main') .' '. lang('labels_navigation')),
				'sub' => ucwords(lang('labels_sub') .' '. lang('labels_navigation')),
				'adminsub' => ucwords(lang('labels_admin') .' '. lang('labels_sub') .' '. lang('labels_navigation')),
			);
			
			$cats = $this->menu_model->get_menu_categories();
			
			if ($cats->num_rows() > 0)
			{
				foreach ($cats->result() as $cat)
				{
					$data['cats'][$cat->menucat_menu_cat] = $cat->menucat_name;
				}
			}
			
			$data['label'] = array(
				'category' => ucfirst(lang('labels_category')),
				'control' => ucwords(lang('labels_access') .' '. lang('labels_control')),
				'control_level' => ucwords(lang('labels_access') .' '. lang('labels_control') .' '. lang('labels_level')),
				'control_text' => lang('text_menu_access'),
				'control_url' => ucwords(lang('labels_access') .' '. lang('labels_control') .' '. lang('abbr_url')),
				'desc' => ucfirst(lang('labels_desc')),
				'display' => ucfirst(lang('labels_display')),
				'group' => ucfirst(lang('labels_group')),
				'groupsort' => ucwords(lang('labels_grouping') .' '. AMP .' '. lang('labels_sorting')),
				'link' => ucfirst(lang('labels_link')),
				'linktype' => ucwords(lang('labels_link') .' '. lang('labels_type')),
				'login_req' => ucwords(lang('labels_login') .' '. lang('labels_requirement')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'off' => ucfirst(lang('labels_off')),
				'offsite' => ucfirst(lang('labels_offsite')),
				'on' => ucfirst(lang('labels_on')),
				'onsite' => ucfirst(lang('labels_onsite')),
				'order' => ucfirst(lang('labels_order')),
				'simtype' => ucwords(lang('labels_sim') .' '. lang('labels_type')),
				'simtype_text' => lang('text_sim_type'),
				'type' => ucfirst(lang('labels_type')),
				'typecat' => ucwords(lang('labels_type') .' '. AMP .' '. lang('labels_category')),
				'use_access' => ucwords(lang('actions_use') .' '. lang('labels_access') .' '. lang('labels_control')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_menu_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_mission()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_mission'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = sprintf(
				lang('text_create_mission_onfly'),
				lang('global_missions'),
				lang('global_mission'),
				lang('global_mission'),
				lang('global_mission'),
				lang('global_mission'),
				lang('global_mission')
			);
			
			// input parameters
			$data['inputs'] = array(
				'title' => array(
					'name' => 'mission_title',
					'class' => 'hud',
					'id' => 'addMissionTitle'),
				'desc' => array(
					'name' => 'mission_desc',
					'class' => 'hud',
					'rows' => 4,
					'id' => 'addMissionDesc'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'id' => 'addMission',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$missions = $this->mis->get_all_missions('upcoming');
			
			$data['missions'][0] = ucwords(lang('actions_create') .' '. lang('status_new') .' '. lang('global_mission'));
			
			if ($missions->num_rows() > 0)
			{
				foreach ($missions->result() as $m)
				{
					$data['missions'][$m->mission_id] = $m->mission_title;
				}
			}
			
			$data['label'] = array(
				'desc' => ucfirst(lang('labels_desc')),
				'title' => ucfirst(lang('labels_title')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_mission_simple', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_mission_action()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$option = $this->input->post('option', true);
			
			if ($option == 0)
			{
				$missions = $this->mis->get_all_missions();
				
				if ($missions->num_rows() > 0)
				{
					$last = $missions->last_row();
					$order = $last->mission_order + 1;
				}
				else
				{
					$order = 0;
				}
				
				$data = array(
					'mission_title' => $this->input->post('title', true),
					'mission_desc' => $this->input->post('desc', true),
					'mission_start' => now(),
					'mission_status' => 'current',
					'mission_order' => $order
				);
				
				$this->mis->add_mission($data);
			}
			else
			{
				$data = array(
					'mission_status' => 'current',
					'mission_start' => now()
				);
				
				$this->mis->update_mission($option, $data);
			}
			
			echo '';
		}
	}
	
	public function add_mission_group()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_missiongroup'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			
			$groups = $this->mis->get_all_mission_groups();
			
			if ($groups->num_rows() > 0)
			{
				$groups_select[0] = ucwords(lang('labels_no').' '.lang('labels_parent').' '.lang('global_missiongroup'));
				
				foreach ($groups->result() as $g)
				{
					$groups_select[$g->misgroup_id] = $g->misgroup_name;
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'misgroup_name',
					'class' => 'hud'),
				'parent' => (isset($groups_select)) ? $groups_select : false,
				'order' => array(
					'name' => 'misgroup_order',
					'class' => 'small hud'),
				'desc' => array(
					'name' => 'misgroup_desc',
					'class' => 'hud',
					'rows' => 5),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'id' => 'addMission',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'parent' => ucwords(lang('labels_parent').' '.lang('global_missiongroup')),
				'order' => ucfirst(lang('labels_order')),
				'desc' => ucfirst(lang('labels_desc')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_mission_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_position()
	{
		$allowed = Auth::check_access('manage/positions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_position'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['g_dept'] = $this->uri->segment(3, 1, true);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'pos_name',
					'class' => 'hud'),
				'open' => array(
					'name' => 'pos_open',
					'class' => 'hud small',
					'value' => 1),
				'order' => array(
					'name' => 'pos_order',
					'class' => 'hud small',
					'value' => 99),
				'desc' => array(
					'name' => 'pos_desc',
					'class' => 'hud',
					'rows' => 4),
				'display_y' => array(
					'name' => 'pos_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'pos_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n'),
				'top_y' => array(
					'name' => 'pos_top_open',
					'id' => 'top_y',
					'class' => 'hud',
					'value' => 'y'),
				'top_n' => array(
					'name' => 'pos_top_open',
					'id' => 'top_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => true),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$depts = $this->dept->get_all_depts('asc', '');
			
			if ($depts->num_rows() > 0)
			{
				foreach ($depts->result() as $dept)
				{
					$data['values']['depts'][$dept->dept_id] = $dept->dept_name;
					
					$subd = $this->dept->get_sub_depts($dept->dept_id, 'asc', '');
					
					if ($subd->num_rows() > 0)
					{
						foreach ($subd->result() as $sub)
						{
							$data['values']['depts'][$sub->dept_id] = $sub->dept_name;
						}
					}
				}
			}
			
			$data['values']['type'] = array(
				'senior' => ucwords(lang('labels_senior')),
				'officer' => ucwords(lang('labels_officer')),
				'enlisted' => ucwords(lang('labels_enlisted')),
				'other' => ucwords(lang('labels_other')),
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'type' => ucfirst(lang('labels_type')),
				'desc' => ucfirst(lang('labels_desc')),
				'open' => ucwords(lang('status_open') .' '. lang('labels_slots')),
				'dept' => ucfirst(lang('global_department')),
				'display' => ucfirst(lang('labels_display')),
				'on' => ucfirst(lang('labels_on')),
				'off' => ucfirst(lang('labels_off')),
				'yes' => ucfirst(lang('labels_yes')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'top' => ucwords(lang('labels_top').' '.lang('status_open').' '.lang('global_position'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_position', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_rank()
	{
		$allowed = Auth::check_access('manage/ranks', false);
		
		if ($allowed)
		{
			$this->load->model('ranks_model', 'ranks');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_rank'))
			);
			
			$data['set'] = $this->uri->segment(3, 'default');
			$data['class'] = $this->uri->segment(4, 1, true);
			
			$data['ext'] = $this->ranks->get_rankcat($data['set'], 'rankcat_id', 'rankcat_extension');
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_rank');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'rank_name',
					'class' => 'hud'),
				'shortname' => array(
					'name' => 'rank_short_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'rank_order',
					'class' => 'hud small',
					'value' => 99),
				'class' => array(
					'name' => 'rank_class',
					'class' => 'hud small',
					'value' => $data['class']),
				'image' => array(
					'name' => 'rank_image',
					'class' => 'hud'),
				'display_y' => array(
					'name' => 'rank_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'rank_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'shortname' => ucwords(lang('labels_shortname')),
				'display' => ucfirst(lang('labels_display')),
				'on' => ucfirst(lang('labels_on')),
				'off' => ucfirst(lang('labels_off')),
				'order' => ucfirst(lang('labels_order')),
				'class' => ucwords(lang('global_rank') .' '. lang('labels_class')),
				'image' => ucfirst(lang('labels_image')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_rank', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_role_group()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_role_group');
			$data['id'] = $this->uri->segment(3, 0, true);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'group_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'group_order',
					'class' => 'hud small',
					'value' => 99),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_role_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_role_page()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_role') .' '. lang('labels_page'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['user'] = $this->uri->segment(3, 0);
			
			$groups = $this->access->get_page_groups();
			
			$data['groups'][0] = ucwords(lang('labels_none'));
			
			if ($groups->num_rows() > 0)
			{
				foreach ($groups->result() as $group)
				{
					$data['groups'][$group->group_id] = $group->group_name;
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'page_name',
					'class' => 'hud'),
				'url' => array(
					'name' => 'page_url',
					'class' => 'hud'),
				'level' => array(
					'name' => 'page_level',
					'class' => 'small hud',
					'value' => 0),
				'desc' => array(
					'name' => 'page_desc',
					'class' => 'hud',
					'value' => '',
					'rows' => 4),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'desc' => ucfirst(lang('labels_desc')),
				'group' => ucfirst(lang('labels_group')),
				'level' => ucwords(lang('labels_page') .' '. lang('labels_level')),
				'name' => ucwords(lang('labels_page') .' '. lang('labels_name')),
				'url' => ucwords(lang('labels_page') .' '. lang('abbr_url')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_role_page', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_site_message()
	{
		$allowed = Auth::check_access('site/messages', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('labels_site') .' '. lang('labels_message'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_site_message');
			
			// input parameters
			$data['inputs'] = array(
				'key' => array(
					'name' => 'message_key',
					'class' => 'hud'),
				'label' => array(
					'name' => 'message_label',
					'class' => 'hud'),
				'content' => array(
					'name' => 'message_content',
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['type'] = array(
				'title' => ucwords(lang('labels_page') .' '. lang('labels_titles')),
				'message' => ucfirst(lang('labels_messages')),
				'other' => ucfirst(lang('labels_other'))
			);
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'key' => ucwords(lang('labels_message') .' '. lang('labels_key')),
				'label' => ucwords(lang('labels_message') .' '. lang('labels_label')),
				'type' => ucfirst(lang('labels_type')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_site_message', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_spec_field()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_specifications') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_spec_field');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'field_name',
					'class' => 'hud'),
				'id' => array(
					'name' => 'field_fid',
					'class' => 'hud'),
				'class' => array(
					'name' => 'field_class',
					'class' => 'hud'),
				'label' => array(
					'name' => 'field_label_page',
					'class' => 'hud'),
				'rows' => array(
					'name' => 'field_rows',
					'class' => 'hud small'),
				'order' => array(
					'name' => 'field_order',
					'class' => 'hud small'),
				'display_y' => array(
					'name' => 'field_display',
					'id' => 'field_display_y',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'field_display',
					'id' => 'field_display_n',
					'value' => 'n'),
				'select' => array(
					'name' => 'select_values',
					'rows' => 8,
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['values']['type'] = array(
				'text' => ucwords(lang('labels_text') .' '. lang('labels_field')),
				'textarea' => ucwords(lang('labels_text') .' '. lang('labels_area')),
				'select' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu'))
			);
			
			$sections = $this->specs->get_spec_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$data['values']['section'][$sec->section_id] = $sec->section_name;
				}
			}
			
			$data['label'] = array(
				'class' => ucfirst(lang('labels_class')),
				'display' => ucfirst(lang('labels_display')),
				'dropdown_select' => lang('text_dropdown_select'),
				'html' => lang('misc_html_attr'),
				'id' => lang('abbr_id'),
				'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'rows' => lang('misc_textarea_rows'),
				'section' => ucfirst(lang('labels_section')),
				'select' => lang('misc_select'),
				'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_spec_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_spec_field_value()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$value = $this->input->post('value', true);
			$content = $this->input->post('content', true);
			$field = $this->input->post('field', true);
			
			$values = $this->specs->get_spec_values($field);
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->value_order + 1;
			}
			
			$insert_array = array(
				'value_content' => $content,
				'value_order' => (isset($order)) ? $order : 0,
				'value_field' => $field,
				'value_field_value' => $value
			);
				
			$insert = $this->specs->add_spec_field_value($insert_array);
			$insert_id = $this->db->insert_id();
			
			// optimize the table
			$this->sys->optimize_table('specs_values');
			
			if ($insert > 0)
			{
				$output = '<li class="ui-state-default" id="value_'. $insert_id .'"><div class="float_right"><a href="#" class="remove image" name="remove" id="'. $insert_id .'">x</a></div><a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="'. $insert_id .'"/>'. $content .'</a></li>';
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('flash_item_spec_field_value')),
					lang('actions_created'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_admin');
					
				$output = Location::view('flash', $skin, 'admin', $flash);
			}
			
			echo $output;
		}
	}
	
	public function add_spec_sec()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_specifications') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_spec_sec');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud'),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_spec_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_tour_field()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_add')),
				ucwords(lang('global_tour') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_tour_field');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'field_name',
					'class' => 'hud'),
				'id' => array(
					'name' => 'field_fid',
					'class' => 'hud'),
				'class' => array(
					'name' => 'field_class',
					'class' => 'hud'),
				'label' => array(
					'name' => 'field_label_page',
					'class' => 'hud'),
				'rows' => array(
					'name' => 'field_rows',
					'class' => 'hud small'),
				'order' => array(
					'name' => 'field_order',
					'class' => 'hud small'),
				'display_y' => array(
					'name' => 'field_display',
					'id' => 'field_display_y',
					'value' => 'y',
					'checked' => true),
				'display_n' => array(
					'name' => 'field_display',
					'id' => 'field_display_n',
					'value' => 'n'),
				'select' => array(
					'name' => 'select_values',
					'rows' => 8,
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['values']['type'] = array(
				'text' => ucwords(lang('labels_text') .' '. lang('labels_field')),
				'textarea' => ucwords(lang('labels_text') .' '. lang('labels_area')),
				'select' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu'))
			);
			
			$data['label'] = array(
				'class' => ucfirst(lang('labels_class')),
				'display' => ucfirst(lang('labels_display')),
				'dropdown_select' => lang('text_dropdown_select'),
				'html' => lang('misc_html_attr'),
				'id' => lang('abbr_id'),
				'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'rows' => lang('misc_textarea_rows'),
				'section' => ucfirst(lang('labels_section')),
				'select' => lang('misc_select'),
				'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_tour_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function add_tour_field_value()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$value = $this->input->post('value', true);
			$content = $this->input->post('content', true);
			$field = $this->input->post('field', true);
			
			$values = $this->tour->get_tour_values($field);
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->value_order + 1;
			}
			
			$insert_array = array(
				'value_content' => $content,
				'value_order' => (isset($order)) ? $order : 0,
				'value_field' => $field,
				'value_field_value' => $value
			);
				
			$insert = $this->tour->add_tour_field_value($insert_array);
			$insert_id = $this->db->insert_id();
			
			// optimize the table
			$this->sys->optimize_table('tour_values');
			
			if ($insert > 0)
			{
				$output = '<li class="ui-state-default" id="value_'. $insert_id .'"><div class="float_right"><a href="#" class="remove image" name="remove" id="'. $insert_id .'">x</a></div><a href="#" rel="facebox" myAction="edit_val" myField="<?php echo $id;?>" class="image" myID="'. $insert_id .'"/>'. $content .'</a></li>';
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_created'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_admin');
					
				$output = Location::view('flash', $skin, 'admin', $flash);
			}
			
			echo $output;
		}
	}
	
	public function add_user_setting()
	{
		$allowed = Auth::check_access('site/settings', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_create')),
				ucwords(lang('labels_site') .' '. lang('labels_setting'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_add_user_setting');
			
			// input parameters
			$data['inputs'] = array(
				'key' => array(
					'name' => 'setting_key',
					'class' => 'hud'),
				'label' => array(
					'name' => 'setting_label',
					'class' => 'hud'),
				'value' => array(
					'name' => 'setting_value',
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'key' => ucwords(lang('labels_setting') .' '. lang('labels_key')),
				'label' => ucwords(lang('labels_label')),
				'value' => ucfirst(lang('labels_value')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('add_user_setting', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function approve()
	{
		$data['type'] = $this->uri->segment(3, false);
		$data['id'] = $this->uri->segment(4, 0, true);
		
		// figure out the skin
		$skin = $this->session->userdata('skin_admin');
		
		// figure out where the view should come from
		$view = 'approve';
		
		switch ($data['type'])
		{
			case 'posts':
				$allowed = Auth::check_access('manage/posts', false);
				$level = Auth::get_access_level('manage/posts');
				
				if ($allowed and $level == 2)
				{
					$this->load->model('posts_model', 'posts');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_missionpost');
					
					// grab the post info
					$item = $this->posts->get_post($data['id']);
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_missionpost'),
						$item->post_title,
						' '. lang('labels_by') .' '.
							$this->char->get_authors($item->post_authors, true)
					);
					
					$data['form'] = 'manage/posts/pending/0/approve';
				}
			break;
				
			case 'logs':
				$allowed = Auth::check_access('manage/logs', false);
				$level = Auth::get_access_level('manage/logs');
				
				if ($allowed and $level == 2)
				{
					$this->load->model('personallogs_model', 'logs');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_personallog');
					
					// grab the log info
					$item = $this->logs->get_log($data['id']);
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_personallog'),
						$item->log_title,
						' '. lang('labels_by') .' '.
							$this->char->get_character_name($item->log_author_character, true)
					);
					
					$data['form'] = 'manage/logs/pending/0/approve';
				}
			break;
				
			case 'news':
				$allowed = Auth::check_access('manage/news', false);
				$level = Auth::get_access_level('manage/news');
				
				if ($allowed and $level == 2)
				{
					$this->load->model('news_model', 'news');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_newsitem');
					
					// grab the news item info
					$item = $this->news->get_news_item($data['id']);
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_newsitem'),
						$item->news_title,
						' '. lang('labels_by') .' '.
							$this->char->get_character_name($item->news_author_character, true)
					);
					
					$data['form'] = 'manage/news/pending/0/approve';
				}
			break;
				
			case 'posts_comment':
				$allowed = Auth::check_access('manage/comments', false);
				
				if ($allowed)
				{
					$this->load->model('posts_model', 'posts');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_missionpost') .' '. lang('labels_comment');
					
					$item = $this->posts->get_post_comment($data['id'], array('pcomment_post', 'pcomment_author_character'));
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_missionpost') .' '. lang('labels_comment') .' '.
							lang('labels_on'),
						$this->posts->get_post($item['pcomment_post'], 'post_title'),
						' '. lang('labels_by') .' '.
							$this->char->get_character_name($item['pcomment_author_character'], true)
					);
					
					$data['form'] = 'manage/comments/posts/activated/0/approve';
				}
			break;
				
			case 'logs_comment':
				$allowed = Auth::check_access('manage/comments', false);
				
				if ($allowed)
				{
					$this->load->model('personallogs_model', 'logs');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_personallog') .' '. lang('labels_comment');
					
					$item = $this->logs->get_log_comment($data['id'], array('lcomment_log', 'lcomment_author_character'));
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_personallog') .' '. lang('labels_comment') .' '.
							lang('labels_on'),
						$this->logs->get_log($item['lcomment_log'], 'log_title'),
						' '. lang('labels_by') .' '.
							$this->char->get_character_name($item['lcomment_author_character'], true)
					);
					
					$data['form'] = 'manage/comments/logs/activated/0/approve';
				}
			break;
				
			case 'news_comment':
				$allowed = Auth::check_access('manage/comments', false);
				
				if ($allowed)
				{
					$this->load->model('news_model', 'news');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_newsitem') .' '. lang('labels_comment');
					
					$item = $this->news->get_news_comment($data['id'], array('ncomment_news', 'ncomment_author_character'));
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						lang('global_newsitem') .' '. lang('labels_comment') .' '.
							lang('labels_on'),
						$this->news->get_news_item($item['ncomment_news'], 'news_title'),
						' '. lang('labels_by') .' '.
							$this->char->get_character_name($item['ncomment_author_character'], true)
					);
					
					$data['form'] = 'manage/comments/news/activated/0/approve';
				}
			break;
				
			case 'wiki_comment':
				$allowed = Auth::check_access('manage/comments', false);
				
				if ($allowed)
				{
					$this->load->model('wiki_model', 'wiki');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_wiki') .' '. lang('labels_comment');
					
					$item = $this->wiki->get_comment($data['id'], array('wcomment_page', 'wcomment_author_character'));
					
					$page = $this->wiki->get_page($item['wcomment_page']);
					
					if ($page->num_rows() > 0)
					{
						$row = $page->row();
					
						$data['text'] = sprintf(
							lang('fbx_content_approve_entry'),
							lang('global_wiki') .' '. lang('labels_comment') .' '. lang('labels_on'),
							$row->draft_title,
							' '. lang('labels_by') .' '.
								$this->char->get_character_name($item['wcomment_author_character'], true)
						);
					}
					
					$data['form'] = 'manage/comments/wiki/activated/0/approve';
				}
			break;
				
			case 'award_nomination':
				$allowed = Auth::check_access('user/nominate', false);
				$level = Auth::get_access_level('user/nominate');
				
				if ($allowed and $level == 2)
				{
					// load the resources
					$this->load->model('characters_model', 'char');
					$this->load->model('users_model', 'user');
					
					$type = lang('global_award') .' '. lang('labels_nomination');
					
					$nom = $this->sys->get_item('awards_queue', 'queue_id', $data['id']);
					$award = $this->sys->get_item('awards', 'award_id', $nom->queue_award);
					
					if ($award->award_cat == 'ooc')
					{
						$user = $this->user->get_user($nom->queue_receive_user);
						$name = (empty($user->name)) ? $user->email : $user->name;
					}
					else
					{
						$name = $this->char->get_character_name($nom->queue_receive_character, true);
					}
					
					$data['text'] = sprintf(
						lang('fbx_content_approve_entry'),
						$type .' '. lang('labels_for'),
						$name,
						''
					);
					
					$data['form'] = 'user/nominate/queue';
					
					// figure out where the view should come from
					$view = 'approve_awardnom';
				}
			break;
				
			case 'character':
				$allowed = Auth::check_access('characters/index', false);
				
				if ($allowed)
				{
					$this->load->model('characters_model', 'char');
					$this->load->model('users_model', 'user');
					$this->load->model('access_model', 'access');
					$this->load->model('messages_model', 'msgs');
					
					$type = lang('global_character');
					
					$item = $this->char->get_character($data['id']);
					$user = $this->user->get_user($item->user);
					$roles = $this->access->get_roles();
					
					$data['values'] = array(
						'position' => $item->position_1,
						'rank' => $item->rank,
						'email' => array(
							'name' => 'accept',
							'id' => 'accept',
							'class' => 'hud',
							'value' => $this->msgs->get_message('accept_message')),
						'user_status' => $user->status,
					);
					
					if ($roles->num_rows() > 0)
					{
						foreach ($roles->result() as $r)
						{
							$data['roles'][$r->role_id] = $r->role_name;
						}
					}
					
					$data['form'] = 'characters/index/pending';
					
					// figure out where the view should come from
					$view = 'approve_character';
				}
			break;
				
			case 'docking':
				$allowed = Auth::check_access('manage/docked', false);
				
				if ($allowed)
				{
					$this->load->model('docking_model', 'docking');
					$this->load->model('messages_model', 'msgs');
					
					$type = lang('actions_docking') .' '. lang('labels_request');
					
					$item = $this->docking->get_docked_item($data['id']);
					
					$data['text'] = sprintf(
						lang('text_docking_approve'),
						$item->docking_sim_name,
						lang('global_game_master')
					);
					
					$data['values'] = array(
						'email' => array(
							'name' => 'accept',
							'id' => 'accept',
							'class' => 'hud',
							'value' => $this->msgs->get_message('docking_accept_message')),
					);
					
					$data['form'] = 'manage/docked/pending';
					
					// figure out where the view should come from
					$view = 'approve_docking';
				}
			break;
		}
		
		$data['header'] = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_approve')),
			ucwords($type)
		);
		
		$data['label'] = array(
			'content' => ucfirst(lang('labels_content')),
			'author' => ucfirst(lang('labels_author')),
			'rank' => ucfirst(lang('global_rank')),
			'position' => ucfirst(lang('global_position')),
			'email' => ucfirst(lang('labels_email')),
			'role' => ucwords(lang('global_user') .' '. lang('labels_role'))
		);
		
		// input parameters
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		$this->_regions['content'] = Location::ajax($view, $skin, 'admin', $data);
		$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function change_password()
	{
		$allowed = Auth::is_logged_in();
		
		if ($allowed)
		{
			// data being sent to the facebox
			$data['header'] = ucwords(lang('actions_change') .' '. lang('labels_password'));
			$data['text'] = lang('fbx_change_password_text');
			$data['user'] = $this->uri->segment(3, 0);
			
			// input parameters
			$data['inputs'] = array(
				'password' => array(
					'name' => 'password',
					'id' => 'password',
					'class' => 'hud'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('change_password', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function character_activate($id)
	{
		$allowed = Auth::check_access('characters/bio', false);
		$level = Auth::get_access_level('characters/bio');
		
		if ($allowed and $level == 3)
		{
			// load the models
			$this->load->model('users_model', 'user');
			$this->load->model('characters_model', 'char');
			$this->load->model('ranks_model', 'rank');
			$this->load->model('positions_model', 'pos');
			$this->load->helper('utility');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_activate')),
				ucwords(lang('global_character'))
			);
			
			// get the character
			$char = $this->char->get_character($id);
			
			// get the user
			$user = $this->user->get_user($char->user);
			
			// get all active users (used for the user dropdown)
			$users = $this->user->get_users(null);
			
			if ($users->num_rows() > 0)
			{
				// doing this to make sure the active users are at the top of the list
				$data['users'][ucwords(lang('status_active').' '.lang('global_users'))] = array();
				
				foreach ($users->result() as $u)
				{
					if ($u->status != 'pending')
					{
						$type = ($u->status == 'active') 
							? ucwords(lang('status_active').' '.lang('global_users')) 
							: ucwords(lang('status_inactive').' '.lang('global_users'));
						
						$data['users'][$type][$u->userid] = $u->name.' ('.$u->email.')';
					}
				}
			}
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_character_activate'),
				parse_name(array($this->rank->get_rank($char->rank, 'rank_name'), $char->first_name, $char->last_name)),
				lang('global_character'),
				lang('global_user'),
				lang('global_character'),
				lang('global_character'),
				lang('global_character'),
				lang('global_character'),
				lang('global_user'),
				lang('fbx_content_character_selections')
			);
			$data['current_user'] = $char->user;
			$data['active_user'] = ($user->status != 'active') ? false : true;
			$data['maincharacter'] = ($user->main_char == $id);
			$data['label']['make_primary'] = ucwords(lang('actions_make').' '.lang('order_primary').' '.lang('global_character'));
			$data['label']['activate_user'] = ucwords(lang('actions_activate').' '.lang('global_user'));
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('character_activate', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function character_deactivate($id)
	{
		$allowed = Auth::check_access('characters/bio', false);
		$level = Auth::get_access_level('characters/bio');
		
		if ($allowed and $level == 3)
		{
			// load the models
			$this->load->model('users_model', 'user');
			$this->load->model('characters_model', 'char');
			$this->load->model('ranks_model', 'rank');
			$this->load->model('positions_model', 'pos');
			$this->load->helper('utility');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_deactivate')),
				ucwords(lang('global_character'))
			);
			
			// get the character
			$char = $this->char->get_character($id);
			
			// get the user
			$user = $this->user->get_user($char->user);
			
			$has_more_characters = true;
			
			if ($id == $user->main_char)
			{
				// get all active characters for the user
				$characters = $this->char->get_user_characters($char->user, 'active', 'array');
				
				if (count($characters) > 1)
				{
					foreach ($characters as $c)
					{
						if ($c != $id)
						{
							$data['characters'][$c] = $this->char->get_character_name($c, true);
						}
					}
				}
				
				$has_more_characters = (isset($data['characters']));
			}
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_character_deactivate'),
				parse_name(array($this->rank->get_rank($char->rank, 'rank_name'), $char->first_name, $char->last_name)),
				lang('global_character'),
				
				( ! $has_more_characters or isset($data['characters']))
					? "\r\n\r\n"
					: '',
				
				( ! $has_more_characters)
					? sprintf(lang('fbx_content_character_deactivate_userdeac'), lang('global_characters'), lang('global_user'), lang('global_user'))
					: '',
					
				(isset($data['characters']))
					? sprintf(
						lang('fbx_content_character_deactivate_newmainchar'), 
						lang('global_character'), 
						lang('global_character'), 
						lang('global_user'), 
						lang('global_character'), 
						lang('global_user'))
					: '',
					
				( ! $has_more_characters or isset($data['characters']))
					? lang('fbx_content_character_selections')
					: ''
			);
			$data['has_characters'] = $has_more_characters;
			$data['label']['deactivate_user'] = ucwords(lang('actions_deactivate').' '.lang('global_user'));
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('character_deactivate', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function character_npc($id)
	{
		$allowed = Auth::check_access('characters/bio', false);
		$level = Auth::get_access_level('characters/bio');
		
		if ($allowed and $level == 3)
		{
			// load the models
			$this->load->model('users_model', 'user');
			$this->load->model('characters_model', 'char');
			$this->load->model('ranks_model', 'rank');
			$this->load->model('positions_model', 'pos');
			$this->load->helper('utility');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_change')),
				ucfirst(lang('global_character')).' '.lang('labels_to').' '.strtoupper(lang('abbr_npc'))
			);
			
			// get the character
			$char = $this->char->get_character($id);
			
			// get the user
			$user = $this->user->get_user($char->user);
			
			$has_more_characters = true;
			
			if ($id == $user->main_char)
			{
				// get all active characters for the user
				$characters = $this->char->get_user_characters($char->user, 'active', 'array');
				
				foreach ($characters as $c)
				{
					if ($c != $id)
					{
						$data['characters'][$c] = $this->char->get_character_name($c, true);
					}
				}
				
				$has_more_characters = (isset($data['characters']));
			}
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_character_npc'),
				parse_name(array($this->rank->get_rank($char->rank, 'rank_name'), $char->first_name, $char->last_name)),
				lang('status_nonplaying'),
				lang('global_character'),
				
				(($char->user !== 0 and $char->user !== null) or ! $has_more_characters or ($id == $user->main_char and $has_more_characters))
					? "\r\n\r\n"
					: '',
				
				($char->user !== 0 and $char->user !== null)
					? sprintf(lang('fbx_content_character_npc_removeuser'), lang('global_user'), lang('global_character'))
					: '',
					
				( ! $has_more_characters)
					? sprintf(
						lang('fbx_content_character_npc_deacuser'), 
						lang('global_character'), 
						lang('global_character'), 
						lang('global_user'),
						lang('global_user'))
					: '',
					
				($id == $user->main_char and $has_more_characters)
					? sprintf(
						lang('fbx_content_character_npc_newmain'), 
						lang('global_character'), 
						lang('global_character'), 
						lang('global_user'),
						lang('global_character'))
					: '',
					
				(($char->user !== 0 and $char->user !== null) or ! $has_more_characters or ($id == $user->main_char and $has_more_characters))
					? lang('fbx_content_character_selections')
					: ''
			);
			$data['has_characters'] = $has_more_characters;
			$data['is_main_character'] = ($id == $user->main_char);
			$data['label']['deactivate_user'] = ucwords(lang('actions_deactivate').' '.lang('global_user'));
			$data['label']['remove_user'] = ucwords(lang('actions_remove').' '.lang('global_user').' '.lang('labels_association'));
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('character_npc', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function charcter_playing_character($id)
	{
		$allowed = Auth::check_access('characters/bio', false);
		$level = Auth::get_access_level('characters/bio');
		
		if ($allowed and $level == 3)
		{
			// load the models
			$this->load->model('users_model', 'user');
			$this->load->model('characters_model', 'char');
			$this->load->model('ranks_model', 'rank');
			$this->load->model('positions_model', 'pos');
			$this->load->helper('utility');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_change')),
				strtoupper(lang('abbr_npc')).' '.lang('labels_to').' '.ucfirst(lang('global_character'))
			);
			
			// get the character
			$char = $this->char->get_character($id);
			
			// get the user
			$user = $this->user->get_user($char->user);
			
			// get all the users in the system
			$users = $this->user->get_users(null);
			
			if ($users->num_rows() > 0)
			{
				$data['users'][0] = ucwords(lang('actions_remove').' '.lang('global_user').' '.lang('labels_association'));
				
				// make sure the active users are listed first
				$data['users'][ucwords(lang('status_active').' '.lang('global_users'))] = array();
				
				foreach ($users->result() as $u)
				{
					$type = ucwords($u->status.' '.lang('global_users'));
					
					if ($u->status != 'pending')
					{
						$data['users'][$type][$u->userid] = $u->name.' ('.$u->email.')';
					}
				}
			}
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_character_playing'),
				parse_name(array($this->rank->get_rank($char->rank, 'rank_name'), $char->first_name, $char->last_name)),
				lang('status_playing'),
				lang('global_character'),
				lang('global_user'),
				lang('global_character'),
				lang('global_user'),
				lang('global_character'),
				lang('global_character'),
				lang('global_user'),
				lang('fbx_content_character_selections')
			);
			$data['user'] = $char->user;
			$data['label']['main_character'] = ucwords(lang('actions_make').' '.lang('order_primary').' '.lang('global_character'));
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('character_playing', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_award()
	{
		$allowed = Auth::check_access('manage/awards', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('awards_model', 'awards');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_award'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->awards->get_award($data['id'], 'award_name');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_award'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_award', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_ban()
	{
		$allowed = Auth::check_access('site/bans', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_ban'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->sys->get_ban($data['id']);
			$descriptor = (empty($item->ban_email)) ? $item->ban_ip : $item->ban_email;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('labels_ban') .' '. lang('labels_on'),
				$descriptor
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_ban', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_bio_field()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_bio') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$field = $this->char->get_bio_field_details($data['id']);
			
			$item = ($field->num_rows() > 0) ? $field->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_bio_field'),
				$item->field_label_page
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_bio_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_bio_field_value()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', true) : 0;
			
			$delete = $this->char->delete_bio_field_value($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_deleted'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_bio_sec()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_bio') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$sec = $this->char->get_bio_section_details($data['id']);
			$sections = $this->char->get_bio_sections();
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_bio_sec'),
				$item->section_name
			);
			
			$data['values']['sections'][0] = ucwords(lang('labels_please') .' '.
				lang('actions_choose') .' '. lang('order_one'));
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $s)
				{
					if ($s->section_id == $data['id'])
					{
						// do nothing
					}
					else
					{
						$data['values']['sections'][$s->section_id] = $s->section_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_bio_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_bio_tab()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_bio') .' '. lang('labels_tab'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$tab = $this->char->get_bio_tab_details($data['id']);
			$tabs = $this->char->get_bio_tabs();
			
			$item = ($tab->num_rows() > 0) ? $tab->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_bio_tab'),
				$item->tab_name
			);
			
			$data['values']['tabs'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')
				.' '. lang('order_one'));
			
			if ($tabs->num_rows() > 0)
			{
				foreach ($tabs->result() as $t)
				{
					if ($t->tab_id == $data['id'])
					{
						// do nothing
					}
					else
					{
						$data['values']['tabs'][$t->tab_id] = $t->tab_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_bio_tab', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_catalogue()
	{
		$type = $this->uri->segment(3);
		$data['id'] = $this->uri->segment(4, 0, true);
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		
		// figure out the skin
		$current_skin = $this->session->userdata('skin_admin');
		
		switch ($type)
		{
			case 'ranks':
				$allowed = Auth::check_access('site/catalogueranks', false);
			
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'del_catalogue_ranks';
					
					$item = $this->ranks->get_rankcat($data['id'], 'rankcat_id');
					$ranks = $this->ranks->get_all_rank_sets();
					
					if ($ranks->num_rows() > 0)
					{
						foreach ($ranks->result() as $rank)
						{
							if ($rank->rankcat_id != $data['id'])
							{
								$data['ranks'][$rank->rankcat_location] = $rank->rankcat_name;
							}
						}
					}
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_delete')),
						ucwords(lang('global_rank') .' '. lang('labels_set'))
					);
					
					$data['text'] = sprintf(
						lang('fbx_content_del_catalogue_rank'),
						$item->rankcat_name
					);
					
					$data['inputs'] = array(
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
				}
			break;
				
			case 'skins':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'del_catalogue_skins';
					
					// get the skin info
					$item = $this->sys->get_skin_info($data['id'], 'skin_id');
					
					// get the skin sections (if they exist)
					$sections = $this->sys->get_skin_sections($item->skin_location, null);
					
					if ($sections->num_rows() > 0)
					{
						foreach ($sections->result() as $s)
						{
							if ($s->skinsec_section != 'login')
							{
								$data['sections'][$s->skinsec_section][$s->skinsec_skin] = $item->skin_name.' ('.ucfirst($s->skinsec_section).')';
								
								// get the skins for the section
								$skins = $this->sys->get_skins_by_section($s->skinsec_section);
								
								if ($skins !== false)
								{
									foreach ($skins as $skin)
									{
										$data['skins'][$s->skinsec_section][$skin->skin_location] = $skin->skin_name;
									}
								}
								
								$data['default'][$s->skinsec_section] = $this->sys->get_skinsec_default($s->skinsec_section);
							}
						}
					}
					
					// set the old skin for reference
					$data['old_skin'] = $item->skin_location;
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_delete')),
						ucwords(lang('labels_skin'))
					);
					
					$data['text'] = sprintf(
						lang('fbx_content_del_catalogue_skin'),
						$item->skin_name,
						($sections->num_rows() > 0) ? lang('fbx_content_del_catalogue_skin_wsections') : ''
					);
					
					$data['inputs'] = array(
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
				}
			break;
				
			case 'skinsecs':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'del_catalogue_skinsec';
					
					$item = $this->sys->get_skin_section_info($data['id'], 'skinsec_id');
					$skins = $this->sys->get_all_skins();
					
					$data['section'] = $item->skinsec_section;
					$data['old_skin'] = $item->skinsec_skin;
					
					if ($skins->num_rows() > 0)
					{
						foreach ($skins->result() as $skin)
						{
							if ($skin->skin_id != $item->skinsec_skin)
							{
								$data['skins'][$skin->skin_location] = $skin->skin_name;
							}
						}
					}
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_delete')),
						ucwords(lang('labels_skin') .' '. lang('labels_section'))
					);
					
					$data['text'] = sprintf(
						lang('fbx_content_del_catalogue_skinsec'),
						$this->sys->get_skin_name($item->skinsec_skin),
						$item->skinsec_section
					);
					
					$data['inputs'] = array(
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
				}
			break;
		}
		
		// data being sent to the facebox
		$data['header'] = $head;
		
		$this->_regions['content'] = Location::ajax($view, $current_skin, 'admin', $data);
		$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function del_character()
	{
		$allowed = Auth::check_access('characters/index', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			$this->load->helper('utility');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_character'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->char->get_character($data['id']);
			
			$name = array(
				$item->first_name,
				$item->middle_name,
				$item->last_name,
				$item->suffix
			);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_character'),
				lang('global_character'),
				parse_name($name),
				lang('global_character'),
				lang('global_character'),
				lang('global_character'),
				lang('global_character'),
				lang('global_characters')
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_character', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_character_award()
	{
		$allowed = Auth::check_access('characters/awards', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('awards_model', 'awards');
			
			$id = $this->input->post('award', true);
			
			$delete = $this->awards->delete_received_award($id);
			
			echo '';
		}
	}
	
	public function del_character_image()
	{
		$allowed = Auth::check_access('characters/bio', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			$images = $this->char->get_character($id, 'images');
			
			if ( ! empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key !== false)
				{
					unset($imagesArray[$key]);
					$imageStr = implode(',', $imagesArray);
					
					$this->char->update_character($id, array('images' => $imageStr));
				}
			}
		}
	}
	
	public function del_coc()
	{
		$allowed = Auth::check_access('characters/coc', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$id = (is_numeric($this->input->post('coc'))) ? $this->input->post('coc', true) : 0;
			
			$delete = $this->char->delete_coc_entry($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_character')),
					lang('actions_removed'),
					''
				);
	
				$flash['status'] = 'success';
				$flash['message'] = text_output($message);
			}
			else
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('global_character')),
					lang('actions_removed'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_comment()
	{
		$allowed = Auth::check_access('manage/comments', false);
		
		if ($allowed)
		{
			$data['type'] = $this->uri->segment(3, false);
			$data['status'] = $this->uri->segment(4, false);
			$data['page'] = $this->uri->segment(5, 0, true);
			$data['id'] = $this->uri->segment(6, 0, true);
			
			switch ($data['type'])
			{
				case 'posts':
					$this->load->model('posts_model', 'posts');
					
					$type = lang('global_missionpost');
					
					$item = $this->posts->get_post($this->posts->get_post_comment($data['id'], 'pcomment_post'), 'post_title');
				break;
					
				case 'logs':
					$this->load->model('personallogs_model', 'logs');
					
					$type = lang('global_personallog');
					
					$item = $this->logs->get_log($this->logs->get_log_comment($data['id'], 'lcomment_log'), 'log_title');
				break;
					
				case 'news':
					$this->load->model('news_model', 'news');
					
					$type = lang('global_newsitem');
					
					$item = $this->news->get_news_item($this->news->get_news_comment($data['id'], 'ncomment_news'), 'news_title');
				break;
					
				case 'wiki':
					$this->load->model('wiki_model', 'wiki');
					
					$type = lang('global_wiki');
					
					$pageid = $this->wiki->get_comment($data['id'], 'wcomment_page');
					
					$page = $this->wiki->get_page($pageid);
					
					if ($page->num_rows() > 0)
					{
						$row = $page->row();
						
						$item = $row->draft_title;
					}
					else
					{
						$item = false;
					}
				break;
			}
			
			$data['header'] = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords($type .' '. lang('labels_comment'))
			);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('labels_comment') .' '. lang('labels_for'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_comment', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_deck()
	{
		$allowed = Auth::check_access('manage/decks', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$id = (is_numeric($this->input->post('deck'))) ? $this->input->post('deck', true) : 0;
			
			$delete = $this->tour->delete_deck($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_deck')),
					lang('actions_removed'),
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
					lang('actions_removed'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_dept()
	{
		$allowed = Auth::check_access('manage/depts', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_department'))
			);
			
			// set the id
			$data['id'] = $this->uri->segment(3, 0, true);
			
			// grab the departments
			$depts = $this->dept->get_all_depts();
			
			// grab the department details
			$subs = $this->dept->get_sub_depts($data['id'], 'asc', '');
			
			$data['dept_count'] = $depts->num_rows();
			$data['sub_count'] = $subs->num_rows();
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = sprintf(
				lang('fbx_content_del_dept'),
				$this->dept->get_dept($data['id'], 'dept_name'),
				lang('global_department'),
				lang('global_department'),
				lang('global_positions'),
				lang('global_department'),
				lang('global_positions'),
				lang('global_department')
			);
			$data['reassign_text'] = sprintf(
				lang('text_manage_dept_reassign'),
				lang('global_subdepartments')
			);
			
			// input parameters
			$data['inputs'] = array(
				'delete' => array(
					'name' => 'delete',
					'id' => 'delete_y',
					'value' => 'y'),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			if ($depts->num_rows() <= 1)
			{
				$data['inputs']['delete']['disabled'] = 'disabled';
			}
			
			$data['label'] = array(
				'dept' => ucfirst(lang('global_department')),
				'delete' => ucwords(lang('actions_delete') .' '. lang('global_department') .' '.
					lang('global_positions') .'?'),
				'reassign' => ucfirst(lang('actions_reassign')) .' '. lang('labels_to') .' '.
					ucfirst(lang('global_department')) .':',
				'reassign_sub' => ucwords(lang('actions_reassign') .' '. 
					lang('global_subdepartments')) .' '. lang('labels_to') .':',
				'positions' => ucfirst(lang('global_positions')),
				'subdepts' => ucwords(lang('global_subdepartments')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_dept', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_docked_item()
	{
		$allowed = Auth::check_access('manage/docked', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('actions_docked') .' '. lang('labels_item'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->docking->get_docked_item($data['id']);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('actions_docked') .' '. lang('labels_item'),
				$item->docking_sim_name
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_docked_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_docking_field()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('actions_docking') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$field = $this->docking->get_docking_field_details($data['id']);
			
			$item = ($field->num_rows() > 0) ? $field->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_docking_field'),
				$item->field_label_page
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_docking_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_docking_field_value()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', true) : 0;
			
			$delete = $this->docking->delete_docking_field_value($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_deleted'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_docking_sec()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('actions_docking') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$sec = $this->docking->get_docking_section_details($data['id']);
			$sections = $this->docking->get_docking_sections();
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_docking_sec'),
				$item->section_name
			);
			
			$data['values']['sections'][0] = ucwords(lang('labels_please') .' '.
				lang('actions_choose') .' '. lang('order_one'));
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $s)
				{
					if ($s->section_id == $data['id'])
					{
						// do nothing
					}
					else
					{
						$data['values']['sections'][$s->section_id] = $s->section_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_docking_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_log()
	{
		$allowed = Auth::check_access('manage/logs', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('personallogs_model', 'logs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_personallog'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['status'] = $this->uri->segment(3, 'activated');
			$data['page'] = $this->uri->segment(4, 0, true);
			$data['id'] = $this->uri->segment(5, 0, true);
			
			$item = $this->logs->get_log($data['id'], 'log_title');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_personallog'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_log', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_manifest()
	{
		$allowed = Auth::check_access('site/manifests', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_manifest'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->dept->get_manifest($data['id'], 'manifest_name');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('labels_manifest'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_manifest', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_menu_cat()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_menu') .' '. lang('labels_category'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$cat = $this->menu_model->get_menu_category($data['id'], 'menucat_id');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_menucat'),
				$cat->menucat_name
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_menu_cat', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_menu_item()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_menu'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			$data['tab'] = $this->uri->segment(4, 0, true);
			
			$menu = $this->menu_model->get_menu_item($data['id']);
			
			$item = ($menu->num_rows() > 0) ? $menu->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_menu'),
				$item->menu_name
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_menu_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_mission()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_mission'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->mis->get_mission($data['id'], array('mission_title', 'mission_status'));
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_mission'),
				$item['mission_title']
			);
			
			$data['form'] = $item['mission_status'];
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_mission', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_mission_image()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			$images = $this->mis->get_mission($id, 'mission_images');
			
			if ( ! empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key !== false)
				{
					unset($imagesArray[$key]);
					$imageStr = implode(',', $imagesArray);
					
					$this->mis->update_mission($id, array('mission_images' => $imageStr));
				}
			}
		}
	}
	
	public function del_mission_group()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_missiongroup'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->mis->get_mission_group($data['id'], array('misgroup_name'));
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_missiongroup'),
				$item['misgroup_name']
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_mission_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_news()
	{
		$allowed = Auth::check_access('manage/news', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('news_model', 'news');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_newsitem'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['status'] = $this->uri->segment(3, 'activated');
			$data['page'] = $this->uri->segment(4, 0, true);
			$data['id'] = $this->uri->segment(5, 0, true);
			
			$item = $this->news->get_news_item($data['id'], 'news_title');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_newsitem'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_news', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_npc()
	{
		$allowed = Auth::check_access('characters/npcs', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			$this->load->helper('utility');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('abbr_npc'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->char->get_character($data['id']);
			
			$name = array(
				$item->first_name,
				$item->middle_name,
				$item->last_name,
				$item->suffix
			);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('abbr_npc'),
				parse_name($name)
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_npc', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_post()
	{
		$allowed = Auth::check_access('manage/posts', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('posts_model', 'posts');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_missionpost'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['status'] = $this->uri->segment(3, 'activated');
			$data['page'] = $this->uri->segment(4, 0, true);
			$data['id'] = $this->uri->segment(5, 0, true);
			$data['refer'] = $this->uri->segment(6, 'posts');
			
			$item = $this->posts->get_post($data['id'], 'post_title');
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_missionpost'),
				$item
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_post', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_role()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_role'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->access->get_role($data['id']);
			$roles = $this->access->get_roles();
			
			$data['text'] = sprintf(
				lang('fbx_content_del_role'),
				$item->role_name
			);
			
			if ($roles->num_rows() > 0)
			{
				foreach ($roles->result() as $r)
				{
					if ($r->role_id == $data['id'])
					{
						// do nothing
					}
					else
					{
						$data['values']['roles'][$r->role_id] = $r->role_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_role', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_role_group()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			$data['text'] = sprintf(
				lang('fbx_content_del_role_group'),
				$this->access->get_group($data['id'], 'group_name')
			);
			
			$groups = $this->access->get_page_groups();
			
			$data['groups'][0] = ucwords(lang('labels_none'));
			
			if ($groups->num_rows() > 0)
			{
				foreach ($groups->result() as $group)
				{
					if ($group->group_id != $data['id'])
					{
						$data['groups'][$group->group_id] = $group->group_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_role_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_role_page()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_role') .' '. lang('labels_page'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['text'] = sprintf(
				lang('fbx_content_del_role_page'),
				$this->access->get_page($data['id'], 'page_name')
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_role_page', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_site_message()
	{
		$allowed = Auth::check_access('site/messages', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_site') .' '. lang('labels_message'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['text'] = sprintf(
				lang('fbx_content_del_site_message'),
				$this->msgs->get_message_label($data['id'])
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_site_message', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_spec_field()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_specifications') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$field = $this->specs->get_spec_field_details($data['id']);
			
			$item = ($field->num_rows() > 0) ? $field->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_specs_field'),
				$item->field_label_page
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_spec_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_spec_field_value()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', true) : 0;
			
			$delete = $this->specs->delete_spec_field_value($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_specification') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('global_specification') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_deleted'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_spec_image()
	{
		$allowed = Auth::check_access('manage/specs', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			$item = $this->specs->get_spec_item($id);
			
			if ($item !== false)
			{
				$images = $item->specs_images;
				
				if ( ! empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key !== false)
					{
						unset($imagesArray[$key]);
						$imageStr = implode(',', $imagesArray);
						
						$this->specs->update_spec_item($id, array('specs_images' => $imageStr));
					}
				}
			}
		}
	}
	
	public function del_spec_item()
	{
		$allowed = Auth::check_access('manage/specs', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_specification') .' '. lang('labels_item'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->specs->get_spec_item($data['id']);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_specification') .' '. lang('labels_item'),
				$item->specs_name
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_spec_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_spec_sec()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_specifications') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$sec = $this->specs->get_spec_section_details($data['id']);
			$sections = $this->specs->get_spec_sections();
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_specs_sec'),
				$item->section_name
			);
			
			$data['values']['sections'][0] = ucwords(lang('labels_please') .' '.
				lang('actions_choose') .' '. lang('order_one'));
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $s)
				{
					if ($s->section_id == $data['id'])
					{
						// do nothing
					}
					else
					{
						$data['values']['sections'][$s->section_id] = $s->section_name;
					}
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_spec_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_tour_field()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_tour') .' '. lang('labels_field'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$field = $this->tour->get_tour_field_details($data['id']);
			
			$item = ($field->num_rows() > 0) ? $field->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_tour_field'),
				$item->field_label_page
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_tour_field', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_tour_field_value()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', true) : 0;
			
			$delete = $this->tour->delete_tour_value($id);
			
			if ($delete > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_deleted'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function del_tour_image()
	{
		$allowed = Auth::check_access('manage/tour', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			$tour = $this->tour->get_tour_item($id);
			
			if ($tour->num_rows() > 0)
			{
				$item = $tour->row();
				
				$images = $item->tour_images;
				
				if ( ! empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key !== false)
					{
						unset($imagesArray[$key]);
						$imageStr = implode(',', $imagesArray);
						
						$this->tour->update_tour_item($id, array('tour_images' => $imageStr));
					}
				}
			}
		}
	}
	
	public function del_tour_item()
	{
		$allowed = Auth::check_access('manage/tour', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_touritem'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$field = $this->tour->get_tour_item($data['id']);
			
			$item = ($field->num_rows() > 0) ? $field->row() : false;
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_touritem'),
				$item->tour_name
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_tour_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_user()
	{
		$allowed = Auth::check_access('user/account', false);
		$level = Auth::get_access_level('user/account');
		
		if ($allowed and $level == 2)
		{
			// load the resources
			$this->load->model('users_model', 'user');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_user'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->user->get_user($data['id']);
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_user'),
				( ! empty($item->name)) ? $item->name : $item->email
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_user', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_user_setting()
	{
		$allowed = Auth::check_access('site/settings', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('labels_site') .' '. lang('labels_setting'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['text'] = sprintf(
				lang('fbx_content_del_user_setting'),
				$this->settings->get_setting_label($data['id'], 'setting_id')
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('del_user_setting', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_wiki_category()
	{
		$allowed = Auth::check_access('wiki/categories', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_wiki') .' '. lang('labels_category'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_wiki') .' '. lang('labels_category'),
				$this->wiki->get_category($data['id'], 'wikicat_name')
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('del_wiki_category', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_wiki_draft()
	{
		$allowed = Auth::check_access('wiki/page', false);
		$level = Auth::get_access_level('wiki/page');
		
		if ($allowed and $level == 3)
		{
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_wiki') .' '. lang('labels_draft'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			// grab the draft we're deleting
			$draft = $this->wiki->get_draft($data['id']);
			
			// get the draft object
			$d = ($draft->num_rows() > 0) ? $draft->row() : false;
			
			// get the title
			$title = ($d !== false) ? $d->draft_title : '';
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_wiki') .' '. lang('labels_draft'),
				$title
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('del_wiki_draft', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function del_wiki_page()
	{
		$allowed = Auth::check_access('wiki/page', false);
		$level = Auth::get_access_level('wiki/page');
		
		if ($allowed and $level == 3)
		{
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_delete')),
				ucwords(lang('global_wiki') .' '. lang('labels_page'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$page = $this->wiki->get_page($data['id']);
			
			if ($page->num_rows() > 0)
			{
				foreach ($page->result() as $p)
				{
					$title = $p->draft_title;
				}
			}
			else
			{
				$title = '';
			}
			
			$data['text'] = sprintf(
				lang('fbx_content_del_entry'),
				lang('global_wiki') .' '. lang('labels_page'),
				$title
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('del_wiki_page', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function duplicate_dept()
	{
		$allowed = Auth::check_access('manage/depts', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_duplicate')),
				ucwords(lang('global_department'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = sprintf(
				lang('text_duplicate_dept'),
				$this->dept->get_dept($data['id'], 'dept_name'),
				lang('global_department'),
				lang('global_department'),
				lang('global_positions'),
				ucwords(lang('actions_submit'))
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('dup_dept', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function duplicate_role()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_duplicate')),
				ucwords(lang('labels_role'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'name',
					'class' => 'hud'),
				'desc' => array(
					'name' => 'desc',
					'class' => 'hud',
					'rows' => 3),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$roles = $this->access->get_roles();
			
			if ($roles->num_rows() > 0)
			{
				foreach ($roles->result() as $r)
				{
					$data['roles'][$r->role_id] = $r->role_name;
				}
			}
			
			$data['label'] = array(
				'desc' => ucfirst(lang('labels_desc')),
				'name' => ucfirst(lang('labels_name')),
				'role' => ucfirst(lang('labels_role'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('dup_role', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_bio_field_value()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['field'] = (is_numeric($this->uri->segment(4))) ? $this->uri->segment(4) : 0;
			
			$value = $this->char->get_bio_field_value_details($data['id']);
			$fields = $this->char->get_bio_fields('', 'select');
			
			if ($fields->num_rows() > 0)
			{
				foreach ($fields->result() as $field)
				{
					$data['values']['fields'][$field->field_id] = $field->field_label_page;
				}
			}
			
			$item = ($value->num_rows() > 0) ? $value->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'value' => array(
					'name' => 'value_field_value',
					'class' => 'hud',
					'value' => $item->value_field_value),
				'content' => array(
					'name' => 'value_content',
					'class' => 'hud',
					'value' => $item->value_content),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'dropdown' => lang('text_dropdown_value'),
				'field' => ucfirst(lang('labels_field')),
				'insert' => lang('text_db_insert'),
				'value' => ucfirst(lang('labels_value')),
			);
			
			$data['selected_field'] = $item->value_field;
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_bio_field_value', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_bio_sec()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_bio') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$tabs = $this->char->get_bio_tabs();
			$sec = $this->char->get_bio_section_details($data['id']);
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			$data['values']['tabs'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')
				.' '. lang('order_one'));
			
			if ($tabs->num_rows() > 0)
			{
				foreach ($tabs->result() as $t)
				{
					$data['values']['tabs'][$t->tab_id] = $t->tab_name;
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud',
					'value' => $item->section_name),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small',
					'value' => $item->section_order),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['tab'] = $item->section_tab;
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
				'tab' => ucfirst(lang('labels_tab')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_bio_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_bio_tab()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_bio') .' '. lang('labels_tab'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$tab = $this->char->get_bio_tab_details($data['id']);
			
			$item = ($tab->num_rows() > 0) ? $tab->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'tab_name',
					'class' => 'hud',
					'value' => $item->tab_name),
				'link' => array(
					'name' => 'tab_link_id',
					'class' => 'hud medium',
					'value' => $item->tab_link_id),
				'order' => array(
					'name' => 'tab_order',
					'class' => 'hud small',
					'value' => $item->tab_order),
				'display_y' => array(
					'name' => 'tab_display',
					'id' => 'tab_display_y',
					'value' => 'y',
					'checked' => ($item->tab_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'tab_display',
					'id' => 'tab_display_n',
					'value' => 'n',
					'checked' => ($item->tab_display == 'n') ? true : false),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'display' => ucfirst(lang('labels_display')),
				'link' => ucfirst(lang('labels_link') .' '. lang('abbr_id')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'order' => ucfirst(lang('labels_order')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_bio_tab', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_catalogue()
	{
		$type = $this->uri->segment(3);
		$data['id'] = $this->uri->segment(4, 0, true);
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		
		// figure out the skin
		$current_skin = $this->session->userdata('skin_admin');
		
		switch ($type)
		{
			case 'ranks':
				$allowed = Auth::check_access('site/catalogueranks', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'edit_catalogue_ranks';
					
					$item = $this->ranks->get_rankcat($data['id'], 'rankcat_id');
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_edit')),
						ucwords(lang('global_rank') .' '. lang('labels_set'))
					);
					
					$data['inputs'] = array(
						'name' => array(
							'name' => 'rank_name',
							'class' => 'hud',
							'value' => $item->rankcat_name),
						'location' => array(
							'name' => 'rank_location',
							'class' => 'hud',
							'value' => $item->rankcat_location),
						'preview' => array(
							'name' => 'rank_preview',
							'class' => 'hud',
							'value' => $item->rankcat_preview),
						'blank' => array(
							'name' => 'rank_blank',
							'class' => 'hud',
							'value' => $item->rankcat_blank),
						'extension' => array(
							'name' => 'rank_extension',
							'class' => 'hud',
							'value' => $item->rankcat_extension),
						'genre' => array(
							'name' => 'rank_genre',
							'class' => 'hud',
							'value' => $item->rankcat_genre),
						'credits' => array(
							'name' => 'rank_credits',
							'class' => 'hud',
							'rows' => 4,
							'value' => $item->rankcat_credits),
						'default_y' => array(
							'name' => 'rank_default',
							'id' => 'rank_default_y',
							'value' => 'y',
							'checked' => ($item->rankcat_default == 'y') ? true : false),
						'default_n' => array(
							'name' => 'rank_default',
							'id' => 'rank_default_n',
							'value' => 'n',
							'checked' => ($item->rankcat_default == 'n') ? true : false),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
					
					$data['values']['status'] = array(
						'active' => ucfirst(lang('status_active')),
						'inactive' => ucfirst(lang('status_inactive')),
						'development' => lang('misc_development')
					);
					
					$data['default']['status'] = $item->rankcat_status;
				}
			break;
				
			case 'skins':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'edit_catalogue_skins';
					
					$item = $this->sys->get_skin_info($data['id'], 'skin_id');
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_edit')),
						ucwords(lang('labels_skin'))
					);
					
					$data['inputs'] = array(
						'name' => array(
							'name' => 'skin_name',
							'class' => 'hud',
							'value' => $item->skin_name),
						'location' => array(
							'name' => 'skin_location',
							'class' => 'hud',
							'value' => $item->skin_location),
						'credits' => array(
							'name' => 'skin_credits',
							'class' => 'hud',
							'rows' => 4,
							'value' => $item->skin_credits),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
				}
			break;
				
			case 'skinsecs':
				$allowed = Auth::check_access('site/catalogueskins', false);
				
				if ($allowed)
				{
					// figure out where the view should come from
					$view = 'edit_catalogue_skinsec';
					
					$item = $this->sys->get_skin_section_info($data['id'], 'skinsec_id');
					
					$head = sprintf(
						lang('fbx_head'),
						ucwords(lang('actions_edit')),
						ucwords(lang('labels_skin') .' '. lang('labels_section'))
					);
					
					$data['inputs'] = array(
						'preview' => array(
							'name' => 'preview',
							'class' => 'hud',
							'value' => $item->skinsec_image_preview),
						'default_y' => array(
							'name' => 'default',
							'id' => 'skin_default_y',
							'value' => 'y',
							'checked' => ($item->skinsec_default == 'y') ? true : false),
						'default_n' => array(
							'name' => 'default',
							'id' => 'skin_default_n',
							'value' => 'n',
							'checked' => ($item->skinsec_default == 'n') ? true : false),
						'submit' => array(
							'type' => 'submit',
							'class' => 'hud_button',
							'name' => 'submit',
							'value' => 'submit',
							'content' => ucwords(lang('actions_submit')))
					);
					
					$data['values']['section'] = array(
						'' => ucwords(lang('labels_please') .' '. lang('actions_choose')
							.' '. lang('order_one')),
						'main' => ucfirst(lang('labels_main')),
						'admin' => ucfirst(lang('labels_admin')),
						'wiki' => ucfirst(lang('global_wiki')),
						'login' => ucfirst(lang('labels_login')),
					);
					
					$data['values']['status'] = array(
						'active' => ucfirst(lang('status_active')),
						'inactive' => ucfirst(lang('status_inactive')),
						'development' => lang('misc_development')
					);
					
					$skins = $this->sys->get_all_skins();
					
					if ($skins->num_rows() > 0)
					{
						$data['skins'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')
							.' '. lang('order_one'));
						
						foreach ($skins->result() as $skin)
						{
							$data['skins'][$skin->skin_location] = $skin->skin_name;
						}
					}
					
					$data['default']['status'] = $item->skinsec_status;
					$data['default']['section'] = $item->skinsec_section;
					$data['default']['skin'] = $item->skinsec_skin;
				}
			break;
			
			default:
				$header = '';
				$view = '';
			break;
		}
		
		// data being sent to the facebox
		$data['header'] = $head;
		
		$data['label'] = array(
			'blank' => ucwords(lang('labels_blank') .' '. lang('labels_image')),
			'credits' => ucfirst(lang('labels_credits')),
			'default_rank' => ucwords(lang('labels_default') .' '. lang('global_rank') .' '. lang('labels_set')),
			'default_theme' => ucwords(lang('labels_default') .' '. lang('labels_section')),
			'display' => ucfirst(lang('labels_display')),
			'extension' => ucwords(lang('labels_image') .' '. lang('labels_extension')),
			'genre' => ucfirst(lang('labels_genre')),
			'location' => lang('misc_server_dir'),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'order' => ucfirst(lang('labels_order')),
			'preview' => ucwords(lang('labels_preview') .' '. lang('labels_image')),
			'section' => ucfirst(lang('labels_section')),
			'skin' => ucfirst(lang('labels_skin')),
			'status' => ucfirst(lang('labels_status')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		$this->_regions['content'] = Location::ajax($view, $current_skin, 'admin', $data);
		$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function edit_comment()
	{
		$allowed = Auth::check_access('manage/comments', false);
		
		if ($allowed)
		{
			$data['type'] = $this->uri->segment(3, false);
			$data['status'] = $this->uri->segment(4, false);
			$data['page'] = $this->uri->segment(5, 0, true);
			$data['id'] = $this->uri->segment(6, 0, true);
			
			switch ($data['type'])
			{
				case 'posts':
					$this->load->model('posts_model', 'posts');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_missionpost');
					
					$item = $this->posts->get_post_comment($data['id'], array('pcomment_content', 'pcomment_author_character'));
					
					$data['inputs'] = array(
						'content' => array(
							'name' => 'pcomment_content',
							'class' => 'hud',
							'rows' => 10,
							'value' => $item['pcomment_content']),
						'author' => $this->char->get_character_name($item['pcomment_author_character'], true)
					);
				break;
					
				case 'logs':
					$this->load->model('personallogs_model', 'logs');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_personallog');
					
					$item = $this->logs->get_log_comment($data['id'], array('lcomment_content', 'lcomment_author_character'));
					
					$data['inputs'] = array(
						'content' => array(
							'name' => 'lcomment_content',
							'class' => 'hud',
							'rows' => 10,
							'value' => $item['lcomment_content']),
						'author' => $this->char->get_character_name($item['lcomment_author_character'], true)
					);
				break;
					
				case 'news':
					$this->load->model('news_model', 'news');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_newsitem');
					
					$item = $this->news->get_news_comment($data['id'], array('ncomment_content', 'ncomment_author_character'));
					
					$data['inputs'] = array(
						'content' => array(
							'name' => 'ncomment_content',
							'class' => 'hud',
							'rows' => 10,
							'value' => $item['ncomment_content']),
						'author' => $this->char->get_character_name($item['ncomment_author_character'], true)
					);
				break;
					
				case 'wiki':
					$this->load->model('wiki_model', 'wiki');
					$this->load->model('characters_model', 'char');
					
					$type = lang('global_wiki');
					
					$item = $this->wiki->get_comment($data['id'], array('wcomment_content', 'wcomment_author_character'));
					
					$data['inputs'] = array(
						'content' => array(
							'name' => 'wcomment_content',
							'class' => 'hud',
							'rows' => 10,
							'value' => $item['wcomment_content']),
						'author' => $this->char->get_character_name($item['wcomment_author_character'], true)
					);
				break;
			}
			
			$data['header'] = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords($type .' '. lang('labels_comment'))
			);
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'author' => ucfirst(lang('labels_author')),
			);
			
			// input parameters
			$data['inputs'] += array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_comment', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_deck()
	{
		$allowed = Auth::check_access('manage/decks', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_deck'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$item = $this->tour->get_deck_details($data['id']);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'deck_name',
					'class' => 'hud',
					'value' => $item->deck_name),
				'item' => $item->deck_item,
				'content' => array(
					'name' => 'deck_content',
					'class' => 'hud',
					'value' => $item->deck_content),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
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
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'name' => ucfirst(lang('labels_name')),
				'item' => ucwords(lang('global_specification').' '.lang('labels_item')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_deck', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_dept()
	{
		$allowed = Auth::check_access('manage/depts', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_department'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			// get the department information
			$dept = $this->dept->get_dept($data['id']);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'dept_name',
					'class' => 'hud',
					'value' => $dept->dept_name),
				'order' => array(
					'name' => 'dept_order',
					'class' => 'hud small',
					'value' => $dept->dept_order),
				'desc' => array(
					'name' => 'dept_desc',
					'class' => 'hud',
					'rows' => 6,
					'value' => $dept->dept_desc),
				'display_y' => array(
					'name' => 'dept_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => ($dept->dept_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'dept_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => ($dept->dept_display == 'n') ? true : false),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$depts = $this->dept->get_all_depts('asc', '');
			
			$data['values']['depts'][0] = ucfirst(lang('labels_none'));
			$data['values']['manifest'][0] = ucfirst(lang('labels_none'));
			
			if ($depts->num_rows() > 0)
			{
				foreach ($depts->result() as $d)
				{
					$data['values']['depts'][$d->dept_id] = $d->dept_name;
				}
			}
			
			$manifests = $this->dept->get_all_manifests(null);
			
			if ($manifests->num_rows() > 0)
			{
				foreach ($manifests->result() as $m)
				{
					$data['values']['manifest'][$m->manifest_id] = $m->manifest_name;
				}
			}
			
			$data['values']['type'] = array(
				'playing' => ucfirst(lang('status_playing')),
				'nonplaying' => ucfirst(lang('status_nonplaying'))
			);
			
			// set the defaults
			$data['default']['type'] = $dept->dept_type;
			$data['default']['parent'] = $dept->dept_parent;
			$data['default']['manifest'] = $dept->dept_manifest;
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'type' => ucfirst(lang('labels_type')),
				'desc' => ucfirst(lang('labels_desc')),
				'display' => ucfirst(lang('labels_display')),
				'on' => ucfirst(lang('labels_on')),
				'off' => ucfirst(lang('labels_off')),
				'order' => ucfirst(lang('labels_order')),
				'parent' => ucwords(lang('labels_parent') .' '. lang('global_department')),
				'manifest' => ucfirst(lang('labels_manifest')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_dept', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_docking_field_value()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['field'] = (is_numeric($this->uri->segment(4))) ? $this->uri->segment(4) : 0;
			
			$value = $this->docking->get_docking_value_details($data['id']);
			$fields = $this->docking->get_docking_fields('', 'select');
			
			if ($fields->num_rows() > 0)
			{
				foreach ($fields->result() as $field)
				{
					$data['values']['fields'][$field->field_id] = $field->field_label_page;
				}
			}
			
			$item = ($value->num_rows() > 0) ? $value->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'value' => array(
					'name' => 'value_field_value',
					'class' => 'hud',
					'value' => $item->value_field_value),
				'content' => array(
					'name' => 'value_content',
					'class' => 'hud',
					'value' => $item->value_content),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['selected_field'] = $item->value_field;
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'dropdown' => lang('text_dropdown_value'),
				'field' => ucfirst(lang('labels_field')),
				'insert' => lang('text_db_insert'),
				'value' => ucfirst(lang('labels_value')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_docking_field_value', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_docking_sec()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('actions_docking') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$sec = $this->docking->get_docking_section_details($data['id']);
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud',
					'value' => $item->section_name),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small',
					'value' => $item->section_order),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_docking_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_manifest()
	{
		$allowed = Auth::check_access('site/manifests', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_site').' '.lang('labels_manifest'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			// get the manifest data
			$item = $this->dept->get_manifest($data['id']);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'manifest_name',
					'class' => 'hud',
					'value' => $item->manifest_name),
				'desc' => array(
					'name' => 'manifest_desc',
					'class' => 'hud',
					'value' => $item->manifest_desc,
					'rows' => 3),
				'header' => array(
					'name' => 'manifest_header_content',
					'class' => 'hud',
					'value' => $item->manifest_header_content,
					'rows' => 10),
				'order' => array(
					'name' => 'manifest_order',
					'class' => 'hud small',
					'value' => $item->manifest_order),
				'display_y' => array(
					'name' => 'manifest_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => ($item->manifest_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'manifest_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => ($item->manifest_display == 'n') ? true : false),
				'default_y' => array(
					'name' => 'manifest_default',
					'id' => 'default_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => ($item->manifest_default == 'y') ? true : false),
				'default_n' => array(
					'name' => 'manifest_default',
					'id' => 'default_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => ($item->manifest_default == 'n') ? true : false),
				'view' => $item->manifest_view,
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
			);
			
			$data['values']['manifest'] = array(
				"" => ucfirst(lang('labels_none')),
				"$('tr.active').show();" => ucwords(lang('status_active') .' '. lang('global_characters') .' '. 
					lang('labels_only')),
				"$('tr.npc').show();" => ucwords(lang('abbr_npcs') .' '. lang('labels_only')),
				"$('tr.open').show();" => ucwords(lang('status_open') .' '. lang('global_positions') .' '. 
					lang('labels_only')),
				"$('tr.past').show();" => ucwords(lang('status_inactive') .' '. lang('global_characters') .' '. 
					lang('labels_only')),
				"$('tr.active').show();,$('tr.npc').show();" => ucwords(lang('status_active') .' '. 					lang('global_characters') .' &amp; '. lang('abbr_npcs')),
				"$('tr.active').show();,$('tr.npc').show();,$('tr.open').show();" => ucwords(lang('status_active') .' '. 
					lang('global_characters') .', '. lang('abbr_npcs') .' &amp; '. lang('status_open') .' '.
					lang('global_positions')),
				"$('tr.npc').show();,$('tr.open').show();" => ucwords(lang('abbr_npcs') .' &amp; '. lang('status_open') .' '.
					lang('global_positions')),
			);
			
			$data['label'] = array(
				'default' => ucwords(lang('labels_default').' '.lang('labels_manifest')),
				'desc' => ucfirst(lang('labels_desc')),
				'display' => ucfirst(lang('labels_display')),
				'header' => ucwords(lang('labels_header').' '.lang('labels_content')),
				'name' => ucwords(lang('labels_name')),
				'view' => ucwords(lang('labels_default').' '.lang('actions_view')),
				'no' => ucfirst(lang('labels_no')),
				'off' => ucfirst(lang('labels_off')),
				'on' => ucfirst(lang('labels_on')),
				'order' => ucfirst(lang('labels_order')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_manifest', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_menu_cat()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_menu') .' '. lang('labels_category'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->menu_model->get_menu_category($data['id'], 'menucat_id');
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'menucat_name',
					'class' => 'hud',
					'value' => $item->menucat_name),
				'order' => array(
					'name' => 'menucat_order',
					'class' => 'hud small',
					'value' => $item->menucat_order),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$cats = $this->menu_model->get_all_item_categories();
			
			if ($cats->num_rows() > 0)
			{
				foreach ($cats->result() as $cat)
				{
					$data['cats'][$cat->menu_cat] = ucfirst($cat->menu_cat);
				}
			}
			
			$data['default']['cat'] = $item->menucat_menu_cat;
			$data['default']['type'] = $item->menucat_type;
			
			$data['types'] = array(
				'sub' => ucwords(lang('labels_sub') .' '. lang('labels_navigation')),
				'adminsub' => ucwords(lang('labels_admin') .' '. lang('labels_sub') .' '. lang('labels_navigation')),
			);
			
			$data['label'] = array(
				'category' => ucfirst(lang('labels_category')),
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
				'type' => ucfirst(lang('labels_type'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_menu_cat', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_menu_item()
	{
		$allowed = Auth::check_access('site/menus', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('menu_model');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_menu'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			$data['tab'] = $this->uri->segment(4, 0, true);
			
			$menu = $this->menu_model->get_menu_item($data['id']);
			
			$item = ($menu->num_rows() > 0) ? $menu->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'menu_name',
					'class' => 'hud',
					'value' => $item->menu_name),
				'group' => array(
					'name' => 'menu_group',
					'class' => 'hud small',
					'value' => $item->menu_group),
				'order' => array(
					'name' => 'menu_order',
					'class' => 'hud small',
					'value' => $item->menu_order),
				'link' => array(
					'name' => 'menu_link',
					'class' => 'hud',
					'value' => $item->menu_link),
				'link_type_on' => array(
					'name' => 'menu_link_type',
					'id' => 'link_type_on',
					'class' => 'hud',
					'value' => 'onsite',
					'checked' => ($item->menu_link_type == 'onsite') ? true : false),
				'link_type_off' => array(
					'name' => 'menu_link_type',
					'id' => 'link_type_off',
					'class' => 'hud',
					'value' => 'offsite',
					'checked' => ($item->menu_link_type == 'offsite') ? true : false),
				'use_access_y' => array(
					'name' => 'menu_use_access',
					'id' => 'use_access_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => ($item->menu_use_access == 'y') ? true : false),
				'use_access_n' => array(
					'name' => 'menu_use_access',
					'id' => 'use_access_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => ($item->menu_use_access == 'n') ? true : false),
				'display_y' => array(
					'name' => 'menu_display',
					'id' => 'display_y',
					'class' => 'hud',
					'value' => 'y',
					'checked' => ($item->menu_display == 'y') ? true : false),
				'display_n' => array(
					'name' => 'menu_display',
					'id' => 'display_n',
					'class' => 'hud',
					'value' => 'n',
					'checked' => ($item->menu_display == 'n') ? true : false),
				'access' => array(
					'name' => 'menu_access',
					'class' => 'hud',
					'value' => $item->menu_access),
				'access_level' => array(
					'name' => 'menu_access_level',
					'class' => 'hud small',
					'value' => $item->menu_access_level),
				'category' => array(
					'name' => 'menu_cat',
					'class' => 'hud',
					'value' => $item->menu_cat),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$sim = $this->sys->get_sim_types();
			
			if ($sim->num_rows() > 0)
			{
				foreach ($sim->result() as $s)
				{
					$data['values']['sim_type'][$s->simtype_id] = ucfirst($s->simtype_name);
				}
			}
			
			$data['values']['login'] = array(
				'none' => ucfirst(lang('labels_no') .' '. lang('labels_requirement')),
				'y' => lang('misc_login_y'),
				'n' => lang('misc_login_n'),
			);
			
			$data['values']['type'] = array(
				'' => ucwords(lang('labels_please') .' '. lang('actions_choose')
					.' '. lang('order_one')),
				'main' => ucwords(lang('labels_main') .' '. lang('labels_navigation')),
				'sub' => ucwords(lang('labels_sub') .' '. lang('labels_navigation')),
				'adminsub' => ucwords(lang('labels_admin') .' '. lang('labels_sub') .' '. lang('labels_navigation')),
			);
			
			$cats = $this->menu_model->get_menu_categories();
			
			if ($cats->num_rows() > 0)
			{
				foreach ($cats->result() as $cat)
				{
					$data['cats'][$cat->menucat_menu_cat] = $cat->menucat_name;
				}
			}
			
			$data['defaults']['login'] = $item->menu_need_login;
			$data['defaults']['type'] = $item->menu_type;
			$data['defaults']['sim_type'] = $item->menu_sim_type;
			$data['defaults']['cat'] = $item->menu_cat;
			
			$data['label'] = array(
				'category' => ucfirst(lang('labels_category')),
				'control' => ucwords(lang('labels_access') .' '. lang('labels_control')),
				'control_level' => ucwords(lang('labels_access') .' '. lang('labels_control') .' '. lang('labels_level')),
				'control_text' => lang('text_menu_access'),
				'control_url' => ucwords(lang('labels_access') .' '. lang('labels_control') .' '. lang('abbr_url')),
				'desc' => ucfirst(lang('labels_desc')),
				'display' => ucfirst(lang('labels_display')),
				'group' => ucfirst(lang('labels_group')),
				'groupsort' => ucwords(lang('labels_grouping') .' '. AMP .' '. lang('labels_sorting')),
				'link' => ucfirst(lang('labels_link')),
				'linktype' => ucwords(lang('labels_link') .' '. lang('labels_type')),
				'login_req' => ucwords(lang('labels_login') .' '. lang('labels_requirement')),
				'name' => ucfirst(lang('labels_name')),
				'no' => ucfirst(lang('labels_no')),
				'off' => ucfirst(lang('labels_off')),
				'offsite' => ucfirst(lang('labels_offsite')),
				'on' => ucfirst(lang('labels_on')),
				'onsite' => ucfirst(lang('labels_onsite')),
				'order' => ucfirst(lang('labels_order')),
				'simtype' => ucwords(lang('labels_sim') .' '. lang('labels_type')),
				'simtype_text' => lang('text_sim_type'),
				'type' => ucfirst(lang('labels_type')),
				'typecat' => ucwords(lang('labels_type') .' '. AMP .' '. lang('labels_category')),
				'use_access' => ucwords(lang('actions_use') .' '. lang('labels_access') .' '. lang('labels_control')),
				'yes' => ucfirst(lang('labels_yes')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_menu_item', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_mission_group()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_missiongroup'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$item = $this->mis->get_mission_group($data['id']);
			
			$groups = $this->mis->get_all_mission_groups();
			
			if ($groups->num_rows() > 0)
			{
				$groups_select[0] = ucwords(lang('labels_no').' '.lang('labels_parent').' '.lang('global_missiongroup'));
				
				foreach ($groups->result() as $g)
				{
					$groups_select[$g->misgroup_id] = $g->misgroup_name;
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'misgroup_name',
					'class' => 'hud',
					'value' => $item->misgroup_name),
				'parent' => (isset($groups_select)) ? $groups_select : false,
				'parent_value' => $item->misgroup_parent,
				'order' => array(
					'name' => 'misgroup_order',
					'class' => 'small hud',
					'value' => $item->misgroup_order),
				'desc' => array(
					'name' => 'misgroup_desc',
					'class' => 'hud',
					'rows' => 5,
					'value' => $item->misgroup_desc),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'id' => 'addMission',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'parent' => ucwords(lang('labels_parent').' '.lang('global_missiongroup')),
				'order' => ucfirst(lang('labels_order')),
				'desc' => ucfirst(lang('labels_desc')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_mission_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_role_group()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$group = $this->access->get_group($data['id']);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'group_name',
					'class' => 'hud',
					'value' => $group->group_name),
				'order' => array(
					'name' => 'group_order',
					'class' => 'hud small',
					'value' => $group->group_order),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_role_group', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_role_page()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_role') .' '. lang('labels_page'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$page = $this->access->get_page($data['id']);
			$groups = $this->access->get_page_groups();
			
			$data['groups'][0] = ucwords(lang('labels_none'));
			
			if ($groups->num_rows() > 0)
			{
				foreach ($groups->result() as $group)
				{
					$data['groups'][$group->group_id] = $group->group_name;
				}
			}
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'page_name',
					'class' => 'hud',
					'value' => $page->page_name),
				'url' => array(
					'name' => 'page_url',
					'class' => 'hud',
					'value' => $page->page_url),
				'level' => array(
					'name' => 'page_level',
					'class' => 'small hud',
					'value' => (empty($page->page_level)) ? 0 : $page->page_level),
				'desc' => array(
					'name' => 'page_desc',
					'class' => 'hud',
					'value' => $page->page_desc,
					'rows' => 4),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['defaults']['group'] = $page->page_group;
			
			$data['label'] = array(
				'desc' => ucfirst(lang('labels_desc')),
				'group' => ucfirst(lang('labels_group')),
				'level' => ucwords(lang('labels_page') .' '. lang('labels_level')),
				'name' => ucwords(lang('labels_page') .' '. lang('labels_name')),
				'url' => ucwords(lang('labels_page') .' '. lang('abbr_url')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_role_page', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_site_message()
	{
		$allowed = Auth::check_access('site/messages', false);
		
		if ($allowed)
		{
			$this->load->model('messages_model', 'msgs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_site') .' '. lang('labels_message'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			// get the message
			$message = $this->msgs->get_message_details($data['id'], 'id');
			
			if ($message->num_rows() > 0)
			{
				$row = $message->row();
				
				// input parameters
				$data['inputs'] = array(
					'label' => array(
						'name' => 'message_label',
						'value' => $row->message_label,
						'class' => 'hud'),
					'key' => array(
						'name' => 'message_key',
						'value' => $row->message_key,
						'class' => 'hud'),
					'content' => array(
						'name' => 'message_content',
						'value' => $row->message_content,
						'class' => 'hud'),
					'submit' => array(
						'type' => 'submit',
						'class' => 'hud_button',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('actions_submit')))
				);
				
				$data['type'] = array(
					'title' => ucwords(lang('labels_page') .' '. lang('labels_titles')),
					'message' => ucfirst(lang('labels_messages')),
					'other' => ucfirst(lang('labels_other'))
				);
				
				$data['value']['type'] = $row->message_type;
				
				$data['old_key'] = $row->message_key;
				
				switch ($row->message_key)
				{
					case 'accept_message':
						$op = array(
							'#name# '. NDASH .' '. lang('global_user_poss') .' '. lang('labels_name'),
							'#character# '. NDASH .' '. lang('global_character') .' '. lang('labels_name'),
							'#sim# '. NDASH .' '. lang('global_sim') .' '. lang('labels_name'),
							'#position# '. NDASH .' '. lang('global_position'),
							'#rank# '. NDASH .' '. lang('global_rank')
						);
						
						$data['text'] = sprintf(
							lang('text_dynamic_emails'),
							implode('<br />', $op)
						);
					break;
						
					case 'reject_message':
						$op = array(
							'#name# '. NDASH .' '. lang('global_user_poss') .' '. lang('labels_name'),
							'#character# '. NDASH .' '. lang('global_character') .' '. lang('labels_name'),
							'#sim# '. NDASH .' '. lang('global_sim') .' '. lang('labels_name'),
							'#position# '. NDASH .' '. lang('global_position'),
						);
						
						$data['text'] = sprintf(
							lang('text_dynamic_emails'),
							implode('<br />', $op)
						);
					break;
						
					case 'docking_accept_message':
						$op = array(
							'#sim# '. NDASH .' '. lang('global_sim') .' '. lang('labels_name'),
							'#sim_name# '. NDASH .' '. lang('actions_docked') .' '. lang('global_sim') .' '. lang('labels_name'),
							'#gm_name# '. NDASH .' '. lang('actions_docked') .' '. lang('global_game_master') .' '. lang('labels_name')
						);
						
						$data['text'] = sprintf(
							lang('text_dynamic_emails'),
							implode('<br />', $op)
						);
					break;
						
					case 'docking_reject_message':
						$op = array(
							'#sim# '. NDASH .' '. lang('global_sim') .' '. lang('labels_name'),
							'#sim_name# '. NDASH .' '. lang('actions_docked') .' '. lang('global_sim') .' '. lang('labels_name'),
							'#gm_name# '. NDASH .' '. lang('actions_docked') .' '. lang('global_game_master') .' '. lang('labels_name')
						);
						
						$data['text'] = sprintf(
							lang('text_dynamic_emails'),
							implode('<br />', $op)
						);
					break;
					
					default:
						$data['text'] = '';
					break;
				}
			}
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'key' => ucwords(lang('labels_message') .' '. lang('labels_key')),
				'label' => ucwords(lang('labels_message') .' '. lang('labels_label')),
				'type' => ucfirst(lang('labels_type')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_site_message', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_spec_field_value()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_specifications') .' '. lang('labels_field') .' '. lang('labels_value'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['field'] = (is_numeric($this->uri->segment(4))) ? $this->uri->segment(4) : 0;
			
			$value = $this->specs->get_spec_value_details($data['id']);
			$fields = $this->specs->get_spec_fields('', '', 'select');
			
			if ($fields->num_rows() > 0)
			{
				foreach ($fields->result() as $field)
				{
					$data['values']['fields'][$field->field_id] = $field->field_label_page;
				}
			}
			
			$item = ($value->num_rows() > 0) ? $value->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'value' => array(
					'name' => 'value_field_value',
					'class' => 'hud',
					'value' => $item->value_field_value),
				'content' => array(
					'name' => 'value_content',
					'class' => 'hud',
					'value' => $item->value_content),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['selected_field'] = $item->value_field;
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'dropdown' => lang('text_dropdown_value'),
				'field' => ucfirst(lang('labels_field')),
				'insert' => lang('text_db_insert'),
				'value' => ucfirst(lang('labels_value')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_spec_field_value', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_spec_sec()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_specifications') .' '. lang('labels_section'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			$sec = $this->specs->get_spec_section_details($data['id']);
			
			$item = ($sec->num_rows() > 0) ? $sec->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'section_name',
					'class' => 'hud',
					'value' => $item->section_name),
				'order' => array(
					'name' => 'section_order',
					'class' => 'hud small',
					'value' => $item->section_order),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'name' => ucfirst(lang('labels_name')),
				'order' => ucfirst(lang('labels_order')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_spec_sec', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_tour_field_value()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['field'] = (is_numeric($this->uri->segment(4))) ? $this->uri->segment(4) : 0;
			
			$value = $this->tour->get_tour_value_details($data['id']);
			$fields = $this->tour->get_tour_fields('', 'select');
			
			if ($fields->num_rows() > 0)
			{
				foreach ($fields->result() as $field)
				{
					$data['values']['fields'][$field->field_id] = $field->field_label_page;
				}
			}
			
			$item = ($value->num_rows() > 0) ? $value->row() : false;
			
			// input parameters
			$data['inputs'] = array(
				'value' => array(
					'name' => 'value_field_value',
					'class' => 'hud',
					'value' => $item->value_field_value),
				'content' => array(
					'name' => 'value_content',
					'class' => 'hud',
					'value' => $item->value_content),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['selected_field'] = $item->value_field;
			
			$data['label'] = array(
				'content' => ucfirst(lang('labels_content')),
				'dropdown' => lang('text_dropdown_value'),
				'field' => ucfirst(lang('labels_field')),
				'insert' => lang('text_db_insert'),
				'value' => ucfirst(lang('labels_value')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_tour_field_value', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_user_setting()
	{
		$allowed = Auth::check_access('site/settings', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('labels_site') .' '. lang('labels_setting'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			// get the message
			$setting = $this->settings->get_setting_details($data['id'], 'setting_id');
			
			if ($setting->num_rows() > 0)
			{
				$row = $setting->row();
				
				// input parameters
				$data['inputs'] = array(
					'label' => array(
						'name' => 'setting_label',
						'value' => $row->setting_label,
						'class' => 'hud'),
					'key' => array(
						'name' => 'setting_key',
						'value' => $row->setting_key,
						'class' => 'hud'),
					'value' => array(
						'name' => 'setting_value',
						'value' => $row->setting_value,
						'class' => 'hud'),
					'submit' => array(
						'type' => 'submit',
						'class' => 'hud_button',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('actions_submit')))
				);
			}
			
			$data['label'] = array(
				'key' => ucwords(lang('labels_setting') .' '. lang('labels_key')),
				'label' => ucwords(lang('labels_label')),
				'value' => ucfirst(lang('labels_value')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('edit_user_setting', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function edit_wiki_category()
	{
		$allowed = Auth::check_access('wiki/categories', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_edit')),
				ucwords(lang('global_wiki') .' '. lang('labels_category'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			
			// get the message
			$cat = $this->wiki->get_category($data['id']);
			
			// input parameters
			$data['inputs'] = array(
				'name' => array(
					'name' => 'name',
					'value' => $cat->wikicat_name,
					'class' => 'hud'),
				'desc' => array(
					'name' => 'desc',
					'value' => $cat->wikicat_desc,
					'class' => 'hud',
					'rows' => 3),
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['label'] = array(
				'desc' => ucfirst(lang('labels_desc')),
				'name' => ucwords(lang('labels_category') .' '. lang('labels_name')),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('edit_wiki_category', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function info_check_post_lock()
	{
		// load the resources
		$this->load->model('posts_model', 'posts');
		
		// set the variables
		$post = $this->input->post('post', true);
		$content = $this->input->post('content', true);
		$time = now();
		$user = $this->session->userdata('userid');
		
		// get the post
		$item = $this->posts->get_post($post);
		
		if ($item)
		{
			// hash the post contents from the db
			$db_hash = md5($item->post_content);
			
			// hash the post contents from the POST variable
			$post_hash = md5($content);
			
			// get the difference between how many minutes since the lock was activated
			$diff = now() - $item->post_lock_date;
			$diff = ($diff / 60);
			$diff = floor($diff);
			
			if ($item->post_lock_user !== $user)
			{
				if ($item->post_lock_user === 0)
				{
					/**
					 * CODE 5
					 *
					 * There is no lock on this post, so we're going to assign a lock
					 * to the current user and send the code back to the view to do
					 * nothing and let the user continue working with the new lock.
					 */
					
					// auto-save the content
					$data = array(
						'post_lock_user' => $user,
						'post_lock_date' => now()
					);
					
					// update the post
					$this->posts->update_post($post, $data);
					
					// the code
					$retval = 5;
				}
				else
				{
					if ($diff < 5)
					{
						/**
						 * CODE 6
						 *
						 * Someone else owns the lock and it is active so there's nothing we
						 * can do here. Send the code back to the view and wait another 5 minutes
						 * to check the lock again.
						 */
						 
						$retval = 6;
					}
					else
					{
						/**
						 * CODE 7
						 *
						 * Someone else owned the lock, but it isn't active any more, so take over
						 * the lock, send the code back to the view and start the process.
						 */
						
						// save the lock
						$data = array(
							'post_lock_user' => $user,
							'post_lock_date' => now()
						);
						
						// update the post
						$this->posts->update_post($post, $data);
						
						$retval = 7;
					}
				}
			}
			else
			{
				/**
				 * CODE 1
				 *
				 * There haven't been any changes to the post since the initial
				 * lock was granted. Release the lock and send the code back to
				 * the view to redirect to the Writing Control Panel.
				 */
				if ($post_hash == $db_hash)
				{
					$this->posts->update_post_lock($post, 0, false);
					
					$retval = 1;
				}
				
				if ($post_hash != $db_hash)
				{
					if ($this->session->userdata('post_lock_'.$post))
					{
						/**
						 * CODE 2
						 *
						 * Changes have been made that differ from the content from
						 * the database, but the post is the same as it was 5 minutes
						 * ago. Auto-save the post content (but don't change the saved
						 * author information or send an email), release then lock then
						 * send the code back to the view to redirect back to the
						 * Writing Control Panel.
						 */
						if ($post_hash == $this->session->userdata('post_lock_'.$post))
						{
							// auto-save the content
							$data = array(
								'post_content' => $content,
								'post_lock_user' => 0,
								'post_lock_date' => 0
							);
							
							// update the post
							$this->posts->update_post($post, $data);
							
							// remove the session data
							$this->session->unset_userdata('post_lock_'.$post);
							
							// the code
							$retval = 2;
						}
						
						/**
						 * CODE 3
						 *
						 * Changes have been made that differ from the content from
						 * the database and the post is different from the check 5
						 * minutes ago. Store a hash of the content in the session
						 * (or update what's already there), renew the lock and send
						 * the code back to the view to do nothing and let the user
						 * continue working.
						 */
						if ($post_hash != $this->session->userdata('post_lock_'.$post))
						{
							// set the session data
							$this->session->set_userdata('post_lock_'.$post, $post_hash);
							
							// update the lock
							$this->posts->update_post_lock($post, $this->session->userdata('userid'));
							
							// the code
							$retval = 3;
						}
					}
					
					/**
					 * CODE 4
					 *
					 * Changes have been made that differ from the content from
					 * the database and no session variable exists that's storing
					 * the hash of the previous check. Send the hash of the content
					 * to the session, renew the lock and send the code back to 
					 * the view to do nothing and let the user continue working.
					 */
					if ( ! $this->session->userdata('post_lock_'.$post))
					{
						// set the session data
						$this->session->set_userdata('post_lock_'.$post, $post_hash);
						
						// update the lock
						$this->posts->update_post_lock($post, $this->session->userdata('userid'));
						
						// the code
						$retval = 4;
					}
				}
			}
			
			echo $retval;
		}
	}
	
	public function info_release_post_lock($id = false)
	{
		$allowed = Auth::check_access('manage/posts', false);
		$level = Auth::get_access_level('manage/posts');
		
		if ($allowed and $level == 2)
		{
			// load the resources
			$this->load->model('posts_model', 'posts');
			
			// get the post
			$post = $this->posts->get_post($id);
			
			// update the lock
			$this->posts->update_post_lock($id, 0, false);
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_release')),
				ucwords(lang('global_post').' '.lang('labels_lock'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = sprintf(
				lang('fbx_content_info_release_post_lock'),
				lang('global_missionpost'),
				($post) ? $post->post_title : ''
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('abbr_ok')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('info_release_post_lock', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function info_format_date()
	{
		$format = $this->input->post('format', true);
		
		echo mdate($format, now());
	}
	
	public function info_users_with_role()
	{
		$allowed = Auth::check_access('site/roles', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('access_model', 'access');
			$this->load->model('characters_model', 'char');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('labels_info') .' '. NDASH .' '),
				ucwords(lang('fbx_item_users_role'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $this->uri->segment(3, 0, true);
			
			$role = $this->access->get_role($data['id']);
			
			$data['text'] = sprintf(
				lang('fbx_content_info_users_with_role'),
				$role->role_name
			);
			
			$data['label'] = array(
				'notfound' => sprintf(lang('error_not_found'), lang('global_users')),
			);
			
			$users = $this->access->get_users_with_role($data['id']);
			
			if (is_array($users))
			{
				foreach ($users as $p)
				{
					$data['list'][] = $this->char->get_character_name($p, true);
				}
			}
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('info_users_with_role', $skin, 'admin', $data);
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function info_show_award_desc()
	{
		// load the resources
		$this->load->model('awards_model', 'awards');
		
		// set the POST variable
		$award = $this->input->post('award', true);
		
		// grab the position details
		$item = $this->awards->get_award($award, 'award_desc');
		
		// set the output
		$output = ($item !== false) ? $item : '';
		
		echo text_output($output, '');
	}
	
	public function info_show_characters_by_award()
	{
		// load the resources
		$this->load->model('awards_model', 'awards');
		$this->load->model('characters_model', 'char');
		
		// set the POST variable
		$award = $this->input->post('award', true);
		
		$type = $this->awards->get_award($award, 'award_cat');
		
		if ($type !== false)
		{
			switch ($type)
			{
				case 'ic':
					$chars = 'user_npc';
				break;
					
				default:
					$chars = 'active';
				break;
			}
			
			echo form_dropdown_characters('character', '', '', $chars);
		}
		
		echo '';
	}
	
	public function info_show_position_desc()
	{
		// load the resources
		$this->load->model('positions_model', 'pos');
		
		// set the POST variable
		$position = $this->input->post('position', true);
		
		// grab the position details
		$item = $this->pos->get_position($position, 'pos_desc');
		
		// set the output
		$output = ($item !== false) ? $item : '';
		
		echo text_output($output, '');
	}
	
	public function info_show_rank_img()
	{
		// load the resources
		$this->load->model('ranks_model', 'rank');
		
		// set the POST variable
		$rank = $this->input->post('rank', true);
		$location = $this->input->post('location', true);
		
		// grab the position details
		$item = $this->rank->get_rank($rank, 'rank_image');
		$ext = $this->rank->get_rankcat($location, 'rankcat_location', 'rankcat_extension');
		
		// set the output
		$output = ($item !== false) ? array('src' => base_url() . Location::rank($location, $item, $ext)) : '';
		
		echo img($output);
	}
	
	public function info_show_rank_preview_img()
	{
		// load the resources
		$this->load->model('ranks_model', 'rank');
		
		// set the POST variable
		$rank = $this->input->post('rank', true);
		
		// grab the position details
		$preview = $this->rank->get_rankcat($rank, 'rankcat_location', 'rankcat_preview');
		
		// set the output
		$output = ($preview !== false) ? array('src' => base_url() . Location::rank($rank, $preview, '')) : '';
		
		echo img($output);
	}
	
	public function info_show_skin_preview_image()
	{
		// set the POST variables
		$location = $this->input->post('skin', true);
		$section = $this->input->post('section', true);
		
		$where = array(
			'skinsec_section' => $section,
			'skinsec_skin' => $location
		);
		
		// grab the position details
		$item = $this->sys->get_skinsec($where);
		
		// set the output
		$output = ($item !== false) ? base_url() . APPFOLDER .'/views/'. $location .'/'. $item->skinsec_image_preview : '';
		
		echo $output;
	}
	
	public function info_show_skin_preview()
	{
		// set the POST variables
		$location = $this->input->post('skin', true);
		$section = $this->input->post('section', true);
		
		$where = array(
			'skinsec_section' => $section,
			'skinsec_skin' => $location
		);
		
		// grab the position details
		$item = $this->sys->get_skinsec($where);
		
		// set the output
		$output = ($item !== false) ? array('src' => base_url() . APPFOLDER .'/views/'. $location .'/'. $item->skinsec_image_preview) : '';
		
		echo img($output);
	}
	
	public function info_show_wiki_categories()
	{
		$this->load->model('wiki_model', 'wiki');
		
		// set the empty arrays
		$response = array();
		$names = array();
		
		// grab the categories
		$categories = $this->wiki->get_categories();
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $cat)
			{
				$names[$cat->wikicat_id] = $cat->wikicat_name;
			}
		}
		
		// make sure they're sorted alphabetically, for binary search tests
		asort($names);
		
		foreach ($names as $i => $name)
		{
			$filename = str_replace(' ', '', strtolower($name));
			$response[] = array($i, $name);
		}
		
		header('Content-type: application/json');
		echo json_encode($response);
	}
	
	public function reject()
	{
		$data['type'] = $this->uri->segment(3, false);
		$data['id'] = $this->uri->segment(4, 0, true);
		
		// figure out the skin
		$skin = $this->session->userdata('skin_admin');
		
		// figure out where the view should come from
		$view = 'reject';
		
		// input parameters
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		switch ($data['type'])
		{
			case 'award_nomination':
				$allowed = Auth::check_access('user/nominate', false);
				
				if ($allowed)
				{
					// load the resources
					$this->load->model('characters_model', 'char');
					$this->load->model('users_model', 'user');
					
					$type = lang('global_award') .' '. lang('labels_nomination');
					
					$nom = $this->sys->get_item('awards_queue', 'queue_id', $data['id']);
					$award = $this->sys->get_item('awards', 'award_id', $nom->queue_award);
					
					if ($award->award_cat == 'ooc')
					{
						$user = $this->user->get_user($nom->award_receive_user);
						$name = (empty($user->name)) ? $user->email : $user->name;
					}
					else
					{
						$name = $this->char->get_character_name($nom->queue_receive_character, true);
					}
					
					$data['text'] = sprintf(
						lang('fbx_content_del_entry'),
						$type .' '. lang('labels_for'),
						$name
					);
					
					$data['form'] = 'user/nominate/queue';
					
					// figure out where the view should come from
					$view = 'reject_awardnom';
				}
			break;
				
			case 'character':
				$allowed = Auth::check_access('characters/index', false);
				
				if ($allowed)
				{
					// load the resources
					$this->load->model('messages_model', 'msgs');
					
					$type = lang('global_character');
					
					// input parameters
					$data['inputs'] += array(
						'email' => array(
							'name' => 'reject',
							'id' => 'reject',
							'class' => 'hud',
							'value' => $this->msgs->get_message('reject_message')),
					);
					
					$data['form'] = 'characters/index/pending/'. $data['id'];
				}
			break;
				
			case 'docking':
				$allowed = Auth::check_access('manage/docked', false);
				
				if ($allowed)
				{
					$this->load->model('docking_model', 'docking');
					$this->load->model('messages_model', 'msgs');
					
					$type = lang('actions_docking') .' '. lang('labels_request');
					
					$item = $this->docking->get_docked_item($data['id']);
					
					$data['text'] = sprintf(
						lang('text_docking_reject'),
						$item->docking_sim_name,
						lang('global_game_master')
					);
					
					$data['values'] = array(
						'email' => array(
							'name' => 'accept',
							'id' => 'accept',
							'class' => 'hud',
							'value' => $this->msgs->get_message('docking_reject_message')),
					);
					
					$data['form'] = 'manage/docked/pending';
					
					// figure out where the view should come from
					$view = 'reject_docking';
				}
			break;
		}
		
		$data['header'] = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_reject')),
			ucwords($type)
		);
		
		$data['label'] = array(
			'email' => ucfirst(lang('labels_email')),
		);
		
		$this->_regions['content'] = Location::ajax($view, $skin, 'admin', $data);
		$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function revert_wiki_page()
	{
		$allowed = Auth::check_access('wiki/page', false);
		
		if ($allowed)
		{
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_revert')),
				ucwords(lang('global_wiki') .' '. lang('labels_page'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['page'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
			$data['draft'] = (is_numeric($this->uri->segment(4))) ? $this->uri->segment(4) : 0;
			
			$page = $this->wiki->get_page($data['page']);
			
			if ($page->num_rows() > 0)
			{
				foreach ($page->result() as $p)
				{
					$title = $p->draft_title;
				}
			}
			else
			{
				$title = '';
			}
			
			$data['text'] = sprintf(
				lang('wiki_revert'),
				$title
			);
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('revert_wiki_page', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function save_character_image()
	{
		$allowed = Auth::check_access('characters/bio', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// get the images
			$images = $this->char->get_character($id, 'images');
			
			if ( ! empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key === false)
				{
					// add the image to the array
					$imagesArray[] = $image;
					
					// make the array a string
					$imagesStr = implode(',', $imagesArray);
					
					// fire the character update event
					$this->char->update_character($id, array('images' => $imagesStr));
					
					$array = array(
						'src' => base_url() . Location::asset('images/characters', $image),
						'height' => 140
					);
					
					echo img($array);
				}
				else
				{
					echo '';
				}
			}
			else
			{
				// add the image to the array
				$imagesArray[] = $image;
				
				// make the array a string
				$imagesStr = implode(',', $imagesArray);
				
				// fire the character update event
				$this->char->update_character($id, array('images' => $imagesStr));
				
				$array = array(
					'src' => base_url() . Location::asset('images/characters', $image),
					'height' => 140
				);
				
				echo img($array);
			}
		}
	}
	
	public function save_character_images()
	{
		$allowed = Auth::check_access('characters/bio', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$images = $this->input->post('img', true);
			$id = $this->uri->segment(3);
			
			// set the initial image string
			$imageStr = '';
			
			if (is_array($images))
			{
				foreach ($images as $i)
				{
					$imageArray[] = str_replace('\.', '.', $i);
				}
				
				$imageStr = implode(',', $imageArray);
			}
			
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// fire the character update event
			$this->char->update_character($id, array('images' => $imageStr));
		}
	}
	
	public function save_coc()
	{
		$allowed = Auth::check_access('characters/coc', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$coc = $this->input->post('coc', true);
			
			$empty = $this->char->empty_coc();
			
			$i = 0;
			$count = 0;
			
			foreach ($coc as $c)
			{
				$insert_array = array(
					'coc_crew' => $c,
					'coc_order' => $i
				);
				
				$insert = $this->char->create_coc_entry($insert_array);
				$count+= $insert;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(strtolower(lang('labels_coc'))),
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
					ucfirst(strtolower(lang('labels_coc'))),
					lang('actions_updated'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_bio_field_value()
	{
		$allowed = Auth::check_access('site/bioform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('characters_model', 'char');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$post = $this->input->post('value', true);
			
			$i = 0;
			$count = 0;
			
			foreach ($post as $key => $value)
			{
				$update_array = array('value_order' => $i);
				
				$update = $this->char->update_bio_field_value($value, $update_array);
				$count+= $update;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_updated'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_deck()
	{
		$allowed = Auth::check_access('manage/decks', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$post = $this->input->post('decks', true);
			
			$i = 0;
			$count = 0;
			
			foreach ($post as $key => $value)
			{
				$update_array = array('deck_order' => $i);
				
				$update = $this->tour->update_deck($value, $update_array);
				$count+= $update;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('global_decks')),
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
					ucfirst(lang('global_decks')),
					lang('actions_updated'),
					''
				);
	
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_dept_manifest()
	{
		$allowed = Auth::check_access('site/manifests', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			// set the variables
			$manifest = $this->input->post('manifest', true);
			$dept = $this->input->post('dept', true);
			
			// set the array of items to update
			$update_array = array('dept_manifest' => $manifest);
			
			// do the update
			$update = $this->dept->update_dept($dept, $update_array);
			
			if ($update > 0)
			{
				echo "1";
			}
			else
			{
				echo "0";
			}
		}
	}
	
	public function save_docking_field_value()
	{
		$allowed = Auth::check_access('site/dockingform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('docking_model', 'docking');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$post = $this->input->post('value', true);
			
			$i = 0;
			$count = 0;
			
			foreach ($post as $key => $value)
			{
				$update_array = array('value_order' => $i);
				
				$update = $this->docking->update_docking_field_value($value, $update_array);
				$count+= $update;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_updated'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_ignore_update_version()
	{
		$allowed = Auth::is_sysadmin($this->session->userdata('userid'));
		
		if ($allowed)
		{
			// grab the version from the POST
			$version = $this->input->post('version', true);
			
			// build the array used by AR
			$update = array('sys_version_ignore' => $version);
			
			// do the update
			$this->sys->update_system_info($update);
		}
	}
	
	public function save_mission_image()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			// get the images
			$images = $this->mis->get_mission($id, 'mission_images');
			
			if ( ! empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key === false)
				{
					// add the image to the array
					$imagesArray[] = $image;
					
					// make the array a string
					$imagesStr = implode(',', $imagesArray);
					
					// fire the character update event
					$this->mis->update_mission($id, array('mission_images' => $imagesStr));
					
					$array = array(
						'src' => base_url().Location::asset('images/missions', $image),
						'width' => 130
					);
					
					echo img($array);
				}
				else
				{
					echo '';
				}
			}
			else
			{
				// add the image to the array
				$imagesArray[] = $image;
				
				// make the array a string
				$imagesStr = implode(',', $imagesArray);
				
				// fire the character update event
				$this->mis->update_mission($id, array('mission_images' => $imagesStr));
				
				$array = array(
					'src' => base_url().Location::asset('images/missions', $image),
					'width' => 130
				);
				
				echo img($array);
			}
		}
	}
	
	public function save_mission_images()
	{
		$allowed = Auth::check_access('manage/missions', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$images = $this->input->post('img', true);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			// load the resources
			$this->load->model('missions_model', 'mis');
			
			// fire the character update event
			$this->mis->update_mission($id, array('mission_images' => $imageStr));
		}
	}
	
	public function save_position()
	{
		$allowed = Auth::check_access('manage/positions', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$id = $this->security->xss_clean($_POST['id']);
			$update = array(
				'pos_order' => $this->security->xss_clean($_POST['order']),
				'pos_dept' => $this->security->xss_clean($_POST['dept']),
				'pos_display' => $this->security->xss_clean($_POST['display']),
				'pos_type' => $this->security->xss_clean($_POST['type']),
				'pos_desc' => $this->security->xss_clean($_POST['desc']),
			);
			
			// load the resources
			$this->load->model('positions_model', 'pos');
			
			// update the position
			$this->pos->update_position($id, $update);
		}
	}
	
	public function save_spec_field_value()
	{
		$allowed = Auth::check_access('site/specsform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$post = $this->input->post('value', true);
			
			$i = 0;
			$count = 0;
			
			foreach ($post as $key => $value)
			{
				$update_array = array('value_order' => $i);
				
				$update = $this->specs->update_spec_field_value($value, $update_array);
				$count+= $update;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_specification') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('global_specification') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_updated'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_spec_image()
	{
		$allowed = Auth::check_access('manage/specs', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			// get the images
			$item = $this->specs->get_spec_item($id);
			
			if ($item !== false)
			{
				$images = $item->specs_images;
				
				if ( ! empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key === false)
					{
						// add the image to the array
						$imagesArray[] = $image;
						
						// make the array a string
						$imagesStr = implode(',', $imagesArray);
						
						// fire the character update event
						$this->specs->update_spec_item($id, array('specs_images' => $imagesStr));
						
						$array = array(
							'src' => base_url().Location::asset('images/specs', $image),
							'width' => 130
						);
						
						echo img($array);
					}
					else
					{
						echo '';
					}
				}
				else
				{
					// add the image to the array
					$imagesArray[] = $image;
					
					// make the array a string
					$imagesStr = implode(',', $imagesArray);
					
					// fire the character update event
					$this->specs->update_spec_item($id, array('specs_images' => $imagesStr));
					
					$array = array(
						'src' => base_url().Location::asset('images/specs', $image),
						'width' => 130
					);
					
					echo img($array);
				}
			}
		}
	}
	
	public function save_spec_images()
	{
		$allowed = Auth::check_access('manage/specs', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$images = $this->input->post('img', true);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			// load the resources
			$this->load->model('specs_model', 'specs');
			
			// fire the character update event
			$this->specs->update_spec_item($id, array('specs_images' => $imageStr));
		}
	}
	
	public function save_tour_field_value()
	{
		$allowed = Auth::check_access('site/tourform', false);
		
		if (IS_AJAX and $allowed)
		{
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$post = $this->input->post('value', true);
			
			$i = 0;
			$count = 0;
			
			foreach ($post as $key => $value)
			{
				$update_array = array('value_order' => $i);
				
				$update = $this->tour->update_tour_field_value($value, $update_array);
				$count+= $update;
				
				++$i;
			}
			
			if ($count > 0)
			{
				$message = sprintf(
					lang('flash_success'),
					ucfirst(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value')),
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
					ucfirst(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value')),
					lang('actions_updated'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			$output = Location::view('flash', $skin, 'admin', $flash);
			
			echo $output;
		}
	}
	
	public function save_tour_image()
	{
		$allowed = Auth::check_access('manage/tour', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', true);
			
			$image = str_replace('\.', '.', $image);
			
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// get the images
			$tour = $this->tour->get_tour_item($id);
			
			if ($tour->num_rows() > 0)
			{
				$item = $tour->row();
				
				$images = $item->tour_images;
				
				if ( ! empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key === false)
					{
						// add the image to the array
						$imagesArray[] = $image;
						
						// make the array a string
						$imagesStr = implode(',', $imagesArray);
						
						// fire the character update event
						$this->tour->update_tour_item($id, array('tour_images' => $imagesStr));
						
						$array = array(
							'src' => base_url().Location::asset('images/tour', $image),
							'width' => 130
						);
						
						echo img($array);
					}
					else
					{
						echo '';
					}
				}
				else
				{
					// add the image to the array
					$imagesArray[] = $image;
					
					// make the array a string
					$imagesStr = implode(',', $imagesArray);
					
					// fire the character update event
					$this->tour->update_tour_item($id, array('tour_images' => $imagesStr));
					
					$array = array(
						'src' => base_url().Location::asset('images/tour', $image),
						'width' => 130
					);
					
					echo img($array);
				}
			}
		}
	}
	
	public function save_tour_images()
	{
		$allowed = Auth::check_access('manage/tour', false);
		
		if (IS_AJAX and $allowed)
		{
			// set the variables
			$images = $this->input->post('img', true);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			// load the resources
			$this->load->model('tour_model', 'tour');
			
			// fire the character update event
			$this->tour->update_tour_item($id, array('tour_images' => $imageStr));
		}
	}
	
	public function update_mark_messages_as_read($user)
	{
		$allowed = Auth::check_access('messages/index', false);
		
		if ($allowed)
		{
			// load the models
			$this->load->model('privmsgs_model', 'pm');
			
			// sanity check
			$user = (is_numeric($user)) ? $user : false;
			
			if ($user !== false)
			{
				// get all of the unread message IDs
				$unread = $this->pm->get_unread_messages($user);
			
				if ($unread !== false)
				{
					// loop through the IDs and mark them as read
					foreach ($unread as $u)
					{
						$this->pm->update_message($u, $user, array('pmto_unread' => 'n'));
					}
				}
			}
		}
	}
	
	public function user_activate($id)
	{
		$allowed = Auth::check_access('user/account', false);
		$level = Auth::get_access_level('user/account');
		
		if ($allowed and $level == 2)
		{
			// load the models
			$this->load->model('users_model', 'user');
			$this->load->model('characters_model', 'char');
			$this->load->model('ranks_model', 'rank');
			$this->load->model('positions_model', 'pos');
			$this->load->helper('utility');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_activate')),
				ucwords(lang('global_user'))
			);
			
			// get the user
			$item = $this->user->get_user($id);
			
			// get all characters associated with the user
			$characters = $this->char->get_user_characters($id, 'inactive');
			
			if ($characters->num_rows() > 0)
			{
				foreach ($characters->result() as $c)
				{
					$data['characters'][$c->charid] = parse_name(array(
						$this->rank->get_rank($c->rank, 'rank_name'),
						$c->first_name,
						$c->last_name)).' - '.$this->pos->get_position($c->position_1, 'pos_name');
				}
			}
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_user_activate'),
				$item->name,
				$item->email,
				lang('global_characters'),
				lang('global_user')
			);
			$data['primarychar'] = $item->main_char;
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('user_activate', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function user_deactivate($id)
	{
		$allowed = Auth::check_access('user/account', false);
		$level = Auth::get_access_level('user/account');
		
		if ($allowed and $level == 2)
		{
			// load the models
			$this->load->model('users_model', 'user');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_deactivate')),
				ucwords(lang('global_user'))
			);
			
			$item = $this->user->get_user($id);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_user_deactivate'),
				$item->name,
				$item->email,
				lang('global_characters')
			);
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('user_deactivate', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function user_password_reset($id)
	{
		$allowed = Auth::check_access('user/account', false);
		$level = Auth::get_access_level('user/account');
		
		if ($allowed and $level == 2)
		{
			// load the models
			$this->load->model('users_model', 'user');
			
			// sanity check
			$id = (is_numeric($id)) ? $id : false;
			
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_reset')),
				ucwords(lang('labels_password'))
			);
			
			// get the user details
			$item = $this->user->get_user($id);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['id'] = $id;
			$data['text'] = sprintf(
				lang('fbx_content_user_password_reset'),
				$item->name,
				$item->email,
				lang('global_user')
			);
			
			$button = array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_admin');
			
			$this->_regions['content'] = Location::ajax('user_password_reset', $skin, 'admin', $data);
			$this->_regions['controls'] = form_button($button).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function wiki_create_category()
	{
		$allowed = Auth::check_access('wiki/categories', false);
		
		if (IS_AJAX and $allowed)
		{
			// grab the category name from the POST
			$name = $_POST['category'];
			
			// load the models
			$this->load->model('wiki_model', 'wiki');
			
			// create the category
			$result = $this->wiki->create_category(array('wikicat_name' => $name));
			
			if ($result > 0)
			{
				echo $this->db->insert_id();
			}
			else
			{
				echo 0;
			}
		}
	}
	
	public function wiki_draft_cleanup()
	{
		$allowed = Auth::check_access('wiki/page', false);
		
		if ($allowed)
		{
			$head = sprintf(
				lang('fbx_head'),
				ucwords(lang('actions_cleanup')),
				ucwords(lang('global_wiki').' '.lang('labels_drafts'))
			);
			
			// data being sent to the facebox
			$data['header'] = $head;
			$data['text'] = lang('fbx_content_draft_cleanup');
			
			// input parameters
			$data['inputs'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'hud_button',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit')))
			);
			
			$data['time'] = array(
				'30' => ucwords(lang('status_older').' '.lang('labels_than').' 30 '.lang('time_days')),
				'60' => ucwords(lang('status_older').' '.lang('labels_than').' 60 '.lang('time_days')),
				'90' => ucwords(lang('status_older').' '.lang('labels_than').' 90 '.lang('time_days')),
				'180' => ucwords(lang('status_older').' '.lang('labels_than').' 6 '.lang('time_months')),
				'all' => lang('misc_draft_cleanup'),
			);
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$this->_regions['content'] = Location::ajax('draft_cleanup', $skin, 'wiki', $data);
			$this->_regions['controls'] = form_button($data['inputs']['submit']).form_close();
			
			Template::assign($this->_regions);
			
			Template::render();
		}
	}
	
	public function wiki_get_page_drafts()
	{
		if (IS_AJAX)
		{
			// get the page ID
			$id = $this->uri->segment(3);
			
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			$this->load->model('characters_model', 'char');
			
			// get the drafts for the page
			$drafts = $this->wiki->get_drafts($id);
			
			// get the page
			$page = $this->wiki->get_page($id);
			$row = ($page->num_rows() > 0) ? $page->row() : false;
			
			// get the timezone and dst
			$timezone = (Auth::is_logged_in()) ? $this->session->userdata('timezone') : $this->settings->get_setting('timezone');
			$dst = (Auth::is_logged_in()) ? (bool) $this->session->userdata('dst') : (bool) $this->settings->get_setting('daylight_savings');
			
			if ($drafts->num_rows() > 0)
			{
				// get the settings
				$datestring = $this->settings->get_setting('date_format');
				
				foreach ($drafts->result() as $d)
				{
					$created = gmt_to_local($d->draft_created_at, $timezone, $dst);
					
					$data['drafts'][$d->draft_id] = array(
						'draft' 		=> $d->draft_id,
						'title' 		=> $d->draft_title,
						'created' 		=> ($d->draft_author_user == 0)
							? ucfirst(lang('labels_system'))
							: $this->char->get_character_name($d->draft_author_character),
						'created_date' 	=> mdate($datestring, $created),
						'page' 			=> $d->draft_page,
						'old_id' 		=> ( ! empty($d->draft_id_old)) ? $d->draft_id_old : false,
						'page_draft' 	=> ($row !== false) ? $row->page_draft : false,
					);
				}
				
				$data['label'] = array(
					'by' => lang('labels_by'),
					'created' => lang('actions_created'),
					'delete' => ucfirst(lang('actions_delete')),
					'draft' => ucfirst(lang('labels_draft')),
					'on' => lang('labels_on'),
					'page' => ucfirst(lang('labels_page')),
					'revert' => ucfirst(lang('actions_revert')),
					'reverted' => lang('actions_reverted'),
					'to' => lang('labels_to'),
				);
				
				// figure out the skin
				$skin = $this->session->userdata('skin_wiki');
				
				$view = Location::ajax('get_page_drafts', $skin, 'wiki', $data);
		
				echo $view;
			}
			else
			{
				// generate the error message
				$error = sprintf(
					lang('error_not_found'),
					lang('global_wiki').' '.lang('labels_drafts')
				);
				
				echo '<strong class="orange">'.$error.'</strong>';
			}
		}
	}
	
	public function wiki_get_page_restrictions()
	{
		if (IS_AJAX)
		{
			// get the page ID
			$id = $this->uri->segment(3);
			
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			$this->load->model('access_model', 'access');
			
			// get the access roles
			$roles = $this->access->get_roles();
			
			if ($roles->num_rows() > 0)
			{
				foreach ($roles->result() as $a)
				{
					$data['roles'][$a->role_id] = $a->role_name;
				}
			}
			
			// set up the array of checking values
			$data['checked'] = array();
			
			// get the drafts for the page
			$res = $this->wiki->get_page_restrictions($id);
			
			$data['label'] = array(
				'no_roles' => sprintf(lang('error_not_found'), lang('labels_access').' '.lang('labels_roles')),
				'roles' => ucwords(lang('actions_restrict').' '.lang('labels_access').' '.lang('labels_to').' '.
					lang('labels_these').' '.lang('labels_access').' '.lang('labels_roles')).':',
			);
			
			$data['submit'] = array(
				'id' => 'submit',
				'name' => 'submit',
				'class' => 'button-main',
				'rel' => $id,
				'content' => ucfirst(lang('actions_update')),
			);
			
			if ($res->num_rows() > 0)
			{
				// get the row
				$r = $res->row();
				
				// find out what the restrictions are
				$data['checked'] = explode(',', $r->restrictions);
			}
			
			// figure out the skin
			$skin = $this->session->userdata('skin_wiki');
			
			$data['images'] = array(
				'loading' => array(
					'src' => Location::img('loading.gif', $skin, 'wiki'),
					'alt' => ''),
				'success' => array(
					'src' => Location::img('tick-circle.png', $skin, 'wiki'),
					'alt' => ''),
				'failure' => array(
					'src' => Location::img('exclamation-red.png', $skin, 'wiki'),
					'alt' => ''),
			);
			
			$view = Location::ajax('get_page_restrictions', $skin, 'wiki', $data);
			
			echo $view;
		}
	}
	
	public function wiki_set_page_restrictions()
	{
		$allowed = Auth::check_access('wiki/page', false);
		
		if (IS_AJAX and $allowed)
		{
			// get the POST information
			$page = $this->input->post('page', true);
			$roles = $this->input->post('roles', true);
			
			// load the resources
			$this->load->model('wiki_model', 'wiki');
			
			if (is_array($roles))
			{
				// check for the existence of a record
				$exist = $this->wiki->get_page_restrictions($page);
				
				if ($exist->num_rows() > 0)
				{
					$update_array = array(
						'restr_updated_by' => $this->session->userdata('userid'),
						'restr_updated_at' => now(),
						'restrictions' => implode(',', $roles)
					);
					
					$update = $this->wiki->update_page_restriction($page, $update_array);
					
					// figure out what to send back to the browser
					$retval = ($update > 0) ? '1' : '0';
				}
				else
				{
					$insert_array = array(
						'restr_page' => $page,
						'restr_created_by' => $this->session->userdata('userid'),
						'restr_created_at' => now(),
						'restrictions' => implode(',', $roles)
					);
					
					$insert = $this->wiki->create_page_restriction($insert_array);
					
					// figure out what to send back to the browser
					$retval = ($insert > 0) ? '1' : '0';
				}
			}
			else
			{
				$delete = $this->wiki->delete_page_restriction($page);
				
				// figure out what to send back to the browser
				$retval = ($delete > 0) ? '1' : '0';
			}
			
			echo $retval;
		}
	}
}
