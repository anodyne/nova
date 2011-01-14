<?php
/**
 * Main controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		2.0
 */

require_once MODPATH.'core/libraries/Nova_main_controller'.EXT;

class Nova_sim extends Nova_main_controller {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_regions['nav_sub'] = Menu::build('sub', 'sim');
	}

	public function index()
	{
		$data['header'] = ucwords(lang('labels_the') .' '. lang('global_sim'));
		$data['msg_sim'] = $this->msgs->get_message('sim');
		
		$this->_regions['content'] = Location::view('sim_index', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function awards()
	{
		$this->load->model('awards_model', 'awards');
		$this->load->helper('inflector');
		
		// make sure the award id is legit
		$award = $this->uri->segment(3, 0, TRUE);
		
		if ($award == 0)
		{
			$awards = $this->awards->get_all_awards();
			
			if ($awards->num_rows() > 0)
			{
				$i = 1;
				foreach ($awards->result() as $row)
				{
					$award_img = array(
						'src' => Location::asset('images/awards', $row->award_image),
						'alt' => $row->award_name,
						'class' => 'image award-small'
					);
					
					$data['awards'][$i]['id'] = $row->award_id;
					$data['awards'][$i]['name'] = $row->award_name;
					$data['awards'][$i]['desc'] = $row->award_desc;
					$data['awards'][$i]['cat'] = $row->award_cat;
					$data['awards'][$i]['img'] = $data['awards'][$i]['img'] = $award_img;
					
					++$i;
				}
			}
			
			// other data used by the template
			$data['header'] = ucwords(lang('labels_crew') .' '. lang('global_awards'));
			
			// the name of the view file
			$view_loc = 'sim_awards_all';
		}
		else
		{
			// get the title
			$title = ucwords(lang('actions_view') .' '. lang('global_award') .' - ');
			
			// run the methods
			$award_row = $this->awards->get_award($award);
			$awardees = $this->awards->get_awardees($award);
			
			if ($award_row !== FALSE)
			{
				$award_img = array(
					'src' => Location::asset('images/awards', $award_row->award_image),
					'alt' => $award_row->award_name,
					'class' => 'image'
				);
						
				$data['name'] = $award_row->award_name;
				$data['id'] = $award_row->award_id;
				$data['desc'] = $award_row->award_desc;
				$data['img'] = FALSE;
				
				if ($award_img['src'] != FALSE)
				{
					$data['img'] = $award_img;
				}
				
				switch ($award_row->award_cat)
				{
					case 'both':
						$data['cat'] = ucfirst($award_row->award_cat);
					break;
					
					case 'ic':
						$data['cat'] = lang('labels_ic');
					break;
						
					case 'ooc':
						$data['cat'] = lang('labels_ooc');
					break;
				}
				
				if ($awardees->num_rows() > 0)
				{
					$i = 1;
					$datestring = $this->options['date_format'];
					
					foreach ($awardees->result() as $item)
					{
						$date = gmt_to_local($item->awardrec_date, $this->timezone, $this->dst);
						
						$data['awardees'][$i]['date'] = mdate($datestring, $date);
						$data['awardees'][$i]['reason'] = $item->awardrec_reason;
						
						switch ($award_row->award_cat)
						{
							case 'both':
								$data['awardees'][$i]['person'] = $this->char->get_character_name($item->awardrec_character);
							break;
								
							case 'ic':
								$data['awardees'][$i]['person'] = $this->char->get_character_name($item->awardrec_character);
							break;
								
							case 'ooc':
								$data['awardees'][$i]['person'] = $this->user->get_user($item->awardrec_user, 'name');
							break;
						}
						
						++$i;
					}
					
					$times = ($awardees->num_rows() == 1) ? singular(lang('labels_times')) : lang('labels_times');
					
					$data['awardees_count'] = $awardees->num_rows() .' '. $times;
				}
				else
				{
					$data['awardees_count'] = '0 '. lang('labels_times');
					$data['msg_error'] = lang('error_msg_no_awardees');
				}
				
				// other data used by the template
				$data['header'] = $title . $data['name'];
				
				// the name of the view
				$view_loc = 'sim_awards_one';
			}
			else
			{
				// name of the view file
				$view_loc = 'error';
				
				// other data used by the template
				$data['header'] = lang('error_head_not_found');
				$data['msg_error'] = lang('error_msg_not_found');
			}
		}
		
		$data['edit_valid'] = (Auth::is_logged_in() and Auth::check_access('manage/awards', false)) ? true : false;
		
		$data['label'] = array(
			'awarded' => ucwords(lang('actions_awarded')) .':',
			'back' => LARROW .' '. ucwords(lang('actions_back')) .' '.
				lang('labels_to') .' '.
				ucwords(lang('global_awards')),
			'category' => ucwords(lang('labels_category')) .':',
			'details' => ucfirst(lang('labels_details')),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
			'noawards' => ucfirst(lang('error_no_awards')),
		);
		
		$this->_regions['content'] = Location::view($view_loc, $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('sim_awards_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function decks($item = false)
	{
		$this->load->model('tour_model', 'tour');
		$this->load->model('specs_model', 'specs');
		
		if ($item)
		{
			// run the methods
			$decks = $this->tour->get_decks($item);
			
			if ($decks->num_rows() > 0)
			{
				foreach ($decks->result() as $row)
				{
					$data['decks'][$row->deck_id]['name'] = $row->deck_name;
					$data['decks'][$row->deck_id]['content'] = $row->deck_content;
				}
			}
		}
		else
		{
			// get all the specification items
			$specs = $this->specs->get_spec_items();
			
			// start with an empty array
			$data['specs'] = array();
			
			if ($specs->num_rows() > 0)
			{
				foreach ($specs->result() as $s)
				{
					$data['specs'][$s->specs_id] = array(
						'name' => $s->specs_name,
						'desc' => $s->specs_summary
					);
				}
			}
		}
		
		// set the header
		$data['header'] = ucwords(lang('global_deck') .' '. lang('labels_listing'));
		
		// determine if they can edit
		$data['edit_valid'] = (Auth::is_logged_in() and Auth::check_access('manage/decks', false)) ? true : false;
		
		$data['label'] = array(
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
			'nodecks' => lang('error_no_decks'),
		);
		
		$this->_regions['content'] = Location::view('sim_decks', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('sim_decks_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function departments()
	{
		$this->load->model('depts_model', 'dept');
		$this->load->model('positions_model', 'pos');
		
		$depts_data = $this->dept->get_all_depts();
		
		if ($depts_data->num_rows() > 0)
		{
			$i = 1;
			foreach ($depts_data->result() as $row)
			{
				$name = $this->dept->get_manifest($row->dept_manifest, 'manifest_name');
				$manifest = ($name == '') ? FALSE : ' <span class="fontTiny gray">('.$name.')</span>';
				
				$data['depts'][$i]['name'] = $row->dept_name.$manifest;
				$data['depts'][$i]['desc'] = $row->dept_desc;
				$data['depts'][$i]['id'] = $row->dept_id;
				
				// grab the positions
				$main_positions = $this->pos->get_dept_positions($row->dept_id);
				
				if ($main_positions->num_rows() > 0)
				{
					foreach ($main_positions->result() as $pos1)
					{
						$data['depts'][$i]['positions'][$pos1->pos_id]['name'] = $pos1->pos_name;
						$data['depts'][$i]['positions'][$pos1->pos_id]['desc'] = $pos1->pos_desc;
					}
				}
				
				// grab the sub depts
				$subdepts = $this->dept->get_sub_depts($row->dept_id);
				
				if ($subdepts->num_rows() > 0)
				{
					$j = 1;
					foreach ($subdepts->result() as $sub)
					{ /* populate the sub dept data */
						$data['depts'][$i]['subs'][$j]['name'] = $sub->dept_name;
						$data['depts'][$i]['subs'][$j]['desc'] = $sub->dept_desc;
						$data['depts'][$i]['subs'][$j]['id'] = $sub->dept_id;
						
						// grab the positions
						$sub_positions = $this->pos->get_dept_positions($sub->dept_id);
						
						if ($sub_positions->num_rows() > 0)
						{
							foreach ($sub_positions->result() as $pos2)
							{
								$data['depts'][$i]['subs'][$j]['positions'][$pos2->pos_id]['name'] = $pos2->pos_name;
								$data['depts'][$i]['subs'][$j]['positions'][$pos2->pos_id]['desc'] = $pos2->pos_desc;
							}
						}
						
						++$j;
					}
				}
				
				++$i;
			}
			
			// set the header
			$data['header'] = ucwords(lang('global_departments') .' &amp; '. lang('global_positions'));
		}
		else
		{
			$data['header'] = $title;
			$data['msg_error'] = lang('error_msg_no_depts');
		}
		
		$data['edit_valid_dept'] = (Auth::is_logged_in() and Auth::check_access('manage/depts', false)) ? true : false;
		$data['edit_valid_pos'] = (Auth::is_logged_in() and Auth::check_access('manage/positions', false)) ? true : false;
		
		$data['label'] = array(
			'edit_dept' => '[ '. ucfirst(lang('actions_edit').' '.lang('global_departments')) .' ]',
			'edit_pos' => '[ '. ucfirst(lang('actions_edit').' '.lang('global_positions')) .' ]',
			'showhide' => lang('labels_showhide_positions'),
			'toggle' => ucwords(lang('actions_toggle').' '.lang('global_positions')),
		);
		
		$this->_regions['content'] = Location::view('sim_depts', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('sim_depts_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	function docked()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id !== FALSE)
		{
			/* grab the docked item */
			$item = $this->docking->get_docked_item($id);
			
			if ($item !== FALSE)
			{
				/* set the date format */
				$datestring = $this->options['date_format'];
				
				/* set the date */
				$date = gmt_to_local($item->docking_date, $this->timezone, $this->dst);
				
				$data['docked'] = array(
					'sim_name' => $item->docking_sim_name,
					'sim_url' => $item->docking_sim_url,
					'gm_name' => $item->docking_gm_name,
					'id' => $item->docking_id,
					'date' => mdate($datestring, $date)
				);
				
				/* run the methods */
				$sections = $this->docking->get_docking_sections();
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $sec)
					{
						$data['sections'][$sec->section_id]['title'] = $sec->section_name;
						
						/* get the fields */
						$fields = $this->docking->get_docking_fields($sec->section_id);
						
						if ($fields->num_rows() > 0)
						{
							foreach ($fields->result() as $field)
							{
								/* grab the data for the fields */
								$field_data = $this->docking->get_field_data($field->field_id, $data['docked']['id']);
								
								if ($field_data->num_rows() > 0)
								{
									foreach ($field_data->result() as $item)
									{
										$data['sections'][$sec->section_id]['fields'][] = array(
											'field' => $field->field_label_page,
											'data' => $item->data_value
										);
									}
								}
							}
						}
					}
				}
				
				/* send the variables to the view */
				$data['header'] = ucwords(lang('actions_docked') .' '. lang('global_sim') .' - '. $data['docked']['sim_name']);
			}
			else
			{
				/* send the variables to the view */
				$data['header'] = ucwords(lang('actions_docked') .' '. lang('global_sim'));
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('sim_docked_one', $this->skin, 'main');
		}
		else
		{
			$items = $this->docking->get_docked_items();
		
			if ($items->num_rows() > 0)
			{
				foreach ($items->result() as $i)
				{
					if ($i->docking_status != 'pending')
					{
						$data['docked'][$i->docking_status][] = array(
							'sim_name' => $i->docking_sim_name,
							'sim_url' => $i->docking_sim_url,
							'gm_name' => $i->docking_gm_name,
							'id' => $i->docking_id
						);
					}
				}
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('sim_docked_all', $this->skin, 'main');
			
			/* send the variables to the view */
			$data['header'] = ucwords(lang('actions_docked') .' '. lang('global_sims'));
		}
		
		/* figure out where the js view should be coming from */
		$js_loc = js_location('sim_docked_js', $this->skin, 'main');
		
		$data['images'] = array(
			'view' => array(
				'src' => img_location('icon-view.png', $this->skin, 'main'),
				'alt' => lang('actions_view'),
				'title' => ucfirst(lang('actions_view'))
			)
		);
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('actions_docked') .' '. lang('global_sims')),
			'docked_current' => ucwords(lang('status_current') .' '. lang('actions_docked') .' '. lang('global_sims')),
			'docked_previous' => ucwords(lang('status_previous') .' '. lang('actions_docked') .' '. lang('global_sims')),
			'gm_name' => ucfirst(lang('labels_name')),
			'name' => ucwords(lang('global_sim') .' '. lang('labels_name')),
			'norequests' => sprintf(lang('error_not_found'), lang('actions_docked') .' '. lang('labels_items')),
			'nosim' => sprintf(lang('error_not_found'), lang('actions_docked') .' '. lang('global_sim')),
			'received' => ucfirst(lang('actions_received')),
		);
	
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function dockingrequest()
	{
		/* load the resources */
		$this->load->model('docking_model', 'docking');
		
		if ($this->options['system_email'] == 'off')
		{
			$flash['status'] = 'info';
			$flash['message'] = lang_output('flash_system_email_off');
			
			// set the location of the flash view
			$flashloc = view_location('flash', $this->skin, 'main');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', $flashloc, $flash);
		}
		
		if (isset($_POST['submit']))
		{
			$check = $this->input->post('check', TRUE);
			
			if (!empty($check))
			{
				$message = sprintf(
					lang('flash_failure'),
					ucfirst(lang('actions_docking') .' '. lang('actions_request')),
					lang('actions_submitted'),
					''
				);
				
				$flash['status'] = 'error';
				$flash['message'] = text_output($message);
			}
			else
			{
				foreach ($_POST as $key => $value)
				{
					if (!is_numeric($key))
					{
						$insert_array[$key] = $this->input->xss_clean($value);
					}
				}
				
				$insert_array['docking_date'] = now();
				
				/* take unnecessary items off the array */
				unset($insert_array['check']);
				unset($insert_array['submit']);
				
				/* put the record into the database */
				$insert = $this->docking->insert_docking_record($insert_array);
				
				/* grab the insert ID */
				$dock_id = $this->db->insert_id();
				
				/* optimize the table */
				$this->sys->optimize_table('docking');
				
				foreach ($_POST as $key => $value)
				{
					if (is_numeric($key))
					{
						$array = array(
							'data_field' => $key,
							'data_docking_item' => $dock_id,
							'data_value' => $value,
							'data_updated' => now()
						);
						
						$this->docking->insert_docking_data($array);
					}
				}
				
				if ($insert > 0)
				{
					$message = sprintf(
						lang('flash_success'),
						ucfirst(lang('actions_docking') .' '. lang('actions_request')),
						lang('actions_submitted'),
						''
					);
					
					$flash['status'] = 'success';
					$flash['message'] = text_output($message);
					
					$email_data = array(
						'name' => $this->input->post('docking_gm_name', TRUE),
						'email' => $this->input->post('docking_gm_email', TRUE)
					);
					
					$email = ($this->options['system_email'] == 'on') ? $this->_email('docking_user', $email_data) : FALSE;
					$email = ($this->options['system_email'] == 'on') ? $this->_email('docking_gm', $dock_id) : FALSE;
				}
				else
				{
					$message = sprintf(
						lang('flash_failure'),
						ucfirst(lang('actions_docking') .' '. lang('actions_request')),
						lang('actions_submitted'),
						''
					);
					
					$flash['status'] = 'error';
					$flash['message'] = text_output($message);
				}
			}
			
			// set the location of the flash view
			$flashloc = view_location('flash', $this->skin, 'main');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', $flashloc, $flash);
		}
		
		/* grab the join fields */
		$sections = $this->docking->get_docking_sections();
		
		if ($sections->num_rows() > 0)
		{
			foreach ($sections->result() as $sec)
			{
				$sid = $sec->section_id; /* section id */
				
				/* set the section name */
				$data['docking'][$sid]['name'] = $sec->section_name;
				
				/* grab the fields for the given section */
				$fields = $this->docking->get_docking_fields($sec->section_id);
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						$f_id = $field->field_id; /* field id */
						
						/* set the page label */
						$data['docking'][$sid]['fields'][$f_id]['field_label'] = $field->field_label_page;
						
						switch ($field->field_type)
						{
							case 'text':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => $field->field_value
								);
								
								$data['docking'][$sid]['fields'][$f_id]['input'] = form_input($input);
							break;
								
							case 'textarea':
								$input = array(
									'name' => $field->field_id,
									'id' => $field->field_fid,
									'class' => $field->field_class,
									'value' => $field->field_value,
									'rows' => $field->field_rows
								);
								
								$data['docking'][$sid]['fields'][$f_id]['input'] = form_textarea($input);
							break;
								
							case 'select':
								$value = FALSE;
								$values = FALSE;
								$input = FALSE;
							
								$values = $this->docking->get_docking_values($field->field_id);
								
								if ($values->num_rows() > 0)
								{
									foreach ($values->result() as $value)
									{
										$input[$value->value_field_value] = $value->value_content;
									}
								}
								
								$data['docking'][$sid]['fields'][$f_id]['input'] = form_dropdown($field->field_id, $input);
							break;
						}
					}
				}
			}
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('sim_dockingrequest', $this->skin, 'main');
		
		/* send the variables to the view */
		$data['header'] = ucwords(lang('actions_docking') .' '. lang('actions_request'));
		$data['docking_inst'] = lang('text_sim_dockingrequest');
		
		/* inputs */
		$data['inputs'] = array(
			'sim_name' => array(
				'name' => 'docking_sim_name',
				'id' => 'sim_name'),
			'sim_url' => array(
				'name' => 'docking_sim_url',
				'id' => 'sim_url'),
			'gm_name' => array(
				'name' => 'docking_gm_name',
				'id' => 'gm_name'),
			'gm_email' => array(
				'name' => 'docking_gm_email',
				'id' => 'gm_email'),
			'check' => array(
				'name' => 'check',
				'id' => 'check',
				'style' => 'background:transparent; border:1px solid transparent; color:transparent'),
		);
		
		/* submit button */
		$data['button_submit'] = array(
			'type' => 'submit',
			'class' => 'button-main',
			'name' => 'submit',
			'value' => 'submit',
			'content' => ucwords(lang('actions_submit'))
		);
		
		$data['label'] = array(
			'check' => ucfirst(lang('text_leave_blank')),
			'gm_email' => ucwords(lang('labels_email_address')),
			'gm_info' => ucwords(lang('global_game_master') .' '. lang('labels_information')),
			'gm_name' => ucfirst(lang('labels_name')),
			'info' => ucwords(lang('global_sim') .' '. lang('labels_information')),
			'name' => ucwords(lang('global_sim') .' '. lang('labels_name')),
			'r_duration' => ucfirst(lang('labels_duration')),
			'r_explain' => ucfirst(lang('labels_reason')),
			'r_info' => ucwords(lang('actions_docking') .' '. lang('labels_information')),
			'url' => ucwords(lang('global_sim') .' '. lang('abbr_url')),
		);
	
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function listlogs()
	{
		/* load the libraries */
		$this->load->library('pagination');
		
		/* load the model */
		$this->load->model('personallogs_model', 'logs');
		
		/* define the variables */
		$data = FALSE;
		$offset = $this->uri->segment(3, 0, TRUE);
		
		/* set the pagination configs */
		$config['base_url'] = site_url('sim/listlogs');
		$config['total_rows'] = $this->logs->count_all_logs();
		$config['per_page'] = $this->options['list_logs_num'];
		$config['full_tag_open'] = '<p>';
		$config['full_tag_close'] = '</p>';
	
		/* initialize the pagination library */
		$this->pagination->initialize($config);
		
		/* create the page links */
		$data['pagination'] = $this->pagination->create_links('logs');
		
		/* run the method */
		$logs = $this->logs->get_log_list($config['per_page'], $offset);
		
		if ($logs->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			
			foreach ($logs->result() as $log)
			{
				$date = gmt_to_local($log->log_date, $this->timezone, $this->dst);
				
				$data['logs'][$log->log_id]['id'] = $log->log_id;
				$data['logs'][$log->log_id]['title'] = $log->log_title;
				$data['logs'][$log->log_id]['author'] = $this->char->get_character_name($log->log_author_character, TRUE);
				$data['logs'][$log->log_id]['date'] = mdate($datestring, $date);
			}
		}
		
		$data['header'] = ucwords(lang('global_personallogs'));
		
		if ($config['total_rows'] < $this->options['list_logs_num'])
		{
			$data['display'] = sprintf(
				lang('text_display_x_of_y'),
				$config['total_rows'],
				$config['total_rows'],
				lang('global_personallogs')
			);
		}
		else
		{
			$data['display'] = sprintf(
				lang('text_display_x_of_y'),
				$this->options['list_logs_num'],
				$config['total_rows'],
				lang('global_personallogs')
			);
		}
		
		$data['label'] = array(
			'author' => ucfirst(lang('labels_author')),
			'nologs' => lang('error_no_logs'),
			'on' => lang('labels_on'),
			'title' => ucfirst(lang('labels_title')),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('sim_listlogs', $this->skin, 'main');
		$js_loc = js_location('sim_listlogs_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function listposts()
	{
		/* define the variables */
		$data = FALSE;
		$mission = FALSE;
		$mission = $this->uri->segment(4, FALSE, TRUE);
		
		/* get the title */
		$title = ucwords(lang('global_missionposts'));
		
		/* load the models */
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		/* load the libraries */
		$this->load->library('pagination');
		
		if ($mission === FALSE)
		{
			$offset = $this->uri->segment(3, 0, TRUE);
		
			/* set the pagination configs */
			$config['base_url'] = site_url('sim/listposts/');
			$config['total_rows'] = $this->posts->count_all_posts();
			$config['per_page'] = $this->options['list_posts_num'];
			$config['full_tag_open'] = '<p class="fontMedium bold">';
			$config['full_tag_close'] = '</p>';
		
			/* initialize the pagination library */
			$this->pagination->initialize($config);
			
			/* create the page links */
			$data['pagination'] = $this->pagination->create_links();
			
			/* run the method */
			$posts = $this->posts->get_post_list('', 'desc', $config['per_page'], $offset, 'activated');
		}
		else
		{
			$offset = $this->uri->segment(5, 0, TRUE);
		
			/* set the pagination configs */
			$config['base_url'] = site_url('sim/listposts/mission/'. $mission .'/');
			$config['total_rows'] = $this->posts->count_all_posts($mission);
			$config['per_page'] = $this->options['list_posts_num'];
			$config['uri_segment'] = 5;
			$config['full_tag_open'] = '<p class="fontMedium bold">';
			$config['full_tag_close'] = '</p>';
		
			/* initialize the pagination library */
			$this->pagination->initialize($config);
			
			/* create the page links */
			$data['pagination'] = $this->pagination->create_links();
			
			/* run the method */
			$posts = $this->posts->get_post_list($mission, 'desc', $config['per_page'], $offset, 'activated');
		}
		
		if ($posts->num_rows() > 0)
		{
			$datestring = $this->options['date_format'];
			
			foreach ($posts->result() as $post)
			{
				$date = gmt_to_local($post->post_date, $this->timezone, $this->dst);
				
				$data['posts'][$post->post_id]['id'] = $post->post_id;
				$data['posts'][$post->post_id]['title'] = $post->post_title;
				$data['posts'][$post->post_id]['author'] = $this->char->get_authors($post->post_authors, TRUE);
				$data['posts'][$post->post_id]['date'] = mdate($datestring, $date);
				$data['posts'][$post->post_id]['mission'] = $this->mis->get_mission($post->post_mission, 'mission_title');
				$data['posts'][$post->post_id]['mission_id'] = $post->post_mission;
			}
			
			if ($mission == FALSE)
			{ /* if no mission is specified */
				$this->template->write('title', $title);
				$data['header'] = $title;
			}
			else
			{
				/* set the mission name */
				$mission_name = $this->mis->get_mission($mission, 'mission_title');
				
				if (!is_numeric($mission) || empty($mission_name))
				{ /* if there isn't a mission or mission name */
					$this->template->write('title', $title);
					$data['header'] = $title;
				}
				else
				{
					$this->template->write('title', $title .' - '. $mission_name);
					$data['header'] = $mission_name;
				}
			}
		}
		else
		{
			/* write the title */
			$this->template->write('title', $title);
			
			/* set the header */
			$data['header'] = $title;
		}
		
		if ($config['total_rows'] < $this->options['list_posts_num'])
		{
			$data['display'] = sprintf(
				lang('text_display_x_of_y'),
				$config['total_rows'],
				$config['total_rows'],
				lang('global_missionposts')
			);
		}
		else
		{
			$data['display'] = sprintf(
				lang('text_display_x_of_y'),
				$this->options['list_posts_num'],
				$config['total_rows'],
				lang('global_missionposts')
			);
		}
		
		$data['label'] = array(
			'by' => lang('labels_by'),
			'date' => ucfirst(lang('labels_date')),
			'mission' => ucfirst(lang('global_mission')) .':',
			'noposts' => lang('error_no_posts'),
			'title' => ucfirst(lang('labels_title')),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('sim_listposts', $this->skin, 'main');
		$js_loc = js_location('sim_listposts_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function missions()
	{
		/* set the variables */
		$type = $this->uri->segment(3);
		$id = $this->uri->segment(4, FALSE, TRUE);
		
		/* load the models */
		$this->load->model('missions_model', 'mis');
		$this->load->model('posts_model', 'posts');
		
		$data['label'] = array();
		
		/* get the title */
		$title = ucfirst(lang('global_missions'));
		
		switch ($type)
		{
			case 'id':
				if ($id === FALSE)
				{
					$missions = $this->mis->get_all_missions('current');
					
					if ($missions->num_rows() > 0)
					{
						$row = $missions->last_row();
						$id = $row->mission_id;
					}
				}
				
				if ($id !== FALSE)
				{
					$row = (!isset($row)) ? $this->mis->get_mission($id) : $row;
					
					if ($row !== FALSE)
					{
						$this->template->write('title', $title .' - '. $row->mission_title);
						
						if (!empty($row->mission_images))
						{
							$images = explode(',', $row->mission_images);
							$images_count = count($images);
							
							/* set the source */
							$src = asset_location('images/missions', trim($images[0]));
							
							/* build the mission image array */
							$data['mission_img'] = array(
								'src' => $src,
								'alt' => $row->mission_title,
								'class' => 'image reflect'
							);
							
							// set the empty image array to avoid errors
							$data['image_array'] = array();
							
							/* build the array of the rest of the images */
							for ($i=1; $i < $images_count; $i++)
							{
								$src = asset_location('images/missions', trim($images[$i]));
								
								/* build the array */
								$data['image_array'][] = array(
									'src' => $src,
									'alt' => $row->mission_title,
									'class' => 'image'
								);
							}
						}
						
						/* data for the view */
						$data['header'] = $row->mission_title;
						$data['mission'] = $row->mission_id;
						
						/* basic mission info */
						$data['info_header'] = ucwords(lang('global_mission') .' '. lang('labels_info'));
						$data['basic']['desc'] = $row->mission_desc;
						$data['basic']['status'] = ucfirst($row->mission_status);
						$data['basic']['start'] = mdate($this->options['date_format'], gmt_to_local($row->mission_start, $this->timezone, $this->dst));
						$data['basic']['end'] = NULL;
						$data['basic']['group'] = $this->mis->get_mission_group($row->mission_group, array('misgroup_id', 'misgroup_name'));
						
						if (!empty($row->mission_end))
						{
							$data['basic']['end'] = mdate($this->options['date_format'], gmt_to_local($row->mission_end, $this->timezone, $this->dst));
						}
						
						/* summary data */
						$data['summary']['title'] = ucwords(lang('global_mission') .' '. lang('labels_summary'));
						$data['summary']['content'] = $row->mission_summary;
						
						/* grab the last 25 posts */
						$posts = $this->posts->get_post_list($row->mission_id, 'desc', 25, '', 'activated');
						
						if ($posts->num_rows() > 0)
						{
							$data['posts_header'] = ucwords(lang('global_missionposts'));
							
							foreach ($posts->result() as $post)
							{
								$pid = $post->post_id;
								
								$data['posts'][$pid]['id'] = $post->post_id;
								$data['posts'][$pid]['title'] = $post->post_title;
								$data['posts'][$pid]['authors'] = $this->char->get_authors($post->post_authors);
								$data['posts'][$pid]['timeline'] = $post->post_timeline;
								$data['posts'][$pid]['location'] = $post->post_location;
							}
						}
						
						/* figure out where the view should be coming from */
						$view_loc = view_location('sim_missions_one', $this->skin, 'main');
					}
					else
					{
						/* figure out where the view should be coming from */
						$view_loc = view_location('error', $this->skin, 'main');
					
						/* set the data for the view */
						$data['header'] = lang('error_head_not_found');
						$data['msg_error'] = lang('error_msg_no_mission');
						
						/* set the page title */
						$this->template->write('title', lang('error_pagetitle'));
					}
				}
			break;
				
			case 'group':
				if ($id === FALSE)
				{
					$groups = $this->mis->get_all_mission_groups();
					
					if ($groups->num_rows() > 0)
					{
						foreach ($groups->result() as $g)
						{
							$data['groups'][$g->misgroup_id] = array(
								'id' => $g->misgroup_id,
								'name' => $g->misgroup_name,
								'desc' => $g->misgroup_desc,
								'count' => $this->mis->get_mission_where(array('mission_group' => $g->misgroup_id))
							);
						}
					}
					
					$title = ucwords(lang('global_mission') .' '. lang('labels_groups'));
					$data['header'] = $title;
					
					/* figure out where the view should be coming from */
					$view_loc = view_location('sim_missions_groups_all', $this->skin, 'main');
					
					/* set the page title */
					$this->template->write('title', $title);
				}
				else
				{
					$group = $this->mis->get_mission_group($id);
					
					if ($group !== FALSE)
					{
						$data['group'] = array(
							'id' => $group->misgroup_id,
							'name' => $group->misgroup_name,
							'desc' => $group->misgroup_desc,
							'posts' => 0
						);
						
						$missions = $this->mis->get_mission_where(array('mission_group' => $group->misgroup_id), 'full');
						
						if ($missions->num_rows() > 0)
						{
							foreach ($missions->result() as $m)
							{
								// set the order
								$order = $m->mission_order;
								
								// make sure all of the items will show up
								$order = (isset($data['group']['missions'][$order])) ? NULL : $order;
								
								$data['group']['missions'][$order] = array(
									'id' => $m->mission_id,
									'title' => $m->mission_title,
									'desc' => $m->mission_desc,
									'count' => $this->posts->count_mission_posts($m->mission_id, $this->options['post_count_format'])
								);
								
								$data['group']['posts'] += $data['group']['missions'][$order]['count'];
							}
							
							// sort the array of missions
							ksort($data['group']['missions']);
						}
						
						$title = ucwords(lang('global_mission') .' '. lang('labels_group') .' - '. $group->misgroup_name);
						$data['header'] = $group->misgroup_name;
					}
					else
					{
						$title = ucwords(lang('global_mission') .' '. lang('labels_group'));
						$data['header'] = $title;
					}
					
					/* figure out where the view should be coming from */
					$view_loc = view_location('sim_missions_groups_one', $this->skin, 'main');
					
					/* set the page title */
					$this->template->write('title', $title);
				}
			break;
			
			default:
				$missions = $this->mis->get_all_missions();
				
				$data['label']['s_current'] = ucwords(lang('status_current') .' '. lang('global_missions'));
				$data['label']['s_completed'] = ucwords(lang('status_completed') .' '. lang('global_missions'));
				$data['label']['s_upcoming'] = ucwords(lang('status_upcoming') .' '. lang('global_missions'));
				
				if ($missions->num_rows() > 0)
				{
					foreach ($missions->result() as $row)
					{
						$mid = $row->mission_id;
						$status = $row->mission_status;
						
						$data['missions'][$status][$mid]['id'] = $row->mission_id;
						$data['missions'][$status][$mid]['title'] = $row->mission_title;
						$data['missions'][$status][$mid]['desc'] = $row->mission_desc;
						$data['missions'][$status][$mid]['count'] = $this->posts->count_mission_posts($row->mission_id, $this->options['post_count_format']);
						$data['missions'][$status][$mid]['group'] = $this->mis->get_mission_group($row->mission_group, array('misgroup_id', 'misgroup_name'));
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
				
				/* other data used by the view */
				$data['header'] = $title;
				
				if (Auth::is_logged_in() === TRUE && Auth::check_access('manage/missions', FALSE) === TRUE)
				{
					$data['edit_valid'] = TRUE;
				}
				else
				{
					$data['edit_valid'] = FALSE;
				}
				
				/* figure out where the view should be coming from */
				$view_loc = view_location('sim_missions_all', $this->skin, 'main');
				
				/* write the data to the template */
				$this->template->write('title', $title);
			break;
		}
		
		$data['label'] += array(
			'backgroups' => LARROW .' '. ucwords(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_mission') .' '. lang('labels_groups')),
			'basicinfo' => ucwords(lang('labels_basic') .' '. lang('labels_info')),
			'by' => lang('labels_by'),
			'count' => ucwords(lang('global_post') .' '. lang('labels_count')) .':',
			'count_missions' => ucfirst(lang('global_missions')) .':',
			'count_posts_group' => ucwords(lang('labels_group') .' '. lang('global_post') .' '. lang('labels_count')) .':',
			'date_end' => ucwords(lang('status_end') .' '. lang('labels_date')),
			'date_start' => ucwords(lang('status_start') .' '. lang('labels_date')),
			'desc' => ucfirst(lang('labels_desc')),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
			'group' => ucwords(lang('global_mission') .' '. lang('labels_group')),
			'included' => ucwords(lang('labels_included') .' '. lang('global_missions')),
			'location' => ucfirst(lang('labels_location')),
			'mission' => ucfirst(lang('global_mission')),
			'missions' => LARROW .' '. ucwords(lang('actions_back')) .' '.
				lang('labels_to') .' '.
				ucwords(lang('global_missions')),
			'nogroup' => sprintf(lang('error_not_found'), lang('global_mission') .' '. lang('labels_group')),
			'nogroups' => sprintf(lang('error_not_found'), lang('global_mission') .' '. lang('labels_groups')),
			'nomissions' => lang('error_no_missions'),
			'noposts' => lang('error_no_posts'),
			'nosummary' => lang('error_no_mission_summary'),
			'open_gallery' => lang('open_gallery'),
			'partof' => ucfirst(lang('labels_part') .' '. lang('labels_of')),
			'posts' => ucfirst(lang('global_posts')),
			'status' => ucfirst(lang('labels_status')),
			'summary' => ucfirst(lang('labels_summary')),
			'timeline' => ucfirst(lang('labels_timeline')),
			'title' => ucfirst(lang('labels_title')),
			'view_all_posts' => ucwords(
				lang('actions_viewall') .' '.
				lang('global_posts') .' '. RARROW),
		);
		
		/* figure out where the js view should be coming from */
		$js_loc = js_location('sim_missions_js', $this->skin, 'main');
		
		/* write the data to the region */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function specs()
	{
		/* load the models */
		$this->load->model('specs_model', 'specs');
		
		/* grab the title */
		$title = ucfirst(lang('global_specifications'));
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id === FALSE)
		{
			/* run the methods */
			$specs = $this->specs->get_spec_items();
			
			if ($specs->num_rows() > 0)
			{
				foreach ($specs->result() as $item)
				{
					$data['items'][$item->specs_id]['id'] = $item->specs_id;
					$data['items'][$item->specs_id]['name'] = $item->specs_name;
					$data['items'][$item->specs_id]['summary'] = $item->specs_summary;
				}
			}
			
			/* set the header */
			$data['header'] = $title;
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('sim_specs_all', $this->skin, 'main');
			
			/* set the title */
			$this->template->write('title', $title);
		}
		else
		{
			/* run the methods */
			$item = $this->specs->get_spec_item($id);
			
			if ($item !== FALSE)
			{
				/* set the data being sent to the view */
				$data['name'] = $item->specs_name;
				$data['summary'] = $item->specs_summary;
				
				if ($item->specs_images > '')
				{ /* make sure there are actually images */
					/* get the images */
					$images = explode(',', $item->specs_images);
					$images_count = count($images);
				
					/* set the image */
					$data['images']['main_img'] = array(
						'src' => asset_location('images/specs', trim($images[0])),
						'class' => 'image reflect',
						'width' => 400
					);
					
					for ($i=1; $i < $images_count; $i++)
					{
						/* build the array */
						$data['images']['image_array'][] = array(
							'src' => asset_location('images/specs', trim($images[$i])),
							'class' => 'image'
						);
					}
				}
				
				/* run the methods */
				$sections = $this->specs->get_spec_sections();
				
				if ($sections->num_rows() > 0)
				{
					foreach ($sections->result() as $sec)
					{
						/* get the fields */
						$fields = $this->specs->get_spec_fields($sec->section_id);
						
						if ($fields->num_rows() > 0)
						{
							foreach ($fields->result() as $field)
							{
								/* grab the data for the fields */
								$item = $this->specs->get_field_data($id, $field->field_id);
								
								if ($item !== FALSE && !empty($item->data_value))
								{
									$data['sections'][$sec->section_id]['title'] = $sec->section_name;
									
									$data['sections'][$sec->section_id]['fields'][] = array(
										'field' => $field->field_label_page,
										'data' => $item->data_value
									);
								}
							}
						}
					}
				}
				
				/* set the header */
				$data['header'] = $title .' - '. $data['name'];
				
				/* figure out where the view should be coming from */
				$view_loc = view_location('sim_specs_one', $this->skin, 'main');
				
				/* set the title */
				$this->template->write('title', $title .' - '. $data['name']);
			}
			else
			{
				/* set the header */
				$data['header'] = lang('error_head_not_found');
				$data['msg_error'] = lang('error_msg_not_found');
				
				/* figure out where the view should be coming from */
				$view_loc = view_location('error', $this->skin, 'main');
				
				/* set the title */
				$this->template->write('title', lang('error_pagetitle'));
			}
		}
		
		if (Auth::is_logged_in() === TRUE && Auth::check_access('manage/specs', FALSE) === TRUE)
		{
			$data['edit_valid'] = TRUE;
		}
		else
		{
			$data['edit_valid'] = FALSE;
		}
		
		if (Auth::is_logged_in() === TRUE && Auth::check_access('site/specsform', FALSE) === TRUE)
		{
			$data['edit_valid_form'] = TRUE;
		}
		else
		{
			$data['edit_valid_form'] = FALSE;
		}
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('global_specs')),
			'desc' => ucfirst(lang('labels_desc')),
			'edit' => '[ '. ucwords(lang('actions_edit') .' '. lang('global_specs') .' '. lang('labels_items')) .' ]',
			'edit_form' => '[ '. ucwords(lang('actions_edit') .' '. lang('global_specs') .' '. lang('labels_form')) .' ]',
			'info' => ucwords(lang('labels_addtl_info')),
			'name' => ucfirst(lang('labels_name')),
			'nospecs_all' => lang('error_no_specs'),
			'opengallery' => lang('open_gallery'),
			'summary' => ucfirst(lang('labels_summary')),
		);
		
		/* set the javascript location */
		$js_loc = js_location('sim_specs_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function stats()
	{
		/* grab the title */
		$title = ucfirst(lang('labels_stats'));
		
		/* load the models */
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		
		/* set the times */
		$today = getdate();
		
		/* this month */
		$this_month_mysql = $today['year'] .'-'. $today['mon'] .'-01 00:00:00';
		$this_month = human_to_unix($this_month_mysql, TRUE);
		
		/* last month */
		$year = ($today['mon'] == 1) ? $today['year'] - 1 : $today['year'];
		$month = ($today['mon'] == 1) ? 12 : $today['mon'] - 1;
		$last_month_mysql = $year .'-'. $month .'-01 00:00:00';
		$last_month = human_to_unix($last_month_mysql, TRUE);
		
		/* next month */
		$year = ($today['mon'] == 12) ? $today['year'] + 1 : $today['year'];
		$month = ($today['mon'] == 12) ? '01' : $today['mon'] + 1;
		$next_month_mysql = $year .'-'. $month .'-01 00:00:00';
		$next_month = human_to_unix($next_month_mysql, TRUE);
		
		/* days in the months */
		$days = date('t');

		/* run the methods */
		$data['users'] = array(
			'current' => $this->user->count_users('current', $this_month, $last_month),
			'previous' => $this->user->count_users('previous', $this_month, $last_month)
		);
		
		$data['characters'] = array(
			'current' => $this->char->count_characters('active', 'current', $this_month, $last_month),
			'previous' => $this->char->count_characters('active', 'previous', $this_month, $last_month)
		);
		
		$data['npcs'] = array(
			'current' => $this->char->count_characters('npc', 'current', $this_month, $last_month),
			'previous' => $this->char->count_characters('npc', 'previous', $this_month, $last_month)
		);
		
		$data['posts'] = array(
			'current' => $this->posts->count_posts($this_month, $next_month, $this->options['post_count_format']),
			'previous' => $this->posts->count_posts($last_month, $this_month, $this->options['post_count_format'])
		);
		
		$data['logs'] = array(
			'current' => $this->logs->count_logs($this_month, $next_month),
			'previous' => $this->logs->count_logs($last_month, $this_month)
		);
		
		$data['post_totals'] = array(
			'current' => $data['posts']['current'] + $data['logs']['current'],
			'previous' => $data['posts']['previous'] + $data['logs']['previous'],
		);
		
		$data['avg_posts'] = array(
			'current' => ($data['posts']['current'] > 0) ? round($data['posts']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['posts']['previous'] > 0) ? round($data['posts']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['avg_logs'] = array(
			'current' => ($data['logs']['current'] > 0) ? round($data['logs']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['logs']['previous'] > 0) ? round($data['logs']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['avg_totals'] = array(
			'current' => ($data['post_totals']['current'] > 0) ? round($data['post_totals']['current'] / $data['users']['current'], 2) : 0,
			'previous' => ($data['post_totals']['previous'] > 0) ? round($data['post_totals']['previous'] / $data['users']['previous'], 2) : 0
		);
		
		$data['pace'] = array(
			'posts' => round((($data['posts']['current']) / ($today['mday'])) * $days, 2),
			'logs' => round((($data['logs']['current']) / ($today['mday'])) * $days, 2),
			'total' => round((($data['post_totals']['current']) / ($today['mday'])) * $days, 2)
		);
		
		/* set the header */
		$data['header'] = $title;
		
		$data['label'] = array(
			'avgentries' => lang('abbr_avg') .' '. ucwords(lang('labels_entries') .' / '. lang('global_user')),
			'avglogs' => lang('abbr_avg') .' '. ucwords(lang('global_personallogs') .' / '. lang('global_user')),
			'avgposts' => lang('abbr_avg') .' '. ucwords(lang('global_missionposts') .' / '. lang('global_user')),
			'lastmonth' => ucwords(lang('order_last') .' '. lang('time_month')),
			'logs' => ucwords(lang('global_personallogs')),
			'npcs' => lang('abbr_npcs'),
			'pacelogs' => ucwords(lang('global_personallogs') .' '. lang('labels_pace')),
			'paceposts' => ucwords(lang('global_missionposts') .' '. lang('labels_pace')),
			'pacetotal' => ucwords(lang('labels_totals') .' '. lang('labels_pace')),
			'users' => ucfirst(lang('global_users')),
			'playing_chars' => ucwords(lang('status_playing') .' '. lang('global_characters')),
			'posts' => ucwords(lang('global_missionposts')),
			'statsavg' => lang('text_stats_avg'),
			'statspace' => lang('text_stats_pace'),
			'thismonth' => ucwords(lang('labels_this') .' '. lang('time_month')),
			'totals' => ucwords(lang('labels_totals')),
		);
		
		/* figure out where the view file should be coming from */
		$view_loc = view_location('sim_stats', $this->skin, 'main');
		$js_loc = js_location('sim_stats_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $title);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function tour()
	{
		/* grab the title */
		$title = ucfirst(lang('global_tour'));
		
		/* load the models */
		$this->load->model('tour_model', 'tour');
		$this->load->model('specs_model', 'specs');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		if ($id === FALSE)
		{
			/* run the methods */
			$tour = $this->tour->get_tour_items();
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
					$specitem = (!empty($item->tour_spec_item)) ? $item->tour_spec_item : 0;
					
					// set the order
					$order = $item->tour_order;
					
					// make sure all of the items will show up
					$order = (isset($data['tour'][$specitem][$order])) ? NULL : $order;
					
					$data['tour'][$specitem][$order]['id'] = $item->tour_id;
					$data['tour'][$specitem][$order]['name'] = $item->tour_name;
					$data['tour'][$specitem][$order]['summary'] = $item->tour_summary;
				}
			}
			
			/* set the header */
			$data['header'] = $title;
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('sim_tour_all', $this->skin, 'main');
			
			/* set the title */
			$this->template->write('title', $title);
		}
		else
		{
			/* run the methods */
			$tour = $this->tour->get_tour_item($id);
			
			if ($tour->num_rows() > 0)
			{
				/* grab the item object */
				$item = $tour->row();
				
				/* set the data being sent to the view */
				$data['name'] = $item->tour_name;
				$data['summary'] = $item->tour_summary;
				
				if ($item->tour_images > '')
				{ /* make sure there are actually images */
					/* get the images */
					$images = explode(',', $item->tour_images);
					$images_count = count($images);
				
					/* set the image */
					$data['images']['main_img'] = array(
						'src' => asset_location('images/tour', trim($images[0])),
						'alt' => $data['name'],
						'class' => 'image reflect',
						'width' => 400
					);
					
					// create the empty array
					$data['images']['image_array'] = array();
					
					for ($i=1; $i < $images_count; $i++)
					{
						/* build the array */
						$data['images']['image_array'][] = array(
							'src' => asset_location('images/tour', trim($images[$i])),
							'alt' => $data['name'],
							'class' => 'image'
						);
					}
				}
				
				/* grab the dynamic elements */
				$fields = $this->tour->get_tour_fields();
				
				if ($fields->num_rows() > 0)
				{
					foreach ($fields->result() as $field)
					{
						/* get the data for this field */
						$info = $this->tour->get_tour_data($id, $field->field_id);
						
						/* put the data into the data array */
						$data['fields'][$field->field_id]['label'] = $field->field_label_page;
						$data['fields'][$field->field_id]['data'] = (!empty($info->data_value)) ? $info->data_value : FALSE;
					}
				}
				
				/* set the header */
				$data['header'] = $title .' - '. $data['name'];
				
				/* figure out where the view should be coming from */
				$view_loc = view_location('sim_tour_one', $this->skin, 'main');
				
				/* set the title */
				$this->template->write('title', $title .' - '. $data['name']);
			}
			else
			{
				/* set the header */
				$data['header'] = lang('error_head_not_found');
				$data['msg_error'] = lang('error_msg_not_found');
				
				/* figure out where the view should be coming from */
				$view_loc = view_location('error', $this->skin, 'main');
				
				/* set the title */
				$this->template->write('title', lang('error_pagetitle'));
			}
		}
		
		if (Auth::is_logged_in() === TRUE && Auth::check_access('manage/tour', FALSE) === TRUE)
		{
			$data['edit_valid'] = TRUE;
		}
		else
		{
			$data['edit_valid'] = FALSE;
		}
		
		if (Auth::is_logged_in() === TRUE && Auth::check_access('site/tourform', FALSE) === TRUE)
		{
			$data['edit_valid_form'] = TRUE;
		}
		else
		{
			$data['edit_valid_form'] = FALSE;
		}
		
		$data['label'] = array(
			'back' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '. ucwords(lang('global_touritems')),
			'desc' => ucfirst(lang('labels_desc')),
			'edit' => '[ '. ucwords(lang('actions_edit') .' '.
				lang('global_touritems')) .' ]',
			'edit_form' => '[ '. ucwords(lang('actions_edit') .' '.
				lang('global_tour') .' '. lang('labels_form')) .' ]',
			'info' => ucwords(lang('labels_addtl_info')),
			'name' => ucfirst(lang('labels_name')),
			'notour_all' => lang('error_no_tour_all'),
			'opengallery' => lang('open_gallery'),
			'summary' => ucfirst(lang('labels_summary')),
			'viewspec' => ucwords(lang('actions_view') .' '. lang('global_specifications') .' '. RARROW),
		);
		
		/* set the javascript location */
		$js_loc = js_location('sim_tour_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewlog()
	{
		/* set the some variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		/* load the model */
		$this->load->model('personallogs_model', 'logs');
		
		if ($this->session->userdata('userid') !== FALSE && isset($_POST['submit']))
		{
			$comment_text = $this->input->post('comment_text');
			
			if (!empty($comment_text))
			{
				$status = $this->user->checking_moderation('log_comment', $this->session->userdata('userid'));
				
				/* build the insert array */
				$insert = array(
					'lcomment_content' => $comment_text,
					'lcomment_log' => $id,
					'lcomment_date' => now(),
					'lcomment_author_character' => $this->session->userdata('main_char'),
					'lcomment_author_user' => $this->session->userdata('userid'),
					'lcomment_status' => $status
				);
				
				/* insert the data */
				$add = $this->logs->add_log_comment($insert);
				
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
					
					if ($status == 'pending')
					{
						/* set the array of data for the email */
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'log' => $id,
							'comment' => $comment_text);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('log_comment_pending', $email_data) : FALSE;
					}
					else
					{
						/* get the user id */
						$user = $this->logs->get_log($id, 'log_author_user');
						
						/* get the author's preference */
						$pref = $this->user->get_pref('email_new_log_comments', $user);
						
						if ($pref == 'y')
						{
							/* set the array of data for the email */
							$email_data = array(
								'author' => $this->session->userdata('main_char'),
								'log' => $id,
								'comment' => $comment_text);
							
							/* send the email */
							$email = ($this->options['system_email'] == 'on') ? $this->_email('log_comment', $email_data) : FALSE;
						}
					}
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
			
			// set the location of the flash view
			$flashloc = view_location('flash', $this->skin, 'main');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', $flashloc, $flash);
		}
		
		/* fire the methods to get the log and its comments */
		$logs = $this->logs->get_log($id);
		$comments = $this->logs->get_log_comments($id);
		
		if ($logs !== FALSE)
		{
			/* grab the next and previous IDs */
			$next = $this->logs->get_link_id($id);
			$prev = $this->logs->get_link_id($id, 'prev');
			
			/* set the date format */
			$datestring = $this->options['date_format'];
			
			/* set the date */
			$date = gmt_to_local($logs->log_date, $this->timezone, $this->dst);
			
			if ($logs->log_date < $logs->log_last_update)
			{
				$edited = gmt_to_local($logs->log_last_update, $this->timezone, $this->dst);
				$data['update'] = mdate($datestring, $edited);
			}
		
			$data['id'] = $logs->log_id;
			$data['title'] = $logs->log_title;
			$data['content'] = $logs->log_content;
			$data['date'] = mdate($datestring, $date);
			$data['author'] = $this->char->get_character_name($logs->log_author_character, TRUE);
			$data['tags'] = (!empty($logs->log_tags)) ? $logs->log_tags : NULL;
			
			/* determine if they can edit the log */
			if (Auth::is_logged_in() === TRUE && ( (Auth::get_access_level('manage/logs') == 2) ||
				(Auth::get_access_level('manage/logs') == 1 && $this->session->userdata('userid') == $logs->log_author_user)))
			{
				$data['edit_valid'] = TRUE;
			}
			else
			{
				$data['edit_valid'] = FALSE;
			}
			
			if ($next !== FALSE)
			{
				$data['next'] = $next;
			}
			
			if ($prev !== FALSE)
			{
				$data['prev'] = $prev;
			}
		}
		
		/* image parameters */
		$data['images'] = array(
			'next' => array(
				'src' => img_location('next.png', $this->skin, 'main'),
				'alt' => ucfirst(lang('actions_next')),
				'class' => 'image'),
			'prev' => array(
				'src' => img_location('previous.png', $this->skin, 'main'),
				'alt' => ucfirst(lang('status_previous')),
				'class' => 'image'),
			'feed' => array(
				'src' => img_location('feed.png', $this->skin, 'main'),
				'alt' => lang('labels_subscribe'),
				'class' => 'image'),
			'comment' => array(
				'src' => img_location('comment-add.png', $this->skin, 'main'),
				'alt=' => '',
				'class' => 'inline_img_left image'),
		);
		
		$data['comment_count'] = $comments->num_rows();
		
		if ($comments->num_rows() > 0)
		{
			$i = 1;
			foreach ($comments->result() as $c)
			{
				$date = gmt_to_local($c->lcomment_date, $this->timezone, $this->dst);
				
				$data['comments'][$i]['author'] = $this->char->get_character_name($c->lcomment_author_character, TRUE);
				$data['comments'][$i]['content'] = $c->lcomment_content;
				$data['comments'][$i]['date'] = mdate($datestring, $date);
				
				++$i;
			}
		}
		
		$data['label'] = array(
			'addcomment' => ucfirst(lang('actions_add')) .' '. lang('labels_a') .' '.
				ucfirst(lang('labels_comment')),
			'by' => lang('labels_by'),
			'comments' => ucfirst(lang('labels_comments')),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
			'edited' => ucfirst(lang('actions_edited') .' '. lang('labels_on')),
			'on' => lang('labels_on'),
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'tags' => ucfirst(lang('labels_tags')) .':',
			'title' => ucfirst(lang('labels_title')),
			'view_log' => ucwords(lang('actions_view') .' '. lang('global_log')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('sim_viewlog', $this->skin, 'main');
		$js_loc = js_location('sim_viewlog_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['title']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewpost()
	{
		/* set the some variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		/* load the models */
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		if ($this->session->userdata('userid') !== FALSE && isset($_POST['submit']))
		{
			$comment_text = $this->input->post('comment_text');
			
			if (!empty($comment_text))
			{
				$status = $this->user->checking_moderation('post_comment', $this->session->userdata('userid'));
				
				/* build the insert array */
				$insert = array(
					'pcomment_content' => $comment_text,
					'pcomment_post' => $id,
					'pcomment_date' => now(),
					'pcomment_author_user' => $this->session->userdata('userid'),
					'pcomment_author_character' => $this->session->userdata('main_char'),
					'pcomment_status' => $status
				);
				
				/* insert the data */
				$add = $this->posts->add_post_comment($insert);
				
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
					
					if ($status == 'pending')
					{
						/* set the array of data for the email */
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'post' => $id,
							'comment' => $comment_text);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('post_comment_pending', $email_data) : FALSE;
					}
					else
					{
						/* set the array of data for the email */
						$email_data = array(
							'author' => $this->session->userdata('main_char'),
							'post' => $id,
							'comment' => $comment_text);
						
						/* send the email */
						$email = ($this->options['system_email'] == 'on') ? $this->_email('post_comment', $email_data) : FALSE;
					}
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
			
			// set the location of the flash view
			$flashloc = view_location('flash', $this->skin, 'main');
			
			/* write everything to the template */
			$this->template->write_view('flash_message', $flashloc, $flash);
		}
		
		/* get the news item */
		$row = $this->posts->get_post($id);
		$comments = $this->posts->get_post_comments($id);
		
		/* set the date format */
		$datestring = $this->options['date_format'];
		
		if ($row !== FALSE)
		{
			$date = gmt_to_local($row->post_date, $this->timezone, $this->dst);
			
			if ($row->post_date < $row->post_last_update)
			{
				$edited = gmt_to_local($row->post_last_update, $this->timezone, $this->dst);
				$data['update'] = mdate($datestring, $edited);
			}
			
			/* grab the next and previous IDs */
			$next = $this->posts->get_link_id($id);
			$prev = $this->posts->get_link_id($id, 'prev');
			
			/* set the data being sent to the view */
			$data['mission'] = $this->mis->get_mission($row->post_mission, 'mission_title');
			$data['mission_id'] = $row->post_mission;
			$data['title'] = $row->post_title;
			$data['content'] = $row->post_content;
			$data['date'] = mdate($datestring, $date);
			$data['author'] = $this->char->get_authors($row->post_authors);
			$data['tags'] = $row->post_tags;
			$data['location'] = $row->post_location;
			$data['timeline'] = $row->post_timeline;
			$data['post_id'] = $id;
			
			if ($next !== FALSE)
			{
				$data['next'] = $next;
			}
			
			if ($prev !== FALSE)
			{
				$data['prev'] = $prev;
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('sim_viewpost', $this->skin, 'main');
			$js_loc = js_location('sim_viewpost_js', $this->skin, 'main');
			
			/* grab the comment count */
			$data['comment_count'] = $comments->num_rows();
			
			if ($comments->num_rows() > 0)
			{
				$i = 1;
				
				foreach ($comments->result() as $c)
				{
					$date = gmt_to_local($c->pcomment_date, $this->timezone, $this->dst);
					
					$data['comments'][$i]['author'] = $this->char->get_character_name($c->pcomment_author_character);
					$data['comments'][$i]['content'] = $c->pcomment_content;
					$data['comments'][$i]['date'] = mdate($datestring, $date);
					
					++$i;
				}
			}
			
			/* image parameters */
			$data['images'] = array(
				'next' => array(
					'src' => img_location('next.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('actions_next')),
					'class' => 'image'),
				'prev' => array(
					'src' => img_location('previous.png', $this->skin, 'main'),
					'alt' => ucfirst(lang('status_previous')),
					'class' => 'image'),
				'feed' => array(
					'src' => img_location('feed.png', $this->skin, 'main'),
					'alt' => lang('labels_subscribe'),
					'class' => 'image'),
				'comment' => array(
					'src' => img_location('comment-add.png', $this->skin, 'main'),
					'alt=' => '',
					'class' => 'inline_img_left image')
			);
			
			/* write the javascript region and title */
			$this->template->write('title', $data['mission'] .' - '. $row->post_title);
			$this->template->write_view('javascript', $js_loc);
		}
		else
		{
			if ($id == 0)
			{
				$data['header'] = lang('error_title_invalid_id');
				$data['msg_error'] = lang('error_msg_id_numeric');
			}
			elseif ($query->num_rows() == 0)
			{
				$data['header'] = lang('error_title_id_not_found');
				$data['msg_error'] = lang('error_msg_not_found');
			}
			
			/* figure out where the view should be coming from */
			$view_loc = view_location('error', $this->skin, 'main');
			
			/* write the title */
			$this->template->write('title', lang('error_pagetitle'));
		}
		
		if (Auth::is_logged_in() === TRUE && Auth::get_access_level('manage/posts') == 1)
		{
			$data['valid'] = array();
			
			$users = explode(',', $row->post_authors_users);
			
			if (in_array($this->session->userdata('userid'), $users))
			{
				$data['valid'][] = TRUE;
			}
			else
			{
				$data['valid'][] = FALSE;
			}
		}
		elseif (Auth::is_logged_in() === TRUE && Auth::get_access_level('manage/posts') == 2)
		{
			$data['valid'][] = TRUE;
		}
		else
		{
			$data['valid'][] = FALSE;
		}
		
		$data['label'] = array(
			'addcomment' => ucfirst(lang('actions_add')) .' '. lang('labels_a') .' '.
				ucfirst(lang('labels_comment')),
			'by' => lang('labels_by'),
			'comments' => ucfirst(lang('labels_comments')),
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
			'edited' => ucfirst(lang('actions_edited') .' '. lang('labels_on')),
			'location' => ucfirst(lang('labels_location')) .':',
			'mission' => ucfirst(lang('global_mission')) .':',
			'on' => lang('labels_on'),
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'tags' => ucfirst(lang('labels_tags')) .':',
			'timeline' => ucfirst(lang('labels_timeline')) .':',
			'title' => ucfirst(lang('labels_title')),
			'view_log' => ucwords(lang('actions_view') .' '. lang('global_log')),
		);
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
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
		
		switch ($type)
		{
			case 'log_comment':
				/* load the models */
				$this->load->model('personallogs_model', 'logs');
				
				/* run the methods */
				$row = $this->logs->get_log($data['log']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = $this->user->get_email_address('character', $row->log_author_character);
				
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
				
			case 'log_comment_pending':
				/* load the models */
				$this->load->model('personallogs_model', 'logs');
				
				/* run the methods */
				$row = $this->logs->get_log($data['log']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = implode(',', $this->user->get_emails_with_access('manage/comments'));
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_personallog'),
					"<strong>". $row->log_title ."</strong>",
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
				
			case 'post_comment':
				/* load the models */
				$this->load->model('posts_model', 'posts');
				
				/* run the methods */
				$row = $this->posts->get_post($data['post']);
				
				/* get who the comment is from */
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				
				/* get the authors' email addresses */
				$authors = $this->posts->get_author_emails($data['post']);
				
				foreach ($authors as $key => $value)
				{
					/* get the user id */
					$user = $this->user->get_userid_from_email($value);
					
					/* get the author's preference */
					$pref = $this->user->get_pref('email_new_post_comments', $user);
					
					if ($pref == 'n' || $pref == '')
					{
						unset($authors[$key]);
					}
				}
				
				/* set the TO string */
				$to = implode(',', $authors);
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_post_comment_added'),
					"<strong>". $row->post_title ."</strong>",
					$data['comment']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_post_comment_added'),
					'email_from' => ucfirst(lang('time_from')) .': '. $name .' - '. $from,
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('sim_post_comment', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($from, $name);
				$this->email->to($to);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'post_comment_pending':
				/* load the models */
				$this->load->model('posts_model', 'posts');
				
				/* run the methods */
				$row = $this->posts->get_post($data['post']);
				$name = $this->char->get_character_name($data['author']);
				$from = $this->user->get_email_address('character', $data['author']);
				$to = implode(',', $this->user->get_emails_with_access('manage/comments'));
				
				/* set the content */	
				$content = sprintf(
					lang('email_content_comment_pending'),
					lang('global_missionpost'),
					"<strong>". $row->post_title ."</strong>",
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
				
			case 'docking_user':
				/* set the content */	
				$content = sprintf(
					lang('email_content_docking_user'),
					$this->options['sim_name']
				);
				
				/* create the array passing the data to the email */
				$email_data = array(
					'email_subject' => lang('email_subject_docking_user'),
					'email_from' => ucfirst(lang('time_from')) .': '. $this->options['default_email_name'] .' - '. $this->options['default_email_address'],
					'email_content' => ($this->email->mailtype == 'html') ? nl2br($content) : $content
				);
				
				/* where should the email be coming from */
				$em_loc = email_location('sim_docking_user', $this->email->mailtype);
				
				/* parse the message */
				$message = $this->parser->parse($em_loc, $email_data, TRUE);
				
				/* set the parameters for sending the email */
				$this->email->from($this->options['default_email_address'], $this->options['default_email_name']);
				$this->email->to($data['email']);
				$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
				$this->email->message($message);
			break;
				
			case 'docking_gm':
				/* load the models */
				$this->load->model('docking_model', 'docking');
				
				$row = $this->docking->get_docked_item($data);
				
				if ($row !== FALSE)
				{
					/* create the array passing the data to the email */
					$email_data = array(
						'email_subject' => lang('email_subject_docking_gm'),
						'email_from' => ucfirst(lang('time_from')) .': '. $row->docking_gm_name .' - '. $row->docking_gm_email,
						'email_content' => nl2br(lang('email_content_docking_gm'))
					);
					
					$email_data['info'] = array(
						array(
							'label' => ucwords(lang('global_sim') .' '. lang('labels_name')),
							'data' => $row->docking_sim_name),
						array(
							'label' => ucwords(lang('global_sim') .' '. lang('abbr_url')),
							'data' => $row->docking_sim_url),
						array(
							'label' => ucfirst(lang('labels_name')),
							'data' => $row->docking_gm_name),
						array(
							'label' => ucwords(lang('labels_email_address')),
							'data' => $row->docking_gm_email)
					);
					
					/* get the sections */
					$sections = $this->docking->get_docking_sections();
					
					if ($sections->num_rows() > 0)
					{
						foreach ($sections->result() as $sec)
						{
							$email_data['sections'][$sec->section_id]['title'] = $sec->section_name;
							
							/* get the section fields */
							$fields = $this->docking->get_docking_fields($sec->section_id);
							
							if ($fields->num_rows() > 0)
							{
								foreach ($fields->result() as $field)
								{
									$docking_data = $this->docking->get_field_data($field->field_id, $data);
									
									if ($docking_data->num_rows() > 0)
									{
										foreach ($docking_data->result() as $d)
										{ /* put the data into an array */
											$email_data['sections'][$sec->section_id]['fields'][] = array(
												'field' => $field->field_label_page,
												'data' => text_output($d->data_value, '')
											);
										}
									}
								}
							}
						}
					
						/* where should the email be coming from */
						$em_loc = email_location('sim_docking_gm', $this->email->mailtype);
					
						/* parse the message */
						$message = $this->parser->parse($em_loc, $email_data, TRUE);
					
						/* get the game masters email addresses */
						$gm = $this->user->get_gm_emails();
					
						/* set the TO variable */
						$to = implode(',', $gm);
					
						/* set the parameters for sending the email */
						$this->email->from($row->docking_gm_email, $row->docking_gm_name);
						$this->email->to($to);
						$this->email->subject($this->options['email_subject'] .' '. $email_data['email_subject']);
						$this->email->message($message);
					}
				}
			break;
		}
		
		/* send the email */
		$email = $this->email->send();
		
		/* return the email variable */
		return $email;
	}
}
