<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Skin Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Catalogueskin extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_skins');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'skin_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'skin_name'
			)),
			'location' => Jelly::field('string', array(
				'column' => 'skin_location',
			)),
			'credits' => Jelly::field('text', array(
				'column' => 'skin_credits'
			)),
		));
	}
}