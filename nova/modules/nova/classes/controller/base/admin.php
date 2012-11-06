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

		// Make sure we're logged in
		if ( ! \Sentry::check())
		{
			\Response::redirect('login/index/'.\Login\Controller_Login::NOT_LOGGED_IN);
		}

		// Set the variables
		$this->skin			= $this->session->get('skin_admin', $this->settings->skin_admin);
		$this->rank			= $this->session->get('rank', $this->settings->rank);
		$this->timezone		= $this->session->get('timezone', $this->settings->timezone);
		$this->images		= \Utility::getImageIndex($this->skin);

		// Get the skin section info
		$this->_section_info = \Model_Catalog_SkinSec::getItem($this->skin, 'skin');
		
		// Set the values to be passed to the structure
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'admin',
			'meta_desc'		=> $this->settings->meta_description,
			'meta_keywords'	=> $this->settings->meta_keywords,
			'meta_author'	=> $this->settings->meta_author,
		);
		
		// Set the structure file
		$this->template = \View::forge(\Location::file('admin', $this->skin, 'structure'), $vars);
		
		// Set the variables in the template
		$this->template->title 						= $this->settings->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('admin', $this->skin, 'template'), $vars);
		//$this->template->layout->navmain 			= \Nav::display('dropdown', 'admin', false);
		//$this->template->layout->navuser 			= \Nav::display('user', false, false);
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
		
		$this->template->layout->navsub 			= \View::forge(\Location::file('navsub', $this->skin, 'partial'));
		$this->template->layout->navsub->menu		= false;
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= \View::forge(\Location::file('footer', $this->skin, 'partial'));
		$this->template->layout->footer->extra 		= \Model_SiteContent::getContent('footer');

		if ($this->_section_info->nav == 'dropdown')
		{
			//$this->template->layout->navmain 		= \Nav::display('dropdown', 'main', 'main');
			$this->nav->setStyle($this->_section_info->nav)
				->setSection('admin')
				->setCategory('admin')
				->setType('admin');
			$this->template->layout->navmain = $this->nav->build();
		}
		else
		{
			$this->template->layout->navmain		= \Nav::display('classic', 'main', 'main');
		}
	}
}
