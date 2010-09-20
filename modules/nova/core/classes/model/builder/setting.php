<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Setting Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 */
 
class Model_Builder_Setting extends Jelly_Builder {
	
	/**
	 * Creates a where statement based on the setting ID value. Since we're trying pull
	 * a specific ID this also creates a LIMIT 1 statement as well.
	 *
	 *     $setting = Jelly::query('setting')->id(1)->select();
	 *
	 * @return	object Jelly_Builder object
	 */
	//public function id($value)
	//{
	//	return $this->where('id', '=', $value)->limit(1);
	//}
	
	/**
	 * Creates a where statement based on the setting key value. Since we're trying pull
	 * a specific key and the keys are supposed to be unique, this also creates a LIMIT 1
	 * statement as well.
	 *
	 *     $setting = Jelly::query('setting')->key('sim_name')->select();
	 *
	 * @return	object Jelly_Builder object
	 */
	//public function key($value)
	//{
	//	return $this->where('key', '=', $value)->limit(1);
	//}
}