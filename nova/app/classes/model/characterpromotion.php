<?php
/**
 * Character Promotions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CharacterPromotion extends Model {
	
	public static $_table_name = 'character_promotions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'old_order' => array(
			'type' => 'int',
			'constraint' => 5),
		'old_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'new_order' => array(
			'type' => 'int',
			'constraint' => 5),
		'new_rank' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
