<?php
/**
 * Menu Category Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_MenuCat extends Model {
	
	public static $_table_name = 'menu_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'category' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'sub','adminsub'",
			'default' => 'sub'),
	);
}
