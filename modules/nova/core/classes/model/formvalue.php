<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Formvalue extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('forms_values');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'value_id'
			)),
			'field' => Jelly::field('belongsto', array(
				'column' => 'value_field',
				'foreign' => 'formfield'
			)),
			'html_name' => Jelly::field('string', array(
				'column' => 'value_html_name'
			)),
			'html_value' => Jelly::field('string', array(
				'column' => 'value_html_value'
			)),
			'html_id' => Jelly::field('string', array(
				'column' => 'value_html_id'
			)),
			'selected' => Jelly::field('string', array(
				'column' => 'value_selected'
			)),
			'content' => Jelly::field('string', array(
				'column' => 'value_content'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'value_order'
			)),
		));
	}
}