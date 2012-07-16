<?php
/**
 * User LOA Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_User_Loa extends \Model {
	
	public static $_table_name = 'user_loas';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'start' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'end' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'duration' => array(
			'type' => 'text',
			'null' => true),
		'reason' => array(
			'type' => 'text',
			'null' => true),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'active','loa','eloa'",
			'default' => 'loa'),
	);
}
