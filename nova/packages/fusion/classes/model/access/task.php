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

class Model_Access_Task extends \Model {
	
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
}
