<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Fields Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formfield extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_fields');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'field_id'
			)),
			'form' => Jelly::field('belongsto', array(
				'column' => 'field_form',
				'foreign' => 'form.key'
			)),
			'section' => Jelly::field('belongsto', array(
				'column' => 'field_section',
				'foreign' => 'formsection'
			)),
			'type' => Jelly::field('string', array(
				'column' => 'field_type'
			)),
			'html_name' => Jelly::field('string', array(
				'column' => 'field_html_name'
			)),
			'html_id' => Jelly::field('string', array(
				'column' => 'field_html_id'
			)),
			'html_class' => Jelly::field('text', array(
				'column' => 'field_html_class'
			)),
			'html_rows' => Jelly::field('integer', array(
				'column' => 'field_html_rows'
			)),
			'selected' => Jelly::field('string', array(
				'column' => 'field_selected'
			)),
			'value' => Jelly::field('string', array(
				'column' => 'field_value'
			)),
			'label' => Jelly::field('string', array(
				'column' => 'field_label'
			)),
			'placeholder' => Jelly::field('text', array(
				'column' => 'field_placeholder'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'field_order'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'field_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'field_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'values' => Jelly::field('hasmany', array(
				'foreign' => 'formvalue.field'
			)),
		));
	}
}