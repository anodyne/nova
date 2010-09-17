<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Wiki Comments Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Wikicomment extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('wiki_comments');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'wcomment_id'
			)),
			'author_user' => Jelly::field('belongsto', array(
				'column' => 'wcomment_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('belongsto', array(
				'column' => 'wcomment_author_character',
				'foreign' => 'character'
			)),
			'page' => Jelly::field('belongsto', array(
				'column' => 'wcomment_page',
				'foreign' => 'wikipage'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'wcomment_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'content' => Jelly::field('text', array(
				'column' => 'wcomment_content'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'wcomment_status',
				'choices' => array('activated', 'pending'),
				'default' => 'activated'
			)),
		));
	}
}