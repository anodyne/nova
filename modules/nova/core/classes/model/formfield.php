<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Fields Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formfield extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_fields');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'field_id'
			)),
			'form' => new Field_BelongsTo(array(
				'column' => 'field_form',
				'foreign' => 'form.key'
			)),
			'section' => new Field_BelongsTo(array(
				'column' => 'field_section',
				'foreign' => 'formsection'
			)),
			'type' => new Field_String(array(
				'column' => 'field_type'
			)),
			'html_name' => new Field_String(array(
				'column' => 'field_html_name'
			)),
			'html_id' => new Field_String(array(
				'column' => 'field_html_id'
			)),
			'html_class' => new Field_Text(array(
				'column' => 'field_html_class'
			)),
			'html_rows' => new Field_Integer(array(
				'column' => 'field_html_rows'
			)),
			'selected' => new Field_String(array(
				'column' => 'field_selected'
			)),
			'value' => new Field_String(array(
				'column' => 'field_value'
			)),
			'label' => new Field_String(array(
				'column' => 'field_label'
			)),
			'placeholder' => new Field_Text(array(
				'column' => 'field_placeholder'
			)),
			'order' => new Field_Integer(array(
				'column' => 'field_order'
			)),
			'display' => new Field_Enum(array(
				'column' => 'field_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'field_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'values' => new Field_HasMany(array(
				'foreign' => 'formvalue.field'
			)),
		));
	}
}