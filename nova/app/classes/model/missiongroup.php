<?php
/**
 * Mission Groups Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_MissionGroup extends Model {
	
	public static $_table_name = 'mission_groups';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'desc' => array(
			'type' => 'text'),
		'parent_id' => array(
			'type' => 'int',
			'constraint' => 5),
	);
	
	public static $_has_many = array(
		'missions' => array(
			'model_to' => 'Model_Mission',
			'key_to' => 'group_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
