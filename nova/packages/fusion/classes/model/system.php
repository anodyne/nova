<?php
/**
 * System Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_System extends \Model {
	
	public static $_table_name = 'system_info';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 1,
			'auto_increment' => true),
		'uid' => array(
			'type' => 'string',
			'constraint' => 32,
			'null' => true),
		'install_date' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'last_update' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
		'version_major' => array(
			'type' => 'int',
			'constraint' => 1,
			'default' => 3),
		'version_minor' => array(
			'type' => 'int',
			'constraint' => 2),
		'version_update' => array(
			'type' => 'int',
			'constraint' => 4),
		'version_ignore' => array(
			'type' => 'string',
			'constraint' => 20,
			'null' => true),
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
	
	/**
	 * Update the system information.
	 *
	 * @access	public
	 * @return	object	the object that was just updated
	 */
	public static function update_info(array $data)
	{
		// get the first record in the table
		$record = static::find('first');
		
		// loop through the data we have and update the object
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		// save the record
		$record->save();
		
		return $record;
	}
}
