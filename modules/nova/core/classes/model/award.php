<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Award Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Award extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'award_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'award_name'
			)),
			'image' => Jelly::field('string', array(
				'column' => 'award_image',
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'award_order',
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'award_desc',
			)),
			'category' => Jelly::field('enum', array(
				'column' => 'award_cat',
				'choices' => array('ic','ooc','both'),
				'default' => 'ic'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'award_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
}