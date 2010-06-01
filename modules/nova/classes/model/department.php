<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Department Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Department extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('departments_'.Kohana::config('nova.genre'));
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'dept_id'
			)),
			'name' => new Field_String(array(
				'column' => 'dept_name'
			)),
			'desc' => new Field_Text(array(
				'column' => 'dept_desc',
			)),
			'order' => new Field_Integer(array(
				'column' => 'dept_order',
			)),
			'display' => new Field_Enum(array(
				'column' => 'dept_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'type' => new Field_Enum(array(
				'column' => 'dept_type',
				'choices' => array('playing','nonplaying'),
				'default' => 'playing'
			)),
			'parent' => new Field_HasOne(array(
				'column' => 'dept_parent',
				'foreign' => 'department'
			))
		));
	}
}