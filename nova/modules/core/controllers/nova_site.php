<?php
/**
 * Site controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		2.0
 */

require_once MODPATH.'core/libraries/Nova_controller_admin'.EXT;

abstract class Nova_site extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function bans()
	{
		// check access
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$level = $this->input->post('ban_level', TRUE);
					$email = $this->input->post('ban_email', TRUE);
					$ipaddr = $this->input->post('ban_ip', TRUE);
					$reason = $this->input->post('ban_reason', TRUE);
					
					$insert_array = array(
						'ban_level' => $level,
						'ban_email' => $email,
						'ban_ip' => $ipaddr,
						'ban_reason' => $reason,
						'ban_date' => now(),
					);
					
					$insert = $this->sys->add_ban($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site') .' '. lang('labels_ban')),
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
							ucfirst(lang('labels_site') .' '. lang('labels_ban')),
							lang('actions_added'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
				
				case 'delete':
					$id = $this->input->post('id', TRUE);
				
					$delete = $this->sys->delete_ban($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site') .' '. lang('labels_ban')),
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
							ucfirst(lang('labels_site') .' '. lang('labels_ban')),
							lang('actions_deleted'),
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
		
		$data['inputs'] = array(
			'level_1' => array(
				'name' => 'ban_level',
				'id' => 'level_1',
				'value' => 1),
			'level_2' => array(
				'name' => 'ban_level',
				'id' => 'level_2',
				'value' => 2),
			'reason' => array(
				'name' => 'ban_reason',
				'id' => 'ban_reason',
				'rows' => 2),
			'email' => array(
				'name' => 'ban_email',
				'id' => 'ban_email'),
			'ip' => array(
				'name' => 'ban_ip',
				'id' => 'ban_ip')
		);
		
		// get the list of bans
		$bans = $this->sys->get_bans();
		
		if ($bans !== false)
		{
			// set the date format
			$datestring = $this->options['date_format'];
			
			foreach ($bans as $b)
			{
				$date = gmt_to_local($b->ban_date, $this->timezone, $this->dst);
				
				$data['bans'][$b->ban_level][$b->ban_id] = array(
					'id' => $b->ban_id,
					'ip' => $b->ban_ip,
					'email' => $b->ban_email,
					'reason' => $b->ban_reason,
					'date' => mdate($datestring, $date),
					'span' => timespan_short($b->ban_date, now())
				);
			}
		}
		
		$data['images'] = array(
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => lang('actions_delete')),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
		);
				
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_bans'));
		$data['text'] = lang('text_bans');
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_ban')),
			'date' => '<strong>'.ucfirst(lang('labels_date')).':</strong> ',
			'email' => ucwords(lang('labels_email_address')),
			'email_note' => lang('misc_level1_only'),
			'ip' => ucwords(lang('labels_ipaddr')),
			'level' => ucwords(lang('labels_ban') .' '. lang('labels_level')),
			'level_1' => ucwords(lang('labels_level').' 1 '.lang('labels_bans')),
			'level_1_label' => ucfirst(lang('labels_level').' 1'),
			'level_2' => ucwords(lang('labels_level').' 2 '.lang('labels_bans')),
			'level_2_label' => ucfirst(lang('labels_level').' 2'),
			'no_bans' => sprintf(lang('error_not_found'), lang('labels_bans')),
			'reason' => ucfirst(lang('labels_reason')),
			'type' => ucwords(lang('labels_ban') .' '. lang('labels_type')),
		);
		
		$data['buttons'] = array(
			'add' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_add'))),
		);
		
		$this->_regions['content'] = Location::view('site_bans', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_bans_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function bioform()
	{
		// check access
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$type = $this->input->post('field_type', TRUE);
					$section = $this->input->post('field_section', TRUE);
					$label = $this->input->post('field_label_page', TRUE);
					$name = $this->input->post('field_name', TRUE);
					$id = $this->input->post('field_fid', TRUE);
					$class = $this->input->post('field_class', TRUE);
					$rows = $this->input->post('field_rows', TRUE);
					$order = $this->input->post('field_order', TRUE);
					$display = $this->input->post('field_display', TRUE);
					$select = $this->input->post('select_values', TRUE);
			
					$insert_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_section' => $section,
						'field_label_page' => $label,
						'field_fid' => $id,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display
					);
							
					$insert = $this->char->add_bio_field($insert_array);
					$insert_id = $this->db->insert_id();
					
					$this->sys->optimize_table('characters_fields');
					
					if ($insert > 0)
					{
						if ($type == 'select')
						{
							$select_array = explode("\n", $select);
							
							$i = 0;
							foreach ($select_array as $select)
							{
								$array = explode(',', $select);
								
								$values_array = array(
									'value_field' => $insert_id,
									'value_field_value' => $array[0],
									'value_content' => $array[1],
									'value_order' => $i
								);
								
								$insert = $this->char->add_bio_field_value($values_array);
								
								++$i;
							}
						}
						
						$characters = $this->char->get_all_characters('all');
						
						if ($characters->num_rows() > 0)
						{
							foreach ($characters->result() as $char)
							{
								$ins_array = array(
									'data_field' => $insert_id,
									'data_char' => $char->charid,
									'data_user' => $char->user,
									'data_value' => '',
									'data_updated' => now()
								);
								
								$ins = $this->char->add_bio_field_data($ins_array);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = (is_numeric($this->input->post('id', TRUE))) ? $this->input->post('id', TRUE) : 0;
							
					$delete = $this->char->delete_bio_field($id);
					
					if ($delete > 0)
					{
						$delete_fields = $this->char->delete_character_field_data($id);
						$values = $this->char->get_bio_values($id);
						
						if ($values->num_rows() > 0)
						{
							foreach ($values->result() as $value)
							{
								$delete_values = $this->char->delete_bio_field_value($value->value_id);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$type = $this->input->post('field_type', TRUE);
					$section = $this->input->post('field_section', TRUE);
					$label = $this->input->post('field_label_page', TRUE);
					$name = $this->input->post('field_name', TRUE);
					$fid = $this->input->post('field_fid', TRUE);
					$class = $this->input->post('field_class', TRUE);
					$rows = $this->input->post('field_rows', TRUE);
					$order = $this->input->post('field_order', TRUE);
					$display = $this->input->post('field_display', TRUE);
					$id = $this->input->post('field_id', TRUE);
					
					$update_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_section' => $section,
						'field_label_page' => $label,
						'field_fid' => $fid,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display
					);
							
					$update = $this->char->update_bio_field($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_field')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'editval':
					$value = $this->input->post('value_field_value', TRUE);
					$content = $this->input->post('value_content', TRUE);
					$field = $this->input->post('value_field', TRUE);
					$id = $this->input->post('id', TRUE);

					$update_array = array(
						'value_field_value' => $value,
						'value_content' => $content,
						'value_field' => $field
					);

					$update = $this->char->update_bio_field_value($id, $update_array);

					if ($update > 0)
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$id = $this->uri->segment(4, 0, true);
		
		if ($id == 0)
		{
			// grab the join fields
			$sections = $this->char->get_bio_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$sid = $sec->section_id; /* section id */
					
					// set the section name
					$data['join'][$sid]['name'] = $sec->section_name;
					
					// grab the fields for the given section
					$fields = $this->char->get_bio_fields($sec->section_id);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$f_id = $field->field_id;
							
							// set the page label
							$data['join'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
							
							switch ($field->field_type)
							{
								case 'text':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value
									);
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_input($input);
									$data['join'][$sid]['fields'][$f_id]['id'] = $field->field_id;
								break;
									
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value,
										'rows' => $field->field_rows
									);
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
									$data['join'][$sid]['fields'][$f_id]['id'] = $field->field_id;
								break;
									
								case 'select':
									$value = FALSE;
									$values = FALSE;
									$input = FALSE;
									
									$values = $this->char->get_bio_values($field->field_id);
									
									if ($values->num_rows() > 0)
									{
										foreach ($values->result() as $value)
										{
											$input[$value->value_field_value] = $value->value_content;
										}
									}
									
									$data['join'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input);
									$data['join'][$sid]['fields'][$f_id]['id'] = $field->field_id;
								break;
							}
						}
					}
				}
			}
			
			$data['images'] = array(
				'tabs' => array(
					'src' => Location::img('forms-tab.png', $this->skin, 'admin'),
					'class' => 'image inline_img_left',
					'alt' => ''),
				'sections' => array(
					'src' => Location::img('forms-section.png', $this->skin, 'admin'),
					'class' => 'image inline_img_left',
					'alt' => ''),
				'edit' => array(
					'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
					'class' => 'image',
					'alt' => lang('actions_edit')),
				'delete' => array(
					'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
					'class' => 'image',
					'alt' => lang('actions_delete')),
				'add_field' => array(
					'src' => Location::img('icon-add.png', $this->skin, 'admin'),
					'class' => 'image inline_img_left',
					'alt' => ''),
			);
					
			// figure out where the view should be coming from
			$view_loc = 'site_bioform_all';
			
			// set the header
			$data['header'] = ucwords(lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '. lang('labels_form'));
			$data['text'] = lang('text_bioform');
		}
		else
		{
			$field = $this->char->get_bio_field_details($id);
			
			if ($field->num_rows() > 0)
			{
				$row = $field->row();
				
				$data['id'] = $row->field_id;
				
				$data['inputs'] = array(
					'fid' => array(
						'name' => 'field_fid',
						'id' => 'field_fid',
						'value' => $row->field_fid),
					'name' => array(
						'name' => 'field_name',
						'id' => 'field_name',
						'value' => $row->field_name),
					'class' => array(
						'name' => 'field_class',
						'id' => 'field_class',
						'value' => $row->field_class),
					'label' => array(
						'name' => 'field_label_page',
						'id' => 'field_label_page',
						'value' => $row->field_label_page),
					'value' => array(
						'name' => 'field_value',
						'id' => 'field_value',
						'value' => $row->field_value),
					'order' => array(
						'name' => 'field_order',
						'id' => 'field_order',
						'class' => 'small',
						'value' => $row->field_order),
					'display_y' => array(
						'name' => 'field_display',
						'id' => 'field_display_y',
						'value' => 'y',
						'checked' => ($row->field_display == 'y') ? TRUE : FALSE),
					'display_n' => array(
						'name' => 'field_display',
						'id' => 'field_display_n',
						'value' => 'n',
						'checked' => ($row->field_display == 'n') ? TRUE : FALSE),
					'rows' => array(
						'name' => 'field_rows',
						'id' => 'field_rows',
						'class' => 'small',
						'value' => $row->field_rows)
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
				
				$data['defaults']['type'] = $row->field_type;
				$data['defaults']['section'] = $row->field_section;
			}
			
			// figure out where the view should be coming from
			$view_loc = 'site_bioform_one';
			
			// set the header
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_bio') .'/'. 
				ucfirst(lang('actions_join')) .' '. lang('labels_form'));
			$data['text'] = lang('text_bioform_edit');
			
			$data['buttons'] = array(
				'submit' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))),
				'update' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'update',
					'id' => 'update',
					'content' => ucwords(lang('actions_update'))),
				'add' => array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'rel' => $id,
					'id' => 'add',
					'content' => ucwords(lang('actions_add'))),
			);
			
			if ($row->field_type == 'select')
			{
				$values = $this->char->get_bio_values($row->field_id);
				
				$data['select'] = FALSE;
				
				if ($values->num_rows() > 0)
				{
					foreach ($values->result() as $value)
					{
						$data['select'][$value->value_id] = $value->value_content;
					}
				}
				
				$data['loading'] = array(
					'src' => img_location('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'
				);
				
				$data['inputs']['val_add_value'] = array('id' => 'value');
				$data['inputs']['val_add_content'] = array('id' => 'content');
			}
		}
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucwords(lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '. lang('labels_form')),
			'biofield' => ucwords(lang('actions_add') .' '. lang('labels_bio') .' '. lang('labels_field')) .' '. RARROW,
			'biosections' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .' '. lang('labels_sections')) .' '. RARROW,
			'biotabs' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .' '. lang('labels_tabs')) .' '. RARROW,
			'bioval' => lang('text_site_bioval'),
			'class' => ucfirst(lang('labels_class')),
			'content' => ucwords(lang('labels_dropdown') .' '. lang('labels_content')),
			'display' => ucfirst(lang('labels_display')),
			'html' => lang('misc_html_attr'),
			'id' => lang('abbr_id'),
			'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'nofields' => sprintf(lang('error_not_found'), lang('labels_fields')),
			'order' => ucfirst(lang('labels_order')),
			'rows' => lang('misc_textarea_rows'),
			'section' => ucfirst(lang('labels_section')),
			'select_values' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu') .' '. lang('labels_values')),
			'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
			'value' => ucwords(lang('labels_dropdown') .' '. lang('labels_value')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_bioform_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function biosections()
	{
		// check access
		Auth::check_access('site/bioform');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('section_name', TRUE);
					$order = $this->input->post('section_order', TRUE);
					$tab = $this->input->post('section_tab', TRUE);
			
					$insert_array = array(
						'section_name' => $name,
						'section_order' => $order,
						'section_tab' => $tab
					);
							
					$insert = $this->char->add_bio_sec($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
							lang('actions_created'),
							lang('flash_additional_bio_section')
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$old_id = $this->input->post('id', TRUE);
					$new_id = $this->input->post('new_sec', TRUE);
					
					$delete = $this->char->delete_bio_section($old_id);
					$update = $this->char->update_field_sections($old_id, $new_id);
							
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('section_name', TRUE);
					$order = $this->input->post('section_order', TRUE);
					$tab = $this->input->post('section_tab', TRUE);
					$id = $this->input->post('id', TRUE);
			
					$update_array = array(
						'section_name' => $name,
						'section_order' => $order,
						'section_tab' => $tab
					);
							
					$update = $this->char->update_bio_section($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_field') .' '. lang('labels_section')),
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
		
		$tabs = $this->char->get_bio_tabs('');
		$sections = $this->char->get_bio_sections();
		
		if ($tabs->num_rows() > 0)
		{
			foreach ($tabs->result() as $tab)
			{
				$all_tabs[$tab->tab_id] = $tab->tab_name;
			}
		}
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$data['sections'][] = array(
					'id' => $sec->section_id,
					'name' => $sec->section_name,
					'tab' => $all_tabs[$sec->section_tab]
				);
			}
		}
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'tabs' => array(
				'src' => Location::img('forms-tab.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_edit'))),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_delete'))),
		);
		
		$data['label'] = array(
			'addsection' => ucwords(lang('actions_add') .' '. lang('labels_bio') .' '. lang('labels_section')) .' '. RARROW,
			'bioform' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '.
				lang('labels_form')) .' '. RARROW,
			'biotabs' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .' '. lang('labels_tabs')) .' '. RARROW,
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'invalid_tab' => lang('error_invalid_tab'),
			'name' => ucfirst(lang('labels_name')),
			'tab' => ucfirst(lang('labels_tab')),
		);
		
		$data['header'] = ucwords(lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '. lang('labels_form') 
			.' '. lang('labels_sections'));
		$data['text'] = lang('text_biosections');
		
		$this->_regions['content'] = Location::view('site_biosections', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_biosections_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function biotabs()
	{
		// check access
		Auth::check_access('site/bioform');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('tab_name', TRUE);
					$order = $this->input->post('tab_order', TRUE);
					$display = $this->input->post('tab_display', TRUE);
					$link = $this->input->post('tab_link_id', TRUE);
			
					$insert_array = array(
						'tab_name' => $name,
						'tab_link_id' => $link,
						'tab_order' => $order,
						'tab_display' => $display
					);
							
					$insert = $this->char->add_bio_tab($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
							lang('actions_created'),
							lang('flash_additional_bio_tab')
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$old_id = $this->input->post('id', TRUE);
					$new_id = $this->input->post('new_tab', TRUE);
					
					$delete = $this->char->delete_bio_tab($old_id);
					$update = $this->char->update_section_tabs($old_id, $new_id);
							
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('tab_name', TRUE);
					$order = $this->input->post('tab_order', TRUE);
					$display = $this->input->post('tab_display', TRUE);
					$link = $this->input->post('tab_link_id', TRUE);
					$id = $this->input->post('tab_id', TRUE);
			
					$update_array = array(
						'tab_name' => $name,
						'tab_link_id' => $link,
						'tab_order' => $order,
						'tab_display' => $display
					);
							
					$update = $this->char->update_bio_tab($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
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
							ucfirst(lang('labels_bio') .' '. lang('labels_tab')),
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
		
		$tabs = $this->char->get_bio_tabs('');
		
		if ($tabs->num_rows() > 0)
		{
			foreach ($tabs->result() as $tab)
			{
				$data['tabs'][] = array(
					'id' => $tab->tab_id,
					'name' => $tab->tab_name,
					'display' => $tab->tab_display
				);
			}
		}
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'sections' => array(
				'src' => Location::img('forms-section.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_edit'))),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ucfirst(lang('actions_delete'))),
		);
		
		$data['header'] = ucwords(lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '. lang('labels_form') 
			.' '. lang('labels_tabs'));
		$data['text'] = lang('text_biotabs');
		
		$data['label'] = array(
			'addtab' => ucwords(lang('actions_add') .' '. lang('labels_bio') .' '. lang('labels_tab')) .' '. RARROW,
			'bioform' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .'/'. ucfirst(lang('actions_join')) .' '.
				lang('labels_form')) .' '. RARROW,
			'biosections' => ucwords(lang('actions_manage') .' '. lang('labels_bio') .' '. lang('labels_sections')) .' '. RARROW,
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'off' => strtoupper(lang('labels_off')),
		);
		
		$this->_regions['content'] = Location::view('site_biotabs', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_biotabs_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}

	public function roles($action = false, $id = false)
	{
		// check access
		Auth::check_access();
		
		// load the resources
		$this->load->model('access_model', 'access');
		
		// sanity checks
		$values = array('add', 'delete', 'edit', 'duplicate');
		$action = (in_array($action, $values)) ? $action : false;
		$id = (is_numeric($id)) ? $id : false;
		
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'add':
					$name = $this->input->post('role_name', TRUE);
					$desc = $this->input->post('role_desc', TRUE);
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 5) == 'page_')
						{
							$pages[$key] = $value;
						}
					}
					
					$string = implode(',', $pages);
					
					$insert_array = array(
						'role_name' => $name,
						'role_desc' => $desc,
						'role_access' => $string
					);
					
					$insert = $this->access->insert_role($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
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
							ucfirst(lang('labels_role')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', TRUE);
					$new_role = $this->input->post('new_role', TRUE);
				
					/* insert the record */
					$delete = $this->access->delete_role($id);
					
					if ($delete > 0)
					{
						$update_data = array('access_role' => $new_role);
						$where = array('access_role' => $id);
						
						$users = $this->user->update_all_users($update_data, $where);
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
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
							ucfirst(lang('labels_role')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('role_name', TRUE);
					$desc = $this->input->post('role_desc', TRUE);
					
					foreach ($_POST as $key => $value)
					{
						if (substr($key, 0, 5) == 'page_')
						{
							$pages[$key] = $value;
						}
					}
					
					$string = implode(',', $pages);
					
					$update_array = array(
						'role_name' => $name,
						'role_desc' => $desc,
						'role_access' => $string
					);
					
					$update = $this->access->update_role($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
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
							ucfirst(lang('labels_role')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'duplicate':
					$new_name = $this->input->post('name', TRUE);
					$new_desc = $this->input->post('desc', TRUE);
					$old_role = $this->input->post('role', TRUE);
					
					$role = $this->access->get_role($old_role);
					
					$insert_array = array(
						'role_name' => $new_name,
						'role_desc' => $new_desc,
						'role_access' => $role->role_access
					);
					
					$insert = $this->access->insert_role($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role')),
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
							ucfirst(lang('labels_role')),
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
		
		if ($action == 'edit' or $action == 'add')
		{
			$pages = $this->access->get_role_pages();
			
			if ($action == 'edit')
			{
				$role = $this->access->get_role($id);
			}
			
			$page_array = (isset($role)) ? explode(',', $role->role_access) : array();
			
			if ($pages->num_rows() > 0)
			{
				foreach ($pages->result() as $page)
				{
					$data['pages']['group'][$page->page_group]['group'] = $this->access->get_group($page->page_group, 'group_name');
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['id'] = $page->page_id;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['name'] = $page->page_name;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['url'] = $page->page_url;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['desc'] = $page->page_desc;
					$data['pages']['group'][$page->page_group]['pages'][$page->page_id]['checked'] = (in_array($page->page_id, $page_array) ? true : false);
				}
				
				$data['inputs'] = array(
					'name' => array(
						'name' => 'role_name',
						'id' => 'role_name',
						'value' => (isset($role)) ? $role->role_name : ''),
					'desc' => array(
						'name' => 'role_desc',
						'id' => 'role_desc',
						'value' => (isset($role)) ? $role->role_desc : '',
						'rows' => 2),
				);
				
				$data['id'] = $id;
				$data['action'] = $action;
				
				$data['button_submit'] = array(
					'type' => 'submit',
					'class' => 'button-main',
					'name' => 'submit',
					'value' => 'submit',
					'content' => ucwords(lang('actions_submit'))
				);
				
				// set the view that's being used
				$view_loc = 'site_roles_action';
			}
		}
		else
		{
			// run the methods
			$roles = $this->access->get_roles();
			
			if ($roles->num_rows() > 0)
			{
				foreach ($roles->result() as $role)
				{
					$data['roles'][$role->role_id]['id'] = $role->role_id;
					$data['roles'][$role->role_id]['name'] = $role->role_name;
					$data['roles'][$role->role_id]['desc'] = $role->role_desc;
				}
			}
			
			// set the view that's being used
			$view_loc = 'site_roles';
		}
		
		switch ($action)
		{
			case 'add':
				$data['header'] = ucwords(lang('actions_add') .' '. lang('labels_role'));
				$data['text'] = lang('text_roles');
			break;
				
			case 'edit':
				$data['header'] = ucwords(lang('actions_edit') .' '. lang('labels_role'));
				$data['text'] = lang('text_roles');
			break;
				
			default:
				$data['header'] = ucfirst(lang('labels_roles'));
				$data['text'] = lang('text_roles');
			break;
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'view' => array(
				'src' => Location::img('icon-view.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image'),
			'pages' => array(
				'src' => Location::img('page.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_role') .' '. RARROW),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucfirst(lang('labels_roles')),
			'delete' => ucfirst(lang('actions_delete')),
			'desc' => ucfirst(lang('labels_desc')),
			'duplicate' => ucfirst(lang('actions_duplicate')),
			'duplicate_role' => ucwords(lang('actions_duplicate') .' '. lang('labels_role')),
			'edit' => ucfirst(lang('actions_edit')),
			'manage_pages' => ucwords(lang('actions_manage') .' '. lang('labels_role') .' '. 
				lang('labels_pages') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'pages' => ucfirst(lang('labels_pages')),
			'view' => ucfirst(lang('actions_view')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_roles_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
