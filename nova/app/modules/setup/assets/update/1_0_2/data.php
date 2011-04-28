<?php
/**
 * File that handles all data changes to the database.
 *
 * 1.0.2 => 1.0.3
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
	'version'	=> '1.0.3',
	'major'		=> 1,
	'minor'		=> 0,
	'update'	=> 3,
	'date'		=> 1272321000,
	'launch'	=> "Nova 1.0.3 is the third maintainance release for Nova 1.0 and continues to fix issues with the system. Included in this release are fixes for errors being thrown throughout the system, several bugs with Thresher, changes to the update center to allow users to update even if they can't get the update information from the Anodyne server, NPC removal issues, updates to the user removal process and much more. A full changelog can be found on AnodyneDocs or from the System and Versions report once Nova has been updated. This update is recommended for all users.",
	'changes'	=> "* added the 1.0.3 update file
* updated the install data
    * menu items
    * version info
* updated the language files
    * [base\_lang] added labels_you
    * [text\_lang] added character_change
* updated the versions array file
* updated the ajax controller to have a separate method for removing NPCs instead of piggybacking off of the delete character method
* updated the characters controller to put the NPC removal inside its own method instead of using the character removal process
* updated the posts model to clean some code up and added a parameter to the unattended posts method
* updated the dynamic form management pages (bio, docking, specs) to show notices if there are no fields in a section
* updated the panel tabs on the control panel to display a notice if there's no content available
* updated thresher to use the proper regions in the template config file
* updated the user deactivation process to deactivate a users' characters at the same time
* updated the update center to show the links to start the update regardless of whether there's information about the update or not
* updated the auth library to add some debugging code to help track down the remember me bug
* updated the process of updating the system to remove dependence on the versions array file and instead pull a listing of the update directory (we still use the versions array file in the event the directory listing fails)
* fixed bug where the create wiki entry page wasn't showing up in the sub navigation menu
* fixed bug where the posts model wasn't accurately counting unattended posts when a character ID was passed in as an integer instead of array
* fixed bug where errors were thrown when deleting characters and NPCs
* fixed an error being thrown on the write mission post page
* fixed bug where the post notification stayed active even after the post had been updated and/or sent out
* fixed errors that were thrown when adding a rank
* fixed error thrown when there are no fields in a specs form section
* fixed error thrown in the dashboard
* fixed bug where wiki pages were being put in the uncategorized section even if they had categories
* fixed error thrown for missing option parameters
* fixed error thrown during accepting/rejecting a docked ship application"
);

$system_info = array(
	'last_update'		=> date::now(),
	'version_major'		=> 1,
	'version_minor'		=> 0,
	'version_update'	=> 3
);

/**
 * update the wiki menu item
 */
Jelly::query('menu')->where('access', '=', 'wiki/pages')->set(array('access' => 'wiki/page'))->update();

/**
  * update characters to make sure that inactive users' characters have been deactivated
  */ 
//$query = $this->db->get_where('users', array('status' => 'inactive'));
$query = Jelly::query('user')->where('status', '=', 'inactive')->select();

if (count($query) > 0)
{
	foreach ($query as $q)
	{
		Jelly::query('character')
			->where('user', '=', $q->id)
			->where('status', '=', 'active')
			->set(array('status' => 'inactive'))
			->update();
	}
}

/**
 * Add the system version info to the database
 */
Jelly::factory('systemversion')->set($system_versions)->save();