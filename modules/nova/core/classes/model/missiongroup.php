<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Mission Groups Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Missiongroup extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('mission_groups');
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'misgroup_id'
			)),
			'name' => new Field_String(array(
				'column' => 'misgroup_name'
			)),
			'order' => new Field_Integer(array(
				'column' => 'misgroup_order'
			)),
			'desc' => new Field_Text(array(
				'column' => 'misgroup_desc'
			)),
		));
	}
}