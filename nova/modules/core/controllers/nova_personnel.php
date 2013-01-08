<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Personnel controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_main.php';

abstract class Nova_personnel extends Nova_controller_main {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_regions['nav_sub'] = Menu::build('sub', 'personnel');
	}

	public function index()
	{
		// load the models
		$this->load->model('depts_model', 'dept');
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('positions_model', 'pos');
		
		// get the variables
		$manifest = $this->uri->segment(3, $this->dept->get_default_manifest());
		
		// pull all the manifests
		$manifests = $this->dept->get_all_manifests();
		
		if ($manifests->num_rows() > 0)
		{
			if ($manifests->num_rows() > 1)
			{
				foreach ($manifests->result() as $m)
				{
					$data['manifests'][$m->manifest_id] = array(
						'id' => $m->manifest_id,
						'name' => $m->manifest_name,
						'desc' => $m->manifest_desc,
					);
				}
			}
			
			// get the manifest details (MD)
			$MD = $this->dept->get_manifest($manifest);
			
			// pull the content for the header
			$data['manifest_header'] = $MD->manifest_header_content;
			
			// run the methods
			$this->db->where('dept_manifest', $manifest);
			$depts = $this->dept->get_all_depts();
			$rank = $this->ranks->get_rankcat($this->rank);
			
			// build the blank image array
			$blank_img = array(
				'src' => Location::rank($this->rank, 'blank', $rank->rankcat_extension),
				'alt' => '',
				'class' => 'image');
			
			if ($depts->num_rows() > 0)
			{
				$a = 1;
				foreach ($depts->result() as $depts)
				{
					// set the dept id as a variable
					$dept = $depts->dept_id;
					
					// set the dept name
					$data['depts'][$dept]['name'] = $depts->dept_name;
					$data['depts'][$dept]['type'] = $depts->dept_type;
					
					// get the sub depts
					$subdepts = $this->dept->get_sub_depts($dept);
					
					if ($subdepts->num_rows() > 0)
					{
						$a = 1;
						foreach ($subdepts->result() as $sub)
						{
							// set the name of the sub dept
							$data['depts'][$dept]['sub'][$a]['name'] = $sub->dept_name;
							$data['depts'][$dept]['sub'][$a]['type'] = $sub->dept_type;
							
							// grab the positions for the sub dept
							$positions = $this->pos->get_dept_positions($sub->dept_id);
					
							if ($positions->num_rows() > 0)
							{
								$b = 1;
								foreach ($positions->result() as $pos)
								{
									// set the sub dept position data
									$data['depts'][$dept]['sub'][$a]['pos'][$b]['name'] = $pos->pos_name;
									$data['depts'][$dept]['sub'][$a]['pos'][$b]['pos_id'] = $pos->pos_id;
									$data['depts'][$dept]['sub'][$a]['pos'][$b]['open'] = $pos->pos_open;
									$data['depts'][$dept]['sub'][$a]['pos'][$b]['blank_img'] = $blank_img;
									
									// get any characters in a position in a sub dept
									$characters = $this->char->get_characters_for_position($pos->pos_id, array('rank' => 'asc'));
							
									if ($characters->num_rows() > 0)
									{
										$c = 1;
										foreach ($characters->result() as $char)
										{
											// grab the rank data we need
											$rankdata = $this->ranks->get_rank($char->rank, array('rank_name', 'rank_image'));
											
											// build the rank image array
											$rank_img = array(
												'src' => Location::rank(
													$this->rank, 
													$rankdata['rank_image'],
													$rank->rankcat_extension),
												'alt' => $rankdata['rank_name'],
												'class' => 'image');
												
											// set the color
											$color = '';
											
											if ($char->user > 0)
											{
												$color = ($this->user->get_loa($char->user) == 'loa') ? '_loa' : $color;
												$color = ($this->user->get_loa($char->user) == 'eloa') ? '_eloa' : $color;
											}
											
											$color = ($char->crew_type == 'npc') ? '_npc' : $color;
									
											// build the combadge image array
											$cb_img = array(
												'src' => Location::cb('combadge'. $color .'.png', $this->skin, 'main'),
												'alt' => ucwords(lang('actions_view') 
													.' '. lang('labels_bio')),
												'class' => 'image'
											);
												
											// get the character name and rank
											$name = $this->char->get_character_name($char->charid, true);
											
											if ($char->crew_type == 'active' and empty($char->user))
											{
												// don't do anything
											}
											else
											{
												// set the data for the characters in a position in a sub dept
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
					
					// get the positions for the dept
					$positions = $this->pos->get_dept_positions($dept);
					
					if ($positions->num_rows() > 0)
					{
						$b = 1;
						foreach ($positions->result() as $pos)
						{
							// set the data for the dept positions
							$data['depts'][$dept]['pos'][$b]['name'] = $pos->pos_name;
							$data['depts'][$dept]['pos'][$b]['pos_id'] = $pos->pos_id;
							$data['depts'][$dept]['pos'][$b]['open'] = $pos->pos_open;
							$data['depts'][$dept]['pos'][$b]['blank_img'] = $blank_img;
							
							// get any characters in a position in the dept
							$characters = $this->char->get_characters_for_position($pos->pos_id, array('rank' => 'asc'));
							
							if ($characters->num_rows() > 0)
							{
								$c = 1;
								foreach ($characters->result() as $char)
								{
									// get the rank data we need
									$ranksdata = $this->ranks->get_rank($char->rank, array('rank_name', 'rank_image'));
									
									// build the rank image array
									$rank_img = array(
										'src' => Location::rank(
											$this->rank,
											$ranksdata['rank_image'],
											$rank->rankcat_extension),
										'alt' => $ranksdata['rank_name'],
										'class' => 'image');
									
									// set the color
									$color = '';
									
									if ($char->user > 0)
									{
										$color = ($this->user->get_loa($char->user) == 'loa') ? '_loa' : $color;
										$color = ($this->user->get_loa($char->user) == 'eloa') ? '_eloa' : $color;
									}
									
									$color = ($char->crew_type == 'inactive') ? '' : $color;
									$color = ($char->crew_type == 'npc') ? '_npc' : $color;
									
									// build the combadge image array
									$cb_img = array(
										'src' => Location::cb('combadge'. $color .'.png', $this->skin, 'main'),
										'alt' => ucwords(lang('actions_view') 
											.' '. lang('labels_bio')),
										'class' => 'image'
									);
									
									// get the character name and rank
									$name = $this->char->get_character_name($char->charid, true);
									
									if ($char->crew_type == 'active' and empty($char->user))
									{
										// don't do anything
									}
									else
									{
										// set the data for characters in a position in the dept
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
		}
		
		// pull the top open positions
		$top = $this->pos->get_open_positions('y', true);
		
		if ($top->num_rows() > 0)
		{
			foreach ($top->result() as $t)
			{
				$data['top'][$t->pos_id] = array(
					'name' => $t->pos_name,
					'id' => $t->pos_id,
					'dept' => $this->dept->get_dept($t->pos_dept, 'dept_name'),
					'blank_img' => $blank_img
				);
			}
		}
		
		// set the javascript data
		$js_data = array(
			'display' => $this->uri->rsegment(3),
			'manifest_defaults' => $MD->manifest_view);
		
		// set the data being sent to the view
		$data['display'] = $this->uri->rsegment(3, 'crew');
		$data['header'] = ucwords(lang('labels_crew') .' '. lang('labels_manifest'));
		$data['loader'] = array(
			'src' => Location::img('loader.gif', $this->skin, 'main'),
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
			'loading' => ucfirst(lang('actions_loading')),
			'inactive' => ucfirst(lang('status_inactive')),
			'apply' => ucwords(lang('global_position') .' '. lang('status_open') .' '. NDASH
				.' '. lang('actions_apply') .' '. lang('time_now')),
			'npc' => lang('abbr_npc'),
			'manifests' => ucwords(lang('labels_site').' '.lang('labels_manifests')),
			'top_positions' => ucwords(lang('labels_top').' '.lang('status_open').' '.lang('global_positions')),
		);
		
		$this->_regions['content'] = Location::view('personnel_index', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_index_js', $this->skin, 'main', $js_data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}

	public function coc()
	{
		// load the models
		$this->load->model('ranks_model', 'ranks');
		
		// run the methods
		$query = $this->char->get_coc();
		$rank_ext = $this->ranks->get_rankcat($this->rank, 'rankcat_location', 'rankcat_extension');
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $item)
			{
				$loa = ( ! empty($item->user)) ? $this->user->get_loa($item->user) : 0;
				
				// set the color
				$color = '';
				
				if ($item->user > 0)
				{
					$color = ($loa == 'loa') ? '_loa' : $color;
					$color = ($loa == 'eloa') ? '_eloa' : $color;
				}
				
				$color = ($item->crew_type == 'inactive') ? '' : $color;
				$color = ($item->crew_type == 'npc') ? '_npc' : $color;
				
				// array of data for the 2 images each array generates (combadge and rank image)
				$images = array(
					'rank' => array(
						'src' => Location::rank($this->rank, $item->rank_image, $rank_ext),
						'alt' => $item->rank_name,
						'class' => 'image',
						'border' => 0),
					'bio' => array(
						'src' => Location::cb('combadge'. $color .'.png', $this->skin, 'main'),
						'alt' => ucwords(lang('actions_view') 
							.' '. lang('labels_bio')),
						'class' => 'image')
				);
				
				if ($item->crew_type == 'active' and empty($item->user))
				{
					// don't do anything
				}
				else
				{
					// data being passed to the view
					$data['coc'][$item->charid]['id'] = $item->charid;
					$data['coc'][$item->charid]['name'] = $this->char->get_character_name($item->charid, true);
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
		
		$data['edit_valid'] = (Auth::is_logged_in() and Auth::check_access('characters/coc', false)) ? true : false;
		
		// page header
		$data['header'] = lang('labels_coc');
		
		$data['label'] = array(
			'edit' => '[ '. ucfirst(lang('actions_edit')) .' ]',
		);
		
		$this->_regions['content'] = Location::view('personnel_coc', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_coc_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function character($id = false)
	{
		// load the models
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('positions_model', 'pos');
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('news_model', 'news');
		$this->load->model('awards_model', 'awards');
		$this->load->helper('utility');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		// grab the character info
		$character = $this->char->get_character($id);
		
		$data['postcount'] = 0;
		$data['logcount'] = 0;
		$data['newscount'] = 0;
		$data['awardcount'] = 0;
		
		if ($character !== false)
		{
			$data['postcount'] = $this->posts->count_character_posts($id);
			$data['logcount'] = $this->logs->count_character_logs($id);
			$data['newscount'] = $this->news->count_character_news($id);
			$data['awardcount'] = $this->awards->count_character_awards($id);
			
			$data['last_post'] = mdate($this->options['date_format'], gmt_to_local($character->last_post, $this->timezone, $this->dst));
			
			// set the name items into an array
			$name_array = array(
				'first_name' => $character->first_name,
				'middle_name' => $character->middle_name,
				'last_name' => $character->last_name,
				'suffix' => $character->suffix
			);
			
			// parse the name out
			$name = parse_name($name_array);
			$abbr_name = parse_name(array('first_name' => $character->first_name, 'last_name' => $character->last_name));
			
			// get the rank name
			$rank = $this->ranks->get_rank($character->rank, 'rank_name');
			
			// set the character info
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
			
			// set the data used by the view
			$data['character']['id'] = $id;
			$data['character']['name'] = $name;
			$data['character']['rank'] = $character->rank;
			$data['character']['position_1'] = $character->position_1;
			$data['character']['position_2'] = $character->position_2;
			$data['character']['user'] = ($character->user !== null or $character->user > 0) ? $character->user : null;
			
			if ($character->images > '')
			{
				// get the images
				$images = explode(',', $character->images);
				$images_count = count($images);
				
				$src = (strstr($images[0], 'http://') !== false)
					? $images[0]
					: base_url().Location::asset('images/characters', trim($images[0]));
				
				// set the image
				$data['character']['image'] = array(
					'src' => $src,
					'alt' => $name,
					'class' => 'image',
					'width' => 200
				);
				
				// creating the empty array
				$data['character']['image_array'] = array();
				
				for ($i=1; $i < $images_count; $i++)
				{
					$src = (strstr($images[$i], 'http://') !== false)
						? trim($images[$i])
						: base_url().Location::asset('images/characters', trim($images[$i]));
					
					// build the array
					$data['character']['image_array'][] = array(
						'src' => $src,
						'alt' => $name,
						'class' => 'image'
					);
				}
			}
			else
			{
				// set the image
				$data['character']['noavatar'] = array(
					'src' => Location::img('no-avatar.png', $this->skin, 'main'),
					'alt' => '',
					'class' => 'image',
					'width' => 200
				);
			}
						
			// get the bio tabs
			$tabs = $this->char->get_bio_tabs();
			
			// get the bio sections
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
							$data['fields'][$sec->section_id][$j]['value'] = false;
							
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
			
			// set the header
			$data['header'] = $rank.' '.$abbr_name;
			
			$this->_regions['title'].= ucfirst(lang('labels_biography')).' - '.$abbr_name;
		}
		else
		{
			// set the header
			$data['header'] = sprintf(lang('error_title_invalid_char'), ucfirst(lang('global_character')));
			$data['msg_error'] = sprintf(lang_output('error_msg_invalid_char'), lang('global_character'));
			
			// set the title
			$this->_regions['title'].= lang('error_pagetitle');
		}
		
		if (Auth::is_logged_in())
		{
			$data['edit_valid_form'] = (Auth::check_access('site/bioform', false)) ? true : false;
			
			if (Auth::check_access('characters/bio', false) === true)
			{
				if (Auth::get_access_level('characters/bio') == 3)
				{
					$data['edit_valid'] = true;
				}
				elseif (Auth::get_access_level('characters/bio') == 2)
				{
					$characters = $this->char->get_user_characters($this->session->userdata('userid'), '', 'array');
					
					$data['edit_valid'] = (in_array($id, $characters) or $character->crew_type == 'npc')
						? true
						: false;
				}
				elseif (Auth::get_access_level('characters/bio') == 1)
				{
					$characters = $this->char->get_user_characters($this->session->userdata('userid'), '', 'array');
					
					$data['edit_valid'] = in_array($id, $characters);
				}
				else
				{
					$data['edit_valid'] = false;
				}
			}
			else
			{
				$data['edit_valid'] = false;
			}
		}
		else
		{
			$data['edit_valid'] = false;
			$data['edit_valid_form'] = false;
		}
		
		$data['label'] = array(
			'edit' => ucwords(lang('actions_edit').' '.lang('global_character')),
			'view_all_posts' => ucwords(lang('actions_seeall') .' '. lang('global_missionposts')),
			'view_all_logs' => ucwords(lang('actions_seeall') .' '. lang('global_personallogs')),
			'view_all_awards' => ucwords(lang('actions_seeall') .' '. lang('global_awards')),
			'view_all_images' => ucwords(lang('actions_seeall') .' '. lang('labels_images')),
			'view_user' => ucwords(lang('global_user').' '.lang('labels_info')),
			'mission_posts' => ucwords(lang('global_missionposts')),
			'personal_logs' => ucwords(lang('global_personallogs')),
			'news_items' => ucwords(lang('global_newsitems')),
			'comments' => ucwords(lang('labels_comments')),
			'last_post' => ucwords(lang('order_last').' '.lang('global_post')),
			'stats' => ucfirst(lang('labels_stats')),
			'back_manifest' => LARROW.' '.ucfirst(lang('actions_back')).' '.lang('labels_to').' '.ucfirst(lang('labels_manifest')),
		);
		
		$this->_regions['content'] = Location::view('personnel_character', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_character_js', $this->skin, 'main');
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function user($user = false, $tab = 'basic')
	{
		Auth::is_logged_in(true);
		
		// figure out the tab
		switch ($tab)
		{
			case 'basic':
			default:
				$tabcode = 0;
			break;
			
			case 'stats':
				$tabcode = 1;
			break;
			
			case 'characters':
				$tabcode = 2;
			break;
			
			case 'rankhistory':
				$tabcode = 3;
			break;
			
			case 'posting':
				$tabcode = 4;
			break;
			
			case 'awards':
				$tabcode = 5;
			break;
		}
		
		// set the variables
		$user = (is_numeric($user)) ? $user : false;
		$js_data['tab'] = $tabcode;
		
		// load the resources
		$this->load->model('ranks_model', 'ranks');
		$this->load->model('posts_model', 'posts');
		$this->load->model('personallogs_model', 'logs');
		$this->load->model('awards_model', 'awards');
		$this->load->model('missions_model', 'mis');
		
		// run the methods
		$row = $this->user->get_user($user);
		$charinfo = array(
			'active' => $this->char->get_user_characters($user),
			'inactive' => $this->char->get_user_characters($user, 'inactive'),
			'npcs' => $this->char->get_user_characters($user, 'npc')
		);
		
		// set the datestring
		$datestring = $this->options['date_format'];
		
		if ($row !== false)
		{
			// calculate the timezone difference
			$pl_timezone = timezones($row->timezone);
			$my_timezone = timezones($this->timezone);
			$diff_timezone = $my_timezone - $pl_timezone;
			
			// load the date language file
			$this->lang->load('date', $this->session->userdata('language'));
			
			// timezone calculations
			$data['timezone'] = lang($row->timezone);
			
			if ($diff_timezone == 0)
			{
				$data['timezone_span'] = ucfirst(lang('time_hours_same'));
			}
			else
			{
				$data['timezone_span'] = abs($diff_timezone);
				$data['timezone_span'].= ( ! is_numeric(substr($diff_timezone, 0, 1))) ? ' '. lang('time_hours_ahead') : ' '. lang('time_hours_behind');
			}
			
			// set the data for the view
			$data['header'] = ucwords(lang('global_user') .' '. lang('labels_info')) .' - '. $row->name;
			$data['userid'] = $user;
			
			/**
			 * Basic Info
			 */
			
			$data['name'] = $row->name;
			$data['email'] = $row->email;
			$data['dob'] = $row->date_of_birth;
			$data['location'] = $row->location;
			$data['interests'] = $row->interests;
			$data['im'] = explode("\n", $row->instant_message);
			$data['bio'] = $row->bio;
			
			// make sure we have an accurate array of IM values
			foreach ($data['im'] as $key => $value)
			{
				if (empty($value))
				{
					unset($data['im'][$key]);
				}
			}
			
			/**
			 * Stats
			 */
			
			// get all of the user's active characters
			$all_active_characters = $this->char->get_user_characters($user);
			
			// get all of the user's inactive characters
			$all_inactive_characters = $this->char->get_user_characters($user, 'inactive');

			// create a holding variable
			$temp_activate = array();
			
			// get the activation dates for the active characters
			if ($all_active_characters->num_rows() > 0)
			{
				foreach ($all_active_characters->result() as $active)
				{
					$temp_activate[] = $active->date_activate;
				}
			}

			// get the activation dates for the inactive characters
			if ($all_inactive_characters->num_rows() > 0)
			{
				foreach ($all_inactive_characters->result() as $inactive)
				{
					$temp_activate[] = $inactive->date_activate;
				}
			}

			if (count($temp_activate) > 0)
			{
				// sort the activation array
				sort($temp_activate);
				
				// use the first item in the array as the final activation time
				$final_activate = $temp_activate[0];
			}

			// figure out what the final deactivation date should be
			if ($all_active_characters->num_rows() == 0)
			{
				$final_deactivate[] = now();
			}
			else
			{
				foreach ($all_active_characters->result() as $active)
				{
					$date = $active->date_deactivate;

					$temp_deactivate[] = ( (int) $date === 0 or $date === null)
						? now()
						: $active->date_deactivate;
				}
				
				// now that we have a list of deactivation dates, let's use the latest one
				rsort($temp_deactivate);
				
				$final_deactivate = $temp_deactivate[0];
			}
			
			$data['join_date_time'] = timespan_short($final_activate, $final_deactivate);
			$data['join_date'] = mdate($datestring, gmt_to_local($final_activate, $this->timezone, $this->dst));
			
			if ( ! empty($row->last_post))
			{
				$data['last_post_time'] = timespan_short($row->last_post, now());
				$data['last_post'] = mdate($datestring, gmt_to_local($row->last_post, $this->timezone, $this->dst));
			}
			
			if ( ! empty($row->last_login))
			{
				$data['last_login_time'] = timespan_short($row->last_login, now());
				$data['last_login'] = mdate($datestring, gmt_to_local($row->last_login, $this->timezone, $this->dst));
			}
			
			// get the IDs of the characters that user has
			$characters = $this->char->get_user_characters($user, '', 'array');
			
			// post and log counts
			$data['post_count'] = $this->posts->count_character_posts($characters);
			$data['log_count'] = $this->logs->count_character_logs($characters);
			
			// calculate the time in weeks
			$total_time = now() - $row->join_date;
			$days = $total_time / 86400;
			$weeks = ($days >= 7) ? $days / 7 : false;
			$time = round($weeks);
			
			// send the data to the view
			$data['avg_posts'] = ($weeks > 0) ? round($data['post_count'] / $weeks, 2) : 0;
			$data['avg_logs'] = ($weeks > 0) ? round($data['log_count'] / $weeks, 2) : 0;
			
			/**
			 * Character Info
			 */
			
			foreach ($charinfo as $key => $value)
			{
				foreach ($charinfo[$key]->result() as $k => $v)
				{
					// build an array of the rank, first name, and last name
					$name = array(
						'rank' => $this->ranks->get_rank($v->rank, 'rank_name'),
						'first' => $v->first_name,
						'last' => $v->last_name
					);
					
					foreach ($name as $a => $b)
					{
						if (empty($b))
						{
							unset($name[$a]);
						}
					}
					
					// implode the array into a string
					$name_string = implode(' ', $name);
					
					// set the character values
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
			
			/**
			 * Rank History
			 */
			
			// get the rank history
			$rankhistory = $this->char->get_rank_history($user);
			
			// array for storing the results
			$data['rank_history'] = array();
			
			if ($rankhistory->num_rows() > 0)
			{
				foreach ($rankhistory->result() as $rank)
				{
					$data['rank_history'][$rank->prom_char]['name'] = $this->char->get_character_name($rank->prom_char, true);
					$data['rank_history'][$rank->prom_char]['history'][] = array(
						'old_order' => $rank->prom_old_order,
						'old_rank' => $rank->prom_old_rank,
						'new_order' => $rank->prom_new_order,
						'new_rank' => $rank->prom_new_rank,
						'date' => mdate($datestring, gmt_to_local($rank->prom_date, $this->timezone, $this->dst)),
					);
				}
			}
			
			/**
			 * Posting Info
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
					$data['logs'][$i]['author'] = $this->char->get_character_name($l->log_author_character, true);
					
					++$i;
				}
			}
			
			/**
			 * Awards
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
					$data['awards'][$i]['name'] = (empty($a->awardrec_character)) ? $row->name : $this->char->get_character_name($a->awardrec_character, true);
					
					++$i;
				}
			}
			
			$this->_regions['title'].= $this->msgs->get_message('personnel_user_title').$row->name;
		}
		else
		{
			// set the header
			$data['header'] = sprintf(lang('error_title_invalid_user'), lang('global_user'));
			$data['msg_error'] = sprintf(lang('error_msg_invalid_user'), lang('global_user'));
			
			// set the title
			$this->_regions['title'].= lang('error_pagetitle');
		}
		
		if (Auth::is_logged_in())
		{
			if (Auth::check_access('user/account', false) and 
				Auth::get_access_level('user/account') == 1 and $user == $this->session->userdata('userid'))
			{
				$data['edit_valid'] = true;
			}
			elseif (Auth::check_access('user/account', false) and Auth::get_access_level('user/account') == 2)
			{
				$data['edit_valid'] = true;
			}
			else
			{
				$data['edit_valid'] = false;
			}
		}
		
		$data['label'] = array(
			'activechars' => ucwords(lang('status_active').' '.lang('global_characters')),
			'activefor' => ucfirst(lang('status_active').' '.lang('labels_for')),
			'ago' => lang('time_ago'),
			'average' => ucfirst(lang('labels_average')).':',
			'award' => ucfirst(lang('global_award')),
			'awards' => ucfirst(lang('global_awards')),
			'basicinfo' => ucwords(lang('labels_basic').' '.lang('labels_info')),
			'bio' => ucfirst(lang('labels_biography')),
			'by' => ucfirst(lang('labels_by')),
			'charinfo' => ucwords(lang('global_character').' '.lang('labels_info')),
			'date' => ucfirst(lang('labels_date')),
			'demoted' => ucfirst(lang('actions_demoted').' '.lang('labels_from')),
			'dob' => lang('labels_dob'),
			'edit' => '[ '.ucwords(lang('actions_edit').' '.lang('global_user')).' ]',
			'email' => ucwords(lang('labels_email_address')),
			'from' => lang('labels_from'),
			'im' => ucwords(lang('labels_im')),
			'inactivechars' => ucwords(lang('status_inactive').' '.lang('global_characters')),
			'interests' => ucfirst(lang('labels_interests')),
			'joined' => ucfirst(lang('actions_joined')),
			'lastlogin' => ucwords(lang('order_last').' '.lang('actions_login')),
			'lastpost' => ucwords(lang('order_last').' '.lang('global_post')),
			'location' => ucfirst(lang('labels_location')),
			'mission' => ucfirst(lang('global_mission')),
			'missionposts' => ucwords(lang('global_missionposts')),
			'name' => ucfirst(lang('labels_name')),
			'noawards' => sprintf(lang('error_not_found'), lang('global_awards')),
			'nologin' => sprintf(lang('error_not_found'), lang('order_last').' '.lang('actions_login')),
			'nologs' => sprintf(lang('error_not_found'), lang('global_personallogs')),
			'none' => ucfirst(lang('labels_none')),
			'nobasic' => sprintf(lang('error_not_found'), lang('labels_basic').' '.lang('labels_info')),
			'nopost' => sprintf(lang('error_not_found'), lang('order_last').' '.lang('global_post')),
			'noposts' => sprintf(lang('error_not_found'), lang('global_missionposts')),
			'norankhistory' => sprintf(lang('error_not_found'), lang('global_rank').' '.lang('labels_history')),
			'npcs' => lang('abbr_npcs'),
			'personallogs' => ucwords(lang('global_personallogs')),
			'perweek' => lang('time_per_week'),
			'postinginfo' => ucwords(lang('labels_posting').' '.lang('labels_info')),
			'promoted' => ucfirst(lang('actions_promoted').' '.lang('labels_to')),
			'rankhistory' => ucwords(lang('global_rank').' '.lang('labels_history')),				
			'reason' => ucfirst(lang('labels_reason')),
			'receivedby' => ucfirst(lang('actions_received').' '.lang('labels_by')),
			'stats' => ucfirst(lang('labels_stats')),
			'timezone' => ucfirst(lang('labels_timezone')),
			'title' => ucfirst(lang('labels_title')),
			'to' => lang('labels_to'),
			'totallogs' => ucwords(lang('labels_total').' '.lang('global_personallogs')),
			'totalposts' => ucwords(lang('labels_total').' '.lang('global_missionposts')),
			'viewawards' => ucwords(lang('actions_view').' '.lang('global_user').' '.lang('global_awards').' '.RARROW),
			'viewlogs' => ucwords(lang('actions_view').' '.lang('global_user').' '.lang('global_logs').' '.RARROW),
			'viewposts' => ucwords(lang('actions_view').' '.lang('global_user').' '.lang('global_posts').' '.RARROW),
		);
		
		$this->_regions['content'] = Location::view('personnel_user', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_user_js', $this->skin, 'main', $js_data);
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function viewawards($type = 'default', $id = false)
	{
		// load the models
		$this->load->model('awards_model', 'awards');
		
		// sanity check
		$id = (is_numeric($id)) ? $id : false;
		
		switch ($type)
		{
			case 'u':
				// run the model methods
				$item = $this->user->get_user($id);
				$data['user'] = $id;

				if ($item !== false)
				{
					// get the awards info
					$awards = $this->awards->get_awards_for_id($id, 'user');
					
					// set the name
					$name = $item->name;

					if ($awards->num_rows() > 0)
					{
						$i = 1;
						$datestring = $this->options['date_format'];

						foreach ($awards->result() as $row)
						{
							$date = gmt_to_local($row->awardrec_date, $this->timezone, $this->dst);
							
							$award_img = array(
								'src' => Location::asset('images/awards', $row->award_image),
								'alt' => $row->award_name,
								'class' => 'image award-small');
							
							if ($row->awardrec_character >= 1)
							{
								$data['char'][$row->awardrec_character]['character'] = $this->char->get_character_name($row->awardrec_character, true);
								$data['char'][$row->awardrec_character]['awards'][$i]['award_id'] = $row->award_id;
								$data['char'][$row->awardrec_character]['awards'][$i]['award'] = $row->award_name;
								$data['char'][$row->awardrec_character]['awards'][$i]['date'] = mdate($datestring, $date);
								$data['char'][$row->awardrec_character]['awards'][$i]['reason'] = $row->awardrec_reason;
								$data['char'][$row->awardrec_character]['awards'][$i]['img'] = $award_img;
								$data['char'][$row->awardrec_character]['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, true);
							}
							else
							{
								$data['awards'][$i]['award_id'] = $row->award_id;
								$data['awards'][$i]['award'] = $row->award_name;
								$data['awards'][$i]['date'] = mdate($datestring, $date);
								$data['awards'][$i]['reason'] = $row->awardrec_reason;
								$data['awards'][$i]['img'] = $award_img;
								$data['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, true);
							}
							
							++$i;
						}
						
						// other data used by the template
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
					}
					else
					{
						// set the data used by the view
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['msg_error'] = lang('error_no_awards');
					}
				}
				else
				{
					// set the data used by the view
					$data['header'] = lang('error_title_invalid_id');
					$data['msg_error'] = lang('error_msg_invalid_user');
				}
			break;
			
			case 'c':
				// run the model methods
				$char_row = $this->char->get_character($id);

				if ($char_row !== false)
				{
					// get the awards info
					$awards = $this->awards->get_awards_for_id($id);
					
					// set the name
					$name = $this->char->get_character_name($id);

					if ($awards->num_rows() > 0)
					{
						$i = 1;
						$datestring = $this->options['date_format'];

						foreach ($awards->result() as $row)
						{
							$award_img = array(
								'src' => Location::asset('images/awards', $row->award_image),
								'alt' => $row->award_name,
								'class' => 'image award-small');

							$date = gmt_to_local($row->awardrec_date, $this->timezone, $this->dst);

							$data['awards'][$i]['award_id'] = $row->award_id;
							$data['awards'][$i]['award'] = $row->award_name;
							$data['awards'][$i]['date'] = mdate($datestring, $date);
							$data['awards'][$i]['reason'] = $row->awardrec_reason;
							$data['awards'][$i]['img'] = $award_img;
							$data['awards'][$i]['nom'] = $this->char->get_character_name($row->awardrec_nominated_by, true);

							++$i;
						}

						// other data used by the template
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['charid'] = $id;
					}
					else
					{
						// set the data used by the view
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_awards')) .' - '. $name;
						$data['msg_error'] = lang('error_no_awards');
					}
				}
				else
				{
					// set the data used by the view
					$data['header'] = lang('error_title_invalid_id');
					$data['msg_error'] = lang('error_msg_invalid_char');
				}
			break;
				
			default:
				// set the data used by the view
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_award_type');
			break;
		}
		
		$data['label'] = array(
			'award' => ucfirst(lang('global_award')),
			'awarded' => ucfirst(lang('actions_awarded')),
			'awards' => ucfirst(lang('global_awards')),
			'backchar' => LARROW.' '.ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_character') .' '. lang('labels_bio')),
			'backuser' => LARROW.' '.ucfirst(lang('actions_back')) .' '. lang('labels_to') .' '.
				ucwords(lang('global_user') .' '. lang('labels_bio')),
			'nominatedby' => ucfirst(lang('actions_nominated') .' '. lang('labels_by')),
			'ooc' => ucwords(lang('labels_ooc')),
			'reason' => ucfirst(lang('labels_reason')),
		);
		
		$this->_regions['content'] = Location::view('personnel_viewawards', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_viewawards_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function viewlogs($type = 'default', $id = false, $offset = 0)
	{
		// load the resources
		$this->load->library('pagination');
		$this->load->model('personallogs_model', 'logs');
		$this->load->helper('text');
		
		// sanity checks
		$id = (is_numeric($id)) ? $id : false;
		$offset = (is_numeric($offset)) ? $offset : 0;
		
		// set the data variable
		$data = false;
		
		switch ($type)
		{
			case 'u':
				// run the model methods
				$row = $this->user->get_user($id);
				$data['user'] = $id;
				
				if ($row !== false)
				{
					// get the user's characters
					$characters = $this->char->get_user_characters($row->userid, 'active', 'array');
					
					foreach ($characters as $char)
					{
						// set the character name info
						$data['char'][$char]['character'] = $this->char->get_character_name($char, true);
						
						// grab all the character posts
						$logs = $this->logs->get_character_logs($char);
						
						if ($logs->num_rows() > 0)
						{
							$datestring = $this->options['date_format'];

							foreach ($logs->result() as $log)
							{
								$date = gmt_to_local($log->log_date, $this->timezone, $this->dst);

								$data['char'][$char]['logs'][$log->log_id]['id'] = $log->log_id;
								$data['char'][$char]['logs'][$log->log_id]['title'] = $log->log_title;
								$data['char'][$char]['logs'][$log->log_id]['date'] = mdate($datestring, $date);
								$data['char'][$char]['logs'][$log->log_id]['content'] = $log->log_content;
							}
						}
					}
					
					// other data used by the template
					$data['header'] = ucwords(lang('actions_view') .' '. lang('global_personallogs')) .' - '. $row->name;
				}
				else
				{
					// set the header
					$data['header'] = lang('error_title_invalid_user');
					$data['msg_error'] = lang('error_msg_invalid_user');
				}
			break;
				
			case 'c':
				// run the model methods
				$char_check = $this->char->get_character($id);

				if ($char_check !== false)
				{
					// set the pagination config
					$config['base_url'] = site_url('personnel/viewlogs/c/'.$id);
					$config['total_rows'] = $this->logs->count_character_logs($id);
					$config['uri_segment'] = 5;
					$config['per_page'] = $this->options['list_logs_num'];
					$config['full_tag_open'] = '<p class="fontMedium">';
					$config['full_tag_close'] = '</p>';
				
					// initialize the pagination library
					$this->pagination->initialize($config);
					
					// create the page links
					$data['pagination'] = $this->pagination->create_links('logs');
					
					$logs = $this->logs->get_character_logs($id, $config['per_page'], 'activated', $offset);

					if ($logs->num_rows() > 0)
					{
						$datestring = $this->options['date_format'];

						foreach ($logs->result() as $log)
						{
							$date = gmt_to_local($log->log_date, $this->timezone, $this->dst);

							$data['logs'][$log->log_id]['id'] = $log->log_id;
							$data['logs'][$log->log_id]['title'] = $log->log_title;
							$data['logs'][$log->log_id]['date'] = mdate($datestring, $date);
							$data['logs'][$log->log_id]['content'] = $log->log_content;
						}

						// other data used by the template
						$data['header'] = $this->msgs->get_message('personnel_logs_title') . $this->char->get_character_name($id);
						$data['charid'] = $id;
						
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
					}
					else
					{
						// other data used by the template
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_personallogs')) .' - '. $this->char->get_character_name($id);
						$data['msg_error'] = lang('error_no_logs');
					}
				}
				else
				{
					// set the header
					$data['header'] = lang('error_title_invalid_char');
					$data['msg_error'] = lang('error_msg_invalid_char');
				}
			break;
			
			default:
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_log_type');
			break;
		}
		
		$data['label'] = array(
			'addcomment' => ucfirst(lang('actions_add')).' '.lang('labels_a').' '.lang('labels_comment'),
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
		
		$this->_regions['content'] = Location::view('personnel_viewlogs', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_viewlogs_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function viewposts($type = 'default', $id = false, $offset = 0)
	{
		// load the resources
		$this->load->library('pagination');
		$this->load->model('posts_model', 'posts');
		$this->load->model('missions_model', 'mis');
		
		// sanity checks
		$id = (is_numeric($id)) ? $id : false;
		$offset = (is_numeric($offset)) ? $offset : 0;
		
		// set the data variable
		$data = false;
		
		switch ($type)
		{
			case 'u':
				// run the model methods
				$row = $this->user->get_user($id);
				$data['user'] = $id;
				
				if ($row !== false)
				{
					// get the user's characters
					$characters = $this->char->get_user_characters($row->userid, 'active', 'array');
					
					foreach ($characters as $char)
					{
						// set the character name info
						$data['char'][$char]['character'] = $this->char->get_character_name($char, true);
						
						// grab all the character posts
						$posts = $this->posts->get_character_posts($char);
						
						if ($posts->num_rows() > 0)
						{
							$datestring = $this->options['date_format'];

							foreach ($posts->result() as $post)
							{
								$date = gmt_to_local($post->post_date, $this->timezone, $this->dst);

								$data['char'][$char]['posts'][$post->post_id]['id'] = $post->post_id;
								$data['char'][$char]['posts'][$post->post_id]['title'] = $post->post_title;
								$data['char'][$char]['posts'][$post->post_id]['date'] = mdate($datestring, $date);
								$data['char'][$char]['posts'][$post->post_id]['mission'] = $this->mis->get_mission($post->post_mission, 'mission_title');
								$data['char'][$char]['posts'][$post->post_id]['mission_id'] = $post->post_mission;
							}
						}
					}
					
					// other data used by the template
					$data['header'] = ucwords(lang('actions_view') .' '. lang('global_missionposts')) .' - '. $row->name;
				}
				else
				{
					$data['header'] = lang('error_title_invalid_user');
					$data['msg_error'] = lang('error_msg_invalid_user');
				}
			break;
				
			case 'c':
				// run the model methods
				$char_check = $this->char->get_character($id);

				if ($char_check !== false)
				{
					// set the pagination config
					$config['base_url'] = site_url('personnel/viewposts/c/'.$id);
					$config['total_rows'] = $this->posts->count_character_posts($id);
					$config['uri_segment'] = 5;
					$config['per_page'] = $this->options['list_posts_num'];
					$config['full_tag_open'] = '<p class="fontMedium">';
					$config['full_tag_close'] = '</p>';
				
					// initialize the pagination library
					$this->pagination->initialize($config);
					
					// create the page links
					$data['pagination'] = $this->pagination->create_links('posts');
					
					$posts = $this->posts->get_character_posts($id, $config['per_page'], 'activated', $offset);

					if ($posts->num_rows() > 0)
					{
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

						// other data used by the template
						$data['header'] = $this->msgs->get_message('personnel_posts_title') . $this->char->get_character_name($id);
						$data['charid'] = $id;
						
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
								$this->options['list_logs_num'],
								$config['total_rows'],
								lang('global_missionposts')
							);
						}
					}
					else
					{
						// other data used by the template
						$data['header'] = ucwords(lang('actions_view') .' '. lang('global_missionposts')) .' - '. $this->char->get_character_name($id);
						$data['msg_error'] = lang('error_no_posts');
					}
				}
				else
				{
					// set the header
					$data['header'] = lang('error_title_invalid_char');
					$data['msg_error'] = lang('error_msg_invalid_char');
				}
			break;
			
			default:
				$data['header'] = lang('error_head_general');
				$data['msg_error'] = lang('error_msg_no_post_type');
			break;
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
		
		$this->_regions['content'] = Location::view('personnel_viewposts', $this->skin, 'main', $data);
		$this->_regions['javascript'] = Location::js('personnel_viewposts_js', $this->skin, 'main');
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
