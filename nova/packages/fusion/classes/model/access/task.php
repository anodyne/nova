<?php
/**
 * Access Task Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Access_Task extends \Model
{
	public static $_table_name = 'tasks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'component' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'action' => array(
			'type' => 'string',
			'constraint' => 11,
			'default' => 'read'),
		'level' => array(
			'type' => 'int',
			'constraint' => 2,
			'default' => 0),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'help' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
	);

	public static $_many_many = array(
		'roles' => array(
			'model_to' => '\\Model_Access_Role',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'task_id',
			'key_through_to' => 'role_id',
			'table_through' => 'roles_tasks',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);

	public static function getTask($task)
	{
		// break the task up into an array
		$taskArray = explode('.', $task);

		// break the task up into its components
		list($component, $action, $level) = $taskArray;

		return static::find()
			->where('component', $component)
			->where('action', $action)
			->where('level', $level)
			->get_one();
	}
}
