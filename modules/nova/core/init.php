<?php defined('SYSPATH') or die('No direct script access.');

Route::set('admin', 'admin/manage(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'admin', 
		'controller' => 'manage', 
		'action' => 'index'
	));