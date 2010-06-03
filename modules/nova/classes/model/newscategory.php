<?php defined('SYSPATH') or die('No direct script access.');
/**
 * News Categories Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Newscategory extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('news_categories');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'newscat_id'
			)),
			'name' => new Field_String(array(
				'column' => 'newscat_name'
			)),
			'display' => new Field_Enum(array(
				'column' => 'newscat_display',
				'choices' => array('y', 'n'),
				'default' => 'y'
			)),
		));
	}
}