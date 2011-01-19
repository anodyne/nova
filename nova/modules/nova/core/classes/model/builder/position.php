<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Postion Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_Position extends Jelly_Builder {
	
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
