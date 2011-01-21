<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Comments Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Comment extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'comment_id'
			)),
			'author_user' => Jelly::field('hasone', array(
				'column' => 'comment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('hasone', array(
				'column' => 'comment_author_character',
				'foreign' => 'character'
			)),
			'type' => Jelly::field('string', array(
				'column' => 'comment_type',
			)),
			'item' => Jelly::field('integer', array(
				'column' => 'comment_item_id',
			)),
			'content' => Jelly::field('text', array(
				'column' => 'comment_content'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'comment_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'comment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}
