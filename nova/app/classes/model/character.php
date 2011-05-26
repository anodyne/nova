<?php
/**
 * Character Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Character extends Model {
	
	public static $_table_name = 'characters';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'first_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'middle_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'last_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'suffix' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','pending','archived'",
			'default' => 'pending'),
		'activated' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'deactivated' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'rank_id' => array(
			'type' => 'int',
			'constraint' => 10,
			'default' => 1),
		'position1_id' => array(
			'type' => 'int',
			'constraint' => 10,
			'default' => 1),
		'position2_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'last_post' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_belongs_to = array(
		'user' => array(
			'model_to' => 'Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'logs' => array(
			'model_to' => 'Model_PersonalLog',
			'key_to' => 'character_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'news' => array(
			'model_to' => 'Model_News',
			'key_to' => 'character_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all characters from the database.
	 *
	 * @access	public
	 * @param	string	the status of characters to pull back
	 * @return	object	an object of characters
	 */
	public static function get_characters($scope = 'active')
	{
		switch ($scope)
		{
			case 'active':
			default:
				$result = static::find('all', array(
					'where' => array('status', 'active')
				));
			break;
			
			case 'inactive':
				$result = static::find('all', array(
					'where' => array('status', 'inactive')
				));
			break;
			
			case 'pending':
				$result = static::find('all', array(
					'where' => array('status', 'pending')
				));
			break;
			
			case 'npc':
				# TODO: is this right?
				$result = static::find('all', array(
					'where' => array(
						array('user', 0),
						array('status', 'active')
					),
				));
			break;
			
			case '':
				$result = static::find('all');
			break;
		}
		
		return $result;
	}
	
	/**
	 * Create a character.
	 *
	 * @access	public
	 * @param	array 	an array of data used for creation
	 * @return	object	the created object
	 */
	public static function create_character(array $data)
	{
		$record = Model_Character::factory();
		
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		$record->save();
		
		DBForge::optimize('characters');
		
		return $record;
	}
}
