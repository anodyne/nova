<?php
/**
 * Menu Category Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_MenuCat extends \Model {
	
	public static $_table_name = 'menu_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'category' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'sub','adminsub'",
			'default' => 'sub'),
		'landing_page' => array(
			'type' => 'text',
			'null' => true),
	);
}
