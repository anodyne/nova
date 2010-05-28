<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Postion Builder Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Builder_Position extends Jelly_Builder
{
	public function open()
	{
		return $this->where('open', '>', 0);
	}
}

// End of file character.php
// Location: modules/nova/classes/model/builder/character.php