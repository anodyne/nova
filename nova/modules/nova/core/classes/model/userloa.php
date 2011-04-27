<?php
/**
 * User LOA Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_UserLoa extends Orm\Model {
	
	public static $_table_name = 'user_loas';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 10,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'start' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'end' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'duration' => array(
			'type' => 'text'),
		'reason' => array(
			'type' => 'text'),
		'type' => array(
			'type' => 'enum',
			'constraint' => "'active','loa','eloa'",
			'default' => 'loa'),
	);
}
