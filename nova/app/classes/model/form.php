<?php
/**
 * Form Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Form extends Model {
	
	public static $_table_name = 'forms';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'desc' => array(
			'type' => 'text'),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','development'",
			'default' => 'active'),
	);
}
