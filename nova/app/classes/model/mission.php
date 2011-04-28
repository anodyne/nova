<?php
/**
 * Missions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Mission extends Model {
	
	public static $_table_name = 'missions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 8,
			'auto_increment' => true),
		'title' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'images' => array(
			'type' => 'text'),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'group_id' => array(
			'type' => 'int',
			'constraint' => 5),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'upcoming','current','completed'",
			'default' => 'upcoming'),
		'start' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'end' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'desc' => array(
			'type' => 'text'),
		'summary' => array(
			'type' => 'text'),
		'notes' => array(
			'type' => 'text'),
		'notes_updated' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_belongs_to = array(
		'group' => array(
			'model_to' => 'Model_MissionGroup',
			'key_to' => 'id',
			'key_from' => 'group_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'posts' => array(
			'model_to' => 'Model_Post',
			'key_to' => 'mission_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
