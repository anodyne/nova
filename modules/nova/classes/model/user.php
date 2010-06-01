<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 */
 
class Model_User extends Jelly_Model
{
	public static function initialize(Jelly_Meta $meta)
	{
		$meta->fields(array(
			'id' => new Field_Primary(array(
				'column' => 'userid'
			)),
			'status' => new Field_Enum(array(
				'choices' => array('active','inactive','pending'),
				'default' => 'pending'
			)),
			'name' => new Field_String,
			'email' => new Field_Email,
			'password' => new Field_Password(array(
				'hash_with' => FALSE,
			)),
			'date_of_birth' => new Field_String,
			'instant_message' => new Field_Text,
			'main_char' => new Field_HasOne(array(
				'foreign' => 'character'
			)),
			'role' => new Field_BelongsTo(array(
				'column' => 'access_role',
				'foreign' => 'accessrole'
			)),
			'sysadmin' => new Field_Enum(array(
				'column' => 'is_sysadmin',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'gm' => new Field_Enum(array(
				'column' => 'is_game_master',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'webmaster' => new Field_Enum(array(
				'column' => 'is_webmaster',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'timezone' => new Field_String(array(
				'default' => 'UTC'
			)),
			'dst' => new Field_Integer(array(
				'column' => 'daylight_savings'
			)),
			'language' => new Field_String,
			'join_date' => new Field_Timestamp(array(
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'leave_date' => new Field_Timestamp(array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'last_update' => new Field_Timestamp(array(
				'auto_now_create' => TRUE,
				'auto_now_update' => TRUE,
				'null' => TRUE
			)),
			'last_post' => new Field_Timestamp(array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'last_login' => new Field_Timestamp(array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE
			)),
			'loa' => new Field_Enum(array(
				'choices' => array('active','loa','eloa'),
				'default' => 'active'
			)),
			'rank' => new Field_String(array(
				'column'=> 'display_rank'
			)),
			'skin_main' => new Field_String,
			'skin_wiki' => new Field_String,
			'skin_admin' => new Field_String,
			'location' => new Field_Text,
			'bio' => new Field_Text,
			'security_question' => new Field_Integer,
			'security_answer' => new Field_String,
			'password_reset' => new Field_Integer,
			'links' => new Field_Text(array(
				'column' => 'my_links'
			))
		));
	}
}