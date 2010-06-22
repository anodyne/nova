<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Personal Logs Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Personallogcomment extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('personal_logs_comments');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'lcomment_id'
			)),
			'author_user' => new Field_HasOne(array(
				'column' => 'lcomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => new Field_HasOne(array(
				'column' => 'lcomment_author_character',
				'foreign' => 'character'
			)),
			'log' => new Field_HasOne(array(
				'column' => 'lcomment_log',
				'foreign' => 'personallog.id'
			)),
			'content' => new Field_Text(array(
				'column' => 'lcomment_content'
			)),
			'date' => new Field_Timestamp(array(
				'column' => 'lcomment_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'status' => new Field_Enum(array(
				'column' => 'lcomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}