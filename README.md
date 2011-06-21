# Nova RPG Management System

Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

## Current Version

2.0-beta

## Changes in 2.0

* brand new file structure that further separates the nova core from user modifications and makes updating infinitely easier
* added the message.php file to handle notification of bans, a missing "nova" directory and incompatible PHP version
* added new process to write the database config file for you
* added the ability to upgrade SMS Database entries to Thresher wiki pages
* added the ability for textareas to "grow" as more text is added like Facebook
* added the ability for site messages to have previously disallowed HTML tags (like embed, iframe, etc.) for embedding media assets from YouTube and Vimeo
* added the ability to nest mission groups one level deep
* added the ability for someone with level 2 admin rights to reset someone's password (the new password will be emailed to the user and they'll be prompted to reset the password the next time they log in)
* updated seamless substitution to be able to override email view files
* updated Thresher with a new way to create and manage categories when working on a wiki page
* updated Thresher with a completely new user experience for managing wiki pages
* updated Thresher with a brand new interface for viewing wiki pages
* updated the upload instructions to include the maximum file size and maximum image dimensions from the config file for reference
* updated the deck listing page (sim/decks) to not use a table which makes for a much cleaner layout
* updated the deck listing page (sim/decks) to have a menu of decks for quickly moving to a deck item without having to scroll (handy for sim with lots of decks)
* updated to jquery version 1.6.1
* updated to jquery version 1.8.13
* updated to uniform version 1.7.5
* updated to prettyPhoto version 3.1.2
* updated to qTip2
* updated the database to not use a default value for a character's rank to avoid confusion when dealing with pending characters
* updated the UI for listing mission groups to provide more information and look a lot better
* updated the missions model to allow group missions to be pulled from the get_all_missions method
* updated the missions model with a method to count mission groups
* updated the users model with a method to pull all of a users' LOA records
* updated the mission post writing page to show who owns a linked NPC
* updated the skin catalogue to allow removing an entire skin (with sections) and letting admins choose which skin users will be updated to for each section
* updated the user account page to make activating and deactivating users a lot easier
* updated the user account page so that when deactivating a user, it will also deactivate all active characters associated with that user account
* updated the user account page so that when activating a user, it will prompt the admin about which of the user's inactive character should be reactivated
* refactored the location helper into a full-blown class with static methods
* refactored the upgrade process to mirror what was created for nova 3
* removed the banned.php file
* removed the rss model since it isn't necessary any more
* fixed bug with seamless substitution of images where they wouldn't work when they were in the _base_override directory
* fixed bug with private messages where RE: and FWD: would constantly be added to message, now Nova will make sure it's only added once
* fixed bug with private messages where the person sending the message would be on the recipient list, so any message they sent would show up in their inbox as well
* fixed bug where the join form could be submitted without an email address or password
* fixed bug where users who were deactivated kept their account flags (sysadmin, game master, etc.) and their access role
* fixed bug where users who were reactivated didn't have their access role set to Standard User

## Version History

<table>
	<tr>
		<th>Version</th><th>Release Date</th>
	</tr>
	<tr>
		<td>2.0</td><td>-</td>
	</tr>
	<tr>
		<td>1.2.5</td><td>16 June 2011</td>
	</tr>
	<tr>
		<td>1.2.4</td><td>25 January 2011</td>
	</tr>
	<tr>
		<td>1.2.3</td><td>04 January 2011</td>
	</tr>
	<tr>
		<td>1.2.2</td><td>30 December 2010</td>
	</tr>
	<tr>
		<td>1.2.1</td><td>23 December 2010</td>
	</tr>
	<tr>
		<td>1.2</td><td>20 December 2010</td>
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