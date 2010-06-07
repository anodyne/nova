<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Message Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 */
 
class Model_Builder_Message extends Jelly_Builder
{
	/**
	 * Creates a where statement based on the message key value.
	 *
	 *     $message = Jelly::select('message')->key('key_name')->load();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function key($value)
	{
		return $this->where('key', '=', $value);
	}
}