<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mission Posts Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Post extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'post_id'
			)),
			'title' => Jelly::field('string', array(
				'column' => 'post_title'
			)),
			'authors' => Jelly::field('text', array(
				'column' => 'post_authors'
			)),
			'author_users' => Jelly::field('text', array(
				'column' => 'post_authors_users'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'post_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => Jelly::field('text', array(
				'column' => 'post_content'
			)),
			'location' => Jelly::field('string', array(
				'column' => 'post_location'
			)),
			'timeline' => Jelly::field('string', array(
				'column' => 'post_timeline'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'post_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'saved' => Jelly::field('integer', array(
				'column' => 'post_saved'
			)),
			'tags' => Jelly::field('text', array(
				'column' => 'post_tags'
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'post_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => Jelly::field('hasmany', array(
				'foreign' => 'postcomment.pcomment_post'
			))
		));
	}
}