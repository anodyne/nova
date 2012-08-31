<?php
/**
 * User Suspension Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_User_Suspend extends \Model {
	
	public static $_table_name = 'users_suspended';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'login_id' => array(
			'type' => 'string',
			'constraint' => 50),
		'attempts' => array(
			'type' => 'int',
			'constraint' => 50),
		'ip' => array(
			'type' => 'string',
			'constraint' => 16),
		'last_attempt_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'suspended_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'unsuspend_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	public static function clear_item(array $conditions)
	{
		// start the find process
		$items = static::find();

		// loop through all the conditions and build the find
		foreach ($conditions as $col => $val)
		{
			$items->where($col, $val);
		}

		// delete the items
		$items->delete();
	}
}
