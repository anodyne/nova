<?php
/**
 * User Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_User extends Model {
	
	public static $_table_name = 'users';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'password' => array(
			'type' => 'string',
			'constraint' => 40,
			'default' => ''),
		'date_of_birth' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'role_id' => array(
			'type' => 'int',
			'constraint' => 5),
		'is_sysadmin' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'is_game_master' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'is_webmaster' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'is_firstlaunch' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'timezone' => array(
			'type' => 'string',
			'constraint' => 5,
			'default' => 'UTC'),
		'daylight_savings' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'email_format' => array(
			'type' => 'string',
			'constraint' => 4,
			'default' => 'html'),
		'language' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'en-us'),
		'join_date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'leave_date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'last_post' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'last_login' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'loa' => array(
			'type' => 'enum',
			'constraint' => "'active','loa','eloa'",
			'default' => 'active'),
		'display_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => 'default'),
		'skin_main' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => 'default'),
		'skin_admin' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => 'default'),
		'security_question' => array(
			'type' => 'int',
			'constraint' => 5),
		'security_answer' => array(
			'type' => 'string',
			'constraint' => 40,
			'default' => ''),
		'password_reset' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'my_links' => array(
			'type' => 'text'),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_belongs_to = array(
		'role' => array(
			'model_to' => 'Model_AccessRole',
			'key_to' => 'id',
			'key_from' => 'role_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_one = array(
		'character' => array(
			'model_to' => 'Model_Character',
			'key_to' => 'id',
			'key_from' => 'character_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'characters' => array(
			'model_to' => 'Model_Character',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'logs' => array(
			'model_to' => 'Model_PersonalLog',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'news' => array(
			'model_to' => 'Model_News',
			'key_to' => 'user_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'posts' => array(
			'model_to' => 'Model_Post',
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
	 * @access	public
	 * @param	string	the column to use
	 * @param	mixed	the value to use
	 * @return	object	a user object
	 */
	public static function get($column, $value)
	{
		if (array_key_exists($column, static::$_properties))
		{
			return static::find()->where($column, $value)->get_one();
		}
		
		return false;
	}
	
	/**
	 * Figure out what the status of a user is given their characters.
	 *
	 * @access	public
	 * @return	mixed	a string with the status or FALSE if the user doesn't exist
	 */
	public function get_status()
	{
		if ($this !== null)
		{
			if (($this->character_id === null) or ($this->character->id == 0))
			{
				$status = 'inactive';
			}
			else
			{
				if (count($this->characters) > 0)
				{
					foreach ($this->characters as $c)
					{
						$chars[] = $c->status;
					}
					
					if (in_array('active', $chars))
					{
						$status = 'active';
					}
					elseif ( ! in_array('active', $chars) and in_array('pending', $chars))
					{
						$status = 'pending';
					}
					elseif ( ! in_array('active', $chars) and ! in_array('pending', $chars))
					{
						$status = 'inactive';
					}
				}
				else
				{
					$status = 'inactive';
				}
			}
			
			return $status;
		}
		
		return false;
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
	 * @access	public
	 * @param	array 	an array of data used for creation
	 * @return	object	the created object
	 */
	public static function create_user(array $data)
	{
		$record = static::create_item($data);
		
		/**
		 * Create the user preferences and fill them with the default values.
		 */
		$prefs = Model_UserPref::find('all');
		
		if (count($prefs) > 0)
		{
			foreach ($prefs as $p)
			{
				$pref_value_data = array(
					'user_id' => $record->id,
					'key' => $p->key,
					'value' => $p->default,
				);
				$prefvalue = Model_UserPrefValue::create_value($pref_value_data);
			}
		}
		
		/**
		 * Fill the user rows for the dynamic form with blank data for editing later.
		 */
		$fields = Model_FormField::get_fields('user');
		
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
					'updated_at' => Date::now(),
				);
				
				Model_FormData::create_data($user_field_data);
			}
		}
		
		DBForge::optimize('form_fields');
		DBForge::optimize('form_data');
		DBForge::optimize('user_prefs');
		DBForge::optimize('user_pref_values');
		DBForge::optimize('users');
		
		return $record;
	}
	
	/**
	 * Update a user.
	 *
	 * @access	public
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
