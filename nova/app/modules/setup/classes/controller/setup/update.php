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
	
	public function action_index()
	{
		// find Markdown
		$path = Kohana::find_file('vendor', 'markdown/markdown');
		
		// load Markdown
		Kohana::load($path);
		
		// create a new content view
		$this->template->layout->content = View::factory('components/pages/update/index');
		
		// assign the object a shorter variable to use in the method
		$data = $this->template->layout->content;
		
		// pull the version info from the db
		$ver = Model_System::find('first');
		
		// build the version information
		$version = $ver->version_major.'.'.$ver->version_minor.'.'.$ver->version_update;
		
		// check for updates
		$check = Setup::check_for_updates();
		
		$allow_update = true;
		
		if ($check)
		{
			// pull a map of the update dirs
			$map = Utility::directory_list(MODPATH.'app/modules/setup/assets/update/');
			
			// on some systems, we may not be able to map automatically
			if ( ! is_array($map))
			{
				// pull in the versions file
				include_once MODPATH.'app/modules/setup/assets/versions.php';
				
				// assign the versions to the proper variable
				$map = $versions_array;
			}
			
			// an empty array to prevent exception
			$data->changes = array();
			
			foreach ($map as $key => $loc)
			{
				$location = str_replace('_', '.', $loc);
				
				if (version_compare($location, $version, '>') and version_compare($location, $check->version, '<='))
				{
					$data->changes[$loc] = Markdown(file_get_contents(MODPATH.'app/modules/setup/assets/update/'.$loc.'/changes.md'));
				}
			}
			
			// sort the array of update notes to make sure the newest are first
			krsort($data->changes);
			
			// send the entire object with the details over to the view
			$data->check = $check;
			
			// set the message
			$data->message = false;
		}
		else
		{
			// set the message
			$data->message = "There are no updates available for Nova 3.";
			
			// append to the message under some circumstances
			if (version_compare($version, Kohana::$config->load('nova.app_version_full'), '>'))
			{
				$data->message.= " I have, however, noticed that your files are running an older version of Nova than your database. I'm not sure how that happened, but you'll need to download the files from the Anodyne site again and upload them to your server.";
				
				$allow_update = false;
			}
			elseif (version_compare($version, Kohana::$config->load('nova.app_version_full'), '<'))
			{
				$data->message.= " I have, however, noticed that your files are running a newer version of Nova than your database. You'll need to run the update script in order to complete the update process.";
				
				$allow_update = true;
			}
		}
		
		if ($allow_update)
		{
			// build the next step button
			$next = array(
				'type' => 'submit',
				'class' => 'btn-main',
				'id' => 'next',
			);
			
			// build the next step control
			$this->template->layout->controls = Form::open('setup/update/step').Form::button('next', 'Start Update', $next).Form::close();
		}
		
		// content
		$this->template->title.= 'Check for Updates';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Check for Updates';
	}
	
	public function action_step()
	{
		// make sure the script doesn't time out
		set_time_limit(0);
		
		switch ($this->request->param('id'))
		{
			case 0:
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/update/step0');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/update/step0_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('setup/update/step/1').Form::button('next', 'Start Update', $next).Form::close();
			break;
				
			case 1:
				if (HTTP_Request::POST == $this->request->method())
				{
					// get the system info
					$ver = Model_System::find('first');
					
					// build the version string
					$version = $ver->version_major.$ver->version_minor.$ver->version_update;
					
					// pull a map of the update dirs
					$map = Utility::directory_map(MODPATH.'app/modules/setup/assets/update/');
					
					// on some systems, we may not be able to map automatically
					if ( ! is_array($map))
					{
						// pull in the versions file
						include_once MODPATH.'app/modules/setup/assets/versions.php';
						
						// assign the versions to the proper variable
						$map = $versions_array;
					}
					
					// an array for holding the stuff we're updating
					$updates = array();
					
					foreach ($map as $key => $loc)
					{
						$location = str_replace('_', '.', $loc);
						
						if (version_compare($location, $version, '>') and version_compare($location, $check->version, '<='))
						{
							$updates[] = $loc;
						}
					}
					
					// sort the array to make sure we're doing the updates in the right order
					sort($updates);
					
					// loop through the array and make the changes
					foreach ($updates as $u)
					{
						// do the schema changes
						include_once MODPATH.'app/modules/setup/assets/update/'.$u.'/schema.php';
						
						// do the data changes
						include_once MODPATH.'app/modules/setup/assets/update/'.$u.'/data.php';
						
						// pause
						sleep(1);
					}
					
					// update the system info
					$ver->last_update = $system_info['last_update'];
					$ver->version_major = $system_info['version_major'];
					$ver->version_minor = $system_info['version_minor'];
					$ver->version_update = $system_info['version_update'];
					$ver->save();
					
					// do the registration
					Setup::register('update');
				}
				
				// create a new content view
				$this->template->layout->content = View::factory('components/pages/update/step1');
				
				// create the javascript view
				$this->template->javascript = View::factory('components/js/update/step1_js');
				
				// assign the object a shorter variable to use in the method
				$data = $this->template->layout->content;
				
				// build the next step button
				$next = array(
					'type' => 'submit',
					'class' => 'btn-main',
					'id' => 'next',
				);
				
				// build the next step control
				$this->template->layout->controls = Form::open('main/index').Form::button('next', 'Back to Site', $next).Form::close();
			break;
		}
		
		// content
		$this->template->title.= 'Update Nova';
		$this->template->layout->image = Html::image(MODFOLDER.'/app/modules/setup/views/design/images/wand-24x24.png', array('id' => 'title-image'));
		$this->template->layout->label = 'Update Nova';
	}
}
