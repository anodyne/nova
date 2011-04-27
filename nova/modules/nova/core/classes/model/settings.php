<?php
/**
 * Settings Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @version		3.0
 */
 
class Model_Settings extends Orm\Model {
	
	public static $_table_name = 'settings';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 5,
			'auto_increment' => true),
		'key' => array(
			'type' => 'string',
			'constraint' => 100,
			'default' => ''),
		'value' => array(
			'type' => 'text'),
		'label' => array(
			'type' => 'string',
			'constraint' => 255,
			'default' => ''),
		'user_created' => array(
			'type' => 'tinyint',
			'constraint' => 1,
			'default' => 1),
	);
	
	/**
	 * Get a specific set of settings from the database.
	 *
	 *     Model_Settings::get_settings('email_format');
	 *     Model_Settings::get_settings(array('sim_name', 'sim_year'));
	 *
	 * @access	public
	 * @param	mixed 	a string with one key or an array of keys to use
	 * @param	boolean	whether to pull the value only (applies to single key requests)
	 * @return	mixed	a string with the setting value, an object of the single setting or an object with the setting values requested
	 */
	public static function get_settings($keys, $value_only = true)
	{
		if (is_array($keys))
		{
			$obj = new stdClass;
			
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
			$query = static::find()->where('key', $keys)->get_one();
			
			if ($value_only === true)
			{
				return $query->value;
			}
			
			return $query;
		}
	}
	
	/**
	 * Update system settings.
	 *
	 *     $data = array('sim_name' => 'Nova 3');
	 *     $update = Model_Settings::update_settings($data);
	 *
	 * You can also pass a larger array with multiple values to the method to
	 * update multiple settings at the same time. The data array just needs to
	 * stay in the (setting key) => (setting value) format.
	 *
	 *     $data = array('sim_name' => 'Nova 3', 'sim_year' => 3150, 'maintenance' => 0);
	 *     $update = Model_Settings::update_settings($data);
	 *
	 * @access	public
	 * @param	array 	the data array for updating the settings
	 * @return	void
	 */
	public static function update_settings(array $data)
	{
		foreach ($data as $key => $value)
		{
			$record = static::find('first', array(
				'where' => array('key', $key),
			));
			
			$record->value = $value;
			$record->save();
		}
	}
}
