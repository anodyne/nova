<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Sim Type Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Simtype extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('sim_type');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'simtype_id'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'simtype_name'
			)),
		));
	}
}