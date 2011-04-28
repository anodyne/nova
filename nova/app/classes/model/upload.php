<?php
/**
 * Uploads Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Upload extends Model {
	
	public static $_table_name = 'uploads';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'filename' => array(
			'type' => 'text'),
		'mime_type' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'resource_type' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16,
			'default' => ''),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
