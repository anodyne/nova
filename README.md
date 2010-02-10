Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Beta (0.9.5-pre)

Last Update
-----------
10 February 2010

Latest Updates
--------------
* updated the managed docked items page to be able to edit a docked item
* updated the managed docked items page to display active, inactive and pending docked items
* updated the icon-delete icon
* added manage_docked_edit view file
* added the icon-cross icon
* added the icon-check icon

Changes in 0.9.5
----------------
* added the 0.9.5 update file
* added the 0.9.4 changelog to the docs directory
* added the docking user email view files
* added the docking gm email view files
* added the sim_docked_all view file
* added the sim_docked_one view file
* added the sim/docked js view file
* added the icon-view.png image to the main section
* added add_docking_field ajax view
* added add_docking_sec ajax view
* added del_docking_field ajax view
* added del_docking_sec ajax view
* added edit_docking_field_value ajax view
* added edit_docking_sec ajax view
* added site/dockingform js view
* added site/dockingsections js view
* added site/dockingform view
* added site/dockingform/edit view
* added site/dockingsections view
* added manage\_docked\_edit view file
* added the icon-cross icon
* added the icon-check icon
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
    * updated the menu items
    * updated the access pages
    * updated the access roles
    * updated the skin catalogue item
* updated the 0.9.4 update file
* updated the update versions array
* updated the colorbox plugin to version 1.3.6
* updated the site options page to handle skin previews like site/settings
* updated the language files
    * [base\_lang] added _global\_sims_
    * [base\_lang] added _status\_previous_
    * [base\_lang] added _labels\_requests_
    * [base\_lang] added _flash\_additional\_docking\_section_
    * [base\_lang] added _labels\_fields_
    * [base\_lang] removed _actions\_previous_
    * [email\_lang] added _email\_subject\_docking\_user_
    * [email\_lang] added _email\_subject\_docking\_gm_
    * [email\_lang] added _email\_content\_docking\_user_
    * [email\_lang] added _email\_content\_docking\_gm_
    * [text\_lang] added _text\_dockingsections_
    * [text\_lang] added _text\_dockingform_
    * [facebox\_lang] added _fbx\_content\_del\_docking\_sec_
    * [facebox\_lang] added _fbx\_content\_add\_docking\_sec_
    * [facebox\_lang] added _fbx\_content\_add\_docking\_field_
    * [facebox\_lang] added _fbx\_content\_del\_docking\_field_
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
* updated the ajax controller to handle operations for the docking form
* updated the ajax controller to handle operations for the docking sections
* updated the site controller to handle operations for the docking form
* updated the site controller to handle operations for the docking sections
* updated the control panel to notify of docking requests
* updated the manage missions page to use the new form layout
* updated the icon-add.png image
* updated the managed docked items page to be able to edit a docked item
* updated the managed docked items page to display active, inactive and pending docked items
* updated the managed docked items page to be able to edit a docked item
* updated the managed docked items page to display active, inactive and pending docked items
* updated the icon-delete icon
* fixed bug where a stray in comma threw errors in IE
* fixed bug in specs form management where values couldn't be added to the dropdown menus
* fixed bug in tour form management where values couldn't be added to the dropdown menus
* fixed bug in bio form management where values couldn't be added to the dropdown menus
* fixed bug where the datepicker wouldn't work if a date was passed to the field
* fixed bug where the bio page wasn't able to handle choosing which of multiple characters to edit if none was in the URI (#73)

Known Issues
------------
_None_

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