<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Department Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Department extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('departments_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'dept_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'dept_name'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'dept_desc',
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'dept_order',
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'dept_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'type' => Jelly::field('enum', array(
				'column' => 'dept_type',
				'choices' => array('playing','nonplaying'),
				'default' => 'playing'
			)),
			'parent' => Jelly::field('hasone', array(
				'column' => 'dept_parent',
				'foreign' => 'department'
			))
		));
	}
}