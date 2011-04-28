<?php
/**
 * Form Data Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_FormData extends Model {
	
	public static $_table_name = 'form_data';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20,
			'default' => ''),
		'field_id' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 8),
		'character_id' => array(
			'type' => 'string',
			'constraint' => 8),
		'item_id' => array(
			'type' => 'int',
			'constraint' => 10),
		'value' => array(
			'type' => 'text'),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20),
	);
	
	/**
	 * Create data for a single field in the data table.
	 *
	 * @access	public
	 * @param	array 	the data array to use for creation
	 * @return	object	the created object
	 */
	public static function create_data(array $data)
	{
		$record = Model_FormData::factory();
		
		foreach ($data as $key => $value)
		{
			$record->{$key} = $value;
		}
		
		$record->save();
		
		return $record;
	}
}
