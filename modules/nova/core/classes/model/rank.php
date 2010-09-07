<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Rank extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('ranks_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'rank_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'rank_name'
			)),
			'shortname' => Jelly::field('string', array(
				'column' => 'rank_short_name',
			)),
			'image' => Jelly::field('string', array(
				'column' => 'rank_image',
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'rank_order',
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'rank_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'class' => Jelly::field('integer', array(
				'column' => 'rank_class'
			)),
		));
	}
}