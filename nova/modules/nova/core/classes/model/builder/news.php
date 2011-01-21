<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_News extends Jelly_Builder {
	
	/**
	 * Pulls all comments for the current news item.
	 *
	 *     $comments = Jelly::select('news', 1)->comments();
	 *
	 * @return	object Jelly_Builder object
	 */
	public function comments()
	{
		return Jelly::query('comment')->where('type', '=', 'news')->where('item', '=', $this->id)->select();
	}
}
