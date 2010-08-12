<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Update Controller
 *
 * @package		Update
 * @category	Controllers
 * @author		Anodyne Productions
 */

# TODO: uncomment $this->_register

class Controller_Update extends Controller_Template
{
	/**
	 * @var	integer	the number of database tables in the system
	 */
	public $_tables = 57;
	
	public function before()
	{
		parent::before();
		
		// make sure the database config file exists
		if (!file_exists(APPPATH.'config/database'.EXT))
		{
			$this->request->redirect('install/setupconfig');
		}
		else
		{
			// make sure the system is installed
			if (count(Database::instance()->list_tables()) < $this->_tables)
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
		$this->template = View::factory('_common/layouts/update');
		
		// set the variables in the template
		$this->template->title 					= 'Nova :: ';
		$this->template->javascript				= FALSE;
		$this->template->layout					= View::factory('update/template_update');
		$this->template->layout->label			= FALSE;
		$this->template->layout->flash_message	= FALSE;
		$this->template->layout->controls		= FALSE;
		$this->template->layout->controls_text	= FALSE;
	}
	
	public function action_index()
	{
		// create a new content view
		$this->template->layout->content = View::factory('update/pages/update_index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('Update Center');
		$this->template->layout->label = __('Update Center');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_check()
	{
		// create a new content view
		$this->template->layout->content = View::factory('update/pages/update_check');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// content
		$this->template->title.= __('Check for Updates');
		$this->template->layout->label = __('Check for Updates');
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_nova1($step = 0)
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// get the version info
		$ver = Jelly::query('system', 1)->select();
		
		switch ($step)
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('update/pages/update_nova1_step0');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('nova1_update0.message', array(':nova1' => $ver->version_major.'.'.$ver->version_minor.'.'.$ver->version_update)));
				
				// content
				$this->template->title.= __('Update From Nova 1');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory('update/js/update_nova1_step0_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('update/step/1').form::button('next', __('Start Update'), $next).form::close();
				$this->template->layout->controls_text = __("Run the Nova update to get the latest and greatest");
				
				break;
				
			case 1:
				// grab the version info from the db and build the version string
				$ver = Jelly::query('system', 1)->select();
				
				// build the version string
				$version = $ver->version_major.$ver->version_minor.$ver->version_update;
				
				// get the directory listing
				$dir = Utility::directory_map(MODFOLDER.'/nova/update/assets', TRUE);
				
				if (is_array($dir))
				{
					// make sure we only have the items we absolutely need from the directory listing
					foreach ($dir as $key => $value)
					{
						// make sure the index.html and versions files aren't in the array
						if ($value == 'index.html' || $value == 'versions.php')
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
				$this->template->layout->content = View::factory('update/pages/update_step0');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// make sure the proper message is displayed
				$data->message = nl2br(__('update0.message'));
				
				// content
				$this->template->title.= __('Update Nova');
				$this->template->layout->label = __('Getting Started');
				
				// create the javascript view
				$this->template->javascript = View::factory('update/js/update_step0_js');
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = form::open('update/step/1').form::button('next', __('Start Update'), $next).form::close();
				$this->template->layout->controls_text = __("Run the Nova update to get the latest changes and fixes");
				
				break;
				
			case 1:
				// grab the version info from the db and build the version string
				$ver = Jelly::query('system', 1)->select();
				
				// build the version string
				$version = $ver->version_major.$ver->version_minor.$ver->version_update;
				
				// get the directory listing
				$dir = Utility::directory_map(MODFOLDER.'/nova/update/assets', TRUE);
				
				if (is_array($dir))
				{
					// make sure we only have the items we absolutely need from the directory listing
					foreach ($dir as $key => $value)
					{
						// make sure the index.html and versions files aren't in the array
						if ($value == 'index.html' || $value == 'versions.php')
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
				
				break;
		}
		
		// send the response
		$this->request->response = $this->template;
	}
	
	public function action_test()
	{
		// get the system information
		$system = Jelly::query('system', 1)->select();
		
		// get the info config data
		$conf = Kohana::config('info');
		
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
		
		echo Kohana::debug($version);
		exit();
	}
	
	protected function check_version()
	{
		/**
		 * Types of udpates:
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
			if (!in_array('sfYaml', $classes))
			{
				// find the sfYAML library
				$path = Kohana::find_file('vendor', 'sfYaml/sfYaml');
				
				// load the sfYAML library
				Kohana::load($path);
			}
			
			// load the YAML data into an array
			$content = sfYaml::load(Kohana::config('info.version_info'));
			
			// get the system information
			$system = Jelly::query('system', 1)->select();
			
			// get the update settings
			$upd = Jelly::query('setting')->key('updates')->select();
			
			// get the info config data
			$conf = Kohana::config('info');
			
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
			
			// make sure the severity lines up with what the user wants to be notified of
			if ($upd <= $content['severity'])
			{
				if (version_compare($version->files->full, $content['version'], '<') || version_compare($version->db->full, $content['version'], '<'))
				{
					$update->version	= $content['version'];
					$update->notes		= $content['notes'];
					$update->severity	= $content['severity'];
					$update->link 		= $content['link'];
				}
				
				if (version_compare($version->db->full, $version->files->full, '>'))
				{
					$flash->status = 'info';
					$flash->message = sprintf(
						lang('update_outofdate_files'),
						$version->files->full,
						$version->db->full
					);
				}
				elseif (version_compare($version->db->full, $version->files->full, '<'))
				{
					$flash['status'] = 'info';
					$flash['message'] = sprintf(
						lang('update_outofdate_database'),
						$version->db->full,
						$version->files->full
					);
				}
				elseif ($update !== FALSE)
				{
					$yourversion = sprintf(
						lang('update_your_version'),
						$conf->app_name,
						$version->files->full);
						
					$flash['status'] = 'info';
					$flash['message'] = sprintf(
						lang('update_available'),
						$conf->app_name,
						$update->version,
						$yourversion
					);
				}
				else
				{
					$flash->status = '';
					$flash->message = '';
				}
				
				$retval = array(
					'flash' => $flash,
					'update' => $update
				);
				
				return $retval;
			}
			
			return FALSE;
		}
		
		return FALSE;
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
				$this->db->platform(),
				$this->db->version(),
				'upgrade',
				Kohana::config('nova.genre'),
			);
			
			$insert = "INSERT INTO www_installs (product, version, url, ip_client, ip_server, php, db_platform, db_version, type, date, genre) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %d, %s);";
			
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
				$db->escape($request[8]),
				$db->escape($request[9]),
				$db->escape(date::now())
			);
			
			// send the email
			$email = email::install_register($data);
		}
	}
}