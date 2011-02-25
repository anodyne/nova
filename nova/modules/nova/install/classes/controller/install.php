<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Install Controller
 *
 * @package		Install
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		3.0
 */

class Controller_Install extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			if ($this->request->action() != 'setupconfig')
			{
				$this->request->redirect('install/setupconfig');
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
		$this->template->layout->content = View::factory(Location::view('install_index'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		// content
		$this->template->title.= ucwords(___('install center'));
		$this->template->layout->label = ucwords(___('install center'));
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_changedb($view = 'main')
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_changedb'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_changedb_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// build the images
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/nova/install/views/design/images/loading-circle-large.gif',
				'attr' => array(
					'alt' => ___('processing'),
					'class' => '')),
		);
		
		// show the back button?
		$showbutton = false;
		
		switch ($view)
		{
			case 'table':
				// set the header
				$data->header = ___('change.title.addtable');
				
				// set the message
				$data->message = ___("change.text.addtable");
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'table',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(__(':create table', array(':create' => ___('create')))), $next);
			break;
				
			case 'field':
				// set the header
				$data->header = ___('change.title.addfield');
				
				// set the message
				$data->message = ___('change.text.addfield');
				
				// set up the options
				$data->options = array();
				
				// get the tables
				$tables = Database::instance()->list_tables();
				
				// set the tables select menu options
				foreach ($tables as $t)
				{
					// get the database prefix
					$prefix = Database::instance()->table_prefix();
					
					// set the key without the prefix
					$key = str_replace($prefix, '', $t);
					
					$data->options[$key] = $t;
				}
				
				// set the field type options
				$data->fieldtypes = array(
					'Strings & Text' => array(
						'VARCHAR' => 'Text String (varchar)',
						'TEXT' => 'Text Field',
						'LONGTEXT' => 'Long Text Field'),
					'Numbers' => array(
						'INT' => 'Integer',
						'TINYINT' => 'Tiny Integer',
						'BIGINT' => 'Big Integer'),
					'ENUM' => 'Enumerated List'
				);
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'field',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(___(':create field', array(':create' => ___('create')))), $next);
				
			break;
				
			case 'query':
				// set the header
				$data->header = ___('change.title.runquery');
				
				// set the message
				$data->message = ___('change.text.runquery');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'query',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', ucwords(___('run query')), $next);
				
			break;
			
			default:
				// set the message
				$data->message = ___('change.text.default');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'back',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('install/index').
					form::button('back', ucwords(___('install center')), $next).
					form::close();
			break;
		}
		
		// content
		$this->template->title.= ___('change.title.default');
		$this->template->layout->label = ___('change.title.default');
		
		if ($showbutton === true)
		{
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'back',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/changedb').
				form::button('back', ___('change.back'), $next).
				form::close();
		}
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_genre()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_genre'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_genre_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
	
		// set the message
		$data->message = __('genre.message', array(':path' => APPFOLDER.'/config/nova'.EXT));
		
		// map the genres directory
		$map = Utility::directory_map(MODPATH.'nova/install/assets/genres/');
		
		// clear out the index file
		$indexkey = array_search('index.html', $map);
		unset($map[$indexkey]);
		
		// get the genre info
		$info = (array) Kohana::config('genreinfo');
		
		foreach ($map as $key => $m)
		{
			// drop the extension off
			$length = strlen(EXT);
			$value = str_replace(EXT, '', $m);
			
			if (array_key_exists($value, $info))
			{
				$genres[$value] = array(
					'name' => $info[$value],
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? true : false
				);
				
				// clear out the item from the map
				unset($map[$key]);
			}
			else
			{
				$additional[$value] = array(
					'name' => $value,
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? true : false
				);
			}
		}
		
		// set the genres list
		$data->genres = (isset($genres)) ? $genres : false;
		$data->additional = (isset($additional)) ? $additional : false;
		
		// set the loading image
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/nova/install/design/images/loading-circle-large.gif',
				'attr' => array(
					'alt' => __('processing'),
					'class' => '')),
		);
		
		// content
		$this->template->title.= __('The Genre Panel');
		$this->template->layout->label = __('The Genre Panel');
		
		// send the response
		$this->response->body($this->template);
	}
	
	/**
	 * The install/main page can display several errors depending on the situation.
	 * The following errors have been built in to the install/main page:
	 *
	 *     0 - no errors
	 *     1 - the system is already installed
	 *     2 - you must be a system administrator to update the genre
	 */
	public function action_main($error = 0)
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_main'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_main_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		if ((is_numeric($error) and $error > 0))
		{
			$this->template->layout->flash = View::factory('install/pages/flash');
			$this->template->layout->flash->status = ($error == 1) ? 'info' : 'error';
			$this->template->layout->flash->message = ___('install.error.error_'.$error);
		}
		
		// content
		$this->template->title.= ___('Installation Center');
		$this->template->layout->label = ___('Installation Center');
		
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
	
	public function action_remove()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_remove'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_remove_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		if (isset($_POST['submit']))
		{
			// grab an instance of the database
			$db = Database::instance();
			
			// get the database config
			$dbconf = Kohana::config('database.default');
			
			// get an array of the tables
			$tables = $db->list_tables();
			
			// get the prefix length
			$prefix_len = strlen($dbconf['table_prefix']);
			
			// go through all the tables to find out if its part of the system or not
			foreach ($tables as $key => $value)
			{
				if (substr($value, 0, $prefix_len) != $dbconf['table_prefix'])
				{
					unset($tables[$key]);
				}
				else
				{
					$tables[$key] = substr_replace($value, '', 0, $prefix_len);
				}
			}
			
			// loop through and uninstall the system
			foreach ($tables as $v)
			{
				DBForge::drop_table($v);
			}
			
			// set the failure message
			$data->message = ___('install.remove.success');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/index').form::button('install', ___('Install Center'), $next).form::close();
		}
		else
		{
			// set the instructions
			$data->message = ___('install.remove.message');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/remove').form::button('submit', ___('Uninstall'), $next).form::close();
		}
		
		// content
		$this->template->title.= ___('Uninstall Nova');
		$this->template->layout->label = ___('Uninstall Nova');
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_setupconfig($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a session instance
		$session = Session::instance();
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('install_setupconfig'));
		
		// create a new js view
		$this->template->javascript = View::factory(Location::view('install_setupconfig_js', null, 'js'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pass the step over to the view file
		$data->step = $step;
		
		if ( ! file_exists(MODPATH.'assets/database/db.mysql'.EXT))
		{
			$data->message = ___('setup.text.noconfig', array(':modules' => MODFOLDER, ':ext' => EXT));
		}
		else
		{
			if (file_exists(APPPATH.'config/database'.EXT))
			{
				$data->message = ___('setup.text.exists', array(':appfolder' => APPFOLDER));
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.2.4', '<'))
				{
					$data->message = ___('setup.text.php', array(':php' => PHP_VERSION));
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data->message = ___('setup.text.step0', array(':modules' => MODFOLDER, ':appfolder' => APPFOLDER));
							
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
							);
							
							if (extension_loaded('mysql'))
							{
								$this->template->layout->controls = form::open('install/setupconfig/1').
									form::button('next', ucwords(___(':next step', array(':next' => ___('next')))), $next).
									form::close();
							}
							else
							{
								$this->template->layout->flash = View::factory('install/pages/flash');
								$this->template->layout->flash->status = 'error';
								$this->template->layout->flash->message = ___('setup.text.nodb');
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
							$data->message = ___('setup.text.connection');

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
									$data->message = ___('setup.text.nova1failure');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/1').
										form::button('next', ucwords(___('start over')), $next).
										form::close();
								}
								else
								{
									// write the message
									$data->message = ___('setup.text.step2.success');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/3').
										form::button('next', ucwords(___(':next step', array(':next' => ___('next')))), $next).
										form::close();
								}
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$data->message = ___('setup.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data->message = ___('setup.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data->message = ___('setup.text.step2.dbname', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = ___('setup.text.step2.gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/1').
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
									$data->message = ___('setup.text.step3write');
									
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
								
									$data->message = ___('setup.text.step3nowrite', array(':ext' => EXT, ':appfolder' => APPFOLDER));
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/4').
										form::button('next', ___('Re-Test'), $next).
										form::close();
								}
							}
							else
							{
								$data->code = $code;
								
								$data->message = ___('setup.text.step3nowrite', array(':ext' => EXT, ':appfolder' => APPFOLDER));
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/4').
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
									$data->message = ___('setup.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$data->message = ___('setup.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$data->message = ___('setup.text.step2.dbname', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = ___('setup.text.step2.gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/1').
									form::button('next', ucwords(___('start over')), $next).
									form::close();
							}
							
						break;
					}
				}
			}
		}
		
		// content
		$this->template->title.= ___('setup.title');
		$this->template->layout->label = ___('setup.title');
		
		// send the response
		$this->response->body($this->template);
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
			$this->template->layout->flash = View::factory('install/pages/flash');
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = ___('install.error.no_genre', array(':path' => APPFOLDER.'/config/nova'.EXT));
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('install_step0'));
				
				// create a new js view
				$this->template->javascript = View::factory(Location::view('install_step0_js', null, 'js'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(___('install.step0.instructions'));
				
				// content
				$this->template->title.= ___('Install Nova');
				$this->template->layout->label = ___('Getting Started');
				
				if ($allowed)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::open('install/step/1').form::button('next', ___('Start Install'), $next).form::close();
				}
				
			break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// update the character set
					$dbconfig = Kohana::config('database');
					$db->set_charset($dbconfig['default']['charset']);
					
					// pull in the field information
					include_once MODPATH.'nova/install/assets/fields'.EXT;
					
					foreach ($data as $key => $value)
					{
						DBForge::add_field($$value['fields']);
						DBForge::add_key($value['id'], true);
						
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
					include_once MODPATH.'nova/install/assets/data'.EXT;
					
					$insert = array();
					
					foreach ($data as $value)
					{
						foreach ($$value as $k => $v)
						{
							$sql = db::insert($value)
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
					include_once MODPATH.'nova/install/assets/genres/'.strtolower(Kohana::config('nova.genre')).EXT;
					
					$genre = array();
					
					foreach ($data as $key_d => $value_d)
					{
						foreach ($$value_d as $k => $v)
						{
							$sql = db::insert($key_d)
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
						include_once MODPATH.'nova/install/assets/dev'.EXT;
						
						$insert = array();
						
						foreach ($data as $value)
						{
							foreach ($$value as $k => $v)
							{
								$sql = db::insert($value)
									->columns(array_keys($v))
									->values(array_values($v))
									->compile($db);
									
								$insert[$value] = $db->query(Database::INSERT, $sql, true);
							}
						}
					}
				}
				
				// get the number of tables
				$tables = $db->list_tables();
				
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('install_step1'));
				
				// create a new js view
				$this->template->javascript = View::factory(Location::view('install_step1_js', null, 'js'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// get the questions from the db
				$questions = Jelly::query('securityquestion')->select();
				
				// set the questions variable
				$data->questions = array('' => ___('Please Select One'));
				
				if (count($questions) > 0)
				{
					foreach ($questions as $q)
					{
						$data->questions[$q->id] = $q->value;
					}
				}
				
				// set the validation errors
				$data->errors = ($session->get('errors')) ? $session->get('errors') : false;
				
				// make sure the proper message is displayed
				$data->message = ($data->errors === false)
					? (count($tables) < Kohana::config('nova.app_db_tables')) ? ___('install.step1.failure') : __('install.step1.success')
					: __('step1.errors');
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/install/views/design/images/loading-circle-large.gif',
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// get the default rank set
				$rankdefault = Jelly::query('setting', 'display_rank')->limit(1)->select()->value;
				
				// grab the rank catalogue
				$catalogue = Jelly::query('cataloguerank')->where('location', '=', $rankdefault)->limit(1)->select();
				
				// pull the rank record
				$rank = Jelly::query('rank', $session->get('rank', 1))->select();
				
				# FIXME: what's going on with this?
				
				$data->default_rank = array(
					//'src' => Location::image($rank->image.$catalogue->extension, null, $catalogue->location, 'rank'),
					'src' => APPFOLDER.'/assets/common/'.Kohana::config('nova.genre').'/ranks/'.$rankdefault.'/'.$rank->image.$catalogue->extension,
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// content
				$this->template->title.= ___('Install Nova: Basic Information');
				$this->template->layout->label = ___('Just the Basics');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::config('nova.app_db_tables')) 
					? false 
					: form::button('next', ___('Next Step'), $next).form::close();
			break;
				
			case 2:
				if (isset($_POST['next']))
				{
					$validate = Validation::factory($_POST)
						->rule('email', 'not_empty', array(':value'))
						->rule('email', 'email', array(':value'))
						->rule('password', 'not_empty', array(':value'))
						->rule('password_confirm', 'not_empty', array(':value'))
						->rule('password_confirm', 'matches', array(':validation', 'password_confirm', 'password'))
						->rule('security_question', 'not_empty', array(':value'))
						->rule('security_answer', 'not_empty', array(':value'));
						
					if ($validate->check())
					{
						// wipe out the session if everything is good
						$session->destroy();
						
						// get the data
						$simname = trim(Security::xss_clean($_POST['sim_name']));
						$name = trim(Security::xss_clean($_POST['name']));
						$email = trim(Security::xss_clean($_POST['email']));
						$password = trim(Security::xss_clean($_POST['password']));
						$question = trim(Security::xss_clean($_POST['security_question']));
						$answer = trim(Security::xss_clean($_POST['security_answer']));
						$first_name = trim(Security::xss_clean($_POST['first_name']));
						$last_name = trim(Security::xss_clean($_POST['last_name']));
						$position = trim(Security::xss_clean($_POST['position']));
						$rank = trim(Security::xss_clean($_POST['rank']));
						
						// update the settings
						Jelly::query('setting')
							->where('key', '=', 'sim_name')
							->limit(1)
							->set(array('value' => $simname))
							->update();
							
						Jelly::query('setting')
							->where('key', '=', 'email_subject')
							->limit(1)
							->set(array('value' => '['.$simname.']'))
							->update();
							
						Jelly::query('setting')
							->where('key', '=', 'default_email_address')
							->limit(1)
							->set(array('value' => 'donotreply@'.strtolower($simname)))
							->update();
							
						Jelly::query('setting')
							->where('key', '=', 'default_email_name')
							->limit(1)
							->set(array('value' => $simname))
							->update();
						
						// create the user
						$crUser = Jelly::factory('user')
							->set(array(
								'status' => 'active',
								'name' => $name,
								'email' => $email,
								'password' => Auth::hash($password),
								'role' => 1,
								'sysadmin' => 'y',
								'gm' => 'y',
								'webmaster' => 'y',
								'skin_main' => Jelly::query('catalogueskinsec')->defaultskin('main')->limit(1)->select()->skin->location,
								'skin_wiki' => Jelly::query('catalogueskinsec')->defaultskin('wiki')->limit(1)->select()->skin->location,
								'skin_admin' => Jelly::query('catalogueskinsec')->defaultskin('admin')->limit(1)->select()->skin->location,
								'rank' => Jelly::query('cataloguerank')->defaultrank()->limit(1)->select()->location,
								'security_question' => $question,
								'security_answer' => sha1($answer),
							))
							->save();
						
						// create the character
						$crCharacter = Jelly::factory('character')
							->set(array(
								'user' => $crUser->id,
								'fname' => $first_name,
								'lname' => $last_name,
								'position1' => $position,
								'rank' => $rank,
								'status' => 'active',
								'activate' => date::now(),
							))
							->save();
						
						// update the user with the character info
						Jelly::query('user', $crUser->id)->set(array('main_char' => $crCharacter->id))->update();
						
						// get the preferences
						$prefs = Jelly::query('userpref')->select();
						
						// loop through and create the preferences for the user
						foreach ($prefs as $p)
						{
							$prefvalues = Jelly::factory('userprefvalue')
								->set(array(
									'user' => $crUser->id,
									'key' => $p->key,
									'value' => $p->default
								))
								->save();
						}
						
						// do the quick installs
						Utility::install_rank();
						Utility::install_skin();
						Utility::install_widget();
						
						// deactivate the upgrade module
						Jelly::query('cataloguemodule')
							->where('shortname', '=', 'upgrade')
							->limit(1)
							->set(array('status' => 'inactive'))
							->update();
						
						// do the registration
						$this->_register();
					}
					else
					{
						// set the session variables
						$session->set('sim_name', Security::xss_clean($_POST['sim_name']));
						$session->set('name', Security::xss_clean($_POST['name']));
						$session->set('email', Security::xss_clean($_POST['email']));
						$session->set('password', Security::xss_clean($_POST['password']));
						$session->set('security_question', Security::xss_clean($_POST['security_question']));
						$session->set('security_answer', Security::xss_clean($_POST['security_answer']));
						$session->set('first_name', Security::xss_clean($_POST['first_name']));
						$session->set('last_name', Security::xss_clean($_POST['last_name']));
						$session->set('position', Security::xss_clean($_POST['position']));
						$session->set('rank', Security::xss_clean($_POST['rank']));
						$session->set('errors', $validate->errors('register'));
						
						// redirect back to step 1
						$this->request->redirect('install/step/1');
					}
				}
				
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('install_step2'));
				
				// create a new js view
				$this->template->javascript = View::factory(Location::view('install_step2_js', null, 'js'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = ___('install.step2.instructions');
				
				// content
				$this->template->title.= ___('Nova Installed!');
				$this->template->layout->label = ___('All Finished');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('main/index').form::button('next', ___('Finish'), $next).form::close();
				
			break;
		}
		
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
	
	private function _register()
	{
		require_once Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');
		
		$db = Database::instance();
		
		$request = array(
			Kohana::config('nova.app_name'),
			Kohana::config('nova.app_version_full'),
			url::site(),
			$_SERVER['REMOTE_ADDR'],
			$_SERVER['SERVER_ADDR'],
			phpversion(),
			'install',
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
		
		//$email = Email::install_register($data);
		$email = false;
		
		return $email;
	}
}
