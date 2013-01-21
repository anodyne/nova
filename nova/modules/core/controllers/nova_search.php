<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Search controller
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

require_once MODPATH.'core/libraries/Nova_controller_main.php';

abstract class Nova_search extends Nova_controller_main {
	
	public function __construct()
	{
		parent::__construct();
		
		$this->_regions['nav_sub'] = Menu::build('sub', 'main');
	}

	public function index()
	{
		// set the page title
		$data['header'] = ucfirst(lang('actions_search'));
		
		// set the input data
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
		
		// set the type array
		$data['type'] = array(
			'posts' => ucwords(lang('global_missionposts')),
			'logs' => ucwords(lang('global_personallogs')),
			'news' => ucwords(lang('global_newsitems')),
			'wiki' => ucwords(lang('global_wiki') .' '. lang('labels_pages')),
		);
		
		// set up the components
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
		
		$this->_regions['content'] = Location::view('search_index', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
	
	public function results()
	{
		// load the helper
		$this->load->helper('text');
		$this->load->helper('inflector');
		
		// set the search POST value to a variable
		$search = $this->input->post('search', true);
		
		if ($search != false)
		{
			$type = $this->input->post('type', true);
			$component = $this->input->post('component', true);
			$input = $this->input->post('input', true);
			
			switch ($type)
			{
				case 'posts':
					// load the model
					$this->load->model('posts_model', 'posts');
					
					// set the prefix
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
					// load the model
					$this->load->model('personallogs_model', 'logs');
					
					// set the prefix
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
					// load the model
					$this->load->model('news_model', 'news');
					
					// set the prefix
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
					// load the model
					$this->load->model('wiki_model', 'wiki');
					
					$result = $this->wiki->search_pages($component, $input);
				break;
			}
			
			if ($result->num_rows() > 0)
			{
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
							$row = ($page->num_rows() > 0) ? $page->row() : false;
							
							if ($row !== false)
							{
								$data['results'][$i]['content'] = $row->draft_content;
								$data['results'][$i]['link'] = anchor('wiki/view/page/'. $item->draft_page, $row->draft_title);
							}
						break;
					}
					
					++$i;
				}
			}
		}
		
		// set the page title
		$data['header'] = ucwords(lang('actions_search') .' '. lang('labels_results'));
		
		// set the message
		if ($result->num_rows() > 0)
		{
			$inflector = ($result->num_rows() > 1) ? lang('labels_results') : lang('labels_result');
			
			$data['msg'] = sprintf(
				lang('text_search_results'),
				$result->num_rows(),
				$inflector
			);
			
			if ($type == 'wiki')
			{
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
		
		$this->_regions['content'] = Location::view('search_results', $this->skin, 'main', $data);
		$this->_regions['title'].= $data['header'];
		
		Template::assign($this->_regions);
		
		Template::render();
	}
}
