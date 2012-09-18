<?php
/**
 * Character Positions Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_Character_Positions extends \Model
{
	public static $_table_name = 'character_positions';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'bigint',
			'constraint' => 20,
			'auto_increment' => true),
		'character_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'position_id' => array(
			'type' => 'int',
			'constraint' => 11),
		'primary' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 0),
	);

	/**
	 * Get the records for character positions.
	 *
	 * @api
	 * @param	mixed	the ID to use or an array of conditions
	 * @param	string	the column to use (character_id, position_id)
	 * @return	object
	 */
	public static function getItems($value, $column = 'character_id')
	{
		if (is_array($value))
		{
			// start the find
			$query = static::find();

			// loop through the array of values and build the WHERE
			foreach ($value as $col => $val)
			{
				$query->where($col, $val);
			}

			return $query->get();
		}

		return static::find()->where($column, $value)->get();
	}
}
