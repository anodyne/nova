# Nova RPG Management System

Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

## Current Version

1.2-pre

## Changes in 1.2

* added the 1.2 update file
* added the ability to ban users from applying or even getting to the site
* added a page that level 2 bans are redirected to
* added the validation error image to the assets directory
* added the assignment image to the admin \_base directory
* added seaquest dsv to the available genres
* updated the applications report to show email address and IP address of the user who applied
* updated the email sent to the game master from the join form to show the IP address of the applicant
* updated the contact form to be simpler and use proper form validation
* updated the departments model with methods for handling multiple manifests
* updated jquery to version 1.4.4
* updated jquery ui to version 1.8.6
* updated the autoload config item to not try and autoload the input library since CI loads it by default
* updated the user model with a method to pull user information based on characters in the database
* updated department management with a better interface for working with departments
* updated position management to split departments out by manifest
* updated the language files
    * [base\_lang] added _labels\_ban_
    * [base\_lang] added _labels\_bans_
    * [base\_lang] added _labels\_ipaddr_
    * [base\_lang] added _labels\_header_
    * [base\_lang] added _labels\_listings_
    * [base\_lang] added _labels\_manifests_
    * [base\_lang] added _labels\_refresh_
    * [base\_lang] added _labels\_unassigned_
    * [base\_lang] added _misc\_level1\_only_
    * [text\_lang] added _text\_bans_
    * [text\_lang] added _text\_ban\_join_
    * [text\_lang] added _text\_manifest\_delete\_departments_
    * [text\_lang] added _text\_manifest_
    * [text\_lang] added _text\_manifest\_assign_
    * [text\_lang] added _text\_duplicate\_dept_
    * [text\_lang] updated _text\_manage\_depts_
* fixed bug where users without an active character would be shown in the activity warning panel on the ACP
* fixed bug where the sample post in the join application email was just a massive wall of text
* fixed bug where the specifications weren't properly upgraded during the sms upgrade process
* fixed bug with a missing closing tag on the create characters page
* fixed bug where timezone menu in site/settings pulled the wrong value to populate the field with
* fixed bug where the join page was pulling an image from the wrong location
* fixed spacing bug in access role management
* fixed spacing bug in news item management
* fixed spacing bug in log management
* fixed spacing bug in post management
* fixed spacing bug in department management
* fixed some errors being thrown throughout the system
* fixed bug where the flash message view couldn't be overridden with seamless substitution

## Version History

<table>
	<tr>
		<th>Version</th><th>Release Date</th>
	</tr>
	<tr>
		<td>1.2</td><td>-</td>
	</tr>
	<tr>
		<td>1.1.2</td><td>14 October 2010</td>
	</tr>
	<tr>
		<td>1.1.1</td><td>27 September 2010</td>
	</tr>
	<tr>
		<td>1.1</td><td>4 September 2010</td>
	</tr>
	<tr>
		<td>1.0.6</td><td>14 July 2010</td>
	</tr>
	<tr>
		<td>1.0.5</td><td>06 June 2010</td>
	</tr>
	<tr>
		<td>1.0.4</td><td>12 May 2010</td>
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