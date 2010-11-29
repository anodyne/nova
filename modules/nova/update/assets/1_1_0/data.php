<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.1 => 1.1.1
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
	'version'	=> '1.1.1',
	'major'		=> 1,
	'minor'		=> 1,
	'update'	=> 1,
	'date'		=> 1275865200,
	'launch'	=> "Nova 1.1 is the first update to Nova that adds additional features to the system. Included in this release is the ability to create multiple specification items and to associate tour items with specific specification items as well as bug fixes (a bug where editing existing tour items wouldn't update the current item, but the first item). A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'changes'	=> "* added the 1.1.1 update file
* updated the comments in the login controller
* updated jquery ui to version 1.8.5
* fixed bug where nova wouldn't display if the template file couldn't be found
* fixed bug where the general tour items category would be shown even if there weren't any general tour items
* fixed bug where skins with dashboard handles were showing bullets and having weird spacing issues"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 1,
	'version_update'	=> 1
);

/**
  * jquery ui version info
  */
Jelly::query('systemcomponent')->where('name', '=', 'jQuery UI')->set(array('version' => '1.8.5'))->update();

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();