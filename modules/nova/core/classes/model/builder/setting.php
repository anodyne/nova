<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_Setting extends Jelly_Builder {
	
	/**
	 * Pulls back specific settings from the database based on their key(s).
	 *
	 *     $settings = Jelly::factory('setting')->get_settings('sim_name');
	 *     $settings = Jelly::factory('setting')->get_settings(array('sim_name', 'sim_year'));
	 *
	 * @param	mixed	key(s) to pull back from the database
	 * @return	array 	an array of setting keys
	 */
	public function get_settings($value)
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
		
		$query = $this->select();
		
		if (count($query) > 0)
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
	
	/**
	 * Overrides the unique key functionality so that the model will understand
	 * both numeric values for primary keys and string values for the name key.
	 *
	 * @param	mixed	value to use as the unique key
	 * @return	object	the primary key or name key object
	 */
	public function unique_key($value)
	{
		if (is_numeric($value))
		{
			return $this->_meta->primary_key();
		}
		else
		{
			return $this->_meta->name_key();
		}
	}
}
