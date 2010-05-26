<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Department Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Department extends Jelly_Model
{
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

// End of file department.php
// Location: modules/nova/classes/model/department.php