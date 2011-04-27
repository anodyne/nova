<?php
/**
 * System Versions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_SystemVersion extends Orm\Model {
	
	public static $_table_name = 'system_versions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 4,
			'auto_increment' => true),
		'version' => array(
			'type' => 'string',
			'constraint' => 25,
			'default' => ''),
		'major' => array(
			'type' => 'int',
			'constraint' => 1),
		'minor' => array(
			'type' => 'int',
			'constraint' => 2),
		'update' => array(
			'type' => 'int',
			'constraint' => 4),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'launch' => array(
			'type' => 'text'),
		'changes' => array(
			'type' => 'text'),
	);
}
