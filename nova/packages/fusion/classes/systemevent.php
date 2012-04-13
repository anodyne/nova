<?php
/**
 * The System Event class is designed to log system events to the database
 * for admins to track what's going on with the game.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class SystemEvent
{	
	/**
	 * Adds a system event message.
	 *
	 * @api
	 * @param	string	the email address
	 * @param	string	the ip address
	 * @param	object	the user object
	 * @param	object	the character object
	 * @param	string	the content
	 * @return	void
	 */
	public static function add($type, $content)
	{
		$data = array();

		switch ($type)
		{
			case 'character':
				// get the user
				$user = \Model_User::get_user(\Sentry::user());

				$data = array(
					'email' => $user->email,
					'user_id' => $user->id,
					'character_id' => $user->character->id,
				);
			break;

			case 'user':
				// get the user
				$user = \Model_User::get_user(\Sentry::user());

				$data = array(
					'email' => $user->email,
					'user_id' => $user->id,
				);
			break;
		}

		// merge two arrays
		$data = array_merge($data, array(
			'ip' => \Input::real_ip(),
			'created_at' => time(),
			'content' => $content
		));

		// create the new event item
		\Model_SystemEvent::create_item($data);
	}

	public static function cleanup()
	{
		# code...
	}
}
