<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Character Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_Character extends Jelly_Model
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
				'column' => 'charid'
			)),
			'user' => new Field_HasOne(array(
				'foreign' => 'user'
			)),
			'fname' => new Field_String(array(
				'column' => 'first_name',
			)),
			'mname' => new Field_String(array(
				'column' => 'middle_name',
			)),
			'lname' => new Field_String(array(
				'column' => 'last_name',
			)),
			'suffix' => new Field_String,
			'type' => new Field_Enum(array(
				'column' => 'crew_type',
				'choices' => array('active','inactive','pending','npc'),
				'default' => 'active'
			)),
			'activate' => new Field_Timestamp(array(
				'column' => 'date_activate',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'deactivate' => new Field_Timestamp(array(
				'column' => 'date_deactivate',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'images' => new Field_Text,
			'rank' => new Field_BelongsTo(array(
				'column' => 'rank',
				'foreign' => 'rank'
			)),
			'position1' => new Field_BelongsTo(array(
				'column' => 'position_1',
				'foreign' => 'position'
			)),
			'position2' => new Field_BelongsTo(array(
				'column' => 'position_2',
				'foreign' => 'position'
			)),
			'last_post' => new Field_Timestamp(array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			/*'last_update' => new Field_Timestamp(array(
				'auto_now_create' => FALSE,
				'auto_now_update' => TRUE,
				'null' => TRUE
					))*/
		));
	}
}