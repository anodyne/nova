<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.4 => 1.0.5
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
	'version'	=> '1.0.5',
	'major'		=> 1,
	'minor'		=> 0,
	'update'	=> 5,
	'date'		=> 1275865200,
	'launch'	=> "Nova 1.0.5 is the fifth maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a bug that wouldn't allow unlinked NPCs to use newly created bio fields, a security issue with the docking form and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'changes'	=> "* added the 1.0.5 update file
* fixed errors after upgrade on the characters management page
* fixed error after upgrade on the npc management page
* fixed errors thrown when editing a wiki page
* fixed bug in the positions dropdown menu where hidden departments' positions were still shown
* fixed bug where a wrong variable was using in a model method
* fixed security issue where docking request data wasn't filtered for xss attacks
* fixed bugs with the email sent to GMs when a docking request is submitted
* fixed error thrown when updating a user to be inactive
* fixed bug we weren't doing any sanity checking on the type of variable we needed when handling character deactivation
* fixed errors thrown when rejecting a docking request
* fixed bug where unlinked NPCs wouldn't be able to use newly created fields
* fixed bug where site options didn't allow skin admins to select in development skins
* fixed bug where join instructions weren't displayed"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 5
);

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();