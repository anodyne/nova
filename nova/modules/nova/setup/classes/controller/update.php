<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Update Controller
 *
 * @package		Update
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @version		3.0
 */

class Controller_Update extends Controller_Template {
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if ( ! file_exists(APPPATH.'config/database'.EXT))
		{
			$this->request->redirect('setup/config');
		}
		else
		{
			// you need to be logged in for these pages
			$protectedsegs = array('check', 'step');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::config('novasys.app_db_tables');
			
			// make sure the system is installed
			if (count($db->list_tables($db->table_prefix().'%')) < $tables)
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
		$this->template = View::factory(Location::file('update', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 				= Kohana::config('novasys.app_name').' :: ';
		$this->template->javascript			= false;
		$this->template->layout				= View::factory(Location::file('update', null, 'templates'));
		$this->template->layout->label		= false;
		$this->template->layout->flash		= false;
		$this->template->layout->controls	= false;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('update_index'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('Update Center');
		$this->template->layout->label = __('Update Center');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	# TODO: need to figure out a better way to figure out if the server can talk to the update file
	
	public function action_check()
	{
		// check for updates
		$upd = $this->check_version();
		
		// set the flash message variable
		$flash = $upd['flash'];
		
		// set the update message variable
		$update = $upd['update'];
		
		// create a new content view
		$this->template->layout->content = View::factory(Location::view('update_check'));
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// set the content
		$data->message = (property_exists($update, 'notes')) ? $update->notes : false;
		
		if (property_exists($update, 'notes'))
		{
			// figure out if they're coming from a nova 1 installation
			$ver = Jelly::query('system', 1)->select();
			
			// build the version string
			$version = $ver->version_major.$ver->version_minor.$ver->version_update;
			
			// get the directory listing
			$dir = Utility::directory_map(MODFOLDER.'/nova/update/assets', true);
			
			if (is_array($dir))
			{
				// sort the array
				sort($dir);
				
				// make sure we only have the items we absolutely need from the directory listing
				foreach ($dir as $key => $value)
				{
					// make sure the index.html and versions files aren't in the array
					if ($value == 'index.html' or $value == 'versions.php' or $value == 'version.yaml')
					{
						unset($dir[$key]);
					}
					else
					{
						$file = str_replace('_', '', $value);
						
						if ((int) $file < (int) $version)
						{
							unset($dir[$key]);
						}
					}
				}
			}
			else
			{
				// pull in the versions file
				include_once MODPATH.'nova/update/assets/versions'.EXT;
				
				// make sure we're not doing more work than we need to
				foreach ($version_array as $k => $v)
				{
					if ($v < $version)
					{
						unset($version_array[$k]);
					}
				}
			}
			
			// find the markdown library
			$path = Kohana::find_file('vendor', 'markdown/markdown');
			
			// load the markdown library
			Kohana::load($path);
			
			// start the changes array
			$changes = array();
			
			// loop through the final listing and do the updates
			foreach ($dir as $d)
			{
				// reset the content variable
				$content = null;
				
				// load the YAML data into an array
				$content = Markdown(file_get_contents(MODPATH.'nova/update/assets/'.$d.'/changes.md'));
				
				// build the proper version string
				$proper_version = str_replace('_', '.', $d);
				
				// build the changes array
				$changes[$proper_version] = $content;
			}
			
			// pass the changes to the view
			$data->changes = $changes;
			
			// send the version across
			$data->version = $ver->version_major.'.'.$ver->version_minor.'.'.$ver->version_update;
		}
		
		// set the flash message
		$this->template->layout->flash = View::factory(Location::view('flash'));
		$this->template->layout->flash->status = $flash->status;
		$this->template->layout->flash->message = $flash->message;
		
		// content
		$this->template->title.= __('Check for Updates');
		$this->template->layout->label = __('Check for Updates');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	# TODO: uh-oh. there are a whole slew of potential issues here
		# 1 - how do we know if nova 1 is installed and nova 2 isn't?
		# 2 - how do we prevent duplicating the table prefix?
		# 3 - do we overwrite existing tables or create new ones?
			# 3a - what happens if they don't have a whole lot of database space?
	
	public function action_nova1($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// get an instance of the database
		$db = Database::instance();
		
		// get an instance of the session
		$session = Session::instance();
		
		// figure out if the system is installed
		$tables = $db->list_tables($db->table_prefix().'%');
		
		// is installation allowed?
		$allowed = true;
		
		if (Kohana::config('nova.genre') == '')
		{
			// installation not allowed
			$allowed = false;
			
			// show the flash message
			$this->template->layout->flash = View::factory(Location::view('flash'));
			$this->template->layout->flash->status = 'error';
			$this->template->layout->flash->message = __('step.error_no_genre', array(':path' => APPFOLDER.'/config/nova'.EXT));
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('update_nova1_step0'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('nova1_update0.message'));
				
				// content
				$this->template->title.= __('Update to Nova 2');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('update_nova1_step0_js', null, 'js'));
				
				if ($allowed === true)
				{
					// build the next step button
					$next = array(
						'type' => 'submit',
						'class' => 'btn-main',
						'id' => 'next',
					);
					
					// build the next step control
					$this->template->layout->controls = form::button('next', __('Start Update'), $next).form::close();
				}
			break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// get the nova 1 prefix
					$n1pref = trim(Security::xss_clean($_POST['nova1prefix']));
					
					// set the prefix in the session
					$session->set('n1pref', $n1pref);
					
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
				
				// get the number of tables
				$tables = $db->list_tables($db->table_prefix().'%');
				
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('update_nova1_step1'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/update/views/design/images/loading-circle-large.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// content
				$this->template->title.= __('Updating to Nova 2');
				$this->template->layout->label = __('Updating to Nova 2');
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('update_nova1_step1_js', null, 'js'));
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'start',
				);
				
				// build the next step control
				$this->template->layout->controls = (count($tables) < Kohana::config('novasys.app_db_tables'))
					? false 
					: form::button('next', __('Update'), $next).form::close();
			break;
				
			case 2:
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('update_nova1_step2'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// content
				$this->template->title.= __('Update Complete');
				$this->template->layout->label = __('Update Complete');
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('nova1_update2.message'));
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('update_nova1_step2_js', null, 'js'));
				
				// set the loading image
				$data->loading = array(
					'src' => MODFOLDER.'/nova/update/views/design/images/loading-circle-large.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('main/index').form::button('next', __('Go to Your Site'), $next).form::close();
			break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_step($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// figure out if they're coming from a nova 1 installation
		$ver = Jelly::query('system', 1)->select();
		
		// if they're coming from a nova 1 install, send them to the other update page
		if ($ver->version_major == 1)
		{
			$this->request->redirect('update/nova1');
		}
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('update_step0'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('update0.message'));
				
				// content
				$this->template->title.= __('Update Nova');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('update_step0_js', null, 'js'));
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('update/step/1').form::button('next', __('Start Update'), $next).form::close();
			break;
				
			case 1:
				if (isset($_POST['next']))
				{
					// build the version string
					$version = $ver->version_major.$ver->version_minor.$ver->version_update;
					
					// get the directory listing
					$dir = Utility::directory_map(MODFOLDER.'/nova/update/assets', true);
					
					if (is_array($dir))
					{
						// make sure we only have the items we absolutely need from the directory listing
						foreach ($dir as $key => $value)
						{
							// make sure the index.html and versions files aren't in the array
							if ($value == 'index.html' or $value == 'versions.php' or $value == 'version.yaml')
							{
								unset($dir[$key]);
							}
							else
							{
								$file = str_replace('_', '', $value);
								
								if ($file < $version)
								{
									unset($dir[$key]);
								}
							}
						}
					}
					else
					{
						// pull in the versions file
						include_once MODPATH.'nova/update/assets/versions'.EXT;
						
						// make sure we're not doing more work than we need to
						foreach ($version_array as $k => $v)
						{
							if ($v < $version)
							{
								unset($version_array[$k]);
							}
						}
					}
					
					// loop through the final listing and do the updates
					foreach ($dir as $d)
					{
						// make the schema changes
						include_once(MODPATH.'nova/update/assets/'.$d.'/schema'.EXT);
						
						// make the data changes
						include_once(MODPATH.'nova/update/assets/'.$d.'/data'.EXT);
						
						// pause the script for a second
						sleep(1);
					}
					
					// update the system info
					$info = Jelly::factory('system');
					$info->last_update = $system_info['last_update'];
					$info->version_major = $system_info['version_major'];
					$info->version_minor = $system_info['version_minor'];
					$info->version_update = $system_info['version_update'];
					$info->save(1);
					
					// do the registration
					$this->_register();
				}
				
				// create a new content view
				$this->template->layout->content = View::factory(Location::view('update_step1'));
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('update1.message'));
				
				// content
				$this->template->title.= __('Update Nova');
				$this->template->layout->label = __('Finishing Up');
				
				// create the javascript view
				$this->template->javascript = View::factory(Location::view('update_step1_js', null, 'js'));
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('main/index').form::button('next', __('Back to Site'), $next).form::close();
			break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	protected function check_version()
	{
		/**
		 * Severity of udpates:
		 *
		 * 1 - major update (1.0 => 2.0)
		 * 2 - minor update (2.0 => 2.1)
		 * 3 - incremental update (2.0.1 => 2.0.2)
		 * 4 - beta releases
		 */
		 
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
			$content = sfYaml::load(Kohana::config('novasys.version_info'));
			
			// get the system information
			$system = Jelly::query('system', 1)->select();
			
			// get the info config data
			$conf = Kohana::config('novasys');
			
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
				$flash->message = __('check.files_outofdate', array(':files' => $version->files->full, ':db' => $version->db->full));
			}
			elseif (version_compare($version->db->full, $version->files->full, '<'))
			{
				$flash->status = 'info';
				$flash->message = __('check.db_outofdate', array(':files' => $version->files->full, ':db' => $version->db->full));
			}
			elseif (property_exists($update, 'version'))
			{
				$yourversion = __('check.your_version', array(':app' => $conf->app_name, ':version' => $version->files->full));
				$flash->status = 'info';
				$flash->message = __('check.update_available', array(':app' => $conf->app_name, ':version' => $content['version'], ':extra' => $yourversion));
			}
			else
			{
				$flash->status = 'success';
				$flash->message = __('check.no_updates', array(':app' => $conf->app_name));
			}
			
			$retval = array(
				'flash' => $flash,
				'update' => $update
			);
			
			return $retval;
		}
		
		return false;
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
				Kohana::config('novasys.app_name'),
				Kohana::config('novasys.app_version_full'),
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
