## Form Builder

* Much like Wufoo, Nova really needs a form builder that will help admins creating their forms. (Likely a future update.)
* Drag fields on to the form to add.
* Click on a field to see all its properties and change them.
* Form options including intro text.

## Posting

* The ability to manually re-order posts, logs, and announcements.
    * http://www.foliotek.com/devblog/make-table-rows-sortable-using-jquery-ui-sortable/
    * Research nested sets as a way to do this.
* Admins can set archive locations in Site Settings for archiving sim content to an external locations
    * Specify where the post should be archived to (an email address for a Yahoo! or Google group)
	* Specify who the entry is coming from (:author: would be marked as coming from the person who posts or you can specific a single address they all come from)
	* Specify the subject format (available tokens are :simname:, :mission:, :title:, plus any free form text)
	* Can be done for mission posts, personal logs, and announcements

## Awards

* Rename from Crew Awards to Awards
* Categories should actually be called type
* Add the ability to create actual categories to sort awards by different types (level 1, level 2, battle awards, exploration awards, etc.)
    
## Catalogs

* If a skin has default sections in it, you shouldn't be able to remove or deactivate it
* Move setting skin defaults into the catalog instead of Site Settings (?)
* Need to research if there's an easy way to provide real multiple rank sets

## Site Content

* Page titles, headers and content will all be stored in the database and then cached by section so that we can use that content throughout the system without putting a ton of stress on the database with constant calls.
* When any site content is changed, we'll delete the cache and re-cache it automatically.
* Move the user menu options to a dropdown in the header.
* Admins should be able to put flags in their content to pull information from Site Settings.
    * {{settings: sim_name}} would go out and get the sim_name value from the settings table
* Store some of the most common language strings in the database. When a user updates them, the system will write a new file to `app/lang/en` with the updated strings.

## Access

* A warning will be shown when duplicating the system administrator role that it contains a lot of power and caution should be used.
* Need to be able to lock a player out of being able to get a lock on a post (maybe through moderation?)
* When logging in, Nova will check a user's status and if their status is INACTIVE, it will automatically set the access roles to the INACTIVE role instead of whatever role is stored in the database for them.

## Framework

* Use Bootstrap for as many components as possible to get rid of the bulk of jQuery UI.

## Settings

* Set the login attempts through Site Settings.
* Set the login lockout period through Site Settings (set in minutes, calculates to seconds in the Auth class).
* Set the template meta data through Site Settings.
* Admins can set archive locations in Site Settings for archiving sim content to an external locations
    * Specify where the post should be archived to (an email address for a Yahoo! or Google group)
	* Specify who the entry is coming from (:author: would be marked as coming from the person who posts or you can specific a single address they all come from)
	* Specify the subject format (available tokens are :simname:, :mission:, :title:, plus any free form text)
	* Can be done for mission posts, personal logs, and announcements

## Characters

* Allow users to create avatars for each of their characters that'll be displayed next to content throughout the system.

## Users

* Admins should be able to clear a user's login lockout from inside the system.
* If users are logged in, they have access to a user manifest.
    * Much like the character manifest, it'll display some basic information about users in the system.
	* Real name, email address, time in relation to the current user's timezone, link to user bio.
* Allow users to create avatars for their account that'll be displayed next to content throughout the system.

## Manifest

* Like SharePoint list views, you should be able to create different "views" for the manifest and be able to set criteria for those views. This would allow users to create different views for different manifests to show what they want.
* Views should be able to pull any information from the character and user sets of data.

## Application Review System

* When an application is received, it's thrown in to a review system where approved users can comment on an application and ultimately vote YES, NO or NO DECISION on the application.
* Rules can be set for applications.
    * If an application is received for any departments, add User A to the review process.
    * If an application is received for Departent A, add User B to the review process.
    * If a rule has no users, the state of the rule needs to be changed to INACTIVE so that it won't be triggered by an application.
    * If User A is on LOA or ELOA, they shouldn't be added to the review process.
    * When a user is deactivated, they need to be removed from all rules.
* Does this mean we can't ever delete characters or users? Without it, there would be no access to the history of applications. (If not, we might be able to store an application as XML and then when they're accepted, move them in to the database.)

## Thresher Release 3

* Need to brainstorm if it's possible to have content pages stored in Thresher and available through normal URLs as an easy way for people to create content pages in the flow of the rest of the system.
* Move Thresher to its own module.

## Mako Release 1

* Threads can be marked as posting threads so that Nova's counting systems can count those posts in reporting features.
* Threads and sections can be marked as public or private. If they're set to private, only authenticated users can see them (much like private news items).
* Polls. I know we originally said no polls, but they could come in really handy.
    * Polls can be marked as public answer or private answer.
        * If a poll is marked as public answer, once a user replies, their answer will be posted by their name.
        * If a poll is marked as private answer, their answer will not be displayed, even to admins.

## Report Center

* Like manifest views, it'd be awesome to be able to give admins tons of options for creating their own reports based on what they want.

## Skinning

* Build default skins with LESS for more consistency. We should also provide the option of download the development versions of skins that will have the LESS files in case advanced skin developers want to use LESS.
* Use Bootstrap's scaffolding in the first-party skins.

## First-Party Modules

* Chain of Command
    * Allow a separate CoC for each manifest
    * Drag-and-drop reordering
* Docking
    * Use the API to be able to show the manifest of docked ships that use Nova 3
* Tour and Specs
    * Specs needs to be completely overhauled to be more flexible
    * Specs should be separated in to tabs
        * Specs
        * Deck listing
        * Tour items
        * Related items (shuttles, etc.)