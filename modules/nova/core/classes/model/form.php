<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Form extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'form_id'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'form_key'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'form_name'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'form_desc'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'form_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'fields' => Jelly::field('hasmany', array(
				'foreign' => 'formfield.form'
			)),
			'sections' => Jelly::field('belongsto', array(
				'foreign' => 'formsection'
			)),
			'tabs' => Jelly::field('belongsto', array(
				'foreign' => 'formtab'
			)),
		));
	}
}