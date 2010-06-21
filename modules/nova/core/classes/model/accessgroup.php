<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Groups Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Accessgroup extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_groups');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'group_id'
			)),
			'name' => new Field_String(array(
				'column' => 'group_name'
			)),
			'order' => new Field_Integer(array(
				'column' => 'group_order'
			)),
		));
	}
}