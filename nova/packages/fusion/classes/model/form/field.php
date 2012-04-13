<?php
/**
 * Form Fields Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Form_Field extends \Model {
	
	public static $_table_name = 'form_fields';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'section_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'null' => true),
		'type' => array(
			'type' => 'string',
			'constraint' => 50,
			'default' => 'text'),
		'html_name' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'html_id' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'html_class' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => 'span4'),
		'html_rows' => array(
			'type' => 'int',
			'constraint' => 3,
			'default' => 5),
		'selected' => array(
			'type' => 'string',
			'constraint' => 50,
			'null' => true),
		'value' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'placeholder' => array(
			'type' => 'text',
			'null' => true),
		'order' => array(
			'type' => 'int',
			'constraint' => 5,
			'null' => true),
		'display' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	public static $_belongs_to = array(
		'section' => array(
			'model_to' => '\\Model_Form_Section',
			'key_to' => 'id',
			'key_from' => 'section_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_has_many = array(
		'values' => array(
			'model_to' => '\\Model_Form_Value',
			'key_to' => 'field_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	/**
	 * Get the values for the current field.
	 *
	 * @api
	 * @return	array
	 */
	public function get_values()
	{
		// start with an empty array
		$items = array();

		// make sure we have values for this field
		if ($this->values !== null)
		{
			// loop through the values and put them in the right format
			foreach ($this->values as $val)
			{
				$items[$val->html_value] = $val->content;
			}
		}

		return $items;
	}
}
