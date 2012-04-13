<?php
/**
 * Form Values Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Form_Value extends \Model {
	
	public static $_table_name = 'form_values';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'field_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'value' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'content' => array(
			'type' => 'text',
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'field' => array(
			'model_to' => '\\Model_Form_Field',
			'key_to' => 'field_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
