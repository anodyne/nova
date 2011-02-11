<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Default auth user
 *
 * @package    Kohana/Auth
 * @author     creatoro
 * @copyright  (c) 2011 creatoro
 * @license    http://creativecommons.org/licenses/by-sa/3.0/legalcode
 */
class Model_Auth_User extends Jelly_Model {

	public static function initialize(Jelly_Meta $meta)
    {
        // The table the model is attached to
        $meta->table('users');

        // Fields defined by the model
        $meta->fields(array(
            'id' => Jelly::field('primary'),
            'email' => Jelly::field('email', array(
				'label' => 'email address',
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4)),
					array('max_length', array(':value', 127)),
				),
				'unique' => TRUE,
			)),
            'username' => Jelly::field('string', array(
				'label' => 'username',
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 4)),
					array('max_length', array(':value', 32)),
					array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
				),
				'unique' => TRUE,
			)),
			'password' => Jelly::field('password', array(
				'label' => 'password',
				'rules' => array(
					array('not_empty'),
					array('min_length', array(':value', 8)),
					array('matches', array(':validation', ':field', 'password_confirm')),
				),
				'hash_with' => array(Auth::instance(), 'hash'),
			)),
			'password_confirm' => Jelly::field('password', array(
				'in_db' => FALSE,
			)),
			'logins' => Jelly::field('integer', array(
				'convert_empty' => TRUE,
				'empty_value' => 0,
			)),
			'last_login' => Jelly::field('timestamp'),

            // Relationships to other models
            'user_tokens' => Jelly::field('hasmany', array(
				'foreign' => 'user_token',
			)),
            'roles' => Jelly::field('manytomany'),
        ));
    }

	/**
	 * Complete the login for a user by incrementing the logins and saving login timestamp
	 *
	 * @return void
	 */
	public function complete_login()
	{
		if ($this->_loaded)
		{
			// Update the number of logins
			$this->logins = $this->logins + 1;

			// Set the last login date
			$this->last_login = time();

			// Save the user
			$this->save();
		}
	}

	/**
	 * Allows a model use both email and username as unique identifiers for login
	 *
	 * @param   string  unique value
	 * @return  string  field name
	 */
	public function unique_key($value)
	{
		return Valid::email($value) ? 'email' : 'username';
	}

	/**
	 * Create a new user
	 *
	 * Example usage:
	 * ~~~
	 * $user = Jelly::factory('user')->create_user($_POST, array(
	 *	'username',
	 *	'password',
	 *	'email',
	 * );
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws Validation_Exception
	 */
	public function create_user($values, $expected)
	{
		return $this->set(Arr::extract($values, $expected))->save();
	}

	/**
	 * Update an existing user
	 *
	 * [!!] We make the assumption that if a user does not supply a password, that they do not wish to update their password.
	 *
	 * Example usage:
	 * ~~~
	 * $user = Jelly::factory('user', 1)
	 *	->update_user($_POST, array(
	 *		'username',
	 *		'password',
	 *		'email',
	 *	);
	 * ~~~
	 *
	 * @param array $values
	 * @param array $expected
	 * @throws Validation_Exception
	 */
	public function update_user($values, $expected)
	{
		if (empty($values['password']))
		{
			unset($values['password'], $values['password_confirm']);
		}

		return $this->set(Arr::extract($values, $expected))->save();
	}

} // End Auth User Model