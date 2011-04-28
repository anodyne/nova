<?php
/**
 * Docking Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Docking extends Model {
	
	public static $_table_name = 'docking';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'sim_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'sim_url' => array(
			'type' => 'text'),
		'gm_name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'gm_email' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'status' => array(
			'type' => 'enum',
			'constraint' => "'active','inactive','pending'",
			'default' => 'pending'),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
