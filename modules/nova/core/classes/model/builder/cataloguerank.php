<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Catalogue Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
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
}