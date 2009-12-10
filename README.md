Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Beta (0.9.0)

Last Update
-----------
10 December 2009

Latest Changes
--------------
* updated the index file to set the default timezone if nothing is set (fixes a PHP 5.3 issue with CI)
* updated the system model with a new method
* updated the character model
* updated the news mdoel
* updated the personal logs model
* updated the posts model
* updated the private messages model
* updated the specs model
* updated the tour model
* updated the users model
* updated the wiki model
* updated the admin controller
* updated the ajax controller
* updated the characters controller
* updated the install controller
* updated the main controller
* updated the manage controller
* udpated the messages controller
* updated the site controller
* updated the upgrade controller
* updated the wiki controller
* updated the write controller
* removed the personnel_player js view
* added the personnel_user js view (fixes #48)
* fixed major bug with PHP 5.3 and Simplepie where HTTPD would crash
* fixed major bug resulting from a change in PHP 5.3 with mysql_insert_id
* fixed bug with undefined variables when accepting or rejecting users

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