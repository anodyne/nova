<?php
/**
 * Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Comment extends Model {
	
	public static $_table_name = 'comments';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'type' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'item_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'content' => array(
			'type' => 'text'),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'activated','pending'",
			'default' => 'activated'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
