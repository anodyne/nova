<?php
/**
 * Character Images Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_CharacterImage extends Model {
	
	public static $_table_name = 'characters_images';
	
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
		'image' => array(
			'type' => 'text'),
		'primary_image' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
		'created_by' => array(
			'type' => 'int',
			'constraint' => 8),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
