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
			'id' => Jelly::field('primary', array(
				'column' => 'misgroup_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'misgroup_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'misgroup_order'
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'misgroup_desc'
			)),
		));
	}
}