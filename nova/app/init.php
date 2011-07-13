<?php defined('SYSPATH') or die('No direct script access.');

Route::set('admin/manage/data', 'admin/manage/data(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'manage',
		'controller' => 'data',
		'action' => 'index'
	));
	
Route::set('admin/manage/forms', 'admin/manage/forms(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'manage',
		'controller' => 'forms',
		'action' => 'index'
	));
	
Route::set('admin/manage/site', 'admin/manage/site(/<action>(/<id>))')
	->defaults(array( 
		'directory' => 'manage',
		'controller' => 'site',
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