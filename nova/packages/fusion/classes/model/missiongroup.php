<?php
/**
 * Mission Groups Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_MissionGroup extends \Model {
	
	public static $_table_name = 'mission_groups';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'parent_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
	);
	
	public static $_has_many = array(
		'missions' => array(
			'model_to' => '\\Model_Mission',
			'key_to' => 'group_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
