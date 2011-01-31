<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The email class utilizes SwiftMailer for preparing and sending all email messages.
 * The class also includes methods for some of the fringe cases used throughout the
 * system that don't fall in to normal email operations.
 *
 *     // set up the mailer
 *     $mailer = Email::setup_mailer();
 *
 *     // set up the message
 *     $message = Email::setup_message();
 *
 * @package		Nova
 * @category	Classes
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 * @since		2.0
 */

abstract class Nova_Email {
	
	/**
	 * Send the installation registration email
	 *
	 * @param	array 	an array of items to use in the email
	 * @return	object	swift mailer object
	 */
	public static function install_register(array $data)
	{
		$mailer = self::setup_mailer();
		
		$message = self::setup_message();
		$message->setSubject('Nova Registration');
		$message->setFrom('nova.registration@example.com');
		$message->setTo(array('anodyne.nova@gmail.com'));
		$message->setBody($data['message']);
		
		$result = $mailer->send($message);
		
		return $result;
	}
	
	/**
	 * Sets up the SwiftMailer class with the appropriate transport, creates
	 * the mailer and returns an instance of the mailer
	 *
	 * @uses	Kohana::config
	 * @return	object	an instance of the mailer object
	 */
	public static function setup_mailer()
	{
		$email = Kohana::config('email');
		
		// create the transport based on what's in the email config file
		switch ($email->type)
		{
			case 'mail':
				$transport = Swift_MailTransport::newInstance();
			break;
				
			case 'sendmail':
				$transport = Swift_SendmailTransport::newInstance($email->sendmail_path);
			break;
				
			case 'smtp':
				$transport = Swift_SmtpTransport::newInstance($email->smtp_server, $email->smtp_port)
					->setUsername($email->smtp_username)
					->setPassword($email->smtp_password);
			break;
		}
		
		$mailer = Swift_Mailer::newInstance($transport);
		
		return $mailer;
	}
	
	/**
	 * Sets up the SwiftMail message and returns the instance
	 *
	 * @return	object	an instance of the message object
	 */
	public function setup_message()
	{
		return Swift_Message::newInstance();
	}
}
