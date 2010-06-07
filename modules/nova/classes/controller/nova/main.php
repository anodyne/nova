<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Main Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Main extends Controller_Nova_Base
{
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$this->settingsArray[] = 'skin_main';
		
		// pull the settings and put them into the options object
		$this->options = Jelly::factory('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', array('skin' => $this->skin, 'sec' => 'main'));
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 					= $this->options->sim_name.' :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory($this->skin.'/template_main', array('skin' => $this->skin, 'sec' => 'main'));
		$this->template->layout->nav_main 		= Menu::build('main', 'main');
		$this->template->layout->nav_sub 		= Menu::build('sub', 'main');
		$this->template->layout->ajax 			= FALSE;
		$this->template->layout->flash_message	= FALSE;
	}
	
	public function action_index()
	{
		// pull in the additional setting items we need for this method
		$this->options->show_news = Jelly::select('setting')->key('show_news')->load()->value;
		
		// create a new content view
		$this->template->layout->content = View::factory(location::view('main_index', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if ($this->options->show_news == 'y')
		{
			// get the news
			$news = Jelly::select('news')
				->where('status', '=', 'activated')
				->order_by('news_date', 'desc')
				->limit(5);
			
			(!Auth::is_logged_in()) ? $news->where('private', '=', 'n') : FALSE;
			
			$news = $news->execute();
			
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
		$data->header = Jelly::select('message')->key('welcome_head')->load()->value;
		$data->message = Jelly::select('message')->key('welcome_msg')->load()->value;
		
		// send the response
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
	
	public function action_viewnews($id = '')
	{
		# TODO: need to handle comment moderation
		
		// sanitize the id
		$id = (!is_numeric($id)) ? FALSE : $id;
		
		// create a new content view
		$this->template->layout->content = View::factory(location::view('main_viewnews', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (isset($_POST['submit']))
		{
			// additional pieces of info that need to go on the end of the POST array
			$additional = array(
				'author_user' => $this->session->get('userid', 1),
				'author_character' => $this->session->get('main_char', 1),
				'news' => $id
			);
			
			// what comes off the POST array
			$pop = array('submit');
			
			// submit the comment
			$submit = Submit::create($_POST, 'newscomment', $additional, $pop);
			
			// show the appropriate flash message
			$this->template->layout->flash_message = Submit::show_flash($submit, __('label.comment'), __('action.added'), $this->skin, 'main');
		}
		
		// grab the news item referenced in the url
		$news = Jelly::select('news', $id);
		
		// figure out what the previous item is
		$prev = Jelly::select('news')
			->where('id', '<', $id)
			->order_by('id', 'desc');
			
		(!Auth::is_logged_in()) ? $prev->where('private', '=', 'n') : FALSE;
		
		$prev = $prev->load();
		
		// figure out what the next item is
		$next = Jelly::select('news')
			->where('id', '>', $id)
			->order_by('id', 'desc');
			
		(!Auth::is_logged_in()) ? $next->where('private', '=', 'n') : FALSE;
		
		$next = $next->load();
		
		if ($news->loaded())
		{
			// grab the news object
			$data->news = $news;
			
			// grab the news comments for this news item
			$comments = Jelly::select('newscomment')
				->where('news', '=', $id)
				->where('status', '=', 'activated')
				->order_by('date', 'desc')
				->execute();
			
			if ($comments)
			{
				$data->comments = array();
				
				foreach ($comments as $c)
				{
					$data->comments[] = $c;
				}
			}
			
			// build the prev/next items
			$data->prev = $prev->id;
			$data->next = $next->id;
			
			// build the images portion of the object
			$data->images = array(
				'rss' => array(
					'src' => location::image($this->images['main.rss'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('abbr.rss'),
						'class' => '')),
				'prev' => array(
					'src' => location::image($this->images['main.previous'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.previous'),
						'title' => ucfirst(__('word.previous')),
						'class' => '')),
				'next' => array(
					'src' => location::image($this->images['main.next'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.next'),
						'title' => ucfirst(__('word.next')),
						'class' => '')),
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
			if ($news->private == 'y' && !Auth::is_logged_in())
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item'));
				$data->header = __('error.header');
				$data->headerclass = ' error';
				$data->message = '<p class="fontMedium">'.__('error.private_news', array(':news' => __('global.news_item'),':users' => __('global.users'))).'</p>';
			}
			else
			{
				$this->template->title.= ucwords(__('action.view').' '.__('global.news_item')).' - '. $news->title;
				$data->header = $news->title;
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
				'name' => 'content',
				'value' => '',
				'attr' => array(
					'id' => 'ncomment_content',
					'placeholder' => __('phrase.enter_your_comment', array(':item' => __('global.news_item'))),
					'rows' => 6)),
		);
		
		$data->buttons = array(
			'submit' => array(
				'name' => 'submit',
				'value' => ucfirst(__('action.submit')),
				'attr' => array(
					'type' => 'submit',
					'class' => 'button-main')),
		);
	}
	
	public function action_test($id = 1)
	{
		/*$field = Jelly::select('formfield')
			->where('form', '=', 1)
			->where('display', '=', 'y')
				->execute();*/
			
		$field = db::select()->from('forms_fields')->where('field_form', '=', 1)->where('field_display', '=', 'y')->as_object()->execute();
		
		foreach ($field as $f)
		{
			$values = db::select()->from('forms_values')->where('value_field', '=', $f->field_id)->as_object()->execute();
			
			switch ($f->field_type)
			{
				case 'radio':
					if (count($values) > 0)
					{
						foreach ($values as $v)
						{
							$attr = array(
								'id' => $v->value_html_id,
								'class' => $f->field_html_class
							);
							
							$output[] = form::radio($f->field_html_name, $v->value_html_value, (bool) $v->value_selected, $attr).' '.form::label($v->value_html_id, $v->value_content);
						}
					}
					break;
					
				case 'checkbox':
					if (count($values) > 0)
					{
						foreach ($values as $v)
						{
							$attr = array(
								'id' => $v->value_html_id,
								'class' => $f->field_html_class
							);
								
							$check[] = form::checkbox($v->value_html_name, $v->value_html_value, (bool) $v->value_selected, $attr).' '.form::label($v->value_html_id, $v->value_content);
						}
					}
					break;
			}
		}
		
		echo Kohana::debug($output);
		echo implode(' ', $output);
		
		echo Kohana::debug($check);
		echo implode(' ', $check);
		exit();
			
		foreach ($field as $f)
		{
			$values = Jelly::select('formvalue')
				->where('field', '=', $f->id)
				->execute();
				
			switch ($f->type)
			{
				case 'radio':
					if (count($values) > 0)
					{
						foreach ($values as $v)
						{
							$attr = array(
								'id' => $v->html_id,
								'class' => $f->html_class
							);
							
							$output[] = form::radio($f->html_name, $v->field_value, $v->selected, $attr).' '.form::label($v->html_id, $v->content);
						}
					}
					break;
				
				default:
					# code...
					break;
			}
		}
	}
	
	public function action_test2()
	{
		Events::event('preCreate');
		exit();
	}
	
	/*private function _email()
	{
		// pull in the additional setting items we need for this method
		$array = array('default_email_name', 'default_email_address', 'email_subject');
		$this->options[] = $this->mSettings->get_settings($array);
	}*/
}

// End of file main.php
// Location: modules/nova/classes/controller/nova/main.php