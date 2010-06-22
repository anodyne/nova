<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Tour Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Tour extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('tour');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'tour_id'
			)),
			'name' => new Field_String(array(
				'column' => 'tour_name'
			)),
			'order' => new Field_Integer(array(
				'column' => 'tour_order'
			)),
			'display' => new Field_Enum(array(
				'column' => 'tour_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
			'images' => new Field_Text(array(
				'column' => 'tour_images',
			)),
			'summary' => new Field_Text(array(
				'column' => 'tour_summary',
			)),
		));
	}
}