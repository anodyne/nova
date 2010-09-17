<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Wiki Categories Model
 *
 * @package		Thresher
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Wikicategory extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('wiki_categories');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'wikicat_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'wikicat_name'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'wikicat_desc'
			)),
		));
	}
}