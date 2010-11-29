<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User LOA Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Userloa extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('user_loa');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'loa_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'loa_user',
				'foreign' => 'user'
			)),
			'start' => Jelly::field('timestamp', array(
				'column' => 'loa_start_date',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'end' => Jelly::field('timestamp', array(
				'column' => 'loa_end_date',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'duration' => Jelly::field('text', array(
				'column' => 'loa_duration'
			)),
			'reason' => Jelly::field('text', array(
				'column' => 'loa_reason'
			)),
			'type' => Jelly::field('enum', array(
				'column' => 'loa_type',
				'choices' => array('active', 'loa', 'eloa'),
				'default' => 'loa'
			)),
		));
	}
}