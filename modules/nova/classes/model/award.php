<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Award Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Award extends Jelly_Model
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
				'column' => 'award_id'
			)),
			'name' => new Field_String(array(
				'column' => 'award_name'
			)),
			'image' => new Field_String(array(
				'column' => 'award_image',
			)),
			'order' => new Field_Integer(array(
				'column' => 'award_order',
			)),
			'desc' => new Field_Text(array(
				'column' => 'award_desc',
			)),
			'category' => new Field_Enum(array(
				'column' => 'award_cat',
				'choices' => array('ic','ooc','both'),
				'default' => 'ic'
			)),
			'display' => new Field_Enum(array(
				'column' => 'award_display',
				'choices' => array('y','n'),
				'default' => 'y'
			)),
		));
	}
}