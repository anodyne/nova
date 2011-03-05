<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Setup Controller
 *
 * @package		Install
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */

class Controller_Setup extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			if ($this->request->action() != 'config')
			{
				$this->request->redirect('setup/config');
			}
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step', 'index', 'main', 'verify', 'readme', 'setupconfig');
			
			// you need to be logged in for these pages
			$protectedsegs = array('changedb', 'genre', 'remove');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::config('nova.app_db_tables');
			
			// make sure the system is installed
			if (count($db->list_tables($db->table_prefix().'%')) < $tables and ! (in_array($this->request->action(), $safesegs)))
			{
				$this->request->redirect('install/index');
			}
			
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (count($db->list_tables($db->table_prefix().'%')) == $tables)
			{
				if (in_array($this->request->action(), $protectedsegs))
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
						// no session? send them away
						$this->request->redirect('login/error/1');
					}
				}
			}
		}
		
		// set the locale
		i18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory(Location::file('install', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 				= Kohana::config('nova.app_name').' :: ';
		$this->template->javascript			= false;
		$this->template->layout				= View::factory(Location::file('install', null, 'templates'));
		$this->template->layout->label		= false;
		$this->template->layout->flash		= false;
		$this->template->layout->controls	= false;
		$this->template->layout->content	= false;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('setup_index'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		$data->header = ___('setup.index.title');
		
		// do some checks to see what we should show
		$data->installed = Utility::install_status();
		$data->sms = (count(Database::instance()->list_tables('sms_%')) == 0) ? false : true;
		$data->update = $this->_update_check();
		
		// content
		$this->template->title.= ___('setup.index.title');
		$this->template->layout->label = ___('setup.index.title');
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_config($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a session instance
		$session = Session::instance();
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('setup_config'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('setup_config_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pass the step over to the view file
		$data->step = $step;
		
		if ( ! file_exists(MODPATH.'assets/database/db.mysql'.EXT))
		{
			$data->message = ___('setup.config.text.noconfig', array(':modules' => MODFOLDER, ':ext' => EXT));
		}
		else
		{
			if (file_exists(APPPATH.'config/database'.EXT))
			{
				$data->message = ___('setup.config.text.exists', array(':appfolder' => APPFOLDER));
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.2.4', '<'))
				{
					$data->message = ___('setup.config.text.php', array(':php' => PHP_VERSION));
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data->message = ___('setup.config.text.step0', array(':modules' => MODFOLDER, ':appfolder' => APPFOLDER));
							
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
							);
							
							if (extension_loaded('mysql'))
							{
								$this->template->layout->controls = form::open('setup/config/1').
									form::button('next', ucwords(___(':next step', array(':next' => ___('next')))), $next).
									form::close();
							}
							else
							{
								$this->template->layout->flash = View::factory('install/pages/flash');
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
							$this->template->layout->controls = form::button('next', ucwords(___(':next step', array(':next' => ___('next')))), $next).
								form::close();
							
						break;
						
						case 2:
							// set the variables to use
							$dbName		= trim(Security::xss_clean($_POST['dbName']));
							$dbUser		= trim(Security::xss_clean($_POST['dbUser']));
							$dbPass		= trim(Security::xss_clean($_POST['dbPass']));
							$dbHost		= trim(Security::xss_clean($_POST['dbHost']));
							$prefix		= trim(Security::xss_clean($_POST['prefix']));
							$type		= trim(Security::xss_clean($_POST['installType']));
							
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
								$tables = $db->list_tables($prefix.'%');
								
								if ($type == 'nova1' and count($tables) > 0)
								{
									// write the message
									$data->message = ___('setup.config.text.nova1failure');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('setup/config/1').
										form::button('next', ucwords(___('start over')), $next).
										form::close();
								}
								else
								{
									// write the message
									$data->message = ___('setup.config.text.step2.success');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('setup/config/3').
										form::button('next', ucwords(___(':next step', array(':next' => ___('next')))), $next).
										form::close();
								}
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
								$this->template->layout->controls = form::open('setup/config/1').
									form::button('next', ucwords(___('start over')), $next).
									form::close();
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
							$file = file(MODPATH.'assets/database/db.mysql'.EXT);
							
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
								$handle = fopen(APPPATH.'config/database'.EXT, 'w');
								
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
									chmod(APPPATH.'config/database'.EXT, 0666);
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
									$this->template->layout->controls = form::open('install/index').
										form::button('next', ucwords(___('install center')), $next).
										form::close();
								}
								else
								{
									$data->code = $code;
								
									$data->message = ___('setup.config.text.step3nowrite', array(':ext' => EXT, ':appfolder' => APPFOLDER));
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('setup/config/4').
										form::button('next', ___('Re-Test'), $next).
										form::close();
								}
							}
							else
							{
								$data->code = $code;
								
								$data->message = ___('setup.config.text.step3nowrite', array(':ext' => EXT, ':appfolder' => APPFOLDER));
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('setup/config/4').
									form::button('next', ___('Re-Test'), $next).
									form::close();
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
								$this->template->layout->controls = form::open('install/index').
									form::button('next', ucwords(___('install center')), $next).
									form::close();
								
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
								$this->template->layout->controls = form::open('setup/config/1').
									form::button('next', ucwords(___('start over')), $next).
									form::close();
							}
							
						break;
					}
				}
			}
		}
		
		// content
		$this->template->title.= ___('setup.config.title');
		$this->template->layout->label = ___('setup.config.title');
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_readme()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_readme'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= ___('Nova Readme');
		$this->template->layout->label = ___('Nova Readme');
		
		// build the next step button
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'install',
		);
		
		// build the next step control
		$this->template->layout->controls = form::open('install/index').form::button('install', ___('Back to Install Center'), $next).form::close();
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_verify()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_verify'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_verify_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// the verification table
		$data->verify = Utility::verify_server();
		
		if ($data->verify === false or ! isset($data->verify['failure']))
		{
			// build the next step button
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/step').form::button('install', __('Start Install'), $next).form::close();
		}
		
		// content
		$this->template->title.= __('Verify Server Requirements');
		$this->template->layout->label = __('Verify Server Requirements');
		
		// send the response
		$this->response->body($this->template);
	}
	
	/**
	 * Do the check for updates to the system. There are 4 different types of
	 * updates that can be found.
	 *
	 *     1 - major update (2.0 => 3.0)
	 *     2 - minor update (3.0 => 3.1)
	 *     3 - incremental update (3.0.1 => 3.0.2)
	 *     4 - pre-release update
	 */
	protected function _update_check()
	{
		if (ini_get('allow_url_fopen'))
		{
			// get the list of classes that have been loaded
			$classes = get_declared_classes();
			
			// if sfYaml hasn't been loaded, then load it
			if ( ! in_array('sfYaml', $classes))
			{
				// find the sfYAML library
				$path = Kohana::find_file('vendor', 'sfYaml/sfYaml');
				
				// load the sfYAML library
				Kohana::load($path);
			}
			
			// load the YAML data into an array
			$content = sfYaml::load(Kohana::config('nova.version_info'));
			
			// get the system information
			$system = Jelly::query('system', 1)->select();
			
			// get the info config data
			$conf = Kohana::config('nova');
			
			// create a new class
			$version = new stdClass;
			
			// create the files object
			$version->files = new stdClass;
			$version->files->full = $conf->app_version_major.'.'.$conf->app_version_minor.'.'.$conf->app_version_update;
			$version->files->major = $conf->app_version_major;
			$version->files->minor = $conf->app_version_minor;
			$version->files->update = $conf->app_version_update;
			
			// create the database object
			$version->db = new stdClass;
			$version->db->full = $system->version_major.'.'.$system->version_minor.'.'.$system->version_update;
			$version->db->major = $system->version_major;
			$version->db->minor = $system->version_minor;
			$version->db->update = $system->version_update;
			
			// the update and flash objects
			$update = new stdClass;
			$flash = new stdClass;
			
			if (version_compare($version->files->full, $content['version'], '<') or version_compare($version->db->full, $content['version'], '<'))
			{
				$update->version	= $content['version'];
				$update->notes		= $content['notes'];
				$update->severity	= $content['severity'];
				$update->link 		= $content['link'];
			}
			
			if (version_compare($version->db->full, $version->files->full, '>'))
			{
				$flash->status = 'info';
				$flash->message = ___('check.files_outofdate', array(':files' => $version->files->full, ':db' => $version->db->full));
			}
			elseif (version_compare($version->db->full, $version->files->full, '<'))
			{
				$flash->status = 'info';
				$flash->message = ___('check.db_outofdate', array(':files' => $version->files->full, ':db' => $version->db->full));
			}
			elseif (property_exists($update, 'version'))
			{
				$yourversion = ___('check.your_version', array(':app' => $conf->app_name, ':version' => $version->files->full));
				$flash->status = 'info';
				$flash->message = ___('check.update_available', array(':app' => $conf->app_name, ':version' => $content['version'], ':extra' => $yourversion));
			}
			else
			{
				$flash->status = 'success';
				$flash->message = ___('check.no_updates', array(':app' => $conf->app_name));
			}
			
			$retval = array(
				'flash' => $flash,
				'update' => $update
			);
			
			return $retval;
		}
		
		return false;
	}
}
