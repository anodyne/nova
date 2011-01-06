<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Access Groups Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Accessgroup extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('access_groups');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'group_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'group_name'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'group_order'
			)),
		));
	}
}
