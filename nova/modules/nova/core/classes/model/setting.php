<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		3.0
 */
 
class Model_Setting extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->name_key('key');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'setting_id'
			)),
			'key' => Jelly::field('string', array(
				'column' => 'setting_key'
			)),
			'value' => Jelly::field('text', array(
				'column' => 'setting_value'
			)),
			'label' => Jelly::field('string', array(
				'column' => 'setting_label'
			)),
			'user_created' => Jelly::field('enum', array(
				'column' => 'setting_user_created',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
	
	/**
	 * Find a single setting in the database.
	 *
	 * @access	public
	 * @param	int		the key of the setting to pull
	 * @param	bool	whether to return just the value or the entire object
	 * @return	mixed	a Jelly_Collection if there are results or FALSE if there are no results
	 */
	public static function find($key, $only_value = true)
	{
		$result = Jelly::query('setting', $key)->limit(1)->select();
		
		if (count($result) > 0)
		{
			if ($only_value)
			{
				return $result->value;
			}
			
			return $result;
		}
		
		return false;
	}
	
	/**
	 * Find all settings from the database unless an array is passed to the first
	 * parameter. If that happens, only pull back those specific setting items.
	 *
	 *     $settings = Model_Setting::find_all();
	 *     $settings = Model_Setting::find_all(array('sim_name', 'sim_year'));
	 *
	 * @param	array	an array of setting keys to pull back
	 * @return	mixed	either an object if there are results or FALSE
	 */
	public static function find_all(array $values = array())
	{
		$result = Jelly::query('setting')->select();
		
		if (count($result) > 0)
		{
			$obj = new stdClass;
			
			if (count($values) > 0)
			{
				foreach ($result as $r)
				{
					if (in_array($r->key, $values))
					{
						$obj->{$r->key} = $r->value;
					}
				}
				
				return $obj;
			}
			
			return $result;
		}
		
		return false;
	}
}
