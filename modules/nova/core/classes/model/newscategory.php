<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Categories Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Newscategory extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_categories');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'newscat_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'newscat_name'
			)),
			'display' => Jelly::field('enum', array(
				'column' => 'newscat_display',
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
		));
	}
}