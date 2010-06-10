<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Setting Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 */
 
class Model_Builder_Setting extends Jelly_Builder
{
	/**
	 * Creates a where statement based on the setting key value.
	 *
	 *     $setting = Jelly::select('setting')->key('sim_name')->load();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function key($value)
	{
		return $this->where('key', '=', $value);
	}
}