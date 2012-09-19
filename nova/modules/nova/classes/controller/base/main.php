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
		
		// pull these additional settings
		$additional_settings = array(
			'skin_main',
		);
		
		// merge the settings arrays
		$this->_settings_setup = array_merge($this->_settings_setup, $additional_settings);
		
		// pull the settings and put them into the options object
		$this->options = \Model_Settings::getItems($this->_settings_setup);
		
		// set the variables
		$this->skin			= $this->session->get('skin_main', $this->options->skin_main);
		$this->rank			= $this->session->get('rank', $this->options->rank);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		$this->images		= \Utility::getImageIndex($this->skin);

		// get the skin section info
		$this->_section_info = \Model_Catalog_SkinSec::getItem($this->skin, 'skin');
		
		// set the values to be passed to the template
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'main',
			'sim_name'		=> $this->options->sim_name,
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the structure file
		$this->template = \View::forge(\Location::file('main', $this->skin, 'structure'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('main', $this->skin, 'templates'), $vars);

		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;

		$this->template->layout->navuser 			= \Nav::display('user', false, false);

		$this->template->layout->navsub 			= \View::forge(\Location::file('navsub', $this->skin, 'partials'));
		$this->template->layout->navsub->menu		= false;
		$this->template->layout->navsub->widget1	= false;
		$this->template->layout->navsub->widget2	= false;
		$this->template->layout->navsub->widget3	= false;
		
		$this->template->layout->footer				= \View::forge(\Location::file('footer', $this->skin, 'partials'));
		$this->template->layout->footer->extra 		= \Model_SiteContent::getContent('footer');

		if ($this->_section_info->nav == 'dropdown')
		{
			$this->template->layout->navmain 		= \Nav::display('dropdown', 'main', 'main');
		}
		else
		{
			$this->template->layout->navmain		= \Nav::display('classic', 'main', 'main');
		}
	}
}
