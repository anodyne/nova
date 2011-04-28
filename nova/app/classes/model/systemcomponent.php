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
 
class Model_SystemComponent extends Model {
	
	public static $_table_name = 'system_components';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 4,
			'auto_increment' => true),
		'name' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'version' => array(
			'type' => 'string',
			'constraint' => 25,
			'default' => ''),
		'url' => array(
			'type' => 'text'),
		'desc' => array(
			'type' => 'text'),
	);
}
