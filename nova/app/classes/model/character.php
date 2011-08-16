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
		'promotions' => array(
			'model_to' => 'Model_CharacterPromotion',
			'key_to' => 'character_id',
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
			'key_through_from' => 'character_id',
			'key_through_to' => 'post_id',
			'table_through' => 'post_authors',
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
	 * This will create a character record and create empty rows for the
	 * character dynamic form.
	 *
	 *     // note: this is an incomplete array
	 *     $data = array('first_name' => 'John', 'last_name' => 'Public');
	 *     
	 *     $character = Model_Character::create_character($data);
	 *
	 * @access	public
	 * @param	array 	an array of data used for creation
	 * @return	object	the created object
	 */
	public static function create_character(array $data)
	{
		$record = static::create_item($data);
		
		/**
		 * Fill the character rows for the dynamic form with blank data for editing later.
		 */
		$fields = Model_FormField::get_fields('bio');
		
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
					'updated_at' => Date::now(),
				);
				
				Model_FormData::create_data($character_field_data);
			}
		}
		
		DBForge::optimize('characters');
		DBForge::optimize('form_fields');
		DBForge::optimize('form_data');
		
		return $record;
	}
	
	public function name($include_rank = true, $short_rank = false)
	{
		// get the rank
		$rank = Model_Rank::find($this->rank_id);
		
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
