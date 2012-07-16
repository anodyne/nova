<?php
/**
 * Access Roles-Tasks Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Access_RoleTask extends \Model {
	
	public static $_table_name = 'roles_tasks';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'role_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'task_id' => array(
			'type' => 'int',
			'constraint' => 11),
	);
}
