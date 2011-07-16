<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Base Controller
 *
 * The base controller is used by every single controller in the system and
 * finalizes setting the system up prior to controller action execution. In
 * addition, the base controller ensures that some classes and variables are
 * always available in the controllers.
 *
 * @package		Nova
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

abstract class Controller_Nova_Base extends Controller_Template {
	
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
	 * @var	bool	Whether we're in daylight savings time.
	 */
	public $dst;
	
	/**
	 * @var	array	An array of setting keys used to make the final pull from the database.
	 */
	protected $settingsArray;
	
	/**
	 * @var	object	Controller action data.
	 */
	protected $_data;
	
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
	 * The before method handles setting up the controller before any action
	 * methods are called.
	 *
	 * @access	public
	 * @return	void
	 */
	public function before()
	{
		parent::before();
		
		// if the config file isn't set
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			$this->request->redirect('setup/main/config');
		}
		
		// make sure the system is installed
		if ( ! Utility::install_status())
		{
			$this->request->redirect('setup/main/index');
		}
		
		// load the session library
		$this->session = Session::instance();
		
		// set the locale
		I18n::lang($this->session->get('language', 'en-us'));
		
		// set the cache driver
		Cache::$default = Kohana::$config->load('cache.driver');
		
		// these are the settings we pull for every controller
		$this->settingsArray = array(
			'display_rank',
			'timezone',
			'daylight_savings',
			'date_format',
			'sim_name',
			'system_email'
		);
		
		// make the data variable an object
		$this->_data = new stdClass;
	}
	
	/**
	 * The after method handles the final steps before rendering the output to
	 * the browser, including populating the template variable with all of the
	 * information it needs from the controller action.
	 *
	 * @access	public
	 * @return	void
	 */
	public function after()
	{
		parent::after();
		
		// set the content 
		$this->template->layout->content = $this->_data;
		
		// set the final template data
		$this->template->title.= $this->_data->title;
		$this->template->layout->header = $this->_data->header;
		$this->template->layout->message = $this->_data->message;
		
		// send the response
		$this->response->body($this->template);
	}
}
