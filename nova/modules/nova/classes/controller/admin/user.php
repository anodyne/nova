<?php
/**
 * Nova's users admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_User extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}
	
	public function action_index()
	{
		\Sentry::allowed('user.read', true);

		$this->_view = 'admin/user/index';
		$this->_js_view = 'admin/user/index_js';

		if (\Input::method() == 'POST')
		{
			if (\Security::check_token())
			{
				// get the action
				$action = \Security::xss_clean(\Input::post('action'));

				/**
				 * Create a new user.
				 */
				if (\Sentry::user()->hasAccess('user.create') and $action == 'create')
				{
					// generate a password
					$password = \Str::random('alnum', 8);

					// create the user
					$user = \Model_User::createItem(array(
						'status' 	=> \Status::ACTIVE,
						'name' 		=> \Security::xss_clean(\Input::post('name')),
						'email' 	=> \Security::xss_clean(\Input::post('email')),
						'password'	=> $password,
						'role_id' 	=> \Model_Access_Role::ACTIVE,
					), true);

					// email the user
					\NovaMail::send('user_add', array(
						'to' => array($user->id),
						'subject' => lang('email.subject.user.add'),
						'content' => array('message' => lang('[[email.content.user.add|user|{{'.$this->settings->sim_name.'}}|{{'.\Uri::base().'}}|action.login|{{'.$user->name.'}}|{{'.$password.'}}]]')),
					));

					if ($user)
					{
						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|user|action.created]]', 1),
						);
					}
					else
					{
						$this->_flash[] = array(
							'status' => 'danger',
							'message' => lang('[[short.flash.failure|user|action.creation]]', 1),
						);
					}
				}

				/**
				 * Deletes a user. This doesn't actually delete anything since there are
				 * far too many pieces that rely on the character and user records being there.
				 * Instead, this simply sets the user to a status that makes sure it's never
				 * pulled back. It also goes through and "removes" the characters as well.
				 */
				if (\Sentry::user()->hasAccess('user.delete') and $action == 'delete')
				{
					// get the user
					$user = \Model_User::find(\Security::xss_clean(\Input::post('id')));

					// update the user
					$user->role_id = \Model_Access_Role::INACTIVE;
					$user->status = \Status::REMOVED;
					$user->leave_date = \Carbon::now('UTC')->toDateTimeString();
					$user->save();

					// deactivate all characters associated with the user
					if (count($user->characters) > 0)
					{
						foreach ($user->characters as $c)
						{
							$c->status = \Status::REMOVED;
							$c->save();
						}
					}

					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|user|action.deleted]]', 1),
					);
				}

				/**
				 * Link a character to a user account.
				 */
				if (\Sentry::user()->hasLevel('user.update', 2) and $action == 'link')
				{
					# code...
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' => 'danger',
					'message' => lang('error.csrf'),
				);
			}
		}

		// get all the users
		$this->_data->active = \Model_User::getItems();

		return;
	}

	public function action_edit($id)
	{
		\Sentry::allowed('user.update', true);

		$this->_view = 'admin/user/edit';
		$this->_js_view = 'admin/user/edit_js';

		// sanitize the input
		\Security::xss_clean($id);

		if (\Sentry::user()->hasLevel('user.update', 2) or 
				(\Sentry::user()->hasLevel('user.update', 1) and \Sentry::user()->id === $id))
		{
			if (\Input::method() == 'POST')
			{
				if (\Security::check_token())
				{
					// get the action
					$action = \Security::xss_clean(\Input::post('action'));

					/**
					 * Update the basic user information.
					 */
					if ($action == 'basic')
					{
						// make sure we hash the password if it's being reset
						if (\Input::post('basic.password', false) !== false)
						{
							$_POST['basic']['password'] = \Sentry_User::passwordGenerate(\Security::xss_clean(\Input::post('basic.password')));
						}

						// update the user
						\Model_User::updateItem($id, \Input::post('basic'));

						// clear some of the POST variables
						unset($_POST['action']);
						unset($_POST['basic']);
						unset($_POST[\Config::get('security.csrf_token_key')]);

						// update the user form
						\Model_Form_Data::updateData('user', $id, \Input::post());

						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|user info|action.updated]]', 1),
						);
					}

					/**
					 * Update the user preferences.
					 */
					if ($action == 'preferences')
					{
						// clear some of the POST variables
						unset($_POST['action']);
						unset($_POST[\Config::get('security.csrf_token_key')]);

						// update the preferences
						\Model_User_Preferences::updateUserPreferences($id, \Input::post());

						$this->_flash[] = array(
							'status' => 'success',
							'message' => lang('[[short.flash.success|user preferences|action.updated]]', 1),
						);
					}
				}
				else
				{
					$this->_flash[] = array(
						'status' => 'danger',
						'message' => lang('error.csrf'),
					);
				}
			}

			// get the user
			$this->_data->user = $user = \Model_User::find($id);

			// get the user preferences
			$this->_data->prefs = $prefs = $user->getPreferences();

			// get the user form
			$this->_data->userForm = \NovaForm::build('user', $this->skin, $id);

			// get the rank catalog items
			$ranks = \Model_Catalog_Rank::getItems(false);

			// loop through the ranks and build the array for the dropdown
			foreach ($ranks as $r)
			{
				if ($r->status == \Status::ACTIVE)
				{
					$this->_data->ranks[$r->location] = $r->name;
				}
			}

			// manually set the header
			$this->_headers['edit'] = lang('action.edit user', 2).' &ndash; '.$user->name;

			// manually set the title
			$this->_titles['edit'] = lang('action.edit user', 2);

			// send the genre to the JS view
			$this->_js_data->genre = $this->genre;
		}
		else
		{
			\Response::redirect('admin/error/'.\Nova\Controller_Admin::NOT_ALLOWED);
		}
	}
}
