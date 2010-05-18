<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Main Controller (Base)
 *
 * @package		Nova Core
 * @subpackage	Controller
 * @author		Anodyne Productions
 * @version		2.0
 */

class Controller_Nova_Main extends Controller_Nova_Base
{
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_main';
		
		// pull the settings and put them into the options variable
		$this->options = $this->mSettings->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options['skin_main']);
		//$this->skin		= (Auth::is_logged_in()) ? $this->session->get('skin_main') : $this->options['skin_main'];
		$this->rank		= (Auth::is_logged_in()) ? $this->session->get('display_rank') : $this->options['display_rank'];
		$this->timezone	= (Auth::is_logged_in()) ? $this->session->get('timezone') : $this->options['timezone'];
		$this->dst		= (Auth::is_logged_in()) ? $this->session->get('dst') : $this->options['daylight_savings'];
		
		// set the shell
		$this->template = new View('_common/layouts/main', array('skin' => $this->skin, 'sec' => 'main'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options['sim_name'].' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= new View($this->skin.'/template_main', array('skin' => $this->skin, 'sec' => 'main'));
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'main');
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
	}
	
	public function action_index()
	{
		// pull in the additional setting items we need for this method
		$args = array(
			'where' => array(
				array(
					'field' => 'setting_key',
					'value' => 'show_news'
				),
			),
		);
		$this->options['show_news'] = $this->mCore->get('settings', $args, 'setting_value');
		
		// create a new content view
		$this->template->layout->content = new View(location::view('main_index', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if ($this->options['show_news'] == 'y')
		{
			$args = array(
				'join' => array(
					array('news_categories', 'news_categories.newscat_id', 'news.news_cat')
				),
				'where' => array(
					'status' => array(
						'field' => 'news_status',
						'value' => 'activated'),
					'private' => array(
						'field' => 'news_private',
						'value' => 'n'),
				),
				'order_by' => array(
					array('news_date', 'desc'),
				),
				'limit' => 5
			);
			
			if (Auth::is_logged_in())
			{
				unset($args['where']['private']);
			}
			
			$news = $this->mCore->get_all('news', $args);
			
			if ($news)
			{
				$data->news = array();
				
				foreach ($news as $n)
				{
					$data->news[] = $n;
				}
			}
		}
		
		// content
		$this->template->title.= 'Main';
		$data->header = $this->mMessages->get_message('main.index.header');
		$data->message = $this->mMessages->get_message('main.index.message');
		
		$this->request->response = $this->template;
	}
	
	/*public function contact()
	{
		# code...
	}
	
	public function credits()
	{
		# code...
	}
	
	public function join()
	{
		// pull in the additional setting items we need for this method
		$args = array('where' => array('setting_key' => 'use_sample_post'));
		$this->options['use_sample_post'] = $this->mCore->get('settings', $args, 'setting_value');
	}
	
	public function news()
	{
		# code...
	}*/
	
	public function viewnews($id = '')
	{
		# TODO: need to handle comment moderation
		
		// create a new content view
		$this->template->layout->content = new View(location::view('main_viewnews', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (isset($_POST['submit']))
		{
			// additional pieces of info that need to go on the end of the POST array
			$additional = array(
				'ncomment_date' => date::now(),
				'ncomment_author_user' => $this->session->get('userid'),
				'ncomment_author_character' => $this->session->get('main_char'),
				'ncomment_news' => $id
			);
			
			// what comes off the POST array
			$pop = array('submit');
			
			// submit the comment
			$submit = Submit::create($_POST, 'news_comments', $additional, $pop);
			
			// show the appropriate flash message
			$this->template->layout->flash_message = Submit::show_flash($submit, __('word.comment'), __('action.added'), $this->skin, 'main');
		}
		
		// grab the news item referenced in the url
		$args = array(
			'join' => array(
				array('news_categories', 'news_categories.newscat_id', 'news.news_cat', ''),
			),
			'where' => array(
				'id' => array(
					'field' => 'news_id',
					'value' => (is_numeric($id)) ? $id : FALSE),
			),
		);
		$news = $this->mCore->get('news', $args);
		
		// figure out what the previous item is
		$args = array(
			'where' => array(
				'id' => array(
					'field' => 'news_id',
					'value' => (is_numeric($id)) ? $id : FALSE,
					'operand' => '<',
				),
			),
			'order_by' => array('news_id' => 'desc'),
			'limit' => 1			
		);
		$prev = $this->mCore->get('news', $args);
		
		// figure out what the next item is
		$args = array(
			'where' => array(
				'id' => array(
					'field' => 'news_id',
					'value' => (is_numeric($id)) ? $id : FALSE,
					'operand' => '>',
				),
			),
			'order_by' => array('news_id' => 'asc'),
			'limit' => 1			
		);
		$next = $this->mCore->get('news', $args);
		
		if ($news)
		{
			// grab the news object
			$data->news = $news;
			
			// grab the news comments for this news item
			$args = array(
				'where' => array(
					'id' => array(
						'field' => 'ncomment_news',
						'value' => (is_numeric($id)) ? $id : FALSE
					),
					'status' => array(
						'field' => 'ncomment_status',
						'value' => 'activated'
					),
				),
				'order_by' => array('ncomment_date' => 'desc')
			);
			$comments = $this->mCore->get_all('news_comments', $args);
			
			if ($comments)
			{
				$data->comments = array();
				
				foreach ($comments as $c)
				{
					$data->comments[] = $c;
				}
			}
			
			// build the prev/next items
			$data->prev = ($prev) ? $prev->news_id : FALSE;
			$data->next = ($next) ? $next->news_id : FALSE;
			
			// build the images portion of the object
			$data->images = array(
				'rss' => array(
					'src' => location::image($this->images['main.rss'], $this->skin, 'main', 'image'),
					'alt' => __('abbr.rss'),
					'class' => ''),
				'prev' => array(
					'src' => location::image($this->images['main.previous'], $this->skin, 'main', 'image'),
					'alt' => __('word.previous'),
					'title' => ucfirst(__('word.previous')),
					'class' => ''),
				'next' => array(
					'src' => location::image($this->images['main.next'], $this->skin, 'main', 'image'),
					'alt' => __('word.next'),
					'title' => ucfirst(__('word.next')),
					'class' => ''),
				'comment'	=> array(),
			);
			
			// figure out if they're allowed to manage news items
			$data->edit = FALSE;
			
			if (Auth::check_access('manage/news', FALSE))
			{
				$level = Auth::get_access_level('manage/news');
				
				$data->edit = ($level == 2 || $level == 1 && ($news->news_author_user == $this->session->get('userid'))) ? TRUE : FALSE;
			}
			
			// make sure they're logged in if it's a private news item
			if ($news->news_private == 'y' && !Auth::is_logged_in())
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item'));
				$data->header = __('error.header');
				$data->headerclass = ' error';
				$data->message = '<p class="fontMedium">'.__('error.private_news', array(':news' => __('global.news_item'),':users' => __('global.users'))).'</p>';
			}
			else
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item')).' - '. $news->news_title;
				$data->header = $news->news_title;
				$data->headerclass = NULL;
				$data->message = NULL;
			}
		}
		else
		{
			$this->template->title.= ucwords(__('action.view').' '.__('global.news_item'));
			$data->header = __('error.header');
			$data->headerclass = ' error';
			$data->message = '<p class="fontMedium">'.__('error.not_found', array(':item' => __('global.news_item'))).'</p>';
		}
		
		// build the controls for the comment box
		$data->inputs = array(
			'content' => array(
				'name' => 'ncomment_content',
				'id' => 'ncomment_content',
				'placeholder' => __('phrase.enter_your_comment', array(':item' => __('global.news_item'))),
				'rows' => 6),
		);
		
		$data->buttons = array(
			'submit' => array(
				'type' => 'submit',
				'class' => 'button-main',
				'name' => 'submit',
				'value' => ucfirst(__('action.submit'))),
		);
	}
	
	public function test()
	{
		//$zone = new DateTimeZone();
		//echo Kohana::debug($zone->listAbbreviations());
		//echo Kohana::debug($zone->listIdentifiers());
		
		//echo Kohana::debug(date::timezones());
		
		//echo Kohana::debug(timezone_identifiers_list());
		//echo Kohana::debug(timezone_abbreviations_list());
		
		echo Kohana::debug(date::timezones());
		exit();
	}
	
	/*private function _email()
	{
		// pull in the additional setting items we need for this method
		$array = array('default_email_name', 'default_email_address', 'email_subject');
		$this->options[] = $this->mSettings->get_settings($array);
	}*/
}

// End of file main_base.php
// Location: modules/nova/classes/controller/nova/main.php