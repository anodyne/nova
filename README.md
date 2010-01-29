Nova RPG Management System
==========================
Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

Current Version
---------------
Beta (0.9.4-pre)

Last Update
-----------
29 January 2010

Latest Updates
--------------
* updated the styling of the readme
* updated the beta skin
* updated the jquery ui images to the base theme
* updated the jquery ui theme stylesheet to the base theme
* updated the lightness skin
* updated the redmond skin
* updated the sunny skin
* removed the version.xml file
* fixed bug with position sliders not updating the proper item (#72)

Changes in 0.9.4
----------------
* added the datepicker plugin
* added the jquery.ui.mouse file
* added the jquery.ui.widget file
* added the 0.9.4 update file
* updated the mission management page to use the datepicker
* updated the version info in the constants file
* updated the basic install data
    * version information
    * system information
    * jquery component information
    * jquery ui component information
    * removed textboxlist from components list
* updated the database schema
    * added the wiki category description field
* updated the index files in the core directory to use the proper line endings (unix) and encoding (utf8)
* updated the beta skin
    * added the skin.yml file
    * updated the main logo files
    * [admin] removed unused images
    * [admin] updated the skin images
    * [admin] updated the footer of the template
    * [admin] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [login] removed unused image files
    * [login] updated the image files
    * [login] updated the stylesheets
        * updated the styles to be cleaner and use better practices
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [main] removed unused images
    * [main] updated the skin images
    * [main] updated the footer of the template
    * [main] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] removed unused images
    * [wiki] updated the skin images
    * [wiki] updated the footer of the template
    * [wiki] updated the stylesheets
        * updated the skin.css file to match with some of the changes from the login's skin.css
* updated the sunny skin
    * updated the main logo files
    * [main] updated the stylesheets
        * updated the alt row color
        * added the info-full class
    * [login] updated the stylesheets
        * updated the skin.css file to match changes made to main's skin.css
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
    * [login] removed the ui.theme.css file
    * [login] removed the unused jquery ui theme images
    * [wiki] added the proper images
    * [wiki] removed unused images
    * [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * [wiki] updated the stylesheets
        * updated to look like the main section
        * updated the alt row color
        * updated the textboxlist styles to remove the focus shadow
        * added the markitup link fix
* updated the lightness skin
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
    * updated the main logo files
* updated the titan skin
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated the redmond skin
    * [login] updated the nova small logo
    * [login] updated the stylesheets
        * updated the skin.css file to remove unused styles
        * updated the structure.css file to remove unused styles
	* [wiki] removed the textboxlist images
    * [wiki] removed the textboxlist stylesheets
* updated jquery to version 1.4.1
* updated jquery ui to version 1.8rc1
* updated the head include files to pull in the jquery.ui.widget file which is now required
* updated the admin's head include file to set some depencies for the ui widgets
* updated the language files
    * [install\_lang] added key _update\_required_
    * [install\_lang] updated key _update\_outofdate\_database_ to change plurality of "links" to "link"
    * [base\_lang] added key _actions\_run_
* updated the update template to not have a copyright statement
* updated the install template to not have a copyright statement
* updated the update versions array
* updated the manage wiki categories page to allow creating a description
* updated the wiki head include to pull in the qtip plugin
* updated the wiki head include to not pull the textboxlist plugin
* updated the wiki page creation to use a different manner of selecting categories
* updated the wiki categories to handle a description as well
* updated the jquery ui images to the base theme
* updated the jquery ui theme stylesheet to the base theme
* removed old jquery ui files (version 1.8 uses a new naming scheme for the .js files)
* removed test update file
* removed the version.xml file
* fixed bug where the update panel wasn't showing the proper information at the right times (#71)
* fixed bug where viewing a wiki page or draft with fewer than 2 categories wouldn't display the category
* fixed bug with position sliders not updating the proper item (#72)

Known Issues
------------
* Problems with position sliders updating the wrong position's counts (#72)

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