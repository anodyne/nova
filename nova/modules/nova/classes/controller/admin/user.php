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
					$password = \Str::random();

					// create the user
					$user = \Model_User::create_item(array(
						'status' 	=> \Status::INACTIVE,
						'name' 		=> \Security::xss_clean(\Input::post('name')),
						'email' 	=> \Security::xss_clean(\Input::post('email')),
						'password'	=> $password,
						'role_id' 	=> \Model_Access_Role::USER,
					));

					// email the user
					\NovaMail::send('', array(
						'to' => array($user->id),
						'subject' => '',
						'content' => array('password' => $password),
					));

					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|user|action.created]]', 1),
					);
				}

				/**
				 * Delete a user.
				 */
				if (\Sentry::user()->has_access('user.delete') and $action == 'delete')
				{
					// get the user
					$user = \Model_User::find(\Security::xss_clean(\Input::post('id')));

					// do the other options that are available when a user is "deleted"

					// update the user
					$user->status = \Status::REMOVED;
					$user->save();

					$this->_flash[] = array(
						'status' => 'success',
						'message' => lang('[[short.flash.success|user|action.deleted]]', 1),
					);
				}

				/**
				 * Link a character to a user account.
				 */
				if (\Sentry::user()->has_level('user.edit', 2) and $action == 'link')
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
