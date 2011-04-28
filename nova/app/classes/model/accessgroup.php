<?php
/**
 * Access Groups Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_AccessGroup extends Model {
	
	public static $_table_name = 'access_groups';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 6,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'default' => 0),
	);
	
	public static $_has_many = array(
		'pages' => array(
			'model_to' => 'Model_AccessPage',
			'key_to' => 'group',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
