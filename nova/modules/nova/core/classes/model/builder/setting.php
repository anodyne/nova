<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Settings Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		3.0
 */
 
class Model_Builder_Setting extends Jelly_Builder {
	
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
