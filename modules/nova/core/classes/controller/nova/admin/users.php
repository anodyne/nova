<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Users Controller
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */

class Controller_Nova_Admin_Users extends Controller_Nova_Base {
	
	public function before()
	{
		parent::before();
		
		// check to make sure the user is logged in
		Auth::is_logged_in(true);
		
		// pull these additional setting keys that'll be available in every method
		$additionalSettings = array(
			'skin_admin',
		);
		
		// merge the settings arrays
		$this->settingsArray = array_merge($this->settingsArray, $additionalSettings);
		
		// pull the settings and put them into the options object
		$this->options = Jelly::query('setting')->get_settings($this->settingsArray);
		
		// set the variables
		$this->skin		= $this->session->get('skin_admin', $this->options->skin_admin);
		$this->rank		= $this->session->get('display_rank', $this->options->display_rank);
		$this->timezone	= $this->session->get('timezone', $this->options->timezone);
		$this->dst		= $this->session->get('dst', $this->options->daylight_savings);
		$this->section	= 'admin';
		
		// set the values to be passed to the views
		$vars = array(
			'template' => array(
				'skin' => $this->skin,
				'sec' => 'admin'),
			'layout' => array(
				'skin'	=> $this->skin,
				'sec'	=> 'admin'),
		);
		
		// set the shell
		$this->template = View::factory('_common/layouts/admin', $vars['template']);
		
		// grab the image index
		$this->images = Utility::get_image_index($this->skin);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= View::factory($this->skin.'/template_admin', $vars['layout']);
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
		$this->template->layout->content = View::factory(Location::view('users_index', $this->skin, 'admin', 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('users_index_js', $this->skin, 'admin', 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// get all the users
		$users = Jelly::query('user')->select();
		
		// start with an empty variable
		$data->users = false;
		
		if (count($users) > 0)
		{
			foreach ($users as $u)
			{
				// calculate the user's status
				$status = Jelly::query('user', $u->id)->get_status();
				
				// put the user in the right arrray
				$data->users[$status][$u->id] = $u;
			}
		}
		
		// images
		$data->images = array(
			'approve' => array(
				'src' => Location::image($this->images['admin.approve'], $this->skin, $this->section),
				'attr' => array(
					'alt' => 'approve',
					'title' => ucfirst(__('approve')))),
			'edit' => array(
				'src' => Location::image($this->images['admin.edit'], $this->skin, $this->section),
				'attr' => array(
					'alt' => 'edit',
					'title' => ucfirst(__('edit')))),
			'delete' => array(
				'src' => Location::image($this->images['admin.delete'], $this->skin, $this->section),
				'attr' => array(
					'alt' => 'delete',
					'title' => ucfirst(__('delete')))),
			'link' => array(
				'src' => Location::image($this->images['admin.link'], $this->skin, $this->section),
				'attr' => array(
					'alt' => 'link',
					'title' => ucfirst(__('link')))),
			'reject' => array(
				'src' => Location::image($this->images['admin.reject'], $this->skin, $this->section),
				'attr' => array(
					'alt' => 'reject',
					'title' => ucfirst(__('reject')))),
		);
		
		// content
		$data->header = ucwords(__("all :users", array(':users' => __('users'))));
		$this->template->title.= $data->header;
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_account($id = null)
	{
		// if there is no ID, set it to the current user
		$id = ($id === null) ? $this->session->get('userid') : $id;
		
		if ($id != $this->session->get('userid') and Auth::get_access_level() < 2)
		{
			// nope, nice try though
			// $this->request->redirect();
		}
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('users_account', $this->skin, $this->section, 'pages'));
		
		// create the javascript view
		$this->template->javascript = View::factory(Location::view('users_account_js', $this->skin, $this->section, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// send the ID over
		$data->id = $id;
		
		// get the user requested in the URI
		$data->user = Jelly::query('user', $id)->select();
		
		// content
		$data->header = ($id == $this->session->get('userid'))
			? ucwords(__(':my :account', array(':my' => __('my'), ':account' => __('account'))))
			: ucwords(__(":user :account", array(':user' => __('user'), ':account' => __('account'))));
		$this->template->title.= $data->header;
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function link($id = null)
	{
		# code...
	}
	
	public function nominate()
	{
		# code...
	}
	
	public function status()
	{
		# code...
	}
}
