<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Pages Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Accesspage extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_pages');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'page_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'page_name'
			)),
			'link' => Jelly::field('string', array(
				'column' => 'page_url'
			)),
			'level' => Jelly::field('string', array(
				'column' => 'page_level'
			)),
			'group' => Jelly::field('belongsto', array(
				'column' => 'page_group',
				'foreign' => 'accessgroup'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'page_desc'
			)),
		));
	}
}
