Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
1.0.4-pre

Last Update
-----------
04 May 2010

Changes in 1.0.4
----------------
* added the 1.0.4 update file
* added the MY\_Email library file
* updated the version update files to make sure the values get reset at the start of every file
* updated jquery ui to version 1.8.1
* updated markItUp! to version 1.1.7
* updated the textile parser to fix some bugs (thanks to dustin for catching this)
* updated the wiki controller to show an error message if the server is running php 4
* updated the archives controller to show an error message if the server is running php 4
* fixed error thrown when a user with level 1 user account privileges updates their account
* fixed bug where saved personal logs could be shown in along with activated logs for users with multiple characters associated with their account
* fixed bug where IE threw an exception on the post, log, news and docked item management pages
* fixed error thrown on the contact page
* fixed errors thrown on the manage bio page for users with level 1 privileges
* fixed bug with the manage bio page where positions were updated when they shouldn't be
* fixed bug where the status change request email wasn't populated properly

Known Issues
------------
http://github.com/anodyne/nova/issues/labels/Bug

* the remember feature can cause issues like errors that say files can't be found
* thresher doesn't work under php4

Version History
---------------
<table>
	<tr>
		<th>Version</th><th>Release Date</th>
	</tr>
	<tr>
		<td>1.0.4</td><td>-</td>
	</tr>
	<tr>
		<td>1.0.3</td><td>26 April 2010</td>
	</tr>
	<tr>
		<td>1.0.2</td><td>20 April 2010</td>
	</tr>
	<tr>
		<td>1.0.1</td><td>16 April 2010</td>
	</tr>
	<tr>
		<td>1.0</td><td>15 April 2010</td>
	</tr>
</table>