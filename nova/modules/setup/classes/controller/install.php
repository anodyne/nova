<?php
/**
 * The install controller handles the front end of installing Nova into
 * the database.
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Install extends Controller_Base_Setup
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->steps = \View::forge('setup::components/partials/setup_install');
	}
	
	/**
	 * The steps for installing Nova.
	 *
	 * @param 	int 	the step number (default: 0)
	 * @return 	void
	 */
	public function action_index($step = 0)
	{
		$this->_view = 'install/step0';
		$this->_js_view = 'install/step0_js';
		
		$this->_data->title = 'Install Nova 3';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Install Nova 3';
		$this->_data->header->image = 'wand-24x24.png';
		$this->_data->controls = false;
		
		// make sure the script doesn't time out
		set_time_limit(0);
		
		// can we install nova?
		$allowed = true;

		// set the loading image
		$this->_data->loading = \Html::img('nova/modules/setup/views/design/images/loading.gif', array('class' => 'image', 'alt' => ''));
		
		if (\Config::get('nova.genre') == '')
		{
			// installation not allowed
			$allowed = false;

			// assign the flash content
			$this->_flash[] = array(
				'status' => 'danger',
				'message' => __('setup.error.no_genre'),
			);
		}
		
		switch ($step)
		{
			case 0:
			default:
				$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to Setup Center</a>';

				// get the prefix
				$prefix = \DB::table_prefix();

				/**
				 * If we actually get something back here, it means there's a copy of Nova
				 * (like Nova 2), in the database. Until the user changes the database prefix,
				 * they can't install the system.
				 */
				try {
					// get the information from the database
					$version = \DB::query("SELECT * FROM ${prefix}system_info WHERE sys_id = 1")
						->as_object()
						->execute()
						->current()
						->sys_version_major;

					// not allowed!
					$allowed = false;

					// assign the flash content
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => __('setup.error.install_tables_exist', array('prefix' => $prefix)),
					);
				}
				catch (\Database_Exception $e)
				{
					$allowed = true;

					if ($allowed)
					{
						$this->_data->controls.= \Form::open('setup/install/index/1').
							\Form::button('next', 'Start Install', array('class' => 'btn', 'type' => 'submit', 'id' => 'next')).
							\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
							\Form::close();
					}
				}
			break;
			
			case 1:
				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// do the install
						Setup::install();
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.csrf'),
						);
					}
				}
				
				$this->_view = 'install/step1';
				$this->_js_view = 'install/step1_js';
				
				// pull the rank record
				$rank = \Model_Rank::find('first');

				// build the image
				$this->_data->defaultRank = \Location::rank($rank->base, $rank->pip);
				
				$this->_data->allowed = true;
				$this->_data->message = __('setup.install.step1.success');
				$this->_data->controls = \Form::button('next', 'Next Step', array('class' => 'btn', 'type' => 'submit', 'id' => 'next')).
					\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
					\Form::close();
			break;

			case 2:
				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// get the data
						$simname 	= \Security::xss_clean(\Input::post('sim_name'));
						$name 		= \Security::xss_clean(\Input::post('name'));
						$email 		= \Security::xss_clean(\Input::post('email'));
						$password 	= \Security::xss_clean(\Input::post('password'));
						$first_name	= \Security::xss_clean(\Input::post('first_name'));
						$last_name	= \Security::xss_clean(\Input::post('last_name'));
						$position 	= \Security::xss_clean(\Input::post('position'));
						$rank 		= \Security::xss_clean(\Input::post('rank'));
						
						// update the settings
						\Model_Settings::updateItems(array(
							'sim_name' => $simname,
							'email_subject' => '['.$simname.']',
							'email_address' => 'nova@'.$_SERVER['HTTP_HOST'],
							'email_name' => $simname,
						));
						
						// create the user
						$crUser = \Model_User::createItem(array(
							'name' => $name,
							'email' => $email,
							'password' => $password,
							'role_id' => \Model_Access_Role::SYSADMIN,
							'status' => \Status::ACTIVE
						), true);

						// update the user prefs
						\Model_User_Preferences::updateUserPreferences($crUser->id, array(
							'is_sysadmin' => (int) true,
							'is_game_master' => (int) true,
						));
						
						// create the character
						$crCharacter = \Model_Character::createItem(array(
							'user_id' => $crUser->id,
							'first_name' => $first_name,
							'last_name' => $last_name,
							'rank_id' => $rank,
							'status' => \Status::ACTIVE,
							'activated' => \Carbon::now('UTC')->toDateTimeString(),
						), true);

						// create the position record
						\Model_Character_Positions::createItem(array(
							'position_id' => $position,
							'character_id' => $crCharacter->id,
							'primary' => (int) true
						));

						// update the position's open slots
						\Model_Position::find($position)->updateAvailability('add');
						
						// update the user with the character info
						\Model_User::updateUser($crUser->id, array(
							'character_id' => $crCharacter->id
						));
						
						// do the registration
						Setup::register('install');

						// create an event
						\SystemEvent::add(false, '[[event.setup.installed|{{'.\Config::get('nova.app_name').'}}|{{'.\Config::get('nova.app_version_full').'}}]]');
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.csrf'),
						);
					}
				}

				$this->_view = 'install/step2';
				$this->_js_view = 'install/step2_js';

				// set the control
				$this->_data->controls = '<a href="'.\Uri::create('main/index').'" class="btn" id="next">Finish</a>';
			break;
		}
		
		return;
	}
}
