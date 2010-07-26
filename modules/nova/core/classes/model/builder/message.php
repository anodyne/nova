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
	 * Creates a where statement based on the message key value. Since we're trying pull
	 * a specific key and the keys are supposed to be unique, this also creates a LIMIT 1
	 * statement as well.
	 *
	 *     $message = Jelly::query('message')->key('key_name')->select();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function key($value)
	{
		return $this->where('key', '=', $value)->limit(1);
	}
}