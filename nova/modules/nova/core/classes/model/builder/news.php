<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Builder Model
 *
 * @package		Nova
 * @category	Model Builders
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		2.0
 */
 
class Model_Builder_News extends Jelly_Builder {
	
	/**
	 * Pulls all comments for the current news item.
	 *
	 *     $comments = Jelly::select('news', 1)->comments();
	 *     $pending = Jelly::select('news', 1)->comments('pending');
	 *
	 * @param	string	the status to pull from the database
	 * @return	object	Jelly_Builder object
	 */
	public function comments($status = 'activated')
	{
		$query = Jelly::query('comment')->where('type', '=', 'news')->where('item', '=', $this->id);
		
		if ( ! empty($status))
		{
			$query->where('status', '=', $status);
		}
		
		return $query->select();
	}
}
