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

		// get the user
		$user = \Sentry::user();

		try
		{
			// make sure we have a user
			$user->get('id');
		}
		catch (\Sentry\SentryUserException $e)
		{
			// if we don't have a user, set the variable to null
			$user = null;
		}

		// character types have one extra item to capture
		if ($type == 'character')
		{
			$data = array(
				'character_id' => ($user !== null) ? $user->character->id : 0,
			);
		}

		// merge two arrays
		$data = array_merge($data, array(
			'email' 	=> ($user !== null) ? $user->email : '',
			'user_id' 	=> ($user !== null) ? $user->id : 0,
			'ip' 		=> \Input::real_ip(),
			'content' 	=> lang($content)
		));

		// create the new event item
		\Model_SystemEvent::createItem($data);
	}

	public static function cleanup()
	{
		# code...
	}
}
