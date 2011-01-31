<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Skin Section Catalogue Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_Catalogueskinsec extends Jelly_Builder {
	
	/**
	 * Creates a where statement for figuring out the system default skin for a section.
	 *
	 *     $setting = Jelly::select('catalogueskinsec')->defaultskin('main')->load();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function defaultskin($section)
	{
		return $this->where('status', '=', 'active')->where('default', '=', 'y')->where('section', '=', $section)->limit(1);
	}
}
