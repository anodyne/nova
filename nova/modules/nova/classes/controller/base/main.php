<?php
/**
 * Nova's main section base controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;
 
abstract class Controller_Base_Main extends Controller_Base_Core
{
	public $template;

	/**
	 * @var	object	The skin section catalog object
	 */
	protected $_section_info;
	
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
		
		// Set the variables
		$this->skin			= $this->session->get('skin_main', $this->settings->skin_main);
		$this->rank			= $this->session->get('rank', $this->settings->rank);
		$this->timezone		= $this->session->get('timezone', $this->settings->timezone);
		$this->images		= \Utility::getImageIndex($this->skin);

		// Get the skin section info
		$this->_section_info = \Model_Catalog_SkinSec::getItem($this->skin, 'skin');
		
		// Set the values to be passed to the structure
		$vars = array(
			'skin'		=> $this->skin,
			'sec'		=> 'main',
			'settings'	=> $this->settings,
		);
		
		// Set the structure file
		$this->template = \View::forge(\Location::file('main', $this->skin, 'structure'), $vars);
		
		// Set the variables in the template
		$this->template->title 						= $this->settings->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('main', $this->skin, 'template'), $vars);

		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;

		//$this->template->layout->navuser 			= \Nav::display('user', false, false);

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
				->setSection('main')
				->setCategory('main')
				->setType('main');
			$this->template->layout->navmain = $this->nav->build();
		}
		else
		{
			$this->template->layout->navmain		= \Nav::display('classic', 'main', 'main');
		}
	}
}
