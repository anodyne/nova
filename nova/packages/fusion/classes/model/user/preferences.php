<?php
/**
 * User Preferences Model
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Model
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */
 
namespace Fusion;

class Model_User_Preferences extends \Model {
	
	public static $_table_name = 'users_preferences';
	
	public static $_properties = array(
		'id' => array(
			'type' => 'int',
			'constraint' => 11,
			'auto_increment' => true),
		'user_id' => array(
			'type' => 'int',
			'constraint' => 11,
			'default' => 0),
		'key' => array(
			'type' => 'string',
			'constraint' => 50),
		'value' => array(
			'type' => 'text',
			'null' => true),
	);
	
	public static $_belongs_to = array(
		'user' => array(
			'model_to' => '\\Model_User',
			'key_to' => 'id',
			'key_from' => 'user_id',
			'cascade_save' => false,
			'cascade_delete' => false,
		),
	);
	
	/**
	 * Create the default user settings.
	 *
	 * @api
	 * @param	int		the user ID
	 * @return	object
	 */
	public static function create_user_preferences($user)
	{
		$insert = array(
			'is_sysadmin'			=> (int) false,
			'is_game_master'		=> (int) false,
			'is_firstlaunch'		=> (int) true,
			'loa'					=> 'active',
			'timezone'				=> 'UTC',
			'daylight_savings'		=> (int) false,
			'email_format'			=> 'html',
			'language'				=> 'en',
			
			# TODO: need to pull these values from the catalogu
			'display_rank'			=> \Model_Catalog_Rank::get_default(true),
			'skin_main'				=> \Model_Catalog_SkinSec::get_default('main', true),
			'skin_admin'			=> \Model_Catalog_SkinSec::get_default('admin', true),
			
			# TODO: need to pull these values from the menu
			'my_links'				=> '',
			
			'email_comments'		=> (int) true,
			'email_messages'		=> (int) true,
			'email_logs'			=> (int) true,
			'email_announcements'	=> (int) true,
			'email_posts'			=> (int) true,
			'email_posts_save'		=> (int) true,
			'email_posts_delete'	=> (int) true,
		);

		foreach ($insert as $key => $value)
		{
			// create a new record
			$record = static::forge();

			// set the key and value
			$record->user_id = $user;
			$record->key = $key;
			$record->value = $value;

			// save the record
			$record->save();
		}
		
		return $record;
	}

	/**
	 * Update the user preferences.
	 *
	 * @api
	 * @param 	int 	the user ID
	 * @param 	array 	an array of data to use
	 * @return 	bool 	whether everything saved
	 */
	public static function update_user_preferences($id, array $data)
	{
		// load the items
		$items = static::find()->where('user_id', $id)->get();

		// set the count to 0
		$count = 0;

		foreach ($items as $i)
		{
			// if we've got the item in the array, update it
			if (array_key_exists($i->key, $data))
			{
				// update the value
				$i->value = $data[$i->key];

				// save the item
				$i->save();

				// increment the count
				++$count;
			}
		}

		if (count($data) == $count)
		{
			return true;
		}

		return false;
	}
}
