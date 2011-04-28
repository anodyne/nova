<?php defined('SYSPATH') or die('No direct script access.');

return array
(
	'driver' => 'file',
	
	'file'    => array
	(
		'driver'             => 'file',
		'cache_dir'          => APPPATH.'cache',
		'default_expire'     => 28800,
	)
);
