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
			'id' => Jelly::field('primary', array(
				'column' => 'userid'
			)),
			'status' => Jelly::field('enum', array(
				'choices' => array('active','inactive','pending'),
				'default' => 'pending'
			)),
			'name' => Jelly::field('string', array(
				'column' => 'name'
			)),
			'email' => Jelly::field('email', array(
				'column' => 'email'
			)),
			'password' => Jelly::field('password', array(
				'hash_with' => FALSE,
			)),
			'date_of_birth' => Jelly::field('string', array(
				'column' => 'date_of_birth'
			)),
			'instant_message' => Jelly::field('text', array(
				'column' => 'instant_message'
			)),
			'main_char' => Jelly::field('belongsto', array(
				'column' => 'main_char',
				'foreign' => 'character'
			)),
			'role' => Jelly::field('belongsto', array(
				'column' => 'access_role',
				'foreign' => 'accessrole'
			)),
			'sysadmin' => Jelly::field('enum', array(
				'column' => 'is_sysadmin',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'gm' => Jelly::field('enum', array(
				'column' => 'is_game_master',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'webmaster' => Jelly::field('enum', array(
				'column' => 'is_webmaster',
				'choices' => array('y','n'),
				'default' => 'n'
			)),
			'timezone' => Jelly::field('string', array(
				'column' => 'timezone',
				'default' => 'UTC'
			)),
			'dst' => Jelly::field('integer', array(
				'column' => 'daylight_savings'
			)),
			'language' => Jelly::field('string', array(
				'column' => 'language'
			)),
			'join' => Jelly::field('timestamp', array(
				'column' => 'join_date',
				'auto_now_create' => TRUE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'leave' => Jelly::field('timestamp', array(
				'column' => 'leave_date',
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'last_update' => Jelly::field('timestamp', array(
				'auto_now_create' => TRUE,
				'auto_now_update' => TRUE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'last_post' => Jelly::field('timestamp', array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'last_login' => Jelly::field('timestamp', array(
				'auto_now_create' => FALSE,
				'auto_now_update' => FALSE,
				'null' => TRUE,
				'default' => date::now()
			)),
			'loa' => Jelly::field('enum', array(
				'choices' => array('active','loa','eloa'),
				'default' => 'active'
			)),
			'rank' => Jelly::field('string', array(
				'column'=> 'display_rank'
			)),
			'skin_main' => Jelly::field('string', array(
				'column' => 'skin_main'
			)),
			'skin_wiki' => Jelly::field('string', array(
				'column' => 'skin_wiki'
			)),
			'skin_admin' => Jelly::field('string', array(
				'column' => 'skin_admin'
			)),
			'location' => Jelly::field('text', array(
				'column' => 'location'
			)),
			'bio' => Jelly::field('text', array(
				'column' => 'bio'
			)),
			'security_question' => Jelly::field('integer', array(
				'column' => 'security_question'
			)),
			'security_answer' => Jelly::field('string', array(
				'column' => 'security_answer'
			)),
			'password_reset' => Jelly::field('integer', array(
				'column' => 'password_reset'
			)),
			'links' => Jelly::field('text', array(
				'column' => 'my_links'
			)),
			'characters' => Jelly::field('hasmany', array(
				'foreign' => 'characters.user'
			)),
		));
	}
}