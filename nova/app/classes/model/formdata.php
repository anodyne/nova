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
	
	/**
	 * Update data in the data table.
	 *
	 * @access	public
	 * @param	string	the form to update
	 * @param	int		the ID to udpate
	 * @param	array 	a data array of information to update
	 * @return	bool	whether it was successful or not
	 */
	public static function update_data($type, $id, array $data)
	{
		$results = array();
		
		// figure out what field we need to use
		switch ($type)
		{
			case 'bio':
				$field = 'character_id';
			break;
			
			case 'user':
				$field = 'user_id';
			break;
			
			default:
				$field = 'item_id';
			break;
		}
		
		// loop through the data array and make the changes
		foreach ($data as $key => $value)
		{
			// get the record
			$record = static::find()->where('field_id', $key)->where($field, $id)->get_one();
			
			// update the values
			$record->value = $value;
			$record->updated_at = Date::now();
			$retval = $record->save();
			
			$results[] = ($retval !== false) ? true : $retval;
		}
		
		DBForge::optimize('form_data');
		
		if (in_array(false, $results))
		{
			return false;
		}
		
		return true;
	}
}
