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
			'id' => new Field_Primary(array(
				'column' => 'post_id'
			)),
			'title' => new Field_String(array(
				'column' => 'post_title'
			)),
			'authors' => new Field_Text(array(
				'column' => 'post_authors'
			)),
			'author_users' => new Field_Text(array(
				'column' => 'post_authors_users'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'post_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => new Field_Text(array(
				'column' => 'post_content'
			)),
			'location' => new Field_String(array(
				'column' => 'post_location'
			)),
			'timeline' => new Field_String(array(
				'column' => 'post_timeline'
			)),
			'status' => new Field_Enum(array(
				'column' => 'post_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'saved' => new Field_Integer(array(
				'column' => 'post_saved'
			)),
			'tags' => new Field_Text(array(
				'column' => 'post_tags'
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'post_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => new Field_HasMany(array(
				'foreign' => 'postcomment.pcomment_post'
			))
		));
	}
}