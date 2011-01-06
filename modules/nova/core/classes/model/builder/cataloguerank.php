<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Catalogue Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_Cataloguerank extends Jelly_Builder {
	
	/**
	 * Creates a where statement for figuring out the system default rank set.
	 *
	 *     $setting = Jelly::select('cataloguerank')->defaultrank()->load();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function defaultrank()
	{
		return $this->where('genre', '=', Kohana::config('nova.genre'))->where('default', '=', 'y')->limit(1);
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
