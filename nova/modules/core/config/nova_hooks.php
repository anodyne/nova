<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'][] = array(
	'class'		=> 'Utility',
	'function'	=> 'extensions',
	'filename'	=> 'Utility.php',
	'filepath'	=> 'hooks',
	'params'	=> ''
);

$hook['post_controller_constructor'][] = array(
	'class'		=> 'Utility',
	'function'	=> 'browser',
	'filename'	=> 'Utility.php',
	'filepath'	=> 'hooks',
	'params'	=> ''
);

$hook['post_controller_constructor'][] = array(
	'class'		=> 'Utility',
	'function'	=> 'bans',
	'filename'	=> 'Utility.php',
	'filepath'	=> 'hooks',
	'params'	=> ''
);

$hook['post_controller_constructor'][] = array(
	'class'		=> 'Utility',
	'function'	=> 'maintenance',
	'filename'	=> 'Utility.php',
	'filepath'	=> 'hooks',
	'params'	=> ''
);
