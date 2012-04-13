<?php
/**
 * Uploads Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Upload extends \Model {
	
	public static $_table_name = 'uploads';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'filename' => array(
			'type' => 'text',
			'null' => true),
		'mime_type' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'resource_type' => array(
			'type' => 'string',
			'constraint' => 100,
			'null' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'ip_address' => array(
			'type' => 'string',
			'constraint' => 16),
		'date' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
}
