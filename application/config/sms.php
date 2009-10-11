<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  UPGRADE SETTINGS
| -------------------------------------------------------------------
| Change these values if you want to change the exactly what Nova will
| upgrade from SMS. To turn off one of the items, simply change TRUE
| to FALSE, save the file and upload it back up to the server.
|
| NOTE: You cannot add items to this array to add more elements to the
| the upgrade process. These are the only items Nova will upgrade due
| to drastic database schema changes.
*/

$config['sms'] = array(
	'awards'		=> TRUE,
	'characters'	=> TRUE,
	'settings'		=> TRUE,
	'logs'			=> TRUE,
	'missions'		=> TRUE,
	'news'			=> TRUE,
	'players'		=> TRUE,
	'posts'			=> TRUE,
	'specs'			=> TRUE,
	'tour'			=> TRUE
);

$config['sms_password'] = 'password';

/* End of file sms.php */
/* Location: ./application/config/sms.php */