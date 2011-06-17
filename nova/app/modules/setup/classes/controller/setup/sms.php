<?php defined('SYSPATH') or die('No direct script access.');
/**
 * SMS Upgrade Controller
 *
 * @package		Upgrade
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		3.0
 */

class Controller_Setup_Sms extends Controller_Template {
	
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
			$tables = Kohana::config('nova.app_db_tables');
			
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
		$this->template->title 					= Kohana::config('nova.app_name').' :: ';
		$this->template->javascript				= false;
		$this->template->layout					= View::factory(Location::file('setup', null, 'templates'));
		$this->template->layout->label			= false;
		$this->template->layout->flash			= false;
		$this->template->layout->controls		= false;
	}
	
	public function action_step($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// get an instance of the database
		$db = Database::instance();
		
		// get an instance of the session
		$session = Session::instance();
		
		// figure out if the system is installed
		$tables = $db->list_tables();
		
		// is installation allowed?
		$allowed = true;
		
		if (Kohana::config('nova.genre') == '')
		{
			// installation not allowed
			$allowed = false;
			
			// show the flash message
			$this->template->layout->flash = View::factory('components/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = ___('setup.error.no_genre', array(':path' => APPFOLDER.'/config/nova.php'));
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/sms/step0');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/sms/step0_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.sms.step0.instructions'));
				
				// content
				$this->template->title.= 'Upgrade to Nova 3';
				$this->template->layout->label = 'Getting Started';
				
				if ($allowed === true)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = Form::open('setup/sms/step/1').Form::button('next', 'Start Upgrade', $next).Form::close();
				}
			break;
				
			case 1:
				if (HTTP_Request::POST == $this->request->method())
				{
					// update the character set
					$dbconfig = Kohana::config('database');
					$db->set_charset($dbconfig['default']['charset']);
					
					// pull in the field information
					include_once MODPATH.'app/modules/setup/assets/install/fields.php';
					
					foreach ($data as $key => $value)
					{
						$fieldID = (isset($value['id'])) ? $value['id'] : 'id';
						$fieldName = (isset($value['fields'])) ? $value['fields'] : 'fields_'.$key;
						
						DBForge::add_field($$fieldName);
						DBForge::add_key($fieldID, true);
						
						if (isset($value['index']))
						{
							foreach ($value['index'] as $index)
							{
								DBForge::add_key($index);
							}
						}
						
						DBForge::create_table($key, true);
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from inserting the tables
					$data = null;
					
					// pull in the basic data
					include_once MODPATH.'app/modules/setup/assets/install/data.php';
					
					$insert = array();
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$sql = DB::insert($value)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$insert[$value] = $db->query(Database::INSERT, $sql, true);
						}
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from insert the data
					$data = null;
					
					// pull in the genre data
					include_once MODPATH.'app/modules/setup/assets/install/genres/'.strtolower(Kohana::config('nova.genre')).'.php';
					
					$genre = array();
					
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$sql = DB::insert($key_d)
								->columns(array_keys($v))
								->values(array_values($v))
								->compile($db);
								
							$genre[$key_d] = $db->query(Database::INSERT, $sql, true);
						}
					}
					
					if (Kohana::config('install.dev'))
					{
						// pause the script for a second
						sleep(1);
						
						// wipe out the data from insert the data
						$data = null;
						
						// pull in the development test data
						include_once MODPATH.'app/modules/setup/assets/install/dev.php';
						
						$insert = array();
						
						foreach ($data as $value)
						{
							foreach ($$value as $k => $v)
							{
								$sql = DB::insert($value)
									->columns(array_keys($v))
									->values(array_values($v))
									->compile($db);
									
								$insert[$value] = $db->query(Database::INSERT, $sql, true);
							}
						}
					}
					
					// do the quick installs
					Utility::install_rank();
					Utility::install_skin();
					Utility::install_widget();
				}
				
				// get the number of tables
				$tables = $db->list_tables($db->table_prefix().'%');
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/sms/step1');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/sms/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/app/modules/setup/views/design/images/loading.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// content
				$this->template->title.= 'Upgrading to Nova 3';
				$this->template->layout->label = 'Upgrading to Nova 3';
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::config('nova.app_db_tables'))
					? false 
					: Form::button('next', 'Upgrade', $next).Form::close();
			break;
				
			case 2:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/sms/step2');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/sms/step2_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// content
				$this->template->title.= 'Cleaning Up Data';
				$this->template->layout->label = 'Cleaning Up Data';
				
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
				
			case 3:
				if (HTTP_Request::POST == $this->request->method())
				{
					// do the registration
					$this->_register();
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/sms/step3');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/sms/step3_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// an empty array for user info
				$data->options = array();
				
				// get all active users
				$all = Model_User::find('all', array('related' => array('characters')));
				
				foreach ($all as $a)
				{
					if ($a->get_status() == 'active')
					{
						$data->options[$a->id] = $a->name.' ('.$a->email.')';
					}
				}
				
				// content
				$this->template->title.= 'Passwords and Admin Rights';
				$this->template->layout->label = 'Passwords and Admin Rights';
				
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
				$this->template->layout->controls = Form::button('next', 'Finalize', $next).Form::close();
			break;
		}
		
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
		
		// send the response
		$this->request->response = $this->template;
	}
	
	private function _register()
	{
		if ($path = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required'))
		{
			// load the file
			Kohana::load($path);
			
			// get an instance of the database
			$db = Database::instance();
			
			// build the data we need
			$request = array(
				Kohana::config('nova.app_name'),
				Kohana::config('nova.app_version_full'),
				url::site(),
				$_SERVER['REMOTE_ADDR'],
				$_SERVER['SERVER_ADDR'],
				phpversion(),
				'upgrade',
				Kohana::config('nova.genre'),
			);
			
			$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, type, date, genre) VALUES (%s, %s, %s, %s, %s, %s, %s, %d, %s);";
			
			$data['message'] = sprintf(
				$insert,
				$db->escape($request[0]),
				$db->escape($request[1]),
				$db->escape($request[2]),
				$db->escape($request[3]),
				$db->escape($request[4]),
				$db->escape($request[5]),
				$db->escape($request[6]),
				$db->escape($request[7]),
				$db->escape(date::now())
			);
			
			// send the email
			//$email = email::install_register($data);
		}
	}
}
