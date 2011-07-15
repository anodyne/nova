<?php
/**
 * Ban Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Ban extends Model {
	
	public static $_table_name = 'bans';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'level' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'default' => ''),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'reason' => array(
			'type' => 'text'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
