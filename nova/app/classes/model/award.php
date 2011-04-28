<?php
/**
 * Award Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Award extends Model {
	
	public static $_table_name = 'awards';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'image' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'desc' => array(
			'type' => 'text'),
		'category' => array(
			'type' => 'enum',
			'constraint' => "'ic','ooc','both'",
			'default' => 'ic'),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
}
