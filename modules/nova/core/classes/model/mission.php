<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Missions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_Mission extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => Jelly::field('primary', array(
				'column' => 'mission_id'
			)),
			'title' => Jelly::field('string', array(
				'column' => 'mission_title'
			)),
			'images' => Jelly::field('text', array(
				'column' => 'mission_images'
			)),
			'order' => Jelly::field('integer', array(
				'column' => 'mission_order'
			)),
			'group' => Jelly::field('belongsto', array(
				'column' => 'mission_group',
				'foreign' => 'missiongroup'
			)),
			'status' => Jelly::field('enum', array(
				'column' => 'mission_status',
				'choices' => array('upcoming','current','completed'),
				'default' => 'upcoming'
			)),
			'start' => Jelly::field('timestamp', array(
				'column' => 'mission_start',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true
			)),
			'end' => Jelly::field('timestamp', array(
				'column' => 'mission_end',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true
			)),
			'desc' => Jelly::field('text', array(
				'column' => 'mission_desc'
			)),
			'summary' => Jelly::field('text', array(
				'column' => 'mission_summary'
			)),
			'notes' => Jelly::field('text', array(
				'column' => 'mission_notes'
			)),
			'notes_update' => Jelly::field('timestamp', array(
				'column' => 'mission_notes_updated',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true
			)),
			'posts' => Jelly::field('hasmany', array(
				'foreign' => 'posts.post_mission'
			)),
		));
	}
}
