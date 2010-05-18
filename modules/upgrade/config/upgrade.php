<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Upgrade Options
 *
 * Change these values if you want to change the exactly what Nova will
 * upgrade from SMS. To turn off one of the items, simply change TRUE
 * to FALSE, save the file and upload it back up to the server. Users
 * and characters will be upgraded automatically. You cannot add items
 * to this array. Only these items with be upgraded.
 */
$config['options'] = array(
	'awards'		=> TRUE,
	'settings'		=> TRUE,
	'logs'			=> TRUE,
	'missions'		=> TRUE,
	'news'			=> TRUE,
	'posts'			=> TRUE,
	'specs'			=> TRUE,
	'tour'			=> TRUE
);

/**
 * Upgrade Password
 *
 * Because SMS and Nova use different encryption methods for their passwords,
 * passwords cannot be upgraded. Set the password below to something
 * different that every member of your RPG will use to log in with. Once
 * they've logged in, they'll be prompted to change their password to
 * something else. This password is case-sensitive.
 */
$config['password'] = 'password';

/**
 * System Administrator Email Address
 *
 * Use this to specify the email addresses of any users who should be given
 * System Administrator access during the upgrade process.
 */
$config['email'] = array(
	'me@example.com',
	'john@example.com'
);

// End of file upgrade.php
// Location: modules/upgrade/config/upgrade.php