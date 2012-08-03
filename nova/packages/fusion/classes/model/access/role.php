<?php
/**
 * Access Role Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Access_Role extends \Model {
	
	/**
	 * Constants for the default access levels.
	 */
	const INACTIVE		= 1;
	const USER			= 2;
	const ACTIVE		= 3;
	const POWERUSER		= 4;
	const ADMIN			= 5;
	const SYSADMIN		= 6;
	
	public static $_table_name = 'roles';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'desc' => array(
			'type' => 'text',
			'null' => true),
		'inherits' => array(
			'type' => 'text',
			'null' => true),
	);
	
	public static $_has_many = array(
		'users' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'role_id',
			'key_from' => 'id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	public static $_many_many = array(
		'tasks' => array(
			'model_to' => '\\Model_Access_Task',
			'key_to' => 'id',
			'key_from' => 'id',
			'key_through_from' => 'role_id',
			'key_through_to' => 'task_id',
			'table_through' => 'roles_tasks',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Get a role from the database based on something other than their ID.
	 *
	 * @api
	 * @param	string	the column to use
	 * @param	mixed	the value to use
	 * @return	object	a role object
	 */
	public static function get_role($column, $value)
	{
		if (array_key_exists($column, static::$_properties))
		{
			return static::find()->where($column, $value)->get_one();
		}
		
		return false;
	}

	public static function get_roles()
	{
		$items = static::find('all');

		$roles = array();

		if (count($items) > 0)
		{
			foreach ($items as $r)
			{
				$roles[$r->id] = $r->name;
			}
		}

		return $roles;
	}
	
	public function get_tasks()
	{
		$groups[] = $this->tasks;
		
		$inherited = explode(',', $this->inherits);
		
		foreach ($inherited as $i)
		{
			//$groups[] = static::find($i)->get_tasks();
			\Debug::dump(static::find($i));
		}
		
		return $groups;
	}
}
