<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Position Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Position extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('positions_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'pos_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'pos_name'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'pos_desc',
			)),
			'dept' => Jelly::field('belongsto', array(
				'column' => 'pos_dept',
				'foreign' => 'department'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'pos_order',
			)),
			'open' => Jelly::field('integer', array(
				'column' => 'pos_open',
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'pos_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'type' => Jelly::field('enum', array(
				'column' => 'pos_type',
				'choices' => array('senior','officer','enlisted','other'),
				'default' => 'officer'
			))
		));
	}
}
