<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Application Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Application extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'app_id'
			)),
			'email' => Jelly::field('email', array(
				'column' => 'app_email'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'app_user',
				'foreign' => 'user'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'app_user_name'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'app_character',
				'foreign' => 'character'
			)),
			'charname' => Jelly::field('string', array(
				'column' => 'app_character_name'
			)),
			'position' => Jelly::field('string', array(
				'column' => 'app_position',
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'app_date',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'action' => Jelly::field('string', array(
				'column' => 'app_action'
			)),
			'message' => Jelly::field('text', array(
				'column' => 'app_message'
			)),
		));
	}
}