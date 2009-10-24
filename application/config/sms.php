<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
|  UPGRADE SETTINGS
| -------------------------------------------------------------------
| Change these values if you want to change the exactly what Nova will
| upgrade from SMS. To turn off one of the items, simply change TRUE
| to FALSE, save the file and upload it back up to the server.
|
| NOTE(1): Nova will upgrade characters and players even though they
| aren't listed in the array.
|
| NOTE(2): You cannot add items to this array to add more elements to
| the upgrade process. These are the only items Nova will upgrade.
*/

$config['sms'] = array(
	'awards'		=> TRUE,
	'settings'		=> TRUE,
	'logs'			=> TRUE,
	'missions'		=> TRUE,
	'news'			=> TRUE,
	'posts'			=> TRUE,
	'specs'			=> TRUE,
	'tour'			=> TRUE
);

$config['sms_password'] = 'password';

$config['sms_email'] = 'me@example.com';

/* End of file sms.php */
/* Location: ./application/config/sms.php */