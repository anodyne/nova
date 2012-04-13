<?php
/**
 * Nova's base setup controller.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

abstract class Controller_Base_Setup extends \Controller_Template
{
	public $template;
	
	/**
	 * @var	object	Controller action data.
	 */
	protected $_data;
	
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
	 * The before method handles setting up the controller before any action
	 * methods are called.
	 *
	 * @internal
	 * @return	void
	 */
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/'.\Fuel::$env.'/db.php'))
		{
			if ($this->request->action != 'config')
			{
				$this->response->redirect('setup/main/config');
			}
		}
		else
		{
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (\Utility::installed() === true)
			{
				if (\Sentry::check() === true)
				{
					// if they aren't a system admin, send them away
					if ( ! \Sentry::user()->is_admin())
					{
						$this->response->redirect('login/index/'.\Login\Controller_Login::NOT_ADMIN);
					}
				}
				else
				{
					if ($this->request->controller == 'Controller_Utility' or $this->request->controller == 'Controller_Main')
					{
						// no session? send them away
						$this->response->redirect('login/index/'.\Login\Controller_Login::NOT_LOGGED_IN);
					}
				}
			}
		}
		
		// load the language file
		\Lang::load('setup', 'setup');
		
		// manually add the nova module to the paths
		\Finder::instance()->add_path(\Fuel::add_module('nova'));
		
		// go out and load then merge the nova config files
		\Config::load('nova', true, false, true);
		
		// make sure _data is a class
		$this->_data = new \stdClass;
		
		// set the structure file
		$this->template = \View::forge('setup::components/structure/setup');
		
		// set the variables in the template
		$this->template->title 				= 'Nova :: ';
		$this->template->javascript			= false;
		$this->template->layout				= \View::forge('setup::components/templates/setup');
		$this->template->layout->flash		= false;
		$this->template->layout->content	= false;
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
		
		// set the content view
		$this->template->layout->content = \View::forge('setup::components/pages/'.$this->_view, $this->_data);
		
		// set the javascript view (if it's been set)
		if ( ! empty($this->_js_view))
		{
			$this->template->javascript = \View::forge('setup::components/js/'.$this->_js_view, $this->_js_data);
		}
		
		// content
		$this->template->title.= $this->_data->title;
		$this->template->layout->image = \Html::img(\Uri::base(false).'nova/modules/setup/views/design/images/'.$this->_data->header->image, array('id' => 'title-image'));
		$this->template->layout->label = $this->_data->header->text;
		$this->template->layout->controls = $this->_data->controls;

		// flash messages
		if (count($this->_flash) > 0)
		{
			foreach ($this->_flash as $flash)
			{
				$this->template->layout->flash = \View::forge('setup::components/partials/flash');
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
}
