<?php
/**
 * Nova's role admin controller.
 *
 * @package		Nova
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova;

class Controller_Admin_Role extends Controller_Base_Admin
{
	public function before()
	{
		parent::before();
		
		$this->template->layout->navsub->menu = false;
	}

	/**
	 * @todo	Create a new role
	 * @todo	Edit an existing role
	 */
	public function action_index($roleID = false)
	{
		\Sentry::allowed('role.update', true);

		$this->_js_view = 'admin/role/roles_js';

		if (\Input::method() == 'POST')
		{
			$action = \Security::xss_clean(\Input::post('action'));

			if (\Security::check_token())
			{
				/**
				 * Delete a role.
				 */
				if ($action == 'delete')
				{
					// Get the id of the role to delete
					$id = \Security::xss_clean(\Input::post('id'));

					// Get the new id to use
					$newRole = \Security::xss_clean(\Input::post('new_role_id'));

					// Get the role
					$role = \Model_Access_Role::find($id);

					// Loop through all the users and update their roles
					foreach ($role->users as $user)
					{
						$user->role_id = $newRole;
						$user->save();
					}

					// Save the role to lock in the user changes
					$role->save();

					// Now delete the role
					$entry = $role->delete();

					if ($entry)
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.delete', langConcat('access role'))),
						);

						# TODO: add system event
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.delete', langConcat('access role'))),
						);
					}
				}

				/**
				 * Duplicate a role into a new role.
				 */
				if ($action == 'duplicate')
				{
					// Get the id and name of the role to duplicate
					$id = \Security::xss_clean(\Input::post('id'));
					$name = \Security::xss_clean(\Input::post('name'));

					// Get the item we're duplicating from
					$original = \Model_Access_Role::find($id);

					// Create a new role
					$entry = \Model_Access_Role::createItem(array(
						'name' 		=> $name,
						'desc' 		=> $original->desc,
						'inherits'	=> $original->inherits,
					), true);

					if (is_object($entry))
					{
						$this->_flash[] = array(
							'status' 	=> 'success',
							'message'	=> ucfirst(lang('short.alert.success.duplicate', langConcat('access role'))),
						);

						# TODO: add system event
					}
					else
					{
						$this->_flash[] = array(
							'status'	=> 'danger',
							'message'	=> ucfirst(lang('short.alert.failure.duplicate', langConcat('access role'))),
						);
					}
				}
			}
			else
			{
				$this->_flash[] = array(
					'status' 	=> 'danger',
					'message' 	=> lang('error.csrf'),
				);
			}
		}

		if ($roleID)
		{
			if ($roleID === 0)
			{
				// create a new role
			}
			else
			{
				// edit the selected role
			}
		}
		else
		{
			$this->_view = 'admin/role/roles';

			// Get all the roles
			$this->_data->roles = \Model_Access_Role::find('all');

			// Manually set the header and title
			$title = ucwords(lang('short.manage', langConcat('access roles')));
			$this->_headers['edit'] = $this->_titles['edit'] = $title;
		}

		return;
	}

	/**
	 * @todo	List all tasks
	 * @todo	Create a new task
	 * @todo	Edit an existing task
	 * @todo	Delete a task
	 */
	public function action_tasks($taskID = false)
	{
		\Sentry::allowed('role.update', true);

		$this->_js_view = 'admin/role/tasks_js';

		if ($taskID)
		{
			if ($taskID === 0)
			{
				// create a new task
			}
			else
			{
				// edit the selected task
			}
		}
		else
		{
			$this->_view = 'admin/role/tasks';

			// Get all the tasks
			$this->_data->tasks = \Model_Access_Task::find('all');

			// Manually set the header, title and message
			$title = ucwords(lang('short.manage', langConcat('access tasks')));
			$this->_headers['tasks'] = $this->_titles['tasks'] = $title;
			$this->_messages['tasks'] = lang('sitecontent.message.roleTasks');
		}

		return;
	}
}
