<?php
/**
 * User Preferences Values Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_UserPrefValue extends Model {
	
	public static $_table_name = 'user_pref_values';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'key' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'value' => array(
			'type' => 'text'),
	);
	
	/**
	 * Create a user preference value.
	 *
	 * @access	public
	 * @param	array 	the data array for creation
	 * @return	object	the created object
	 */
	public static function create_value(array $data)
	{
		$record = Model_UserPrefValue::factory();
		
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		$record->save();
		
		return $record;
	}
}
