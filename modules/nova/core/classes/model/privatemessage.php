<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Private Messages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Privatemessage extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('private_messages');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'privmsgs_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'privmsgs_author_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'privmsgs_author_character',
				'foreign' => 'character'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'privmsgs_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'subject' => Jelly::field('string', array(
				'column' => 'privmsgs_subject'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'privmsgs_content'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'privmsgs_author_display',
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
			'to' => Jelly::field('hasmany', array(
				'foreign' => 'privatemessageto.message'
			)),
		));
	}
}