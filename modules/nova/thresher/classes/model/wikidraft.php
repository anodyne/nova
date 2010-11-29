<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Wiki Drafts Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Wikidraft extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('wiki_drafts');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'draft_id'
			)),
			'old_id' => Jelly::field('integer', array(
				'column' => 'draft_id_old'
			)),
			'title' => Jelly::field('string', array(
				'column' => 'draft_title'
			)),
			'author_user' => Jelly::field('belongsto', array(
				'column' => 'draft_author_user',
				'foreign' => 'user'
			)),
			'author_character' => Jelly::field('belongsto', array(
				'column' => 'draft_author_character',
				'foreign' => 'character'
			)),
			'summary' => Jelly::field('text', array(
				'column' => 'draft_summary'
			)),
			'content' => Jelly::field('text', array(
				'column' => 'draft_content'
			)),
			'page' => Jelly::field('belongsto', array(
				'column' => 'draft_page',
				'foreign' => 'wikipage'
			)),
			'created_at' => Jelly::field('timestamp', array(
				'column' => 'draft_created_at',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'categories' => Jelly::field('text', array(
				'column' => 'draft_categories'
			)),
			'change_comments' => Jelly::field('text', array(
				'column' => 'draft_changed_comments'
			)),
		));
	}
}