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
							\Form::close();
					}
				}
			break;
			
			case 1:
				if (\Input::method() == 'POST')
				{
					// do the install
					Setup::install();
				}
				
				$this->_view = 'install/step1';
				$this->_js_view = 'install/step1_js';
				
				// get the number of tables
				$tables = \DB::list_tables(\DB::table_prefix().'%');
				
				// make sure the proper message is displayed
				$this->_data->message = ((count($tables) != \Config::get('nova.base_install_tables')) 
					? __('setup.install.step1.failure') 
					: __('setup.install.step1.success'));
				
				// get the default rank object
				$catalog = \Model_Catalog_Rank::get_default();
				
				// pull the rank record
				$rank = \Model_Rank::find('first');

				// find the image and build it
				$this->_data->default_rank = \Location::rank($catalog->location, 
					$rank->image, 
					$catalog->extension, 
					'image', 
					array('class' => 'image', 'alt' => ''));
				
				// make sure the base install is there
				if (count($tables) == \Config::get('nova.base_install_tables'))
				{
					$this->_data->allowed = true;
					$this->_data->message = __('setup.install.step1.success');
					$this->_data->controls = \Form::button('next', 'Next Step', array('class' => 'btn', 'type' => 'submit', 'id' => 'next')).
						\Form::close();
				}
				else
				{
					// this ensures the form isn't shown
					$this->_data->allowed = false;
					
					// change the message, controls, and header
					$this->_data->message = __('setup.install.step1.failure');
					$this->_data->controls = '<a href="'.\Uri::create('setup/main/index').'" class="pull-right muted">Back to the Setup Center</a>';
					$this->_data->header->text = 'Install Failed';
					$this->_data->header->image = 'cross-24x24.png';
					
					// make sure the steps "gems" aren't shown
					$this->template->layout->steps = false;
				}
			break;

			case 2:
				if (\Input::method() == 'POST')
				{
					// get the data
					$simname = trim(\Security::xss_clean($_POST['sim_name']));
					$name = trim(\Security::xss_clean($_POST['name']));
					$email = trim(\Security::xss_clean($_POST['email']));
					$password = trim(\Security::xss_clean($_POST['password']));
					$first_name = trim(\Security::xss_clean($_POST['first_name']));
					$last_name = trim(\Security::xss_clean($_POST['last_name']));
					$position = trim(\Security::xss_clean($_POST['position']));
					$rank = trim(\Security::xss_clean($_POST['rank']));
					
					// update the settings
					\Model_Settings::update_settings(array(
						'sim_name' => $simname,
						'email_subject' => '['.$simname.']',
						'email_address' => 'nova@'.\Uri::base(false),
						'email_name' => $simname,
					));
					
					// create the user
					$crUser = \Model_User::create_user(array(
						'name' => $name,
						'email' => $email,
						'password' => \Sentry_User::password_generate($password),
						'role_id' => \Model_Access_Role::SYSADMIN,
						'join_date' => time(),
					));

					// update the user prefs
					\Model_User_Preferences::update_user_preferences($crUser->id, array(
						'is_sysadmin' => (int) true,
						'is_game_master' => (int) true,
					));
					
					// create the character
					$crCharacter = \Model_Character::create_character(array(
						'user_id' => $crUser->id,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'rank_id' => $rank,
						'status' => 'active',
						'activated' => time(),
					));

					// create the position record
					\Model_Character_Positions::create_item(array(
						'position_id' => $position,
						'character_id' => $crCharacter->id,
						'primary' => (int) true
					));
					
					// update the user with the character info
					\Model_User::update_user($crUser->id, array(
						'character_id' => $crCharacter->id
					));
					
					// do the registration
					Setup::register('install');

					// create an event
					\SystemEvent::add(false, __('event.setup.installed', array('version' => \Config::get('nova.app_version_full'))));
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
