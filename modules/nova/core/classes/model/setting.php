<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Setting extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->name_key('key');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'setting_id'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'setting_key'
			)),
			'value' => Jelly::field('text', array(
				'column' => 'setting_value'
			)),
			'label' => Jelly::field('string', array(
				'column' => 'setting_label'
			)),
			'user_created' => Jelly::field('enum', array(
				'column' => 'setting_user_created',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
}