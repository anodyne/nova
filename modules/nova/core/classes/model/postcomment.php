<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mission Posts Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Postcomment extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('posts_comments');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'pcomment_id'
			)),
			'author_user' => new Field_HasOne(array(
				'column' => 'pcomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => new Field_HasOne(array(
				'column' => 'pcomment_author_character',
				'foreign' => 'character'
			)),
			'post' => new Field_HasOne(array(
				'column' => 'pcomment_post',
				'foreign' => 'personallog.id'
			)),
			'content' => new Field_Text(array(
				'column' => 'pcomment_content'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'pcomment_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'status' => new Field_Enum(array(
				'column' => 'pcomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}