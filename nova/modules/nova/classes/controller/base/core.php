<?php
/**
 * Nova's base controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 */

namespace Nova;
 
abstract class Controller_Base_Core extends \Controller_Template
{
	/**
	 * @var	Session	The current session instance.
	 */
	public $session;
	
	/**
	 * @var	object	An object that stores all of the setting values from the database.
	 */
	public $settings;
	
	/**
	 * @var	array	All the image information from the image indices.
	 */
	public $images;

	/**
	 * @var	string	The genre.
	 */
	public $genre;
	
	/**
	 * @var	string	The current skin.
	 */
	public $skin;
	
	/**
	 * @var	string	The current rank set.
	 */
	public $rank;
	
	/**
	 * @var	string	The current timezone.
	 */
	public $timezone;

	/**
	 * @var	Nav		The navigation object.
	 */
	protected $nav;
	
	/**
	 * @var	array	An array of setting keys used to make the final pull from the database.
	 */
	protected $_settings_setup;
	
	/**
	 * @var	object	Controller action data.
	 */
	protected $_data;

	/**
	 * @var	string	Fallback module.
	 */
	protected $_module_fallback = 'nova';
	
	/**
	 * @var	string	Name of the view file to use.
	 */
	protected $_view;
	
	/**
	 * @var	string	Name of the JavaScript view file to use.
	 */
	protected $_js_view;
	
	/**
	 * @var	object	Controller action data for the JavaScript view.
	 */
	protected $_js_data;

	/**
	 * @var	int		Status code to be passed to the Response object.
	 */
	protected $_status = 200;

	/**
	 * @var array 	Array of flash messages
	 */
	protected $_flash = array();
	
	/**
	 * @var	array 	An array of headers that can be used by the pages.
	 */
	protected $_headers = array();
	
	/**
	 * @var	array 	An array of messages that can be used by the pages.
	 */
	protected $_messages = array();
	
	/**
	 * @var	array 	An array of titles that can be used by the pages.
	 */
	protected $_titles = array();

	/**
	 * @var	bool	Whether the header and message are editable.
	 */
	protected $_editable = true;
	
	/**
	 * The before method handles setting up the controller before any action
	 * methods are called.
	 *
	 * @internal
	 * @return	void
	 */
	public function before()
	{
		parent::before();
		
		// If the config file isn't set
		if ( ! file_exists(APPPATH.'config/'.\Fuel::$env.'/db.php'))
		{
			\Response::redirect('setup/main/config');
		}

		// Make sure the system is installed
		if ( ! \Utility::installed())
		{
			\Response::redirect('setup/main/index');
		}
		
		// Get an instance of the Session
		$this->session = \Session::instance();

		// Set the genre
		$this->genre = \Config::get('nova.genre');

		// Create a new Nav
		$this->nav = new \Menu;

		// Load all of the settings
		$this->settings = \Model_Settings::getItems(false);

		// Load the nova config file
		\Config::load('nova', 'nova');
		
		// Set the language
		\Config::set('language', $this->session->get('language', 'en'));

		// Now, load the language files
		\Lang::load('app');
		\Lang::load('nova::base');
		\Lang::load('nova::event', 'event');
		\Lang::load('nova::email', 'email');
		\Lang::load('nova::error', 'error');
		\Lang::load('nova::action', 'action');
		\Lang::load('nova::short', 'short');
		\Lang::load('nova::sitecontent', 'sitecontent');
		
		// Set up the controller name without the Controller_ prefix
		$controllerName = strtolower(str_replace('Controller_', '', $this->request->controller));

		// Make sure the namespace is removed
		$controllerName = \Inflector::denamespace($controllerName);

		// Make sure we've removed the prefixes
		$controllerName = str_replace('admin_', '', $controllerName);

		// Create empty objects for the data
		$this->_data = new \stdClass;
		$this->_js_data = new \stdClass;
		
		// Grab the content for the current section
		$this->_headers		= \Model_SiteContent::getSectionContent('header', $controllerName);
		$this->_messages	= \Model_SiteContent::getSectionContent('message', $controllerName);
		$this->_titles		= \Model_SiteContent::getSectionContent('title', $controllerName);
	}
	
	/**
	 * The after method handles the final steps before rendering the output to
	 * the browser, including populating the template variable with all of the
	 * information it needs from the controller action.
	 *
	 * @internal
	 * @return	Response	a response object
	 */
	public function after($response)
	{
		parent::after($response);

		// Set the content view (if it's been set)
		if ( ! empty($this->_view))
		{
			$this->template->layout->content = \View::forge(\Location::file($this->_view, $this->skin, 'pages', $this->_module_fallback), $this->_data);
		}
		
		// Set the javascript view (if it's been set)
		if ( ! empty($this->_js_view))
		{
			$this->template->javascript = \View::forge(\Location::file($this->_js_view, $this->skin, 'js', $this->_module_fallback), $this->_js_data);
		}
		
		// Set the final title content
		$this->template->title.= (property_exists($this->_data, 'title')) 
			? $this->_data->title 
			: ((array_key_exists($this->request->action, $this->_titles)) ? $this->_titles[$this->request->action] : null);
		
		// Set the final header content
		$this->template->layout->header = (property_exists($this->_data, 'header')) 
			? $this->_data->header 
			: ((array_key_exists($this->request->action, $this->_headers)) ? $this->_headers[$this->request->action] : null);
		
		// set the final message content
		$this->template->layout->message = (property_exists($this->_data, 'message')) 
			? \Markdown::parse($this->_data->message)
			: ((array_key_exists($this->request->action, $this->_messages)) 
				? \Markdown::parse($this->_messages[$this->request->action])
				: null);

		if ($this->_editable === true)
		{
			// Set up the controller name without the Controller_ prefix
			$controllerName = strtolower(str_replace('Controller_', '', $this->request->controller));

			// Make sure the namespace is removed
			$controllerName = \Inflector::denamespace($controllerName);

			// Set the final header content key
			$this->template->layout->header_key = (array_key_exists($this->request->action, $this->_headers)) 
				? $controllerName.'_'.$this->request->action.'_header' 
				: false;

			// Set the final message content key
			$this->template->layout->message_key = (array_key_exists($this->request->action, $this->_messages)) 
				? $controllerName.'_'.$this->request->action.'_message' 
				: false;
		}
		
		// Flash messages
		if (count($this->_flash) > 0)
		{
			foreach ($this->_flash as $flash)
			{
				$this->template->layout->flash = \View::forge(\Location::file('flash', $this->skin, 'partials', $this->_module_fallback));
				$this->template->layout->flash->status = $flash['status'];
				$this->template->layout->flash->message = $flash['message'];
			}
		}

		// Return the response object
		return \Response::forge($this->template, $this->_status);
	}
	
	/**
	 * Every controller can pull information out of the wiki database
	 * by simply calling the page action and passing a link as the
	 * 3rd parameter. Like wiki pages, these are completely static
	 * and don't have access to any information out of the database.
	 *
	 * @internal
	 * @param	mixed	a page ID or page permalink
	 * @return	void
	 */
	public function action_page($link)
	{
		if (is_numeric($link))
		{
			/**
			 * Find the page based on the wiki page_id. If there isn't
			 * a page with that ID, return an error. If there is a page
			 * with that ID but it isn't classified as being in the
			 * current section, redirect them to that section. Otherwise,
			 * display the page.
			 */
		}
		else
		{
			/**
			 * Find the page based on the wiki page_permalink. If there isn't
			 * a page with that link, return an error. If there is a page
			 * with that link but it isn't classified as being in the
			 * current section, redirect them to that section. Otherwise,
			 * display the page.
			 */
		}

		return;
	}
}
