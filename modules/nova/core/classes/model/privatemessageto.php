<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Private Messages To Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Privatemessageto extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('private_messages_to');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'pmto_id'
			)),
			'message' => Jelly::field('belongsto', array(
				'column' => 'pmto_message',
				'foreign' => 'privatemessage'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'pmto_recipient_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'pmto_recipient_character',
				'foreign' => 'character'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'pmto_display',
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
			'unread' => Jelly::field('enum', array(
				'column' => 'pmto_unread',
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
		));
	}
}
