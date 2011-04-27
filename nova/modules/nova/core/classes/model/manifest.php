<?php
/**
 * Manifest Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Manifest extends Orm\Model {
	
	public static $_table_name = 'manifests';
	
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
		'header_content' => array(
			'type' => 'text'),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'default' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);
	
	public static $_has_many = array(
		'departments' => array(
			'model_to' => 'Model_Department',
			'key_to' => 'manifest_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
