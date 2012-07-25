<?php
/**
 * Part of the Sentry package for FuelPHP.
 *
 * @package    Sentry
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    MIT License
 * @copyright  2011 Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Sentry;

use ArrayAccess;
use Config;
use DB;
use FuelException;
use Iterator;
use Lang;
use Str;

class SentryUserException extends \FuelException {}
class SentryUserNotFoundException extends \SentryUserException {}

/**
 * Sentry Auth User Class
 *
 * @package  Sentry
 * @author   Daniel Petrie
 */
class Sentry_User implements Iterator, ArrayAccess
{
	/**
	 * @var  string  Database instance
	 */
	protected $db_instance = null;

	/**
	 * @var  array  User
	 */
	protected $user = array();

	/**
	 * @var  array  Groups
	 */
	protected $groups = array();

	/**
	 * @var  string  Table name
	 */
	protected $table = null;

	/**
	 * @var  string  User metadata table
	 */
	protected $table_metadata = null;

	/**
	 * @var  string  User groups table
	 */
	protected $table_usergroups = null;

	/**
	 * @var  string  Login column
	 */
	protected $login_column = null;

	/**
	 * @var  string  Login column string (formatted)
	 */
	protected $login_column_str = '';

	/**
	 * Loads in the user object
	 *
	 * @param   int|string  User id or Login Column value
	 * @return  void
	 * @throws  SentryUserNotFoundException
	 */
	public function __construct($id = null, $check_exists = false)
	{
		// load and set config
		$this->login_column = strtolower(\Config::get('sentry.login_column'));
		$this->login_column_str = ucfirst($this->login_column);
		$_db_instance = trim(\Config::get('sentry.db_instance'));

		// db_instance check
		if ( ! empty($_db_instance) )
		{
			$this->db_instance = $_db_instance;
		}

		// if an ID was passed
		if ($id)
		{
			// make sure ID is valid
			if (is_int($id))
			{
				if ($id <= 0)
				{
					throw new \SentryUserException(__('sentry.invalid_user_id'));
				}

				// set field to id for query
				$field = 'id';
			}
			// if ID is not an integer
			else
			{
				// set field to login_column
				$field = $this->login_column;
			}
			
			// get the user
			$user = \Model_User::get_user($field, $id);

			// if there was a result - update user
			if (count($user))
			{
				// if just a user exists check - return true, no need for additional queries
				if ($check_exists)
				{
					return true;
				}
				
				$this->user = $user;
			}
			// user doesn't exist
			else
			{
				throw new \SentryUserNotFoundException(__('sentry.user_not_found'));
			}
			
			// assign the roles to the user
			$this->groups = $this->get_user_role();
		}
	}

	/**
	 * Get the current user's role and all the inherited tasks.
	 *
	 * @api
	 * @return	array 	the array of role tasks for the user
	 */
	public function get_user_role()
	{
		// get the roles from the session
		$roles = \Session::get('role');
		
		// if we don't have anything in the session, calculate the roles
		if ($roles === null)
		{
			// set up an empty array for storing all the role tasks
			$roles = array();
			
			// get the user's role
			$role = \Model_Access_Role::find($this->user['role_id']);
			
			// loop through the primary role's tasks and add them
			foreach ($role->tasks as $task)
			{
				if ((isset($roles[$task->component][$task->action]) 
						and $roles[$task->component][$task->action] < (int) $task->level)
						or ! isset($roles[$task->component][$task->action]))
				{
					$roles[$task->component][$task->action] = (int) $task->level;
				}
			}
			
			// get an array of inherited roles
			$inherited = explode(',', $role->inherits);
			
			// loop through the inherited roles
			foreach ($inherited as $i)
			{
				// make sure we aren't doing any stupid
				if ($i > 0 and $i !== null)
				{
					// get the role
					$r = \Model_Access_Role::find($i);
					
					// loop through the role's tasks and add them
					foreach ($r->tasks as $t)
					{
						if ((isset($roles[$t->component][$t->action]) 
								and $roles[$t->component][$t->action] < (int) $t->level)
								or ! isset($roles[$t->component][$t->action]))
						{
							$roles[$t->component][$t->action] = (int) $t->level;
						}
					}
				}
			}
		}
		
		return $roles;
	}

	/**
	 * Register a user - Alias of create()
	 *
	 * @param   array  User array for creation
	 * @return  int
	 * @throws  SentryUserException
	 */
	public function register($user)
	{
		return $this->create($user, true);
	}

	/**
	 * Create's a new user.  Returns user 'id'.
	 *
	 * @param   array  User array for creation
	 * @return  int
	 * @throws  SentryUserException
	 */
	public function create(array $user, $activation = false)
	{
		# TODO: you should be able to create a new user, but it should use the model instead

		throw new FuelException('Sentry_User::create is under development');
	}

	/**
	 * Update the current user
	 *
	 * @param   array  Fields to update
	 * @param   bool   Whether to hash the password
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function update(array $fields, $hash_password = true)
	{
		# TODO: you should be able to update a user, but it should use the model instead

		throw new FuelException('Sentry_User::update is under development');
	}

	/**
	 * Delete's the current user.
	 *
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function delete()
	{
		# TODO: you should be able to delete a user, but it should use the model instead

		throw new FuelException('Sentry_User::delete is under development');
	}

	/**
	 * Enable a User
	 *
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function enable()
	{
		# TODO: figure out how we want to handle enabling accounts

		if ($this->user['status'] == 1)
		{
			throw new \SentryUserException(__('sentry.user_already_enabled'));
		}

		return \Model_User::update_item($this->user['id'], array('status' => 1));
	}

	/**
	 * Disable a User
	 *
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function disable()
	{
		# TODO: figure out how we want to handle disabling accounts

		if ($this->user['status'] == 0)
		{
			throw new \SentryUserException(__('sentry.user_already_disabled'));
		}
		
		return $this->update(array('status' => 0));
	}

	/**
	 * Checks if the Field is set or not.
	 *
	 * @param   string  Field name
	 * @return  bool
	 */
	public function __isset($field)
	{
		return array_key_exists($field, $this->user);
	}

	/**
	 * Gets a field value of the user
	 *
	 * @param   string  Field name
	 * @return  mixed
	 * @throws  SentryUserException
	 */
	public function __get($field)
	{
		return $this->get($field);
	}

	/**
	 * Gets a given field (or array of fields).
	 *
	 * @param   string|array  Field(s) to get
	 * @return  mixed
	 * @throws  SentryUserException
	 */
	public function get($field = null)
	{
		// make sure a user id is set
		if (empty($this->user['id']))
		{
			throw new \SentryUserException(__('sentry.no_user_selected_to_get'));
		}

		// if no fields were passed - return entire user
		if ($field === null)
		{
			return $this->user;
		}
		// if field is an array - return requested fields
		else if (is_array($field))
		{
			$values = array();

			// loop through requested fields
			foreach ($field as $key)
			{
                                // check to see if field exists in user
				$val = \Arr::get($this->user, $key, '__MISSING_KEY__');
				if ($val !== '__MISSING_KEY__')
				{
					$values[$key] = $val;
				}
				else
				{
					throw new \SentryUserException(
						__('sentry.not_found_in_user_object', array('field' => $key))
					);
				}
			}

			return $values;
		}
		// if single field was passed - return its value
		else
		{
			// check to see if field exists in user
			$val = \Arr::get($this->user, $field, '__MISSING_KEY__');
			if ($val !== '__MISSING_KEY__')
			{
				return $val;
			}

			throw new \SentryUserException(__('sentry.not_found_in_user_object', array('field' => $field)));
		}
	}

	/**
	 * Changes a user's password
	 *
	 * @param   string  The new password
	 * @param   string  Users old password
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function change_password($password, $old_password)
	{
		// make sure old password matches the current password
		if ( ! $this->check_password($old_password))
		{
			throw new \SentryUserException(__('sentry.invalid_old_password'));
		}

		return $this->update(array('password' => $password));
	}

	/**
	 * Returns an array of groups the user is part of.
	 *
	 * @return  array
	 */
	public function groups()
	{
		return $this->groups;
	}

	/**
	 * Adds this user to the group.
	 *
	 * @param   string|int  Group ID or group name
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function add_to_group($id)
	{
		if ($this->in_group($id))
		{
			throw new \SentryUserException(__('sentry.user_already_in_group', array('group' => $id)));
		}

		$field = (is_numeric($id)) ? 'id' : 'name';

		try
		{
			$group = new \Sentry_Group($id);
		}
		catch (SentryGroupNotFoundException $e)
		{
			throw new \SentryUserException($e->getMessage());
		}

		list($insert_id, $rows_affected) = \DB::insert($this->table_usergroups)->set(array(
			'user_id' => $this->user['id'],
			'group_id' => $group->get('id'),
		))->execute($this->db_instance);

		$this->groups[] = array(
			'id'       => $group->get('id'),
			'name'     => $group->get('name'),
			'level'    => $group->get('level'),
			'is_admin' => $group->get('is_admin')
		);

		return true;
	}

	/**
	 * Removes this user from the group.
	 *
	 * @param   string|int  Group ID or group name
	 * @return  bool
	 * @throws  SentryUserException
	 */
	public function remove_from_group($id)
	{
		if ( ! $this->in_group($id))
		{
			throw new \SentryUserException(__('sentry.user_not_in_group', array('group' => $id)));
		}

		$field = (is_numeric($id)) ? 'id' : 'name';

		try
		{
			$group = new \Sentry_Group($id);
		}
		catch (SentryGroupNotFoundException $e)
		{
			throw new \SentryUserException($e->getMessage());
		}

		$delete = \DB::delete($this->table_usergroups)
				->where('user_id', $this->user['id'])
				->where('group_id', $group->get('id'))->execute($this->db_instance);

		// remove from array
		$field = 'name';
		if (is_numeric($id))
		{
			$field = 'id';
		}

		foreach ($this->groups as $key => $group)
		{
			if ($group[$field] == $id)
			{
				unset($group);
			}
		}

		return (bool) $delete;
	}

	/**
	 * Checks if the current user is part of the given group.
	 *
	 * @param   string  Group name
	 * @return  bool
	 */
	public function in_group($name)
	{
		$field = 'name';
		if (is_numeric($name))
		{
			$field = 'id';
		}

		foreach ($this->groups as $group)
		{
			if ($group[$field] == $name)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks if the user is an admin
	 *
	 * @return  bool
	 */
	public function is_admin()
	{
		if (\Session::get('user') == (int) $this->user['id'])
		{
			// grab the preferences from the session
			$preferences = \Session::get('preferences', false);

			// make sure we have preferences and they're an admin
			if ($preferences !== false and (bool) $preferences['is_sysadmin'] === true)
			{
				return true;
			}

			return false;
		}
		else
		{
			$user = \Model_User::find($this->user['id']);

			if ($user !== null)
			{
				foreach ($user->preferences as $key => $value)
				{
					if ($key == 'is_sysadmin' and (bool) $value === true)
					{
						return true;
					}
				}

				return false;
			}

			return false;
		}
	}

	/**
	 * Checks if the user has the given level
	 *
	 * @param	string	a dot-notated array key of the task
	 * @param	int		the level to check for (default: 0)
	 * @return	bool
	 */
	public function has_level($task, $level = 0)
	{
		return (\Arr::get($this->groups(), $task, false) === $level);
	}

	/**
	 * Checks if the user has at least given level
	 *
	 * @param	string	a dot-notated array key of the task
	 * @param	int		the level to check for (default: 0)
	 * @return	bool
	 */
	public function atleast_level($task, $level = 0)
	{
		if ($this->has_access($task) === false)
		{
			return false;
		}

		return (\Arr::get($this->groups(), $task, false) >= $level);
	}

	/**
	 * Check if user exists already
	 *
	 * @param   string  The Login Column value
	 * @param   string  Column to use for check
	 * @return  bool
	 */
	protected function user_exists($login, $field = null)
	{
		// set field value if null
		if ($field === null)
		{
			$field = $this->login_column;
		}
		
		$result = \Model_User::get_user($field, $login);

		if ($result)
		{
			return $result;
		}

		return false;
	}

	/**
	 * Checks the given password to see if it matches the one in the database.
	 *
	 * @param   string  Password to check
	 * @param   string  Password type
	 * @return  bool
	 */
	public function check_password($password, $field = 'password')
	{
		// get the UID (which is used for the salt)
		$salt = \Model_System::get_uid();

		// hash the inputted password
		$password = $this->hash_password($password, $salt);
		
		// check to see if passwords match
		return $password == $this->user[$field];
	}

	/**
	 * Return all users
	 *
	 * @return  array
	 */
	public function all()
	{
		return \Model_User::find('all');
	}

	/**
	 * Generates a random salt and hashes the given password with the salt.
	 * String returned is prepended with a 16 character alpha-numeric salt.
	 *
	 * @param   string  Password to generate hash/salt for
	 * @return  string
	 */
	protected function generate_password($password)
	{
		return self::password_generate($password);
	}

	/**
	 * Hash a given password with the given salt.
	 *
	 * @param   string  Password to hash
	 * @param   string  Password Salt
	 * @return  string
	 */
	protected function hash_password($password, $salt)
	{
		return self::password_hash($password, $salt);
	}

	/**
	 * Uses the sim's randomly generated UID as a salt and returns
	 * a hashed password.
	 *
	 * @api
	 * @param   string  Password to generate hash/salt for
	 * @return  string
	 */
	public static function password_generate($password)
	{
		$salt = \Model_System::get_uid();

		return static::password_hash($password, $salt);
	}

	/**
	 * Hash a given password with the given salt.
	 *
	 * @internal
	 * @param   string  Password to hash
	 * @param   string  Password Salt
	 * @return  string
	 */
	public static function password_hash($password, $salt)
	{
		$password = hash('sha256', $salt.$password);

		return $password;
	}

	/**
	 * Implementation of the Iterator interface
	 */

	protected $_iterable = array();

	public function rewind()
	{
		$this->_iterable = $this->user;
		reset($this->_iterable);
	}

	public function current()
	{
		return current($this->_iterable);
	}

	public function key()
	{
		return key($this->_iterable);
	}

	public function next()
	{
		return next($this->_iterable);
	}

	public function valid()
	{
		return key($this->_iterable) !== null;
	}

	/**
	 * Sets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @param   string  $value   value
	 * @return  void
	 */
	public function offsetSet($offset, $value)
	{
		$this->{$offset} = $value;
	}

	/**
	 * Checks if the given offset (class property) exists.
	 *
	 * @param   string  $offset  class property
	 * @return  bool
	 */
	public function offsetExists($offset)
	{
		return isset($this->{$offset});
	}

	/**
	 * Unsets the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  void
	 */
	public function offsetUnset($offset)
	{
		unset($this->{$offset});
	}

	/**
	 * Gets the value of the given offset (class property).
	 *
	 * @param   string  $offset  class property
	 * @return  mixed
	 */
	public function offsetGet($offset)
	{
		if (isset($this->{$offset}))
		{
			return $this->{$offset};
		}

		throw new \OutOfBoundsException('Property "'.$offset.'" not found for '.get_called_class().'.');
	}

	/**
	 * Custom methods to the Nova implementation.
	 */

	/**
	 * Check if the user has access to the given task.
	 *
	 * @api
	 * @param	string	a dot-notated string with the component and action (user.edit)
	 * @return	bool
	 */
	public function has_access($task)
	{
		return (\Arr::get($this->groups(), $task, false) !== false);
	}
}
