<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Upgrade Controller
 *
 * @package		Upgrade
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
		$this->template->layout->steps			= View::factory(Location::file('setup_nova1', null, 'partials'));
	}
	
	/**
	 * 1 - change the table prefix from whatever it is to nova1_
	 * 2 - install nova 3
	 * 3 - move the data over from nova 1 similar to how we do in the sms upgrade
	 */
	
	public function action_step()
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
				$this->template->layout->content = View::factory('components/pages/nova1/step0');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/nova1/step0_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.nova1.step0.instructions'));
				
				// content
				$this->template->title.= 'Upgrading to Nova 3';
				$this->template->layout->label = 'Upgrading to Nova 3';
				
				if ($allowed === true)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = Form::open('setup/nova1/step/1').Form::button('next', 'Start Upgrade', $next).Form::close();
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
							$newtable = '`nova1_'.str_replace($db->table_prefix(), '', $table).'`';
							
							// build the sql statement
							$sql = "ALTER TABLE `".$table."` RENAME TO ".$newtable;
							
							// run the query
							$db->query(null, $sql);
						}
					}
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/nova1/step1');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/nova1/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('setup.nova1.step1.instructions'));
				
				// content
				$this->template->title.= 'Upgrading to Nova 3';
				$this->template->layout->label = 'Upgrading to Nova 3';
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('setup/nova1/step/2').Form::button('next', 'Continue Upgrade', $next).Form::close();
			break;
				
			case 2:
				if (HTTP_Request::POST == $this->request->method())
				{
					// update the character set
					$dbconfig = Kohana::$config->load('database');
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
					include_once MODPATH.'app/modules/setup/assets/install/genres/'.strtolower(Kohana::$config->load('nova.genre')).'.php';
					
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
					
					if (Kohana::$config->load('install.dev'))
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
				$this->template->layout->content = View::factory('components/pages/nova1/step2');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/nova1/step2_js');
				
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
				$this->template->layout->controls = (count($tables) < Kohana::$config->load('nova.app_db_tables'))
					? false 
					: Form::button('next', 'Upgrade', $next).Form::close();
			break;
				
			case 3:
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('upgrade_step2'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// content
				$this->template->title.= 'Cleaning Up Data';
				$this->template->layout->label = 'Cleaning Up Data';
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('upgrade_step2_js', null, 'js'));
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/upgrade/views/design/images/loading-circle-large.gif',
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
				if (isset($_POST['submit']))
				{
					// do the registration
					$this->_register();
				}
				
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('upgrade_step3'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// an empty array for user info
				$data->options = array();
				
				// get all active users
				$all = Jelly::query('user')->where('status', '=', 'active')->select();
				
				foreach ($all as $a)
				{
					$data->options[$a->id] = $a->name.' ('.$a->email.')';
				}
				
				// content
				$this->template->title.= __('Passwords and Admin Rights');
				$this->template->layout->label = __('Passwords and Admin Rights');
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('upgrade_step3_js', null, 'js'));
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/upgrade/views/design/images/loading-circle-large.gif',
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
				$this->template->layout->controls = form::button('next', __('Finalize'), $next).form::close();
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
				Kohana::$config->load('novasys.app_name'),
				Kohana::$config->load('novasys.app_version_full'),
				url::site(),
				$_SERVER['REMOTE_ADDR'],
				$_SERVER['SERVER_ADDR'],
				phpversion(),
				'upgrade',
				Kohana::$config->load('nova.genre'),
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
