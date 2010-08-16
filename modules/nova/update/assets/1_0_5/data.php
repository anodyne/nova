<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.5 => 1.0.6
 *
 * @package		Update
 * @author		Anodyne Productions
 */

$system_versions	= NULL;
$system_info		= NULL;

/**
 * Build the data used by the system for version info
 */
$system_versions = array(
	'version'	=> '1.0.6',
	'major'		=> 1,
	'minor'		=> 0,
	'update'	=> 6,
	'date'		=> 1279148400,
	'launch'	=> "Nova 1.0.6 is the sixth and final maintenance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, a critical CodeIgniter security bug, several bugs with character management, a bug with user management and setting email preferences, updates to the jQuery UI library and other plugins and more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users. Additionally, active testing is underway for Nova 1.1 that will add several new features to the system and will be available later this summer.",
	'changes'	=> "* added the 1.0.6 update file
* updated the character bio management page to show a loader until everything has finished loading to help with load time
* updated jquery ui to version 1.8.2
* updated the auth library to remove some debug code since the autologin bug seems to have been solved
* updated the index page to turn down the error reporting (fatal errors and database errors will still be shown)
* updated the select menu on the write PM page to separate active and inactive characters
* updated colorbox to version 1.3.8
* updated the characters model to include a method for inserting promotion records
* updated the language file with a new item (_labels\_from_)
* updated the users model with a new method for removing user preference values
* updated CI's core upload class to fixing a security hole
* fixed error thrown when posting a comment on a mission post
* fixed error thrown when attempting to delete a character
* fixed error thrown during step 2 of the update process for some users
* fixed error thrown when there's only one mission image set on the mission detail page
* fixed error thrown when there's only one tour image set on the tour detail page
* fixed error thrown when there's only one character image set on the character bio page
* fixed bug where acceptance and rejection messages were sent without any changes an admin made
* fixed bug where changing a character's state to and from active wouldn't set the open slots of their position(s)
* fixed bug where the position dropdowns when creating a character showed all positions instead of open positions
* fixed bug where rank history information wasn't being populated correctly
* fixed bug where turning off update notification still attempted to run the check (before running in to another check)
* fixed bug where a user's email preferences remained active even after the user was set to inactive
* fixed bug where a user's email preferences weren't deleted when the user was deleted"
);

$system_info = array(
	'last_update'		=> now(),
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 6
);

/**
  * jquery ui version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'jQuery UI')->set(array('version' => '1.8.2'))->update();

/**
  * colorbox version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'jQuery ColorBox')->set(array('version' => '1.3.8'))->update();

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();