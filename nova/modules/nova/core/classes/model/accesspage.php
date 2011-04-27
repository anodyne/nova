<?php
/**
 * Access Pages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_AccessPage extends Orm\Model {
	
	public static $_table_name = 'access_pages';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 6,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'url' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'level' => array(
			'type' => 'int',
			'constraint' => 3,
			'default' => 0),
		'group' => array(
			'type' => 'int',
			'constraint' => 6,
			'default' => 0),
		'desc' => array(
			'type' => 'text'),
	);
	
	public static $_belongs_to = array(
		'group' => array(
			'model_to' => 'Model_AccessGroup',
			'key_to' => 'id',
			'key_from' => 'group',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
