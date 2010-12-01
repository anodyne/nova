<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Module Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Cataloguemodule extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_modules');
		$meta->name_key('shortname');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'module_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'module_name'
			)),
			'shortname' => Jelly::field('string', array(
				'column' => 'module_short_name'
			)),
			'location' => Jelly::field('string', array(
				'column' => 'module_location',
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'module_desc',
			)),
			'protected' => Jelly::field('enum', array(
				'column' => 'module_protected',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'module_status',
				'choices' => array('active','inactive'),
				'default' => 'active'
			)),
			'credits' => Jelly::field('text', array(
				'column' => 'module_credits'
			)),
		));
	}
}