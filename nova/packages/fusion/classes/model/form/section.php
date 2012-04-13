<?php
/**
 * Form Sections Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Form_Section extends \Model {
	
	public static $_table_name = 'form_sections';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'tab_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
	);

	public static $_belongs_to = array(
		'tab' => array(
			'model_to' => '\\Model_Form_Tab',
			'key_to' => 'id',
			'key_from' => 'tab_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static $_has_many = array(
		'fields' => array(
			'model_to' => '\\Model_Form_Field',
			'key_to' => 'section_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
