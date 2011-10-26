# Changelog

## v2.0

### General

* Site Messages can now contain previously disallowed HTML tags (like `embed`, `iframe`, etc) for adding media from YouTube and Vimeo to site messages (like the welcome message) without needing to use seamless substitution.
* Mission groups can now be added inside other mission groups (nesting only allowed one level deep).
* Users with Level 2 user admin access rights can now reset someone's password for them. The new password will be generated and emailed to the user and they'll be prompted to reset the password the next time they log in. At no time does the user with Level 2 user admin access rights see what the newly generated password is.
* Multi-author posts are now locked during editing to prevent users editing the same post at the same time. The lock is released after the user saves their changes or they've gone 5 minutes without making a change. (In the event a user has changed something and walked away, their changes will be saved to the post first.)
* Admins now have the option of showing the latest personal logs and mission posts on the main page. (Admins will be able to select any combination of news, logs and posts.)
* Admins now have the option of setting the top open positions (from Position Management) that will be shown at the top of each manifest (not manifest-specific).
* Added a rules page to the main section that can be updated from the Site Messages page.
* The instructions on the upload page now include the maximum file size and maximum image dimensions (pulled from the upload config file) for reference to anyone uploading images.
* The deck listing page now uses a table-less layout for a cleaner look.
* The deck listing page now has a menu of decks at the top of the page for quickly moving to a deck item without having to scroll. (We think RPGs with a lot of decks are going to love this!)
* Overhauled the user interface for mission groups to provide more information (and look a lot better too).
* When composing a mission post, the dropdown will now show who owns a linked NPC.
* When composing a mission post, personal log or private message, users only have to start typing a name and the options will be narrowed down for them.
* The skin catalogue now allows removing an entire skin (with sections) and letting admins choose which skin users will beupdated to for each section.
* The user account page now has options to make activating and deactivating users a lot easier.
    * When deactivating a user, all active characters associated with that account with also be deactivated.
    * When activating a user, admins will be prompted about which of the user's inactive characters should be reactivated.
* The character bio page now has options to make activating and deactivating characters a lot easier.
    * Activating an inactive character (and all related actions) can now be done with the push of a button.
    * Deactivating an active character (and all related actions) can now be done with the push of a button.
    * Making an NPC an active character (and all related actions) can now be done with the push of a button.
    * Making a character an NPC (and all related actions) can now be done with the push of a button.
* When viewing a character's posts, the entries will be paginated to help with load times and usability.
* When viewing a character's logs, the entries will be paginated to help with load times and usability.
* Site manifests can now store default view information so that different manifests can have different view settings. (This is now handled through Site Manifest management instead of Site Settings.)
* Gave the Pulsar skin a refreshed look and feel.
* The Writing Control Panel now shows a notification for any entires that have been commented on in the last 30 days (along with a link to the comments section of the entry).
* The manifest has been reorganized (for the first time ever) with a slightly different look.

### The Nova Core

#### Framework

* Moved to CodeIgniter 2.0.3 (was previously 1.7.3).
* Moved to a brand new file structure that further removes the Nova Core from any changes an admin might be making.
* Added __experimental__ module support.
* Updated to jQuery 1.7.
* Updated to jQuery UI 1.8.16.
* Updated to jQuery Uniform 1.7.5.
* Updated to jQuery prettyPhoto 3.1.2.
* Added the jQuery Chosen plugin.
* Added the Bootstrap by Twitter Twipsy plugin (version 1.3).
* Added the Bootstrap by Twitter Popover plugin (version 1.3).
* Removed the qTip plugin. (Please use the Bootstrap Twipsy plugin instead.)
* Changed the `banned.php` file to `message.php` that now contains notifications of Level 2 bans, a missing `nova` directory and incompatible PHP version information.
* Seamless substitution can now be used to override email view files from the `_base_override` directory.
* Added seaQuest DSV as a genre option.

#### Helpers/Libraries/Models

* Changed the Location helper into a library with static methods (`Location::view` instead of `view_location`).
* Removed the RSS model. (It isn't necessary since most of the calls were duplicated in the appropriate post type models.)
* Added constants to the Access model for the default access roles.
* The Missions model now allows group missions to be pulled from `get_all_missions()`.
* The Missions model now has a method to count mission groups: `count_mission_groups()`.
* The Users model now has a method to pull all of a user's LOA records: `get_user_loa_records()`.
* The Auth library now uses static methods to be able to call quicker (`Auth::check_access()` instead of `$this->auth->check_access()`).

#### Install/Update/Upgrade

* Nova will always check for the existence of the database config file. If the file isn't found, Nova will enter a new config setup wizard that will walk admins through setting up the config file, test the connection and then write the file for them.
* The SMS Upgrade process will now migrate SMS Database entries to the Thresher wiki page format.
* Completely re-wrote the upgrade process to not use config files (admins select the components they want upgraded through a user interface), to show more useful validation messages and be a shorter, more pleasant process (reduced the number of steps from 14 to 4).

### Thresher

* Changed the way users manage categories when creating and editing a wiki page.
* Users with the proper permissions can now create categories when creating and editing a wiki page.
* If there are no categories set in Thresher and the user has the proper permissions, they will be prompted to create some new categories when creating and editing a wiki page.
* Changed the user experience for managing wiki pages that puts more controls at the user's disposal and simplifies the entire page.
* Changed the user interface for viewing wiki pages to make it simpler.
* Users must have Level 1 wiki page access to see the page history now.
* Only users who are logged in can see comments on a wiki page.
* Added system pages to Thresher that allow some of the system pages to have their content changed like a normal wiki page.
* Users can now search Thresher from the main Thresher page.
* Fixed several bugs with the listing of Thresher search results.
* Removed the recently changed and recently updated listings from the main Thresher page.
* Users can now subscribe to an RSS feed for created wiki pages as well as updated wiki pages.

### Bug Fixes

* Seamless substitution of images wouldn't work when the images were in the `_base_override` directory.
* The `RE:` and `FWD:` tags would be added to private message subjects when replying and forwarding indefinitely until there was no space left for the actual subject line. Now, Nova will make sure it's only added once.
* When replying to a private message, the author of the message would be added to the recipient list, so any message they send would also show up in their inbox as well. (This behavior can be duplicated by manually adding themselves to the recipients list.)
* The join form could be submitted without an email address or password.
* Users who were deactivated kept their account flags (system administrator, game master, webmaster) and their access role. Now, all account flags and access roles are changed on deactivation.
* Users who were reactivated didn't have their access role set to Standard User.
* Inactive users were shown a link in the sub-navigation to upload an image even though they don't have permissions to upload images.
* A password could be reset for a user even if they don't have a security question chosen.
* Patched several potential security and access issues.
* Positions weren't properly updated when deleting an active character.
* Pulsar styling issues in Internet Explorer 9.
* Titan styling issues in Internet Explorer 9.
* When viewing character or user award, the "Nominated By" line was shown even if there was no nomineed. (This is only an issue for RPGs who upgraded from SMS.)
* The Enterprise-era (ENT) genre install file had several issues and typos.
* The database automatically set a default rank for pending users potentially resulting in some confusion as to why a pending user already has a rank.