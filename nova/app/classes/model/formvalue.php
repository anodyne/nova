<?php
/**
 * Form Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_FormValue extends Model {
	
	public static $_table_name = 'form_values';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'field_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'html_name' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'html_value' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'html_id' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'selected' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'content' => array(
			'type' => 'text'),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
	);
	
	public static $_belongs_to = array(
		'belong_field' => array(
			'model_to' => 'Model_FormField',
			'key_to' => 'id',
			'key_from' => 'field_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
}
