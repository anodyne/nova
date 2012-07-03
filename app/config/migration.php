<?php
/**
 * Part of the Fuel framework.
 *
 * @package		Fuel
 * @version		1.0
 * @author		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 - 2011 Fuel Development Team
 */

return array(

	/*
	| Which version of the schema should be considered "current"
	|
	|	Default: 0
	|
	*/
	'version' => array(
		'app' => array(
			'default' => 0,
		),
		'module' => array(),
		'package' => array()
	),

	/*
	| Folder name where migrations are stored relative to App, Module and Package Paths?
	|
	|	Default: 'migrations/'
	|
	*/
	'folder' => 'migrations/',

	/*
	| Table name
	|
	|	Default: 'migration'
	|
	*/
	'table' => 'migration',

);
