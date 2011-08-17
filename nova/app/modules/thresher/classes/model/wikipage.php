<?php
/**
 * Wiki Page Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_WikiPage extends Model {
	
	public static $_table_name = 'wiki_pages';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'draft_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'created_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'created_by_user' => array(
			'type' => 'int',
			'constraint' => 8),
		'created_by_character' => array(
			'type' => 'int',
			'constraint' => 8),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'updated_by_user' => array(
			'type' => 'int',
			'constraint' => 8),
		'updated_by_character' => array(
			'type' => 'int',
			'constraint' => 8),
		'comments' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'standard','system'",
			'default' => 'standard'),
		'key' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
	);
}
