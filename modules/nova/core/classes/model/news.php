<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_News extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'news_id'
			)),
			'title' => Jelly::field('string', array(
				'column' => 'news_title'
			)),
			'author_user' => Jelly::field('belongsto', array(
				'column' => 'news_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('belongsto', array(
				'column' => 'news_author_character',
				'foreign' => 'character'
			)),
			'category' => Jelly::field('hasone', array(
				'column' => 'news_cat',
				'foreign' => 'newscategory.newscat_id'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'news_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => Jelly::field('text', array(
				'column' => 'news_content'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'news_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'private' => Jelly::field('enum', array(
				'column' => 'news_private',
				'choices' => array('y', 'n')
			)),
			'tags' => Jelly::field('text', array(
				'column' => 'news_tags'
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'news_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => Jelly::field('hasmany', array(
				'foreign' => 'newscomment.ncomment_news'
			))
		));
	}
}