<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.0 => 1.0.1
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
	'version'	=> '1.0.1',
	'major'		=> 1,
	'minor'		=> 0,
	'update'	=> 1,
	'date'		=> 1271393940,
	'launch'	=> 'Nova 1.0.1 is a maintenance release that fixes two important issues with Nova 1.0. The release fixes a bug where the upgrade process did not create a necessary field in the missions table as well as two issues with installations oh PHP4 servers. This update is recommended for all users who have upgraded from SMS and/or are running on a PHP4 server.',
	'changes'	=> "* fixed bug in the upgrade process where a database field wasn't added to the table
* fixed bug where models couldn't be autoloaded because Base4 doesn't extend MY_Loader
* fixed error that was thrown because the date_default_timezone_set function doesn't exist in PHP before version 5.1"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 1
);

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();