<?php
/**
 * Form Fields Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_FormField extends Model {
	
	public static $_table_name = 'form_fields';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'section_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'text'),
		'html_name' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'html_id' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'html_class' => array(
			'type' => 'text'),
		'html_rows' => array(
			'type' => 'int',
			'constraint' => 3,
			'default' => 5),
		'selected' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => ''),
		'value' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'placeholder' => array(
			'type' => 'TEXT'),
		'order' => array(
			'type' => 'int',
			'constraint' => 5),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	public static $_has_many = array(
		'values' => array(
			'model_to' => 'Model_FormValue',
			'key_to' => 'field_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get the fields for a specific form.
	 *
	 * @access	public
	 * @param	string	the form key to use
	 * @return	object	the form fields object
	 */
	public static function get_fields($key)
	{
		return static::find()->where('form_key', $key)->get();
	}
}
