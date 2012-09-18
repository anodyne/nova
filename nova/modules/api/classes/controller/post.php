<?php
/**
 * API controller for game mission posts.
 *
 * @package		Nova
 * @subpackage	API
 * @category	Controller
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 * @version		1.0
 */

namespace Api;

class Controller_Post extends \Controller_Rest
{
	/**
	 * The data return format.
	 */
	protected $format = 'json';

	/**
	 * Get a specific mission post.
	 *
	 *     api/post/item?id=1
	 *
	 * @since	1.0
	 * @param	int		the ID of the mission post
	 */
	public function get_item()
	{
		// sanitize the input
		$id = \Security::xss_clean(\Input::get('id'));

		// get the post
		$post = \Model_Post::find($id);

		if ($post and $post->status == \Status::ACTIVE)
		{
			$this->response(array(
				'title'		=> $post->title,
				'authors'	=> $post->showAuthors(),
				'content'	=> $post->content,
				'location'	=> $post->location,
				'timeline'	=> $post->timeline,
				'mission'	=> $post->mission->name,
				'date'		=> \Date::forge($post->date)->format(\Model_Settings::get_settings('date_format'))
			), 200);
		}
		else
		{
			$this->response(array('error' => 'Not found'), 404);
		}
	}
}
