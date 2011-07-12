<?php defined('SYSPATH') or die('No direct script access.');

Route::set('manage hmvc', 'admin/manage/forms(/<id>)')
	->defaults(array( 
		'directory' => 'manage',
		'controller' => 'forms',
		'action' => 'index'
	));
	
Route::set('admin/manage', 'admin/manage(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'admin', 
		'controller' => 'manage', 
		'action' => 'index'
	));

Route::set('admin/users', 'admin/users(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'admin', 
		'controller' => 'users', 
		'action' => 'index'
	));

Route::set('admin/characters', 'admin/characters(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'admin', 
		'controller' => 'characters', 
		'action' => 'index'
	));

Route::set('admin/site', 'admin/site(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'admin', 
		'controller' => 'site', 
		'action' => 'index'
	));