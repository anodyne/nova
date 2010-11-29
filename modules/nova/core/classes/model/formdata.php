<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Data Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formdata extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_data');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'data_id'
			)),
			'form' => Jelly::field('string', array(
				'column' => 'data_form'
			)),
			'field' => Jelly::field('belongsto', array(
				'column' => 'data_field',
				'foreign' => 'formfield'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'data_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'data_character',
				'foreign' => 'character'
			)),
			'item' => Jelly::field('integer', array(
				'column' => 'data_item'
			)),
			'value' => Jelly::field('text', array(
				'column' => 'data_value'
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'data_last_update',
				'auto_now_create' => false,
				'auto_now_update' => true,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}