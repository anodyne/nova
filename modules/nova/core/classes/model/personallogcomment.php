<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Personal Logs Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Personallogcomment extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('personal_logs_comments');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'lcomment_id'
			)),
			'author_user' => Jelly::field('hasone', array(
				'column' => 'lcomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('hasone', array(
				'column' => 'lcomment_author_character',
				'foreign' => 'character'
			)),
			'log' => Jelly::field('hasone', array(
				'column' => 'lcomment_log',
				'foreign' => 'personallog.id'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'lcomment_content'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'lcomment_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'lcomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}