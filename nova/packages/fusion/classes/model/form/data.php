<?php
/**
 * Form Data Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Form_Data extends \Model {
	
	public static $_table_name = 'form_data';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'form_key' => array(
			'type' => 'string',
			'constraint' => 20),
		'field_id' => array(
			'type' => 'bigint',
			'constraint' => 20),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'character_id' => array(
			'type' => 'string',
			'constraint' => 11),
		'item_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'value' => array(
			'type' => 'text',
			'null' => true),
		'updated_at' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'null' => true),
	);

	public static function get_data($field)
	{
		return static::find()->where('field_id', $field)->get();
	}
	
	/**
	 * Create data for a single field in the data table.
	 *
	 * @access	public
	 * @param	array 	the data array to use for creation
	 * @return	object	the created object
	 */
	public static function create_data(array $data)
	{
		$record = \Model_Form_Data::forge();
		
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
			$record->updated_at = time();
			$retval = $record->save();
			
			$results[] = ($retval !== false) ? true : $retval;
		}
		
		if (in_array(false, $results))
		{
			return false;
		}
		
		return true;
	}
}
