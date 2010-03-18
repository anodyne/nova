Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Release Candidate 3 (0.9.8)

Last Update
-----------
18 March 2010

Latest Updates
--------------
* updated the database schema to add the mission_group field to the missions table
* updated the database schema to add the mission groups table
* updated the install data
* updated the missions model with methods for mission groups
* updated the language files
* updated the 0.9.8 update file
* updated the sim controller to handle displaying mission groups
* updated some view files to change the URLs for mission pages
* updated the missions management page to be able to assign a mission group
* updated the manage controller to handle management of mission groups
* updated the copyright year of the nova license
* added the manage/missiongroups view file
* added the manage/missiongroups js view file
* added the sim/missions/group view file
* added the sim/missions/group/X view file

Changes in 0.9.8
----------------
* added the 0.9.8 update file
* added the archive_characters view file
* added the archive_departments view file
* added the archive_positions view file
* added the redeye skin
* added the manage/missiongroups view file
* added the manage/missiongroups js view file
* added the sim/missions/group view file
* added the sim/missions/group/X view file
* updated the dashboard to use the short rank name instead of the full rank name
* updated the pulsar skin
    * [admin] updated the size of the dashboard panel
    * [admin] updated the stylesheets
    * [main] updated the size of the dashboard panel
    * [wiki] updated the size of the dashboard panel
* updated the upgrade process to make the processing messages more descriptive
* updated the install data
    * version info
    * menu items
* updated the 0.9.7 update file
* updated the version info for 0.9.8
* updated the language files
* updated the characters model to take a zero into account instead of just NULL
* updated the upgrade process to pull over last post information as well
* updated the archive model with methods for pulling characters, positions and departments
* updated the archive controller to handle displaying characters from the SMS data
* updated the archive controller to handle displaying departments from the SMS data
* updated the archive controller to handle displaying positions from the SMS data
* updated the posts model to count posts based on users not on characters (prevents padding stats)
* updated character linking to use quick search on the NPCs tab
* updated write/missionpost to allow a user to select multiple characters of theirs for a post (#59)
* updated write/missionpost to simplify the UI a little bit
* updated the install controller to log any XML-RPC errors
* updated the update controller to log any XML-RPC errors
* updated the upgrade controller to log any XML-RPC errors
* updated the install controller to take the xmlrpc extension not being loaded into account
* updated the upgrade controller to take the xmlrpc extension not being loaded into account
* updated the update controller to take the xmlrpc extension not being loaded into account
* updated the database schema
    * [add] mission\_group field to the missions table
    * [add] mission\_groups table
* updated the missions model with methods for mission groups
* updated the sim controller to handle displaying mission groups
* updated some view files to change the URLs for mission pages
* updated the missions management page to be able to assign a mission group
* updated the manage controller to handle management of mission groups
* updated the copyright year of the nova license
* fixed errors in the upgrade process
* fixed errors after upgrading on the characters management page
* fixed errors after upgrading on the npc management page
* fixed bug where the all recent entries in the writing control panel showed all entries instead of just activated entries
* fixed bug where the character link page wouldn't show npcs
* fixed bug where the sms archives link didn't point to anywhere
* fixed an error in the archive controller
* fixed bug where user IDs were duplicated on multi-author posts allowing a user to pad their stats
* fixed potential bug where nova could look for array indices that wouldn't exist
* fixed bug in counting character's posts where low-numbered ID characters could have highly exaggerated post counts
* fixed bug in coutning users' posts where low-numbered ID users could have highly exaggerated post counts
* fixed bug in the upgrade process where last post wasn't put into the characters table too
* fixed bug in the upgrade process where news items weren't updated with the proper author user ID
* fixed bug in the upgrade process where personal logs weren't updated with the proper author user ID

Version History
---------------
<table>
	<tr>
		<th>Version</th><th>Description</th><th>Start Date</th><th>End Date</th>
	</tr>
	<tr>
		<td>Release Candidate</td><td>Final candidate builds for golden master</td><td>01 March 2010</td><td>-</td>
	</tr>
	<tr>
		<td>Beta</td><td>Feature complete testing version</td><td>10 Nov 2009</td><td>01 March 2010</td>
	</tr>
	<tr>
		<td>M7</td><td>Thresher Release 1</td><td>02 Nov 2009</td><td>09 Nov 2009</td>
	</tr>
	<tr>
		<td>M6</td><td>Reports, upgrading from SMS, updating Nova</td><td>02 Sep 2009</td><td>30 Oct 2009</td>
	</tr>
	<tr>
		<td>M5</td><td>Character and user management</td><td>01 Jul 2009</td><td>31 Sep 2009</td>
	</tr>
	<tr>
		<td>M4</td><td>Site and data management</td><td>01 Mar 2009</td><td>30 Jun 2009</td>
	</tr>
	<tr>
		<td>M3</td><td>Authentication, writing and private messaging</td><td>14 Jan 2009</td><td>27 Feb 2009</td>
	</tr>
	<tr>
		<td>M2</td><td>Un-authenticated system</td><td>30 Sep 2008</td><td>13 Jan 2009</td>
	</tr>
	<tr>
		<td>M1</td><td>CodeIgniter and Nova setup</td><td>01 Jul 2008</td><td>30 Sep 2008</td>
	</tr>
	<tr>
		<td>M0</td><td>Development start</td><td>-</td><td>30 May 2008</td>
	</tr>
</table>