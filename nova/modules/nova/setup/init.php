<?php

Route::set('setup', 'setup(/<controller>(/<action>(/<id>)))')
	->defaults(array( 
		'directory' => 'setup', 
		'controller' => 'main', 
		'action' => 'index'
	));