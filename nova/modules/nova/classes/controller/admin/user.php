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
				if (\Sentry::user()->has_access('user.create') and $action == 'create')
				{
					// generate a password for the user
					$password = \Str::random('alnum', 8);

					// create the user
					$user = \Model_User::create_item(array(
						'status' 	=> \Status::ACTIVE,
						'name' 		=> \Security::xss_clean(\Input::post('name')),
						'email' 	=> \Security::xss_clean(\Input::post('email')),
						'password'	=> $password,
						'role_id' 	=> \Model_Access_Role::ACTIVE,
					), true);

					// email the user
					\NovaMail::send('user_add', array(
						'to' => array($user->id),
						'subject' => '',
						'content' => array('message' => lang('[[email.content.user.add|user|{{'.$this->options->sim_name.'}}|{{'.\Uri::base().'}}|action.login|{{'.$user->name.'}}|{{'.$password.'}}]]')),
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
				if (\Sentry::user()->has_access('user.delete') and $action == 'delete')
				{
					// get the user
					$user = \Model_User::find(\Security::xss_clean(\Input::post('id')));

					// update the user
					$user->role_id = \Model_Access_Role::INACTIVE;
					$user->status = \Status::REMOVED;
					$user->leave_date = time();
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
				if (\Sentry::user()->has_level('user.update', 2) and $action == 'link')
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
		$this->_data->active = \Model_User::find_users();

		return;
	}
}
