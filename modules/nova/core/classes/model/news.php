<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_News extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'news_id'
			)),
			'title' => new Field_String(array(
				'column' => 'news_title'
			)),
			'author_user' => new Field_BelongsTo(array(
				'column' => 'news_author_user',
				'foreign' => 'user'
			)),
			'author_character' => new Field_BelongsTo(array(
				'column' => 'news_author_character',
				'foreign' => 'character'
			)),
			'category' => new Field_HasOne(array(
				'column' => 'news_cat',
				'foreign' => 'newscategory.newscat_id'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'news_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => new Field_Text(array(
				'column' => 'news_content'
			)),
			'status' => new Field_Enum(array(
				'column' => 'news_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'private' => new Field_Enum(array(
				'column' => 'news_private',
				'choices' => array('y', 'n')
			)),
			'tags' => new Field_Text(array(
				'column' => 'news_tags'
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'news_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => new Field_HasMany(array(
				'foreign' => 'newscomment.ncomment_news'
			))
		));
	}
}