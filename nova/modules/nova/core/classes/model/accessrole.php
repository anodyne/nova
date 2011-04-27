<?php
/**
 * Access Role Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_AccessRole extends Orm\Model {
	
	public static $_table_name = 'access_roles';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'INT',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'pages' => array(
			'type' => 'text'),
		'desc' => array(
			'type' => 'text'),
	);
	
	public static $_has_many = array(
		'users' => array(
			'model_to' => 'Model_User',
			'key_to' => 'role_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
