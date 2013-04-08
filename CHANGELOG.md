# Changelog

## 2.2.3 (7 April 2013)

### Bug Fixes

* Some users have reported errors being thrown during the update process that prevent them from moving up to newer versions of Nova. We've attempted to create a fix for this, but since we haven't been able to recreate the issue, this may or may not work.

## 2.2.2 (27 March 2013)

### Bug Fixes

* Fixed error thrown when managing NPCs. (Thanks to evshell18 for the fix and pull request.)
* Fixed issue where users without `wiki/categories` permissions couldn't create or edit wiki pages. ([#239](https://github.com/anodyne/nova/issues/239))

## 2.2.1 (09 March 2013)

### Nova Core

* Updated the jQuery prettyPhoto plugin to version 3.1.5.

### Bug Fixes

* Fixed update message always displaying because of a wrong version number in the core.

## 2.2.0 (15 February 2013)

* Added reply to header to most of the emails that are sent from Nova. ([#217](https://github.com/anodyne/nova/issues/217))
* Update author listings to provide links to each character's bio page. Thanks to Jordan Jay for his MOD to do this. We've expanded on his idea to provide this functionality for mission posts, personal logs, news items, wiki pages and comments. ([#223](https://github.com/anodyne/nova/issues/223))
* Removed the SMS Archive feature since it's no longer needed.

### Nova Core

* Updated the characters model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
* Updated the docking model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
* Updated the specs model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
* Updated the tour model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
* Updated copyright dates in source code. ([#224](https://github.com/anodyne/nova/issues/224))

### Bug Fixes

* When viewing a mission post that doesn't exist, Nova throws a fatal error. ([#233](https://github.com/anodyne/nova/issues/233))
* When using the tour form, Nova throws an error.
* Sub-department names and descriptions weren't displayed properly when managing positions. ([#232](https://github.com/anodyne/nova/issues/232))
* A missing closing tag on the character bio management page caused display problems.
* When upgrading from SMS, system administrators didn't have the proper flags set.
* When using the personal logs RSS feed, the link to the entry went to the view post page, not the view log page. ([#234](https://github.com/anodyne/nova/issues/234))

## 2.1.3 (05 November 2012)

### Bug Fixes

* Restoring lost functionality on some pages due to the security vulnerability update. ([#215](https://github.com/anodyne/nova/issues/215))

## 2.1.2 (04 November 2012)

### Nova Core

* Update to jQuery 1.8.2.
* Update to jQuery UI 1.8.24.
* Update to markItUp! 1.1.13.
* Update to CodeIgniter 2.1.3.
* Update Nova to address a security issue.

### Bug Fixes

* Once a bio field is turned off, the only way to turn it back on is by going in to the database and changing the display value. ([#214](https://github.com/anodyne/nova/issues/214))
* Once a docking field is turned off, the only way to turn it back on is by going in to the database and changing the display value. ([#214](https://github.com/anodyne/nova/issues/214))
* Any spec form field that is turned off has no indication that it's disabled.
* Any tour form field that is turned off has no indication that it's disabled.

## 2.1.1 (12 September 2012)

### Nova Core

* Update to CodeIgniter 2.1.2.
* Update to jQuery 1.8.1.
* Update to jQuery UI 1.8.23.
* Update the IP Address fields in the database to be compatible with IPv6 addresses.

### Bug Fixes

* During the update process, Nova never updated the system information table with the correct version number.
* Despite the system version and components database tables being pulled out, the What's New menu item was never removed, throwing a 404 error if someone tried to go to the page.
* The Admin Control Panel's update notification panel doesn't properly display all the language strings because the proper language file wasn't loaded.
* The user bio page had debug code from 2.1 development at the top of the page.
* Under some circumstances, unlinked NPCs had a link to a user bio that threw an error.
* The User Not Found error was missing a parameter (would show %s instead of the word 'user').

## 2.1.0 (26 June 2012)

* Users are now notified when mission notes have been updated in the last 72 hours by the notes box auto-expanding when they arrive at the posting page.
* Users are now shown when the last update to the mission notes was all the time.

### Nova Core

* Remove the `count_unread_pms` method from the private messages model. (This method was deprecated in Nova 2.0.)
* Remove the `system_components` and `system_versions` tables from the database. There's really no reason to be maintaining these lists in Nova. Instead, users who are interested in Nova's components and version history should visit AnodyneDocs.
* Remove the What's New page for the reasons specified above.
* Update the Version Information page to reflect the database changes.
* Update the post, log, and news creation pages to give a description of what tags are meant to be used for.
* Remove jQuery library from the file system. We now pull jQuery from a CDN instead of storing it locally.
* Update to jQuery UI 1.8.20 (we now include the entire jQuery UI library for anyone who wants to use components we don't use).
* Update to prettyPhoto 3.1.4.
* Update to jQuery Reflection 1.1.

### Bug Fixes

* The update page would always throw an error that it couldn't find Nova installed in the current database.
* When a mission was updated, it was assumed mission notes updated as well. Now, there's greater precision in determining if the notes were actually updated.
* Accepting or rejecting docking applications would throw a fatal error because the Messages model wasn't loaded before it was used.
* Join timespan always showed as a user joining "1 Second ago" no matter when they joined.
* Nova's `timespan_short` helper was missing the word "ago" when the time was less than an hour.
* The Site Messages page didn't strip HTML tags from the content potentially allowing unclosed HTML tags to wreak havoc on the page.

## 2.0.3 (01 March 2012)

### Nova Core

* Updated jQuery UI to version 1.8.18.

### Bug Fixes

* Benchmarking psuedo-variables are not handled properly because of the fact the Template library doesn't not use the Output library for sending content to the browser.
* When saving posts with the Post Participants feature turned off, Nova would throw errors about a database field not accepting NULL values.

## 2.0.2 (09 February 2012)

### Nova Core

* Removed the social interaction tools from prettyPhoto image modals. ([#169](https://github.com/anodyne/nova/issues/169))
* Added some code to try and make the mission post locking auto-release a little smarter.

### Bug Fixes

* Under some (strange) circumstances, Nova could throw errors from the Ajax controller.
* A typo in the language string on the reset password page when the security question you select doesn't match what's in the database.
* If a user has multiple playing characters assigned to them, the milestones listing would display their main character name for every playing character they had assigned to them instead of just displaying it once.
* The new manifest layout has some display issues when using sub departments. ([#168](https://github.com/anodyne/nova/issues/168))
* When updating the content of a deck, the submit process went back to the select screen instead of staying on the current item's page.
* When deleting specification items, if there are decks associated with that spec item, they're orphaned and not deleted.
* The Who's Online listing displayed random spaces and commas.
* Character image galleries duplicated the primary image.

## 2.0.1 (04 February 2012)

### Bug Fixes

* If the user's screen isn't wide enough, the tooltip on the Writing Control Panel that displays the post lock information can slide partially out of view.
* Nova tried to load a language file through an object that couldn't see it, resulting in an error thrown about the file not being found.

## 2.0 (04 February 2012)

* Site Messages can now contain previously disallowed HTML tags (like `embed`, `iframe`, etc) for adding media from YouTube and Vimeo to site messages (like the welcome message) without needing to use seamless substitution.
* Mission groups can now be added inside other mission groups (nesting only allowed one level deep).
* Users with Level 2 user admin access rights can now reset someone's password for them. The new password will be generated and emailed to the user and they'll be prompted to reset the password the next time they log in. At no time does the user with Level 2 user admin access rights see what the newly generated password is. ([#16](https://github.com/anodyne/nova/issues/16))
* Multi-author posts are now locked during editing to prevent users editing the same post at the same time. The lock is released after the user saves their changes or they've gone 5 minutes without making a change. (In the event a user has changed something and walked away, their changes will be saved to the post first.)
* Admins now have the option of showing the latest personal logs and mission posts on the main page. (Admins will be able to select any combination of news, logs and posts.)
* Admins now have the option of setting the top open positions (from Position Management) that will be shown at the top of each manifest (not manifest-specific).
* Added a rules page to the main section that can be updated from the Site Messages page.
* The instructions on the upload page now include the maximum file size and maximum image dimensions (pulled from the upload config file) for reference to anyone uploading images. ([#143](https://github.com/anodyne/nova/issues/143))
* The deck listing page now uses a table-less layout for a cleaner look.
* The deck listing page now has a menu of decks at the top of the page for quickly moving to a deck item without having to scroll. (We think RPGs with a lot of decks are going to love this!)
* Overhauled the user interface for mission groups to provide more information (and look a lot better too).
* When composing a mission post, the dropdown will now show who owns a linked NPC.
* When composing a mission post, personal log or private message, users only have to start typing a name and the options will be narrowed down for them. ([#23](https://github.com/anodyne/nova/issues/23))
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
* Site manifests can now store default view information so that different manifests can have different view settings. (This is now handled through Site Manifest management instead of Site Settings.) ([#157](https://github.com/anodyne/nova/issues/157))
* Gave the Pulsar skin a refreshed look and feel.
* Gave the Titan skin a refreshed look and feel. (If you're interested in changing the header image, please see Titan's README.md file for instructions.)
* The Writing Control Panel now shows a notification for any entires that have been commented on in the last 30 days (along with a link to the comments section of the entry).
* The manifest has been reorganized (for the first time ever) with a slightly different look.
* The email sent to the game master when a user applies now goes to anyone who can approve or reject character applications.
* Acceptance and rejection emails now CC in anyone who can approve or reject character applications.
* Users can now search within their sent and received private messages.
* Private messages have now been split in to separate inbox and sent message pages. This will help improve performance since the page doesn't have to load all the messages at once then split them off in to tabs.
* Private messages in the inbox and sent messages list are now paginated.
* The Reply to All link when reading a private message is only displayed if there's more than one recipient.
* The Reply, Reply to All and Forward options when reading a private message are now displayed above and below the private message.
* Users can now mark all unread private messages as read with a single click.
* An all-new redesigned character bio page provides a better, cleaner user experience.

### The Nova Core

* Moved to CodeIgniter 2.1 (was previously 1.7.3).
* Moved to a brand new file structure that further removes the Nova Core from any changes an admin might be making.
* Added __experimental__ module support.
* Updated to jQuery 1.7.1.
* Updated to jQuery UI 1.8.17.
* Updated to jQuery Uniform 1.7.5.
* Updated to jQuery prettyPhoto 3.1.3.
* Updated to markItUp! 1.1.12.
* Added the jQuery Chosen plugin.
* Added the Bootstrap by Twitter Twipsy plugin (version 1.4).
* Added the Bootstrap by Twitter Popover plugin (version 1.4).
* Removed the qTip plugin. (Please use the Bootstrap Twipsy plugin instead.)
* Changed the `banned.php` file to `message.php` that now contains notifications of Level 2 bans, a missing `nova` directory and incompatible PHP version information.
* Seamless substitution can now be used to override email view files from the `_base_override` directory.
* Added seaQuest DSV as a genre option. ([#144](https://github.com/anodyne/nova/issues/144))
* Changed the Location helper into a library with static methods (`Location::view` instead of `view_location`).
* Removed the RSS model. (It isn't necessary since most of the calls were duplicated in the appropriate post type models.)
* Added constants to the Access model for the default access roles.
* The Missions model now allows group missions to be pulled from `get_all_missions()`.
* The Missions model now has a method to count mission groups: `count_mission_groups()`.
* The Users model now has a method to pull all of a user's LOA records: `get_user_loa_records()`.
* The Auth library now uses static methods to be able to call quicker (`Auth::check_access()` instead of `$this->auth->check_access()`).
* Nova will always check for the existence of the database config file. If the file isn't found, Nova will enter a new config setup wizard that will walk admins through setting up the config file, test the connection and then write the file for them.
* The SMS Upgrade process will now migrate SMS Database entries to the Thresher wiki page format.
* Completely re-wrote the upgrade process to not use config files (admins select the components they want upgraded through a user interface), to show more useful validation messages and be a shorter, more pleasant process (reduced the number of steps from 14 to 4).
* View files now check for the existence of the BASEPATH constant before rendering. On some servers, random `error_log` files are generated all over the place. A big part of this is view files that are accessed apart from the framework and generate PHP fatal errors. This fix should help eliminate those error log files.
* In preparation for future deprecation, we've removed all references to jQuery's `.live()` method. Third party developers should ensure their own code is updated as soon as possible to avoid any issues once the method is removed from the jQuery core.

### Thresher

* Changed the way users manage categories when creating and editing a wiki page. ([#137](https://github.com/anodyne/nova/issues/137))
* Users with the proper permissions can now create categories when creating and editing a wiki page. ([#64](https://github.com/anodyne/nova/issues/64))
* If there are no categories set in Thresher and the user has the proper permissions, they will be prompted to create some new categories when creating and editing a wiki page.
* Changed the user experience for managing wiki pages that puts more controls at the user's disposal and simplifies the entire page. ([#141](https://github.com/anodyne/nova/issues/141))
* Changed the user interface for viewing wiki pages to make it simpler.
* Users must have Level 1 wiki page access to see the page history now.
* Only users who are logged in can see comments on a wiki page.
* Added system pages to Thresher that allow some of the system pages to have their content changed like a normal wiki page. ([#123](https://github.com/anodyne/nova/issues/123))
* Users can now search Thresher from the main Thresher page.
* Fixed several bugs with the listing of Thresher search results.
* Removed the recently changed and recently updated listings from the main Thresher page.
* Users can now subscribe to an RSS feed for created wiki pages as well as updated wiki pages.
* Admins can now restrict access to a wiki page based on access role. ([#11](https://github.com/anodyne/nova/issues/11), [#12](https://github.com/anodyne/nova/issues/12))

### Bug Fixes

* Seamless substitution of images wouldn't work when the images were in the `_base_override` directory.
* The `RE:` and `FWD:` tags would be added to private message subjects when replying and forwarding indefinitely until there was no space left for the actual subject line. Now, Nova will make sure it's only added once. ([#158](https://github.com/anodyne/nova/issues/158))
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
* The Enterprise-era (ENT) genre install file had several issues and typos. ([#155](https://github.com/anodyne/nova/issues/155))
* The database automatically set a default rank for pending users potentially resulting in some confusion as to why a pending user already has a rank. ([#148](https://github.com/anodyne/nova/issues/148))
* If there is only one specification item, the list of items would be dispalyed instead of automatically sending the user to the only specification item. ([#146](https://github.com/anodyne/nova/issues/146))
* If there is only one specification item, the list of decks would be dispalyed instead of automatically sending the user to the only deck listing. ([#147](https://github.com/anodyne/nova/issues/147))
* During fresh installs, the user ID constraint wasn't consistent with the rest of the user ID fields throughout the system.
* Under some circumstances, users could edit posts they weren't even a part of. (Thanks to evshell18 on the Anodyne forums for pointing this out and getting the ball rolling on a fix.)

## 1.2.6 (15 July 2011)

### Bug Fixes

* Addressed some major security issues.
* The Writing Control Panel included several wrong links.
* Character mission posts weren't accurately pulled from the database.

## 1.2.5 (16 June 2011)

### Bug Fixes

* Specification data wouldn't get added to the database table for old items if a new field was added.
* Deactivated users would retain their account flags (system administrator, game master, webmaster) and wouldn't have their access role changed.
* Reactivated users wouldn't be given a reasonable access role.

## 1.2.4 (25 January 2011)

### Nova Core

* Updated to jQuery UI 1.8.9.

### Bug Fixes

* Mission posts weren't accurately counted.
* The user acceptance email CCed in more people that needed to be.
* The manifest wouldn't load in Internet Explorer 7.

## 1.2.3 (04 January 2011)

### Bug Fixes

* Addressed issues handling deck listings and multiple specification items.

## 1.2.2 (30 December 2010)

### Bug Fixes

* Sub departments couldn't be managed from the Department management page.
* Mission post emails didn't display the authors properly.
* Addressed access issues created by the update from 1.1.2.

## 1.2.1 (23 December 2010)

### Bug Fixes

* Positions would disappeaer when being updated.
* Errors thrown when trying to update character images when there aren't any images present.
* Error thrown from the RSS feed.

## 1.2 (20 December 2010)

* Admins can now ban users from applying to the game (level 1) or even getting in to the site (level 2)
* If the system detects a Level 2 ban, the user will be redirected to a new page with information about why they aren't allowed to get to the site.
* The application report now shows the email address and IP address of the applicant.
* The email sent to the game master(s) from the join form now shows the IP address of the applicant.
* Made the contact form simpler.
* The contact form now uses proper form validation to make sure all the fields are completed properly.
* Department Management now has a new user interface to make working with departments easier.
* Position Management now splits departments out by manifest.
* Users can no longer get to any of the writing features if they don't have a character associated with their account.

### Nova Core

* Added a new validation error image.
* Added a new assignment image.
* Added the jQuery prettyPhoto plugin to replace jQuery Fancybox.
* Removed the jQuery Fancybox plugin.
* Updated to CodeIgniter 1.7.3.
* Updated to jQuery 1.4.4.
* Updated to jQuery UI 1.8.7.
* Updated to jQuery markItUp! 1.1.9.
* The Departments model now has methods for handling multiple manifests.
* The User model now has a method to pull user information based on characters in the database.
* Some of the models needed to be updated to correct for situations where the user or character ID isn't present.

### Bug Fixes

* The autoload config item tried to autoload the Input library. This isn't necessary since CodeIgniter loads it by default.
* Fixed some typos in the install data.
* Users without an active character would be shown in the activity warning panel on the Admin Control Panel.
* A sample post submitted by an applicant would just be a massive block of text in the email sent to the game master(s).
* Some specifications weren't properly upgraded during the SMS Upgrade process.
* A mission closing tag on the Create Characters page was causing some issues.
* The timezone menu in Site Settings pulled the wrong value from the database to populate the field with.
* The join form pulled one of its images from the admin section instead of the main section.
* Whitespace issues in Access Role management, News Item management, Personal Log management, Mission Post management and Department management.
* Fixed the errors thrown throughout the system.
* Some errors were thrown throughout the system when a user didn't have a character associated with their account.
* Flash message view couldn't be overridden with seamless substitution.
* Mission post emails were sent with the user's primary character name attached to it even if the primary character isn't associated with the post.
* Private message emails didn't contain the content of the private message.
* Personal logs didn't have the right date when they were first saved.
* Pending users would appear in the recipients dropdown for private messages.
* Changing a dynamic form field from text/textarea to dropdown wouldn't trigger the dropdown values section to open. This essentially rendered the field useless and would cause admins to have to delete the field and start over.

## 1.1.2 (14 October 2010)

### Nova Core

* Instead of duplicating code, Nova's form helper now extends the dropdown functions.
* When writing or editing a mission post, we now take the author list in to account in the author selection dropdown. (Thanks to Patric for helping with this.)

### Bug Fixes

* Addressed an issue when adding an author when creating or editing a mission post. (Thanks to Patric for this fix.)
* Nova would try to update a user's profile with a field that doesn't exist.
* Under very strange circumstances, Quick Install wouldn't work the way it's supposed to.

## 1.1.1 (27 September 2010)

### Nova Core

* Updated to jQuery UI 1.8.5.
* Updated to jQuery markItUp! 1.1.8.

### Bug Fixes

* The system wouldn't display if the template file couldn't be found (blank white screen).
* The general tour items category would be shown even if there weren't any general tour items.
* Skins with dashboard handles were showing bullets and having weird spacing issues.

## 1.1 (4 September 2010)

* Admins can now create multiple specification items.
* Admins can now associate tour items with a single specification item.
* Users (with proper permissions) can upload specification items through the upload interface.

### Nova Core

* Added the jQuery Fancybox plugin.
* Added the jQuery Reflection plugin and updated the system to use this plugin instead of reflection.js.
* Removed the jQuery Colorbox plugin.
* Removed the reflection.js plugin.
* Updated the jQuery UI to version 1.8.4.
* The specifications model now has new methods for handling specification items.
* Applied some minors updates to the mission groups listing user interface.

### Bug Fixes

* Ordered and unordered lists weren't properly styled in Thresher.
* Missions inside mission groups don't respect the mission order set for them.
* The author dropdown when replying to a private message wasn't populating with data in some cases.
* Mission post next and previous links were wrong under certain circumstances.
* Personal log next and previous links were wrong under certain circumstances.
* News item next and previous links were wrong under certain circumstances.
* The model methods that pulled command staff, game master and webmaster emails returned all users, not just active users.
* Error was thrown about an undefined class method when deleting uploaded items.

## 1.0.6 (14 July 2010)

### Nova Core

* The Character Bio management page shows a loader until everything has finished loading.
* Turned down the debug level (fatal errors and database errors are still shown).
* The recipients menu when writing a private message now separates active and inactive characters.
* Updated to jQuery UI 1.8.2.
* Updated to jQuery Colorbox 1.3.8.
* Removed some debug code from the Auth library since the Remember Me bug seems to have been solved.
* Added a method to the Characters model for inserting promotion records.
* Added a method to the Users model for removing user preference values.
* Addressed a security issue in CodeIgniter's Upload class.

### Bug Fixes

* Error thrown when posting a comment on a mission post.
* Error thrown when attempting to delete a character.
* Error thrown during step 2 of the update process for some admins.
* Error thrown when there's only one mission image set on the mission details page.
* Error thrown when there's only one tour iamge set on the tour details page.
* Error thrown when there's only one character image set on the character bio page.
* Acceptance and rejection messages were sent without any of the changes the admin made.
* Changing a character's status to and from active wouldn't set the open slots of the position(s).
* When creating a character, the position dropdowns showed all positions instead of only open positions.
* Rank history information wasn't being populated correctly.
* Turning off update notification still attempted to run the check.
* A user's email preferences remained active even after the user was deactivated.
* A user's email preferences weren't removed when the user was removed.

## 1.0.5 (06 June 2010)

### Bug Fixes

* Errors thrown after the SMS Upgrade process on Characters management.
* Error thrown after the SMS Upgrade process on NPC management.
* Errors thrown when editing a wiki page.
* Hidden departments were shown in the positions dropdown menu.
* A wrong variable was used in a model method.
* Addressed a security issue where docking request data wasn't filtered for XSS attacks.
* Docking request emails sent to the game master(s) had several bugs.
* Error thrown when updating a user to be inactive.
* There were no sanity checks on the type of variable needed when handling character deactivation.
* Errors thrown when rejecting a docking request.
* Unlinked NPCs wouldn't be able to use newly created bio fields.
* Site Options didn't allow admins with access to the Skin Catalogue to select skins in development.
* Join form instructions weren't displayed.

## 1.0.4 (12 May 2010)

### Nova Core

* The `MY_Input` library tries to filter for Microsoft Word special character a little better.
* The Archives feature now requires PHP 5.0 or higher.
* Thresher now requires PHP 5.0 or higher.
* Updated to jQuery UI 1.8.1.
* UPdated to jQuery markItUp! 1.1.7.

### Bug Fixes

* Error thrown when a user with Level 1 user account access updated their account.
* Saved personal logs could be shown along with activated personal logs for users with multiple characters associated with their account.
* Internet Explorer threw an exception on the Mission Post, Personal Log, News Item and Docked Item management pages.
* Error thrown on the contact page.
* Errors thrown on the Manage Bio page for users with Level 1 access.
* Character position was updated from the Manage Bio page even when they shouldn't be.
* The status change email wasn't populated properly.
* The Textile parser had some bugs. (Thanks to Dustin for catching these issues.)
* Addressed an issue with emails on some servers.
* Attempted to fix some errors thrown in some circumstances during updates.

## 1.0.3 (26 April 2010)

### Nova Core

* Removed the dependency on the versions array file. Instead, we try to pull a listing of the update directory dynamically (though we still use the array file in the the event the directory listing fails).
* Separated some code for character deletion between playing characters and NPCs.
* Added notices to the dynamic form management pages if there's no content available.
* Added some debug code to the Auth library to help track down the Remember Me bug.
* Cleaned up the Posts model.
* Added a parameter to a Post model method to help with issues in with unattented posts.
* When deactivating a user, we deactivate the user's characters at the same time.
* The Update Center to show the links to start the update regardless of whether there's information about the update or not.

### Bug Fixes

* The Create Wiki page link didn't show up in the sub navigation menu.
* Posts weren't accurately counting unattented posts when a character ID was passed in as an integer instead of an array.
* Errors were thrown when deleting characters and NPCs.
* Error was thrown when writing a Mission Post.
* The post notification stayed active even after the post had been updated and/or emailed out.
* Errors thrown when adding a rank.
* Error thrown when there are no fields in a specification form section.
* Error thrown in the Admin Control Panel.
* Wiki pages were being categorized as Uncategorized even if they had categories.
* Error thrown for missing option parameters.
* Error thrown when accepting or rejecting a docked ship application.
* Thresher wasn't using the right regions in the Template config file.

## 1.0.2 (20 April 2010)

### Nova Core

* The Ranks model uses the genre when looking for the default rank catalogue item.
* The Ranks model only pulls ranks sets from the current genre when getting all ranks.
* The Ranks model only pulls rank catalogue items for the current genre.
* The Ranks model `get_group_ranks()` method now has a parameter for a custom identifier.
* The Auth library checks for a user's status and will no longer allow pending users to log in.
* The Auth library will now allow 5 log in attempts before locking the user out.
* Admins can now add and edit the genre for Rank Catalogue items.
* The Upload Management page now shows a message if uploaded images weren't found in specific categories.
* Turned up the debug level so users could see any errors for debugging purposes.
* When a user updates their password and they're set to have Nova remember them, their cookie will be reset with the new password.

### Bug Fixes

* The Menu library wouldn't respect any access control put on main navigation menu items or sub navigation menu items.
* Undefined variable error was thrown in the Rank Catalogue.
* The Rank Catalogue wouldn't work well when multiple genres were installed.
* Uploaded images (besides bio images) couldn't be deleted.
* Authors were dropped off of mission posts because of some flawed logic.
* The sample post wasn't in the email sent to the game master(s).
* Ranks couldn't be added in Internet Explorer.
* Rank classes wouldn't be shown for rank sets without a blank name rank item.
* The user bio pointed to the wrong location for user posts and user awards.
* Listing all of a user's posts would display posts besides their own.
* When commenting on a mission post, an error would be thrown.
* Updating a news item threw a fatal error.
* Updating a personal log threw a fatall error.
* Log in error 6 presentation issues.
* The mission dropdown wasn't properly populated when viewing a saved post.
* Added a special call to the `MY_Input` library to do some text cleanup after filtering for XSS.
* News items could be posted without a category.
* There were some minor schema differences between SMS and Nova created by the SMS Upgrade process.
* Addressed some of the Remember Me lockout issues.

## 1.0.1 (16 April 2010)

* A database field wasn't properly added during the SMS Upgrade process.
* Models couldn't be autoloaded because `Base4.php` didn't extend `My_Loader`.
* An error was thrown because the `date_default_timezone_set` function doesn't exist in PHP before version 5.1.

## 1.0 (15 April 2010)

* Initial release