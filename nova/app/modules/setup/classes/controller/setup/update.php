<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Update Controller
 *
 * @package		Setup
 * @category	Controllers
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

# TODO: remove the environment check around the login redirect

class Controller_Setup_Update extends Controller_Template {
	
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
			// you need to be logged in for these pages
			$protectedsegs = array('check', 'step');
			
			// get an instance of the database
			$db = Database::instance();
			
			// get the number of tables
			$tables = Kohana::$config->load('nova.app_db_tables');
			
			// make sure the system is installed
			if (count($db->list_tables($db->table_prefix().'%')) < $tables)
			{
				$this->request->redirect('setup/main/index');
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
						if ( ! $sysadmin)
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
		}
		
		// set the locale
		I18n::lang('en-us');
		
		// set the shell
		$this->template = View::factory(Location::file('setup', null, 'structure'));
		
		// set the variables in the template
		$this->template->title 				= Kohana::$config->load('nova.app_name').' :: ';
		$this->template->javascript			= false;
		$this->template->layout				= View::factory(Location::file('setup', null, 'templates'));
		$this->template->layout->label		= false;
		$this->template->layout->flash		= false;
		$this->template->layout->controls	= false;
		$this->template->layout->content	= false;
		$this->template->layout->steps		= View::factory(Location::file('setup_update', null, 'partials'));
	}
	
	public function after()
	{
		parent::after();
		
		// send the response
		$this->response->body($this->template);
	}
	
	public function action_check()
	{
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/update/check');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// check for updates
		$check = Setup::check_for_updates();
		
		if ($check)
		{
			// pull the version info from the db
			$ver = Model_System::find('first');
			
			// build the version information
			$version = $ver->version_major.'.'.$ver->version_minor.'.'.$ver->version_update;
			
			// pull a map of the update dirs
			$map = Utility::directory_map(MODPATH.'app/modules/setup/assets/update/', true);
			
			foreach ($map as $key => $loc)
			{
				$location = str_replace('_', '.', $loc);
				
				if (version_compare($location, $version, '>') and version_compare($location, $check->version, '<='))
				{
					$updates[] = $loc;
				}
			}
			
			// send the entire object with the details over to the view
			$data->check = $check;
			
			// set the message
			$data->message = false;
		}
		else
		{
			// set the message
			$data->message = "There are no updates available for Nova 3.";
		}
		
		// content
		$this->template->title.= 'Check for Updates';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Check for Updates';
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
}
