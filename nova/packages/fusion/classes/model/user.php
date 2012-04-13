<?php
/**
 * User Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_User extends \Model {
	
	public static $_table_name = 'users';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'status' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'pending'),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'password' => array(
			'type' => 'string',
			'constraint' => 96,
			'null' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'role_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'join_date' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'leave_date' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'last_post' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'last_login' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'password_reset_hash' => array(
			'type' => 'string',
			'constraint' => 24,
			'null' => true),
		'temp_password' => array(
			'type' => 'string',
			'constraint' => 96,
			'null' => true),
		'remember_me' => array(
			'type' => 'string',
			'constraint' => 24,
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'role' => array(
			'model_to' => '\\Model_Access_Role',
			'key_to' => 'id',
			'key_from' => 'role_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_one = array(
		'character' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'characters' => array(
			'model_to' => '\\Model_Character',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'logs' => array(
			'model_to' => '\\Model_PersonalLog',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'announcements' => array(
			'model_to' => '\\Model_Announcement',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'preferences' => array(
			'model_to' => '\\Model_User_Preferences',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'posts' => array(
			'model_to' => '\\Model_Post',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'user_id',
			'key_through_to' => 'post_id',
			'table_through' => 'post_authors',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get a user from the database based on something other than their ID.
	 *
	 * @api
	 * @param	string	the column to use
	 * @param	mixed	the value to use
	 * @return	object	a user object
	 */
	public static function get_user($column, $value)
	{
		if (array_key_exists($column, static::$_properties))
		{
			return static::find()->where($column, $value)->get_one();
		}
		
		return false;
	}

	/**
	 * Get every user from the database based on criteria.
	 *
	 * @api
	 * @param	string	the status to pull
	 * @return	object	a user object
	 */
	public static function get_users($status = 'active')
	{
		return static::find()->where('status', $status)->get();
	}
	
	/**
	 * This will retrieve a user's preferences from the database as an array.
	 *
	 *     $preferences = Model_User::find($id)->get_user_preferences();
	 *
	 * @api
	 * @return	array	an array of items
	 */
	public function get_user_preferences()
	{
		// set up a blank array for storing the items
		$prefs = array();
		
		// loop through the preferences
		foreach ($this->preferences as $p)
		{
			$prefs[$p->key] = $p->value;
		}
		
		// return the items array
		return $prefs;
	}
	
	/**
	 * Create a user.
	 *
	 * This will create a user record, create user preference values (read from
	 * the defaults in the user preference tale) and create empty rows for the
	 * user dynamic form.
	 *
	 *     // note: this is an incomplete array
	 *     $data = array('name' => 'John Public', 'email' => 'john@example.com');
	 *     
	 *     $user = Model_User::create_user($data);
	 *
	 * @api
	 * @param	array 	an array of data used for creation
	 * @return	object	the created object
	 */
	public static function create_user(array $data)
	{
		$record = static::create_item($data);
		
		/**
		 * Create the user settings.
		 */
		$settings = \Model_User_Preferences::create_user_preferences($record->id);
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$fields = \Model_Form_Field::find_form_items('user');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				$user_field_data = array(
					'form_key' => 'user',
					'field_id' => $f->id,
					'user_id' => $record->id,
					'character_id' => 0,
					'item_id' => 0,
					'value' => '',
					'updated_at' => time(),
				);
				
				\Model_Form_Data::create_data($user_field_data);
			}
		}
		
		return $record;
	}
	
	/**
	 * Update a user.
	 *
	 * @api
	 * @param	int		the user ID to update, if nothing is provided, it will update all users
	 * @param	array 	a data array to use for updating the record
	 * @return	object	the user object of the updated user
	 */
	public static function update_user($user, array $data)
	{
		if ($user !== null)
		{
			// get the user
			$record = static::find($user);
			
			// loop through the data array and make the changes
			foreach ($data as $key => $value)
			{
				$record->$key = $value;
			}
			
			// save the record
			$record->save();
			
			return $record;
		}
		else
		{
			// pull everything from the table
			$records = static::find('all');
			
			// loop through all the records
			foreach ($records as $r)
			{
				// loop through the data and make the changes
				foreach ($data as $key => $value)
				{
					$r->$key = $value;
				}
				
				// save the record
				$r->save();
			}
		}
	}
}
