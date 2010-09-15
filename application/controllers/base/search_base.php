<?php
/*
|---------------------------------------------------------------
| SEARCH CONTROLLER
|---------------------------------------------------------------
|
| File: controllers/base/search_base.php
| System Version: 1.1.1
|
| Changes: fixed a bug where nova wouldn't display because it
|	couldn't find the template file
|
*/

class Search_base extends Controller {
	
	/* set the variables */
	var $options;
	var $skin;
	var $rank;
	var $timezone;
	var $dst;

	function Search_base()
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
			'date_format'
		);
		
		/* grab the settings */
		$this->options = $this->settings->get_settings($settings_array);
		
		/* set the variables */
		$this->skin = $this->options['skin_main'];
		$this->rank = $this->options['display_rank'];
		$this->timezone = $this->options['timezone'];
		$this->dst = (bool) $this->options['daylight_savings'];
		
		if ($this->auth->is_logged_in())
		{
			$this->skin = (file_exists(APPPATH .'views/'.$this->session->userdata('skin_main').'/template_main'.EXT))
				? $this->session->userdata('skin_main')
				: $this->skin;
			$this->rank = $this->session->userdata('display_rank');
			$this->timezone = $this->session->userdata('timezone');
			$this->dst = (bool) $this->session->userdata('dst');
		}
		
		/* set and load the language file needed */
		$this->lang->load('app', $this->session->userdata('language'));
		
		/* set the template */
		$this->template->set_master_template($this->skin . '/template_main.php');
		
		/* write the common elements to the template */
		$this->template->write('nav_main', $this->menu->build('main', 'main'), TRUE);
		$this->template->write('nav_sub', $this->menu->build('sub', 'main'), TRUE);
		$this->template->write('title', $this->options['sim_name'] . ' :: ');
		
		if ($this->auth->is_logged_in())
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
		/* set the page title */
		$data['header'] = ucfirst(lang('actions_search'));
		
		/* set the input data */
		$data['inputs'] = array(
			'search' => array(
				'name' => 'input',
				'id' => 'input'),
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'search',
				'value' => 'search',
				'content' => ucwords(lang('actions_search')))
		);
		
		/* set the type array */
		$data['type'] = array(
			'posts' => ucwords(lang('global_missionposts')),
			'logs' => ucwords(lang('global_personallogs')),
			'news' => ucwords(lang('global_newsitems')),
			'wiki' => ucwords(lang('global_wiki') .' '. lang('labels_pages')),
		);
		
		/* set up the components */
		$data['component'] = array(
			'title' => ucwords(lang('labels_title')),
			'content' => ucwords(lang('labels_content')),
			'tags' => ucwords(lang('labels_tags'))
		);
		
		$data['label'] = array(
			'type' => ucwords(lang('labels_type')),
			'search_in' => ucwords(lang('actions_search') .' '. lang('labels_in')),
			'search_for' => ucwords(lang('actions_search') .' '. lang('labels_for')),
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('search_index', $this->skin, 'main');
		$js_loc = js_location('search_index_js', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		$this->template->write_view('javascript', $js_loc);
		
		/* render the template */
		$this->template->render();
	}
	
	function results()
	{
		/* load the helper */
		$this->load->helper('text');
		$this->load->helper('inflector');
		
		/* set the search POST value to a variable */
		$search = $this->input->post('search', TRUE);
		
		if ($search != FALSE)
		{ /* if the search variable is set */
			$type = $this->input->post('type', TRUE);
			$component = $this->input->post('component', TRUE);
			$input = $this->input->post('input', TRUE);
			
			switch ($type)
			{ /* move through the types and take the right action */
				case 'posts':
					/* load the model */
					$this->load->model('posts_model', 'posts');
					
					/* set the prefix */
					$prefix = 'post_';
					$id = 'item->post_id';
					
					switch ($component)
					{
						case 'title':
							$comp = $prefix .'title';
							$title = 'post_title';
							break;
						case 'content':
							$comp = $prefix .'content';
							$content = 'post_content';
							break;
						case 'tags':
							$comp = $prefix .'tags';
							$tags = 'post_tags';
							break;
					}
					
					$result = $this->posts->search_posts($comp, $input);
					break;
				
				case 'logs':
					/* load the model */
					$this->load->model('personallogs_model', 'logs');
					
					/* set the prefix */
					$prefix = 'log_';
					
					switch ($component)
					{
						case 'title':
							$comp = $prefix .'title';
							break;
						case 'content':
							$comp = $prefix .'content';
							break;
						case 'tags':
							$comp = $prefix .'tags';
							break;
					}
					
					$result = $this->logs->search_logs($comp, $input);
					break;
					
				case 'news':
					/* load the model */
					$this->load->model('news_model', 'news');
					
					/* set the prefix */
					$prefix = 'news_';
					
					switch ($component)
					{
						case 'title':
							$comp = $prefix .'title';
							break;
						case 'content':
							$comp = $prefix .'content';
							break;
						case 'tags':
							$comp = $prefix .'tags';
							break;
					}
					
					$result = $this->news->search_news($comp, $input);
					break;
					
				case 'wiki':
					/* load the model */
					$this->load->model('wiki_model', 'wiki');
					
					$result = $this->wiki->search_pages($component, $input);
					break;
			}
			
			if ($result->num_rows() > 0)
			{ /* if there are results */
				$i = 1;
				foreach ($result->result() as $item)
				{
					switch ($type)
					{
						case 'posts':
							$data['results'][$i]['content'] = $item->post_content;
							$data['results'][$i]['link'] = anchor('sim/viewpost/'. $item->post_id, $item->post_title);
							break;
						case 'logs':
							$data['results'][$i]['content'] = $item->log_content;
							$data['results'][$i]['link'] = anchor('sim/viewlog/'. $item->log_id, $item->log_title);
							break;
						case 'news':
							$data['results'][$i]['content'] = $item->news_content;
							$data['results'][$i]['link'] = anchor('main/viewnews/'. $item->news_id, $item->news_title);
							break;
						case 'wiki':
							$page = $this->wiki->get_page($item->draft_page);
							$row = ($page->num_rows() > 0) ? $page->row() : FALSE;
							
							if ($row !== FALSE)
							{
								$data['results'][$i]['content'] = $row->draft_content;
								$data['results'][$i]['link'] = anchor('wiki/page/view/'. $item->draft_page, $row->draft_title);
							}
							
							break;
					}
					
					++$i;
				}
			}
		}
		
		/* set the page title */
		$data['header'] = ucwords(lang('actions_search') .' '. lang('labels_results'));
		
		/* set the message */
		if ($result->num_rows() > 0)
		{
			$inflector = ($result->num_rows() > 1) ? lang('labels_results') : lang('labels_result');
			
			$data['msg'] = sprintf(
				lang('text_search_results'),
				$result->num_rows(),
				$inflector
			);
			
			if ($type == 'wiki')
			{ /* if it's a wiki search, show an additional explanation */
				$data['msg'].= "\r\n\r\n";
				$data['msg'].= sprintf(lang('wiki_search_results'), ucfirst(lang('global_wiki')));
			}
		}
		
		$data['label'] = array(
			'search' => LARROW .' '. ucwords(lang('actions_back')) .' '.
				lang('labels_to') .' '.
				ucwords(lang('actions_search')),
			'noresult' => ucfirst(lang('labels_no') .' '. lang('labels_results') .' '.
				lang('actions_found')),
		);
		
		/* figure out where the view JS files should be coming from */
		$view_loc = view_location('search_results', $this->skin, 'main');
		
		/* write the data to the template */
		$this->template->write('title', $data['header']);
		$this->template->write_view('content', $view_loc, $data);
		
		/* render the template */
		$this->template->render();
	}
}

/* End of file search_base.php */
/* Location: ./application/controllers/base/search_base.php */