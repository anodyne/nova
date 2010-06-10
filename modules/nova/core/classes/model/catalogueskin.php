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
			'id' => new Field_Primary(array(
				'column' => 'skin_id'
			)),
			'name' => new Field_String(array(
				'column' => 'skin_name'
			)),
			'location' => new Field_String(array(
				'column' => 'skin_location',
			)),
			'credits' => new Field_Text(array(
				'column' => 'skin_credits'
			)),
		));
	}
}