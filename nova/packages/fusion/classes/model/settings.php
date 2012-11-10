<?php
/**
 * Settings Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;
 
class Model_Settings extends \Model
{
	public static $_table_name = 'settings';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 100),
		'value' => array(
			'type' => 'text',
			'null' => true),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'null' => true),
		'help' => array(
			'type' => 'text',
			'null' => true),
		'user_created' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	/**
	 * Get a specific set of settings from the database.
	 *
	 * @api
	 * @param	mixed 	a string with one key or an array of keys to use
	 * @param	boolean	whether to pull the value only (applies to single key requests)
	 * @return	mixed
	 */
	public static function getItems($keys, $value_only = true)
	{
		if (is_array($keys))
		{
			$obj = new \stdClass;
			
			$settings = static::find('all');
			
			foreach ($settings as $s)
			{
				if (in_array($s->key, $keys))
				{
					$obj->{$s->key} = $s->value;
				}
			}
			
			return $obj;
		}
		else
		{
			if ($keys === false or $keys === null)
			{
				$obj = new \stdClass;
				
				$settings = static::find('all');
				
				foreach ($settings as $s)
				{
					$obj->{$s->key} = $s->value;
				}
				
				return $obj;
			}
			else
			{
				$query = static::query()->where('key', $keys)->get_one();
				
				if ($value_only === true)
				{
					return $query->value;
				}
				
				return $query;
			}
		}
	}
	
	/**
	 * Update system settings.
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 * @api
	 * @param	array 	the data array for updating the settings
	 * @return	void
	 */
	public static function updateItems(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::query()->where('key', $key)->get_one();

			if ($record)
			{
				$record->value = $value;
				$record->save();
			}
		}
	}
}
