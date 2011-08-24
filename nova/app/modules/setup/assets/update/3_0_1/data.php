<?php
/**
 * File that handles all data changes to the database.
 *
 * 3.0.0 => 3.0.1
 *
 * @package		Setup
 * @author		Anodyne Productions
 */

$system_versions	= null;
$system_info		= null;

/**
 * Build the data used by the system for version info
 */
$system_versions = array(
	'version'	=> '3.0.1',
	'major'		=> 3,
	'minor'		=> 0,
	'update'	=> 1,
	'date'		=> 1273705200,
	'launch'	=> "Description goes here",
	'changes'	=> "Changes go here"
);

$system_info = array(
	'last_update'		=> Date::now(),
	'version_major'		=> 3,
	'version_minor'		=> 0,
	'version_update'	=> 1
);

/**
 * Add the system version info to the database
 */
Model_SystemVersion::create_item($system_versions);

/**
 * Clear out the variables
 */
$system_versions	= null;
$system_info		= null;