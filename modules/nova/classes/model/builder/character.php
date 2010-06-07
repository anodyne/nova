<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 */
 
class Model_Builder_Character extends Jelly_Builder
{
	/**
	 * Pulls active characters from the database.
	 *
	 *     $characters = Jelly::select('character')->active()->execute();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function active()
	{
		return $this->where('type', '=', 'active');
	}
	
	/**
	 * Pulls inactive characters from the database.
	 *
	 *     $characters = Jelly::select('character')->inactive()->execute();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function inactive()
	{
		return $this->where('type', '=', 'inactive');
	}
	
	/**
	 * Pulls non-playing characters from the database.
	 *
	 *     $characters = Jelly::select('character')->npc()->execute();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function npc()
	{
		return $this->where('type', '=', 'npc');
	}
	
	/**
	 * Pulls pending characters from the database.
	 *
	 *     $characters = Jelly::select('character')->pending()->execute();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function pending()
	{
		return $this->where('type', '=', 'pending');
	}
}