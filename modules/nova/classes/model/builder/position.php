<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Postion Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 */
 
class Model_Builder_Position extends Jelly_Builder
{
	/**
	 * Pulls open positions from the database.
	 *
	 *     $positions = Jelly::select('position')->open()->execute();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function open()
	{
		return $this->where('open', '>', 0);
	}
}