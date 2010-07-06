# Nova RPG Management System

Anodyne Production's next-generation RPG management system combines popular features from the SIMM Management System as well as new features like internationalization, developer enhancements, commenting on entries, dynamic forms, multiple characters per player and much more to make Nova the premier web-based solution for managing your RPG game.

## Current Version

1.0.6-pre

## Last Update

06 July 2010

## Changes in 1.0.6

* added the 1.0.6 update file
* updated the character bio management page to show a loader until everything has finished loading to help with load time
* updated jquery ui to version 1.8.2
* updated the auth library to remove some debug code since the autologin bug seems to have been solved
* updated the index page to turn down the error reporting (fatal errors and database errors will still be shown)
* updated the select menu on the write PM page to separate active and inactive characters
* updated colorbox to version 1.3.8
* updated the characters model to include a method for inserting promotion records
* updated the language file with a new item (_labels\_from_)
* fixed bug where acceptance and rejection messages were sent without any changes an admin made
* fixed error thrown when posting a comment on a mission post
* fixed bug where changing a character's state to and from active wouldn't set the open slots of their position(s)
* fixed error thrown when attempting to delete a character
* fixed bug where the position dropdowns when creating a character showed all positions instead of open positions
* fixed bug where rank history information wasn't being populated correctly

## Known Issues

http://github.com/anodyne/nova/issues/labels/Bug

## Version History

<table>
	<tr>
		<th>Version</th><th>Release Date</th>
	</tr>
	<tr>
		<td>1.0.6</td><td>-</td>
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