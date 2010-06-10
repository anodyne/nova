<?php defined('SYSPATH') or die('No direct script access.');

Route::set('about nova redirect', 'main/nova')->defaults(array('controller' => 'aboutnova', 'action' => 'index'));