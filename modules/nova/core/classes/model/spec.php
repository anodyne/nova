<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Specs Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Spec extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'specs_id'
			)),
			'name' => new Field_String(array(
				'column' => 'specs_name'
			)),
			'order' => new Field_Integer(array(
				'column' => 'specs_order'
			)),
			'display' => new Field_Enum(array(
				'column' => 'specs_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'images' => new Field_Text(array(
				'column' => 'specs_images',
			)),
			'summary' => new Field_Text(array(
				'column' => 'specs_summary',
			)),
			'touritems' => new Field_HasMany(array(
				'foreign' => 'tour.specitem'
			)),
		));
	}
}