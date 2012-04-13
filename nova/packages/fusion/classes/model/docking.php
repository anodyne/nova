<?php
/**
 * Docking Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Docking extends \Model {
	
	public static $_table_name = 'docking';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'sim_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'sim_url' => array(
			'type' => 'text',
			'null' => true),
		'gm_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'gm_email' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','pending'",
			'default' => 'pending'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
