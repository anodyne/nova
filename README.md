Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Release Candidate 1 (0.9.6-pre)

Last Update
-----------
25 February 2010

Latest Updates
--------------
* updated the KLI genre file
* updated the BAJ genre file
* updated the DS9 genre file

Changes in 0.9.6
----------------
* added the 0.9.6 update file
* added the new jquery ui css files
* added the uniform jquery plugin
* added a javascript view for the upload index
* removed the old jquery ui css files
* removed the changes doc
* updated the install data
    * system info
    * system versions info
    * component info
* updated the database schema
    * users::daylight\_savings from enum to varchar
* updated the genre files
    * MOV
    * BAJ
    * ENT
    * TOS
    * KLI
    * ROM
    * BL5
    * AND
    * DS9
* updated the language files
    * [text\_lang] added _text\_dynamic\_emails_
    * [install\_lang] updated _upd\_error\_2_
* updated the sunny skin
    * removed the notes document
    * updated the skin.yml file
    * updated the wiki template file
    * updated the admin template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the titan skin
    * updated the skin.yml file
    * updated the wiki template file
    * [admin] updated the images
    * [admin] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
    * [main] updated the stylesheets
    * [wiki] updated the images
    * [wiki] updated the stylesheets
         * updated the skin stylesheet to match the main section
         * udpated the structure stylesheet to match the main section
* updated the dynamic emails to use both sim and ship (ship is left to maintain SMS upgrade compatability)
* updated the way updates are checked to use PHP's version\_compare function
* updated the constants config file
* updated the docking model methods to be listed alphabetically
* updated the jquery ui to version 1.8rc2
* updated the head include files with the new jquery ui css naming scheme
* updated all the skins with the new naming scheme
* updated the user section view files to use the new form layout
* updated the characters section view files to use the new form layout
* updated the skin stylesheets to tweak the new form layout
* updated the manage section view files to use the new form layout on some pages
* updated the site section view files to use the new form layout on some pages
* updated the admin section to clean up some UI inconsistencies
* updated thresher to clean up some UI inconsistencies
* updated markItUp! to version 1.1.6.1
* updated the site settings page to use the form layout
* updated the site settings page to handle rank selection better
* updated the update controller with the registration code
* updated the upgrade controller with the registration code
* updated jquery to version 1.4.2
* updated the controller constructors to cast the daylight savings value as a boolean instead of doing logic against it
* updated files to remove some of the remaining TODOs
* updated the install and upgrade process to try and automatically set the welcome page title
* fixed bug where the site messages always showed the type as page title (#74)
* fixed bug where the system versions accordion broke when there were multiple versions
* fixed bug where the system versions threw an error when only one version was in the database
* fixed bug where thresher threw errors when submitting a page without categories
* fixed bug where thresher still wasn't printing categories properly (should be completely fixed now)
* fixed bug where thresher was missing some language elements
* fixed bug where the rank ajax menus always showed the default rank set (#75)
* fixed bug with the install rank ajax menu where it wasn't passing the right information to the ajax method
* fixed bug with the registration process in the install controller

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