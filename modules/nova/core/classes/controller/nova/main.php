<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 */

class Controller_Nova_Main extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_main',
			'email_subject',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Jelly::query('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		
		// set the values to be passed to the views
		$vars = array(
			'template' => array(
				'skin' => $this->skin,
				'sec' => 'main'),
			'layout' => array(
				'skin'	=> $this->skin,
				'sec'	=> 'main'),
		);
		
		// set the shell
		$this->template = View::factory('_common/layouts/main', $vars['template']);
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory($this->skin.'/template_main', $vars['layout']);
		$this->template->layout->navmain 			= Menu::build('main', 'main');
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		
		$this->template->layout->panel				= View::factory('_common/partials/panel');
		$this->template->layout->panel->panel1		= false;
		$this->template->layout->panel->panel2		= false;
		$this->template->layout->panel->panel3		= false;
		$this->template->layout->panel->workflow	= false;
		
		$this->template->layout->navsub 			= View::factory('_common/partials/navsub');
		$this->template->layout->navsub->menu		= Menu::build('sub', 'main');
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= View::factory('_common/partials/footer');
		$this->template->layout->footer->extra 		= Jelly::query('message', 'footer')->limit(1)->select()->value;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_index', $this->skin, 'main', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('main_index_js', $this->skin, 'main', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		# TODO: when widgets are worked on, this will need to uncommented
		// get all of the widgets for the page
		//$widgets = Jelly::query('cataloguewidget')->where('page', '=', 'main/index')->select();
		$widgets = array();
		
		if (count($widgets) > 0)
		{
			// set the widgets array
			$data->widgets = array();
			
			// loop through the widgets and pass the info to the view
			foreach ($widgets as $w)
			{
				$data->widgets[$w->zone] = $w;
			}
		}
		
		// content
		$this->template->title.= ucfirst(__("main"));
		$data->header = Jelly::query('message', 'welcome_head')->limit(1)->select()->value;
		$data->message = Jelly::query('message', 'welcome_msg')->limit(1)->select()->value;
		
		// send the response
		$this->request->response = $this->template;
	}
	/*
	public function action_contact()
	{
		if (isset($_POST['submit']))
		{
			// clear the errors (if there are any)
			$this->session->delete('errors');
			
			// set the validation rules
			$validate = Validate::factory($_POST)
				->rule('email', 'not_empty')
				->rule('email', 'email')
				->rule('name', 'not_empty')
				->rule('subject', 'not_empty')
				->rule('message', 'not_empty');
			
			// run the check to make sure everything is validated like it should be
			if ($validate->check())
			{
				// set the data for the email
				$emaildata = new stdClass;
				$emaildata->name = trim(Security::xss_clean($_POST['name']));
				$emaildata->email = trim(Security::xss_clean($_POST['email']));
				$emaildata->subject = trim(Security::xss_clean($_POST['subject']));
				$emaildata->message = trim(Security::xss_clean($_POST['message']));
				$emaildata->cc = trim(Security::xss_clean($_POST['ccme']));
				
				// send the email
				$email = $this->_email('contact', $emaildata);
				
				// set the flash message
				$this->template->layout->flash = Submit::show_flash( (int) $email, __("your information"), __("submitted"), $this->skin, 'main');
			}
			else
			{
				// set the errors
				$this->session->set('errors', $validate->errors('register'));
			}
		}
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_contact', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(__("contact us"));
		$data->header = ucwords(__("contact us"));
		$data->message = Jelly::query('message', 'contact')->limit(1)->select()->value;
		
		// fields
		$data->inputs = array(
			'name' => array(
				'id' => 'name'),
			'email' => array(
				'type' => 'email',
				'id' => 'email'),
			'subject' => array(
				'id' => 'subject'),
			'message' => array(
				'id' => 'message',
				'rows' => 12),
			'submit' => array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit'),
		);
		
		// images
		$data->images = array(
			'error' => array(
				'src' => Location::image($this->images['main.error'], $this->skin, 'main', 'image'),
				'attr' => array(
					'alt' => '!',
					'class' => 'inline-image-left')),
		);
		
		// set the validation errors
		$data->errors = ($this->session->get('errors')) ? $this->session->get('errors') : false;
		
		// send the response
		$this->request->response = $this->template;
	}
	*/
	public function action_credits()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_credits', $this->skin, 'main', 'pages'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ucwords(__("site credits"));
		$data->header = ucwords(__("site credits"));
		
		// non-editable credits
		$credits_perm = Jelly::query('message', 'credits_perm')->limit(1)->select()->value;
		$credits_perm.= "\r\n\r\n".Jelly::query('catalogueskinsec')->defaultskin('main')->select()->skin->credits;
		$credits_perm.= "\r\n\r\n".Jelly::query('cataloguerank', $this->rank)->limit(1)->select()->credits;
		
		// credits
		$data->credits_perm = nl2br($credits_perm);
		$data->credits = Jelly::query('message', 'credits')->limit(1)->select()->value;
		
		// should we show an edit link?
		$data->edit = (Auth::is_logged_in() and Auth::check_access('site/messages', false))
			? true
			: false;
		
		// send the response
		$this->request->response = $this->template;
	}
	/*
	public function join()
	{
		# code...
	}
	
	public function action_news()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_news', $this->skin, 'main', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('main_news_js', $this->skin, 'main', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// get all the news items
		$news = Jelly::query('news')->where('status', '=', 'activated')->order_by('date', 'desc');
		
		// if the user isn't logged in, only pull public news items
		( ! Auth::is_logged_in()) ? $news->where('private', '=', 'n') : false;
		
		// run the query
		$news = $news->select();
		
		// make sure there are news items
		if (count($news) > 0)
		{
			// set the variable being used by the news items
			$data->news = false;
			
			// send the timezone to the view
			$data->timezone = $this->timezone;
			
			// loop through all the items and pass them to the view
			foreach ($news as $n)
			{
				$data->news[$n->id] = $n;
			}
		}
		
		// get the categories
		$cats = Jelly::query('newscategory')->select();
		
		// make sure there are news categories
		if (count($cats) > 0)
		{
			// set the variables being used by the news categories
			$data->categories = false;
			$data->lastcategory = false;
			
			// set the counter
			$i = 0;
			
			// loop through all the categories and pass them to the view
			foreach ($cats as $c)
			{
				// increment the count
				++$i;
				
				$data->categories[$c->id] = $c;
				
				$data->lastcategory[$c->id] = (count($cats) == $i) ? true : false;
			}
		}
		
		// content
		$this->template->title.= ucwords(__("news"));
		$data->header = ucwords(__("news"));
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_viewnews($id = null)
	{
		# TODO: need to handle comment moderation
		
		// sanitize the id
		$id = ( ! is_numeric($id)) ? false : $id;
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('main_viewnews', $this->skin, 'main', 'pages'));
		
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
		$news = Jelly::query('news', $id)->limit(1)->select();
		
		// figure out what the previous item is
		$prev = Jelly::query('news')->where('id', '<', $id)->order_by('id', 'desc')->limit(1);
			
		( ! Auth::is_logged_in()) ? $prev->where('private', '=', 'n') : false;
		
		$prev = $prev->select();
		
		// figure out what the next item is
		$next = Jelly::query('news')->where('id', '>', $id)->order_by('id', 'desc')->limit(1);
			
		( ! Auth::is_logged_in()) ? $next->where('private', '=', 'n') : false;
		
		$next = $next->select();
		
		if (count($news) > 0)
		{
			// grab the news object
			$data->news = $news;
			
			// build the prev/next items
			$data->prev = $prev->id;
			$data->next = $next->id;
			
			// build the images portion of the object
			$data->images = array(
				'rss' => array(
					'src' => Location::image($this->images['main.rss'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('abbr.rss'),
						'class' => '')),
				'prev' => array(
					'src' => Location::image($this->images['main.previous'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.previous'),
						'title' => ucfirst(__('word.previous')),
						'class' => '')),
				'next' => array(
					'src' => Location::image($this->images['main.next'], $this->skin, 'main', 'image'),
					'attr' => array(
						'alt' => __('word.next'),
						'title' => ucfirst(__('word.next')),
						'class' => '')),
				'comment'	=> array(),
			);
			
			// figure out if they're allowed to manage news items
			$data->edit = false;
			
			if (Auth::check_access('manage/news', false))
			{
				$level = Auth::get_access_level('manage/news');
				
				$data->edit = ($level == 2 or ($level == 1 and ($news->news_author_user == $this->session->get('userid')))) ? true : false;
			}
			
			// make sure they're logged in if it's a private news item
			if ($news->private == 'y' and ! Auth::is_logged_in())
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
				$data->headerclass = null;
				$data->message = null;
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
	
	protected function _email($type, $data)
	{
		// set the email variable that'll be returned
		$email = false;
		
		// make sure system email is turned on
		if ($this->options->system_email == 'on')
		{
			// set up the mailer
			$mailer = Email::setup_mailer();
			
			// create a new message
			$message = Email::setup_message();
			
			switch ($type)
			{
				case 'contact':
					// data for the view files
					$view = new stdClass;
					$view->subject = __("email.subject.contact", array(':name' => $data->name));
					$view->content = $data->message;
					
					// set the html version
					$html = View::factory(Location::view('main_contact_em_html', $this->skin, 'main', 'email'), $view);
					
					// set the text version
					$text = View::factory(Location::view('main_contact_em_text', $this->skin, 'main', 'email'), $view);
					
					// figure out who gets the email
					$to = implode(',', Jelly::factory('user')->get_gm_data('email'));
					
					// set the message data
					$message->setSubject($this->options->email_subject.' '.$view->subject);
					$message->setFrom(array($data->email => $data->name));
					$message->setTo($to);
					$message->setBody($html->render(), 'text/html');
					$message->addPart($text->render(), 'text/plain');
				break;
			}
			
			// send the message
			$email = $mailer->send($message);
		}
		
		return $email;
	}
	*/
}