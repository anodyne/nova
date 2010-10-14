<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Rank Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Cataloguerank extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_ranks');
		$meta->name_key('location');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'rankcat_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'rankcat_name'
			)),
			'location' => Jelly::field('string', array(
				'column' => 'rankcat_location',
			)),
			'preview' => Jelly::field('string', array(
				'column' => 'rankcat_preview',
			)),
			'blank' => Jelly::field('string', array(
				'column' => 'rankcat_blank',
			)),
			'extension' => Jelly::field('string', array(
				'column' => 'rankcat_extension',
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'rankcat_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'credits' => Jelly::field('text', array(
				'column' => 'rankcat_credits'
			)),
			'default' => Jelly::field('enum', array(
				'column' => 'rankcat_default',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'genre' => Jelly::field('string', array(
				'column' => 'rankcat_genre'
			))
		));
	}
}