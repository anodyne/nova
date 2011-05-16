<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Event config file contains the events and their respective callbacks which
 * should be in a $key => $value format. The Event Call section includes the
 * different classes that should be called within each event.
 */

return array(
	'pre_create'	=> 'Hooks::pre_create',
	
	'post_create'	=> 'Hooks::post_create',
	
	'pre_execute'	=> 'Hooks::pre_execute',
	
	'post_execute'	=> 'Hooks::post_execute',
	
	'pre_headers'	=> 'Hooks::pre_headers',
	
	'post_headers'	=> 'Hooks::post_headers',
	
	'pre_response'	=> 'Hooks::pre_response',
	
	'post_response'	=> 'Hooks::post_response',
	
	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------
	
	'event_calls' => array(
		'pre_create'	=> array(),
		
		'post_create'	=> array(),
		
		'pre_execute'	=> array(
			'Hooks::browser',
			'Hooks::modules',
			'Hooks::bans',
			'Hooks::maintenance',
		),
		
		'post_execute'	=> array(),
		
		'pre_headers'	=> array(),
		
		'post_headers'	=> array(),
		
		'pre_response'	=> array(),
		
		'post_response'	=> array(),
	),
);
