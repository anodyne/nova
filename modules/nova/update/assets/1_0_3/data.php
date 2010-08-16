<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.3 => 1.0.4
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
	'version'	=> '1.0.4',
	'major'		=> 1,
	'minor'		=> 0,
	'update'	=> 4,
	'date'		=> 1273705200,
	'launch'	=> "Nova 1.0.4 is the fourth maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, bugs with emails not being sent out on some servers, user access errors and filtering text before going into the database. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'changes'	=> "* added the 1.0.4 update file
* added the MY\_Email library file
* updated the version update files to make sure the values get reset at the start of every file
* updated jquery ui to version 1.8.1
* updated markItUp! to version 1.1.7
* updated the textile parser to fix some bugs (thanks to dustin for catching this)
* updated the wiki controller to show an error message if the server is running php 4
* updated the archives controller to show an error message if the server is running php 4
* updated the MY\_Input library to try and do filtering for MS Word characters a little better
* fixed error thrown when a user with level 1 user account privileges updates their account
* fixed bug where saved personal logs could be shown in along with activated logs for users with multiple characters associated with their account
* fixed bug where IE threw an exception on the post, log, news and docked item management pages
* fixed error thrown on the contact page
* fixed errors thrown on the manage bio page for users with level 1 privileges
* fixed bug with the manage bio page where positions were updated when they shouldn't be
* fixed bug where the status change request email wasn't populated properly"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 4
);

/**
  * jquery ui version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'jQuery UI')->set(array('version' => '1.8.1'))->update();

/**
  * markitup version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'markItUp!')->set(array('version' => '1.1.7'))->update();

/**
  * textile version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'Textile')->set(array('url' => 'http://textpattern.com/download'))->update();

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();