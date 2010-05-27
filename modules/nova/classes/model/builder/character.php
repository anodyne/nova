<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Builder Model
 *
 * @package		Nova Core
 * @subpackage	Model
 * @author		Anodyne Productions
 * @version		2.0
 */
 
class Model_Builder_Character extends Jelly_Builder
{
	public function active()
	{
		return $this->where('type', '=', 'active');
	}
	
	public function inactive()
	{
		return $this->where('type', '=', 'inactive');
	}
	
	public function npc()
	{
		return $this->where('type', '=', 'npc');
	}
	
	public function pending()
	{
		return $this->where('type', '=', 'pending');
	}
}

// End of file character.php
// Location: modules/nova/classes/model/builder/character.php