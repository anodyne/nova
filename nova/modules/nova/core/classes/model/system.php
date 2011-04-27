<?php
/**
 * System Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_System extends Orm\Model {
	
	public static $_table_name = 'system_info';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 4,
			'auto_increment' => true),
		'uid' => array(
			'type' => 'string',
			'constraint' => 32,
			'default' => ''),
		'install_date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'last_update' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'version_major' => array(
			'type' => 'int',
			'constraint' => 1),
		'version_minor' => array(
			'type' => 'int',
			'constraint' => 2),
		'version_update' => array(
			'type' => 'int',
			'constraint' => 4),
		'version_ignore' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
	);
	
	/**
	 * Get the RPG unique identifier.
	 *
	 * @access	public
	 * @return	string	the UID
	 */
	public static function get_uid()
	{
		return static::find('first')->uid;
	}
}
