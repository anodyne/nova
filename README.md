Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
1.0-pre

Last Update
-----------
12 April 2010

Latest Updates
--------------
* updated the genre data files

Changes in 1.0-pre
------------------
* updated tour management with the new image upload management code
* updated the install data
    * menu items
    * menu item categories
    * access role pages
    * access roles
* updated the menu library with an all new method to build the admin sub menus that makes sure the right menu items and categories are displayed
* updated the admin controller with a tweak to the code for building its submenus
* updated the auth library with a minor change to some logic
* updated the genre data files
* removed test images
* fixed bug with undefined variable errors on the character bio page (#99)
* fixed wrong link for the edit bio link on the character bio page
* fixed wrong link for the mission groups link
* fixed bug with the date format dropdown menu
* fixed a couple of potential bugs in the mission management page
* fixed bug where users with permissions lower than system administrator couldn't edit their characters (#100)
* fixed bug the system didn't respect the access role allowing (or disallowing) people to upload images
* fixed bug where the system wasn't using access control on the docking form menu item

Known Issues
------------
http://github.com/anodyne/nova/issues/labels/Bug

* main navigation menu items do not respect any access control put on them (#101)
* ranks don't display properly when multiple genres have been installed (#102)

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