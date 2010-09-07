<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Personal Logs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Personallog extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('personal_logs');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'log_id'
			)),
			'title' => Jelly::field('string', array(
				'column' => 'log_title'
			)),
			'author_user' => Jelly::field('belongsto', array(
				'column' => 'log_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('belongsto', array(
				'column' => 'log_author_character',
				'foreign' => 'character'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'log_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => Jelly::field('text', array(
				'column' => 'log_content'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'log_status',
				'choices' => array('activated', 'saved', 'pending')
			)),
			'tags' => Jelly::field('text', array(
				'column' => 'log_tags'
			)),
			'last_update' => Jelly::field('timestamp', array(
				'column' => 'log_last_update',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'comments' => Jelly::field('hasmany', array(
				'foreign' => 'personallogcomment.lcomment_log'
			))
		));
	}
}