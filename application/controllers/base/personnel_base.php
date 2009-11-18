<?php
/*
|---------------------------------------------------------------
| PERSONNEL CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/personnel_base.php
| System Version: 1.0
|
| Controller that handles the PERSONNEL section of the system.
|
*/

class Personnel_base extends Controller {

	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Personnel_base()
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
		$this->auth->is_logged_in();
		
		/* an array of the global we want to retrieve */
		$settings_array = array(
			'skin_main',
			'display_rank',
			'timezone',
			'daylight_savings',
			'sim_name',
			'date_format',
			'manifest_defaults'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_main'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in() === TRUE)
		{ /* if there's a session, set the variables appropriately */
			$this->skin = $this->session->userdata('skin_main');
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_main.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'personnel'), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
		
		if ($this->session->userdata('userid') !== FALSE)
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
		/* load the models */
		$this->load->model('depts_model', 'dept');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('positions_model', 'pos');
		
		/* run the methods */
		$depts = $this->dept->get_all_depts();
		$rank = $this->ranks->get_rankcat($this->rank);
		
		/* build the blank image array */
		$blank_img = array(
			'src' => rank_location($this->rank, 'blank', $rank->rankcat_extension),
			'alt' => '',
			'class' => 'image');
		
		if ($depts->num_rows() > 0)
		{
			$a = 1;
			foreach ($depts->result() as $depts)
			{
				/* set the dept id as a variable */
				$dept = $depts->dept_id;
				
				/* set the dept name */
				$data['depts'][$dept]['name'] = $depts->dept_name;
				$data['depts'][$dept]['type'] = $depts->dept_type;
				
				/* get the sub depts */
				$subdepts = $this->dept->get_sub_depts($dept);
				
				if ($subdepts->num_rows() > 0)
				{
					$a = 1;
					foreach ($subdepts->result() as $sub)
					{
						/* set the name of the sub dept */
						$data['depts'][$dept]['sub'][$a]['name'] = $sub->dept_name;
						$data['depts'][$dept]['sub'][$a]['type'] = $sub->dept_type;
						
						/* grab the positions for the sub dept */
						$positions = $this->pos->get_dept_positions($sub->dept_id);
				
						if ($positions->num_rows() > 0)
						{
							$b = 1;
							foreach ($positions->result() as $pos)
							{
								/* set the sub dept position data */
								$data['depts'][$dept]['sub'][$a]['pos'][$b]['name'] = $pos->pos_name;
								$data['depts'][$dept]['sub'][$a]['pos'][$b]['pos_id'] = $pos->pos_id;
								$data['depts'][$dept]['sub'][$a]['pos'][$b]['open'] = $pos->pos_open;
								$data['depts'][$dept]['sub'][$a]['pos'][$b]['blank_img'] = $blank_img;
								
								$order = array(
									'position_1' => 'desc',
									'position_2' => 'desc',
									'rank' => 'asc'
								);
								/* get any characters in a position in a sub dept */
								$characters = $this->char->get_characters_for_position($pos->pos_id, $order);
						
								if ($characters->num_rows() > 0)
								{
									$c = 1;
									foreach ($characters->result() as $char)
									{
										/* get user info */
										$user = $this->user->get_user_details($char->user);
										
										/* grab the rank data we need */
										$rankdata = $this->ranks->get_rank($char->rank, array('rank_name', 'rank_image'));
										
										/* build the rank image array */
										$rank_img = array(
											'src' => rank_location(
												$this->rank, 
												$rankdata['rank_image'],
												$rank->rankcat_extension),
											'alt' => $rankdata['rank_name'],
											'class' => 'image');
											
										/* set the color */
										$color = '';
										
										if ($char->user > 0)
										{
											$color = ($this->user->get_loa($char->user) == 'loa') ? '_loa' : $color;
											$color = ($this->user->get_loa($char->user) == 'eloa') ? '_eloa' : $color;
										}
										
										$color = ($char->crew_type == 'npc') ? '_npc' : $color;
								
										/* build the combadge image array */
										$cb_img = array(
											'src' => cb_location('combadge'. $color .'.png', $this->skin, 'main'),
											'alt' => ucwords(lang('actions_view') 
												.' '. lang('labels_bio')),
											'class' => 'image'
										);
											
										/* get the character name and rank */
										$name = $this->char->get_character_name($char->charid, TRUE);
										
										if ($char->crew_type == 'active' && empty($char->user))
										{
											/* don't do anything */
										}
										else
										{
											/* set the data for the characters in a position in a sub dept */
											$data['depts'][$dept]['sub'][$a]['pos'][$b]['chars'][$c]['char_id'] = $char->charid;
											$data['depts'][$dept]['sub'][$a]['pos'][$b]['chars'][$c]['name'] = $name;
											$data['depts'][$dept]['sub'][$a]['pos'][$b]['chars'][$c]['rank_img'] = $rank_img;
											$data['depts'][$dept]['sub'][$a]['pos'][$b]['chars'][$c]['crew_type'] = $char->crew_type;
											$data['depts'][$dept]['sub'][$a]['pos'][$b]['chars'][$c]['combadge'] = $cb_img;
											
											++$c;
										}
									}
								}
								
								++$b;
							}
						}
						
						++$a;
					}
				}
				
				/* get the positions for the dept */
				$positions = $this->pos->get_dept_positions($dept);
				
				if ($positions->num_rows() > 0)
				{
					$b = 1;
					foreach ($positions->result() as $pos)
					{
						/* set the data for the dept positions */
						$data['depts'][$dept]['pos'][$b]['name'] = $pos->pos_name;
						$data['depts'][$dept]['pos'][$b]['pos_id'] = $pos->pos_id;
						$data['depts'][$dept]['pos'][$b]['open'] = $pos->pos_open;
						$data['depts'][$dept]['pos'][$b]['blank_img'] = $blank_img;
						
						$order = array(
							'position_1' => 'desc',
							'position_2' => 'desc',
							'rank' => 'asc'
						);
						
						/* get any characters in a position in the dept */
						$characters = $this->char->get_characters_for_position($pos->pos_id, $order);
						
						if ($characters->num_rows() > 0)
						{
							$c = 1;
							foreach ($characters->result() as $char)
							{
								/* get the rank data we need */
								$ranksdata = $this->ranks->get_rank($char->rank, array('rank_name', 'rank_image'));
								
								/* build the rank image array */
								$rank_img = array(
									'src' => rank_location(
										$this->rank,
										$ranksdata['rank_image'],
										$rank->rankcat_extension),
									'alt' => $ranksdata['rank_name'],
									'class' => 'image');
								
								/* set the color */
								$color = '';
								
								if ($char->user > 0)
								{
									$color = ($this->user->get_loa($char->user) == 'loa') ? '_loa' : $color;
									$color = ($this->user->get_loa($char->user) == 'eloa') ? '_eloa' : $color;
								}
								
								$color = ($char->crew_type == 'inactive') ? '' : $color;
								$color = ($char->crew_type == 'npc') ? '_npc' : $color;
								
								/* build the combadge image array */
								$cb_img = array(
									'src' => cb_location('combadge'. $color .'.png', $this->skin, 'main'),
									'alt' => ucwords(lang('actions_view') 
										.' '. lang('labels_bio')),
									'class' => 'image'
								);
								
								/* get the character name and rank */
								$name = $this->char->get_character_name($char->charid, TRUE);
								
								if ($char->crew_type == 'active' && empty($char->user))
								{
									/* don't do anything */
								}
								else
								{
									/* set the data for characters in a position in the dept */
									$data['depts'][$dept]['pos'][$b]['chars'][$c]['char_id'] = $char->charid;
									$data['depts'][$dept]['pos'][$b]['chars'][$c]['name'] = $name;
									$data['depts'][$dept]['pos'][$b]['chars'][$c]['rank_img'] = $rank_img;
									$data['depts'][$dept]['pos'][$b]['chars'][$c]['crew_type'] = $char->crew_type;
									$data['depts'][$dept]['pos'][$b]['chars'][$c]['combadge'] = $cb_img;
									
									++$c;
								}
							}
						}
						
						++$b;
					}
				}
			}
		}
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('personnel_index', $this->skin, 'main');
		$js_loc = js_location('personnel_index_js', $this->skin, 'main');
		
		/* set the javascript data */
		$js_data = array(
			'display' => $this->uri->rsegment(3),
			'manifest_defaults' => $this->options['manifest_defaults']);
		
		/* set the data being sent to the view */
		$data['display'] = $this->uri->rsegment(3, 'crew');
		$data['header'] = ucwords(lang('labels_crew') .' '. lang('labels_manifest'));
		$data['loader'] = array(
			'src' => img_location('loader.gif', $this->skin, 'main'),
			'alt' => '',
			'class' => 'image');
			
		$data['label'] = array(
			'playing_chars' => ucwords(lang('status_playing') .' '. lang('global_characters')),
			'inactive_chars' => ucwords(lang('status_inactive') .' '. lang('global_characters')),
			'all_chars' => ucwords(lang('labels_all') .' '. lang('global_characters')),
			'open' => ucwords(lang('status_open') .' '. lang('global_positions')),
			'show' => ucfirst(lang('actions_show')),
			'toggle' => ucfirst(lang('actions_toggle')),
			'npcs' => lang('abbr_npcs'),
			'loading' => lang('actions_loading'),
			'inactive' => ucfirst(lang('status_inactive')),
			'apply' => ucwords(lang('global_position') .' '. lang('status_open') .' '. NDASH
				.' '. lang('actions_apply') .' '. lang('time_now')),
			'npc' => lang('abbr_npc'),
		);
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}

	function coc()
	{
		/* load the models */
		$this->load->model('ranks_model', 'ranks');
		
		/* run the methods */
		$query = $this->char->get_coc();
		$rank_ext = $this->ranks->get_rankcat($this->rank, 'rankcat_location', 'rankcat_extension');
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				$loa = (!empty($item->user)) ? $this->user->get_loa($item->user) : 0;
				
				/* set the color */
				$color = '';
				
				if ($item->user > 0)
				{
					$color = ($loa == 'loa') ? '_loa' : $color;
					$color = ($loa == 'eloa') ? '_eloa' : $color;
				}
				
				$color = ($item->crew_type == 'inactive') ? '' : $color;
				$color = ($item->crew_type == 'npc') ? '_npc' : $color;
				
				/* array of data for the 2 images each array generates (combadge and rank image) */
				$images = array(
					'rank' => array(
						'src' => rank_location($this->rank, $item->rank_image, $rank_ext),
						'alt' => $item->rank_name,
						'class' => 'image',
						'border' => 0),
					'bio' => array(
						'src' => cb_location('combadge'. $color .'.png', $this->skin, 'main'),
						'alt' => ucwords(lang('actions_view') 
							.' '. lang('labels_bio')),
						'class' => 'image')
				);
				
				if ($item->crew_type == 'active' && empty($item->user))
				{
					/* don't do anything */
				}
				else
				{
					/* data being passed to the view */
					$data['coc'][$item->charid]['id'] = $item->charid;
					$data['coc'][$item->charid]['name'] = $this->char->get_character_name($item->charid, TRUE);
					$data['coc'][$item->charid]['position'] = $item->pos_name;
					$data['coc'][$item->charid]['img_rank'] = $images['rank'];
					$data['coc'][$item->charid]['img_bio'] = $images['bio'];
				}
			}
		}
		else
		{
			$data['error'] = lang('error_no_coc');
		}
		
		if ($this->auth->is_logged_in() === TRUE && $this->auth->check_access('characters/coc', FALSE) === TRUE)
		{
			$data['edit_valid'] = TRUE;
		}
		else
		{
			$data['edit_valid'] = FALSE;
		}
		
		/* page header */
		$data['header'] = lang('labels_coc');
		
		$data['label'] = array(
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('personnel_coc', $this->skin, 'main');
		$js_loc = js_location('personnel_coc_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function character()
	{
		/* load the models */
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('positions_model', 'pos');
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('awards_model', 'awards');
		
		/* set the variables */
		$id = $this->uri->segment(3, FALSE, TRUE);
		
		/* grab the character info */
		$character = $this->char->get_character($id);
		
		if ($character !== FALSE)
		{
			$data['postcount'] = $this->posts->count_character_posts($id);
			$data['logcount'] = $this->logs->count_character_logs($id);
			$data['awardcount'] = $this->awards->count_character_awards($id);
			
			/* set the name items into an array */
			$name_array = array(
				'first_name' => $character->first_name,
				'middle_name' => $character->middle_name,
				'last_name' => $character->last_name,
				'suffix' => $character->suffix
			);
			
			foreach ($name_array as $key => $value)
			{ /* make sure there aren't any blank items */
				if (empty($value))
				{
					unset($name_array[$key]);
				}
			}
			
			$name = implode(' ', $name_array);
			$rank = $this->ranks->get_rank($character->rank, 'rank_name');
			
			/* set the character info */
			$data['character_info'] = array(
				array(
					'label' => ucfirst(lang('labels_name')),
					'value' => $name),
				array(
					'label' => ucfirst(lang('global_position')),
					'value' => $this->pos->get_position($character->position_1, 'pos_name')),
				array(
					'label' => ucwords(lang('order_second') .' '. lang('global_position')),
					'value' => $this->pos->get_position($character->position_2, 'pos_name')),
				array(
					'label' => ucfirst(lang('global_rank')),
					'value' => $rank),
			);
			
			/* set the data used by the view */
			$data['character']['id'] = $id;
			$data['character']['name'] = $name;
			$data['character']['rank'] = $character->rank;
			$data['character']['position_1'] = $character->position_1;
			$data['character']['position_2'] = $character->position_2;
			$data['character']['user'] = $character->user;
			
			if ($character->images > '')
			{ /* make sure there are actually images */
				/* get the images */
				$images = explode(',', $character->images);
				$images_count = count($images);
			
				if (strstr($images[0], 'http://'))
				{ /* make sure it is not an external image */
					$src = $images[0];
				}
				else
				{
					$src = asset_location('images/characters', trim($images[0]));
				}
				
				/* set the image */
				$data['character']['image'] = array(
					'src' => $src,
					'alt' => $name,
					'class' => 'image reflect rheight20 ropacity30',
					'height' => 150
				);
				
				for ($i=1; $i < $images_count; $i++)
				{
					if (strstr($images[$i], 'http://'))
					{ /* make sure it is not an external image */
						$src = trim($images[$i]);
					}
					else
					{
						$src = asset_location('images/characters', trim($images[$i]));
					}
					
					/* build the array */
					$data['character']['image_array'][] = array(
						'src' => $src,
						'alt' => $name,
						'class' => 'image'
					);
				}
			}
						
			/* get the bio tabs */
			$tabs = $this->char->get_bio_tabs();
			
			/* get the bio sections */
			$sections = $this->char->get_bio_sections();
			
			if ($tabs->num_rows() > 0)
			{
				$i = 1;
				foreach ($tabs->result() as $tab)
				{
					$data['tabs'][$i]['id'] = $tab->tab_id;
					$data['tabs'][$i]['name'] = $tab->tab_name;
					$data['tabs'][$i]['link'] = $tab->tab_link_id;
					
					++$i;
				}
			}
			
			if ($sections->num_rows() > 0)
			{
				$i = 1;
				foreach ($sections->result() as $sec)
				{
					$fields = $this->char->get_bio_fields($sec->section_id);
					
					if ($fields->num_rows() > 0)
					{
						$j = 1;
						foreach ($fields->result() as $field)
						{
							$data['fields'][$sec->section_id][$j]['label'] = $field->field_label_page;
							$data['fields'][$sec->section_id][$j]['value'] = FALSE;
							
							$info = $this->char->get_field_data($field->field_id, $id);
							
							if ($info->num_rows() > 0)
							{
								foreach ($info->result() as $item)
								{
									$data['fields'][$sec->section_id][$j]['value'] = $item->data_value;
								}
							}
							
							++$j;
						}
					}
					
					if ($tabs->num_rows() > 0)
					{
						$data['sections'][$sec->section_tab][$i]['id'] = $sec->section_id;
						$data['sections'][$sec->section_tab][$i]['name'] = $sec->section_name;
					}
					else
					{
						$data['sections'][$i]['id'] = $sec->section_id;
						$data['sections'][$i]['name'] = $sec->section_name;
					}
					
					++$i;
				}
			}
			
			/* set the header */
			$data['header'] = ucfirst(lang('labels_biography')) .' - '. $rank .' '. $name;
			
			/* set the title */
			$this->template->write('title', ucfirst(lang('labels_biography')) .' - '. $name);
		}
		else
		{
			/* set the header */
			$data['header'] = lang('error_title_invalid_char');
			$data['msg_error'] = lang_output('error_msg_invalid_char');
			
			/* set the title */
			$this->template->write('title', lang('error_pagetitle'));
		}
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			if ($this->auth->check_access('site/bioform', FALSE) === TRUE)
			{
				$data['edit_valid_form'] = TRUE;
			}
			else
			{
				$data['edit_valid_form'] = FALSE;
			}
			
			if ($this->auth->check_access('characters/bio', FALSE) === TRUE)
			{
				if ($this->auth->get_access_level('characters/bio') == 3)
				{
					$data['edit_valid'] = TRUE;
				}
				elseif ($this->auth->get_access_level('characters/bio') == 2)
				{
					$characters = $this->char->get_user_characters($this->session->userdata('userid'), '', 'array');
					
					if (in_array($id, $characters) || $character->crew_type == 'npc')
					{
						$data['edit_valid'] = TRUE;
					}
					else
					{
						$data['edit_valid'] = FALSE;
					}
				}
				elseif ($this->auth->get_access_level('characters/bio') == 1)
				{
					$characters = $this->char->get_user_characters($this->session->userdata('userid'), '', 'array');
					
					if (in_array($id, $characters))
					{
						$data['edit_valid'] = TRUE;
					}
					else
					{
						$data['edit_valid'] = FALSE;
					}
				}
				else
				{
					$data['edit_valid'] = FALSE;
				}
			}
			else
			{
				$data['edit_valid'] = FALSE;
			}
		}
		
		$data['label'] = array(
			'edit' => '[ '. ucwords(lang('actions_edit') .' '. lang('global_character')) .' ]',
			'edit_form' => '[ '. ucwords(lang('actions_edit') .' '. lang('labels_biography') .' '. 
				lang('labels_form')) .' ]',
			'gallery' => lang('open_gallery'),
			'view_all_posts' => ucwords(lang('actions_viewall') .' '. lang('global_posts') .' '. RARROW),
			'view_all_logs' => ucwords(lang('actions_viewall') .' '. lang('global_personallogs') .' '. RARROW),
			'view_all_awards' => ucwords(lang('actions_viewall') .' '. lang('global_awards') .' '. RARROW),
			'view_user' => ucwords(lang('actions_view') .' '. lang('global_user') .' '.
				lang('labels_info') .' '. RARROW),
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('personnel_character', $this->skin, 'main');
		$js_loc = js_location('personnel_character_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function user()
	{
		$this->auth->is_logged_in(TRUE);
		
		/* set the variables */
		$user = $this->uri->segment(3, FALSE, TRUE);
		$js_data['tab'] = $this->uri->segment(4, 0, TRUE);
		
		/* load the resources */
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('awards_model', 'awards');
		$this->load->model('missions_model', 'mis');
		
		/* run the methods */
		$info = $this->user->get_user_details($user);
		$charinfo = array(
			'active' => $this->char->get_user_characters($user),
			'inactive' => $this->char->get_user_characters($user, 'inactive'),
			'npcs' => $this->char->get_user_characters($user, 'npc')
		);
		$rankhistory = $this->char->get_rank_history($user);
		
		/* set the datestring */
		$datestring = $this->options['date_format'];
		
		if ($info->num_rows() > 0)
		{
			/* grab the row info */
			$row = $info->row();
			
			/* calculate the timezone difference */
			$pl_timezone = timezones($row->timezone);
			$my_timezone = timezones($this->timezone);
			$diff_timezone = $my_timezone - $pl_timezone;
			
			/* load the date language file */
			$this->lang->load('date', $this->session->userdata('language'));
			
			/* timezone calculations */
			$data['timezone'] = lang($row->timezone);
			
			if ($diff_timezone == 0)
			{
				$data['timezone_span'] = ucfirst(lang('time_hours_same'));
			}
			else
			{
				$data['timezone_span'] = abs($diff_timezone);
				$data['timezone_span'].= (!is_numeric(substr($diff_timezone, 0, 1))) ? ' '. lang('time_hours_ahead') : ' '. lang('time_hours_behind');
			}
			
			/* set the data for the view */
			$data['header'] = ucwords(lang('global_user') .' '. lang('labels_info')) .' - '. $row->name;
			$data['userid'] = $user;
			
			/*
			|---------------------------------------------------------------
			| BASIC INFO
			|---------------------------------------------------------------
			*/
			
			$data['name'] = $row->name;
			$data['email'] = $row->email;
			$data['dob'] = $row->date_of_birth;
			$data['location'] = $row->location;
			$data['interests'] = $row->interests;
			$data['im'] = explode("\n", $row->instant_message);
			$data['bio'] = $row->bio;
			
			/*
			|---------------------------------------------------------------
			| CHARACTER INFO
			|---------------------------------------------------------------
			*/
			
			foreach ($charinfo as $key => $value)
			{ /* loop through the array of crew types */
				foreach ($charinfo[$key]->result() as $k => $v)
				{ /* loop through each type */
					/* build an array of the rank, first name, and last name */
					$name = array(
						'rank' => $this->ranks->get_rank($v->rank, 'rank_name'),
						'first' => $v->first_name,
						'last' => $v->last_name
					);
					
					foreach ($name as $a => $b)
					{ /* if there is an empty value, get rid of it */
						if (empty($b))
						{
							unset($name[$a]);
						}
					}
					
					/* implode the array into a string */
					$name_string = implode(' ', $name);
					
					/* set the character values */
					$data['characters'][$key][$v->charid]['id'] = $v->charid;
					$data['characters'][$key][$v->charid]['name'] = $name_string;
					
					if ($key == 'active')
					{
						$date = gmt_to_local($v->date_activate, $this->timezone, $this->dst);
						$data['characters'][$key][$v->charid]['active_date'] = mdate($datestring, $date);
						$data['characters'][$key][$v->charid]['active_time'] = timespan($v->date_activate);
					}
				}
			}
			
			/*
			|---------------------------------------------------------------
			| RANK HISTORY
			|---------------------------------------------------------------
			*/
			
			$data['rank_history'] = FALSE;
			
			if ($rankhistory->num_rows() > 0)
			{
				foreach ($rankhistory->result() as $rank)
				{
					$data['rank_history'][$rank->prom_char]['name'] = $this->char->get_character_name($rank->prom_char, TRUE);
					$data['rank_history'][$rank->prom_char]['history'][] = array(
						'old_order' => $rank->prom_old_order,
						'old_rank' => $rank->prom_old_rank,
						'new_order' => $rank->prom_new_order,
						'new_rank' => $rank->prom_new_rank,
						'date' => mdate($datestring, $rank->prom_date),
					);
				}
			}
			
			/*
			|---------------------------------------------------------------
			| STATS
			|---------------------------------------------------------------
			*/
			
			$data['join_date_time'] = timespan($row->join_date, now());
			$data['join_date'] = mdate($datestring, gmt_to_local($row->join_date, $this->timezone, $this->dst));
			
			if (!empty($row->last_post))
			{ /* if there is a last post date, use it */
				$data['last_post_time'] = timespan($row->last_post, now());
				$data['last_post'] = mdate($datestring, gmt_to_local($row->last_post, $this->timezone, $this->dst));
			}
			
			if (!empty($row->last_login))
			{ /* if there is a last login date, use it */
				$data['last_login_time'] = timespan($row->last_login, now());
				$data['last_login'] = mdate($datestring, gmt_to_local($row->last_login, $this->timezone, $this->dst));
			}
			
			/* get the IDs of the characters that user has */
			$characters = $this->char->get_user_characters($user, '', 'array');
			
			/* post and log counts */
			$data['post_count'] = $this->posts->count_character_posts($characters);
			$data['log_count'] = $this->logs->count_character_logs($characters);
			
			/* calculate the time in weeks */
			$total_time = now() - $row->join_date;
			$days = $total_time / 86400; /* number of days */
			$weeks = ($days >= 7) ? $days / 7 : FALSE;
			$time = round($weeks);
			
			/* send the data to the view */
			$data['avg_posts'] = ($weeks > 0) ? round($data['post_count'] / $weeks, 2) : 0;
			$data['avg_logs'] = ($weeks > 0) ? round($data['log_count'] / $weeks, 2) : 0;
			
			/*
			|---------------------------------------------------------------
			| POSTING INFO
			|---------------------------------------------------------------
			*/
			
			$posts = $this->posts->get_character_posts($characters, 5);
			$logs = $this->logs->get_character_logs($characters, 5);
			
			if ($posts->num_rows() > 0)
			{
				$i = 1;
				foreach ($posts->result() as $p)
				{
					$data['posts'][$i]['title'] = $p->post_title;
					$data['posts'][$i]['post_id'] = $p->post_id;
					$data['posts'][$i]['date'] = mdate($datestring, gmt_to_local($p->post_date, $this->timezone, $this->dst));
					$data['posts'][$i]['authors'] = $this->char->get_authors($p->post_authors);
					$data['posts'][$i]['mission'] = $this->mis->get_mission($p->post_mission, 'mission_title');
					$data['posts'][$i]['mission_id'] = $p->post_mission;
					
					++$i;
				}
			}
			
			if ($logs->num_rows() > 0)
			{
				$i = 1;
				foreach ($logs->result() as $l)
				{
					$data['logs'][$i]['title'] = $l->log_title;
					$data['logs'][$i]['log_id'] = $l->log_id;
					$data['logs'][$i]['date'] = mdate($datestring, gmt_to_local($l->log_date, $this->timezone, $this->dst));
					$data['logs'][$i]['author'] = $this->char->get_character_name($l->log_author_character, TRUE);
					
					++$i;
				}
			}
			
			/*
			|---------------------------------------------------------------
			| AWARDS
			|---------------------------------------------------------------
			*/
			
			$awards = $this->awards->get_user_awards($user);
			
			if ($awards->num_rows() > 0)
			{
				$i = 1;
				foreach ($awards->result() as $a)
				{
					$data['awards'][$i]['award'] = $a->award_name;
					$data['awards'][$i]['award_id'] = $a->awardrec_award;
					$data['awards'][$i]['reason'] = $a->awardrec_reason;
					$data['awards'][$i]['given'] = mdate($datestring, gmt_to_local($a->awardrec_date, $this->timezone, $this->dst));
					$data['awards'][$i]['name'] = (empty($a->awardrec_character)) ? $row->name : $this->char->get_character_name($a->awardrec_character, TRUE);
					
					++$i;
				}
			}
			
			/* set the title */
			$this->template->write('title', $this->msgs->get_message('personnel_user_title') . $row->name);
		}
		else
		{
			/* set the header */
			$data['header'] = lang('error_title_invalid_user');
			$data['msg_error'] = lang('error_msg_invalid_user');
			
			/* set the title */
			$this->template->write('title', lang('error_pagetitle'));
		}
		
		if ($this->auth->is_logged_in() === TRUE)
		{
			if ($this->auth->check_access('user/account', FALSE) === TRUE && 
				$this->auth->get_access_level('user/account') == 1 && $user == $this->session->userdata('userid'))
			{
				$data['edit_valid'] = TRUE;
			}
			elseif ($this->auth->check_access('user/account', FALSE) === TRUE && 
				$this->auth->get_access_level('user/account') == 2)
			{
				$data['edit_valid'] = TRUE;
			}
			else
			{
				$data['edit_valid'] = FALSE;
			}
		}
		
		$data['label'] = array(
			'activechars' => ucwords(lang('status_active') .' '. lang('global_characters')),
			'activefor' => ucfirst(lang('status_active') .' '. lang('labels_for')),
			'ago' => lang('time_ago'),
			'average' => ucfirst(lang('labels_average')) .':',
			'award' => ucfirst(lang('global_award')),
			'awards' => ucfirst(lang('global_awards')),
			'basicinfo' => ucwords(lang('labels_basic') .' '. lang('labels_info')),
			'bio' => ucfirst(lang('labels_biography')),
			'by' => ucfirst(lang('labels_by')),
			'charinfo' => ucwords(lang('global_character') .' '. lang('labels_info')),
			'date' => ucfirst(lang('labels_date')),
			'demoted' => ucfirst(lang('actions_demoted') .' '. lang('labels_from')),
			'dob' => lang('labels_dob'),
			'edit' => '[ '. ucwords(lang('actions_edit') .' '. lang('global_user')) .' ]',
			'email' => ucwords(lang('labels_email_address')),
			'from' => lang('labels_from'),
			'im' => ucwords(lang('labels_im')),
			'inactivechars' => ucwords(lang('status_inactive') .' '. 
				lang('global_characters')),
			'interests' => ucfirst(lang('labels_interests')),
			'joined' => ucfirst(lang('actions_joined')),
			'lastlogin' => ucwords(lang('order_last') .' '. lang('actions_login')),
			'lastpost' => ucwords(lang('order_last') .' '. lang('global_post')),
			'location' => ucfirst(lang('labels_location')),
			'mission' => ucfirst(lang('global_mission')),
			'missionposts' => ucwords(lang('global_missionposts')),
			'name' => ucfirst(lang('labels_name')),
			'noawards' => lang('error_no_awards'),
			'nologin' => lang('error_no_last_login'),
			'nologs' => lang('error_no_logs'),
			'none' => ucfirst(lang('labels_none')),
			'nopost' => lang('error_no_last_post'),
			'noposts' => lang('error_no_posts'),
			'norankhistory' => lang('error_no_rank_history'),
			'npcs' => lang('abbr_npcs'),
			'personallogs' => ucwords(lang('global_personallogs')),
			'perweek' => lang('time_per_week'),
			'postinginfo' => ucwords(lang('labels_posting') .' '. lang('labels_info')),
			'promoted' => ucfirst(lang('actions_promoted') .' '. lang('labels_to')),
			'rankhistory' => ucwords(lang('global_rank') .' '. lang('labels_history')),				
			'reason' => ucfirst(lang('labels_reason')),
			'receivedby' => ucfirst(lang('actions_received') .' '. lang('labels_by')),
			'stats' => ucfirst(lang('labels_stats')),
			'timezone' => ucfirst(lang('labels_timezone')),
			'title' => ucfirst(lang('labels_title')),
			'to' => lang('labels_to'),
			'totallogs' => ucwords(lang('labels_total') .' '. lang('global_personallogs')),
			'totalposts' => ucwords(lang('labels_total') .' '. lang('global_missionposts')),
			'viewawards' => ucwords(lang('actions_view') .' '. lang('global_user') .' '.
				lang('global_awards') .' '. RARROW),
			'viewlogs' => ucwords(lang('actions_view') .' '. lang('global_user') .' '.
				lang('global_logs') .' '. RARROW),
			'viewposts' => ucwords(lang('actions_view') .' '. lang('global_user') .' '.
				lang('global_posts') .' '. RARROW),
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('personnel_user', $this->skin, 'main');
		$js_loc = js_location('personnel_user_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc, $js_data);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewawards()
	{
		/* define some variables */
		$type = $this->uri->segment(3, 'default');
		$id = $this->uri->segment(4, FALSE, TRUE);
		
		/* load the models */
		$this->load->model('awards_model', 'awards');
		
		switch ($type)
		{
			case 'u':
				/* run the model methods */
				$user = $this->user->get_user_details($id);
				$data['user'] = $id;

				if ($user->num_rows() > 0)
				{
					/* drop the object into a variable */
					$item = $user->row();
					
					/* get the awards info */
					$awards = $this->awards->get_awards_for_id($id, 'user');
					
					/* set the name */
					$name = $item->name;

					if ($awards->num_rows() > 0)
					{
						$i = 1;
						$datestring = $this->options['date_format'];

						foreach ($awards->result() as $row)
						{
							$date = gmt_to_local($row->awardrec_date, $this->timezone, $this->dst);
							
							$award_img = array(
								'src' => asset_location('images/awards', $row->award_image),
								'alt' => $row->award_name,
								'class' => 'image award-small');
							
							if ($row->awardrec_character >= 1)
							{
								$data['char'][$row->awardrec_character]['character'] = $this->char->get_character_name($row->awardrec_character, TRUE);
								$data['char'][$row->awardrec_character]['awards'][$i]['award_id'] = $row->award_id;
								$data['char'][$row->awardrec_character]['awards'][$i]['award'] = $row->award_name;
								$data['char'][$row->awardrec_character]['awards'][$i]['date'] = mdate($datestring, $date);
								$data['char'][$row->awardrec_character]['awards'][$i]['reason'] = $row->awardrec_reason;
								$data['char'][$row->awardrec_character]['awards'][$i]['img'] = $award_img;
								$data['char'][$row->awardrec_character]['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, TRUE);
							}
							else
							{
								$data['awards'][$i]['award_id'] = $row->award_id;
								$data['awards'][$i]['award'] = $row->award_name;
								$data['awards'][$i]['date'] = mdate($datestring, $date);
								$data['awards'][$i]['reason'] = $row->awardrec_reason;
								$data['awards'][$i]['img'] = $award_img;
								$data['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, TRUE);
							}
							
							++$i;
						}
						
						/* other data used by the template */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;

						/* figure out where the view should be coming from */
						$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
						$js_loc = js_location('personnel_viewawards_js', $this->skin, 'main');
						
						/* write the javascript stuff to the view */
						$this->template->write_view('javascript', $js_loc);
						
						/* write the title */
						$this->template->write('title', $data['header']);
					}
					else
					{
						/* figure out where the view should be coming from */
						$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
						
						/* set the data used by the view */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['msg_error'] = lang('error_no_awards');
						
						/* write the title */
						$this->template->write('title', $data['header']);
					}
				}
				else
				{
					/* figure out where the view should be coming from */
					$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
					
					/* set the data used by the view */
					$data['header'] = lang('error_title_invalid_id');
					$data['msg_error'] = lang('error_msg_invalid_user');
					
					/* write the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
			
			case 'c':
				/* run the model methods */
				$char_row = $this->char->get_character($id);

				if ($char_row !== FALSE)
				{
					/* get the awards info */
					$awards = $this->awards->get_awards_for_id($id);
					
					/* set the name */
					$name = $this->char->get_character_name($id);

					if ($awards->num_rows() > 0)
					{
						$i = 1;
						$datestring = $this->options['date_format'];

						foreach ($awards->result() as $row)
						{
							$award_img = array(
								'src' => asset_location('images/awards', $row->award_image),
								'alt' => $row->award_name,
								'class' => 'image award-small');

							$date = gmt_to_local($row->awardrec_date, $this->timezone, $this->dst);

							$data['awards'][$i]['award_id'] = $row->award_id;
							$data['awards'][$i]['award'] = $row->award_name;
							$data['awards'][$i]['date'] = mdate($datestring, $date);
							$data['awards'][$i]['reason'] = $row->awardrec_reason;
							$data['awards'][$i]['img'] = $award_img;
							$data['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, TRUE);

							++$i;
						}

						/* other data used by the template */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['charid'] = $id;

						/* figure out where the view should be coming from */
						$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
						$js_loc = js_location('personnel_viewawards_js', $this->skin, 'main');
						
						/* write the javascript stuff to the view */
						$this->template->write_view('javascript', $js_loc);
						
						/* write the title */
						$this->template->write('title', $data['header']);
					}
					else
					{
						/* figure out where the view should be coming from */
						$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
						
						/* set the data used by the view */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['msg_error'] = lang('error_no_awards');
						
						/* write the title */
						$this->template->write('title', $data['header']);
					}
				}
				else
				{
					/* figure out where the view should be coming from */
					$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
					
					/* set the data used by the view */
					$data['header'] = lang('error_title_invalid_id');
					$data['msg_error'] = lang('error_msg_invalid_char');
					
					/* write the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
				
			default:
				/* figure out where the view should be coming from */
				$view_loc = view_location('personnel_viewawards', $this->skin, 'main');
				
				/* set the data used by the view */
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_award_type');
				
				/* write the title */
				$this->template->write('title', lang('error_pagetitle'));
		}
		
		$data['label'] = array(
			'award' => ucfirst(lang('global_award')),
			'awarded' => ucfirst(lang('actions_awarded')),
			'awards' => ucfirst(lang('global_awards')),
			'backchar' => ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_character') .' '. lang('labels_bio')),
			'backuser' => ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_user') .' '. lang('labels_bio')),
			'nominatedby' => ucfirst(lang('actions_nominated') .' '. lang('labels_by')),
			'ooc' => ucwords(lang('labels_ooc')),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewlogs()
	{
		/* set the variables */
		$type = $this->uri->segment(3, 'default');
		$id = $this->uri->segment(4, FALSE, TRUE);
		$data = FALSE;
		
		/* load the models */
		$this->load->model('personallogs_model', 'logs');
		
		/* load the helpers */
		$this->load->helper('text');
		
		switch ($type)
		{
			case 'u':
				/* run the model methods */
				$user = $this->user->get_user_details($id);
				$data['user'] = $id;
				
				if ($user->num_rows() > 0)
				{ /* if there is a character, run the method and continue */
					$row = $user->row();
					
					/* get the user's characters */
					$characters = $this->char->get_user_characters($row->userid, 'active', 'array');
					
					foreach ($characters as $char)
					{
						/* set the character name info */
						$data['char'][$char]['character'] = $this->char->get_character_name($char, TRUE);
						
						/* grab all the character posts */
						$logs = $this->logs->get_character_logs($char);
						
						if ($logs->num_rows() > 0)
						{ /* if there is 1 or more posts */
							$datestring = $this->options['date_format'];

							foreach ($logs->result() as $log)
							{ /* loop through the posts */
								$date = gmt_to_local($log->log_date, $this->timezone, $this->dst);

								$data['char'][$char]['logs'][$log->log_id]['id'] = $log->log_id;
								$data['char'][$char]['logs'][$log->log_id]['title'] = $log->log_title;
								$data['char'][$char]['logs'][$log->log_id]['date'] = mdate($datestring, $date);
								$data['char'][$char]['logs'][$log->log_id]['content'] = $log->log_content;
							}
							
							/* other data used by the template */
							$data['header'] = ucwords(lang('actions_view') .' '. lang('global_personallogs')) .' - '. $row->name;

							/* figure out where the view should be coming from */
							$js_loc = js_location('personnel_viewlogs_js', $this->skin, 'main');

							/* write the javascript region */
							$this->template->write_view('javascript', $js_loc);
						}
					}
					
					/* set the title */
					$this->template->write('title', $data['header']);
				}
				else
				{
					/* set the header */
					$data['header'] = lang('error_title_invalid_user');
					$data['msg_error'] = lang('error_msg_invalid_user');

					/* set the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
				
			case 'c':
				/* run the model methods */
				$char_check = $this->char->get_character($id);

				if ($char_check !== FALSE)
				{ /* if there is a character, run the method and continue */
					$logs = $this->logs->get_character_logs($id);

					if ($logs->num_rows() > 0)
					{ /* if there is a log, continue */
						$datestring = $this->options['date_format'];

						foreach ($logs->result() as $log)
						{
							$date = gmt_to_local($log->log_date, $this->timezone, $this->dst);

							$data['logs'][$log->log_id]['id'] = $log->log_id;
							$data['logs'][$log->log_id]['title'] = $log->log_title;
							$data['logs'][$log->log_id]['date'] = mdate($datestring, $date);
							$data['logs'][$log->log_id]['content'] = $log->log_content;
						}

						/* other data used by the template */
						$data['header'] = $this->msgs->get_message('personnel_logs_title') . $this->char->get_character_name($id);
						$data['charid'] = $id;

						/* figure out where the view should be coming from */
						$js_loc = js_location('personnel_viewlogs_js', $this->skin, 'main');

						/* write the javascript region */
						$this->template->write_view('javascript', $js_loc);
					}
					else
					{
						/* other data used by the template */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_personallogs')) .' - '. $this->char->get_character_name($id);
						$data['msg_error'] = lang('error_no_logs');
					}

					/* write the title */
					$this->template->write('title', $data['header']);
				}
				else
				{
					/* set the header */
					$data['header'] = lang('error_title_invalid_char');
					$data['msg_error'] = lang('error_msg_invalid_char');

					/* set the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
			
			default:
				/* set the data used by the view */
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_log_type');
				
				/* write the title */
				$this->template->write('title', lang('error_pagetitle'));
		}
		
		$data['label'] = array(
			'addcomment' => ucfirst(lang('actions_add')) .' '. lang('labels_a') .' '.
				lang('labels_comment'),
			'backchar' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_character') .' '. lang('labels_bio')),
			'backuser' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_user') .' '. lang('labels_bio')),
			'blurb' => ucfirst(lang('labels_blurb')),
			'by' => lang('labels_by'),
			'comments' => ucfirst(lang('labels_comments')),
			'edited' => ucfirst(lang('actions_edited') .' '. lang('labels_on')),
			'nologs' => lang('error_no_logs'),
			'on' => lang('labels_on'),
			'posted' => ucfirst(lang('actions_posted') .' '. lang('labels_on')),
			'tags' => ucfirst(lang('labels_tags')) .':',
			'title' => ucfirst(lang('labels_title')),
			'view_log' => ucwords(lang('actions_view') .' '. lang('global_log')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('personnel_viewlogs', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
	
	function viewposts()
	{
		/* set the variables */
		$type = $this->uri->segment(3, 'default');
		$id = $this->uri->segment(4, FALSE, TRUE);
		$data = FALSE;
		
		/* load the models */
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		switch ($type)
		{
			case 'u':
				/* run the model methods */
				$user = $this->user->get_user_details($id);
				$data['user'] = $id;
				
				if ($user->num_rows() > 0)
				{ /* if there is a character, run the method and continue */
					$row = $user->row();
					
					/* get the user's characters */
					$characters = $this->char->get_user_characters($row->userid, 'active', 'array');
					
					foreach ($characters as $char)
					{
						/* set the character name info */
						$data['char'][$char]['character'] = $this->char->get_character_name($char, TRUE);
						
						/* grab all the character posts */
						$posts = $this->posts->get_character_posts($char);
						
						if ($posts->num_rows() > 0)
						{ /* if there is 1 or more posts */
							$datestring = $this->options['date_format'];

							foreach ($posts->result() as $post)
							{ /* loop through the posts */
								$date = gmt_to_local($post->post_date, $this->timezone, $this->dst);

								$data['char'][$char]['posts'][$post->post_id]['id'] = $post->post_id;
								$data['char'][$char]['posts'][$post->post_id]['title'] = $post->post_title;
								$data['char'][$char]['posts'][$post->post_id]['date'] = mdate($datestring, $date);
								$data['char'][$char]['posts'][$post->post_id]['mission'] = $this->mis->get_mission($post->post_mission, 'mission_title');
								$data['char'][$char]['posts'][$post->post_id]['mission_id'] = $post->post_mission;
							}
							
							/* other data used by the template */
							$data['header'] = ucwords(lang('actions_view') .' '. lang('global_missionposts')) .' - '. $row->name;

							/* figure out where the view should be coming from */
							$js_loc = js_location('personnel_viewposts_js', $this->skin, 'main');

							/* write the javascript region */
							$this->template->write_view('javascript', $js_loc);
						}
					}
					
					/* set the title */
					$this->template->write('title', $data['header']);
				}
				else
				{
					/* set the header */
					$data['header'] = lang('error_title_invalid_user');
					$data['msg_error'] = lang('error_msg_invalid_user');

					/* set the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
				
			case 'c':
				/* run the model methods */
				$char_check = $this->char->get_character($id);

				if ($char_check !== FALSE)
				{ /* if there is a character, run the method and continue */
					$posts = $this->posts->get_character_posts($id);

					if ($posts->num_rows() > 0)
					{ /* if there is a log, continue */
						$datestring = $this->options['date_format'];

						foreach ($posts->result() as $post)
						{
							$date = gmt_to_local($post->post_date, $this->timezone, $this->dst);

							$data['posts'][$post->post_id]['id'] = $post->post_id;
							$data['posts'][$post->post_id]['title'] = $post->post_title;
							$data['posts'][$post->post_id]['date'] = mdate($datestring, $date);
							$data['posts'][$post->post_id]['mission'] = $this->mis->get_mission($post->post_mission, 'mission_title');
							$data['posts'][$post->post_id]['mission_id'] = $post->post_mission;
						}

						/* other data used by the template */
						$data['header'] = $this->msgs->get_message('personnel_posts_title') . $this->char->get_character_name($id);
						$data['charid'] = $id;

						/* figure out where the view should be coming from */
						$js_loc = js_location('personnel_viewposts_js', $this->skin, 'main');

						/* write the javascript region */
						$this->template->write_view('javascript', $js_loc);
					}
					else
					{
						/* other data used by the template */
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_missionposts')) .' - '. $this->char->get_character_name($id);
						$data['msg_error'] = lang('error_no_posts');
					}

					/* write the title */
					$this->template->write('title', $data['header']);
				}
				else
				{
					/* set the header */
					$data['header'] = lang('error_title_invalid_char');
					$data['msg_error'] = lang('error_msg_invalid_char');

					/* set the title */
					$this->template->write('title', lang('error_pagetitle'));
				}
				
				break;
			
			default:
				/* set the data used by the view */
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_post_type');
				
				/* write the title */
				$this->template->write('title', lang('error_pagetitle'));
		}
		
		$data['label'] = array(
			'backchar' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_character') .' '. lang('labels_bio')),
			'backuser' => LARROW .' '. ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_user') .' '. lang('labels_bio')),
			'mission' => ucfirst(lang('global_mission')),
			'noposts' => lang('error_no_posts'),
			'on' => lang('labels_on'),
			'title' => ucfirst(lang('labels_title')),
			'view_post' => ucwords(lang('actions_view') .' '. lang('global_post')),
		);
		
		/* figure out where the view should be coming from */
		$view_loc = view_location('personnel_viewposts', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file personnel_base.php */
/* Location: ./application/controllers/base/personnel_base.php */