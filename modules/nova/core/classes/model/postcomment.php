<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mission Posts Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Postcomment extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('posts_comments');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'pcomment_id'
			)),
			'author_user' => Jelly::field('hasone', array(
				'column' => 'pcomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('hasone', array(
				'column' => 'pcomment_author_character',
				'foreign' => 'character'
			)),
			'post' => Jelly::field('hasone', array(
				'column' => 'pcomment_post',
				'foreign' => 'personallog.id'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'pcomment_content'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'pcomment_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'pcomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}