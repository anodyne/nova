<?php
/**
 * The update controller for the setup module is where Nova checks for
 * updates to itself and executes those updates.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Update extends Controller_Base_Setup
{
	public function before()
	{
		parent::before();

		$this->template->layout->steps = ($this->request->action == 'step')
			? \View::forge('setup::components/partials/setup_update')
			: false;
	}

	public function action_index()
	{
		$this->_view = 'update/index';
		$this->_js_view = 'update/index_js';
		
		$this->_data->title = 'Check for Updates';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Check for Updates';
		$this->_data->header->image = 'arrow-circle-double-135-24x24.png';
		$this->_data->controls = '<a href="'.\Uri::create('setup/main').'" class="muted pull-right">Back to Setup Center</a>';

		// check for updates
		$check = \Utility::getUpdates();

		// get the version from the database
		$sys = \Model_System::find('first');

		// build the version string
		$version = $sys->version_major.'.'.$sys->version_minor.'.'.$sys->version_update;
		
		// is the update allowed?
		$allowed = true;
		
		if ($check)
		{
			// pull a map of the update dirs
			$map = \File::read_dir(NOVAPATH.'setup/assets/update');
			
			// on some systems, we may not be able to map automatically
			if ( ! is_array($map))
			{
				// pull in the versions file
				include NOVAPATH.'setup/assets/versions.php';
				
				// assign the versions to the proper variable
				$map = $versions_array;
			}
			
			// an empty array to prevent exception
			$this->_data->changes = array();

			foreach ($map as $key => $loc)
			{
				if (is_array($loc))
				{
					// make sure we have a proper string for the path
					$location = str_replace('_', '.', $key);

					// make sure the key doesn't have a trailing slash
					$key = ( ! is_numeric(substr($key, -1))) ? substr($key, 0, -1) : $key;

					// check the version info and print the changes if there are any
					if (version_compare($location, $version, '>') and version_compare($location, $check->version, '<='))
					{
						$this->_data->changes[$key] = \Markdown::parse(file_get_contents(NOVAPATH.'setup/assets/update/'.$key.'/changes.md'));
					}
				}
			}
			
			// sort the array of update notes to make sure the newest are first
			krsort($this->_data->changes);
			
			// send the entire object with the details over to the view
			$this->_data->check = $check;
			
			// set the message
			$this->_data->message = false;
		}
		else
		{
			// set the message
			$this->_data->message = "There are no updates available for Nova 3.";
			
			// append to the message under some circumstances
			if (version_compare($version, \Config::get('nova.app_version_full'), '>'))
			{
				$this->_data->message.= " I have, however, noticed that your files are running an older version of Nova than your database. I'm not sure how that happened, but you'll need to download the files from the Anodyne site again and upload them to your server.";
				
				$allowed = false;
			}
			elseif (version_compare($version, \Config::get('nova.app_version_full'), '<'))
			{
				$this->_data->message.= " I have, however, noticed that your files are running a newer version of Nova than your database. You'll need to run the update script in order to complete the update process.";
				
				$allowed = true;
			}
		}
		
		if ($allowed === true)
		{
			$this->_data->controls.= '<a href="'.\Uri::create('setup/update/step').'" class="btn" id="next">Start Update</a>';
		}

		return;
	}
	
	public function action_step($id = 0)
	{
		$this->_view = 'update/step0';
		$this->_js_view = 'update/step0_js';
		
		$this->_data->title = 'Update Nova';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Update Nova';
		$this->_data->header->image = 'arrow-circle-double-135-24x24.png';

		// make sure the script doesn't time out
		set_time_limit(0);

		// check for updates
		$check = \Utility::getUpdates();
		
		switch ($id)
		{
			case 0:
				$this->_data->controls = \Form::open('setup/update/step/1').
					\Form::button('next', 'Start Update', array('type' => 'submit', 'class' => 'btn', 'id' => 'next')).
					\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
					\Form::close();
			break;
				
			case 1:
				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// get the system info
						$ver = \Model_System::find('first');
						
						// build the version string
						$version = $ver->version_major.$ver->version_minor.$ver->version_update;
						
						// pull a map of the update dirs
						$map = \File::read_dir(NOVAPATH.'setup/assets/update');
						
						// on some systems, we may not be able to map automatically
						if ( ! is_array($map))
						{
							// pull in the versions file
							include NOVAPATH.'setup/assets/versions.php';
							
							// assign the versions to the proper variable
							$map = $versions_array;
						}
						
						// an array for holding the stuff we're updating
						$updates = array();

						foreach ($map as $key => $loc)
						{
							if (is_array($loc))
							{
								// make sure we have a proper string for the path
								$location = str_replace('_', '.', $key);

								// make sure the key doesn't have a trailing slash
								$key = ( ! is_numeric(substr($key, -1))) ? substr($key, 0, -1) : $key;

								// check the version info and print the changes if there are any
								if (version_compare($location, $version, '>') and version_compare($location, $check->version, '<='))
								{
									$updates[] = $key;
								}
							}
						}
						
						// sort the array to make sure we're doing the updates in the right order
						sort($updates);
						
						// loop through the array and make the changes
						foreach ($updates as $u)
						{
							// do the schema changes
							include NOVAPATH.'setup/assets/update/'.$u.'/schema.php';
							
							// do the data changes
							include NOVAPATH.'setup/assets/update/'.$u.'/data.php';
							
							// pause
							sleep(2);
						}
						
						// update the system info
						$ver->last_update = $system_info['last_update'];
						$ver->version_major = $system_info['version_major'];
						$ver->version_minor = $system_info['version_minor'];
						$ver->version_update = $system_info['version_update'];
						$ver->save();
						
						// do the registration
						Setup::register('update');

						// create an event
						\SystemEvent::add(false, __('event.setup.updated', array(
							'version' => $system_info['version_major'].'.'.$system_info['version_minor'].'.'.$system_info['version_update']
						)));
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.csrf'),
						);
					}
				}

				// set the view files
				$this->_view = 'update/step1';
				$this->_js_view = 'update/step1_js';

				// set the controls
				$this->_data->controls = '<a href="'.\Uri::create('main/index').'" class="btn">Back to Site</a>';
			break;
		}
		
		return;
	}
}
