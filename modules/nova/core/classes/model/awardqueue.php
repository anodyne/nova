<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Awards Queue Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Awardqueue extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('awards_queue');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'queue_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'queue_receive_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'queue_receive_character',
				'foreign' => 'character'
			)),
			'nominated' => Jelly::field('belongsto', array(
				'column' => 'queue_nominate',
				'foreign' => 'user'
			)),
			'award' => Jelly::field('belongsto', array(
				'column' => 'queue_award',
				'foreign' => 'award'
			)),
			'reason' => Jelly::field('text', array(
				'column' => 'queue_reason'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'queue_status',
				'choices' => array('pending', 'accepted', 'rejected'),
				'default' => 'pending'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'queue_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
		));
	}
}