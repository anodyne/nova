<?php
/**
 * Nova's login section base controller.
 *
 * @package		Nova
 * @subpackage	Login
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Login;
 
abstract class Controller_Base_Login extends \Nova\Controller_Base_Core
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

		// change the fallback module
		$this->_module_fallback = 'login';
		
		// pull these additional settings
		$additional_settings = array(
			'skin_login',
		);
		
		// merge the settings arrays
		$this->_settings_setup = array_merge($this->_settings_setup, $additional_settings);
		
		// pull the settings and put them into the options object
		$this->options = \Model_Settings::get_settings($this->_settings_setup);
		
		// set the variables
		$this->skin			= $this->session->get('skin_login', $this->options->skin_login);
		$this->rank			= $this->session->get('rank', $this->options->rank);
		$this->timezone		= $this->session->get('timezone', $this->options->timezone);
		
		// set the values to be passed to the template
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'login',
			'meta_desc'		=> $this->options->meta_description,
			'meta_keywords'	=> $this->options->meta_keywords,
			'meta_author'	=> $this->options->meta_author,
		);
		
		// set the structure file
		$this->template = \View::forge(\Location::file('login', $this->skin, 'structure', 'login'), $vars);
		
		// set the variables in the template
		$this->template->title 						= $this->options->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('login', $this->skin, 'templates', 'login'), $vars);
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
	}
}
