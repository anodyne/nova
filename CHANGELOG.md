# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/).

## [Unreleased]

### Added

- [HTML Purifier](http://htmlpurifier.org/) package

### Changed

- Removed XSS filtering from content fields
- `text_output` helper will now run content through HTML Purifier to address potential XSS attacks

## [2.7.5] - 2023-05-23

### Added

- Page to generate updated colors for the new Pulsar and Titan skins.
- Tailwind utilities module. This is intended to allow existing skins to add CSS utility classes to their skin in a non-breaking fashion. More details are available in the docs.
- System setting to disable the contact form.
- `flash_contact_form_off_disabled` language key.
- `labels_contact_enabled` language key.

### Changed

- New version check and registration URLs.
- Titan's workflow icons (upper right corner) had their color changed to match the color scheme better.
- Pulsar workflow icons (upper right corner) were changed to match Titan's icons.
- Database configuration file stub now includes the database port.
- Updated the `upd_step2_title` language item.
- Updated the `upd_step2_success` language item.
- Mission post fields have been updated with additional CSS classes: title (`w-1/2`), tags (`w-1/2`), timeline (`w-1/2`), location (`w-1/2`), content (`w-full`), status (`w-1/4` - management mode only).
- Personal log fields have been updated with additional CSS classes: title (`w-1/2`), tags (`w-1/2`), timeline (`w-1/2`), location (`w-1/2`), content (`w-full`), status (`w-1/4` - management mode only).
- News item fields have been updated with additional CSS classes: title (`w-1/2`), tags (`w-1/2`), newscat (`w-1/4`), private (`w-1/4`), content (`w-full`), status (`w-1/4` - management mode only).
- Private message compose fields have been updated with additional CSS classes: subject (`w-1/2`), content (`w-full`).
- Contact form fields have been updated with additional CSS classes: name (`w-1/2`), email (`w-1/2`), subject (`w-1/2`), message (`w-full`).
- The contact form message (configurable in Site Messages) will always be shown on the contact form, even if system email is off or the contact form has been disabled.
- Sub navigation items now include a class to indicate whether they're the actively viewed page or not.

### Removed

- Database backup attempt before running an update.
- Resetting every user record's `is_firstlaunch` flag. This is not used anywhere.

### Fixed

- Errors while checking for a new version of Nova in certain circumstances.
- Incorrect method of checking for the latest version of Nova in the Update Center.
- Missing information caused the `nullable` field updates in 2.7.4 to silently fail.
- Ranks management displayed sets and classes vertically instead of horizontally.
- Errors about incorrect return types from inside extensions.
- Extension controllers not working.
- Personnel main navigation item hides when show/hiding certain types of characters on the manifest.

### Security

- Updated Composer dependencies to address CVE-2022-24894: Prevent storing cookie headers in HttpCache.
- Updated Composer dependencies to address CVE-2023-29197: Improper header validation.

## [2.7.4] - 2023-01-27

### Changed

- Updated all fields marked as `nullable` in the install process as `nullable` in the update process.
- Better support for PHP 8.2.
- Analytics will properly report initial install date during the update process.
- Version checking uses an API endpoint on the Anodyne servers instead of parsing a YAML file.
- The response from the version check will be cached for 24 hours.

### Fixed

- Could not delete any site messages.

## [2.7.3] - 2023-01-07

### Added

- `update_read_guide` language key.

### Changed

- Updated Nova license to include 2023.
- Install and update processes will now report analytics back to Anodyne.
- In the production environment, Nova will only log errors and follow best practices for displaying errors and what it reports for logging.
- In the development environment, Nova will be more verbose in its logging.
- Update notifications have a better UI.
- Future update notifications will link to the update guide on the documentation site.

### Removed

- Testing environment code. (This mirrored what is used for the production environment and was unnecessary.)

### Fixed

- Some games running the BLANK genre were not able to get to their site after successfully updating.

## [2.7.2] - 2023-01-01

### Changed

- Minimum PHP version requirement has been raised from 7.0 to 7.4.
- Upgraded Swiftmailer to version 6.3.
- PHP's built-in `mail()` function can no longer be used with Swiftmailer. When using the `mail` protocol, Sendmail will be used instead.
- Moved the errors directory from `application/views` into the Nova core.
- Made the 2.4.10 update file idempotent to avoid duplicate data issues.
- When uploading images, if the target directory doesn't exist, it will attempt to create the directory.

### Fixed

- Missing background image from jQuery UI library on the admin control panel in the Pulsar skin.
- Missing background image from jQuery UI library on the admin control panel in the Titan skin.
- Footer appears twice in the main section of Titan skin.
- Missing folders in the zip files (this only impacts fresh installs).
- Running the updater multiple times results in the version number being set to 2.5.
- Upload Image page didn't display information from the upload config file correctly.

## [2.7.1] - 2022-12-04

### Fixed

- Misconfigured base URL would redirect users to an external domain during the update process.

## [2.7.0] - 2022-12-02

### Added

- Word counts for mission posts and personal logs.
- Word count display below mission post and personal log content text areas. (Note: due the differences between how Javascript calculates words and how PHP calculates words, there may be slight differences between the count displayed and what is stored in the database.)
- Word count display and reading time shown when viewing a mission post or personal log.
- Contact page "honeypot" for attempting to limit spam.
- `actions_cancel` language key.
- `misc_rss_feed` language key.
- `word_count_with_read_time` language key.
- New versions of the `include_head` files (all suffixed with `_next`). This allowed us to fix some significant issues with jQuery bugs by removing some code. Existing skins will continue to work as expected, but the Pulsar and Titan skins now use the newer versions.

### Changed

- Upgraded CodeIgniter from version 2.2.3 to version 3.1.13 for better PHP 8 compatibility.
- Minimum PHP version requirement has been raised from 5.3 to 7.0.
- Minimum Internet Explorer requirement has been raised from version 7 to version 11.
- The System Information and Version History page now displays the server's version of PHP.
- Reorganized the Sim Statistics report to include word count stats in most categories.
- Updated the Sim Statistics report to include lifetime totals for word counts.
- Renamed the departments database table from `departments_{genre}` to `departments`.
- Renamed the positions database table from `positions_{genre}` to `positions`.
- Renamed the ranks database table from `ranks_{genre}` to `ranks`.
- Redesigned the special messages page for maintenance mode, PHP version issues, ban notice, and browser updates.
- Logging in and logging out will no longer force users to sit on a waiting screen for 5 seconds before redirecting.
- HTML markup around several field labels in Site Settings have been updated. This mainly involves wrapping several labels in `span` tags and should not impact any existing skins.
- A `span` tag has been added around the label and page name on the Manage Wiki Pages screen.
- A `span` tag has been added around the text inside the Show Filters link in the wiki screens.
- A `span` tag has been added around the text inside the sub navigation links in the wiki screens.
- The Edit Categories link on the wiki/categories page has been given the `edit` class to be consistent with other similar edit links.
- The `versions_redirect` language item now links to the Nova 2 source code repository changelog instead of Anodyne Help.
- Provided a link to manage uploads directly from the upload screen.
- The `ui-datepicker-trigger` styling has been moved out of the Javascript files and into the stylesheets. If you are overriding the `mange_missions_js.php` file, your changes will remain intact. If you're using the Pulsar or Titan skins, you will get the new styling. If you are using a custom skin, you will need to copy the styling from `application/views/default/dist/css/app.css` for `.ui-datepicker-trigger` and move it into your own skin.
- For the word counter used when writing different types of posts, we've added a new `counter` class. Everything will display correctly without this class, but you can use it in your own skins to control the distance from the content textarea.
- New classes `pill-container`, `pill-inline-container`, and `pill` have been added to the HTML in several places. Everything will display correctly without these classes in your skin stylesheets, but you can use them in your own skins to control the look of "pill" elements. This is in use in the follow pages now: main/news, main/viewnews, personnel/index, manage/positions.
- New class `large` targeting inputs and selects has been added. Everything will display correct without this class in your skin stylesheets, but you can use it to control the size of text inputs and select menus that should be wider.
- The RSS feed links when viewing a post, log, or news item now have a text label to make them more visible.
- Added some `autocomplete` attributes to email and password fields on the login, reset password, and join forms.
- The wiki page content wrapping element has been changed from a `p` tag to a `div` and given a class of `prose` (this applies to both published and draft pages). This allows for the removal of overly greedy CSS selectors in the `include_head_wiki_next` file and moving those styles into the `wiki.css` file in the Pulsar and Titan skins. Existing skins will continue to work as expected.
- The manage positions departments wrapping element has been changed from a `p` tag to a `div` and given an additional class of `pill-container` (see above for pill changes).
- Updated some casings of different labels throughout the system.

### Removed

- The ability to install a separate genre from the Installation Center.
- The System Components section of the System Information & Version History page. There was in fact no such information in Anodyne Help.

### Fixed

- Wrong character name was displayed in email clients when sending the email to players after a pending post is approved ([#295](https://github.com/anodyne/nova/issues/295))
- Creating a mission without a start or end date does not give good error messages ([#296](https://github.com/anodyne/nova/issues/296))
- Missing email field placeholder on the reset password page.
- The blank genre will now use `blank` for the genre code instead of previous uses of `bln` and `blk` (impacts fresh installs only).
- Tags were displaying on the view news page even when there weren't any tags specified.
- The search field in the Active Users tab of the Posting Levels report was above the header. It's been moved to be below the header to be consistent with the other tabs on the page.
- Removed extra closing `div` tag on the site/simtypes page that resulted in broken layouts.
- Date fields cut off the text when managing missions.
- Mission field cut off the text when managing mission posts.

## [2.6.2] - 2021-07-08

### Security

- Patched an issue where a user's password could be exposed.

## [2.6.1] - 2019-04-05

### Fixed

- Fixed issues with `location.view.output` event listener.

## [2.6.0] - 2019-04-03

### Added

- Added an events system. This system is experimental and offered as a purely beta feature for developers to use for the remainder of Nova 2's life.
- Added an extensions system. This system is experimental and offered as a purely beta feature for developers to use for the remainder of Nova 2's life.

### Changed

- Updated the character bio form with a heading above the position and rank fields.
- Updated the mission management pages to provide proper spacing for mission descriptions longer than 1 paragraph.
- Updated the positioning of the submit button on the character bio form for better semantics.
- Updated the margins for lists in the wiki section to be more consistent with the rest of the application.

## [2.5.1] - 2018-06-05

### Fixed

- Fixed an issue where the new settings added for privacy policies didn't work on fresh installs.

## [2.5.0] - 2018-05-25

### Added

- Nova is now GDPR compliant.
- Added the ability for a user to remove their own account. (Thanks to Jon Matterson for his work on this.)
- Added a privacy policy page.
- 4 privacy policies as site messages for users to use and modify easily. (Thanks to Bravo Fleet and Jon Matterson for their work on these policies.)

### Changed

- Update Site Bans to default to a level 1 ban if no level is selected.
- Update Site Bans to use the current timestamp when a ban is created.
- Update the database driver to MySQLi by default. (This will only apply to new installations.)
- Update Nova with PHP 7 support. (Thanks to Williams for his work on this.)
- Display private message search results (Thanks to Williams for his work on this.)

## [2.4.10] - 2017-06-23

### Changed

- Update character approval pop-up to prevent accidentally setting new users as system administrators.
- Update Mail class to allow for SSL or TLS over SMTP.
- Update posting flow to prevent unnecessary locking when saving a mission post

## [2.4.9] - 2017-03-08

### Fixed

- Fixed an issue where the installer would throw an error on certain server setups.

## [2.4.8] - 2017-01-25

### Changed

- Updated the Nova database to allow for mission posts, personal logs, and news items of more than 65,000 characters.
- Updated the behavior of replying to a private message from your own sent messages. Previously, it would reply to yourself, but now will reply to the original recipient. (Thanks to Williams for this update!)
- Updated how Nova handles incrementing the version number in hopes of mitigating the "0.0.0" database version issue.

## [2.4.7] - 2017-01-07

### Changed

- The saved post links in the Writing Control Panel have been updated to favor the "view" mode instead of "edit" mode. This should prevent posts from being unnecessarily locked when users are just trying to read saved posts.
- The post, log, and news posting pages have been updated with back buttons to make navigation easier.

## [2.4.6] - 2016-08-28

### Changed

- We've updated the gender identification selections on new installations to be more in line with social conventions. Hermaphrodite has been replaced with Transgendered/Intersex and Neuter has been replaced with Agendered/Non-Binary.

### Fixed

- We've made some changes to the email class in the hopes of reducing the number of errors people are starting to see.
- Addressed an error with assigning departments to a manifest.

## [2.4.5] - 2015-11-14

### Changed

- Addressed potential issue for users who are running MySQL with strict SQL mode. This would oftentimes result in a cryptic "1364 error" during installation or update, but it could also occur in other areas of the system. Thanks to Jon Matterson for his work on this issue!
- Update the new Mail class with attempts to validate the email addresses. If they're empty or not valid email address, they'll be stripped out of the recipient list.

### Fixed

- Fixed an issue where a user could update their character without a name. Either the first or last name is now required to update the character.

## [2.4.4] - 2015-09-04

### Changed

- Updated Nova to indicate when anything less than PHP 5.3 is on the server. Due to changes in Nova 2.4, there is now a requirement of PHP 5.3.

### Fixed

- Fixed wrong link to the Inbox from Sent Messages.

## [2.4.3] - 2015-08-11

### Added

- Added indicator when viewing a post, log, or news items if it's a saved or pending item.

### Fixed

- Fixed issues with viewing non-activated posts, logs, and news items.

## [2.4.2] - 2015-08-08

### Fixed

- Fixed errors when sending emails to multiple recipients.

## [2.4.1] - 2015-08-07

### Fixed

- Fixed error thrown with missing method that was removed in the latest version of CodeIgniter 2.

## [2.4.0] - 2015-08-07

### Added

- Created a new `Mail` wrapper class around SwiftMailer for better email handling than CodeIgniter's built-in email class. Thanks to forum user TheDrew for helping us sort through some of these issues.
- Added a notice to the bottom of all emails that it's an automated email and they shouldn't reply to the message.

### Changed

- Updated the controllers with the new Mail class calls.
- Updated the manifest Javascript to remove hard-coded calls to a table structure. This has become problematic as people have begun to modify the manifest to have less traditional layouts.
- Updated the error language file with a new error message.

### Removed

- We've removed all the reply-to calls with emails since more and more spam filters are checking the reply-to headers as well as the from header.

### Fixed

- When there is no manifest metadata, an extra space is displayed.
- Fixed issue where users could view pending and saved mission posts, personal logs, and news items from their respective view pages.

## [2.3.2] - 2014-05-10

### Changed

- Updated the email from the contact form and the email to the GM from the docking form to include recipient information. Despite the name and email address are in the headers, we're including those as well as the sender's IP address.
- Updated the included head files to allow for using Nova on a secure domain.

### Fixed

- Fixed wrong language key being used for the word "sim" in a couple of places.

## [2.3.1] - 2014-02-02

### Fixed

- When toggling open positions, any open positions in sub-departments would throw off the display of the entire manifest.

## [2.3.0] - 2013-09-14

### Added

- Admins can now add inline help for any dynamic form field to help users filling the forms out. The content will be shown below the label and above the field.
- Nova now shows a link back to All Characters when editing a character (if the user has permission).
- Nova now shows a link back to All Users when editing a user (if the user has permission).
- Admins can now specify additional metadata from the bio form to be dispalyed under the character name on the manifest (such as species, gender or any other field).
- Sim stats now shows some statistics for the total life of the sim.

### Changed

- When displaying the output of a dynamic form, if there's nothing in the field, we no longer show it.

### Fixed

- If a character didn't have any posts, their bio would display the start of UNIX time instead of nothing.

## [2.2.3] - 2013-04-07

### Fixed

- Some users have reported errors being thrown during the update process that prevent them from moving up to newer versions of Nova. We've attempted to create a fix for this, but since we haven't been able to recreate the issue, this may or may not work.

## [2.2.2] - 2013-03-27

### Fixed

- Fixed error thrown when managing NPCs. (Thanks to evshell18 for the fix and pull request.)
- Fixed issue where users without `wiki/categories` permissions couldn't create or edit wiki pages. ([#239](https://github.com/anodyne/nova/issues/239))

## [2.2.1] - 2013-03-09

### Changed

- Updated the jQuery prettyPhoto plugin to version 3.1.5.

### Fixed

- Fixed update message always displaying because of a wrong version number in the core.

## [2.2.0] - 2013-02-15

### Added

- Added reply to header to most of the emails that are sent from Nova. ([#217](https://github.com/anodyne/nova/issues/217))

### Changed

- Update author listings to provide links to each character's bio page. Thanks to Jordan Jay for his MOD to do this. We've expanded on his idea to provide this functionality for mission posts, personal logs, news items, wiki pages and comments. ([#223](https://github.com/anodyne/nova/issues/223))
- Updated the characters model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
- Updated the docking model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
- Updated the specs model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
- Updated the tour model to allow retrieving specific field information by ID or field_name. ([#216](https://github.com/anodyne/nova/issues/216))
- Updated copyright dates in source code. ([#224](https://github.com/anodyne/nova/issues/224))

### Removed

- Removed the SMS Archive feature since it's no longer needed.

### Fixed

- When viewing a mission post that doesn't exist, Nova throws a fatal error. ([#233](https://github.com/anodyne/nova/issues/233))
- When using the tour form, Nova throws an error.
- Sub-department names and descriptions weren't displayed properly when managing positions. ([#232](https://github.com/anodyne/nova/issues/232))
- A missing closing tag on the character bio management page caused display problems.
- When upgrading from SMS, system administrators didn't have the proper flags set.
- When using the personal logs RSS feed, the link to the entry went to the view post page, not the view log page. ([#234](https://github.com/anodyne/nova/issues/234))

## [2.1.3] - 2012-11-05

### Fixed

- Restoring lost functionality on some pages due to the security vulnerability update. ([#215](https://github.com/anodyne/nova/issues/215))

## [2.1.2] - 2012-11-04

### Changed

- Update to jQuery 1.8.2.
- Update to jQuery UI 1.8.24.
- Update to markItUp! 1.1.13.
- Update to CodeIgniter 2.1.3.
- Update Nova to address a security issue.

### Fixed

- Once a bio field is turned off, the only way to turn it back on is by going in to the database and changing the display value. ([#214](https://github.com/anodyne/nova/issues/214))
- Once a docking field is turned off, the only way to turn it back on is by going in to the database and changing the display value. ([#214](https://github.com/anodyne/nova/issues/214))
- Any spec form field that is turned off has no indication that it's disabled.
- Any tour form field that is turned off has no indication that it's disabled.

## [2.1.1] 2012-09-12

### Changed

- Update to CodeIgniter 2.1.2.
- Update to jQuery 1.8.1.
- Update to jQuery UI 1.8.23.
- Update the IP Address fields in the database to be compatible with IPv6 addresses.

### Fixed

- During the update process, Nova never updated the system information table with the correct version number.
- Despite the system version and components database tables being pulled out, the What's New menu item was never removed, throwing a 404 error if someone tried to go to the page.
- The Admin Control Panel's update notification panel doesn't properly display all the language strings because the proper language file wasn't loaded.
- The user bio page had debug code from 2.1 development at the top of the page.
- Under some circumstances, unlinked NPCs had a link to a user bio that threw an error.
- The User Not Found error was missing a parameter (would show %s instead of the word 'user').

## [2.1.0] - 2012-06-26

### Added

- Users are now notified when mission notes have been updated in the last 72 hours by the notes box auto-expanding when they arrive at the posting page.
- Users are now shown when the last update to the mission notes was all the time.

### Changed

- Update the Version Information page to reflect the database changes.
- Update the post, log, and news creation pages to give a description of what tags are meant to be used for.
- Update to jQuery UI 1.8.20 (we now include the entire jQuery UI library for anyone who wants to use components we don't use).
- Update to prettyPhoto 3.1.4.
- Update to jQuery Reflection 1.1.

### Removed

- Remove the `count_unread_pms` method from the private messages model. (This method was deprecated in Nova 2.0.)
- Remove the `system_components` and `system_versions` tables from the database. There's really no reason to be maintaining these lists in Nova. Instead, users who are interested in Nova's components and version history should visit AnodyneDocs.
- Remove the What's New page for the reasons specified above.
- Remove jQuery library from the file system. We now pull jQuery from a CDN instead of storing it locally.

### Fixed

- The update page would always throw an error that it couldn't find Nova installed in the current database.
- When a mission was updated, it was assumed mission notes updated as well. Now, there's greater precision in determining if the notes were actually updated.
- Accepting or rejecting docking applications would throw a fatal error because the Messages model wasn't loaded before it was used.
- Join timespan always showed as a user joining "1 Second ago" no matter when they joined.
- Nova's `timespan_short` helper was missing the word "ago" when the time was less than an hour.
- The Site Messages page didn't strip HTML tags from the content potentially allowing unclosed HTML tags to wreak havoc on the page.

## [2.0.3] - 2012-03-01

### Changed

- Updated jQuery UI to version 1.8.18.

### Fixed

- Benchmarking psuedo-variables are not handled properly because of the fact the Template library doesn't not use the Output library for sending content to the browser.
- When saving posts with the Post Participants feature turned off, Nova would throw errors about a database field not accepting NULL values.

## [2.0.2] - 2012-02-09

### Added

- Added some code to try and make the mission post locking auto-release a little smarter.

### Removed

- Removed the social interaction tools from prettyPhoto image modals. ([#169](https://github.com/anodyne/nova/issues/169))

### Fixed

- Under some (strange) circumstances, Nova could throw errors from the Ajax controller.
- A typo in the language string on the reset password page when the security question you select doesn't match what's in the database.
- If a user has multiple playing characters assigned to them, the milestones listing would display their main character name for every playing character they had assigned to them instead of just displaying it once.
- The new manifest layout has some display issues when using sub departments. ([#168](https://github.com/anodyne/nova/issues/168))
- When updating the content of a deck, the submit process went back to the select screen instead of staying on the current item's page.
- When deleting specification items, if there are decks associated with that spec item, they're orphaned and not deleted.
- The Who's Online listing displayed random spaces and commas.
- Character image galleries duplicated the primary image.

## [2.0.1] - 2012-02-04

### Fixed

- If the user's screen isn't wide enough, the tooltip on the Writing Control Panel that displays the post lock information can slide partially out of view.
- Nova tried to load a language file through an object that couldn't see it, resulting in an error thrown about the file not being found.

## [2.0.0] 2012-02-04

### Changed

- Site Messages can now contain previously disallowed HTML tags (like `embed`, `iframe`, etc) for adding media from YouTube and Vimeo to site messages (like the welcome message) without needing to use seamless substitution.
- Mission groups can now be added inside other mission groups (nesting only allowed one level deep).
- Users with Level 2 user admin access rights can now reset someone's password for them. The new password will be generated and emailed to the user and they'll be prompted to reset the password the next time they log in. At no time does the user with Level 2 user admin access rights see what the newly generated password is. ([#16](https://github.com/anodyne/nova/issues/16))
- Multi-author posts are now locked during editing to prevent users editing the same post at the same time. The lock is released after the user saves their changes or they've gone 5 minutes without making a change. (In the event a user has changed something and walked away, their changes will be saved to the post first.)
- Admins now have the option of showing the latest personal logs and mission posts on the main page. (Admins will be able to select any combination of news, logs and posts.)
- Admins now have the option of setting the top open positions (from Position Management) that will be shown at the top of each manifest (not manifest-specific).
- Added a rules page to the main section that can be updated from the Site Messages page.
- The instructions on the upload page now include the maximum file size and maximum image dimensions (pulled from the upload config file) for reference to anyone uploading images. ([#143](https://github.com/anodyne/nova/issues/143))
- The deck listing page now uses a table-less layout for a cleaner look.
- The deck listing page now has a menu of decks at the top of the page for quickly moving to a deck item without having to scroll. (We think RPGs with a lot of decks are going to love this!)
- Overhauled the user interface for mission groups to provide more information (and look a lot better too).
- When composing a mission post, the dropdown will now show who owns a linked NPC.
- When composing a mission post, personal log or private message, users only have to start typing a name and the options will be narrowed down for them. ([#23](https://github.com/anodyne/nova/issues/23))
- The skin catalogue now allows removing an entire skin (with sections) and letting admins choose which skin users will beupdated to for each section.
- The user account page now has options to make activating and deactivating users a lot easier.
  - When deactivating a user, all active characters associated with that account with also be deactivated.
  - When activating a user, admins will be prompted about which of the user's inactive characters should be reactivated.
- The character bio page now has options to make activating and deactivating characters a lot easier.
  - Activating an inactive character (and all related actions) can now be done with the push of a button.
  - Deactivating an active character (and all related actions) can now be done with the push of a button.
  - Making an NPC an active character (and all related actions) can now be done with the push of a button.
  - Making a character an NPC (and all related actions) can now be done with the push of a button.
- When viewing a character's posts, the entries will be paginated to help with load times and usability.
- When viewing a character's logs, the entries will be paginated to help with load times and usability.
- Site manifests can now store default view information so that different manifests can have different view settings. (This is now handled through Site Manifest management instead of Site Settings.) ([#157](https://github.com/anodyne/nova/issues/157))
- Gave the Pulsar skin a refreshed look and feel.
- Gave the Titan skin a refreshed look and feel. (If you're interested in changing the header image, please see Titan's README.md file for instructions.)
- The Writing Control Panel now shows a notification for any entires that have been commented on in the last 30 days (along with a link to the comments section of the entry).
- The manifest has been reorganized (for the first time ever) with a slightly different look.
- The email sent to the game master when a user applies now goes to anyone who can approve or reject character applications.
- Acceptance and rejection emails now CC in anyone who can approve or reject character applications.
- Users can now search within their sent and received private messages.
- Private messages have now been split in to separate inbox and sent message pages. This will help improve performance since the page doesn't have to load all the messages at once then split them off in to tabs.
- Private messages in the inbox and sent messages list are now paginated.
- The Reply to All link when reading a private message is only displayed if there's more than one recipient.
- The Reply, Reply to All and Forward options when reading a private message are now displayed above and below the private message.
- Users can now mark all unread private messages as read with a single click.
- An all-new redesigned character bio page provides a better, cleaner user experience.
- Moved to CodeIgniter 2.1 (was previously 1.7.3).
- Moved to a brand new file structure that further removes the Nova Core from any changes an admin might be making.
- Added **experimental** module support.
- Updated to jQuery 1.7.1.
- Updated to jQuery UI 1.8.17.
- Updated to jQuery Uniform 1.7.5.
- Updated to jQuery prettyPhoto 3.1.3.
- Updated to markItUp! 1.1.12.
- Added the jQuery Chosen plugin.
- Added the Bootstrap by Twitter Twipsy plugin (version 1.4).
- Added the Bootstrap by Twitter Popover plugin (version 1.4).
- Removed the qTip plugin. (Please use the Bootstrap Twipsy plugin instead.)
- Changed the `banned.php` file to `message.php` that now contains notifications of Level 2 bans, a missing `nova` directory and incompatible PHP version information.
- Seamless substitution can now be used to override email view files from the `_base_override` directory.
- Added seaQuest DSV as a genre option. ([#144](https://github.com/anodyne/nova/issues/144))
- Changed the Location helper into a library with static methods (`Location::view` instead of `view_location`).
- Removed the RSS model. (It isn't necessary since most of the calls were duplicated in the appropriate post type models.)
- Added constants to the Access model for the default access roles.
- The Missions model now allows group missions to be pulled from `get_all_missions()`.
- The Missions model now has a method to count mission groups: `count_mission_groups()`.
- The Users model now has a method to pull all of a user's LOA records: `get_user_loa_records()`.
- The Auth library now uses static methods to be able to call quicker (`Auth::check_access()` instead of `$this->auth->check_access()`).
- Nova will always check for the existence of the database config file. If the file isn't found, Nova will enter a new config setup wizard that will walk admins through setting up the config file, test the connection and then write the file for them.
- The SMS Upgrade process will now migrate SMS Database entries to the Thresher wiki page format.
- Completely re-wrote the upgrade process to not use config files (admins select the components they want upgraded through a user interface), to show more useful validation messages and be a shorter, more pleasant process (reduced the number of steps from 14 to 4).
- View files now check for the existence of the BASEPATH constant before rendering. On some servers, random `error_log` files are generated all over the place. A big part of this is view files that are accessed apart from the framework and generate PHP fatal errors. This fix should help eliminate those error log files.
- In preparation for future deprecation, we've removed all references to jQuery's `.live()` method. Third party developers should ensure their own code is updated as soon as possible to avoid any issues once the method is removed from the jQuery core.
- Changed the way users manage categories when creating and editing a wiki page. ([#137](https://github.com/anodyne/nova/issues/137))
- Users with the proper permissions can now create categories when creating and editing a wiki page. ([#64](https://github.com/anodyne/nova/issues/64))
- If there are no categories set in Thresher and the user has the proper permissions, they will be prompted to create some new categories when creating and editing a wiki page.
- Changed the user experience for managing wiki pages that puts more controls at the user's disposal and simplifies the entire page. ([#141](https://github.com/anodyne/nova/issues/141))
- Changed the user interface for viewing wiki pages to make it simpler.
- Users must have Level 1 wiki page access to see the page history now.
- Only users who are logged in can see comments on a wiki page.
- Added system pages to Thresher that allow some of the system pages to have their content changed like a normal wiki page. ([#123](https://github.com/anodyne/nova/issues/123))
- Users can now search Thresher from the main Thresher page.
- Fixed several bugs with the listing of Thresher search results.
- Removed the recently changed and recently updated listings from the main Thresher page.
- Users can now subscribe to an RSS feed for created wiki pages as well as updated wiki pages.
- Admins can now restrict access to a wiki page based on access role. ([#11](https://github.com/anodyne/nova/issues/11), [#12](https://github.com/anodyne/nova/issues/12))

### Fixed

- Seamless substitution of images wouldn't work when the images were in the `_base_override` directory.
- The `RE:` and `FWD:` tags would be added to private message subjects when replying and forwarding indefinitely until there was no space left for the actual subject line. Now, Nova will make sure it's only added once. ([#158](https://github.com/anodyne/nova/issues/158))
- When replying to a private message, the author of the message would be added to the recipient list, so any message they send would also show up in their inbox as well. (This behavior can be duplicated by manually adding themselves to the recipients list.)
- The join form could be submitted without an email address or password.
- Users who were deactivated kept their account flags (system administrator, game master, webmaster) and their access role. Now, all account flags and access roles are changed on deactivation.
- Users who were reactivated didn't have their access role set to Standard User.
- Inactive users were shown a link in the sub-navigation to upload an image even though they don't have permissions to upload images.
- A password could be reset for a user even if they don't have a security question chosen.
- Patched several potential security and access issues.
- Positions weren't properly updated when deleting an active character.
- Pulsar styling issues in Internet Explorer 9.
- Titan styling issues in Internet Explorer 9.
- When viewing character or user award, the "Nominated By" line was shown even if there was no nomineed. (This is only an issue for RPGs who upgraded from SMS.)
- The Enterprise-era (ENT) genre install file had several issues and typos. ([#155](https://github.com/anodyne/nova/issues/155))
- The database automatically set a default rank for pending users potentially resulting in some confusion as to why a pending user already has a rank. ([#148](https://github.com/anodyne/nova/issues/148))
- If there is only one specification item, the list of items would be dispalyed instead of automatically sending the user to the only specification item. ([#146](https://github.com/anodyne/nova/issues/146))
- If there is only one specification item, the list of decks would be dispalyed instead of automatically sending the user to the only deck listing. ([#147](https://github.com/anodyne/nova/issues/147))
- During fresh installs, the user ID constraint wasn't consistent with the rest of the user ID fields throughout the system.
- Under some circumstances, users could edit posts they weren't even a part of. (Thanks to evshell18 on the Anodyne forums for pointing this out and getting the ball rolling on a fix.)

## [1.2.6] - 2011-07-15

### Fixed

- The Writing Control Panel included several wrong links.
- Character mission posts weren't accurately pulled from the database.

### Security

- Addressed some major security issues.

## [1.2.5] - 2011-06-16

### Fixed

- Specification data wouldn't get added to the database table for old items if a new field was added.
- Deactivated users would retain their account flags (system administrator, game master, webmaster) and wouldn't have their access role changed.
- Reactivated users wouldn't be given a reasonable access role.

## [1.2.4] - 2011-01-25

### Changed

- Updated to jQuery UI 1.8.9.

### Fixed

- Mission posts weren't accurately counted.
- The user acceptance email CCed in more people that needed to be.
- The manifest wouldn't load in Internet Explorer 7.

## [1.2.3] - 2011-01-04

### Fixed

- Addressed issues handling deck listings and multiple specification items.

## [1.2.2] - 2010-12-30

### Fixed

- Sub departments couldn't be managed from the Department management page.
- Mission post emails didn't display the authors properly.
- Addressed access issues created by the update from 1.1.2.

## [1.2.1] - 2010-12-23

### Fixed

- Positions would disappeaer when being updated.
- Errors thrown when trying to update character images when there aren't any images present.
- Error thrown from the RSS feed.

## [1.2.0] - 2010-12-20

### Added

- Added a new validation error image.
- Added a new assignment image.
- Added the jQuery prettyPhoto plugin to replace jQuery Fancybox.

### Changed

- Admins can now ban users from applying to the game (level 1) or even getting in to the site (level 2)
- If the system detects a Level 2 ban, the user will be redirected to a new page with information about why they aren't allowed to get to the site.
- The application report now shows the email address and IP address of the applicant.
- The email sent to the game master(s) from the join form now shows the IP address of the applicant.
- Made the contact form simpler.
- The contact form now uses proper form validation to make sure all the fields are completed properly.
- Department Management now has a new user interface to make working with departments easier.
- Position Management now splits departments out by manifest.
- Users can no longer get to any of the writing features if they don't have a character associated with their account.
- Updated to CodeIgniter 1.7.3.
- Updated to jQuery 1.4.4.
- Updated to jQuery UI 1.8.7.
- Updated to jQuery markItUp! 1.1.9.
- The Departments model now has methods for handling multiple manifests.
- The User model now has a method to pull user information based on characters in the database.
- Some of the models needed to be updated to correct for situations where the user or character ID isn't present.

### Removed

- Removed the jQuery Fancybox plugin.

### Fixed

- The autoload config item tried to autoload the Input library. This isn't necessary since CodeIgniter loads it by default.
- Fixed some typos in the install data.
- Users without an active character would be shown in the activity warning panel on the Admin Control Panel.
- A sample post submitted by an applicant would just be a massive block of text in the email sent to the game master(s).
- Some specifications weren't properly upgraded during the SMS Upgrade process.
- A mission closing tag on the Create Characters page was causing some issues.
- The timezone menu in Site Settings pulled the wrong value from the database to populate the field with.
- The join form pulled one of its images from the admin section instead of the main section.
- Whitespace issues in Access Role management, News Item management, Personal Log management, Mission Post management and Department management.
- Fixed the errors thrown throughout the system.
- Some errors were thrown throughout the system when a user didn't have a character associated with their account.
- Flash message view couldn't be overridden with seamless substitution.
- Mission post emails were sent with the user's primary character name attached to it even if the primary character isn't associated with the post.
- Private message emails didn't contain the content of the private message.
- Personal logs didn't have the right date when they were first saved.
- Pending users would appear in the recipients dropdown for private messages.
- Changing a dynamic form field from text/textarea to dropdown wouldn't trigger the dropdown values section to open. This essentially rendered the field useless and would cause admins to have to delete the field and start over.

## [1.1.2] - 2010-10-14

### Changed

- Instead of duplicating code, Nova's form helper now extends the dropdown functions.
- When writing or editing a mission post, we now take the author list in to account in the author selection dropdown. (Thanks to Patric for helping with this.)

### Fixed

- Addressed an issue when adding an author when creating or editing a mission post. (Thanks to Patric for this fix.)
- Nova would try to update a user's profile with a field that doesn't exist.
- Under very strange circumstances, Quick Install wouldn't work the way it's supposed to.

## [1.1.1] - 2010-09-27

### Changed

- Updated to jQuery UI 1.8.5.
- Updated to jQuery markItUp! 1.1.8.

### Fixed

- The system wouldn't display if the template file couldn't be found (blank white screen).
- The general tour items category would be shown even if there weren't any general tour items.
- Skins with dashboard handles were showing bullets and having weird spacing issues.

## [1.1.0] - 2010-09-04

### Added

- Admins can create multiple specification items.
- Admins can associate tour items with a single specification item.
- Users (with proper permissions) can upload specification items through the upload interface.

### Changed

- Added the jQuery Fancybox plugin.
- Added the jQuery Reflection plugin and updated the system to use this plugin instead of reflection.js.
- Updated the jQuery UI to version 1.8.4.
- The specifications model now has new methods for handling specification items.
- Applied some minors updates to the mission groups listing user interface.

### Removed

- Removed the jQuery Colorbox plugin.
- Removed the reflection.js plugin.

### Fixed

- Ordered and unordered lists weren't properly styled in Thresher.
- Missions inside mission groups don't respect the mission order set for them.
- The author dropdown when replying to a private message wasn't populating with data in some cases.
- Mission post next and previous links were wrong under certain circumstances.
- Personal log next and previous links were wrong under certain circumstances.
- News item next and previous links were wrong under certain circumstances.
- The model methods that pulled command staff, game master and webmaster emails returned all users, not just active users.
- Error was thrown about an undefined class method when deleting uploaded items.

## [1.0.6] - 2010-07-14

### Fixed

- The Character Bio management page shows a loader until everything has finished loading.
- Turned down the debug level (fatal errors and database errors are still shown).
- The recipients menu when writing a private message now separates active and inactive characters.
- Updated to jQuery UI 1.8.2.
- Updated to jQuery Colorbox 1.3.8.
- Removed some debug code from the Auth library since the Remember Me bug seems to have been solved.
- Added a method to the Characters model for inserting promotion records.
- Added a method to the Users model for removing user preference values.
- Addressed a security issue in CodeIgniter's Upload class.
- Error thrown when posting a comment on a mission post.
- Error thrown when attempting to delete a character.
- Error thrown during step 2 of the update process for some admins.
- Error thrown when there's only one mission image set on the mission details page.
- Error thrown when there's only one tour iamge set on the tour details page.
- Error thrown when there's only one character image set on the character bio page.
- Acceptance and rejection messages were sent without any of the changes the admin made.
- Changing a character's status to and from active wouldn't set the open slots of the position(s).
- When creating a character, the position dropdowns showed all positions instead of only open positions.
- Rank history information wasn't being populated correctly.
- Turning off update notification still attempted to run the check.
- A user's email preferences remained active even after the user was deactivated.
- A user's email preferences weren't removed when the user was removed.

## [1.0.5] - 2010-06-06

### Fixed

- Errors thrown after the SMS Upgrade process on Characters management.
- Error thrown after the SMS Upgrade process on NPC management.
- Errors thrown when editing a wiki page.
- Hidden departments were shown in the positions dropdown menu.
- A wrong variable was used in a model method.
- Addressed a security issue where docking request data wasn't filtered for XSS attacks.
- Docking request emails sent to the game master(s) had several bugs.
- Error thrown when updating a user to be inactive.
- There were no sanity checks on the type of variable needed when handling character deactivation.
- Errors thrown when rejecting a docking request.
- Unlinked NPCs wouldn't be able to use newly created bio fields.
- Site Options didn't allow admins with access to the Skin Catalogue to select skins in development.
- Join form instructions weren't displayed.

## [1.0.4] - 2010-05-12

### Fixed

- The `MY_Input` library tries to filter for Microsoft Word special character a little better.
- The Archives feature now requires PHP 5.0 or higher.
- Thresher now requires PHP 5.0 or higher.
- Updated to jQuery UI 1.8.1.
- Updated to jQuery markItUp! 1.1.7.
- Error thrown when a user with Level 1 user account access updated their account.
- Saved personal logs could be shown along with activated personal logs for users with multiple characters associated with their account.
- Internet Explorer threw an exception on the Mission Post, Personal Log, News Item and Docked Item management pages.
- Error thrown on the contact page.
- Errors thrown on the Manage Bio page for users with Level 1 access.
- Character position was updated from the Manage Bio page even when they shouldn't be.
- The status change email wasn't populated properly.
- The Textile parser had some bugs. (Thanks to Dustin for catching these issues.)
- Addressed an issue with emails on some servers.
- Attempted to fix some errors thrown in some circumstances during updates.

## [1.0.3] - 2010-04-26

### Fixed

- Removed the dependency on the versions array file. Instead, we try to pull a listing of the update directory dynamically (though we still use the array file in the the event the directory listing fails).
- Separated some code for character deletion between playing characters and NPCs.
- Added notices to the dynamic form management pages if there's no content available.
- Added some debug code to the Auth library to help track down the Remember Me bug.
- Cleaned up the Posts model.
- Added a parameter to a Post model method to help with issues in with unattented posts.
- When deactivating a user, we deactivate the user's characters at the same time.
- The Update Center to show the links to start the update regardless of whether there's information about the update or not.
- The Create Wiki page link didn't show up in the sub navigation menu.
- Posts weren't accurately counting unattented posts when a character ID was passed in as an integer instead of an array.
- Errors were thrown when deleting characters and NPCs.
- Error was thrown when writing a Mission Post.
- The post notification stayed active even after the post had been updated and/or emailed out.
- Errors thrown when adding a rank.
- Error thrown when there are no fields in a specification form section.
- Error thrown in the Admin Control Panel.
- Wiki pages were being categorized as Uncategorized even if they had categories.
- Error thrown for missing option parameters.
- Error thrown when accepting or rejecting a docked ship application.
- Thresher wasn't using the right regions in the Template config file.

## [1.0.2] - 2010-04-20

### Fixed

- The Ranks model uses the genre when looking for the default rank catalogue item.
- The Ranks model only pulls ranks sets from the current genre when getting all ranks.
- The Ranks model only pulls rank catalogue items for the current genre.
- The Ranks model `get_group_ranks()` method now has a parameter for a custom identifier.
- The Auth library checks for a user's status and will no longer allow pending users to log in.
- The Auth library will now allow 5 log in attempts before locking the user out.
- Admins can now add and edit the genre for Rank Catalogue items.
- The Upload Management page now shows a message if uploaded images weren't found in specific categories.
- Turned up the debug level so users could see any errors for debugging purposes.
- When a user updates their password and they're set to have Nova remember them, their cookie will be reset with the new password.
- The Menu library wouldn't respect any access control put on main navigation menu items or sub navigation menu items.
- Undefined variable error was thrown in the Rank Catalogue.
- The Rank Catalogue wouldn't work well when multiple genres were installed.
- Uploaded images (besides bio images) couldn't be deleted.
- Authors were dropped off of mission posts because of some flawed logic.
- The sample post wasn't in the email sent to the game master(s).
- Ranks couldn't be added in Internet Explorer.
- Rank classes wouldn't be shown for rank sets without a blank name rank item.
- The user bio pointed to the wrong location for user posts and user awards.
- Listing all of a user's posts would display posts besides their own.
- When commenting on a mission post, an error would be thrown.
- Updating a news item threw a fatal error.
- Updating a personal log threw a fatall error.
- Log in error 6 presentation issues.
- The mission dropdown wasn't properly populated when viewing a saved post.
- Added a special call to the `MY_Input` library to do some text cleanup after filtering for XSS.
- News items could be posted without a category.
- There were some minor schema differences between SMS and Nova created by the SMS Upgrade process.
- Addressed some of the Remember Me lockout issues.

## [1.0.1] 2010-04-16

### Fixed

- A database field wasn't properly added during the SMS Upgrade process.
- Models couldn't be autoloaded because `Base4.php` didn't extend `My_Loader`.
- An error was thrown because the `date_default_timezone_set` function doesn't exist in PHP before version 5.1.

## [1.0.0] - 2010-04-15

- Initial release
