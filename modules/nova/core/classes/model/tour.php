<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Tour Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Tour extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('tour');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'tour_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'tour_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'tour_order'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'tour_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'images' => Jelly::field('text', array(
				'column' => 'tour_images',
			)),
			'summary' => Jelly::field('text', array(
				'column' => 'tour_summary',
			)),
			'specitem' => Jelly::field('belongsto', array(
				'column' => 'tour_spec_item',
				'foreign' => 'spec'
			)),
		));
	}
}