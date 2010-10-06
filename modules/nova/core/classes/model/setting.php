<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
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
	 * Pulls back specific settings from the database based on their key(s).
	 *
	 *     $settings = Jelly::factory('setting')->get_settings('sim_name');
	 *     $settings = Jelly::factory('setting')->get_settings(array('sim_name', 'sim_year'));
	 *
	 * @param	mixed	key(s) to pull back from the database
	 * @return	array 	an array of setting keys
	 */
	public static function get_settings($value)
	{
		// create a new class
		$obj = new stdClass;
		
		if (is_array($value))
		{
			$select = $value;
		}
		else
		{
			$select[] = $value;
		}
		
		$query = Jelly::query('setting')->select();
		
		if ($query)
		{
			foreach ($query as $i)
			{
				if (in_array($i->key, $select))
				{
					$obj->{$i->key} = $i->value;
				}
			}
		}
		
		return $obj;
	}
}