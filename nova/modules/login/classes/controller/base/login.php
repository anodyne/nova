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

		// Change the fallback module
		$this->_module_fallback = 'login';
		
		// Set the variables
		$this->skin			= $this->session->get('skin_login', $this->settings->skin_login);
		$this->rank			= $this->session->get('rank', $this->settings->rank);
		$this->timezone		= $this->session->get('timezone', $this->settings->timezone);
		
		// Set the values to be passed to the structure
		$vars = array(
			'skin'			=> $this->skin,
			'sec'			=> 'login',
			'meta_desc'		=> $this->settings->meta_description,
			'meta_keywords'	=> $this->settings->meta_keywords,
			'meta_author'	=> $this->settings->meta_author,
		);
		
		// Set the structure file
		$this->template = \View::forge(\Location::file('login', $this->skin, 'structure', 'login'), $vars);
		
		// Set the variables in the template
		$this->template->title 						= $this->settings->sim_name.' :: ';
		$this->template->javascript					= false;
		$this->template->layout						= \View::forge(\Location::file('login', $this->skin, 'template', 'login'), $vars);
		$this->template->layout->ajax 				= false;
		$this->template->layout->flash				= false;
		$this->template->layout->content			= false;
		$this->template->layout->header				= false;
		$this->template->layout->message			= false;
	}
}
