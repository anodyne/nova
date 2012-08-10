<?php
/**
 * The NovaMail class handles building the emails sent from the system.
 *
 * @package		Nova
 * @subpackage	Fusion
 * @category	Class
 * @author 		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Fusion;

class NovaMail
{
	/**
	 * Compile and send the emails.
	 *
	 * @api
	 * @param	string	the view file to use for the email
	 * @param	array	the data for the email
	 * @return	array
	 * @throws	Exception
	 */
	public static function send($view, array $data)
	{
		// we have to have a `to` index otherwise things will fail
		if ( ! array_key_exists('to', $data))
		{
			throw new \Exception(lang('email.error.no_to_address'));
		}

		// we have to have a `subject` index
		if ( ! array_key_exists('to', $data))
		{
			throw new \Exception(lang('email.error.no_subject'));
		}

		// do we have data for the email?
		$content = (array_key_exists('content', $data)) ? $data['content'] : false;

		// get the email preferences
		$email_prefs = \Model_Settings::get_settings(array(
			'email_subject',
			'email_name',
			'email_address',
		));

		// set up the mailer
		$mailer = static::_setup();

		// set up the users by email format preference
		$users = static::_split_users($data['to']);

		// build the basic message
		$message = \Swift_Message::newInstance()
			->setSubject($email_prefs['email_subject'].' '.$data['subject'])
			->setFrom(array($email_prefs['email_address'] => $email_prefs['email_name']));

		// build the html message
		$html = $message->setTo($users['html'])
			->setBody(\View::forge(\Location::file("html/$view", false, 'email'), $content), 'text/html');

		// build the plain text message
		$text = $message->setTo($users['text'])
			->setBody(\View::forge(\Location::file("text/$view", false, 'email'), $content), 'text/plain');

		// send the messages
		$send = array(
			'html' => $mailer->send($html),
			'text' => $mailer->send($text),
		);

		return $send;
	}

	/**
	 * Setup the SwiftMailer object.
	 *
	 * @internal
	 * @return	Swift_Mailer
	 */
	protected static function _setup()
	{
		$type = false;

		switch ($type)
		{
			case 'smtp':
				$transport = \Swift_SmtpTransport::newInstance('smtp.example.org', 25)
					->setUsername('your username')
					->setPassword('your password');
			break;

			case 'sendmail':
				$transport = \Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
			break;

			case 'mail':
			default:
				$transport = \Swift_MailTransport::newInstance();
			break;
		}

		return \Swift_Mailer::newInstance($transport);
	}

	/**
	 * Take the recipients and split them up based on their email format preference.
	 *
	 * @internal
	 * @param	array	an array of user IDs
	 * @return	array
	 */
	protected static function _split_users(array $users)
	{
		// create an array for storing users
		$retval = array();

		// loop through the users
		foreach ($users as $user)
		{
			// get the user
			$u = \Model_User::find($user);

			// break the users out based on mail format preference
			$retval[$u->preferences('email_format')][] = $u->email;
		}

		return $retval;
	}
}
