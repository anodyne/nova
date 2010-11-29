<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Docking Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Docking extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('docking');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'docking_id'
			)),
			'sim' => Jelly::field('string', array(
				'column' => 'docking_sim_name'
			)),
			'url' => Jelly::field('text', array(
				'column' => 'docking_sim_url'
			)),
			'gm' => Jelly::field('string', array(
				'column' => 'docking_gm_name'
			)),
			'email' => Jelly::field('email', array(
				'column' => 'docking_gm_email',
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'docking_status',
				'choices' => array('active', 'inactive', 'pending'),
				'default' => 'pending'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'docking_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
		));
	}
}