<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User Model
 *
 * @package		Nova
 * @category	Models
 * @author		Anodyne Productions
 * @copyright	2010-11 Anodyne Productions
 * @since		2.0
 */
 
class Model_User extends Jelly_Model {
	
	/**
	 * Initialize the model with Jelly_Meta data
	 *
	 * @return	void
	 */
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
			'password' => Jelly::field('string', array(
				'column' => 'password',
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
			'email_format' => Jelly::field('string', array(
				'column' => 'email_format',
				'default' => 'html'
			)),
			'language' => Jelly::field('string', array(
				'column' => 'language'
			)),
			'join' => Jelly::field('timestamp', array(
				'column' => 'join_date',
				'auto_now_create' => true,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'leave' => Jelly::field('timestamp', array(
				'column' => 'leave_date',
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'last_update' => Jelly::field('timestamp', array(
				'auto_now_create' => true,
				'auto_now_update' => true,
				'null' => true,
				'default' => date::now()
			)),
			'last_post' => Jelly::field('timestamp', array(
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
				'default' => date::now()
			)),
			'last_login' => Jelly::field('timestamp', array(
				'auto_now_create' => false,
				'auto_now_update' => false,
				'null' => true,
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
			'security_question' => Jelly::field('belongsto', array(
				'column' => 'security_question',
				'foreign' => 'securityquestion'
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
	
	/**
	 * Pulls game master data back from the users table.
	 *
	 * @param	string	the type of data to pull back (all, email, id)
	 * @return	mixed	an array of data or false if there are no GMs
	 */
	public function get_gm_data($type = 'all')
	{
		// get all the game masters
		$query = Jelly::query('user')->where('gm', '=', 'y')->select();
		
		if (count($query) > 0)
		{
			// create an array for storing the data
			$array = array();
			
			foreach ($query as $row)
			{
				switch ($type)
				{
					case 'all':
						$array[] = $row;
					break;
					
					case 'email':
						$array[] = $row->email;
					break;
					
					case 'id':
						$array[] = $row->id;
					break;
				}
			}
			
			return $array;
		}
		
		return false;
	}
}
