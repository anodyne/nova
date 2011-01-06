<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Moderation Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Moderation extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('moderation');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'moderation_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'moderation_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'moderation_character',
				'foreign' => 'character'
			)),
			'type' => Jelly::field('string', array(
				'column' => 'moderation_type'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'moderation_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}
