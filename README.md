Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Beta (0.9.1-pre)

Last Update
-----------
30 December 2009

Latest Changes
--------------
* added category icons
* added menu model method to grab the admin sub items
* added the menuca_type field to the install fields file
* updated manage/newscats with new category icons
* updated site/menus with new category icons
* udpated the ajax controller to allow adding and updating menucat_type
* updated the ajax view files to allow adding and updating menucat_type
* updated the menu model to allow filtering menu categories by type
* updated the menu library with the simplified code in _built_sub_admin()
* updated the basic install data with information about menu category types
* updated the private messages model to put the methods in the right order
* fixed bug in the admin control panel where the update notification text was wrong
* fixed bug where safari didn't respect -webkit-border-radius with multiple parameters
* fixed bug where the ui.tabs.css stylesheets used the wrong syntax for webkit border radius
* removed the get_admin_menu_active() method from the menu model
* removed the get_admin_menu_inactive() method from the menu model

Known Issues
------------
* Skin display issues in Internet Explorer
* Text display issues between operating systems

Version History
---------------
<table>
	<tr>
		<th>Version</th><th>Description</th><th>Start Date</th><th>End Date</th>
	</tr>
	<tr>
		<td>Beta</td><td>Feature complete testing version</td><td>10 Nov 2009</td><td>-</td>
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