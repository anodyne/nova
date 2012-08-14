<?php
/**
 * Upgrade Controller
 *
 * @package		Nova
 * @subpackage	Setup
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Setup;

class Controller_Upgrade extends Controller_Base_Setup
{
	public function before()
	{
		parent::before();

		$this->template->layout->steps = \View::forge('setup::components/partials/setup_upgrade');
	}
	
	public function action_index($step = 0)
	{
		$this->_data->title = 'Upgrade to Nova 3';
		$this->_data->header = new \stdClass;
		$this->_data->header->text = 'Upgrade to Nova 3';
		$this->_data->header->image = 'wand-24x24.png';
		$this->_data->controls = '<a href="'.\Uri::create('setup/main').'" class="muted pull-right">Back to Setup Center</a>';

		// make sure the script doesn't time out
		set_time_limit(0);
		
		// is installation allowed?
		$allowed = true;
		
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
				$this->_view = 'upgrade/step0';
				$this->_js_view = 'upgrade/step0_js';

				if ($allowed)
				{
					$this->_data->controls.= \Form::open('setup/upgrade/index/1').
						\Form::button('next', 'Start Upgrade', array(
							'type' => 'submit',
							'class' => 'btn',
							'id' => 'next')
						).
						\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
						\Form::close();
				}
			break;
			
			case 1:
				$this->_view = 'upgrade/step1';
				$this->_js_view = 'upgrade/step1_js';

				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// get the tables that are part of nova
						$tables = \DB::list_tables(\DB::table_prefix().'%');
						
						if (count($tables) > 0)
						{
							// loop through all the tables and rename them with a nova2_ prefix
							foreach ($tables as $table)
							{
								// set the new table name
								$newtable = '`nova2_'.str_replace(\DB::table_prefix(), '', $table).'`';
								
								// run the query
								\DB::query("ALTER TABLE `".$table."` RENAME TO ".$newtable)->execute();
							}
						}
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.csrf'),
						);
					}

					$this->_data->controls = \Form::open('setup/upgrade/index/2').
						\Form::button('next', 'Continue Upgrade', array(
							'type' => 'submit',
							'class' => 'btn',
							'id' => 'next')
						).
						\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
						\Form::close();
				}
			break;
				
			case 2:
				$this->_view = 'upgrade/step2';
				$this->_js_view = 'upgrade/step2_js';

				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// do the install
						Setup::migration_install();
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('error.csrf'),
						);
					}
				}
				
				// get the number of tables
				$tables = \DB::list_tables(\DB::table_prefix().'%');
				
				// set the loading image
				$this->_data->loading = array(
					'src' => 'nova/modules/setup/views/design/images/loading.gif',
					'attr' => array(
						'class' => 'image'),
				);
				
				// build the next step control
				$this->_data->controls = (count($tables) < \Config::get('nova.app_db_tables'))
					? false 
					: \Form::button('next', 'Upgrade', array('type' => 'submit', 'class' => 'btn', 'id' => 'start')).
						\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
						\Form::close();
			break;

			case 3:
				$this->_view = 'upgrade/step3';
				$this->_js_view = 'upgrade/step3_js';

				if (\Input::method() == 'POST')
				{
					if (\Security::check_token())
					{
						// do the registration
						Setup::register('upgrade');

						// create an event
						\SystemEvent::add(false, __('event.setup.upgraded', array(
							'product' => \Config::get('nova.app_name'),
							'version' => \Config::get('nova.app_version_full')
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
				
				// set the images
				$this->_data->image = array(
					'loading' => array(
						'src' => 'nova/modules/setup/views/design/images/loading.gif',
						'attr' => array('class' => 'image')
					),
					'success' => array(
						'src' => 'nova/modules/setup/views/design/images/tick-circle.png',
						'attr' => array('class' => 'image')
					),
					'failure' => array(
						'src' => 'nova/modules/setup/views/design/images/exclamation-red.png',
						'attr' => array('class' => 'image')
					),
				);

				// get all the users
				$users = \Model_User::find('all');

				// start with an empty array for the users
				$this->_data->users = array();

				if (count($users) > 0)
				{
					foreach ($users as $u)
					{
						if ($u->status == 'active')
						{
							$user_array[$u->id] = $u->name.' ('.$u->email.')';
						}
					}

					// update the list of users
					$this->_data->users = $user_array;
				}
				
				// build the next step control
				$this->_data->controls = \Form::button('next', 'Submit', array(
						'type' => 'submit',
						'class' => 'btn',
						'id' => 'start')
					).
					\Form::hidden(\Config::get('security.csrf_token_key'), \Security::fetch_token()).
					\Form::close();
			break;
				
			case 4:
				$this->_view = 'upgrade/step4';

				// build the control
				$this->_data->controls = '<a href="'.\Uri::create('main/index').'" class="btn">Go to your site now</a>';
			break;
		}
		
		return;
	}
}
