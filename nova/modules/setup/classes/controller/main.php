<?php
/**
 * The main controller for the setup module is the main entry point into the
 * module. Included in this controller is the main page that determines what
 * a user wants to do, a 404 page, and the database configuration wizard.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

# FIXME: using the session before the system is installed is going to create problems

class Controller_Main extends Controller_Base_Setup
{
	/**
	 * Nova will look at the database and attempt to determine exactly what
	 * you want to do. If there's nothing in the database, then you probably
	 * want to do a fresh install. If Nova 3 is in the database, we'll check
	 * for an update, but if there isn't an update available, Nova will show
	 * you the utilities you have available to you. Finally, if something
	 * is found but it isn't Nova 3 (like Nova 2 for example), we assume you
	 * want to upgrade from the previous version.
	 *
	 * @return 	void
	 */
	public function action_index()
	{
		$this->_view = 'setup/index';
		$this->_js_view = 'setup/index_js';
		
		$this->_data->title = 'Nova Setup';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Nova Setup';
		$this->_data->header->image = 'wand-24x24.png';
		$this->_data->controls = false;

		// do some checks to see what we should show
		$installed = \Utility::installed();
		$update = ($installed) ? \Utility::check_for_updates() : false;

		if ($installed)
		{
			if (is_object($update))
			{
				/**
				 * Nova is installed and an update is available.
				 */
				$this->_data->option = 3;
				$this->_data->controls = '<a href="'.\Uri::create('setup/update/index').'" class="btn">Start Update</a>';
				$this->_data->controls.= '<a href="#" class="pull-right muted" rel="ignoreVersion" data-version="'.$update->version.'">Ignore this version</a>';
				$this->_data->header->text = 'Update Nova 3';
				
				$this->_data->update = new \stdClass;
				$this->_data->update->version = 'Nova '.$update->version;
				$this->_data->update->description = $update->notes;
			}
			else
			{
				/**
				 * Nova is installed and there are no updates available. Show the
				 * admin the list of utilities they can use.
				 */
				$this->_data->option = 4;
				$this->_data->header->text = 'Nova Setup Utilities';
				$this->_data->controls = '<a href="'.\Uri::create('main/index').'" class="pull-right muted">Back to site</a>';
			}
		}
		else
		{
			// get the prefix
			$prefix = \DB::table_prefix();

			/**
			 * If we throw an exception here, it means there's no table for Nova to pull
			 * information from, so the only option is a fresh install. If there is a table
			 * to pull from, then we figure out if they're coming from version 1 or version
			 * 2 and take the appropriate action.
			 */
			try {
				// get the information from the database
				$version = \DB::query("SELECT * FROM ${prefix}system_info WHERE sys_id = 1")
					->as_object()
					->execute()
					->current()
					->sys_version_major;

				// set the option
				$this->_data->option = ((int) $version == 2) ? 2 : 5;
				
				// nova 2 means they can do the upgrade
				if ($this->_data->option == 2)
				{
					$this->_data->controls = '<a href="'.\Uri::create('setup/upgrade/index').'" class="btn">Start Upgrade</a>';
					$this->_data->controls.= '<a href="'.\Uri::create('setup/install/index').'" class="pull-right muted">I\'d like to do a Fresh Install instead</a>';
					$this->_data->header->text = 'Upgrade From Nova 2';
				}
				
				// nova 1 means they can't do the upgrade
				if ($this->_data->option == 5)
				{
					$this->_data->controls = '<a href="'.\Uri::create('setup/install/index').'" class="pull-right muted">I\'d like to do a Fresh Install instead</a>';
					$this->_data->header->text = 'Unable to Upgrade Nova';
					$this->_data->header->image = 'cross-24x24.png';
				}
			}
			catch (\Database_Exception $e)
			{
				/**
				 * The database is empty which means the only thing we can do
				 * is a fresh install of Nova 3.
				 */
				$this->_data->option = 1;
				$this->_data->controls = '<a href="'.\Uri::create('setup/install/index').'" class="btn">Start Install</a>';
				$this->_data->header->text = 'Install Nova 3';
			}
		}
		
		return;
	}
	
	/**
	 * Nova will walk admins through the process of setting up their database
	 * connection file. Once the information is provided, Nova will attempt to
	 * connect to the database. If there's a problem, the admin will be able to
	 * make changes and test again. If the connection was made then if the server
	 * allows, Nova will also write the file to the proper location.
	 *
	 * @param 	int 	the step in the process (default: 0)
	 * @return 	void
	 */
	public function action_config($step = 0)
	{
		$this->_view = 'setup/config';
		
		$this->_data->title = 'Database Connection Setup';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Database Connection Setup';
		$this->_data->header->image = 'pencil-24x24.png';
		$this->_data->controls = false;

		// clear the installed status cache
		\Cache::delete('nova_system_installed');
		
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// create a session instance
		$session = \Session::instance();
		
		// assign the step so the view can use it
		$this->_data->step = $step;
		
		if ( ! file_exists(NOVAPATH.'setup/assets/db.mysql.php'))
		{
			$this->_data->message = __('setup.config.text.noconfig');
			$this->_data->header->text = 'File Not Found';
			$this->_data->header->image = 'cross-24x24.png';
			$this->_data->controls = '<a href="'.\Uri::create('setup/main/config').'" class="pull-right muted">Try again</a>';
		}
		else
		{
			if (file_exists(APPPATH.'config/'.\Fuel::$env.'/db.php') and $step != 4)
			{
				$this->_data->message = __('setup.config.text.exists', array('env' => \Fuel::$env));
				$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to Setup Center</a>';
			}
			else
			{
				if (version_compare(PHP_VERSION, '5.3.0', '<'))
				{
					$this->_data->message = __('setup.config.text.php', array('php' => PHP_VERSION));
					$this->_data->header->text = 'Installation Cannot Continue';
					$this->_data->header->image = 'cross-24x24.png';
				}
				else
				{
					switch ($step)
					{
						case 0:
							$this->_data->message = __('setup.config.text.step0', array('env' => \Fuel::$env));
							
							if (extension_loaded('mysql'))
							{
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/1').'" class="btn">Next Step</a>';
								
							}
							else
							{
								$this->_flash[] = array(
									'status' => 'danger',
									'message' => __('setup.config.text.nodb'),
								);
							}
						break;
						
						case 1:
							// set the message
							$this->_data->message = __('setup.config.text.connection');
							
							// build the next step button
							$next = array(
								'type' => 'submit',
								'class' => 'btn',
								'id' => 'next',
							);
							
							// build the next step control
							$this->_data->controls = \Form::button('next', 'Next Step', $next).\Form::close();
						break;
						
						case 2:
							// set the variables to use
							$dbName		= trim(\Security::xss_clean($_POST['dbName']));
							$dbUser		= trim(\Security::xss_clean($_POST['dbUser']));
							$dbPass		= trim(\Security::xss_clean($_POST['dbPass']));
							$dbHost		= trim(\Security::xss_clean($_POST['dbHost']));
							$prefix		= trim(\Security::xss_clean($_POST['prefix']));
							
							// set the session variables
							$session->set('dbName', $dbName);
							$session->set('dbUser', $dbUser);
							$session->set('dbPass', $dbPass);
							$session->set('dbHost', $dbHost);
							$session->set('prefix', $prefix);
							
							$dbconfig = array(
								'type'        => 'mysql',
								'connection'  => array(
									'hostname'       => ''.$session->get('dbHost').'',
									'port'           => '3306',
									'database'       => ''.$session->get('dbName').'',
									'username'       => ''.$session->get('dbUser').'',
									'password'       => ''.$session->get('dbPass').'',
									'persistent' => false,
								),
								'table_prefix' => ''.$session->get('prefix').'',
								'identifier'   => '`',
								'charset'      => 'utf8',
								'caching'      => false,
								'profiling'    => false,
							);
							
							// get an instance of the database
							$db = \Database_Connection::instance('custom', $dbconfig);
							
							try
							{
								// try to list the tables
								$db->list_tables($prefix.'%');
								
								// write the message
								$this->_data->message = __('setup.config.text.step2.success');
								
								// write the controls
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/3').'" class="btn">Write Connection File</a>';
							}
							catch (Exception $e)
							{
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.dbname', array('dbname' => $dbName));
								}
								else
								{
									$this->_data->message = __('setup.config.text.step2.gen');
								}
								
								// write the controls
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/1').'" class="btn">Start Over</a>';
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
							$file = file(NOVAPATH.'setup/assets/db.mysql.php');
							
							if (is_array($file))
							{
								foreach ($file as $line_num => $line)
								{
									switch (substr($line, 0, 9))
									{
										case "'database":
											$file[$line_num] = str_replace("#DATABASE#", $session->get('dbName'), $line);
										break;
										
										case "'username":
											$file[$line_num] = str_replace("#USERNAME#", $session->get('dbUser'), $line);
										break;
										
										case "'password":
											$file[$line_num] = str_replace("#PASSWORD#", $session->get('dbPass'), $line);
										break;
										
										case "'hostname":
											$file[$line_num] = str_replace("#HOSTNAME#", $session->get('dbHost'), $line);
										break;
										
										case "'table_pr":
											$file[$line_num] = str_replace("#PREFIX#", $session->get('prefix'), $line);
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
								$code = htmlentities("<?php

return array(
'default' => array(
'connection' => array(
'hostname' => '".$session->get('dbHost')."',
'port' => '3306',
'database' => '".$session->get('dbName')."',
'username' => '".$session->get('dbUser')."',
'password' => '".$session->get('dbPass')."',
),
'table_prefix' => '".$session->get('prefix')."',
),
);");
							}
							
							if (count($check) == 0)
							{
								try
								{
									// try to chmod the config directory to the proper permissions
									chmod(APPPATH.'config/'.\Fuel::$env, 0777);
								}
								catch (Exception $e)
								{
									// add the message
									\Log::error('Could not change file permissions of the config directory to 0777. Please do so manually.');
								}
								
								// open the file
								$handle = fopen(APPPATH.'config/'.\Fuel::$env.'/db.php', 'w');
								
								// figure out if the write was successful
								$write = false;
							
								// write the file line by line
								foreach ($file as $line)
								{
									$write = fwrite($handle, $line);
								}
								
								// close the file
								fclose($handle);
								
								try
								{
									// try to chmod the file to the proper permissions
									chmod(APPPATH.'config/'.\Fuel::$env.'/db.php', 0666);
								}
								catch (Exception $e)
								{
									// add the message
									\Log::error('Could not change file permissions of the database configuration file to 0666. Please do so manually.');
								}
								
								if ($write !== false)
								{
									// set the success message
									$this->_data->message = __('setup.config.text.step3write');
									
									// wipe out the session
									$session->destroy();
									
									// write the controls
									$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="btn">Setup Center</a>';
								}
								else
								{
									$this->_data->code = $code;
								
									$this->_data->message = __('setup.config.text.step3nowrite', array('env' => \Fuel::$env));
									
									$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/4').'" class="btn">Re-Test</a>';
								}
							}
							else
							{
								$this->_data->code = $code;
								
								$this->_data->message = __('setup.config.text.step3nowrite', array('env' => \Fuel::$env));
								
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/4').'" class="btn">Re-Test</a>';
							}
						break;
							
						case 4:
							try
							{
								$tables = \DB::list_tables();
								
								// write the message
								$this->_data->message = __('setup.config.text.step4success');
								
								// write the controls
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="btn btn-primary">Setup Center</a>';
								
								// clear the session
								$session->destroy();
							}
							catch (Exception $e)
							{
								$msg = (string) $e->getMessage();
								
								if (stripos($msg, 'No such host is known') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.nohost');
								}
								elseif (stripos($msg, 'Access denied for user') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.userpass');
								}
								elseif (stripos($msg, 'Unknown database') !== false)
								{
									$this->_data->message = __('setup.config.text.step2.dbname', array('dbname' => $dbName));
								}
								else
								{
									$this->_data->message = __('setup.config.text.step2.gen');
								}
								
								// write the controls
								$this->_data->controls = '<a href="'.\Uri::create('setup/main/config/1').'" class="btn">Start Over</a>';
							}
						break;
					}
				}
			}
		}
		
		return;
	}
	
	/**
	 * The 404 page indicates that a page could not be found.
	 *
	 * @return 	void
	 */
	public function action_404()
	{
		$this->_view = 'setup/404';
		$this->_status = 404;
		
		$this->_data->title = '404 - Not Found';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = '404';
		$this->_data->header->image = 'exclamation-24x24.png';
		$this->_data->controls = '<a href="javascript: history.go(-1)" class="pull-right muted">Go Back</a>';
		
		$headers = array(
			0 => 'Aw, crap!',
			1 => 'Bloody Hell!',
			2 => 'Uh Oh!',
			3 => 'Nope, not here.',
			4 => 'Huh?',
			5 => 'Doh!',
			6 => 'What have you done?!',
			7 => 'Congratulations, you broke the Internet',
			8 => '404\'d',
			9 => 'Error 404: Page Not Found',
			10 => '404 Error',
			11 => '202 + 202 = 404',
			12 => 'Bummer!',
			13 => 'Page Not Found',
		);
		
		$messages = array(
			0 => "Looks like what you're trying to find isn't here. It was probably moved, or sucked in to a black hole. Chin up.",
			1 => "The rabbits have been nibbling on the cables again.",
			2 => "You seem to have stumbled off the beaten path. Perhaps you should try again.",
			3 => "That file ain't there. Kind of pathetic, really.",
			4 => "Dear Happy Internet Traveler,\r\n\r\nDespite that song in your step and sense of purpose, you've hit a little bump in the road. These things happen, but go ahead and try again.",
			5 => "We lost that page. Try again.",
			6 => "I take my eye off you for one minute and this is where I find you?! Come on!",
			7 => "The page you're after doesn't exist. Try again.",
			8 => "Boy, you sure are stupid.\r\n\r\nWere you just making up names of files or what? I mean, I've seen some pretend file names in my day, but come on! It's like you're not even trying.",
			9 => "We actually know where the page is. Chuck Norris has it and he decided to keep it.",
			10 => "This is not the page you're looking for.\r\n\r\nMove along...\r\nMove along...",
			11 => "For those who aren't great at math, that means your page couldn't be found. Try again.",
			12 => "aka Error 404\r\n\r\nThe web address you entered is not a functioning page on the site.",
			13 => "We think it may have been murdered.\r\n\r\nProfessor Plum, in the Ball Room, with the Wrench.",
		);
		
		// get a random item
		$rand = array_rand($headers);
		
		// set the content now
		$this->_data->header->text = $headers[$rand];
		$this->_data->message = $messages[$rand];
		
		return;
	}

	public function action_test()
	{
		$array = array(
			'version' => '3.0.1',
			'version_major' => 3,
			'version_minor' => 0,
			'version_update' => 1,
			'severity' => 3,
			'notes' => "Nova 3.0.1 is the first maintenance release for Nova 3 and addresses several launch day issues that came up. Among the bugs fixed are a random display issue where a sparkling pink dolphin may appear on random pages. The damned thing got loose at the end of development and we couldn't capture it before release. But, we finally captured it and you shouldn't see him any more.",
			'date' => '30 April 2010',
			'link' => 'http://www.anodyne-productions.com/nova'
		);

		\Debug::dump(json_decode(file_get_contents(NOVAPATH.'setup/assets/update/version.json')));
		exit;
	}
}
