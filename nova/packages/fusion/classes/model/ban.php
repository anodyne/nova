<?php
/**
 * Ban Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Ban extends \Model {
	
	public static $_table_name = 'bans';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'level' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'null' => true),
		'email' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'reason' => array(
			'type' => 'text',
			'null' => true),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
