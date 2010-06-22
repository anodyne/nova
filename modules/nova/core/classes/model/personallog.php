<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Personal Logs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Personallog extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('personal_logs');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'log_id'
			)),
			'title' => new Field_String(array(
				'column' => 'log_title'
			)),
			'author_user' => new Field_BelongsTo(array(
				'column' => 'log_author_user',
				'foreign' => 'user'
			)),
			'author_character' => new Field_BelongsTo(array(
				'column' => 'log_author_character',
				'foreign' => 'character'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'log_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => new Field_Text(array(
				'column' => 'log_content'
			)),
			'status' => new Field_Enum(array(
				'column' => 'log_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'tags' => new Field_Text(array(
				'column' => 'log_tags'
			)),
			'last_update' => new Field_Timestamp(array(
				'column' => 'log_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => new Field_HasMany(array(
				'foreign' => 'personallogcomment.lcomment_log'
			))
		));
	}
}