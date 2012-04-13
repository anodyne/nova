<?php
/**
 * Character Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Character extends \Model {
	
	public static $_table_name = 'characters';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'first_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'middle_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'last_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'suffix' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','pending','archived'",
			'default' => 'pending'),
		'activated' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'deactivated' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'rank_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 1),
		'last_post' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'logs' => array(
			'model_to' => '\\Model_PersonalLog',
			'key_to' => 'character_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'announcements' => array(
			'model_to' => '\\Model_Announcement',
			'key_to' => 'character_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'promotions' => array(
			'model_to' => '\\Model_Character_Promotion',
			'key_to' => 'character_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'positions' => array(
			'key_from' => 'id',
			'key_through_from' => 'character_id',
			'table_through' => 'character_positions',
			'key_through_to' => 'position_id',
			'model_to' => '\\Model_Position',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
		'posts' => array(
			'key_from' => 'id',
			'key_through_from' => 'character_id',
			'table_through' => 'post_authors',
			'key_through_to' => 'post_id',
			'model_to' => '\\Model_Post',
			'key_to' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get all characters from the database.
	 *
	 * @api
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
	 * This will create a character record and create empty rows for the
	 * character dynamic form.
	 *
	 *     // note: this is an incomplete array
	 *     $data = array('first_name' => 'John', 'last_name' => 'Public');
	 *     
	 *     $character = Model_Character::create_character($data);
	 *
	 * @api
	 * @param	array 	an array of data used for creation
	 * @return	object	the created object
	 */
	public static function create_character(array $data)
	{
		$record = static::create_item($data);
		
		/**
		 * Fill the character rows for the dynamic form with blank data for editing later.
		 */
		$fields = \Model_Form_Field::find_form_items('bio');
		
		if (count($fields) > 0)
		{
			foreach ($fields as $f)
			{
				$character_field_data = array(
					'form_key' => 'bio',
					'field_id' => $f->id,
					'user_id' => 0,
					'character_id' => $record->id,
					'item_id' => 0,
					'value' => '',
					'updated_at' => time(),
				);
				
				\Model_Form_Data::create_data($character_field_data);
			}
		}
		
		return $record;
	}
	
	public function name($include_rank = true, $short_rank = false)
	{
		// get the rank
		$rank = \Model_Rank::find($this->rank_id);
		
		$pieces = array(
			($include_rank) 
				? ($short_rank) 
					? $rank->short_name 
					: $rank->name 
				: '',
			$this->first_name,
			$this->last_name
		);
		
		foreach ($pieces as $key => $p)
		{
			if (empty($p))
			{
				unset($pieces[$key]);
			}
		}
		
		return implode(' ', $pieces);
	}
}
