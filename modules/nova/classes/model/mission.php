<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Missions Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Mission extends Jelly_Model
{
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'mission_id'
			)),
			'title' => new Field_String(array(
				'column' => 'mission_title'
			)),
			'images' => new Field_Text(array(
				'column' => 'mission_images'
			)),
			'order' => new Field_Integer(array(
				'column' => 'mission_order'
			)),
			'group' => new Field_BelongsTo(array(
				'column' => 'mission_group',
				'foreign' => 'missiongroup'
			)),
			'status' => new Field_Enum(array(
				'column' => 'mission_status',
				'choices' => array('upcoming','current','completed'),
				'default' => 'upcoming'
			)),
			'start' => new Field_Timestamp(array(
				'column' => 'mission_start',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'end' => new Field_Timestamp(array(
				'column' => 'mission_end',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'desc' => new Field_Text(array(
				'column' => 'mission_desc'
			)),
			'summary' => new Field_Text(array(
				'column' => 'mission_summary'
			)),
			'notes' => new Field_Text(array(
				'column' => 'mission_notes'
			)),
			'notes_update' => new Field_Timestamp(array(
				'column' => 'mission_notes_updated',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'posts' => new Field_HasMany(array(
				'foreign' => 'posts.post_mission'
			)),
		));
	}
}