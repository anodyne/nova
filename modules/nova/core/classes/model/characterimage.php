<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Images Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Characterimage extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('characters_images');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'charimageid'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'character',
				'foreign' => 'character'
			)),
			'image' => Jelly::field('string', array(
				'column' => 'image'
			)),
			'primary' => Jelly::field('enum', array(
				'column' => 'primary_image',
				'choices' => array('y', 'n'),
				'default' => 'n'
			)),
			'created_by' => Jelly::field('belongsto', array(
				'column' => 'created_by',
				'foreign' => 'user'
			)),
			'created_at' => Jelly::field('timestamp', array(
				'column' => 'created_at',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}