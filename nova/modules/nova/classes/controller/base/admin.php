<?php
/**
 * Nova's admin section base controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;
 
abstract class Controller_Base_Admin extends Controller_Base_Core
{
	public $template;
	
	/**
	 * The before method handles setting up the controller before any action
	 * methods are called.
	 *
	 * @api
	 * @return	void
	 */
	public function before()
	{
		parent::before();

		// make sure we're logged in
		if ( ! \Sentry::check())
		{
			$this->response->redirect('login/index/'.\Login\Controller_Login::NOT_LOGGED_IN);
		}

		// pull these additional settings
		$additional_settings = array(
			'skin_admin',
		);
		
		// merge the settings arrays
		$this->_settings_setup = array_merge($this->_settings_setup, $additional_settings);
		
		// pull the settings and put them into the options object
		$this->options = \Model_Settings::get_settings($this->_settings_setup);
		
		// set the variables
		$this->skin			= $this->session->get('skin_admin', $this->options->skin_admin);
		$this->rank			= $this->session->get('rank', $this->options->rank);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		$this->images		= \Utility::get_image_index($this->skin);
		
		// set the values to be passed to the template
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'admin',
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the structure file
		$this->template = \View::forge(\Location::file('admin', $this->skin, 'structure'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('admin', $this->skin, 'templates'), $vars);
		$this->template->layout->navmain 			= \Nav::display('dropdown', 'admin', false);
		$this->template->layout->navuser 			= \Nav::display('user', false, false);
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
		
		$this->template->layout->navsub 			= \View::forge(\Location::file('navsub', $this->skin, 'partials'));
		$this->template->layout->navsub->menu		= false;
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= \View::forge(\Location::file('footer', $this->skin, 'partials'));
		$this->template->layout->footer->extra 		= \Model_SiteContent::get_content('footer');
	}
}
