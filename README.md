Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

This is a pre-release version of Nova and may contain bugs.

Current Version
---------------
1.0.1-pre

Last Update
-----------
15 April 2010

Latest Updates
--------------
* fixed bug where the menu library wouldn't respect any access control put on main navigation menu items (#101)
* fixed bug where the menu library wouldn't respect any access control put on sub navigation menu items
* fixed undefined variable error thrown on site/catalogueranks
* fixed bug where rank catalogue items didn't work well when multiple genres were installed (#102)
* updated the database schema to use a genre field in the rank catalogue table
* updated the genre install files to populate the new genre field in the rank catalogue table on creation
* updated the ranks model to pull the genre when looking for the default rank catalogue item
* updated the ranks model to pull only the ranks sets from a genre when getting all ranks
* updated the ranks model to only pull rank catalogue items for the given genre
* updated the language files
* updated the site controller to handle adding and editing the genre for a rank catalogue item
* updated the ajax controller to handle adding and editing the genre for a rank catalogue item
* added the 1.0.1 update file

Changes in 1.0.1
----------------
* added the 1.0.1 update file
* updated the database schema to use a genre field in the rank catalogue table
* updated the genre install files to populate the new genre field in the rank catalogue table on creation
* updated the language files
    * [base\_lang] added labels_genre key
* updated the ranks model to pull the genre when looking for the default rank catalogue item
* updated the ranks model to pull only the ranks sets from a genre when getting all ranks
* updated the ranks model to only pull rank catalogue items for the given genre
* updated the site controller to handle adding and editing the genre for a rank catalogue item
* updated the ajax controller to handle adding and editing the genre for a rank catalogue item
* fixed bug where the menu library wouldn't respect any access control put on main navigation menu items (#101)
* fixed bug where the menu library wouldn't respect any access control put on sub navigation menu items
* fixed undefined variable error thrown on site/catalogueranks
* fixed bug where rank catalogue items didn't work well when multiple genres were installed (#102)

Known Issues
------------
http://github.com/anodyne/nova/issues/labels/Bug

Version History
---------------
<table>
	<tr>
		<th>Version</th><th>Description</th><th>Start Date</th><th>End Date</th>
	</tr>
	<tr>
		<td>Release Candidate</td><td>Final candidate builds for golden master</td><td>01 March 2010</td><td>13 April 2010</td>
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