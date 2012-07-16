<?php
/**
 * Award Categories Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Award_Category extends \Model {
	
	public static $_table_name = 'awards_categories';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);

	public static $_has_many = array(
		'awards' => array(
			'model_to' => '\\Model_Award',
			'key_to' => 'category_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
