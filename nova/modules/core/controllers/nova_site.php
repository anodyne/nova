<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Site controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_admin.php';

abstract class Nova_site extends Nova_controller_admin {
	
	public function __construct()
	{
		parent::__construct();
	}
	
	public function bans()
	{
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $this->security->xss_clean($value);
					}
					
					// pop unnecessary items off the array
					unset($insert_array['submit']);
					
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
					$id = $this->input->post('id', true);
				
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
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $this->security->xss_clean($value);
					}
					
					// pull the items off the array
					$select = $insert_array['select_values'];
					$type = $insert_array['field_type'];
					
					// pop unnecessary items off the array
					unset($insert_array['select_values']);
					unset($insert_array['submit']);
							
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
									'value_field_value' => trim($array[0]),
									'value_content' => trim($array[1]),
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
					$id = (is_numeric($this->input->post('id', true))) ? $this->input->post('id', true) : 0;
							
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
					foreach ($_POST as $key => $value)
					{
						$update_array[$key] = $this->security->xss_clean($value);
					}
					
					// set the ID
					$id = $update_array['field_id'];
					
					// pop unnecessary items off the array
					unset($update_array['field_id']);
					unset($update_array['submit']);

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
					$value = $this->input->post('value_field_value', true);
					$content = $this->input->post('value_content', true);
					$field = $this->input->post('value_field', true);
					$id = $this->input->post('id', true);

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
					$fields = $this->char->get_bio_fields($sec->section_id, false, false);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$f_id = $field->field_id;
							
							// set the page label
							$data['join'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;

							// set the display
							$data['join'][$sid]['fields'][$f_id]['display'] = $field->field_display;
							
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
									$value = false;
									$values = false;
									$input = false;
									
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
						'checked' => ($row->field_display == 'y') ? true : false),
					'display_n' => array(
						'name' => 'field_display',
						'id' => 'field_display_n',
						'value' => 'n',
						'checked' => ($row->field_display == 'n') ? true : false),
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
				
				$data['select'] = false;
				
				if ($values->num_rows() > 0)
				{
					foreach ($values->result() as $value)
					{
						$data['select'][$value->value_id] = $value->value_content;
					}
				}
				
				$data['loading'] = array(
					'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
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
			'off' => '[ '.strtoupper(lang('labels_off')).' ]',
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_bioform_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function biosections()
	{
		Auth::check_access('site/bioform');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('section_name', true);
					$order = $this->input->post('section_order', true);
					$tab = $this->input->post('section_tab', true);
			
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
					$old_id = $this->input->post('id', true);
					$new_id = $this->input->post('new_sec', true);
					
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
					$name = $this->input->post('section_name', true);
					$order = $this->input->post('section_order', true);
					$tab = $this->input->post('section_tab', true);
					$id = $this->input->post('id', true);
			
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
		Auth::check_access('site/bioform');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('tab_name', true);
					$order = $this->input->post('tab_order', true);
					$display = $this->input->post('tab_display', true);
					$link = $this->input->post('tab_link_id', true);
			
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
					$old_id = $this->input->post('id', true);
					$new_id = $this->input->post('new_tab', true);
					
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
					$name = $this->input->post('tab_name', true);
					$order = $this->input->post('tab_order', true);
					$display = $this->input->post('tab_display', true);
					$link = $this->input->post('tab_link_id', true);
					$id = $this->input->post('tab_id', true);
			
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
	
	public function catalogueranks()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		$this->load->helper('directory');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'install':
					// set the variable
					$selection = $this->input->post('install_rank', true);
					
					// load the yaml parser
					$this->load->helper('yayparser');
					
					// get the contents of the file
					$contents = file_get_contents(APPPATH.'assets/common/'.GENRE.'/ranks/'.$selection.'/rank.yml');
					
					// parse the contents of the yaml file
					$array = yayparser($contents);
					
					// create the skin array
					$set = array(
						'rankcat_name'		=> $array['rank'],
						'rankcat_location'	=> $array['location'],
						'rankcat_credits'	=> $array['credits'],
						'rankcat_preview'	=> $array['preview'],
						'rankcat_blank'		=> $array['blank'],
						'rankcat_extension'	=> $array['extension'],
						'rankcat_url'		=> $array['url'],
						'rankcat_genre'		=> $array['genre'],
					);
					
					$insert = $this->ranks->add_rank_set($set);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
							lang('actions_installed'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
							lang('actions_installed'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'add':
					$name = $this->input->post('rank_name', true);
					$location = $this->input->post('rank_location', true);
					$preview = $this->input->post('rank_preview', true);
					$blank = $this->input->post('rank_blank', true);
					$extension = $this->input->post('rank_extension', true);
					$status = $this->input->post('rank_status', true);
					$credits = $this->input->post('rank_credits', true);
					$default = $this->input->post('rank_default', true);
					$genre = $this->input->post('rank_genre', true);
					
					if ($default == 'y')
					{
						$all_data = array('rankcat_default' => 'n');
						$all_where = array('rankcat_default' => 'y');
						$update_all = $this->ranks->update_rank_set('', $all_data, $all_where);
					}
			
					$insert_array = array(
						'rankcat_name' => $name,
						'rankcat_location' => $location,
						'rankcat_preview' => $preview,
						'rankcat_blank' => $blank,
						'rankcat_extension' => $extension,
						'rankcat_status' => $status,
						'rankcat_credits' => $credits,
						'rankcat_default' => $default,
						'rankcat_genre' => $genre
					);
							
					$insert = $this->ranks->add_rank_set($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
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
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
							lang('actions_added'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$old_id = $this->input->post('id', true);
					$new = $this->input->post('new_rank', true);
					
					$item = $this->ranks->get_rankcat($old_id, 'rankcat_id');
					
					if ($item->rankcat_location == $this->options['display_rank'])
					{
						$setting_data = array('setting_value' => $new);
						$update_settings = $this->settings->update_setting('display_rank', $setting_data);
					}
						
					$user_data = array('display_rank' => $new);
					$user_where = array('display_rank' => $item->rankcat_location);
					
					$delete = $this->ranks->delete_rank_set($old_id);
					$update = $this->user->update_all_users($user_data, $user_where);
							
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
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
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
							lang('actions_removed'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('rank_name', true);
					$location = $this->input->post('rank_location', true);
					$preview = $this->input->post('rank_preview', true);
					$blank = $this->input->post('rank_blank', true);
					$extension = $this->input->post('rank_extension', true);
					$status = $this->input->post('rank_status', true);
					$credits = $this->input->post('rank_credits', true);
					$default = $this->input->post('rank_default', true);
					$genre = $this->input->post('rank_genre', true);
					$id = $this->input->post('id', true);
					
					if ($default == 'y')
					{
						$all_data = array('rankcat_default' => 'n');
						$all_where = array('rankcat_default' => 'y');
						$update_all = $this->ranks->update_rank_set('', $all_data, $all_where);
					}
			
					$update_array = array(
						'rankcat_name' => $name,
						'rankcat_location' => $location,
						'rankcat_preview' => $preview,
						'rankcat_blank' => $blank,
						'rankcat_extension' => $extension,
						'rankcat_status' => $status,
						'rankcat_credits' => $credits,
						'rankcat_default' => $default,
						'rankcat_genre' => $genre
					);
							
					$update = $this->ranks->update_rank_set($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
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
							ucfirst(lang('global_rank') .' '. lang('labels_set')),
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
		
		$dir = directory_map(APPPATH .'assets/common/'. GENRE .'/ranks/', true);
		
		$ranks = $this->ranks->get_all_rank_sets('');
		
		if ($ranks->num_rows() > 0)
		{
			foreach ($ranks->result() as $rank)
			{
				$data['catalogue'][$rank->rankcat_id]['id'] = $rank->rankcat_id;
				$data['catalogue'][$rank->rankcat_id]['name'] = $rank->rankcat_name;
				$data['catalogue'][$rank->rankcat_id]['location'] = $rank->rankcat_location;
				$data['catalogue'][$rank->rankcat_id]['status'] = $rank->rankcat_status;
				$data['catalogue'][$rank->rankcat_id]['default'] = $rank->rankcat_default;
				
				$key = array_search($rank->rankcat_location, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// create an array of items that shouldn't be included in the dir listing
			$pop = array('index.html');
			
			// make sure the items aren't in the listing
			foreach ($pop as $value)
			{
				$key = array_search($value, $dir);
				
				if ($key !== false)
				{
					unset($dir[$key]);
				}
			}
			
			// make sure these are items that can use quick install
			foreach ($dir as $key => $value)
			{
				if ( ! file_exists(APPPATH .'assets/common/'. GENRE .'/ranks/'. $value .'/rank.yml'))
				{
					unset($dir[$key]);
				}
			}
			
			$data['uninstalled'] = $dir;
		}
		
		$data['images'] = array(
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
			'default' => array(
				'src' => Location::img('icon-green-small.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image')
		);
		
		$data['buttons'] = array(
			'install' => array(
				'type' => 'submit',
				'class' => 'button-small',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_install')) .'&nbsp;&nbsp;'),
		);
		
		$data['header'] = ucwords(lang('labels_system') .' '. lang('global_rank') .' '. lang('labels_catalogue'));
		$data['text'] = sprintf(lang('text_catalogueranks'), img($data['images']['default']));
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('global_rank') .' '. lang('labels_set') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'install' => ucfirst(lang('actions_install')),
			'install_ranks' => ucwords(lang('actions_install') .' '. lang('global_rank') .' '. lang('labels_sets')),
			'location' => ucfirst(lang('labels_location') .':'),
			'name' => ucfirst(lang('labels_name')),
			'no_ranks' => sprintf(lang('error_not_found'), lang('global_ranks')),
			'quick_install' => sprintf(lang('text_quick_install'), lang('global_ranks'), lang('global_ranks')),
			'status' => ucfirst(lang('labels_status')),
		);
		
		$this->_regions['content'] = Location::view('site_catalogueranks', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_catalogueranks_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function catalogueskins()
	{
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'install':
					// set the variable
					$selection = $this->input->post('install_skin', true);
					
					// load the yaml parser
					$this->load->helper('yayparser');
					
					// get the contents of the file
					$contents = file_get_contents(APPPATH .'views/'. $selection .'/skin.yml');
					
					// parse the contents of the yaml file
					$array = yayparser($contents);
					
					// create the skin array
					$skin = array(
						'skin_name'		=> trim($array['skin']),
						'skin_location'	=> trim($array['location']),
						'skin_credits'	=> trim($array['credits'])
					);
					
					$install_count = $this->sys->add_skin($skin);

					foreach ($array['sections'] as $value)
					{
						$section = array(
							'skinsec_section'			=> trim($value['type']),
							'skinsec_skin'				=> trim($array['location']),
							'skinsec_image_preview'		=> trim($value['preview']),
							'skinsec_status'			=> 'active',
							'skinsec_default'			=> 'n'
						);
						
						$install_count += $this->sys->add_skin_section($section);
					}
					
					$total_count = count($array['sections']) + 1;
					
					if ($install_count == $total_count)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_skin')),
							lang('actions_installed'),
							''
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('labels_skin')),
							lang('actions_installed'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'skin':
					switch ($this->uri->segment(4))
					{
						case 'add':
							$name = $this->input->post('skin_name', true);
							$location = $this->input->post('skin_location', true);
							$credits = $this->input->post('skin_credits', true);
					
							$insert_array = array(
								'skin_name' => $name,
								'skin_location' => $location,
								'skin_credits' => $credits,
							);
									
							$insert = $this->sys->add_skin($insert_array);
							
							if ($insert > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin')),
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
									ucfirst(lang('labels_skin')),
									lang('actions_added'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
							
						case 'delete':
							$id = $this->input->post('id', true);
							$id = (is_numeric($id)) ? $id : false;
							
							// the old skin
							$old_skin = (isset($_POST['old_skin'])) ? $_POST['old_skin'] : false;
							
							// grab the sections if they came through
							$sec['main'] = (isset($_POST['change_main'])) ? $_POST['change_main'] : false;
							$sec['wiki'] = (isset($_POST['change_wiki'])) ? $_POST['change_wiki'] : false;
							$sec['admin'] = (isset($_POST['change_admin'])) ? $_POST['change_admin'] : false;
							
							if ($sec['main'] !== false)
							{
								// set the user data
								$user_data = array('skin_main' => $sec['main']);
								$user_where = array('skin_main' => $old_skin);
								
								// update the users
								$update = $this->user->update_all_users($user_data, $user_where);
							}
							
							if ($sec['wiki'] !== false)
							{
								// set the user data
								$user_data = array('skin_wiki' => $sec['wiki']);
								$user_where = array('skin_wiki' => $old_skin);
								
								// update the users
								$update = $this->user->update_all_users($user_data, $user_where);
							}
							
							if ($sec['admin'] !== false)
							{
								// set the user data
								$user_data = array('skin_admin' => $sec['admin']);
								$user_where = array('skin_admin' => $old_skin);
								
								// update the users
								$update = $this->user->update_all_users($user_data, $user_where);
							}
							
							// delete the skin sections
							$section_delete = $this->sys->delete_skin_section($old_skin, 'skinsec_skin');
							
							// delete the skin
							$delete = $this->sys->delete_skin($id);
									
							if ($delete > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin')),
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
									ucfirst(lang('labels_skin')),
									lang('actions_removed'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
							
						case 'edit':
							$name = $this->input->post('skin_name', true);
							$location = $this->input->post('skin_location', true);
							$credits = $this->input->post('skin_credits', true);
							$id = $this->input->post('id', true);
					
							$update_array = array(
								'skin_name' => $name,
								'skin_location' => $location,
								'skin_credits' => $credits,
							);
									
							$update = $this->sys->update_skin($id, $update_array);
							
							if ($update > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin')),
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
									ucfirst(lang('labels_skin')),
									lang('actions_updated'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
					}
				break;
					
				case 'section':
					switch ($this->uri->segment(4))
					{
						case 'add':
							$section = $this->input->post('section', true);
							$skin = $this->input->post('skin', true);
							$preview = $this->input->post('preview', true);
							$status = $this->input->post('status', true);
							$default = $this->input->post('default', true);
							
							if ($default == 'y')
							{
								$all_data = array('skinsec_default' => 'n');
								$all_where = array(
									'skinsec_default' => 'y',
									'skinsec_section' => $section
								);
								$update_all = $this->sys->update_skin_section('', $all_data, $all_where);
							}
					
							$insert_array = array(
								'skinsec_section' => $section,
								'skinsec_skin' => $skin,
								'skinsec_image_preview' => $preview,
								'skinsec_status' => $status,
								'skinsec_default' => $default,
							);
									
							$insert = $this->sys->add_skin_section($insert_array);
							
							if ($insert > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
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
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
									lang('actions_added'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
							
						case 'delete':
							// theme section we're handling
							$section = $this->input->post('section', true);
							
							// skin location we're changing to
							$new_skin = $this->input->post('new_skin', true);
							
							// theme ID we're deleting
							$id = $this->input->post('id', true);
							
							// skin location we're changing from
							$old_skin = $this->input->post('old_skin', true);
							
							// get the current skin for the section we're playing with
							$theme = $this->settings->get_setting('skin_'. $section);
							
							/**
							 * If the skin location of the theme we're deleting is the same as
							 * the skin location in the settings table, then we need to change
							 * the one in the settings table
							 */
							if ($old_skin == $theme)
							{
								$setting_data = array('setting_value' => $new_skin);
								$update_settings = $this->settings->update_setting('skin_'. $section, $setting_data);
							}
							
							// set the user data
							$user_data = array('skin_'. $section => $new_skin);
							$user_where = array('skin_'. $section => $old_skin);
							
							$delete = $this->sys->delete_skin_section($id);
							$update = ($section != 'login') ? $this->user->update_all_users($user_data, $user_where) : false;
									
							if ($delete > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
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
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
									lang('actions_removed'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
							
						case 'edit':
							$section = $this->input->post('section', true);
							$skin = $this->input->post('skin', true);
							$preview = $this->input->post('preview', true);
							$status = $this->input->post('status', true);
							$default = $this->input->post('default', true);
							$id = $this->input->post('id', true);
							
							if ($default == 'y')
							{
								$all_data = array('skinsec_default' => 'n');
								$all_where = array(
									'skinsec_default' => 'y',
									'skinsec_section' => $section
								);
								$update_all = $this->sys->update_skin_section('', $all_data, $all_where);
							}
					
							$update_array = array(
								'skinsec_section' => $section,
								'skinsec_skin' => $skin,
								'skinsec_image_preview' => $preview,
								'skinsec_status' => $status,
								'skinsec_default' => $default,
							);
									
							$update = $this->sys->update_skin_section($id, $update_array);
							
							if ($update > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
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
									ucfirst(lang('labels_skin') .' '. lang('labels_section')),
									lang('actions_updated'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						break;
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
			
			// get the admin section default
			$admin_default = $this->sys->get_skinsec_default('admin');
			
			// if the admin default has changed, update the database
			if ($admin_default != $this->options['skin_admin'])
			{
				$this->settings->update_setting('skin_admin', array('setting_value' => $admin_default));
			}
		}
		
		// load the resources
		$this->load->helper('directory');
		
		$check = array();
		
		$viewdirs = directory_map(APPPATH .'views/', true);
		
		$skins = $this->sys->get_all_skins();
		
		if ($skins->num_rows() > 0)
		{
			foreach ($skins->result() as $skin)
			{
				$sloc = $skin->skin_location;
				
				$data['catalogue'][$sloc]['id'] = $skin->skin_id;
				$data['catalogue'][$sloc]['name'] = $skin->skin_name;
				$data['catalogue'][$sloc]['location'] = $skin->skin_location;
				
				$key = array_search($skin->skin_location, $viewdirs);
				
				if ($key !== false)
				{
					unset($viewdirs[$key]);
				}
				
				$sections = $this->sys->get_skin_sections($skin->skin_location, '');
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $sec)
					{
						$data['catalogue'][$sloc]['sec'][$sec->skinsec_section]['id'] = $sec->skinsec_id;
						$data['catalogue'][$sloc]['sec'][$sec->skinsec_section]['name'] = $sec->skinsec_section;
						$data['catalogue'][$sloc]['sec'][$sec->skinsec_section]['skin'] = $sec->skinsec_skin;
						$data['catalogue'][$sloc]['sec'][$sec->skinsec_section]['default'] = $sec->skinsec_default;
						$data['catalogue'][$sloc]['sec'][$sec->skinsec_section]['status'] = $sec->skinsec_status;
						
						if ($sec->skinsec_default == 'y')
						{
							$check[$sec->skinsec_section][] = $sec->skinsec_skin;
						}
					}
				}
			}
		}
		
		// create an array of items that shouldn't be included in the dir listing
		$pop = array('_base_override', 'index.html', 'template.php');
		
		// make sure the items aren't in the listing
		foreach ($pop as $value)
		{
			$key = array_search($value, $viewdirs);
			
			if ($key !== false)
			{
				unset($viewdirs[$key]);
			}
		}
		
		// make sure these are items that can use quick install
		foreach ($viewdirs as $key => $value)
		{
			if ( ! file_exists(APPPATH .'views/'. $value .'/skin.yml'))
			{
				unset($viewdirs[$key]);
			}
		}
		
		// pass the listing to the view
		$data['uninstalled'] = $viewdirs;
		
		if (count($check) < 4)
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('error_skin_defaults');
			
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$data['images'] = array(
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
			'default' => array(
				'src' => Location::img('icon-green-small.png', $this->skin, 'admin'),
				'alt' => '*',
				'class' => 'image'),
		);
		
		$data['buttons'] = array(
			'install' => array(
				'type' => 'submit',
				'class' => 'button-small',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_install')) .'&nbsp;&nbsp;'),
		);
		
		$data['header'] = ucwords(lang('labels_system') .' '. lang('labels_skin') .' '. lang('labels_catalogue'));
		$data['text'] = sprintf(lang('text_catalogueskins'), img($data['images']['default']));
		
		$data['label'] = array(
			'addskin' => ucwords(lang('actions_add') .' '. lang('labels_skin') .' '. RARROW),
			'addskinsec' => ucwords(lang('actions_add') .' '. lang('labels_skin') .' '. 
				lang('labels_section') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'install' => ucfirst(lang('actions_install')),
			'install_skins' => ucwords(lang('actions_install') .' '. lang('labels_skins')),
			'location' => ucfirst(lang('labels_location') .':'),
			'no_skins' => sprintf(lang('error_not_found'), lang('labels_skins')),
			'quick_install' => sprintf(lang('text_quick_install'), lang('labels_skins'), lang('labels_skins')),
		);
		
		$this->_regions['content'] = Location::view('site_catalogueskins', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_catalogueskins_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function dockingform()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('docking_model', 'docking');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $this->security->xss_clean($value);
					}
					
					$select = $insert_array['select_values'];
					$type = $insert_array['field_type'];
					
					unset($insert_array['select_values']);
					unset($insert_array['submit']);
							
					$insert = $this->docking->add_docking_field($insert_array);
					$insert_id = $this->db->insert_id();
					
					$this->sys->optimize_table('docking_fields');
					
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
								
								$insert = $this->docking->add_docking_field_value($values_array);
								
								++$i;
							}
						}
						
						$data_array = array(
							'data_field' => $insert_id,
							'data_value' => '',
							'data_updated' => now()
						);
								
						$data_insert = $this->docking->add_docking_field_data($data_array);
						
						$this->sys->optimize_table('docking_values');
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
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
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = (is_numeric($this->input->post('id', true))) ? $this->input->post('id', true) : 0;
							
					$delete = $this->docking->delete_docking_field($id);
					
					if ($delete > 0)
					{
						$delete_fields = $this->docking->delete_docking_field_data($id);
						$values = $this->docking->get_docking_values($id);
						
						if ($values->num_rows() > 0)
						{
							foreach ($values->result() as $value)
							{
								$delete_values = $this->docking->delete_docking_field_value($value->value_id);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
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
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
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
						$update_array[$key] = $this->security->xss_clean($value);
					}
					
					$id = $update_array['field_id'];
					
					unset($update_array['field_id']);
					unset($update_array['submit']);
							
					$update = $this->docking->update_docking_field($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
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
							ucfirst(lang('actions_docking') .' '. lang('labels_field')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'editval':
					foreach ($_POST as $key => $value)
					{
						$update_array[$key] = $this->security->xss_clean($value);
					}
					
					$id = $update_array['id'];
					
					unset($update_array['id']);
					unset($update_array['submit']);
					
					$value = $this->input->post('value_field_value', true);
					$content = $this->input->post('value_content', true);
					$field = $this->input->post('value_field', true);
					$id = $this->input->post('id', true);

					$update_array = array(
						'value_field_value' => $value,
						'value_content' => $content,
						'value_field' => $field
					);

					$update = $this->docking->update_docking_field_value($id, $update_array);

					if ($update > 0)
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$id = $this->uri->segment(4, false, true);
		
		if ( ! $id)
		{
			$sections = $this->docking->get_docking_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$data['docking']['sections'][$sec->section_id]['name'] = $sec->section_name;
					
					$fields = $this->docking->get_docking_fields($sec->section_id, '', false);
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$fid = $field->field_id;
							
							$data['docking']['sections'][$sec->section_id]['fields'][$fid]['label'] = $field->field_label_page;
							$data['docking']['sections'][$sec->section_id]['fields'][$fid]['display'] = $field->field_display;
							
							switch ($field->field_type)
							{
								case 'text':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value
									);
									
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_input($input);
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
								break;
											
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value,
										'rows' => $field->field_rows
									);
											
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_textarea($input);
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
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
											
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_dropdown($field->field_id, $input);
									$data['docking']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
								break;
							}
						}
					}
				}
			}
			
			$data['images'] = array(
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
				'sections' => array(
					'src' => Location::img('forms-section.png', $this->skin, 'admin'),
					'class' => 'image inline_img_left',
					'alt' => ''),
			);
			
			// set the view location
			$view_loc = 'site_dockingform_all';
			
			$data['header'] = ucwords(lang('actions_docking') .' '. lang('labels_form'));
			$data['text'] = lang('text_dockingform');
		}
		else
		{
			$field = $this->docking->get_docking_field_details($id);
			
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
						'checked' => ($row->field_display == 'y') ? true : false),
					'display_n' => array(
						'name' => 'field_display',
						'id' => 'field_display_n',
						'value' => 'n',
						'checked' => ($row->field_display == 'n') ? true : false),
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
				
				$sections = $this->docking->get_docking_sections();
		
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
			
			// set the view
			$view_loc = 'site_dockingform_one';
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('actions_docking') .' '. lang('labels_form'));
			
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
					'value' => 'submit',
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
				$values = $this->docking->get_docking_values($row->field_id);
				
				if ($values->num_rows() > 0)
				{
					foreach ($values->result() as $value)
					{
						$data['select'][$value->value_id] = $value->value_content;
					}
				}
				
				$data['loading'] = array(
					'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'
				);
				
				$data['inputs']['val_add_value'] = array('id' => 'value');
				$data['inputs']['val_add_content'] = array('id' => 'content');
			}
		}
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('actions_docking') .' '. lang('labels_field') .' '. RARROW),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('actions_docking') .' '. lang('labels_form')),
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
			'sections' => ucwords(lang('actions_manage') .' '. lang('actions_docking') .' '. 
				lang('labels_sections') .' '. RARROW),
			'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
			'value' => ucwords(lang('labels_dropdown') .' '. lang('labels_value')),
			'values' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu') .' '. lang('labels_values')),
			'yes' => ucfirst(lang('labels_yes')),
			'off' => '[ '.strtoupper(lang('labels_off')).' ]',
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_dockingform_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function dockingsections()
	{
		Auth::check_access('site/dockingform');
		
		// load the resources
		$this->load->model('docking_model', 'docking');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $this->security->xss_clean($value);
					}
					
					unset($insert_array['submit']);
							
					$insert = $this->docking->add_docking_section($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
							lang('actions_created'),
							lang('flash_additional_docking_section')
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$old_id = $this->input->post('id', true);
					$new_id = $this->input->post('new_sec', true);
					
					$delete = $this->docking->delete_docking_section($old_id);
					$update = $this->docking->update_field_sections($old_id, $new_id);
							
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
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
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
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
						$update_array[$key] = $this->security->xss_clean($value);
					}
					
					$id = $update_array['id'];
					
					unset($update_array['id']);
					unset($update_array['submit']);
							
					$update = $this->docking->update_docking_section($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
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
							ucfirst(lang('actions_docking') .' '. lang('labels_section')),
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
		
		$sections = $this->docking->get_docking_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$data['sections'][] = array(
					'id' => $sec->section_id,
					'name' => $sec->section_name
				);
			}
		}
		
		$data['header'] = ucwords(lang('actions_docking') .' '. lang('labels_form') .' '. lang('labels_sections'));
		$data['text'] = lang('text_dockingsections');
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
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
			'add' => ucwords(lang('actions_add') .' '. lang('actions_docking') .' '. lang('labels_section') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'form' => ucwords(lang('actions_manage') .' '. lang('actions_docking') .' '. lang('labels_form') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'nofields' => sprintf(lang('error_not_found'), lang('labels_fields')),
			'nosections' => sprintf(lang('error_not_found'), lang('labels_sections')),
		);
		
		$this->_regions['content'] = Location::view('site_dockingsections', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_dockingsections_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function manifests($action = false)
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('depts_model', 'dept');
		$this->load->helper('debug');
		
		if (isset($_POST['submit']))
		{
			switch ($action)
			{
				case 'add':
					// dynamically assign the POST variables to the insert array
					foreach ($_POST as $key => $value)
					{
						$insert_array[$key] = $this->security->xss_clean($value);
					}
					
					// pop off the button
					unset($insert_array['submit']);
					
					// insert the record
					$insert = $this->dept->add_manifest($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site').' '.lang('labels_manifest')),
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
							ucfirst(lang('labels_site').' '.lang('labels_manifest')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					
					// get all departments assigned to the manifest
					$this->db->where('dept_manifest', $id);
					$depts = $this->dept->get_all_depts('asc', NULL);
					
					if ($depts->num_rows() > 0)
					{
						$update = 0;
						
						// reassign the departments to unassigned
						foreach ($depts->result() as $d)
						{
							$update += $this->dept->update_dept($d->dept_id, array('dept_manifest' => 0));
						}
						
						if ($depts->num_rows() == $update)
						{
							// delete the manifest
							$delete = $this->dept->delete_manifest($id);
							
							if ($delete > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_site').' '.lang('labels_manifest')),
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
									ucfirst(lang('labels_site').' '.lang('labels_manifest')),
									lang('actions_deleted'),
									''
								);
		
								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						}
						else
						{
							$message = sprintf(
								lang('flash_failure'),
								ucfirst(lang('labels_site').' '.lang('labels_manifest')),
								lang('actions_deleted'),
								sprintf(
									lang('text_manifest_delete_departments'),
									lang('global_departments'),
									lang('labels_manifest'),
									lang('global_departments'),
									lang('labels_manifest')
								)
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
					else
					{
						// delete the manifest
						$delete = $this->dept->delete_manifest($id);
						
						if ($delete > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_site').' '.lang('labels_manifest')),
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
								ucfirst(lang('labels_site').' '.lang('labels_manifest')),
								lang('actions_deleted'),
								''
							);
	
							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'edit':
					// get the ID
					$id = $this->input->post('id', true);
					
					// dynamically assign the POST variables to the insert array
					foreach ($_POST as $key => $value)
					{
						$update_array[$key] = $this->security->xss_clean($value);
					}
					
					// pop off the button
					unset($update_array['submit']);
					unset($update_array['id']);
					
					// clear out the manifest default
					if ($update_array['manifest_default'] == 'y')
					{
						$this->dept->update_manifest_default();
					}
					
					// update the record
					$update = $this->dept->update_manifest($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site').' '.lang('labels_manifest')),
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
							ucfirst(lang('labels_site').' '.lang('labels_manifest')),
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
		
		if ($action == 'assign')
		{
			// get all the manifests
			$manifests = $this->dept->get_all_manifests(NULL);
			
			if ($manifests->num_rows() > 0)
			{
				foreach ($manifests->result() as $m)
				{
					$data['manifests'][$m->manifest_id] = array(
						'manifest' => $m->manifest_name,
						'display' => $m->manifest_display,
					);
				}
			}
			
			// get all the departments
			$depts = $this->dept->get_all_depts('asc', NULL);
			
			if ($depts->num_rows() > 0)
			{
				foreach ($depts->result() as $d)
				{
					if ($d->dept_manifest == 0)
					{
						$data['unassigned'][$d->dept_id] = array(
							'name' => $d->dept_name,
							'desc' => $d->dept_desc,
						);
					}
					else
					{
						$data['manifests'][$d->dept_manifest]['depts'][$d->dept_id] = array(
							'name' => $d->dept_name,
							'desc' => $d->dept_desc,
						);
					}
				}
			}
			
			$data['text'] = sprintf(
				lang('text_manifest_assign'),
				lang('global_departments'),
				lang('labels_manifest'),
				lang('global_department'),
				lang('labels_manifest'),
				lang('global_departments'),
				lang('labels_manifests')
			);
			
			// figure out where the view should be coming from
			$view_loc = 'site_manifests_assign';
		}
		else
		{
			// get all the manifests
			$manifests = $this->dept->get_all_manifests(NULL);
			
			if ($manifests->num_rows() > 0)
			{
				foreach ($manifests->result() as $m)
				{
					$data['manifests'][$m->manifest_id] = array(
						'id' => $m->manifest_id,
						'name' => $m->manifest_name,
						'desc' => $m->manifest_desc,
						'display' => $m->manifest_display,
					);
				}
			}
			
			$data['inputs'] = array(
				'name' => array(
					'name' => 'manifest_name',
					'id' => 'manifest_name'),
				'order' => array(
					'name' => 'manifest_order',
					'id' => 'manifest_order',
					'class' => 'small',
					'value' => 99),
				'desc' => array(
					'name' => 'manifest_desc',
					'id' => 'manifest_desc',
					'rows' => 3),
				'header' => array(
					'name' => 'manifest_header_content',
					'id' => 'manifest_header_content',
					'rows' => 10),
				'button' => array(
					'type' => 'submit',
					'class' => 'button-main',
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
			
			$data['text'] = sprintf(
				lang('text_manifest'),
				ucfirst(lang('labels_site').' '.lang('labels_manifests')),
				lang('global_characters'),
				lang('global_sim'),
				lang('labels_manifest'),
				lang('global_departments'),
				lang('labels_manifest'),
				lang('labels_manifests'),
				lang('global_departments'),
				lang('global_positions'),
				lang('global_characters'),
				lang('labels_manifest'),
				lang('labels_manifests'),
				lang('global_departments'),
				lang('labels_manifests')
			);
			
			// figure out where the view should be coming from
			$view_loc = 'site_manifests';
		}
		
		$data['images'] = array(
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
			'assign' => array(
				'src' => Location::img('property-import.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'refresh' => array(
				'src' => Location::img('arrow-circle-double-135.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add').' '.lang('labels_manifest')),
			'assign' => ucwords(lang('actions_assign').' '.lang('global_departments')),
			'back' => LARROW.' '.ucfirst(lang('actions_back')).' '.lang('labels_to').' '.ucwords(lang('labels_site').' '.lang('labels_manifests')),
			'manifest_desc' => ucwords(lang('labels_manifest').' '.lang('labels_desc')),
			'manifest_header' => ucwords(lang('labels_manifest').' '.lang('labels_header').' '.lang('labels_content')),
			'manifest_name' => ucwords(lang('labels_manifest').' '.lang('labels_name')),
			'manifest_order' => ucwords(lang('labels_manifest').' '.lang('labels_order')),
			'manifest_view' => ucwords(lang('labels_manifest').' '.lang('labels_default').' '.lang('actions_view')),
			'off' => strtoupper(lang('labels_off')),
			'refresh' => ucwords(lang('labels_refresh').' '.lang('labels_page')),
			'sitemanifests' => ucwords(lang('labels_site').' '.lang('labels_manifests')),
			'unassigned' => ucwords(lang('labels_unassigned').' '.lang('global_departments')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_manifests_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['label']['sitemanifests'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function menus()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('menu_model');
		
		// set the variables
		$js_data['tab'] = 0;
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('menu_name', true);
					$group = $this->input->post('menu_group', true);
					$order = $this->input->post('menu_order', true);
					$link = $this->input->post('menu_link', true);
					$link_type = $this->input->post('menu_link_type', true);
					$need_login = $this->input->post('menu_need_login', true);
					$use_access = $this->input->post('menu_use_access', true);
					$access = $this->input->post('menu_access', true);
					$level = $this->input->post('menu_access_level', true);
					$type = $this->input->post('menu_type', true);
					$cat = $this->input->post('menu_cat', true);
					$display = $this->input->post('menu_display', true);
					$sim_type = $this->input->post('menu_sim_type', true);
					$js_data['tab'] = $this->input->post('tab', true);
					
					if (empty($name) or empty($link) or empty($type) or empty($cat))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_menus'),
							lang('actions_create'),
							lang('labels_menu') .' '. lang('labels_item')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$insert_array = array(
							'menu_name' => $name,
							'menu_group' => $group,
							'menu_order' => $order,
							'menu_link' => $link,
							'menu_link_type' => $link_type,
							'menu_need_login' => $need_login,
							'menu_use_access' => $use_access,
							'menu_access' => $access,
							'menu_access_level' => $level,
							'menu_type' => $type,
							'menu_cat' => $cat,
							'menu_display' => $display,
							'menu_sim_type' => $sim_type
						);
						
						$insert = $this->menu_model->add_menu_item($insert_array);
						
						if ($insert > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_menu') .' '. lang('labels_item')),
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
								ucfirst(lang('labels_menu') .' '. lang('labels_item')),
								lang('actions_created'),
								''
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$js_data['tab'] = $this->input->post('tab', true);
				
					$delete = $this->menu_model->delete_menu_item($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_menu') .' '. lang('labels_item')),
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
							ucfirst(lang('labels_menu') .' '. lang('labels_item')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('menu_name', true);
					$group = $this->input->post('menu_group', true);
					$order = $this->input->post('menu_order', true);
					$link = $this->input->post('menu_link', true);
					$link_type = $this->input->post('menu_link_type', true);
					$need_login = $this->input->post('menu_need_login', true);
					$use_access = $this->input->post('menu_use_access', true);
					$access = $this->input->post('menu_access', true);
					$level = $this->input->post('menu_access_level', true);
					$type = $this->input->post('menu_type', true);
					$cat = $this->input->post('menu_cat', true);
					$display = $this->input->post('menu_display', true);
					$sim_type = $this->input->post('menu_sim_type', true);
					$id = $this->input->post('id', true);
					$js_data['tab'] = $this->input->post('tab', true);
					
					if (empty($name) or empty($link) or empty($type) or empty($cat))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_menus'),
							lang('actions_update'),
							lang('labels_menu') .' '. lang('labels_item')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$update_array = array(
							'menu_name' => $name,
							'menu_group' => $group,
							'menu_order' => $order,
							'menu_link' => $link,
							'menu_link_type' => $link_type,
							'menu_need_login' => $need_login,
							'menu_use_access' => $use_access,
							'menu_access' => $access,
							'menu_access_level' => $level,
							'menu_type' => $type,
							'menu_cat' => $cat,
							'menu_display' => $display,
							'menu_sim_type' => $sim_type
						);
						
						$update = $this->menu_model->update_menu_item($update_array, $id);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_menu') .' '. lang('labels_item')),
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
								ucfirst(lang('labels_menu') .' '. lang('labels_item')),
								lang('actions_updated'),
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
		
		// grab all the menu items
		$menus = $this->menu_model->get_menu_items('', '', '');
		
		if ($menus->num_rows() > 0)
		{
			foreach ($menus->result() as $m)
			{
				switch ($m->menu_type)
				{
					case 'main':
						$data['menus'][$m->menu_type][$m->menu_id]['id'] = $m->menu_id;
						$data['menus'][$m->menu_type][$m->menu_id]['name'] = $m->menu_name;
						$data['menus'][$m->menu_type][$m->menu_id]['link'] = $m->menu_link;
						$data['menus'][$m->menu_type][$m->menu_id]['display'] = $m->menu_display;
					break;
						
					case 'sub':
						$data['menus'][$m->menu_type][$m->menu_cat]['category'] = ucfirst($m->menu_cat);
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['id'] = $m->menu_id;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['name'] = $m->menu_name;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['link'] = $m->menu_link;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['display'] = $m->menu_display;
					break;
						
					case 'adminsub':
						$cat = $this->menu_model->get_menu_category($m->menu_cat);
						
						$data['menus'][$m->menu_type][$m->menu_cat]['category'] = $cat->menucat_name;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['id'] = $m->menu_id;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['name'] = $m->menu_name;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['link'] = $m->menu_link;
						$data['menus'][$m->menu_type][$m->menu_cat]['items'][$m->menu_id]['display'] = $m->menu_display;
					break;
				}
			}
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
			'cats' => array(
				'src' => Location::img('category.png', $this->skin, 'admin'),
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
		
		$data['header'] = ucfirst(lang('labels_menus'));
		$data['text'] = '';
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_menu') .' '. lang('labels_item') .' '. RARROW),
			'category' => ucfirst(lang('labels_category') .':'),
			'cats' => ucwords(lang('actions_manage') .' '. lang('labels_menu') .' '. 
				lang('labels_categories') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'nav_adminsub' => ucwords(lang('labels_admin') .' '. lang('labels_sub')
				.' '. lang('labels_navigation')),
			'nav_main' => ucwords(lang('labels_main') .' '. lang('labels_navigation')),
			'nav_sub' => ucwords(lang('labels_sub') .' '. lang('labels_navigation')),
			'off' => lang('labels_off'),
			'url' => lang('abbr_url') .':',
		);
		
		$this->_regions['content'] = Location::view('site_menus', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_menus_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function menucats()
	{
		Auth::check_access('site/menus');
		
		// load the resources
		$this->load->model('menu_model');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('menucat_name', true);
					$order = $this->input->post('menucat_order', true);
					$cat = $this->input->post('menucat_menu_cat', true);
					$type = $this->input->post('menucat_type', true);
					
					if (empty($name) || empty($cat))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_menucats'),
							lang('actions_create'),
							lang('labels_menu') .' '. lang('labels_item')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$insert_array = array(
							'menucat_name' => $name,
							'menucat_order' => $order,
							'menucat_menu_cat' => $cat,
							'menucat_type' => $type
						);
						
						$insert = $this->menu_model->add_menu_category($insert_array);
						
						if ($insert > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_menu') .' '. lang('labels_category')),
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
								ucfirst(lang('labels_menu') .' '. lang('labels_category')),
								lang('actions_created'),
								''
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
				
					$delete = $this->menu_model->delete_menu_category($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_menu') .' '. lang('labels_category')),
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
							ucfirst(lang('labels_menu') .' '. lang('labels_category')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('menucat_name', true);
					$order = $this->input->post('menucat_order', true);
					$cat = $this->input->post('menucat_menu_cat', true);
					$id = $this->input->post('id', true);
					$type = $this->input->post('menucat_type', true);
					
					if (empty($name) || empty($cat))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_menucats'),
							lang('actions_update'),
							lang('labels_menu') .' '. lang('labels_item')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$update_array = array(
							'menucat_name' => $name,
							'menucat_order' => $order,
							'menucat_menu_cat' => $cat,
							'menucat_type' => $type
						);
						
						$update = $this->menu_model->update_menu_category($update_array, $id);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_menu') .' '. lang('labels_category')),
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
								ucfirst(lang('labels_menu') .' '. lang('labels_category')),
								lang('actions_updated'),
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
		
		// grab all the menu items
		$categories = $this->menu_model->get_menu_categories();
		
		if ($categories->num_rows() > 0)
		{
			foreach ($categories->result() as $cat)
			{
				$data['cats'][$cat->menucat_id]['id'] = $cat->menucat_id;
				$data['cats'][$cat->menucat_id]['cat'] = $cat->menucat_menu_cat;
				$data['cats'][$cat->menucat_id]['name'] = $cat->menucat_name;
			}
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
			'menu' => array(
				'src' => Location::img('menu.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
		);
		
		$data['header'] = ucwords(lang('labels_menu') .' '. lang('labels_categories'));
		$data['text'] = '';
		
		$data['label'] = array(
			'addcat' => ucwords(lang('actions_add') .' '. lang('labels_menu') .' '. lang('labels_category') .' '. RARROW),
			'category' => ucfirst(lang('labels_category') .':'),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'location' => ucfirst(lang('labels_location') .':'),
			'menus' => ucwords(lang('actions_manage') .' '. lang('labels_menu') .' '. lang('labels_items') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
			'no_skins' => sprintf(lang('error_not_found'), lang('labels_skins')),
		);
		
		$this->_regions['content'] = Location::view('site_menucats', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_menucats_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function messages()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->helper('text');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$label = $this->input->post('message_label', true);
					$key = $this->input->post('message_key', true);
					$content = $this->input->post('message_content');
					$type = $this->input->post('message_type', true);
					
					if (empty($label) || empty($key) || empty($content) || empty($type))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_all'),
							lang('actions_create'),
							lang('labels_site') .' '. lang('labels_message')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$check = $this->msgs->get_message($key);
						
						if ( ! $check)
						{
							$insert_array = array(
								'message_key' => $key,
								'message_label' => $label,
								'message_content' => $content,
								'message_type' => $type
							);
							
							$insert = $this->msgs->insert_new_message($insert_array);
							
							if ($insert > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_site') .' '. lang('labels_message')),
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
									ucfirst(lang('labels_site') .' '. lang('labels_message')),
									lang('actions_created'),
									''
								);

								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						}
						else
						{
							$message = sprintf(
								lang('flash_duplicate_key'),
								lang('labels_site') .' '. lang('labels_message')
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
				
					$delete = $this->msgs->delete_message($id);
					
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_site') .' '. lang('labels_message')),
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
							ucfirst(lang('labels_site') .' '. lang('labels_message')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$label = $this->input->post('message_label', true);
					$key = $this->input->post('message_key', true);
					$content = $this->input->post('message_content');
					$type = $this->input->post('message_type', true);
					$old_key = $this->input->post('old_key', true);
					
					if (empty($label) or empty($key) or empty($type))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_all'),
							lang('actions_update'),
							lang('labels_site') .' '. lang('labels_message')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$update_array = array(
							'message_key' => $key,
							'message_label' => $label,
							'message_content' => $content,
							'message_type' => $type
						);
						
						$update = $this->msgs->update_message($update_array, $old_key);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_site') .' '. lang('labels_message')),
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
								ucfirst(lang('labels_site') .' '. lang('labels_message')),
								lang('actions_updated'),
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
		
		if (isset($type))
		{
			switch ($type)
			{
				case 'title':
					$js_data['tab'] = 0;
				break;
					
				case 'message':
					$js_data['tab'] = 1;
				break;
					
				case 'other':
					$js_data['tab'] = 2;
				break;
			}
		}
		else
		{
			$js_data['tab'] = 0;
		}
		
		// grab all the messages
		$messages = $this->msgs->get_all_messages();
		
		if ($messages->num_rows() > 0)
		{
			foreach ($messages->result() as $msg)
			{
				$data['messages'][$msg->message_type][$msg->message_id]['id'] = $msg->message_id;
				$data['messages'][$msg->message_type][$msg->message_id]['key'] = $msg->message_key;
				$data['messages'][$msg->message_type][$msg->message_id]['label'] = $msg->message_label;
				$data['messages'][$msg->message_type][$msg->message_id]['content'] = word_limiter(strip_tags($msg->message_content, 25));
			}
		}
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'class' => 'image inline_img_left',
				'alt' => ''),
			'edit' => array(
				'src' => Location::img('icon-edit.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
			'delete' => array(
				'src' => Location::img('icon-delete.png', $this->skin, 'admin'),
				'class' => 'image',
				'alt' => ''),
		);
		
		$data['button_submit'] = array(
			'type' => 'submit',
			'class' => 'button-main',
			'name' => 'submit',
			'value' => 'submit',
			'content' => ucwords(lang('actions_submit'))
		);
		
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_messages'));
		$data['text'] = lang('text_add_new_message');
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('status_new') .' '. lang('labels_message')) .' '. RARROW,
			'content' => ucfirst(lang('labels_content')),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'key' => ucfirst(lang('labels_key') .':'),
			'messages' => ucfirst(lang('labels_messages')),
			'name' => ucfirst(lang('labels_name')),
			'no_messages' => sprintf(lang('error_not_found'), lang('labels_site').' '.lang('labels_messages')),
			'other' => ucfirst(lang('labels_other')),
			'titles' => ucwords(lang('labels_page') .' '. lang('labels_titles')),
		);
		
		$this->_regions['content'] = Location::view('site_messages', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_messages_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function rolepagegroups()
	{
		Auth::check_access('site/roles');
		
		// load the resources
		$this->load->model('access_model', 'access');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('group_name', true);
					$order = $this->input->post('group_order', true);
					
					if (empty($name))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_role_groups'),
							lang('actions_create'),
							lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$insert_array = array(
							'group_name' => $name,
							'group_order' => $order
						);
						
						$insert = $this->access->insert_group($insert_array);
						
						if ($insert > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
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
								ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
								lang('actions_created'),
								''
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					$new_group = $this->input->post('new_group', true);
				
					$delete = $this->access->delete_group($id);
					
					if ($delete > 0)
					{
						$where = array('page_group' => $id);
						$update_data = array('page_group' => $new_group);
						
						$update_pages = $this->access->update_pages($update_data, $where);
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
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
							ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('group_name', true);
					$order = $this->input->post('group_order', true);
					$id = $this->input->post('id', true);
					
					if (empty($name))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_role_groups'),
							lang('actions_update'),
							lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$insert_array = array(
							'group_name' => $name,
							'group_order' => $order
						);
						
						$update = $this->access->update_group($id, $insert_array);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
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
								ucfirst(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_group')),
								lang('actions_updated'),
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
		
		// run the methods
		$groups = $this->access->get_page_groups();
		
		if ($groups->num_rows() > 0)
		{
			foreach ($groups->result() as $group)
			{
				$data['groups'][$group->group_id]['id'] = $group->group_id;
				$data['groups'][$group->group_id]['name'] = $group->group_name;
			}
		}
		
		$data['header'] = ucwords(lang('labels_role') .' '. lang('labels_page') .' '. lang('labels_groups'));
		$data['text'] = lang('text_role_groups');
		
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
			'roles' => array(
				'src' => Location::img('role.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'pages' => array(
				'src' => Location::img('page.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_role') .' '. lang('labels_page') .' '.
				lang('labels_group') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'group' => ucwords(lang('labels_group') .' '. lang('labels_name')),
			'pages' => ucwords(lang('actions_manage') .' '. lang('labels_role') .' '. 
				lang('labels_pages') .' '. RARROW),
			'roles' => ucwords(lang('actions_manage') .' '. lang('labels_roles') .' '. RARROW),
		);
		
		$this->_regions['content'] = Location::view('site_rolepagegroups', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_rolepagegroups_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function rolepages()
	{
		Auth::check_access('site/roles');
		
		// load the resources
		$this->load->model('access_model', 'access');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('page_name', true);
					$url = $this->input->post('page_url', true);
					$level = $this->input->post('page_level', true);
					$group = $this->input->post('page_group', true);
					$desc = $this->input->post('page_desc', true);
					
					if (empty($name) || empty($url))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_role_pages'),
							lang('actions_create'),
							lang('labels_role') .' '. lang('labels_page')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$insert_array = array(
							'page_name' => $name,
							'page_url' => $url,
							'page_level' => $level,
							'page_group' => $group,
							'page_desc' => $desc
						);
						
						$insert = $this->access->insert_page($insert_array);
						
						if ($insert > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_role') .' '. lang('labels_page')),
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
								ucfirst(lang('labels_role') .' '. lang('labels_page')),
								lang('actions_created'),
								''
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
				
					$delete = $this->access->delete_page($id);
					
					if ($delete > 0)
					{
						$roles = $this->access->get_roles();
						
						if ($roles->num_rows() > 0)
						{
							foreach ($roles->result() as $role)
							{
								if (strstr($role->role_access, $id) !== false)
								{
									$string = str_replace($id, '', $role->role_access);
									$string = str_replace(',,', ',', $string);
									
									if (substr($string, 0, 1) == ',')
									{
										$string = substr_replace(',', '', 0, 1);
									}
									
									if (substr($string, -1) == ',')
									{
										$string = substr_replace(',', '', -1);
									}
									
									$role_data = array('role_access' => $string);
									
									$update = $this->access->update_role($role->role_id, $role_data);
								}
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('labels_role') .' '. lang('labels_page')),
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
							ucfirst(lang('labels_role') .' '. lang('labels_page')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('page_name', true);
					$url = $this->input->post('page_url', true);
					$level = $this->input->post('page_level', true);
					$group = $this->input->post('page_group', true);
					$desc = $this->input->post('page_desc', true);
					$id = $this->input->post('id', true);
					
					if (empty($name) || empty($url))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_role_pages'),
							lang('actions_update'),
							lang('labels_role') .' '. lang('labels_page')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$update_array = array(
							'page_name' => $name,
							'page_url' => $url,
							'page_level' => $level,
							'page_group' => $group,
							'page_desc' => $desc
						);
						
						$update = $this->access->update_page($id, $update_array);
						
						if ($update > 0)
						{
							$message = sprintf(
								lang('flash_success'),
								ucfirst(lang('labels_role') .' '. lang('labels_page')),
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
								ucfirst(lang('labels_role') .' '. lang('labels_page')),
								lang('actions_updated'),
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
		
		// run the methods
		$pages = $this->access->get_role_pages();
		
		if ($pages->num_rows() > 0)
		{
			foreach ($pages->result() as $page)
			{
				$data['pages']['groups'][$page->page_group]['name'] = $this->access->get_group($page->page_group, 'group_name');
				$data['pages']['groups'][$page->page_group]['pages'][$page->page_id]['id'] = $page->page_id;
				$data['pages']['groups'][$page->page_group]['pages'][$page->page_id]['name'] = $page->page_name;
				$data['pages']['groups'][$page->page_group]['pages'][$page->page_id]['url'] = $page->page_url;
				$data['pages']['groups'][$page->page_group]['pages'][$page->page_id]['desc'] = $page->page_desc;
			}
		}
		
		$data['header'] = ucwords(lang('labels_role') .' '. lang('labels_pages'));
		$data['text'] = lang('text_rolepages');
		
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
			'roles' => array(
				'src' => Location::img('role.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
			'groups' => array(
				'src' => Location::img('group.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'image inline_img_left'),
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_role') .' '. lang('labels_page') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'groups' => ucwords(lang('actions_manage') .' '. lang('labels_role') .' '. lang('labels_page') .' '.
				lang('labels_groups') .' '. RARROW),
			'name' => ucwords(lang('labels_page') .' '. lang('labels_name')),
			'roles' => ucwords(lang('actions_manage') .' '. lang('labels_roles') .' '. RARROW),
			'url' => lang('abbr_url'),
		);
		
		$this->_regions['content'] = Location::view('site_rolepages', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_rolepages_js', $this->skin, 'admin');
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
					$name = $this->input->post('role_name', true);
					$desc = $this->input->post('role_desc', true);
					
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
					$id = $this->input->post('id', true);
					$new_role = $this->input->post('new_role', true);
				
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
					$name = $this->input->post('role_name', true);
					$desc = $this->input->post('role_desc', true);
					
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
					$new_name = $this->input->post('name', true);
					$new_desc = $this->input->post('desc', true);
					$old_role = $this->input->post('role', true);
					
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
	
	public function settings()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('menu_model');
		$this->load->model('ranks_model', 'ranks');
		
		if (isset($_POST['submit']))
		{
			$key_exceptions = array('submit', 'old_sim_type', 'formats');
			
			foreach ($_POST as $key => $value)
			{
				if ( ! in_array($key, $key_exceptions))
				{
					$update_array['setting_value'] = $this->security->xss_clean($value);
					
					$update = $this->settings->update_setting($key, $update_array);
					
					if ($key == 'timezone' && $value != $this->timezone)
					{
						$this->timezone = $this->settings->get_setting('timezone');
					}
				}
			}
			
			if ($update > 0)
			{
				$new_type = $this->input->post('sim_type', true);
				$old_type = $this->input->post('old_sim_type', true);
				
				if ($new_type != $old_type)
				{
					$data_old = array('menu_display' => 'n');
					$data_new = array('menu_display' => 'y');
					
					$this->menu_model->update_menu_item($data_old, $old_type, 'menu_sim_type');
					$this->menu_model->update_menu_item($data_new, $new_type, 'menu_sim_type');
				}
				
				$message = sprintf(
					lang('flash_success_plural'),
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
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
					ucfirst(lang('labels_site') .' '. lang('labels_settings')),
					lang('actions_updated'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab all settings
		$settings = $this->settings->get_all_settings();
		
		if ($settings->num_rows() > 0)
		{
			foreach ($settings->result() as $value)
			{
				$setting[$value->setting_key] = $value->setting_value;
			}
			
			$data['button_submit'] = array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => 'submit',
				'content' => ucwords(lang('actions_submit'))
			);
			
			$data['images'] = array(
				'help' => array(
					'src' => Location::img('help.png', $this->skin, 'admin'),
					'alt' => lang('whats_this')),
				'gear' => array(
					'src' => Location::img('gear.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image inline_img_left'),
				'view' => array(
					'src' => Location::img('icon-view.png', $this->skin, 'admin'),
					'alt' => '',
					'class' => 'image'),
				'loading' => array(
					'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'),
			);
			
			/*
			|---------------------------------------------------------------
			| SIM
			|---------------------------------------------------------------
			*/
			
			$data['inputs'] = array(
				'sim_name' => array(
					'name' => 'sim_name',
					'id' => 'sim_name',
					'value' => $setting['sim_name']),
				'sim_year' => array(
					'name' => 'sim_year',
					'id' => 'sim_year',
					'class' => 'medium',
					'value' => $setting['sim_year'])
			);
			
			$type = $this->settings->get_sim_types();
			
			if ($type->num_rows() > 0)
			{
				$data['values']['sim_type'][0] = ucwords(lang('labels_please') .' '.
					lang('actions_choose') .' '. lang('order_one'));
				
				foreach ($type->result() as $value)
				{
					$data['values']['sim_type'][$value->simtype_id] = ucwords($value->simtype_name);
				}
			}
			
			/*
			|---------------------------------------------------------------
			| SYSTEM/EMAIL
			|---------------------------------------------------------------
			*/
			
			$data['inputs'] += array(
				'sys_email_on' => array(
					'name' => 'system_email',
					'id' => 'sys_email_on',
					'value' => 'on',
					'checked' => ($setting['system_email'] == 'on') ? true : false),
				'sys_email_off' => array(
					'name' => 'system_email',
					'id' => 'sys_email_off',
					'value' => 'off',
					'checked' => ($setting['system_email'] == 'off') ? true : false),
				'email_subject' => array(
					'name' => 'email_subject',
					'id' => 'email_subject',
					'value' => $setting['email_subject']),
				'allowed_playing_chars' => array(
					'name' => 'allowed_chars_playing',
					'id' => 'allowed_chars_playing',
					'value' => $setting['allowed_chars_playing'],
					'class' => 'small'),
				'allowed_npcs' => array(
					'name' => 'allowed_chars_npc',
					'id' => 'allowed_chars_npc',
					'value' => $setting['allowed_chars_npc'],
					'class' => 'small'),
				'maintenance_on' => array(
					'name' => 'maintenance',
					'id' => 'maintenance_on',
					'value' => 'on',
					'checked' => ($setting['maintenance'] == 'on') ? true : false),
				'maintenance_off' => array(
					'name' => 'maintenance',
					'id' => 'maintenance_off',
					'value' => 'off',
					'checked' => ($setting['maintenance'] == 'off') ? true : false),
				'dst_y' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_y',
					'value' => 'true',
					'checked' => (strtolower($setting['daylight_savings']) == 'true') ? true : false),
				'dst_n' => array(
					'name' => 'daylight_savings',
					'id' => 'dst_n',
					'value' => 'false',
					'checked' => (strtolower($setting['daylight_savings']) == 'false') ? true : false),
				'email_name' => array(
					'name' => 'default_email_name',
					'id' => 'default_email_name',
					'value' => $setting['default_email_name']),
				'email_address' => array(
					'name' => 'default_email_address',
					'id' => 'default_email_address',
					'value' => $setting['default_email_address']),
				'online_timespan' => array(
					'name' => 'online_timespan',
					'id' => 'online_timespan',
					'class' => 'small',
					'value' => $setting['online_timespan']),
				'posting_req' => array(
					'name' => 'posting_requirement',
					'value' => $setting['posting_requirement'],
					'class' => 'small'),
				'date_format' => array(
					'name' => 'date_format',
					'id' => 'date_format',
					'value' => $setting['date_format']),
				'participants_y' => array(
					'name' => 'use_post_participants',
					'id' => 'participants_y',
					'value' => 'y',
					'checked' => ($setting['use_post_participants'] == 'y') ? true : false),
				'participants_n' => array(
					'name' => 'use_post_participants',
					'id' => 'participants_n',
					'value' => 'n',
					'checked' => ($setting['use_post_participants'] == 'n') ? true : false),
			);
			
			$data['values']['updates'] = array(
				'all' => ucwords(lang('labels_all') .' '. lang('labels_updates')),
				'major' => ucwords(lang('status_major') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.0, 2.0, etc.)',
				'minor' => ucwords(lang('status_minor') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.1, 1.2, etc.)',
				'update' => ucwords(lang('status_incremental') .' '. lang('labels_updates') .' '. lang('labels_only')) .' (1.0.1, 1.0.2, etc.)',
				'none' => ucwords(lang('labels_no') .' '. lang('labels_updates'))
			);
			
			$data['values']['date_format'] = array(
				'%D %M %j%S, %Y @ %g:%i%a'	=> 'Mon Jan 1st, 2009 @ 12:01am',
				'%D %M %j, %Y @ %g:%i%a'	=> 'Mon Jan 1, 2009 @ 12:01am',
				'%l %F %j%S, %Y @ %g:%i%a'	=> 'Monday January 1st, 2009 @ 12:01am',
				'%l %F %j, %Y @ %g:%i%a'	=> 'Monday January 1, 2009 @ 12:01am',
				'%m/%d/%Y @ %g:%i%a'		=> '01/01/2009 @ 12:01am',
				'%d %M %Y @ %g:%i%a'		=> '01 Jan 2009 @ 12:01am',
			);
			
			if (array_key_exists($setting['date_format'], $data['values']['date_format']))
			{
				$data['values']['date_format'][''] = ucfirst(lang('labels_other'));
			}
			else
			{
				$data['values']['date_format'][$setting['date_format']] = ucfirst(lang('labels_other'));
			}
			
			$data['default']['sim_type'] = $setting['sim_type'];
			$data['default']['updates'] = $setting['updates'];
			$data['default']['date_format'] = $setting['date_format'];
			$data['default']['timezone'] = $setting['timezone'];
			
			/*
			|---------------------------------------------------------------
			| APPEARANCE
			|---------------------------------------------------------------
			*/
			
			$skins = $this->sys->get_all_skins();
			$ranks = $this->ranks->get_all_rank_sets();
			
			if ($skins->num_rows() > 0)
			{
				foreach ($skins->result() as $skin)
				{
					$sections = $this->sys->get_skin_sections($skin->skin_location);
					
					if ($sections->num_rows() > 0)
					{
						foreach ($sections->result() as $section)
						{
							$data['themes'][$section->skinsec_section][$skin->skin_location] = $skin->skin_name;
						}
					}
				}
			}
			
			if ($ranks->num_rows() > 0)
			{
				$ext = $this->ranks->get_rankcat($this->options['display_rank'], 'rankcat_location', 'rankcat_extension');
				
				$data['inputs']['rank'] = array(
					'src' => Location::rank($this->options['display_rank'], 'preview', $ext),
					'alt' => ''
				);
					
				foreach ($ranks->result() as $rank)
				{
					$data['values']['ranks'][$rank->rankcat_location] = $rank->rankcat_name;
				}
			}
			
			$data['inputs'] += array(
				'list_logs_num' => array(
					'name' => 'list_logs_num',
					'id' => 'list_logs_num',
					'class' => 'small',
					'value' => $setting['list_logs_num']),
				'list_posts_num' => array(
					'name' => 'list_posts_num',
					'id' => 'list_posts_num',
					'class' => 'small',
					'value' => $setting['list_posts_num']),
				'show_news_y' => array(
					'name' => 'show_news',
					'id' => 'show_news_y',
					'value' => 'y',
					'checked' => ($setting['show_news'] == 'y') ? true : false),
				'show_news_n' => array(
					'name' => 'show_news',
					'id' => 'show_news_n',
					'value' => 'n',
					'checked' => ($setting['show_news'] == 'n') ? true : false),
				'show_logs_y' => array(
					'name' => 'show_logs',
					'id' => 'show_logs_y',
					'value' => 'y',
					'checked' => ($setting['show_logs'] == 'y') ? true : false),
				'show_logs_n' => array(
					'name' => 'show_logs',
					'id' => 'show_logs_n',
					'value' => 'n',
					'checked' => ($setting['show_logs'] == 'n') ? true : false),
				'show_posts_y' => array(
					'name' => 'show_posts',
					'id' => 'show_posts_y',
					'value' => 'y',
					'checked' => ($setting['show_posts'] == 'y') ? true : false),
				'show_posts_n' => array(
					'name' => 'show_posts',
					'id' => 'show_posts_n',
					'value' => 'n',
					'checked' => ($setting['show_posts'] == 'n') ? true : false),
				'use_mission_notes_y' => array(
					'name' => 'use_mission_notes',
					'id' => 'use_mission_notes_y',
					'value' => 'y',
					'checked' => ($setting['use_mission_notes'] == 'y') ? true : false),
				'use_mission_notes_n' => array(
					'name' => 'use_mission_notes',
					'id' => 'use_mission_notes_n',
					'value' => 'n',
					'checked' => ($setting['use_mission_notes'] == 'n') ? true : false),
				'use_sample_post_y' => array(
					'name' => 'use_sample_post',
					'id' => 'use_sample_post_y',
					'value' => 'y',
					'checked' => ($setting['use_sample_post'] == 'y') ? true : false),
				'use_sample_post_n' => array(
					'name' => 'use_sample_post',
					'id' => 'use_sample_post_n',
					'value' => 'n',
					'checked' => ($setting['use_sample_post'] == 'n') ? true : false),
				'post_count_multi' => array(
					'name' => 'post_count_format',
					'id' => 'post_count_multi',
					'value' => 'multiple',
					'checked' => ($setting['post_count_format'] == 'multiple') ? true : false),
				'post_count_single' => array(
					'name' => 'post_count_format',
					'id' => 'post_count_single',
					'value' => 'single',
					'checked' => ($setting['post_count_format'] == 'single') ? true : false),
			);
			
			$data['default']['skin_main'] = $setting['skin_main'];
			$data['default']['skin_admin'] = $setting['skin_admin'];
			$data['default']['skin_wiki'] = $setting['skin_wiki'];
			$data['default']['skin_login'] = $setting['skin_login'];
		}
		
		/*
		|---------------------------------------------------------------
		| USER ITEMS
		|---------------------------------------------------------------
		*/
		
		$user = $this->settings->get_all_settings('y');
		
		if ($user->num_rows() > 0)
		{
			foreach ($user->result() as $u)
			{
				$data['user'][] = array(
					'id' => $u->setting_id,
					'key' => $u->setting_key,
					'label' => $u->setting_label,
					'value' => $u->setting_value
				);
			}
		}
		
		$data['header'] = ucwords(lang('labels_site') .' '. lang('labels_settings'));
		
		$data['label'] = array(
			'allowed_chars' => ucfirst(lang('labels_number')) .' '. lang('labels_of') .' '. 
				ucwords(lang('labels_allowed') .' '. lang('status_playing') .' '. lang('global_characters')),
			'allowed_npcs' => ucfirst(lang('labels_number')) .' '. lang('labels_of') .' '. 
				ucwords(lang('labels_allowed') .' '. lang('abbr_npcs')),
			'appearance' => ucfirst(lang('labels_appearance')),
			'count_format' => ucwords(lang('global_post') .' '. lang('labels_count') .' '. lang('labels_format')),
			'count_multiple' => ucfirst(lang('labels_multiple')),
			'count_single' => ucfirst(lang('labels_single')),
			'date' => ucwords(lang('labels_date') .' '. lang('labels_format')),
			'date_format' => lang('date_format'),
			'days' => lang('time_days'),
			'dst' => ucwords(lang('labels_dst')),
			'edit' => ucfirst(lang('actions_edit')),
			'emailaddress' => ucwords(lang('labels_default') .' '. lang('labels_email_address')),
			'emailname' => ucwords(lang('labels_default') .' '. lang('labels_email') .' '. lang('labels_name')),
			'emailsubject' => ucwords(lang('labels_email') .' '. lang('labels_subject')),
			'general' => ucfirst(lang('labels_general')),
			'header_email' => ucwords(lang('labels_email') .' '. lang('labels_settings')),
			'header_gen' => ucwords(lang('labels_general') .' '. lang('labels_information')),
			'header_options' => ucwords(lang('labels_display') .' '. lang('labels_options')),
			'header_skins' => ucfirst(lang('labels_skins')),
			'header_system' => ucwords(lang('labels_system') .' '. lang('labels_settings')),
			'header_user' => ucwords(lang('labels_user') .'-'. ucfirst(lang('actions_created')) 
				.' '. lang('labels_settings')),
			'logs_num' => ucwords(lang('global_personallogs')) .' '. lang('labels_per') .' '. ucfirst(lang('labels_page')),
			'maint' => ucwords(lang('labels_maintanance') .' '. lang('labels_mode')),
			'manageuser' => ucwords(lang('actions_manage') .' '. lang('labels_user') .'-'. ucfirst(lang('actions_created')) 
				.' '. lang('labels_settings') .' '. RARROW),
			'manifest' => ucwords(lang('labels_default') .' '. lang('labels_manifest') .' '. lang('labels_display')),
			'minutes' => lang('time_minutes'),
			'name' => ucwords(lang('global_sim') .' '. lang('labels_name')),
			'logs_show' => ucwords(lang('actions_show') .' '. lang('global_personallogs')) .' '. lang('labels_on') .' '.
				ucwords(lang('labels_main') .' '. lang('labels_page')),
			'news_show' => ucwords(lang('actions_show') .' '. lang('global_news')) .' '. lang('labels_on') .' '.
				ucwords(lang('labels_main') .' '. lang('labels_page')),
			'posts_show' => ucwords(lang('actions_show') .' '. lang('global_missionposts')) .' '. lang('labels_on') .' '.
				ucwords(lang('labels_main') .' '. lang('labels_page')),
			'no' => ucfirst(lang('labels_no')),
			'off' => ucfirst(lang('labels_off')),
			'on' => ucfirst(lang('labels_on')),
			'online' => lang('misc_label_online'),
			'posts_num' => ucwords(lang('global_missionposts')) .' '. lang('labels_per') .' '. ucfirst(lang('labels_page')),
			'posts_participants' => ucwords(lang('global_post').' '.lang('labels_participants')),
			'rank' => ucwords(lang('global_rank') .' '. lang('labels_set')),
			'requirement' => ucwords(lang('labels_posting') .' '. lang('labels_requirements')),
			'sample_post' => ucwords(lang('actions_use') .' '. lang('labels_sample_post')) .' '. lang('labels_on') .' '.
				ucwords(lang('actions_join') .' '. lang('labels_page')),
			'sample_output' => lang('sample_output'),
			'skin_admin' => ucwords(lang('labels_admin') .' '. lang('labels_site')),
			'skin_login' => ucwords(lang('actions_login') .' '. lang('labels_page')),
			'skin_main' => ucwords(lang('labels_main') .' '. lang('labels_site')),
			'skin_wiki' => ucfirst(lang('global_wiki')),
			'skins_text' => sprintf(lang('text_skins_global'), site_url('user/options')),
			'sysemail' => ucwords(lang('labels_system') .' '. lang('labels_email')),
			'system' => ucwords(lang('labels_system') .'/'. ucfirst(lang('labels_email'))),
			'timezone' => ucfirst(lang('labels_timezone')),
			'tt_online_timespan' => lang('info_online_timespan'),
			'tt_post_count' => lang('info_post_count_format'),
			'tt_posting_participants' => lang('info_posting_participants'),
			'tt_posting_requirement' => lang('info_posting_req'),
			'type' => ucwords(lang('global_sim') .' '. lang('labels_type')),
			'updates' => ucwords(lang('labels_update') .' '. lang('labels_notification')),
			'use_notes' => ucwords(lang('actions_use') .' '. lang('global_mission') .' '. lang('labels_notes')),
			'user' => ucwords(lang('labels_user') .'-'. lang('actions_created') .' '. lang('labels_settings')),
			'year' => ucwords(lang('global_sim') .' '. lang('time_year')),
			'yes' => ucfirst(lang('labels_yes')),
		);
		
		// set the js data
		$js_data['tab'] = $this->uri->segment(3, 0, true);
		
		$this->_regions['content'] = Location::view('site_settings', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_settings_js', $this->skin, 'admin', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function simtypes()
	{
		Auth::check_access();
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$insert_array = array(
						'simtype_name' => $this->input->post('simtype_name', true),
					);
					
					$insert = $this->sys->add_sim_type($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_sim') .' '. lang('labels_type')),
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
							ucfirst(lang('global_sim') .' '. lang('labels_type')),
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
							{
								$new_key = 'simtype_'. substr($key, ($loc+1));
								$array[$loc_pos][$new_key] = $value;
							}
						}
					}
					
					foreach ($array as $a => $b)
					{
						$update += $this->sys->update_sim_type($a, $b);
					}
					
					foreach ($delete as $del)
					{
						$delete = $this->sys->delete_sim_type($del);
					}
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success_plural'),
							ucfirst(lang('global_sim') .' '. lang('labels_types')),
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
							ucfirst(lang('global_sim') .' '. lang('labels_types')),
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
		
		$types = $this->sys->get_sim_types();
		
		if ($types->num_rows() > 0)
		{
			foreach ($types->result() as $t)
			{
				$tid = $t->simtype_id;
				
				$data['types'][$tid] = array(
					'id' => $tid,
					'name' => array(
						'name' => $tid .'_name',
						'value' => $t->simtype_name),
					'delete' => array(
						'name' => 'delete[]',
						'value' => $tid,
						'id' => $tid .'_id'),
				);
			}
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
				'content' => ucwords(lang('actions_add')))
		);
		
		$data['images'] = array(
			'add' => array(
				'src' => Location::img('icon-add.png', $this->skin, 'admin'),
				'alt' => '',
				'class' => 'inline_img_left')
		);
		
		$data['inputs']['name'] = array(
			'name' => 'simtype_name'
		);
		
		$data['header'] = ucwords(lang('global_sim') .' '. lang('labels_types'));
		$data['text'] = lang('text_site_simtypes');
		
		$data['label'] = array(
			'name' => ucfirst(lang('labels_name')),
			'add' => ucwords(lang('actions_add') .' '. lang('global_sim') .' '. lang('labels_type') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete'))
		);
		
		$this->_regions['content'] = Location::view('site_simtypes', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_simtypes_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function specsform()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('specs_model', 'specs');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$type = $this->input->post('field_type', true);
					$label = $this->input->post('field_label_page', true);
					$name = $this->input->post('field_name', true);
					$id = $this->input->post('field_fid', true);
					$class = $this->input->post('field_class', true);
					$rows = $this->input->post('field_rows', true);
					$order = $this->input->post('field_order', true);
					$display = $this->input->post('field_display', true);
					$select = $this->input->post('select_values', true);
					$section = $this->input->post('field_section', true);
			
					$insert_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_label_page' => $label,
						'field_fid' => $id,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display,
						'field_section' => $section
					);
							
					$insert = $this->specs->add_spec_field($insert_array);
					$insert_id = $this->db->insert_id();
					
					$this->sys->optimize_table('specs_fields');
					
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
								
								$insert = $this->specs->add_spec_field_value($values_array);
								
								++$i;
							}
						}
						
						$data_array = array(
							'data_field' => $insert_id,
							'data_value' => '',
							'data_updated' => now()
						);
								
						$data_insert = $this->specs->add_spec_field_data($data_array);
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = (is_numeric($this->input->post('id', true))) ? $this->input->post('id', true) : 0;
							
					$delete = $this->specs->delete_spec_field($id);
					
					if ($delete > 0)
					{
						$delete_fields = $this->specs->delete_spec_field_data($id);
						$values = $this->specs->get_spec_values($id);
						
						if ($values->num_rows() > 0)
						{
							foreach ($values->result() as $value)
							{
								$delete_values = $this->specs->delete_spec_field_value($value->value_id);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$type = $this->input->post('field_type', true);
					$label = $this->input->post('field_label_page', true);
					$name = $this->input->post('field_name', true);
					$fid = $this->input->post('field_fid', true);
					$class = $this->input->post('field_class', true);
					$rows = $this->input->post('field_rows', true);
					$order = $this->input->post('field_order', true);
					$display = $this->input->post('field_display', true);
					$id = $this->input->post('field_id', true);
					$section = $this->input->post('field_section', true);
					
					$update_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_label_page' => $label,
						'field_fid' => $fid,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display,
						'field_section' => $section
					);
							
					$update = $this->specs->update_spec_field($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_field')),
							lang('actions_updated'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'editval':
					$value = $this->input->post('value_field_value', true);
					$content = $this->input->post('value_content', true);
					$field = $this->input->post('value_field', true);
					$id = $this->input->post('id', true);

					$update_array = array(
						'value_field_value' => $value,
						'value_content' => $content,
						'value_field' => $field
					);

					$update = $this->specs->update_spec_field_value($id, $update_array);

					if ($update > 0)
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$id = $this->uri->segment(4, 0, true);
		
		if ($id == 0)
		{
			$sections = $this->specs->get_spec_sections();
			
			if ($sections->num_rows() > 0)
			{
				foreach ($sections->result() as $sec)
				{
					$data['specs']['sections'][$sec->section_id]['name'] = $sec->section_name;
					
					$fields = $this->specs->get_spec_fields($sec->section_id, '');
					
					if ($fields->num_rows() > 0)
					{
						foreach ($fields->result() as $field)
						{
							$fid = $field->field_id;
							
							$data['specs']['sections'][$sec->section_id]['fields'][$fid]['label'] = $field->field_label_page;
							$data['specs']['sections'][$sec->section_id]['fields'][$fid]['display'] = $field->field_display;
							
							switch ($field->field_type)
							{
								case 'text':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value
									);
									
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_input($input);
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
								break;
											
								case 'textarea':
									$input = array(
										'name' => $field->field_id,
										'id' => $field->field_fid,
										'class' => $field->field_class,
										'value' => $field->field_value,
										'rows' => $field->field_rows
									);
											
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_textarea($input);
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
								break;
											
								case 'select':
									$value = false;
									$values = false;
									$input = false;
											
									$values = $this->specs->get_spec_values($field->field_id);
											
									if ($values->num_rows() > 0)
									{
										foreach ($values->result() as $value)
										{
											$input[$value->value_field_value] = $value->value_content;
										}
									}
											
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['input'] = form_dropdown($field->field_id, $input);
									$data['specs']['sections'][$sec->section_id]['fields'][$fid]['id'] = $field->field_id;
								break;
							}
						}
					}
				}
			}
			
			$data['images'] = array(
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
				'sections' => array(
					'src' => Location::img('forms-section.png', $this->skin, 'admin'),
					'class' => 'image inline_img_left',
					'alt' => ''),
			);
			
			// set the view
			$view_loc = 'site_specsform_all';
			
			$data['header'] = ucwords(lang('global_specifications') .' '. lang('labels_form'));
			$data['text'] = lang('text_specsform');
		}
		else
		{
			$field = $this->specs->get_spec_field_details($id);
			
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
						'checked' => ($row->field_display == 'y') ? true : false),
					'display_n' => array(
						'name' => 'field_display',
						'id' => 'field_display_n',
						'value' => 'n',
						'checked' => ($row->field_display == 'n') ? true : false),
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
				
				$sections = $this->specs->get_spec_sections();
		
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
			
			// set the view
			$view_loc = 'site_specsform_one';
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_specifications') .' '. lang('labels_form'));
			$data['text'] = lang('text_specsform_edit');
			
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
					'value' => 'submit',
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
				$values = $this->specs->get_spec_values($row->field_id);
				
				$data['select'] = false;
				
				if ($values->num_rows() > 0)
				{
					foreach ($values->result() as $value)
					{
						$data['select'][$value->value_id] = $value->value_content;
					}
				}
				
				$data['loading'] = array(
					'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'
				);
				
				$data['inputs']['val_add_value'] = array('id' => 'value');
				$data['inputs']['val_add_content'] = array('id' => 'content');
			}
		}
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('global_specs') .' '. lang('labels_field') .' '. RARROW),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_specs') .' '. lang('labels_form')),
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
			'sections' => ucwords(lang('actions_manage') .' '. lang('global_specs') .' '. 
				lang('labels_sections') .' '. RARROW),
			'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
			'value' => ucwords(lang('labels_dropdown') .' '. lang('labels_value')),
			'values' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu') .' '. lang('labels_values')),
			'yes' => ucfirst(lang('labels_yes')),
			'off' => '[ '.strtoupper(lang('labels_off')).' ]',
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_specsform_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function specssections()
	{
		Auth::check_access('site/specsform');
		
		// load the resources
		$this->load->model('specs_model', 'specs');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$name = $this->input->post('section_name', true);
					$order = $this->input->post('section_order', true);
			
					$insert_array = array(
						'section_name' => $name,
						'section_order' => $order
					);
							
					$insert = $this->specs->add_spec_section($insert_array);
					
					if ($insert > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
							lang('actions_created'),
							lang('flash_additional_specs_section')
						);

						$flash['status'] = 'success';
						$flash['message'] = text_output($message);
					}
					else
					{
						$message = sprintf(
							lang('flash_failure'),
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
							lang('actions_created'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$old_id = $this->input->post('id', true);
					$new_id = $this->input->post('new_sec', true);
					
					$delete = $this->specs->delete_spec_section($old_id);
					$update = $this->specs->update_field_sections($old_id, $new_id);
							
					if ($delete > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
							lang('actions_deleted'),
							''
						);

						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$name = $this->input->post('section_name', true);
					$order = $this->input->post('section_order', true);
					$id = $this->input->post('id', true);
			
					$update_array = array(
						'section_name' => $name,
						'section_order' => $order
					);
							
					$update = $this->specs->update_spec_section($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
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
							ucfirst(lang('global_specification') .' '. lang('labels_section')),
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
		
		$sections = $this->specs->get_spec_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$data['sections'][] = array(
					'id' => $sec->section_id,
					'name' => $sec->section_name
				);
			}
		}
		
		$data['header'] = ucwords(lang('global_specifications') .' '. lang('labels_form') .' '. lang('labels_sections'));
		$data['text'] = lang('text_specssections');
		
		$data['images'] = array(
			'form' => array(
				'src' => Location::img('forms-field.png', $this->skin, 'admin'),
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
			'add' => ucwords(lang('actions_add') .' '. lang('global_specs') .' '. lang('labels_section') .' '. RARROW),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'form' => ucwords(lang('actions_manage') .' '. lang('global_specs') .' '. 
				lang('labels_form') .' '. RARROW),
			'name' => ucfirst(lang('labels_name')),
		);
		
		$this->_regions['content'] = Location::view('site_specssections', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_specssections_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function tourform()
	{
		Auth::check_access();
		
		// load the resources
		$this->load->model('tour_model', 'tour');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$type = $this->input->post('field_type', true);
					$label = $this->input->post('field_label_page', true);
					$name = $this->input->post('field_name', true);
					$id = $this->input->post('field_fid', true);
					$class = $this->input->post('field_class', true);
					$rows = $this->input->post('field_rows', true);
					$order = $this->input->post('field_order', true);
					$display = $this->input->post('field_display', true);
					$select = $this->input->post('select_values', true);
			
					$insert_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_label_page' => $label,
						'field_fid' => $id,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display
					);
							
					$insert = $this->tour->add_tour_field($insert_array);
					$insert_id = $this->db->insert_id();
					
					$this->sys->optimize_table('tour_fields');
					
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
								
								$insert = $this->tour->add_tour_field_value($values_array);
								
								++$i;
							}
						}
						
						$items = $this->tour->get_tour_items();
						
						if ($items->num_rows() > 0)
						{
							foreach ($items->result() as $item)
							{
								$data_array = array(
									'data_tour_item' => $item->tour_id,
									'data_field' => $insert_id,
									'data_value' => '',
									'data_updated' => now()
								);
								
								$data_insert = $this->tour->add_tour_field_data($data_array);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
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
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
							lang('actions_created'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'delete':
					$id = (is_numeric($this->input->post('id', true))) ? $this->input->post('id', true) : 0;
							
					$delete = $this->tour->delete_tour_field($id);
					
					if ($delete > 0)
					{
						$delete_fields = $this->tour->delete_tour_field_data($id);
						$values = $this->tour->get_tour_values($id);
						
						if ($values->num_rows() > 0)
						{
							foreach ($values->result() as $value)
							{
								$delete_values = $this->tour->delete_tour_value($value->value_id);
							}
						}
						
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
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
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
							lang('actions_deleted'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'edit':
					$type = $this->input->post('field_type', true);
					$label = $this->input->post('field_label_page', true);
					$name = $this->input->post('field_name', true);
					$fid = $this->input->post('field_fid', true);
					$class = $this->input->post('field_class', true);
					$rows = $this->input->post('field_rows', true);
					$order = $this->input->post('field_order', true);
					$display = $this->input->post('field_display', true);
					$id = $this->input->post('field_id', true);
					
					$update_array = array(
						'field_name' => $name,
						'field_type' => $type,
						'field_label_page' => $label,
						'field_fid' => $fid,
						'field_class' => $class,
						'field_rows' => $rows,
						'field_order' => $order,
						'field_display' => $display
					);
							
					$update = $this->tour->update_tour_field($id, $update_array);
					
					if ($update > 0)
					{
						$message = sprintf(
							lang('flash_success'),
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
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
							ucfirst(lang('global_tour') .' '. lang('labels_field')),
							lang('actions_updated'),
							''
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
				break;
					
				case 'editval':
					$value = $this->input->post('value_field_value', true);
					$content = $this->input->post('value_content', true);
					$field = $this->input->post('value_field', true);
					$id = $this->input->post('id', true);

					$update_array = array(
						'value_field_value' => $value,
						'value_content' => $content,
						'value_field' => $field
					);

					$update = $this->tour->update_tour_field_value($id, $update_array);

					if ($update > 0)
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
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		$id = $this->uri->segment(4, 0, true);
		
		if ($id == 0)
		{
			$fields = $this->tour->get_tour_fields('');
			
			if ($fields->num_rows() > 0)
			{
				foreach ($fields->result() as $field)
				{
					$fid = $field->field_id;
					
					$data['tour'][$fid]['label'] = $field->field_label_page;
					$data['tour'][$fid]['display'] = $field->field_display;
					
					switch ($field->field_type)
					{
						case 'text':
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => $field->field_value
							);
							
							$data['tour'][$fid]['input'] = form_input($input);
							$data['tour'][$fid]['id'] = $field->field_id;
						break;
									
						case 'textarea':
							$input = array(
								'name' => $field->field_id,
								'id' => $field->field_fid,
								'class' => $field->field_class,
								'value' => $field->field_value,
								'rows' => $field->field_rows
							);
									
							$data['tour'][$fid]['input'] = form_textarea($input);
							$data['tour'][$fid]['id'] = $field->field_id;
						break;
									
						case 'select':
							$value = false;
							$values = false;
							$input = false;
									
							$values = $this->tour->get_tour_values($field->field_id);
									
							if ($values->num_rows() > 0)
							{
								foreach ($values->result() as $value)
								{
									$input[$value->value_field_value] = $value->value_content;
								}
							}
									
							$data['tour'][$fid]['input'] = form_dropdown($field->field_id, $input);
							$data['tour'][$fid]['id'] = $field->field_id;
						break;
					}
				}
			}
			
			$data['images'] = array(
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
			
			// set the view
			$view_loc = 'site_tourform_all';
			
			$data['header'] = ucwords(lang('global_tour') .' '. lang('labels_form'));
			$data['text'] = lang('text_tourform');
		}
		else
		{
			$field = $this->tour->get_tour_field_details($id);
			
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
						'checked' => ($row->field_display == 'y') ? true : false),
					'display_n' => array(
						'name' => 'field_display',
						'id' => 'field_display_n',
						'value' => 'n',
						'checked' => ($row->field_display == 'n') ? true : false),
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
				
				$data['defaults']['type'] = $row->field_type;
			}
			
			// set the view
			$view_loc = 'site_tourform_one';
			
			$data['header'] = ucwords(lang('actions_edit') .' '. lang('global_tour') .' '. lang('labels_form'));
			$data['text'] = lang('text_tourform_edit');
			
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
					'value' => 'submit',
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
				$values = $this->tour->get_tour_values($row->field_id);
				
				$data['select'] = false;
				
				if ($values->num_rows() > 0)
				{
					foreach ($values->result() as $value)
					{
						$data['select'][$value->value_id] = $value->value_content;
					}
				}
				
				$data['loading'] = array(
					'src' => Location::img('loading-circle.gif', $this->skin, 'admin'),
					'alt' => lang('actions_loading'),
					'class' => 'image'
				);
				
				$data['inputs']['val_add_value'] = array('id' => 'value');
				$data['inputs']['val_add_content'] = array('id' => 'content');
			}
		}
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('global_tour') .' '. lang('labels_field')) .' '. RARROW,
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucwords(lang('global_tour') .' '. lang('labels_form')),
			'bioval' => lang('text_site_bioval'),
			'class' => ucfirst(lang('labels_class')),
			'content' => ucwords(lang('labels_dropdown') .' '. lang('labels_content')),
			'display' => ucfirst(lang('labels_display')),
			'html' => lang('misc_html_attr'),
			'id' => lang('abbr_id'),
			'label' => ucwords(lang('labels_page') .' '. lang('labels_label')),
			'name' => ucfirst(lang('labels_name')),
			'no' => ucfirst(lang('labels_no')),
			'order' => ucfirst(lang('labels_order')),
			'rows' => lang('misc_textarea_rows'),
			'type' => ucwords(lang('labels_field') .' '. lang('labels_type')),
			'value' => ucwords(lang('labels_dropdown') .' '. lang('labels_value')),
			'values' => ucwords(lang('labels_dropdown') .' '. lang('labels_menu') .' '. lang('labels_values')),
			'yes' => ucfirst(lang('labels_yes')),
			'off' => '[ '.strtoupper(lang('labels_off')).' ]',
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_tourform_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function usersettings()
	{
		Auth::check_access('site/settings');
		
		if (isset($_POST['submit']))
		{
			switch ($this->uri->segment(3))
			{
				case 'add':
					$label = $this->input->post('setting_label', true);
					$key = $this->input->post('setting_key', true);
					$value = $this->input->post('setting_value', true);
					
					if (empty($label) || empty($key))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_all'),
							lang('actions_create'),
							lang('labels_site') .' '. lang('labels_setting')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$check = $this->settings->get_setting($key);
						
						if ( ! $check)
						{
							$insert_array = array(
								'setting_key' => $key,
								'setting_label' => $label,
								'setting_value' => $value
							);
							
							$insert = $this->settings->add_new_setting($insert_array);
							
							if ($insert > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_site') .' '. lang('labels_setting')),
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
									ucfirst(lang('labels_site') .' '. lang('labels_setting')),
									lang('actions_created'),
									''
								);

								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						}
						else
						{
							$message = sprintf(
								lang('flash_duplicate_key'),
								lang('labels_site') .' '. lang('labels_setting')
							);

							$flash['status'] = 'error';
							$flash['message'] = text_output($message);
						}
					}
				break;
					
				case 'delete':
					$id = $this->input->post('id', true);
					
					$get = $this->settings->get_setting_details($id, 'setting_id');
					
					if ($get->num_rows() > 0)
					{
						$item = $get->row();
						
						if ($item->setting_user_created == 'y')
						{
							$delete = $this->settings->delete_setting($id);
							
							if ($delete > 0)
							{
								$message = sprintf(
									lang('flash_success'),
									ucfirst(lang('labels_site') .' '. lang('labels_setting')),
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
									ucfirst(lang('labels_site') .' '. lang('labels_setting')),
									lang('actions_deleted'),
									''
								);

								$flash['status'] = 'error';
								$flash['message'] = text_output($message);
							}
						}
						else
						{
							$flash['status'] = 'error';
							$flash['message'] = lang_output('flash_settings_delete_nonuser');
						}
					}
				break;
					
				case 'edit':
					$label = $this->input->post('setting_label', true);
					$key = $this->input->post('setting_key', true);
					$content = $this->input->post('setting_value', true);
					$id = $this->input->post('id', true);
					
					if (empty($label) || empty($key) || empty($content))
					{
						$message = sprintf(
							lang('flash_empty_fields'),
							lang('flash_fields_all'),
							lang('actions_update'),
							lang('labels_site') .' '. lang('labels_setting')
						);
						
						$flash['status'] = 'error';
						$flash['message'] = text_output($message);
					}
					else
					{
						$get = $this->settings->get_setting_details($id, 'setting_id');
					
						if ($get->num_rows() > 0)
						{
							$item = $get->row();
							
							if ($item->setting_user_created == 'y')
							{
								$update_array = array(
									'setting_key' => $key,
									'setting_label' => $label,
									'setting_value' => $content
								);
								
								$update = $this->settings->update_setting($key, $update_array);
								
								if ($update > 0)
								{
									$message = sprintf(
										lang('flash_success'),
										ucfirst(lang('labels_site') .' '. lang('labels_setting')),
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
										ucfirst(lang('labels_site') .' '. lang('labels_setting')),
										lang('actions_updated'),
										''
									);

									$flash['status'] = 'error';
									$flash['message'] = text_output($message);
								}
							}
							else
							{
								$flash['status'] = 'error';
								$flash['message'] = lang_output('flash_settings_edit_nonuser');
							}
						}
					}
				break;
			}
			
			// set the flash message
			$this->_regions['flash_message'] = Location::view('flash', $this->skin, 'admin', $flash);
		}
		
		// grab all settings
		$settings = $this->settings->get_all_settings('y');
		
		if ($settings->num_rows() > 0)
		{
			foreach ($settings->result() as $value)
			{
				$data['settings'][$value->setting_id] = $value->setting_label;
			}
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
				'class' => 'image')
		);
		
		$data['label'] = array(
			'add' => ucwords(lang('actions_add') .' '. lang('labels_user') .'-'. 
				ucfirst(lang('actions_created')) .' '. lang('labels_setting')),
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. 
				ucwords(lang('labels_site') .' '. lang('labels_settings')),
			'delete' => ucfirst(lang('actions_delete')),
			'edit' => ucfirst(lang('actions_edit')),
			'name' => ucfirst(lang('labels_name')),
			'no_settings' => sprintf(lang('error_not_found'), lang('global_user').'-'.lang('actions_created').' '.lang('labels_settings')),
		);
		
		$data['header'] = ucwords(lang('labels_user') .'-'. ucfirst(lang('actions_created')) .' '. lang('labels_settings'));
		$data['text'] = lang('text_add_new_setting');
		
		$this->_regions['content'] = Location::view('site_usersettings', $this->skin, 'admin', $data);
		$this->_regions['javascript'] = Location::js('site_usersettings_js', $this->skin, 'admin');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
