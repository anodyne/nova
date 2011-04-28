<?php
/**
 * Login Attempts Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_LoginAttempts extends Model {
	
	public static $_table_name = 'login_attempts';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'default' => ''),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'time' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	/**
	 * Get all of a user's log in attempts. You can also pass the strings 'first'
	 * or 'last' to the second parameter to retrieve the first attempt or the
	 * last attempt.
	 *
	 *     Model_LoginAttempts::get_user_attempts('me@example.com');
	 *     Model_LoginAttempts::get_user_attempts('me@example.com', 'first');
	 *     Model_LoginAttempts::get_user_attempts('me@example.com', 'last');
	 *
	 * @access	public
	 * @param	string	the email address to check
	 * @param	string	the scope to pull back (all, first, last)
	 * @return	object	an object with all the attempts for the email
	 */
	public static function get_user_attempts($email, $scope = 'all')
	{
		switch ($scope)
		{
			case 'all':
			default:
				return static::find()->where('email', $email)->get();
			break;
			
			case 'first':
				return static::find('first', array(
					'where' => array('email' => $email)
				));
			break;
			
			case 'last':
				return static::find('last', array(
					'where' => array('email' => $email)
				));
			break;
		}
	}
	
	/**
	 * Delete all of a user's login attempts.
	 *
	 * @access	public
	 * @param	string	the email address to remove the attempts for
	 * @return	void
	 */
	public static function delete_user_attempts($email)
	{
		$attempts = static::find()->where('email', $email)->get();
		
		if (count($attempts) > 0)
		{
			foreach ($attempts as $a)
			{
				$a->delete();
			}
		}
	}
	
	/**
	 * Create a new user login attempt.
	 *
	 * @access	public
	 * @param	array 	an array of data to put in to the database
	 * @return	void
	 */
	public static function create_user_attempt(array $data)
	{
		$attempt = Model_LoginAttempts::factory();
		
		foreach ($data as $key => $value)
		{
			if (in_array($key, static::$_properties))
			{
				$attempt->{$key} = $value;
			}
		}
		
		$attempt->save();
	}
}
