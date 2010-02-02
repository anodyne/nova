Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Beta (0.9.5-pre)

Last Update
-----------
01 February 2010

Latest Updates
--------------
* added the january 2010 changelog archive file
* added docking model
* added docking user email view files
* added docking gm email view files
* added sim/docked view file
* added sim/docked js view file
* updated the database schema to add the docking tables
* updated the main controller to change a language key
* updated the sim controller to chang a language key
* updated the language files
* updated the dev install data
* removed the old docking request email views

Changes in 0.9.5
----------------
* added the 0.9.5 update file
* added the 0.9.4 changelog to the docs directory
* added the docking user email view files
* added the docking gm email view files
* added the sim/docked view file
* added the sim/docked js view file
* removed the old docking request email views
* updated the database schema
    * added docking table
    * added docking_data table
    * added docking_fields table
    * added docking_sections table
    * added docking_values table
* updated the basic install data
    * updated the version info
    * updated the system info
    * updated the version history info
    * updated the menu items
    * updated the colorbox version info
* updated the 0.9.4 update file
* updated the update versions array
* updated the colorbox plugin to version 1.3.6
* updated the site options page to handle skin previews like site/settings
* updated the language files
    * [base\_lang] added _global\_sims_
    * [base\_lang] added _status\_previous_
    * [base\_lang] added _labels\_requests_
    * [base\_lang] removed _actions\_previous_
    * [email\_lang] added _email\_subject\_docking\_user_
    * [email\_lang] added _email\_subject\_docking\_gm_
    * [email\_lang] added _email\_content\_docking\_user_
    * [email\_lang] added _email\_content\_docking\_gm_
* updated the sunny skin
    * added the preview-main.jpg image
    * removed the preview-main.png image
    * updated the skin.yml file with the new preview image
    * [main] updated the stylesheets
         * updated the panel handle to not have top and side borders
         * updated the main menu styles to fix a strange bug in IE
* updated the beta skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
    * added the preview-wiki.jpg image
    * removed the preview-main.png image
    * removed the preview-admin.png image
    * removed the preview-login.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
* updated the lightness skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
	* added the preview-wiki.jpg image
	* removed the preview-admin.png image
    * removed the preview-main.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
* updated the redmond skin
    * added the preview-main.jpg image
    * added the preview-admin.jpg image
	* added the preview-wiki.jpg image
	* removed the preview-admin.png image
    * removed the preview-main.png image
    * removed the preview-wiki.png image
    * updated the skin.yml file with the new preview images
    * [admin] updated the stylesheets
        * updated the alt row color
	* [main] updated the stylesheets
        * updated the alt row color
	* [wiki] updated the stylesheets
        * updated the alt row color
* updated the main and sim controllers to update some language keys
* updated the docking request form to use the dynamic form
* fixed bug where a stray in comma threw errors in IE

Known Issues
------------


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