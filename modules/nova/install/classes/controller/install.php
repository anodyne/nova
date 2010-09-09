<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Install Controller
 *
 * @package		Install
 * @category	Controllers
 * @author		Anodyne Productions
 */

# TODO: uncomment the redirects in the before() method after the login controller is built

class Controller_Install extends Controller_Template {
	
	/**
	 * @var	integer	the number of database tables in the system
	 */
	public $_tables = 59;
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if (!file_exists(APPPATH.'config/database'.EXT))
		{
			if ($this->request->action != 'setupconfig')
			{
				$this->request->redirect('install/setupconfig');
			}
		}
		else
		{
			// you're allowed to go to these segments if the system isn't installed
			$safesegs = array('step', 'index', 'main', 'verify', 'readme');
			
			// make sure the system is installed
			if (count(Database::instance()->list_tables()) < $this->_tables && !(in_array($this->request->action, $safesegs)))
			{
				$this->request->redirect('install/index');
			}
			
			// if the system is installed, make sure the user is logged in and a sysadmin
			if (count(Database::instance()->list_tables()) == $this->_tables)
			{
				// get an instance of the session
				$session = Session::instance();
				
				// make sure there's a session
				if ($session->get('userid'))
				{
					// are they a sysadmin?
					$sysadmin = Auth::is_type('sysadmin', $session->get('userid'));
					
					// if they aren't, send them away
					if ($sysadmin === FALSE)
					{
						//$this->request->redirect('login/index/error/1');
					}
				}
				else
				{
					// no session? send them away
					//$this->request->redirect('login/index/error/1');
				}
			}
		}
		
		// set the locale
		i18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory('_common/layouts/install');
		
		// set the variables in the template
		$this->template->title 					= 'Nova :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory('install/template_install');
		$this->template->layout->label			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->controls		= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		// content
		$this->template->title.= __('Installation Center');
		$this->template->layout->label = __('Installation Center');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_changedb($view = 'main')
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_changedb');
		
		// create the javascript view
		$this->template->javascript = View::factory('install/js/install_changedb_js');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// build the images
		$data->images = array(
			'loading' => array(
				'src' => MODFOLDER.'/nova/install/views/install/images/loading-circle-large.gif',
				'attr' => array(
					'alt' => __('processing'),
					'class' => '')),
		);
		
		// show the back button?
		$showbutton = FALSE;
		
		switch ($view)
		{
			case 'table':
				// set the header
				$data->header = __('Add Database Table');
				
				// set the message
				$data->message = __('changedb.table_inst');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'table',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', __('Create Table'), $next);
			break;
				
			case 'field':
				// set the header
				$data->header = __('Add Database Field');
				
				// set the message
				$data->message = __('changedb.field_inst');
				
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
				$this->template->layout->controls = form::button('back', __('Create Field'), $next);
				
			break;
				
			case 'query':
				// set the header
				$data->header = __('Run a MySQL Query');
				
				// set the message
				$data->message = __('changedb.query_inst');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'query',
				);
				
				// build the next step control
				$this->template->layout->controls = form::button('back', __('Run Query'), $next);
				
			break;
			
			default:
				// set the message
				$data->message = __('changedb.message');
				
				// build the button attributes
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'back',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('install/index').form::button('back', __('Install Center'), $next).form::close();
			break;
		}
		
		// content
		$this->template->title.= __('Change Database');
		$this->template->layout->label = __('Change Database');
		
		if ($showbutton === TRUE)
		{
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'back',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/changedb').form::button('back', __('Back to Change Database Panel'), $next).form::close();
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_genre()
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_genre');
		
		// create the javascript view
		$this->template->javascript = View::factory('install/js/install_genre_js');
		
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
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? TRUE : FALSE
				);
				
				// clear out the item from the map
				unset($map[$key]);
			}
			else
			{
				$additional[$value] = array(
					'name' => $value,
					'installed' => (Database::instance()->list_tables('%_'.$value)) ? TRUE : FALSE
				);
			}
		}
		
		// set the genres list
		$data->genres = (isset($genres)) ? $genres : FALSE;
		$data->additional = (isset($additional)) ? $additional : FALSE;
		
		// set the loading image
		$data->images = array(
			'loading' => array(
				'src' => Location::image('loading-circle-large.gif', NULL, 'install', 'image'),
				'attr' => array(
					'alt' => __('processing'),
					'class' => '')),
		);
		
		// content
		$this->template->title.= __('The Genre Panel');
		$this->template->layout->label = __('The Genre Panel');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_main($error = 0)
	{
		/**
		 * 0 - no errors
		 * 1 - system is already installed
		 * 2 - you must be a sysadmin to update the genre
		 */
		
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_main');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// figure out if the system is installed or not
		$data->installed = Utility::install_status();
		
		if ((is_numeric($error) && $error > 0))
		{
			$this->template->layout->flash_message = View::factory('install/pages/flash');
			$this->template->layout->flash_message->status = ($error == 1) ? 'info' : 'error';
			$this->template->layout->flash_message->message = __('install.error.error_'.$error);
		}
		
		// content
		$this->template->title.= __('Installation Center');
		$this->template->layout->label = __('Installation Center');
		
		// load the javascript
		$this->template->javascript = View::factory('install/js/verify_js');
	}
	
	public function action_readme()
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_readme');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('Nova Readme');
		$this->template->layout->label = __('Nova Readme');
		
		// build the next step button
		$next = array(
			'type' => 'submit',
			'class' => 'btn-main',
			'id' => 'install',
		);
		
		// build the next step control
		$this->template->layout->controls = form::open('install/index').form::button('install', __('Back to Install Center'), $next).form::close();
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_remove()
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_remove');
		
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
			$data->message = __('remove.success');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'install',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/index').form::button('install', __('Install Center'), $next).form::close();
		}
		else
		{
			// set the instructions
			$data->message = __('remove.message');
			
			// build the button attributes
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'submit',
			);
			
			// build the next step control
			$this->template->layout->controls = form::open('install/remove').form::button('submit', __('Uninstall'), $next).form::close();
		}
		
		// content
		$this->template->title.= __('Uninstall Nova');
		$this->template->layout->label = __('Uninstall Nova');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_setupconfig($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a session instance
		$session = Session::instance();
		
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_setupconfig');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pass the step over to the view file
		$data->step = $step;
		
		if (!file_exists(MODPATH.'assets/database/db.mysql'.EXT))
		{
			$data->message = __('setup.no_config_file', array(':modules' => MODFOLDER, ':ext' => EXT));
		}
		else
		{
			if (file_exists(APPPATH.'config/database'.EXT))
			{
				$data->message = __('setup.config_exists', array(':appfolder' => APPFOLDER));
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.2.4', '<'))
				{
					$data->message = __('Your server is running PHP version :php but Nova requires at least PHP 5.2.4.', array(':php' => PHP_VERSION));
				}
				else
				{
					switch ($step)
					{
						case 0:
							$data->message = __('setup.step0_text', array(':modules' => MODFOLDER, ':appfolder' => APPFOLDER));
							
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn-main',
								'id' => 'next',
							);
							
							if (extension_loaded('mysql'))
							{
								$this->template->layout->controls = form::open('install/setupconfig/1').form::button('next', __('Next Step'), $next).form::close();
							}
							else
							{
								$this->template->layout->flash_message = View::factory('install/pages/flash');
								$this->template->layout->flash_message->status = 'error';
								$this->template->layout->flash_message->message = __('setup.nodb');
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
							$data->message = __("Enter your database connection details below. If you're not sure about these, contact your web host.");

							// build the next step control
							$this->template->layout->controls = form::button('next', __('Next Step'), $next).form::close();
							
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
								
								if ($type == 'nova1' && count($tables) > 0)
								{
									// write the message
									$data->message = __('setup.step2_nova1_failure');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/1').form::button('next', __('Start Over'), $next).form::close();
								}
								else
								{
									// write the message
									$data->message = __('setup.step2_success');
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/3').form::button('next', __('Next Step'), $next).form::close();
								}
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== FALSE)
								{
									$data->message = __('setup.step2_db_host');
								}
								elseif (stripos($msg, 'Access denied for user') !== FALSE)
								{
									$data->message = __('setup.step2_db_userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== FALSE)
								{
									$data->message = __('setup.step2_db_name', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = __('setup.step2_db_gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/1').form::button('next', __('Start Over'), $next).form::close();
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
											$file[$line_num] = str_replace("FALSE", "'".$session->get('dbUser')."'", $line);
										break;
										
										case "'password":
											$file[$line_num] = str_replace("FALSE", "'".$session->get('dbPass')."'", $line);
										break;
										
										case "'hostname":
											$file[$line_num] = str_replace("localhost", $session->get('dbHost'), $line);
										break;
										
										case "'table_pr":
											$file[$line_num] = str_replace("''", "'".$session->get('prefix')."'", $line);
										break;
									}
								}
								
								$code = FALSE;
								
								foreach ($file as $value)
								{
									$code.= htmlentities($value);
								}
							}
							else
							{
								$code = htmlentities("<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
'default' => array(
'type' => 'mysql',

'connection' => array(
'hostname' => '".$session->get('dbHost')."',
'username' => '".$session->get('dbUser')."',
'password' => '".$session->get('dbPass')."',
'persistent' => FALSE,
'database' => '".$session->get('dbName')."',
),

'table_prefix' => '".$session->get('prefix')."',
'charset' => 'utf8',
'collate' => 'utf8_general_ci',
'caching' => FALSE,
'profiling' => TRUE,
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
								$write = FALSE;
							
								// write the file line by line
								foreach ($file as $line)
								{
									$write = fwrite($handle, $line);
								}
								
								// close the file
								fclose($handle);
								
								// try to chmod the file to the proper permissions
								chmod(APPPATH.'config/database'.EXT, 0666);
								
								if ($write !== FALSE)
								{
									// set the success message
									$data->message = __('setup.step3_write');
									
									// wipe out the session
									$session->destroy();
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/index').form::button('next', __('Install Center'), $next).form::close();
								}
								else
								{
									$data->code = $code;
								
									$data->message = __('setup.step3_no_write', array(':ext' => EXT, ':appfolder' => APPFOLDER));
									
									// build the next step button
									$next = array(
										'type' => 'submit',
										'class' => 'btn-main',
										'id' => 'next',
									);
									
									// write the controls
									$this->template->layout->controls = form::open('install/setupconfig/4').form::button('next', __('Re-Test'), $next).form::close();
								}
							}
							else
							{
								$data->code = $code;
								
								$data->message = __('setup.step3_no_write', array(':ext' => EXT, ':appfolder' => APPFOLDER));
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								$text = __('setup.step3_retest');
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/4').form::button('next', __('Re-Test'), $next).form::close();
							}
						break;
							
						case 4:
							// get an instance of the database
							$db = Database::instance();
							
							try {
								$tables = $db->list_tables();
								
								// write the message
								$data->message = __('setup.step4_success');
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								$text = __('setup.step3_install');
								
								// write the controls
								$this->template->layout->controls = form::open('install/index').form::button('next', __('Install Center'), $next).form::close();
								
								// clear the session
								$session->destroy();
							} catch (Exception $e) {
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== FALSE)
								{
									$data->message = __('setup.step2_db_host');
								}
								elseif (stripos($msg, 'Access denied for user') !== FALSE)
								{
									$data->message = __('setup.step2_db_userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== FALSE)
								{
									$data->message = __('setup.step2_db_name', array(':dbname' => $dbName));
								}
								else
								{
									$data->message = __('setup.step2_db_gen');
								}
								
								// build the next step button
								$next = array(
									'type' => 'submit',
									'class' => 'btn-main',
									'id' => 'next',
								);
								
								// write the controls
								$this->template->layout->controls = form::open('install/setupconfig/1').form::button('next', __('Start Over'), $next).form::close();
							}
							
						break;
					}
				}
			}
		}
		
		// create the javascript view
		$this->template->javascript = View::factory('install/js/install_setupconfig_js');
		
		// content
		$this->template->title.= __('Config File Setup');
		$this->template->layout->label = __('Config File Setup');
		
		// send the response
		$this->request->response = $this->template;
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
		$allowed = TRUE;
		
		if (Kohana::config('nova.genre') == '')
		{
			// installation not allowed
			$allowed = FALSE;
			
			// show the flash message
			$this->template->layout->flash_message = View::factory('install/pages/flash');
			$this->template->layout->flash_message->status = 'error';
			$this->template->layout->flash_message->message = __('install.error_no_genre', array(':path' => APPFOLDER.'/config/nova'.EXT));
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('install/pages/install_step0');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('step0.inst'));
				
				// content
				$this->template->title.= __('Install Nova');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory('install/js/install_step0_js');
				
				if ($allowed === TRUE)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::open('install/step/1').form::button('next', __('Start Install'), $next).form::close();
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
						DBForge::add_key($value['id'], TRUE);
						
						if (isset($value['index']))
						{
							foreach ($value['index'] as $index)
							{
								DBForge::add_key($index);
							}
						}
						
						DBForge::create_table($key, TRUE);
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from inserting the tables
					$data = NULL;
					
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
								
							$insert[$value] = $db->query(Database::INSERT, $sql, TRUE);
						}
					}
					
					// pause the script for a second
					sleep(1);
					
					// wipe out the data from insert the data
					$data = NULL;
					
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
								
							$genre[$key_d] = $db->query(Database::INSERT, $sql, TRUE);
						}
					}
					
					if (Kohana::config('install.dev'))
					{
						// pause the script for a second
						sleep(1);
						
						// wipe out the data from insert the data
						$data = NULL;
						
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
									
								$insert[$value] = $db->query(Database::INSERT, $sql, TRUE);
							}
						}
					}
				}
				
				// get the number of tables
				$tables = $db->list_tables();
				
				// create a new content view
				$this->template->layout->content = View::factory('install/pages/install_step1');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the validation errors
				$data->errors = ($session->get('errors')) ? $session->get('errors') : FALSE;
				
				// make sure the proper message is displayed
				$data->message = ($data->errors === FALSE)
					? (count($tables) < $this->_tables) ? __('step1.failure') : __('step1.success')
					: __('step1.errors');
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/install/views/install/images/loading-circle-large.gif',
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// get the default rank set
				$rankdefault = Jelly::query('setting')->where('key', '=', 'display_rank')->limit(1)->select()->value;
				
				// grab the rank catalogue
				$catalogue = Jelly::query('cataloguerank')->where('location', '=', $rankdefault)->limit(1)->select();
				
				// pull the rank record
				$rank = Jelly::query('rank', $session->get('rank', 1))->select();
				
				# FIXME: what's going on with this?
				
				$data->default_rank = array(
					//'src' => Location::image($rank->image.$catalogue->extension, NULL, $catalogue->location, 'rank'),
					'src' => APPFOLDER.'/assets/common/'.Kohana::config('nova.genre').'/ranks/'.$rankdefault.'/'.$rank->image.$catalogue->extension,
					'attr' => array(
						'class' => 'image',
						'alt' => ''),
				);
				
				// content
				$this->template->title.= __('Install Nova: Basic Information');
				$this->template->layout->label = __('Just the Basics');
				
				// create the javascript view
				$this->template->javascript = View::factory('install/js/install_step1_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < $this->_tables) ? FALSE : form::button('next', __('Next Step'), $next).form::close();
				
			break;
				
			case 2:
				if (isset($_POST['next']))
				{
					$validate = Validate::factory($_POST)
						->rule('email', 'not_empty')
						->rule('email', 'email')
						->rule('password', 'not_empty')
						->rule('password_confirm', 'not_empty')
						->rule('password_confirm', 'matches', array('password'));
						
					if ($validate->check())
					{
						// wipe out the session if everything is good
						$session->destroy();
						
						// get the data
						$simname = trim(Security::xss_clean($_POST['sim_name']));
						$name = trim(Security::xss_clean($_POST['name']));
						$email = trim(Security::xss_clean($_POST['email']));
						$password = trim(Security::xss_clean($_POST['password']));
						$first_name = trim(Security::xss_clean($_POST['first_name']));
						$last_name = trim(Security::xss_clean($_POST['last_name']));
						$position = trim(Security::xss_clean($_POST['position']));
						$rank = trim(Security::xss_clean($_POST['rank']));
						
						// update the settings
						Jelly::query('setting')
							->where('key', '=', 'sim_name')
							->limit(1)
							->set(array(
								'value' => $simname
							))
							->update();
							
						Jelly::query('setting')
							->where('key', '=', 'email_subject')
							->limit(1)
							->set(array(
								'value' => '['.$simname.']'
							))
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
								'skin_main' => Jelly::query('catalogueskinsec')->defaultskin('main')->limit(1)->select()->skin,
								'skin_wiki' => Jelly::query('catalogueskinsec')->defaultskin('wiki')->limit(1)->select()->skin,
								'skin_admin' => Jelly::query('catalogueskinsec')->defaultskin('admin')->limit(1)->select()->skin,
								'rank' => Jelly::query('cataloguerank')->defaultrank()->limit(1)->select()->location,
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
							$prefvalues = Jelly::query('userprefvalue')
								->set(array(
									'user' => $crUser->id,
									'key' => $p->key,
									'value' => $p->default
								))
								->save();
						}
						
						// do the quick installs
						Utility::install_ranks();
						Utility::install_skins();
						
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
				$this->template->layout->content = View::factory('install/pages/install_step2');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = __('step2.message');
				
				// content
				$this->template->title.= __('Nova Installed!');
				$this->template->layout->label = __('All Finished');
				
				// create the javascript view
				$this->template->javascript = View::factory('install/js/install_step2_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('main/index').form::button('next', __('Finish'), $next).form::close();
				
			break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_verify()
	{
		// create a new content view
		$this->template->layout->content = View::factory('install/pages/install_verify');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// create the javascript view
		$this->template->javascript = View::factory('install/js/verify_js');
		
		// the verification table
		$data->verify = Utility::verify_server();
		
		if ($data->verify === FALSE || !isset($data->verify['failure']))
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
				Kohana::config('info.app_name'),
				Kohana::config('info.app_version_full'),
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