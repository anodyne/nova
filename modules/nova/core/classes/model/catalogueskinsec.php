<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Skin Section Catalogue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Catalogueskinsec extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('catalogue_skinsecs');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'skinsec_id'
			)),
			'section' => new Field_String(array(
				'column' => 'skinsec_section'
			)),
			'skin' => new Field_String(array(
				'column' => 'skinsec_skin',
			)),
			'image' => new Field_String(array(
				'column' => 'skinsec_image_preview'
			)),
			'status' => new Field_Enum(array(
				'column' => 'skinsec_status',
				'choices' => array('active','inactive','development'),
				'default' => 'active'
			)),
			'default' => new Field_Enum(array(
				'column' => 'skinsec_default',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
		));
	}
}