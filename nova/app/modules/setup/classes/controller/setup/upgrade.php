<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Upgrade Controller
 *
 * @package		Setup
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

class Controller_Setup_Upgrade extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			$this->request->redirect('setup/main/config');
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::$config->load('nova.app_db_tables');
			
			// we're upgrading from sms, so make sure the system isn't installed
			if ($this->request->action() != 'step' and (count($db->list_tables($db->table_prefix().'%')) == $tables))
			{
				$this->request->redirect('setup/main/index');
			}
		}
		
		// set the locale
		I18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory(Location::file('setup', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 					= Kohana::$config->load('nova.app_name').' :: ';
		$this->template->javascript				= false;
		$this->template->layout					= View::factory(Location::file('setup', null, 'templates'));
		$this->template->layout->label			= false;
		$this->template->layout->flash			= false;
		$this->template->layout->controls		= false;
		$this->template->layout->steps			= View::factory(Location::file('setup_upgrade', null, 'partials'));
	}
	
	public function after()
	{
		parent::after();
		
		// send the response
		$this->response->body($this->template);
	}
	
	/**
	 * 1 - change the table prefix from whatever it is to nova2_
	 * 2 - install nova 3
	 * 3 - move the data over from nova 2
	 */
	
	public function action_step()
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// get an instance of the database
		$db = Database::instance();
		
		// get an instance of the session
		$session = Session::instance();
		
		// is installation allowed?
		$allowed = true;
		
		if (Kohana::$config->load('nova.genre') == '')
		{
			// installation not allowed
			$allowed = false;
			
			// show the flash message
			$this->template->layout->flash = View::factory('components/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = ___('setup.error.no_genre', array(':path' => APPFOLDER.'/config/nova.php'));
		}
		
		switch ($this->request->param('id'))
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/upgrade/step0');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/upgrade/step0_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.upgrade.step0.instructions'));
				
				if ($allowed)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = Form::open('setup/upgrade/step/1').Form::button('next', 'Start Upgrade', $next).Form::close();
				}
			break;
			
			case 1:
				if (HTTP_Request::POST == $this->request->method())
				{
					// get the tables that are part of nova
					$tables = $db->list_tables($db->table_prefix().'%');
					
					if (count($tables) > 0)
					{
						foreach ($tables as $table)
						{
							// set the new table name
							$newtable = '`nova2_'.str_replace($db->table_prefix(), '', $table).'`';
							
							// build the sql statement
							$sql = "ALTER TABLE `".$table."` RENAME TO ".$newtable;
							
							// run the query
							$db->query(null, $sql);
						}
					}
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/upgrade/step1');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/upgrade/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.upgrade.step1.instructions'));
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('setup/upgrade/step/2').Form::button('next', 'Continue Upgrade', $next).Form::close();
			break;
				
			case 2:
				if (HTTP_Request::POST == $this->request->method())
				{
					// do the install
					Setup::install();
				}
				
				// get the number of tables
				$tables = $db->list_tables($db->table_prefix().'%');
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/upgrade/step2');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/upgrade/step2_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::$config->load('nova.app_db_tables'))
					? false 
					: Form::button('next', 'Upgrade', $next).Form::close();
			break;
				
			case 3:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/upgrade/step3');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/upgrade/step3_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::button('next', 'Run', $next).Form::close();
			break;
				
			case 4:
				if (HTTP_Request::POST == $this->request->method())
				{
					// do the registration
					Setup::register('upgrade');
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/upgrade/step4');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
					'attr' => array(
						'class' => 'image'),
				);
			break;
		}
		
		$this->template->title.= 'Upgrade to Nova 3';
		$this->template->layout->label = 'Upgrade to Nova 3';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
	}
}
