Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Release Candidate 4 (0.9.9)

Last Update
-----------
27 March 2010

Latest Updates
--------------
* fixed bug where adding an int field would error out because it tried to put a default value in (#94)
* fixed bug where in certain situations an error could be thrown pulling online users
* updated site settings to change the way the date format setting works

Changes in 0.9.9
----------------
* added the 0.9.9 update file
* updated the versions array file
* updated the install data
    * version info
    * component info
    * permanent credits message
* updated the shiloh skin
    * [main] updated the stylesheets
    * [wiki] added the wiki section
* updated the pulsar skin
    * [admin] added a new small loading circle graphic
    * [main] updated the structure stylesheet
* updated the nova license
* updated the language files
* updated the sms config file with directions about what each item is for
* updated to jquery ui version 1.8
* updated the constants config file with a constant for defining whether something is an ajax request
* updated several ajax methods that were vulnerable to outside hijacking
* updated several ajax methods to get the final order integer better
* updated the all news page to handle the lack of news better
* updated the contact page to not show the form if email is disabled
* updated the wiki manage categories page to show a message if there aren't any categories
* updated the wiki view page to only show the revert option if A) there's more than 1 draft and B) the draft row isn't the current page draft
* updated the wiki revert draft functionality to put a generic update message in place
* updated the write mission post page to check for missions and allow admins to create to create them right there
* updated the write mission post page to be able to set an upcoming mission to current on the fly if there aren't no current missions
* updated site settings to change the way the date format setting works
* fixed bug in the upgrade controller where an error would be thrown in certain circumstances
* fixed bug with adding bio dropdown values
* fixed bug where adding a deck and immediately trying to re-order it wouldn't work (#93)
* fixed error thrown when editing a specs field because of a misnamed array index
* fixed error thrown when editing a tour field because of a misnamed array index
* fixed error thrown when editing a docking field because of a misnamed array index
* fixed bug where adding a docking field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a specs form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a tour form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where adding a bio form field dropdown value then immediately updating them would trigger multiple animations
* fixed bug where the description for wiki categories couldn't be edited (#92)
* fixed bug where external images wouldn't display in character bio pages (#91)
* fixed bug where gallery wouldn't work unless there were 3 images
* fixed bug during install caused by not loading a library
* fixed bug during update caused by not loading a library
* fixed bug where reverting a wiki page wiped out the categories for the draft
* fixed bug where adding an int field would error out because it tried to put a default value in (#94)
* fixed bug where in certain situations an error could be thrown pulling online users

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