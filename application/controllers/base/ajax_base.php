<?php
/*
|---------------------------------------------------------------
| AJAX CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/ajax_base.php
| System Version: 1.2
|
| Changes: added method for handling deleting a ban; added method for
|	duplicating a department confirmation; added method for editing
|	a department
|
*/

class Ajax_base extends Controller {
	
	function Ajax_base()
	{
		parent::Controller();
		
		/* load the session library */
		$this->load->library('session');
	
		/* check to see if they are logged in */
		$this->auth->is_logged_in();
		
		/* set the template */
		$this->template->set_template('ajax');
		$this->template->set_master_template('_base/template_ajax.php');
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* load the system model */
		$this->load->model('system_model', 'sys');
	}

	function index()
	{
		/* nothing goes here */
	}
	
	/*
	|---------------------------------------------------------------
	| ADD METHODS
	|---------------------------------------------------------------
	*/
	
	function add_bio_field()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_bio') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_bio_field');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_bio_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_bio_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$value = $this->input->post('value', TRUE);
			$content = $this->input->post('content', TRUE);
			$field = $this->input->post('field', TRUE);
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
			
			/* optimize the table */
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_bio_sec()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$tabs = $this->char->get_bio_tabs();
		
		$data['values']['tabs'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')
			.' '. lang('order_one'));
		
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
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_bio_sec');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_bio_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_bio_tab()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_bio') .' '. lang('labels_tab'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_bio_tab');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_bio_tab', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_catalogue()
	{
		$type = $this->uri->segment(3);
		
		switch ($type)
		{
			case 'ranks':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('add_catalogue_ranks', $skin, 'admin');
				
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
						'checked' => TRUE),
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
		
				break;
				
			case 'skins':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('add_catalogue_skins', $skin, 'admin');
				
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
		
				break;
				
			case 'skinsecs':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('add_catalogue_skinsec', $skin, 'admin');
				
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
						'checked' => TRUE),
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
					foreach ($skins->result() as $skin)
					{
						$data['skins'][$skin->skin_location] = $skin->skin_name;
					}
				}
		
				break;
		}
		
		/* data being sent to the facebox */
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
		
		/* write the data to the template */
		$this->template->write_view('content', $view, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_coc_entry()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$values = $this->char->get_coc();
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->coc_order + 1;
			}
			
			$user = $this->input->post('user', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_comment_log()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_personallog') .' '. lang('labels_comment'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['log_id'] = $this->uri->segment(3, 0);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_main');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_log_comment', $skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_comment_news()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_newsitem') .' '. lang('labels_comment'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['news_id'] = $this->uri->segment(3, 0);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_main');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_news_comment', $skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_comment_post()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_missionpost') .' '. lang('labels_comment'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['post_id'] = $this->uri->segment(3, 0);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_main');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_post_comment', $skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_comment_wiki()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_wiki') .' '. lang('labels_comment'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_wiki');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_wiki_comment', $skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_deck()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$values = $this->tour->get_decks();
			
			if ($values->num_rows() > 0)
			{
				$last = $values->last_row();
				$order = $last->deck_order + 1;
			}
			
			$deck = $this->input->post('deck', TRUE);
			
			$insert_array = array(
				'deck_name' => $deck,
				'deck_order' => (isset($order)) ? $order : 0,
				'deck_content' => ''
			);
				
			$insert = $this->tour->add_deck($insert_array);
			$insert_id = $this->db->insert_id();
			
			/* optimize the table */
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_dept()
	{
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_department'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		$manifests = $this->dept->get_all_manifests(NULL);
		
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_dept', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_docking_field()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('actions_docking') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_docking_field');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_docking_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_docking_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('docking_model', 'docking');
			
			$value = $this->input->post('value', TRUE);
			$content = $this->input->post('content', TRUE);
			$field = $this->input->post('field', TRUE);
			
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
			
			/* optimize the table */
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_docking_sec()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('actions_docking') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_docking_sec');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_docking_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_menu_cat()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_menu') .' '. lang('labels_category'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_menucat');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_menu_cat', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_menu_item()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_menu'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_menu');
		$data['tab'] = $this->uri->segment(3, 0, TRUE);
		
		/* input parameters */
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
				'checked' => TRUE),
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
				'checked' => TRUE),
			'display_y' => array(
				'name' => 'menu_display',
				'id' => 'display_y',
				'class' => 'hud',
				'value' => 'y',
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_menu_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_mission()
	{
		/* load the resources */
		$this->load->model('missions_model', 'mis');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_mission'))
		);
		
		/* data being sent to the facebox */
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
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_mission_simple', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_mission_action()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('missions_model', 'mis');
			
			$option = $this->input->post('option', TRUE);
			
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
					'mission_title' => $this->input->post('title', TRUE),
					'mission_desc' => $this->input->post('desc', TRUE),
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
	
	function add_position()
	{
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_position'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['g_dept'] = $this->uri->segment(3, 1, TRUE);
		
		/* input parameters */
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
				'checked' => TRUE),
			'display_n' => array(
				'name' => 'pos_display',
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
			'order' => ucfirst(lang('labels_order'))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_position', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_rank()
	{
		$this->load->model('ranks_model', 'ranks');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_rank'))
		);
		
		$data['set'] = $this->uri->segment(3, 'default');
		$data['class'] = $this->uri->segment(4, 1, TRUE);
		
		$data['ext'] = $this->ranks->get_rankcat($data['set'], 'rankcat_id', 'rankcat_extension');
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_rank');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_rank', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_role_group()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_role_group');
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_role_group', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_role_page()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_role') .' '. lang('labels_page'))
		);
		
		/* data being sent to the facebox */
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
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_role_page', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_site_message()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('labels_site') .' '. lang('labels_message'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_site_message');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_site_message', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_spec_field()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_specifications') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_spec_field');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_spec_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_spec_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			$value = $this->input->post('value', TRUE);
			$content = $this->input->post('content', TRUE);
			$field = $this->input->post('field', TRUE);
			
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
			
			/* optimize the table */
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_spec_sec()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_specifications') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_spec_sec');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_spec_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_tour_field()
	{
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_add')),
			ucwords(lang('global_tour') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_tour_field');
		
		/* input parameters */
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
				'checked' => TRUE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_tour_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function add_tour_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$value = $this->input->post('value', TRUE);
			$content = $this->input->post('content', TRUE);
			$field = $this->input->post('field', TRUE);
			
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
			
			/* optimize the table */
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function add_user_setting()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_create')),
			ucwords(lang('labels_site') .' '. lang('labels_setting'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = lang('fbx_content_add_user_setting');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('add_user_setting', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function approve()
	{
		$data['type'] = $this->uri->segment(3, FALSE);
		$data['id'] = $this->uri->segment(4, 0, TRUE);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$view = ajax_location('approve', $skin, 'admin');
		
		switch ($data['type'])
		{
			case 'posts':
				$this->load->model('posts_model', 'posts');
				$this->load->model('characters_model', 'char');
				
				$type = lang('global_missionpost');
				
				/* grab the post info */
				$item = $this->posts->get_post($data['id']);
				
				$data['text'] = sprintf(
					lang('fbx_content_approve_entry'),
					lang('global_missionpost'),
					$item->post_title,
					' '. lang('labels_by') .' '.
						$this->char->get_authors($item->post_authors, TRUE)
				);
				
				$data['form'] = 'manage/posts/pending/0/approve';
				
				break;
				
			case 'logs':
				$this->load->model('personallogs_model', 'logs');
				$this->load->model('characters_model', 'char');
				
				$type = lang('global_personallog');
				
				/* grab the log info */
				$item = $this->logs->get_log($data['id']);
				
				$data['text'] = sprintf(
					lang('fbx_content_approve_entry'),
					lang('global_personallog'),
					$item->log_title,
					' '. lang('labels_by') .' '.
						$this->char->get_character_name($item->log_author_character, TRUE)
				);
				
				$data['form'] = 'manage/logs/pending/0/approve';
				
				break;
				
			case 'news':
				$this->load->model('news_model', 'news');
				$this->load->model('characters_model', 'char');
				
				$type = lang('global_newsitem');
				
				/* grab the news item info */
				$item = $this->news->get_news_item($data['id']);
				
				$data['text'] = sprintf(
					lang('fbx_content_approve_entry'),
					lang('global_newsitem'),
					$item->news_title,
					' '. lang('labels_by') .' '.
						$this->char->get_character_name($item->news_author_character, TRUE)
				);
				
				$data['form'] = 'manage/news/pending/0/approve';
				
				break;
				
			case 'posts_comment':
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
						$this->char->get_character_name($item['pcomment_author_character'], TRUE)
				);
				
				$data['form'] = 'manage/comments/posts/activated/0/approve';
				
				break;
				
			case 'logs_comment':
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
						$this->char->get_character_name($item['lcomment_author_character'], TRUE)
				);
				
				$data['form'] = 'manage/comments/logs/activated/0/approve';
				
				break;
				
			case 'news_comment':
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
						$this->char->get_character_name($item['ncomment_author_character'], TRUE)
				);
				
				$data['form'] = 'manage/comments/news/activated/0/approve';
				
				break;
				
			case 'wiki_comment':
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
							$this->char->get_character_name($item['wcomment_author_character'], TRUE)
					);
				}
				
				$data['form'] = 'manage/comments/wiki/activated/0/approve';
				
				break;
				
			case 'award_nomination':
				/* load the resources */
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
					$name = $this->char->get_character_name($nom->queue_receive_character, TRUE);
				}
				
				$data['text'] = sprintf(
					lang('fbx_content_approve_entry'),
					$type .' '. lang('labels_for'),
					$name,
					''
				);
				
				$data['form'] = 'user/nominate/queue';
				
				/* figure out where the view should come from */
				$view = ajax_location('approve_awardnom', $skin, 'admin');
				
				break;
				
			case 'character':
				$this->load->model('characters_model', 'char');
				$this->load->model('users_model', 'user');
				$this->load->model('access_model', 'access');
				
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
				
				/* figure out where the view should come from */
				$view = ajax_location('approve_character', $skin, 'admin');
				
				break;
				
			case 'docking':
				$this->load->model('docking_model', 'docking');
				
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
				
				/* figure out where the view should come from */
				$view = ajax_location('approve_docking', $skin, 'admin');
				
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* write the data to the template */
		$this->template->write_view('content', $view, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	/*
	|---------------------------------------------------------------
	| DELETE METHODS
	|---------------------------------------------------------------
	*/
	
	function change_password()
	{
		/* data being sent to the facebox */
		$data['header'] = ucwords(lang('actions_change') .' '. lang('labels_password'));
		$data['text'] = lang('fbx_change_password_text');
		$data['user'] = $this->uri->segment(3, 0);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('change_password', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_award()
	{
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_award'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->awards->get_award($data['id'], 'award_name');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_award'),
			$item
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_award', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_bio_field()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_bio') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$field = $this->char->get_bio_field_details($data['id']);
		
		$item = ($field->num_rows() > 0) ? $field->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_bio_field'),
			$item->field_label_page
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_bio_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_bio_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_bio_sec()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_bio') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$sec = $this->char->get_bio_section_details($data['id']);
		$sections = $this->char->get_bio_sections();
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
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
					/* do nothing */
				}
				else
				{
					$data['values']['sections'][$s->section_id] = $s->section_name;
				}
			}
		}
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_bio_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_bio_tab()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_bio') .' '. lang('labels_tab'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$tab = $this->char->get_bio_tab_details($data['id']);
		$tabs = $this->char->get_bio_tabs();
		
		$item = ($tab->num_rows() > 0) ? $tab->row() : FALSE;
		
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
					/* do nothing */
				}
				else
				{
					$data['values']['tabs'][$t->tab_id] = $t->tab_name;
				}
			}
		}
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_bio_tab', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_ban()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_ban'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->sys->get_ban($data['id']);
		$descriptor = (empty($item->ban_email)) ? $item->ban_ip : $item->ban_email;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('labels_ban') .' '. lang('labels_on'),
			$descriptor
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_ban', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_catalogue()
	{
		$type = $this->uri->segment(3);
		$data['id'] = $this->uri->segment(4, 0, TRUE);
		
		/* load the resources */
		$this->load->model('ranks_model', 'ranks');
		
		switch ($type)
		{
			case 'ranks':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('del_catalogue_ranks', $skin, 'admin');
				
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
				
				break;
				
			case 'skins':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('del_catalogue_skins', $skin, 'admin');
				
				$item = $this->sys->get_skin_info($data['id'], 'skin_id');
				
				$head = sprintf(
					lang('fbx_head'),
					ucwords(lang('actions_delete')),
					ucwords(lang('labels_skin'))
				);
				
				$data['text'] = sprintf(
					lang('fbx_content_del_catalogue_skin'),
					$item->skin_name
				);
				
				$data['inputs'] = array(
					'submit' => array(
						'type' => 'submit',
						'class' => 'hud_button',
						'name' => 'submit',
						'value' => 'submit',
						'content' => ucwords(lang('actions_submit')))
				);
				
				break;
				
			case 'skinsecs':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('del_catalogue_skinsec', $skin, 'admin');
				
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
				
				break;
		}
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		
		/* write the data to the template */
		$this->template->write_view('content', $view, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_character()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		$this->load->helper('utility');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_character'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_character', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_character_award()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('awards_model', 'awards');
			
			$id = $this->input->post('award', TRUE);
			
			$delete = $this->awards->delete_received_award($id);
			
			echo '';
		}
	}
	
	function del_character_image()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			$images = $this->char->get_character($id, 'images');
			
			if (!empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key !== FALSE)
				{
					unset($imagesArray[$key]);
					$imageStr = implode(',', $imagesArray);
					
					$this->char->update_character($id, array('images' => $imageStr));
				}
			}
		}
	}
	
	function del_coc()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$id = (is_numeric($this->input->post('coc'))) ? $this->input->post('coc', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_comment()
	{
		$data['type'] = $this->uri->segment(3, FALSE);
		$data['status'] = $this->uri->segment(4, FALSE);
		$data['page'] = $this->uri->segment(5, 0, TRUE);
		$data['id'] = $this->uri->segment(6, 0, TRUE);
		
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
					$item = FALSE;
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_comment', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_deck()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$id = (is_numeric($this->input->post('deck'))) ? $this->input->post('deck', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_dept()
	{
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_department'))
		);
		
		/* set the id */
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		/* grab the departments */
		$depts = $this->dept->get_all_depts();
		
		/* grab the department details */
		$subs = $this->dept->get_sub_depts($data['id'], 'asc', '');
		
		$data['dept_count'] = $depts->num_rows();
		$data['sub_count'] = $subs->num_rows();
		
		/* data being sent to the facebox */
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
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_dept', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_docked_item()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('actions_docked') .' '. lang('labels_item'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->docking->get_docked_item($data['id']);
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('actions_docked') .' '. lang('labels_item'),
			$item->docking_sim_name
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_docked_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_docking_field()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('actions_docking') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$field = $this->docking->get_docking_field_details($data['id']);
		
		$item = ($field->num_rows() > 0) ? $field->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_docking_field'),
			$item->field_label_page
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_docking_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_docking_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('docking_model', 'docking');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_docking_sec()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('actions_docking') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$sec = $this->docking->get_docking_section_details($data['id']);
		$sections = $this->docking->get_docking_sections();
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
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
					/* do nothing */
				}
				else
				{
					$data['values']['sections'][$s->section_id] = $s->section_name;
				}
			}
		}
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_docking_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_log()
	{
		/* load the resources */
		$this->load->model('personallogs_model', 'logs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_personallog'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['status'] = $this->uri->segment(3, 'activated');
		$data['page'] = $this->uri->segment(4, 0, TRUE);
		$data['id'] = $this->uri->segment(5, 0, TRUE);
		
		$item = $this->logs->get_log($data['id'], 'log_title');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_personallog'),
			$item
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_log', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_manifest()
	{
		// load the resources
		$this->load->model('depts_model', 'dept');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_manifest'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->dept->get_manifest($data['id'], 'manifest_name');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('labels_manifest'),
			$item
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_manifest', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_menu_cat()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_menu') .' '. lang('labels_category'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$cat = $this->menu_model->get_menu_category($data['id'], 'menucat_id');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_menucat'),
			$cat->menucat_name
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_menu_cat', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_menu_item()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_menu'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		$data['tab'] = $this->uri->segment(4, 0, TRUE);
		
		$menu = $this->menu_model->get_menu_item($data['id']);
		
		$item = ($menu->num_rows() > 0) ? $menu->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_menu'),
			$item->menu_name
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_menu_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_mission()
	{
		/* load the resources */
		$this->load->model('missions_model', 'mis');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_mission'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->mis->get_mission($data['id'], array('mission_title', 'mission_status'));
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_mission'),
			$item['mission_title']
		);
		
		$data['form'] = $item['mission_status'];
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_mission', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_mission_image()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('missions_model', 'mis');
			
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			$images = $this->mis->get_mission($id, 'mission_images');
			
			if (!empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key !== FALSE)
				{
					unset($imagesArray[$key]);
					$imageStr = implode(',', $imagesArray);
					
					$this->mis->update_mission($id, array('mission_images' => $imageStr));
				}
			}
		}
	}
	
	function del_news()
	{
		/* load the resources */
		$this->load->model('news_model', 'news');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_newsitem'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['status'] = $this->uri->segment(3, 'activated');
		$data['page'] = $this->uri->segment(4, 0, TRUE);
		$data['id'] = $this->uri->segment(5, 0, TRUE);
		
		$item = $this->news->get_news_item($data['id'], 'news_title');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_newsitem'),
			$item
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_news', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_npc()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		$this->load->helper('utility');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('abbr_npc'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_npc', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	
	
	function del_post()
	{
		/* load the resources */
		$this->load->model('posts_model', 'posts');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_missionpost'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['status'] = $this->uri->segment(3, 'activated');
		$data['page'] = $this->uri->segment(4, 0, TRUE);
		$data['id'] = $this->uri->segment(5, 0, TRUE);
		$data['refer'] = $this->uri->segment(6, 'posts');
		
		$item = $this->posts->get_post($data['id'], 'post_title');
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_missionpost'),
			$item
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_post', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_role()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_role'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
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
					/* do nothing */
				}
				else
				{
					$data['values']['roles'][$r->role_id] = $r->role_name;
				}
			}
		}
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_role', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_role_group()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_role_group', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_role_page()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_role') .' '. lang('labels_page'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		$data['text'] = sprintf(
			lang('fbx_content_del_role_page'),
			$this->access->get_page($data['id'], 'page_name')
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_role_page', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_site_message()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_site') .' '. lang('labels_message'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		$data['text'] = sprintf(
			lang('fbx_content_del_site_message'),
			$this->msgs->get_message_label($data['id'])
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_site_message', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_spec_field()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_specifications') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$field = $this->specs->get_spec_field_details($data['id']);
		
		$item = ($field->num_rows() > 0) ? $field->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_specs_field'),
			$item->field_label_page
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_spec_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_spec_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_spec_image()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			$item = $this->specs->get_spec_item($id);
			
			if ($item !== FALSE)
			{
				$images = $item->specs_images;
				
				if (!empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key !== FALSE)
					{
						unset($imagesArray[$key]);
						$imageStr = implode(',', $imagesArray);
						
						$this->specs->update_spec_item($id, array('specs_images' => $imageStr));
					}
				}
			}
		}
	}
	
	function del_spec_item()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_specification') .' '. lang('labels_item'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->specs->get_spec_item($data['id']);
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_specification') .' '. lang('labels_item'),
			$item->specs_name
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_spec_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_spec_sec()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_specifications') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$sec = $this->specs->get_spec_section_details($data['id']);
		$sections = $this->specs->get_spec_sections();
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
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
					/* do nothing */
				}
				else
				{
					$data['values']['sections'][$s->section_id] = $s->section_name;
				}
			}
		}
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_spec_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_tour_field()
	{
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_tour') .' '. lang('labels_field'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$field = $this->tour->get_tour_field_details($data['id']);
		
		$item = ($field->num_rows() > 0) ? $field->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_tour_field'),
			$item->field_label_page
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_tour_field', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_tour_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$id = (is_numeric($this->input->post('field'))) ? $this->input->post('field', TRUE) : 0;
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function del_tour_image()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			$tour = $this->tour->get_tour_item($id);
			
			if ($tour->num_rows() > 0)
			{
				$item = $tour->row();
				
				$images = $item->tour_images;
				
				if (!empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key !== FALSE)
					{
						unset($imagesArray[$key]);
						$imageStr = implode(',', $imagesArray);
						
						$this->tour->update_tour_item($id, array('tour_images' => $imageStr));
					}
				}
			}
		}
	}
	
	function del_tour_item()
	{
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_touritem'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$field = $this->tour->get_tour_item($data['id']);
		
		$item = ($field->num_rows() > 0) ? $field->row() : FALSE;
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_touritem'),
			$item->tour_name
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_tour_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_user()
	{
		/* load the resources */
		$this->load->model('users_model', 'user');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_user'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->user->get_user($data['id']);
		
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_user'),
			(!empty($item->name)) ? $item->name : $item->email
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_user', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_user_setting()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('labels_site') .' '. lang('labels_setting'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		$data['text'] = sprintf(
			lang('fbx_content_del_user_setting'),
			$this->settings->get_setting_label($data['id'], 'setting_id')
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_user_setting', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_wiki_category()
	{
		/* load the resources */
		$this->load->model('wiki_model', 'wiki');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_wiki') .' '. lang('labels_category'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		$data['text'] = sprintf(
			lang('fbx_content_del_entry'),
			lang('global_wiki') .' '. lang('labels_category'),
			$this->wiki->get_category($data['id'], 'wikicat_name')
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_wiki');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_wiki_category', $skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function del_wiki_page()
	{
		/* load the resources */
		$this->load->model('wiki_model', 'wiki');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_delete')),
			ucwords(lang('global_wiki') .' '. lang('labels_page'))
		);
		
		/* data being sent to the facebox */
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_wiki');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('del_wiki_page', $skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function duplicate_dept()
	{
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_duplicate')),
			ucwords(lang('global_department'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['text'] = sprintf(
			lang('text_duplicate_dept'),
			$this->dept->get_dept($data['id'], 'dept_name'),
			lang('global_department'),
			lang('global_department'),
			lang('global_positions'),
			ucwords(lang('actions_submit'))
		);
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('dup_dept', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function duplicate_role()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_duplicate')),
			ucwords(lang('labels_role'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('dup_role', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	/*
	|---------------------------------------------------------------
	| EDIT METHODS
	|---------------------------------------------------------------
	*/
	
	function edit_bio_field_value()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_value'))
		);
		
		/* data being sent to the facebox */
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
		
		$item = ($value->num_rows() > 0) ? $value->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_bio_field_value', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_bio_sec()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_bio') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$tabs = $this->char->get_bio_tabs();
		$sec = $this->char->get_bio_section_details($data['id']);
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
		$data['values']['tabs'][0] = ucwords(lang('labels_please') .' '. lang('actions_choose')
			.' '. lang('order_one'));
		
		if ($tabs->num_rows() > 0)
		{
			foreach ($tabs->result() as $t)
			{
				$data['values']['tabs'][$t->tab_id] = $t->tab_name;
			}
		}
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_bio_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_bio_tab()
	{
		/* load the resources */
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_bio') .' '. lang('labels_tab'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$tab = $this->char->get_bio_tab_details($data['id']);
		
		$item = ($tab->num_rows() > 0) ? $tab->row() : FALSE;
		
		/* input parameters */
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
				'checked' => ($item->tab_display == 'y') ? TRUE : FALSE),
			'display_n' => array(
				'name' => 'tab_display',
				'id' => 'tab_display_n',
				'value' => 'n',
				'checked' => ($item->tab_display == 'n') ? TRUE : FALSE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_bio_tab', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_catalogue()
	{
		$type = $this->uri->segment(3);
		$data['id'] = $this->uri->segment(4, 0, TRUE);
		
		/* load the resources */
		$this->load->model('ranks_model', 'ranks');
		
		switch ($type)
		{
			case 'ranks':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('edit_catalogue_ranks', $skin, 'admin');
				
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
						'checked' => ($item->rankcat_default == 'y') ? TRUE : FALSE),
					'default_n' => array(
						'name' => 'rank_default',
						'id' => 'rank_default_n',
						'value' => 'n',
						'checked' => ($item->rankcat_default == 'n') ? TRUE : FALSE),
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
		
				break;
				
			case 'skins':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('edit_catalogue_skins', $skin, 'admin');
				
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
		
				break;
				
			case 'skinsecs':
				/* figure out the skin */
				$skin = $this->session->userdata('skin_admin');
				
				/* figure out where the view should come from */
				$view = ajax_location('edit_catalogue_skinsec', $skin, 'admin');
				
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
						'checked' => ($item->skinsec_default == 'y') ? TRUE : FALSE),
					'default_n' => array(
						'name' => 'default',
						'id' => 'skin_default_n',
						'value' => 'n',
						'checked' => ($item->skinsec_default == 'n') ? TRUE : FALSE),
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
		
				break;
		}
		
		/* data being sent to the facebox */
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
		
		/* write the data to the template */
		$this->template->write_view('content', $view, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_comment()
	{
		$data['type'] = $this->uri->segment(3, FALSE);
		$data['status'] = $this->uri->segment(4, FALSE);
		$data['page'] = $this->uri->segment(5, 0, TRUE);
		$data['id'] = $this->uri->segment(6, 0, TRUE);
		
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
					'author' => $this->char->get_character_name($item['pcomment_author_character'], TRUE)
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
					'author' => $this->char->get_character_name($item['lcomment_author_character'], TRUE)
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
					'author' => $this->char->get_character_name($item['ncomment_author_character'], TRUE)
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
					'author' => $this->char->get_character_name($item['wcomment_author_character'], TRUE)
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
		
		/* input parameters */
		$data['inputs'] += array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_comment', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_deck()
	{
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_deck'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$item = $this->tour->get_deck_details($data['id']);
		
		/* input parameters */
		$data['inputs'] = array(
			'name' => array(
				'name' => 'deck_name',
				'class' => 'hud',
				'value' => $item->deck_name),
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
		
		$data['label'] = array(
			'content' => ucfirst(lang('labels_content')),
			'name' => ucfirst(lang('labels_name')),
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_deck', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_dept()
	{
		/* load the resources */
		$this->load->model('depts_model', 'dept');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_department'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		// get the department information
		$dept = $this->dept->get_dept($data['id']);
		
		/* input parameters */
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
				'checked' => ($dept->dept_display == 'y') ? TRUE : FALSE),
			'display_n' => array(
				'name' => 'dept_display',
				'id' => 'display_n',
				'class' => 'hud',
				'value' => 'n',
				'checked' => ($dept->dept_display == 'n') ? TRUE : FALSE),
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
		
		$manifests = $this->dept->get_all_manifests(NULL);
		
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_dept', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_docking_field_value()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('actions_docking') .' '. lang('labels_field') .' '. lang('labels_value'))
		);
		
		/* data being sent to the facebox */
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
		
		$item = ($value->num_rows() > 0) ? $value->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_docking_field_value', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_docking_sec()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('actions_docking') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$sec = $this->docking->get_docking_section_details($data['id']);
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_docking_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_manifest()
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
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
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
				'checked' => ($item->manifest_display == 'y') ? TRUE : FALSE),
			'display_n' => array(
				'name' => 'manifest_display',
				'id' => 'display_n',
				'class' => 'hud',
				'value' => 'n',
				'checked' => ($item->manifest_display == 'n') ? TRUE : FALSE),
			'default_y' => array(
				'name' => 'manifest_default',
				'id' => 'default_y',
				'class' => 'hud',
				'value' => 'y',
				'checked' => ($item->manifest_default == 'y') ? TRUE : FALSE),
			'default_n' => array(
				'name' => 'manifest_default',
				'id' => 'default_n',
				'class' => 'hud',
				'value' => 'n',
				'checked' => ($item->manifest_default == 'n') ? TRUE : FALSE),
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))),
		);
		
		$data['label'] = array(
			'default' => ucwords(lang('labels_default').' '.lang('labels_manifest')),
			'desc' => ucfirst(lang('labels_desc')),
			'display' => ucfirst(lang('labels_display')),
			'header' => ucwords(lang('labels_header').' '.lang('labels_content')),
			'name' => ucwords(lang('labels_manifest').' '.lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'off' => ucfirst(lang('labels_off')),
			'on' => ucfirst(lang('labels_on')),
			'order' => ucfirst(lang('labels_order')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_manifest', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_menu_cat()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_menu') .' '. lang('labels_category'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$item = $this->menu_model->get_menu_category($data['id'], 'menucat_id');
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_menu_cat', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_menu_item()
	{
		/* load the resources */
		$this->load->model('menu_model');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_menu'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		$data['tab'] = $this->uri->segment(4, 0, TRUE);
		
		$menu = $this->menu_model->get_menu_item($data['id']);
		
		$item = ($menu->num_rows() > 0) ? $menu->row() : FALSE;
		
		/* input parameters */
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
				'checked' => ($item->menu_link_type == 'onsite') ? TRUE : FALSE),
			'link_type_off' => array(
				'name' => 'menu_link_type',
				'id' => 'link_type_off',
				'class' => 'hud',
				'value' => 'offsite',
				'checked' => ($item->menu_link_type == 'offsite') ? TRUE : FALSE),
			'use_access_y' => array(
				'name' => 'menu_use_access',
				'id' => 'use_access_y',
				'class' => 'hud',
				'value' => 'y',
				'checked' => ($item->menu_use_access == 'y') ? TRUE : FALSE),
			'use_access_n' => array(
				'name' => 'menu_use_access',
				'id' => 'use_access_n',
				'class' => 'hud',
				'value' => 'n',
				'checked' => ($item->menu_use_access == 'n') ? TRUE : FALSE),
			'display_y' => array(
				'name' => 'menu_display',
				'id' => 'display_y',
				'class' => 'hud',
				'value' => 'y',
				'checked' => ($item->menu_display == 'y') ? TRUE : FALSE),
			'display_n' => array(
				'name' => 'menu_display',
				'id' => 'display_n',
				'class' => 'hud',
				'value' => 'n',
				'checked' => ($item->menu_display == 'n') ? TRUE : FALSE),
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_menu_item', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_role_group()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$group = $this->access->get_group($data['id']);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_role_group', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_role_page()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_role') .' '. lang('labels_page'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
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
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_role_page', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_site_message()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_site') .' '. lang('labels_message'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		/* get the message */
		$message = $this->msgs->get_message_details($data['id'], 'id');
		
		if ($message->num_rows() > 0)
		{
			$row = $message->row();
			
			/* input parameters */
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
			}
		}
		
		$data['label'] = array(
			'content' => ucfirst(lang('labels_content')),
			'key' => ucwords(lang('labels_message') .' '. lang('labels_key')),
			'label' => ucwords(lang('labels_message') .' '. lang('labels_label')),
			'type' => ucfirst(lang('labels_type')),
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_site_message', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_spec_field_value()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_specifications') .' '. lang('labels_field') .' '. lang('labels_value'))
		);
		
		/* data being sent to the facebox */
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
		
		$item = ($value->num_rows() > 0) ? $value->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_spec_field_value', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_spec_sec()
	{
		/* load the resources */
		$this->load->model('specs_model', 'specs');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_specifications') .' '. lang('labels_section'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		$sec = $this->specs->get_spec_section_details($data['id']);
		
		$item = ($sec->num_rows() > 0) ? $sec->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_spec_sec', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_tour_field_value()
	{
		/* load the resources */
		$this->load->model('tour_model', 'tour');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_tour') .' '. lang('labels_field') .' '. lang('labels_value'))
		);
		
		/* data being sent to the facebox */
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
		
		$item = ($value->num_rows() > 0) ? $value->row() : FALSE;
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_tour_field_value', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_user_setting()
	{
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('labels_site') .' '. lang('labels_setting'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		/* get the message */
		$setting = $this->settings->get_setting_details($data['id'], 'setting_id');
		
		if ($setting->num_rows() > 0)
		{
			$row = $setting->row();
			
			/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_user_setting', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function edit_wiki_category()
	{
		/* load the resources */
		$this->load->model('wiki_model', 'wiki');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_edit')),
			ucwords(lang('global_wiki') .' '. lang('labels_category'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = (is_numeric($this->uri->segment(3))) ? $this->uri->segment(3) : 0;
		
		/* get the message */
		$cat = $this->wiki->get_category($data['id']);
		
		/* input parameters */
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
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_wiki');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('edit_wiki_category', $skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	/*
	|---------------------------------------------------------------
	| INFO METHODS
	|---------------------------------------------------------------
	*/
	
	function info_format_date()
	{
		$format = $this->input->post('format', TRUE);
		
		echo mdate($format, now());
	}
	
	function info_users_with_role()
	{
		/* load the resources */
		$this->load->model('access_model', 'access');
		$this->load->model('characters_model', 'char');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('labels_info') .' '. NDASH .' '),
			ucwords(lang('fbx_item_users_role'))
		);
		
		/* data being sent to the facebox */
		$data['header'] = $head;
		$data['id'] = $this->uri->segment(3, 0, TRUE);
		
		$role = $this->access->get_role($data['id']);
		
		$data['text'] = sprintf(
			lang('fbx_content_info_users_with_role'),
			$role->role_name
		);
		
		$users = $this->access->get_users_with_role($data['id']);
		
		if (is_array($users))
		{
			foreach ($users as $p)
			{
				$data['list'][] = $this->char->get_character_name($p, TRUE);
			}
		}
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('info_users_with_role', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function info_show_award_desc()
	{
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		
		/* set the POST variable */
		$award = $this->input->post('award', TRUE);
		
		/* grab the position details */
		$item = $this->awards->get_award($award, 'award_desc');
		
		/* set the output */
		$output = ($item !== FALSE) ? $item : '';
		
		echo text_output($output, '');
	}
	
	function info_show_characters_by_award()
	{
		/* load the resources */
		$this->load->model('awards_model', 'awards');
		$this->load->model('characters_model', 'char');
		
		/* set the POST variable */
		$award = $this->input->post('award', TRUE);
		
		$type = $this->awards->get_award($award, 'award_cat');
		
		if ($type !== FALSE)
		{
			switch ($type)
			{
				case 'ic':
					$chars = 'user_npc';
					break;
					
				default:
					$chars = 'active';
			}
			
			echo form_dropdown_characters('character', '', '', $chars);
		}
		
		echo '';
	}
	
	function info_show_position_desc()
	{
		/* load the resources */
		$this->load->model('positions_model', 'pos');
		
		/* set the POST variable */
		$position = $this->input->post('position', TRUE);
		
		/* grab the position details */
		$item = $this->pos->get_position($position, 'pos_desc');
		
		/* set the output */
		$output = ($item !== FALSE) ? $item : '';
		
		echo text_output($output, '');
	}
	
	function info_show_rank_img()
	{
		/* load the resources */
		$this->load->model('ranks_model', 'rank');
		
		/* set the POST variable */
		$rank = $this->input->post('rank', TRUE);
		$location = $this->input->post('location', TRUE);
		
		/* grab the position details */
		$item = $this->rank->get_rank($rank, 'rank_image');
		$ext = $this->rank->get_rankcat($location, 'rankcat_location', 'rankcat_extension');
		
		/* set the output */
		$output = ($item !== FALSE) ? array('src' => base_url() . rank_location($location, $item, $ext)) : '';
		
		echo img($output);
	}
	
	function info_show_rank_preview_img()
	{
		/* load the resources */
		$this->load->model('ranks_model', 'rank');
		
		/* set the POST variable */
		$rank = $this->input->post('rank', TRUE);
		
		/* grab the position details */
		$preview = $this->rank->get_rankcat($rank, 'rankcat_location', 'rankcat_preview');
		
		/* set the output */
		$output = ($preview !== FALSE) ? array('src' => base_url() . rank_location($rank, $preview, '')) : '';
		
		echo img($output);
	}
	
	function info_show_skin_preview_image()
	{
		/* set the POST variables */
		$location = $this->input->post('skin', TRUE);
		$section = $this->input->post('section', TRUE);
		
		$where = array(
			'skinsec_section' => $section,
			'skinsec_skin' => $location
		);
		
		/* grab the position details */
		$item = $this->sys->get_skinsec($where);
		
		/* set the output */
		$output = ($item !== FALSE) ? base_url() . APPFOLDER .'/views/'. $location .'/'. $item->skinsec_image_preview : '';
		
		echo $output;
	}
	
	function info_show_skin_preview()
	{
		/* set the POST variables */
		$location = $this->input->post('skin', TRUE);
		$section = $this->input->post('section', TRUE);
		
		$where = array(
			'skinsec_section' => $section,
			'skinsec_skin' => $location
		);
		
		/* grab the position details */
		$item = $this->sys->get_skinsec($where);
		
		/* set the output */
		$output = ($item !== FALSE) ? array('src' => base_url() . APPFOLDER .'/views/'. $location .'/'. $item->skinsec_image_preview) : '';
		
		echo img($output);
	}
	
	function info_show_wiki_categories()
	{
		$this->load->model('wiki_model', 'wiki');
		
		if (!function_exists('json_encode'))
		{
			$this->load->library('Services_json');
		}
		
		/* set the empty arrays */
		$response = array();
		$names = array();
		
		/* grab the categories */
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
	
	function reject()
	{
		$data['type'] = $this->uri->segment(3, FALSE);
		$data['id'] = $this->uri->segment(4, 0, TRUE);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$view = ajax_location('reject', $skin, 'admin');
		
		/* input parameters */
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
				/* load the resources */
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
					$name = $this->char->get_character_name($nom->queue_receive_character, TRUE);
				}
				
				$data['text'] = sprintf(
					lang('fbx_content_del_entry'),
					$type .' '. lang('labels_for'),
					$name
				);
				
				$data['form'] = 'user/nominate/queue';
				
				/* figure out where the view should come from */
				$view = ajax_location('reject_awardnom', $skin, 'admin');
				
				break;
				
			case 'character':
				$type = lang('global_character');
				
				/* input parameters */
				$data['inputs'] += array(
					'email' => array(
						'name' => 'reject',
						'id' => 'reject',
						'class' => 'hud',
						'value' => $this->msgs->get_message('reject_message')),
				);
				
				$data['form'] = 'characters/index/pending/'. $data['id'];
				
				break;
				
			case 'docking':
				$this->load->model('docking_model', 'docking');
				
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
				
				/* figure out where the view should come from */
				$view = ajax_location('reject_docking', $skin, 'admin');
				
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
		
		/* write the data to the template */
		$this->template->write_view('content', $view, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function revert_wiki_page()
	{
		/* load the resources */
		$this->load->model('wiki_model', 'wiki');
		
		$head = sprintf(
			lang('fbx_head'),
			ucwords(lang('actions_revert')),
			ucwords(lang('global_wiki') .' '. lang('labels_page'))
		);
		
		/* data being sent to the facebox */
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
		
		/* input parameters */
		$data['inputs'] = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'hud_button',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit')))
		);
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_wiki');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('revert_wiki_page', $skin, 'wiki');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	/*
	|---------------------------------------------------------------
	| SAVE METHODS
	|---------------------------------------------------------------
	*/
	
	function save_character_image()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			/* get the images */
			$images = $this->char->get_character($id, 'images');
			
			if (!empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key === FALSE)
				{
					/* add the image to the array */
					$imagesArray[] = $image;
					
					/* make the array a string */
					$imagesStr = implode(',', $imagesArray);
					
					/* fire the character update event */
					$this->char->update_character($id, array('images' => $imagesStr));
					
					$array = array(
						'src' => base_url() . asset_location('images/characters', $image),
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
				/* add the image to the array */
				$imagesArray[] = $image;
				
				/* make the array a string */
				$imagesStr = implode(',', $imagesArray);
				
				/* fire the character update event */
				$this->char->update_character($id, array('images' => $imagesStr));
				
				$array = array(
					'src' => base_url() . asset_location('images/characters', $image),
					'height' => 140
				);
				
				echo img($array);
			}
		}
	}
	
	function save_character_images()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$images = $this->input->post('img', TRUE);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			/* fire the character update event */
			$this->char->update_character($id, array('images' => $imageStr));
		}
	}
	
	function save_coc()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$coc = $this->input->post('coc', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_bio_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('characters_model', 'char');
			
			$post = $this->input->post('value', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_deck()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$post = $this->input->post('decks', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_dept_manifest()
	{
		if (IS_AJAX)
		{
			// load the resources
			$this->load->model('depts_model', 'dept');
			
			// set the variables
			$manifest = $this->input->post('manifest', TRUE);
			$dept = $this->input->post('dept', TRUE);
			
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
	
	function save_docking_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('docking_model', 'docking');
			
			$post = $this->input->post('value', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_ignore_update_version()
	{
		/* grab the version from the POST */
		$version = $this->input->post('version', TRUE);
		
		/* build the array used by AR */
		$update = array('sys_version_ignore' => $version);
		
		/* do the update */
		$this->sys->update_system_info($update);
	}
	
	function save_mission_image()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			/* load the resources */
			$this->load->model('missions_model', 'mis');
			
			/* get the images */
			$images = $this->mis->get_mission($id, 'mission_images');
			
			if (!empty($images))
			{
				$imagesArray = explode(',', $images);
				
				$key = array_search($image, $imagesArray);
				
				if ($key === FALSE)
				{
					/* add the image to the array */
					$imagesArray[] = $image;
					
					/* make the array a string */
					$imagesStr = implode(',', $imagesArray);
					
					/* fire the character update event */
					$this->mis->update_mission($id, array('mission_images' => $imagesStr));
					
					$array = array(
						'src' => base_url() . asset_location('images/missions', $image),
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
				/* add the image to the array */
				$imagesArray[] = $image;
				
				/* make the array a string */
				$imagesStr = implode(',', $imagesArray);
				
				/* fire the character update event */
				$this->mis->update_mission($id, array('mission_images' => $imagesStr));
				
				$array = array(
					'src' => base_url() . asset_location('images/missions', $image),
					'width' => 130
				);
				
				echo img($array);
			}
		}
	}
	
	function save_mission_images()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$images = $this->input->post('img', TRUE);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			/* load the resources */
			$this->load->model('missions_model', 'mis');
			
			/* fire the character update event */
			$this->mis->update_mission($id, array('mission_images' => $imageStr));
		}
	}
	
	function save_spec_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			$post = $this->input->post('value', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_spec_image()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			/* get the images */
			$item = $this->specs->get_spec_item($id);
			
			if ($item !== FALSE)
			{
				$images = $item->specs_images;
				
				if (!empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key === FALSE)
					{
						/* add the image to the array */
						$imagesArray[] = $image;
						
						/* make the array a string */
						$imagesStr = implode(',', $imagesArray);
						
						/* fire the character update event */
						$this->specs->update_spec_item($id, array('specs_images' => $imagesStr));
						
						$array = array(
							'src' => base_url() . asset_location('images/specs', $image),
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
					/* add the image to the array */
					$imagesArray[] = $image;
					
					/* make the array a string */
					$imagesStr = implode(',', $imagesArray);
					
					/* fire the character update event */
					$this->specs->update_spec_item($id, array('specs_images' => $imagesStr));
					
					$array = array(
						'src' => base_url() . asset_location('images/specs', $image),
						'width' => 130
					);
					
					echo img($array);
				}
			}
		}
	}
	
	function save_spec_images()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$images = $this->input->post('img', TRUE);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			/* load the resources */
			$this->load->model('specs_model', 'specs');
			
			/* fire the character update event */
			$this->specs->update_spec_item($id, array('spec_images' => $imageStr));
		}
	}
	
	function save_tour_field_value()
	{
		if (IS_AJAX)
		{
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			$post = $this->input->post('value', TRUE);
			
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
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
					
				$output = $this->load->view('_base/admin/pages/flash', $flash, TRUE);
			}
			
			echo $output;
		}
	}
	
	function save_tour_image()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$id = $this->uri->segment(3);
			$image = $this->input->post('image', TRUE);
			
			$image = str_replace('\.', '.', $image);
			
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			/* get the images */
			$tour = $this->tour->get_tour_item($id);
			
			if ($tour->num_rows() > 0)
			{
				$item = $tour->row();
				
				$images = $item->tour_images;
				
				if (!empty($images))
				{
					$imagesArray = explode(',', $images);
					
					$key = array_search($image, $imagesArray);
					
					if ($key === FALSE)
					{
						/* add the image to the array */
						$imagesArray[] = $image;
						
						/* make the array a string */
						$imagesStr = implode(',', $imagesArray);
						
						/* fire the character update event */
						$this->tour->update_tour_item($id, array('tour_images' => $imagesStr));
						
						$array = array(
							'src' => base_url() . asset_location('images/tour', $image),
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
					/* add the image to the array */
					$imagesArray[] = $image;
					
					/* make the array a string */
					$imagesStr = implode(',', $imagesArray);
					
					/* fire the character update event */
					$this->tour->update_tour_item($id, array('tour_images' => $imagesStr));
					
					$array = array(
						'src' => base_url() . asset_location('images/tour', $image),
						'width' => 130
					);
					
					echo img($array);
				}
			}
		}
	}
	
	function save_tour_images()
	{
		if (IS_AJAX)
		{
			/* set the variables */
			$images = $this->input->post('img', TRUE);
			$id = $this->uri->segment(3);
			
			foreach ($images as $i)
			{
				$imageArray[] = str_replace('\.', '.', $i);
			}
			
			$imageStr = implode(',', $imageArray);
			
			/* load the resources */
			$this->load->model('tour_model', 'tour');
			
			/* fire the character update event */
			$this->tour->update_tour_item($id, array('tour_images' => $imageStr));
		}
	}
	
	function whats_new()
	{
		/* load the resources */
		$this->load->model('users_model', 'user');
		
		/* build the array of pieces we need */
		$version_pieces = array(
			'sys_version_major',
			'sys_version_minor',
			'sys_version_update'
		);
		
		/* get the current version */
		$version = $this->sys->get_item('system_info', 'sys_id', 1, $version_pieces);
		
		/* put the version into a string */
		$version_str = implode('.', $version);
		
		/* grab the user info */
		$person = $this->user->get_user($this->session->userdata('userid'), 'is_firstlaunch');
		
		/* grab the what's new information */
		$data['whats_new'] = $this->sys->get_item('system_versions', 'version', $version_str, 'version_launch');
		
		$data['header'] = lang('head_admin_whatsnew');
		
		if ($person == 1)
		{
			$this->user->update_first_launch($this->session->userdata('userid'));
		}
		
		/* figure out the skin */
		$skin = $this->session->userdata('skin_admin');
		
		/* figure out where the view should come from */
		$ajax = ajax_location('whats_new', $skin, 'admin');
		
		/* write the data to the template */
		$this->template->write_view('content', $ajax, $data);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file ajax_base.php */
/* Location: ./application/controllers/base/ajax_base.php */