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
			'id' => new Field_Primary(array(
				'column' => 'ncomment_id'
			)),
			'author_user' => new Field_HasOne(array(
				'column' => 'ncomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => new Field_HasOne(array(
				'column' => 'ncomment_author_character',
				'foreign' => 'character'
			)),
			'news' => new Field_HasOne(array(
				'column' => 'ncomment_news',
				'foreign' => 'news.id'
			)),
			'content' => new Field_Text(array(
				'column' => 'ncomment_content'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'ncomment_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'status' => new Field_Enum(array(
				'column' => 'ncomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}