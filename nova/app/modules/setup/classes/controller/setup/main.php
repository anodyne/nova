<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Main setup controller
 *
 * @package		Setup
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
# TODO: need to remove the Kohana::$environment check around the login redirect

class Controller_Setup_Main extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database.php'))
		{
			if ($this->request->action() != 'config')
			{
				$this->request->redirect('setup/main/config');
			}
		}
		else
		{
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::config('nova.app_db_tables');
			
			# FIXME: hmm ... i'm pretty sure this would fail in the event that nova 1 or 2 are installed
			
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (count($db->list_tables($db->table_prefix().'%')) == $tables)
			{
				// get an instance of the session
				$session = Session::instance();
				
				// make sure there's a session
				if ($session->get('userid'))
				{
					// are they a sysadmin?
					$sysadmin = Auth::is_type('sysadmin', $session->get('userid'));
					
					// if they aren't, send them away
					if ($sysadmin === false)
					{
						$this->request->redirect('login/error/1');
					}
				}
				else
				{
					if (Kohana::$environment !== Kohana::DEVELOPMENT)
					{
						// no session? send them away
						$this->request->redirect('login/error/1');
					}
				}
			}
		}
		
		// set the locale
		I18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory(Location::file('setup', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 				= Kohana::config('nova.app_name').' :: ';
		$this->template->javascript			= false;
		$this->template->layout				= View::factory(Location::file('setup', null, 'templates'));
		$this->template->layout->label		= false;
		$this->template->layout->flash		= false;
		$this->template->layout->controls	= false;
		$this->template->layout->content	= false;
	}
	
	public function after()
	{
		parent::after();
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/setup/main_index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// do some checks to see what we should show
		$installed = Utility::install_status();
		$update = ($installed) ? $this->_check_for_updates() : false;
		
		if ($installed)
		{
			/**
			 * This might be cheating, but if Nova throws an exception when trying
			 * to load the first record of the system_info table, it means that
			 * we're dealing with a Nova 2 installation and need to offer up the
			 * upgrade option. If there's no exception, then we're dealing with
			 * Nova 3.
			 */
			try {
				$system = Model_System::find('first');
				
				if ($update)
				{
					/**
					 * Nova is installed and an update is available.
					 */
					$data->option = 7;
				}
				else
				{
					/**
					 * Nova is installed and there are no updates available. Show the
					 * admin the list of utilities they can use.
					 */
					$data->option = 8;
				}
			} catch (Exception $e) {
				// get the table prefix
				$prefix = Database::instance()->table_prefix();
				
				// get the information from the database
				$version = DB::query(Database::SELECT, "SELECT * FROM ${prefix}system_info WHERE sys_id = 1")
					->as_object()
					->execute()
					->current()
					->sys_version_major;
					
				/**
				 * 1 if by land, 2 if by sea. I mean, 2 if we're coming from
				 * 2.x and 3 if we're coming from 1.x. If we're coming from 1.x,
				 * it HAS to be at least 1.2.4.
				 */
				$data->option = ($version == 2) ? 2 : 3;
				
				if ($version == 2)
				{
					$data->option = 2;
				}
				elseif ($version == 3)
				{
					// full nova 1 version
					$fullversion = $version->sys_version_major.'.'.$version->sys_version_minor.'.'.$version->sys_version_update;
					
					// assume we're running at least 1.2.4
					$data->option = 3;
					
					// unless we aren't running 1.2.4, then they'll need to do that update first
					if (version_compare($fullversion, '1.2.4', '<'))
					{
						$data->option = 4;
					}
				}
			}
		}
		else
		{
			// find out if there are any SMS tables in the database
			$sms = DB::query(Database::SELECT, "SHOW TABLES like 'sms_%'")->execute()->count();
			
			if ($sms > 0)
			{
				// now that we know SMS is here, find out the version
				$smsversion = DB::query(Database::SELECT, "SELECT * FROM sms_system WHERE sysid = 1")
					->as_object()
					->execute()
					->current()
					->sysVersion;
				
				// if we don't have 2.6.9 or higher, we can't do the upgrade
				$data->option = (version_compare($smsversion, '2.6.9', '<')) ? 6 : 5;
			}
			else
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$data->option = 1;
			}
		}
		
		// content
		$this->template->title.= 'Nova Setup';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Nova Setup';
	}
	
	public function action_config($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a session instance
		$session = Session::instance();
		
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/setup/main_config');
		
		// create a new js view
		$this->template->javascript = View::factory('components/js/setup/main_config_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pass the step over to the view file
		$data->step = $step;
		
		if ( ! file_exists(MODPATH.'app/modules/setup/assets/db.mysql.php'))
		{
			$data->message = ___('setup.config.text.noconfig', array(':modules' => MODFOLDER.'/modules', ':ext' => '.php'));
		}
		else
		{
			if (file_exists(APPPATH.'config/database.php'))
			{
				$data->message = ___('setup.config.text.exists', array(':appfolder' => APPFOLDER));
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.3.0', '<'))
				{
					$data->message = ___('setup.config.text.php', array(':php' => PHP_VERSION));
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data->message = ___('setup.config.text.step0', array(':modules' => MODFOLDER.'/modules', ':appfolder' => APPFOLDER));
							
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
							);
							
							if (extension_loaded('mysql'))
							{
								$this->template->layout->controls = Form::open('setup/main/config/1').
									Form::button('next', 'Next Step', $next).
									Form::close();
							}
							else
							{
								$this->template->layout->flash = View::factory('components/pages/flash');
								$this->template->layout->flash->status = 'error';
								$this->template->layout->flash->message = ___('setup.config.text.nodb');
							}
						break;
						
						case 1:
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
							);
							
							// set the message
							$data->message = ___('setup.config.text.connection');

							// build the next step control
							$this->template->layout->controls = Form::button('next', 'Next Step', $next).Form::close();
						break;
						
						case 2:
							// set the variables to use
							$dbName		= trim(Security::xss_clean($_POST['dbName']));
							$dbUser		= trim(Security::xss_clean($_POST['dbUser']));
							$dbPass		= trim(Security::xss_clean($_POST['dbPass']));
							$dbHost		= trim(Security::xss_clean($_POST['dbHost']));
							$prefix		= trim(Security::xss_clean($_POST['prefix']));
							
							// set the session variables
							$session->set('dbName', $dbName);
							$session->set('dbUser', $dbUser);
							$session->set('dbPass', $dbPass);
							$session->set('dbHost', $dbHost);
							$session->set('prefix', $prefix);
							
							$dbconfig = array(
								'type' => "mysql",
								'table_prefix' => "".$session->get('prefix')."",
								'connection' => array(
									'hostname' => "".$session->get('dbHost')."",
									'username' => "".$session->get('dbUser')."",
									'password' => "".$session->get('dbPass')."",
									'database' => "".$session->get('dbName')."",
								),
							);
							
							// get an instance of the database
							$db = Database::instance('custom', $dbconfig);
							
							try {
								// try to list the tables
								$db->list_tables($prefix.'%');
								
								// write the message
								$data->message = ___('setup.config.text.step2.success');
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = Form::open('setup/main/config/3').
									Form::button('next', 'Next Step', $next).
									Form::close();
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$data->message = ___('setup.config.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data->message = ___('setup.config.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data->message = ___('setup.config.text.step2.dbname', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = ___('setup.config.text.step2.gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = Form::open('setup/main/config/1').
									Form::button('next', 'Start Over', $next).
									Form::close();
							}
						break;
							
						case 3:
							// grab the disabled functions
							$disabled = explode(',', ini_get('disable_functions'));
							
							// make sure everything is trimmed properly
							foreach ($disabled as $key => $value)
							{
								$disabled[$key] = trim($value);
							}
							
							// what we need
							$need = array('fopen', 'fwrite', 'file');
							
							// check to make sure we have what we need
							$check = array_intersect($disabled, $need);
							
							// pull in the mysql file
							$file = file(MODPATH.'app/modules/setup/assets/db.mysql.php');
							
							if (is_array($file))
							{
								foreach ($file as $line_num => $line)
								{
									switch (substr($line, 0, 9))
									{
										case "'database":
											$file[$line_num] = str_replace("nova", $session->get('dbName'), $line);
										break;
										
										case "'username":
											$file[$line_num] = str_replace("false", "'".$session->get('dbUser')."'", $line);
										break;
										
										case "'password":
											$file[$line_num] = str_replace("false", "'".$session->get('dbPass')."'", $line);
										break;
										
										case "'hostname":
											$file[$line_num] = str_replace("localhost", $session->get('dbHost'), $line);
										break;
										
										case "'table_pr":
											$file[$line_num] = str_replace("''", "'".$session->get('prefix')."'", $line);
										break;
									}
								}
								
								$code = false;
								
								foreach ($file as $value)
								{
									$code.= htmlentities($value);
								}
							}
							else
							{
								$code = htmlentities("<?php defined('SYSPATH') or die('No direct access allowed.');

return array
(
'default' => array(
'type' => 'mysql',

'connection' => array(
'hostname' => '".$session->get('dbHost')."',
'username' => '".$session->get('dbUser')."',
'password' => '".$session->get('dbPass')."',
'persistent' => false,
'database' => '".$session->get('dbName')."',
),

'table_prefix' => '".$session->get('prefix')."',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => false,
'profiling' => true,
),
);");
							}
							
							if (count($check) == 0)
							{
								// make sure the config directory has the proper permissions
								chmod(APPPATH.'config', 0777);
								
								// open the file
								$handle = fopen(APPPATH.'config/database.php', 'w');
								
								// figure out if the write was successful
								$write = false;
							
								// write the file line by line
								foreach ($file as $line)
								{
									$write = fwrite($handle, $line);
								}
								
								// close the file
								fclose($handle);
								
								try {
									// try to chmod the file to the proper permissions
									chmod(APPPATH.'config/database.php', 0666);
								} catch (Exception $e) {
									// get an instance of the log class
									$log = Kohana_Log::instance();
									
									// add the message
									$log->add('error', 'Could not change file permissions of the database configuration file to 0666. Please do so manually.');
									
									// write the message to the log file
									$log->write();
								}
								
								if ($write !== false)
								{
									// set the success message
									$data->message = ___('setup.config.text.step3write');
									
									// wipe out the session
									$session->destroy();
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = Form::open('setup/main/index').
										Form::button('next', 'Setup Center', $next).
										Form::close();
								}
								else
								{
									$data->code = $code;
								
									$data->message = ___('setup.config.text.step3nowrite', array(':ext' => '.php', ':appfolder' => APPFOLDER));
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = Form::open('setup/main/config/4').
										Form::button('next', 'Re-Test', $next).
										Form::close();
								}
							}
							else
							{
								$data->code = $code;
								
								$data->message = ___('setup.config.text.step3nowrite', array(':ext' => '.php', ':appfolder' => APPFOLDER));
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = Form::open('setup/main/config/4').
									Form::button('next', 'Re-Test', $next).
									Form::close();
							}
						break;
							
						case 4:
							// get an instance of the database
							$db = Database::instance();
							
							try {
								$tables = $db->list_tables();
								
								// write the message
								$data->message = ___('setup.text.step4success');
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = Form::open('setup/main/index').
									Form::button('next', 'Setup Center', $next).
									Form::close();
								
								// clear the session
								$session->destroy();
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$data->message = ___('setup.config.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data->message = ___('setup.config.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data->message = ___('setup.config.text.step2.dbname', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = ___('setup.config.text.step2.gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = Form::open('setup/main/config/1').
									Form::button('next', 'Start Over', $next).
									Form::close();
							}
							
						break;
					}
				}
			}
		}
		
		// content
		$this->template->title.= 'Config File Setup';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/pencil-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Config File Setup';
	}
	
	public function action_readme()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/setup/main_readme');
		
		// create a new js view
		$this->template->javascript = View::factory('components/js/setup/main_readme_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// build the next step button
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'install',
		);
		
		// build the next step control
		$this->template->layout->controls = Form::open('setup/main/index').Form::button('install', 'Back to Setup', $next).Form::close();
		
		// content
		$this->template->title.= 'Nova Readme';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/information-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Nova Readme';
	}
	
	public function action_verify()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/setup/main_verify');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// the verification table
		$data->verify = Verify::server();
		
		if ($data->verify === false or ! isset($data->verify['failure']))
		{
			// build the next step button
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = Form::open('setup/main/index').Form::button('install', 'Back to Setup', $next).Form::close();
		}
		
		// content
		$this->template->title.= 'Verify Server Requirements';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Verify Server Requirements';
	}
	
	protected function _check_for_updates()
	{
		if (ini_get('allow_url_fopen'))
		{
			// get the list of classes that have been loaded
			$classes = get_declared_classes();
			
			// if sfYaml hasn't been loaded, then load it
			if ( ! in_array('Spyc', $classes))
			{
				// find the sfYAML library
				$path = Kohana::find_file('vendor', 'spyc/spyc');
				
				// load the sfYAML library
				Kohana::load($path);
			}
			
			// load the YAML data into an array
			$content = Spyc::YAMLLoad(Kohana::config('nova.version_info'));
			
			try {
				// get the system information
				$system = Model_System::find('first');
				
				return $system->version_major;
			} catch (Exception $e) {
				// get the prefix
				$prefix = Database::instance()->table_prefix();
				
				// query the database for the version info
				$system = DB::query(Database::SELECT, "SELECT * FROM ${prefix}system_info WHERE sys_id = 1")
					->as_object()
					->execute()
					->current();
				
				return $system->sys_version_major;
			}
		}
		
		return false;
	}
}
