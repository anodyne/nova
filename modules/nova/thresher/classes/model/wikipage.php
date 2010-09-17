<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Wiki Pages Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Wikipage extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('wiki_pages');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'page_id'
			)),
			'draft' => Jelly::field('belongsto', array(
				'column' => 'page_draft',
				'foreign' => 'wikidraft'
			)),
			'created_at' => Jelly::field('timestamp', array(
				'column' => 'page_created_at',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'created_by_user' => Jelly::field('belongsto', array(
				'column' => 'page_created_by_user',
				'foreign' => 'user'
			)),
			'created_by_character' => Jelly::field('belongsto', array(
				'column' => 'page_created_by_character',
				'foreign' => 'character'
			)),
			'updated_at' => Jelly::field('timestamp', array(
				'column' => 'page_updated_at',
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'updated_by_user' => Jelly::field('belongsto', array(
				'column' => 'page_updated_by_user',
				'foreign' => 'user'
			)),
			'updated_by_character' => Jelly::field('belongsto', array(
				'column' => 'page_updated_by_character',
				'foreign' => 'character'
			)),
			'page_comments' => Jelly::field('text', array(
				'column' => 'page_comments',
			)),
			'comments' => Jelly::field('hasmany', array(
				'foreign' => 'wikicomment.wcomment_page'
			))
		));
	}
}