<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Newscomment extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_comments');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'ncomment_id'
			)),
			'author_user' => Jelly::field('hasone', array(
				'column' => 'ncomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('hasone', array(
				'column' => 'ncomment_author_character',
				'foreign' => 'character'
			)),
			'news' => Jelly::field('hasone', array(
				'column' => 'ncomment_news',
				'foreign' => 'news.id'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'ncomment_content'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'ncomment_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'ncomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}