<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Awards Received Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Awardrec extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->table('awards_received');
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'awardrec_id'
			)),
			'user' => Jelly::field('belongsto', array(
				'column' => 'awardrec_user',
				'foreign' => 'user'
			)),
			'character' => Jelly::field('belongsto', array(
				'column' => 'awardrec_character',
				'foreign' => 'character'
			)),
			'nominated' => Jelly::field('integer', array(
				'column' => 'awardrec_nominated_by',
			)),
			'award' => Jelly::field('belongsto', array(
				'column' => 'awardrec_award',
				'foreign' => 'award'
			)),
			'date' => Jelly::field('timestamp', array(
				'column' => 'awardrec_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'reason' => Jelly::field('text', array(
				'column' => 'awardrec_reason'
			)),
		));
	}
}
