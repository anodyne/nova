<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Skin Section Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Catalogueskinsec extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_skinsecs');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'skinsec_id'
			)),
			'section' => Jelly::field('string', array(
				'column' => 'skinsec_section'
			)),
			'skin' => Jelly::field('belongsto', array(
				'column' => 'skinsec_skin',
				'foreign' => 'catalogueskin.location'
			)),
			'image' => Jelly::field('string', array(
				'column' => 'skinsec_image_preview'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'skinsec_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'default' => Jelly::field('enum', array(
				'column' => 'skinsec_default',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
		));
	}
}
