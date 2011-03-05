<?php
/**
 * File that handles all data changes to the database.
 *
 * 2.0.0 => 2.0.1
 *
 * @package		Update
 * @author		Anodyne Productions
 */

$system_versions	= null;
$system_info		= null;

/**
 * Build the data used by the system for version info
 */
$system_versions = array(
	'version'	=> '2.0.1',
	'major'		=> 2,
	'minor'		=> 0,
	'update'	=> 1,
	'date'		=> 1273705200,
	'launch'	=> "Description goes here",
	'changes'	=> "Changes go here"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 2,
	'version_minor'		=> 0,
	'version_update'	=> 1
);

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();