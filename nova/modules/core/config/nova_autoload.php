<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$autoload['packages'] = array(APPPATH.'third_party');

$autoload['libraries'] = array(
	'template',
	'menu',
	'auth',
	'event',
	'user_panel',
	'location',
	'util'
);

$autoload['helper'] = array(
	'url',
	'date',
	'html',
	'language',
	'form',
	'string'
);

$autoload['config'] = array('nova');

$autoload['language'] = array();

$autoload['model'] = array();
