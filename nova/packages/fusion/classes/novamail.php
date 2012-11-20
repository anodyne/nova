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
		// Get the email preferences
		$options = \Model_Settings::getItems(array(
			'email_subject',
			'email_name',
			'email_address',
			'email_status'
		));

		if ($options->email_status == \Status::ACTIVE)
		{
			// We have to have a `to` index otherwise things will fail
			if ( ! array_key_exists('to', $data))
			{
				throw new \Exception(lang('email.error.noToAddress'));
			}

			// We have to have a `subject` index
			if ( ! array_key_exists('subject', $data))
			{
				throw new \Exception(lang('email.error.noSubject'));
			}

			// Do we have data for the email?
			$content = (array_key_exists('content', $data)) ? $data['content'] : false;

			// Set up the mailer
			$mailer = static::setup();

			// Set up the users by email format preference
			$to = static::splitUsers($data['to']);

			// Build the basic message
			$message = \Swift_Message::newInstance()
				->setSubject($options->email_subject.' '.$data['subject'])
				->setFrom(array($options->email_address => $options->email_name));

			// If there's a reply to, add it
			if (array_key_exists('replyTo', $data))
			{
				$message->setReplyTo($data['replyTo']);
			}

			// Build the html message
			if (array_key_exists('html', $to))
			{
				$html = $message->setTo($to['html'])
					->setBody(\View::forge(\Location::file("html/$view", false, 'email'), $content), 'text/html');
			}

			// Build the plain text message
			if (array_key_exists('text', $to))
			{
				$text = $message->setTo($to['text'])
					->setBody(\View::forge(\Location::file("text/$view", false, 'email'), $content), 'text/plain');
			}

			// If there's a CC, add it
			if (array_key_exists('cc', $data))
			{
				// Split the users based on email format preferences
				$cc = static::splitUsers($data['cc']);

				// Add the CC to the emails
				$html->setCc($cc['html']);
				$text->setCc($cc['text']);
			}

			// If there's a BCC, add it
			if (array_key_exists('bcc', $data))
			{
				// Split the users based on email format preferences
				$bcc = static::splitUsers($data['bcc']);

				// Add the BCC to the emails
				$html->setBcc($bcc['html']);
				$text->setBcc($bcc['text']);
			}

			// Send the messages
			$send = array(
				'html' => (isset($html) and \Fuel::$env != \Fuel::DEVELOPMENT) ? $mailer->send($html) : false,
				'text' => (isset($text) and \Fuel::$env != \Fuel::DEVELOPMENT) ? $mailer->send($text) : false,
			);

			return $send;
		}

		return false;
	}

	/**
	 * Setup the SwiftMailer object.
	 *
	 * @api
	 * @return	Swift_Mailer
	 */
	public static function setup()
	{
		// Get the email config options from the database
		$cfg = \Model_Settings::getItems(array(
			'email_protocol',
			'email_smtp_server',
			'email_smtp_port',
			'email_smtp_encryption',
			'email_smtp_username',
			'email_smtp_password',
			'email_sendmail_path',
		));

		// Set up the transport based on the protocol the user has set
		switch ($cfg->email_protocol)
		{
			case 'smtp':
				$transport = \Swift_SmtpTransport::newInstance(
						$cfg->email_smtp_server, 
						$cfg->email_smtp_port, 
						$cfg->email_smtp_encryption
					)
					->setUsername($cfg->email_smtp_username)
					->setPassword($cfg->email_smtp_password);
			break;

			case 'sendmail':
				$transport = \Swift_SendmailTransport::newInstance($cfg->email_sendmail_path);
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
	protected static function splitUsers(array $users)
	{
		// Create an array for storing users
		$retval = array();

		// Loop through the users
		foreach ($users as $user)
		{
			// Get the user
			$u = \Model_User::find($user);

			// Break the users out based on mail format preference
			$retval[$u->getPreferences('email_format')][] = $u->email;
		}

		return $retval;
	}
}
