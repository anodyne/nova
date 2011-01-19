<?php defined('SYSPATH') or die('No direct script access.');

return array(
	/**
	 * The protocol to use for sending email messages. The default is to use
	 * PHP's built-in mail function but you can also use sendmail or smtp.
	 * If you choose to use sendmail or SMTP email, you must also provide the
	 * necessary information below.
	 */
	'type' => 'mail',
	
	/**
	 * SMTP server information. This is needed to connect to the SMTP server to
	 * send email.
	 */
	'smtp_server' => 'smtp.example.com',
	'smtp_port' => '25',
	'smtp_username' => 'username',
	'smtp_password' => 'password',
	
	/**
	 * Sendmail information. This is needed to connect to sendmail to send email
	 * through the script.
	 */
	'sendmail_path' => '/usr/sbin/sendmail -bs',
);
