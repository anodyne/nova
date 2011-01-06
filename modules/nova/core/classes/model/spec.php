<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Specs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Spec extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'specs_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'specs_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'specs_order'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'specs_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'images' => Jelly::field('text', array(
				'column' => 'specs_images',
			)),
			'summary' => Jelly::field('text', array(
				'column' => 'specs_summary',
			)),
			'touritems' => Jelly::field('hasmany', array(
				'foreign' => 'tour.specitem'
			)),
		));
	}
}
