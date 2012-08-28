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
	public $options;
	
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
		
		// if the config file isn't set
		if ( ! file_exists(APPPATH.'config/'.\Fuel::$env.'/db.php'))
		{
			$this->response->redirect('setup/main/config');
		}

		// make sure the system is installed
		if ( ! \Utility::installed())
		{
			$this->response->redirect('setup/main/index');
		}
		
		// load the session library
		$this->session = \Session::instance();

		// load the nova config file
		\Config::load('nova', 'nova');

		// set the genre as a variable
		$this->genre = \Config::get('nova.genre');
		
		// set the language
		\Config::set('language', $this->session->get('language', 'en'));

		// load the language files
		\Lang::load('app');
		\Lang::load('nova::base');
		\Lang::load('nova::event', 'event');
		\Lang::load('nova::email', 'email');
		\Lang::load('nova::error', 'error');
		\Lang::load('nova::action', 'action');
		\Lang::load('nova::short', 'short');
		\Lang::load('nova::sitecontent', 'sitecontent');
		
		// these are the settings we pull for every controller
		$this->_settings_setup = array(
			'rank',
			'timezone',
			'date_format',
			'sim_name',
			'meta_description',
			'meta_keywords',
			'meta_author',
		);
		
		// set up the controller name without the Controller_ prefix
		$controller_name = strtolower(str_replace('Controller_', '', $this->request->controller));

		// make sure the namespace is removed
		$controller_name = \Inflector::denamespace($controller_name);

		// make sure we've removed the prefixes
		$controller_name = str_replace('admin_', '', $controller_name);

		$this->_data = new \stdClass;
		$this->_js_data = new \stdClass;
		
		// grab the content for the current section
		$this->_headers		= \Model_SiteContent::get_section_content('header', $controller_name);
		$this->_messages	= \Model_SiteContent::get_section_content('message', $controller_name);
		$this->_titles		= \Model_SiteContent::get_section_content('title', $controller_name);
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

		// set the content view (if it's been set)
		if ( ! empty($this->_view))
		{
			$this->template->layout->content = \View::forge(\Location::file($this->_view, $this->skin, 'pages', $this->_module_fallback), $this->_data);
		}
		
		// set the javascript view (if it's been set)
		if ( ! empty($this->_js_view))
		{
			$this->template->javascript = \View::forge(\Location::file($this->_js_view, $this->skin, 'js', $this->_module_fallback), $this->_js_data);
		}
		
		// set the final title content
		$this->template->title.= (array_key_exists($this->request->action, $this->_titles)) 
			? $this->_titles[$this->request->action] 
			: ((property_exists($this->_data, 'title')) ? $this->_data->title : null);
		
		// set the final header content
		$this->template->layout->header = (array_key_exists($this->request->action, $this->_headers)) 
			? $this->_headers[$this->request->action]
			: ((property_exists($this->_data, 'header')) ? $this->_data->header : null);
		
		// set the final message content
		$this->template->layout->message = (array_key_exists($this->request->action, $this->_messages)) 
			? \Markdown::parse($this->_messages[$this->request->action])
			: ((property_exists($this->_data, 'message') === true) ? \Markdown::parse($this->_data->message) : null);

		if ($this->_editable === true)
		{
			// set up the controller name without the Controller_ prefix
			$controller_name = strtolower(str_replace('Controller_', '', $this->request->controller));

			// make sure the namespace is removed
			$controller_name = \Inflector::denamespace($controller_name);

			// set the final header content key
			$this->template->layout->header_key = (array_key_exists($this->request->action, $this->_headers)) 
				? $controller_name.'_'.$this->request->action.'_header' 
				: false;

			// set the final message content key
			$this->template->layout->message_key = (array_key_exists($this->request->action, $this->_messages)) 
				? $controller_name.'_'.$this->request->action.'_message' 
				: false;
		}
		
		// flash messages
		if (count($this->_flash) > 0)
		{
			foreach ($this->_flash as $flash)
			{
				$this->template->layout->flash = \View::forge(\Location::file('flash', $this->skin, 'partials', $this->_module_fallback));
				$this->template->layout->flash->status = $flash['status'];
				$this->template->layout->flash->message = $flash['message'];
			}
		}

		// set the response body
		$this->response->body = $this->template;

		// set the status
		$this->response->status = $this->_status;
		
		// return the response object
		return $this->response;
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
	}
}
