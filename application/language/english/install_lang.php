<?php
/*
|---------------------------------------------------------------
| LANGUAGE FILE - ENGLISH
|---------------------------------------------------------------
| File: application/language/english/install_lang.php
| System Version: 1.0
|
| English language file for the system. Punctuation constants are
| defined in ./application/config/constants.php
|
|---------------------------------------------------------------
| NOTES
|---------------------------------------------------------------
| The following should not be translated:
|
| NDASH		- translates to a medium dash
| RSQUO		- translates to a right single quote
| RARROW	- translates to a right double arrow
| LARROW	- translates to a left double array
| AMP		- translates to an ampersand
|
| Rules:
|
| # If you use an apostrophe (') in your translations, you shoud be
|   using the our constant for it (RSQUO). There are examples in the
|	translated content.
| # If you use a dash (-) in your translations, you should be using
|   the our constant for it (NDASH). There are examples in the
|	translated content.
| # All language items should be in lowercase unless the original
|   English uses mixed case or uppercase.
| # Do not translate the array keys (the text in the brackets), only
|   translate what is on the right side of the equal sign (=).
*/

$lang['global_progress'] = 'Progress';
$lang['global_processing'] = 'Processing, please wait...';

$lang['global_content_index'] = "From all of us at Anodyne Productions we want to thank you for choosing <strong>Nova</strong> as your RPG management tool!\r\n\r\nNova represents years of work and a new approach to RPG management that we". RSQUO ."re excited to share. While the SIMM Management System was a revolution in managing your RPG, Nova is the next evolution that provides an easy-to-use, clean interface with a more powerful system engine that allows more robust tools for skin developers and third-party developers.";

/*
|---------------------------------------------------------------
| INSTALL
|---------------------------------------------------------------
*/

/*
 * Index
 */
$lang['install_index_title'] = 'Installation Center';
$lang['install_index_header_welcome'] = 'Welcome to Nova!';
$lang['install_index_header_whattodo'] = 'What do you want to do?';

$lang['install_index_options_install'] = 'Install a fresh copy of Nova '. RARROW;
$lang['install_index_options_upgrade'] = 'Upgrade to Nova from SMS 2 '. RARROW;
$lang['install_index_options_update'] = 'Update to the newest version of Nova '. RARROW;
$lang['install_index_options_verify'] = 'Verify my server can run Nova '. RARROW;
$lang['install_index_options_readme'] = 'View the Nova readme '. RARROW;
$lang['install_index_options_remove'] = 'Uninstall Nova '. RARROW;
$lang['install_index_options_tour'] = 'Take a tour of Nova '. RARROW;
$lang['install_index_options_firststeps'] = 'First Steps';
$lang['install_index_options_whatsnext'] = 'What'. RSQUO .'s Next?';

/*
 * Remove
 */
$lang['install_remove_title'] = 'Uninstall Nova';
$lang['install_remove_warning'] = 'Removing system data is permanent and cannot be undone, proceed with caution!';
$lang['install_remove_success'] = 'All system data has been cleared! You are free to re-install the system.';
$lang['install_remove_button_clear'] = 'Clear Data';

/*
 * Readme
 */
$lang['install_readme_title'] = 'Readme';

$lang['install_label_next'] = 'Next Step';
$lang['install_label_back'] = LARROW .' Back to Installation Center';
$lang['install_label_site'] = 'Proceed to Site '. RARROW;
$lang['install_label_on'] = 'On';
$lang['install_label_off'] = 'Off';
$lang['install_label_submit'] = 'Submit';

/*
 * Step 1
 */
$lang['install_step1_title'] = 'Step 1 - Create Database Tables';
$lang['install_step1_label'] = 'Step 1: Database Structure';
$lang['install_step1_success'] = 'You have successfully created the database structure needed by Nova! The next step will insert some basic data into your newly created database tables for use by Nova. Click <strong>Next Step</strong> to continue.';
$lang['install_step1_failure'] = "There was a problem creating the database structure. Please make sure all your settings in your config file are correct and try again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.";

/*
 * Step 2
 */
$lang['install_step2_title'] = 'Step 2 - Insert Basic Data';
$lang['install_step2_label'] = 'Step 2: Basic Data';
$lang['install_step2_success'] = 'You have successfully inserted the basic system data into your database. The next step will insert all of the genre-specific data into your database. Click <strong>Next Step</strong> to continue.';
$lang['install_step2_failure'] = 'There was a problem inserting all of the basic data into your database. Please clear your database tables and try again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

/*
 * Step 3
 */
$lang['install_step3_title'] = 'Step 3 - Insert Genre Data';
$lang['install_step3_label'] = 'Step 3: User Account &amp; Character';
$lang['install_step3_success'] = 'You have successfully inserted the genre data into your database. Please use the fields below to create your user profile and main character. You will be able to edit the character bio and your account once installation is complete and you have logged in to the system. Once you are finished, click <strong>Next Step</strong> to continue.';
$lang['install_step3_failure'] = 'There was a problem inserting all of the genre data into your database. Please clear your database tables and try again. If you have created the genre file yourself, please make sure the file is formatted correctly and you don'. RSQUO .'t have any syntax errors. If you are using an Anodyne-created genre file, try installing again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

$lang['install_step3_player'] = 'Player Information';
$lang['install_step3_name'] = 'Real Name';
$lang['install_step3_email'] = 'Email Address';
$lang['install_step3_password'] = 'Password';
$lang['install_step3_dob'] = 'Date of Birth';
$lang['install_step3_character'] = 'Character Information';
$lang['install_step3_fname'] = 'First Name';
$lang['install_step3_lname'] = 'Last Name';
$lang['install_step3_rank'] = 'Rank';
$lang['install_step3_position'] = 'Position';
$lang['install_step3_timezone'] = 'Select Your Timezone';
$lang['install_step3_question'] = 'Security Question';
$lang['install_step3_answer'] = 'Answer';
$lang['text_security_question'] = 'Remember your security answer exactly as you type it!';

/*
 * Step 4
 */
$lang['install_step4_title'] = 'Step 4 - Create Account';
$lang['install_step4_label'] = 'Step 4: System Setup';
$lang['install_step4_success'] = 'You have successfully created your user profile and main character. You will be able to login to the system using your email address and the password you just created. You can now set up some of the basic system settings. You will be able to update more settings once Nova is installed and you have logged in to the Admin Control Panel. Once you are finished, click <strong>Next Step</strong> to continue.';
$lang['install_step4_failure'] = 'There was a problem inserting your user profile and/or main character. Please clear your database tables and try again. If you are using an Anodyne-created genre file, try installing again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

$lang['install_step4_simname'] = 'Sim Name';
$lang['install_step4_emailsubject'] = 'Email Subject Prefix';
$lang['install_step4_sysemail'] = 'System Emails';
$lang['install_step4_updates'] = 'Update Notification';
$lang['install_step4_chars'] = 'Allowed Playing Characters / Player';
$lang['install_step4_npcs'] = 'Allowed NPCs / Player';
$lang['install_step4_dates'] = 'Date Format';
$lang['install_step4_updates_all'] = 'All Updates';
$lang['install_step4_updates_maj'] = 'Major Updates (1.0, 2.0, etc.)';
$lang['install_step4_updates_min'] = 'Minor Updates (1.1, 1.2, etc.)';
$lang['install_step4_updates_none'] = 'No Updates';

/*
 * Step 5
 */
$lang['install_step5_title'] = 'Step 5 - Set System Values';
$lang['install_step5_label'] = 'Step 5: Finalize';
$lang['install_step5_success'] = "You have successfully updated the selected system values.\r\n\r\nNova has been successfully installed and you can begin using it. Please take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don". RSQUO ."t know how to do that, please contact your host. Nova needs these directories writable for several features.";
$lang['install_step5_failure'] = "There was a problem updating your system settings. This is not a critical error however. Once you have logged in, you will be able to update site settings.\r\n\r\nPlease take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don". RSQUO ."t know how to do that, please contact your host. Nova needs these directories writable for several features.";

/*
|---------------------------------------------------------------
| FEATURE TOUR
|---------------------------------------------------------------
*/

$lang['install_tour_whatsnew'] = 'What'. RSQUO .'s New in Nova?';
$lang['install_tour_whatsnew_content'] = 'There isn'. RSQUO .'t a single area of the system we haven'. RSQUO .'t gone in and improved in some way, shape or form. Sometimes it'. RSQUO .'s minor, other times it'. RSQUO .'s a radical change. But even with all the changes we'. RSQUO .'ve worked hard to make sure the system is still incredibly intuitive. Our goal with Nova was to provide a system that got out of your way and just let you play the game the way you want. We'. RSQUO .'re very proud of what we'. RSQUO .'ve accomplished here and are excited to share it with you. Below are a handful of brand new features and enhancements in Nova. We encourage you to check out <a href="http://docs.anodyne-productions.com/nova.php">Nova'. RSQUO .'s documentation</a> to get a complete list of changes since SMS and get a ton of information from the new user guide.';

$lang['install_title_tour'] = 'Nova Tour';

$lang['install_tour_header_genres'] = 'Genres';
$lang['install_tour_header_bios'] = 'Dynamic Bios';
$lang['install_tour_header_players'] = 'Players &amp; Characters';
$lang['install_tour_header_wiki'] = 'Built-in Wiki';

$lang['install_tour_genres_content'] = 'When Anodyne Productions released SMS in the spring of 2005, the focus was entirely on Star Trek. Even with the release of version 2 of SMS, Anodyne decided not to stray from what they knew and had worked so well. But as time went on, other organizations wanted to use SMS for their RPGs because of its ease of use and power. With everything hard-coded for Star Trek though, any modifications were laborious at best. With Nova, we'. RSQUO .'ve addressed that issue head on by creating wide-ranging support for different genres. Right now, Nova can handle fourteen different genres ranging from Battlestar Galactica to Firefly to Stargate Atlantis and everything in between. In addition, we'. RSQUO .'ve greatly expanded our Star Trek genres to include information for Enterprise, The Original Series, the Movie era and even several different alien races (Klingon, Cardassian, Romulan and Bajoran). Our goal was to make Nova as flexible and versatile a product as we could and genres is just one way we do that.';
$lang['install_tour_bios_content'] = 'Character biographies are now driven almost entirely from the database. While that may not sound like anything special, it'. RSQUO .'s actually one of the coolest things about Nova. Now, instead of a static HTML file, the bios (as well as specs and tour pages) are built entirely on the fly from the database. This means that admins have more control than ever before over bios, specs and tour pages to make them their own. Don'. RSQUO .'t want to see a Service Record entry in the bio pages? Remove it. Want to add a field for any pets your character may have? You can add it. All these changes are done right from the Nova Admin Control Panel in an easy to use interface, meaning that more than ever, you have complete control over your site.';
$lang['install_tour_players_content'] = 'Let'. RSQUO .'s face it, not everyone plays the game the same way. Some organizations or RPGs allow a single player to have multiple playing characters while others restrict it to a single playing character for each player. Why should people who do it one way have an easier time than others? The answer is they shouldn'. RSQUO .'t and we'. RSQUO .'ve corrected that imbalance in Nova by separating player and character accounts. Now, once you have a player account, admins can assign playing characters and even non-playing characters to a player for them to post as. This means that instead of having to post as John even when you'. RSQUO .'re playing Dave, you can post as Dave and the crew will see it on the site and in their inboxes as coming from Dave, not John. Nova even allows admins to set the maximum number of playing and non-playing characters that can be assigned to a player. This leap forward ensures that no matter how you play the game, Nova makes it easier for you to starting posting how you want.';
$lang['install_tour_wiki_content'] = '<em>Coming Soon...</em>';

/*
|---------------------------------------------------------------
| SERVER VERIFICATION
|---------------------------------------------------------------
*/

$lang['verify_header_success'] = 'Congratulations, your server is able to run Nova!';
$lang['verify_header_failure'] = 'Your server does not meet the minimum requirements for running Nova!';

$lang['verify_content_success'] = 'Continuing on to the installation will create the database tables the system needs to run, insert some basic data, and allow you to set up your account.';
$lang['verify_content_failure'] = 'We' . RSQUO . 're sorry, but your server cannot run Nova. In order to run Nova, you must be running PHP version 4.3.2 or higher and have a database. (Supported database platforms are MySQL 4.1+ and MySQLi.) Please make sure you have a server that meets these requirements and try again.';

$lang['verify_link_success'] = 'Go to step 1 '. RARROW;

$lang['verify_table_component'] = 'Component';
$lang['verify_table_required'] = 'Required';
$lang['verify_table_actual'] = 'Actual';
$lang['verify_table_recommended'] = 'Recommended';

$lang['verify_table_php'] = 'PHP';
$lang['verify_table_db'] = 'Database Platform';
$lang['verify_table_db_ver'] = 'Database Version';
$lang['verify_table_mem_limit'] = 'Memory Limit';
$lang['verify_table_reg_globals'] = 'Register Globals';

/*
|---------------------------------------------------------------
| UPDATE
|---------------------------------------------------------------
*/

$lang['update_not_installed'] = 'You have not installed Nova and cannot update the system until it is installed!';

$lang['update_available'] = '%s %s is now available.';
$lang['update_outofdate_files'] = 'Your system files are running version %s, but your database is running version %s. Please update your system files and try again.';
$lang['update_outofdate_database'] = 'Your database is running version %s, but your files are running version %s. Please use the links below to update your database.';

$lang['update_header_releasenotes'] = 'Release Notes';
$lang['update_header_whatsnew'] = "What's New in This Release?";

$lang['update_text_no_updates'] = 'No updates are available for %s right now.';
$lang['update_text_index'] = 'Only system administrators can update the system. In order to continue with the update, you must verify you are a system administrator. Please provide your email address and password and click Submit.';

$lang['update_title_index'] = 'Update Center';

$lang['title_update_readme'] = 'Readme';
$lang['title_update_sms_index'] = 'Upgrade from SMS';
$lang['title_update_sms_step1'] = 'SMS Update - Step 1: Database Backup';
$lang['title_update_sms_step2'] = 'SMS Update - Step 2: Create New Tables';
$lang['title_update_sms_step3'] = 'SMS Update - Step 3: Insert Basic Data';
$lang['title_update_sms_step4'] = 'SMS Update - Step 4: Insert Genre Data';
$lang['title_update_sms_step5'] = 'SMS Update - Step 5: Import SMS Data';

$lang['head_update_error'] = 'Error!';
$lang['head_update_sms_index'] = 'Upgrade SMS';
$lang['head_update_sms_step1'] = 'SMS Update '. NDASH .' Step 1: Database Backup';

$lang['update_sms_next'] = 'Next';
$lang['update_sms_begin_update'] = 'Begin Update';

$lang['update_sms_menu_step1'] = 'Step 1: Database Backup';
$lang['update_sms_menu_step2'] = 'Step 2: Create New Tables';
$lang['update_sms_menu_step3'] = 'Step 3: Insert Basic Data';
$lang['update_sms_menu_step4'] = 'Step 4: Insert Genre Data';
$lang['update_sms_menu_step5'] = 'Step 5: Import SMS Data';

$lang['update_sms_index_msg'] = "Nova represents an incredible evolution of the RPG management system and one of those majors evolutions is how simple it is to upgrade from SMS 2.6 to Nova. The following steps will guide you through upgrading your SMS system to the current version of Nova. All in all, the upgrade process will take anywhere between 60 seconds and a few minutes depending on the speed of your connection and how much data needs to be converted and inserted into Nova.\r\n\r\nYou <strong>must</strong> be running SMS 2.6.0 or higher before beginning the upgrade! If you are not running the latest version of SMS, you will not be allowed to continue.\r\n\r\nThe upgrade will start by doing an automatic backup of your SMS database tables. In the event that your server doesn". RSQUO ."t have a high enough memory limit, you will be notified to perform a manual backup before continuing. We <strong>strongly</strong> urge you to do a backup of both your SMS files and database before moving forward with the upgrade. We". RSQUO ."ve done our best to test the upgrade script, but things can always go wrong, and without a backup, you may not be able to recover your sim". RSQUO ."s data.\r\n\r\n";

$lang['update_sms_step1_success'] = "The backup has been successfully run. We recommend that you verify the backup ZIP archive is in the <strong>application/assets/backups</strong> directory before continuing. If it is not, we <strong>strongly</strong> recommend that you create a manual backup of your SMS database tables.\r\n\r\nThe next step of the update process will create the new tables Nova will need to run.";
$lang['update_sms_step1_no_backup'] = 'The backup could not be run because your server does not have a high enough memory limit. We <strong>strongly</strong> recommend that you do a manual backup through phpMyAdmin before continuing. Once you have backed up your SMS database tables, you can continue to the next step which will create the new tables Nova will need to run.';
$lang['update_sms_step1_no_fields'] = 'There are no SMS database tables to backup. If you believe you have receive this message in error, please manually backup your SMS database tables before continuing. Once you have backed up your data, you can continue to the next step which will create the new tables Nova will need to run.';

$lang['install_label_yes'] = 'yes';
$lang['install_label_no'] = 'no';
$lang['install_label_on'] = 'on';
$lang['install_label_off'] = 'off';

/*
|---------------------------------------------------------------
| UPGRADE
|---------------------------------------------------------------
*/

$lang['upgrade_index_title'] = 'Upgrade Center';

$lang['upgrade_index_head'] = 'Upgrade Center';

$lang['upgrade_status_1'] = 'Nova is already installed in this database! In order to continue, you will need to change your database prefix variable, uninstall Nova, or use another database.';
$lang['upgrade_status_2'] = 'You are running a version of SMS that is not supported for upgrade to Nova. You must be running SMS 2.6.0 or higher in order to upgrade. Please update SMS then try again.';
$lang['upgrade_status_3'] = 'We could not find an copy of SMS installed on this database. In order to upgrade, you must be running SMS 2.6.0 or higher.';

/*
 * Step 2
 */
$lang['upg_step2_title'] = 'Step 2 - Create Database Tables';
$lang['upg_step2_label'] = 'Step 2: Database Structure';
$lang['upg_step2_success'] = 'You have successfully created the database structure needed by Nova! The next step will insert some basic data into your newly created database tables for use by Nova. Click <strong>Next Step</strong> to continue.';
$lang['upg_step2_failure'] = "There was a problem creating the database structure. Please make sure all your settings in your config file are correct and try again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.";

/*
 * Step 3
 */
$lang['upg_step3_title'] = 'Step 3 - Insert Basic Data';
$lang['upg_step3_label'] = 'Step 3: Basic Data';
$lang['upg_step3_success'] = 'You have successfully inserted the basic system data into your database. The next step will insert all of the genre-specific data into your database. Click <strong>Next Step</strong> to continue.';
$lang['upg_step3_failure'] = 'There was a problem inserting all of the basic data into your database. Please clear your database tables and try again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

/*
 * Step 4
 */
$lang['upg_step4_title'] = 'Step 4 - Insert Genre Data';
$lang['upg_step4_label'] = 'Step 4: Insert Genre Data';
$lang['upg_step4_success'] = 'You have successfully inserted the genre data into your database. The next step will upgrade several of your global settings to the new Nova settings format. The following items will be upgraded: ship prefix, ship name, ship registry, sim year, default post counting, JP count format and email subject. Other items cannot be upgraded and will have to be manually updated from Site Settings after Nova is installed. Click <strong>Next Step</strong> to continue.';
$lang['upg_step4_failure'] = 'There was a problem inserting all of the genre data into your database. Please clear your database tables and try again. If you have created the genre file yourself, please make sure the file is formatted correctly and you don'. RSQUO .'t have any syntax errors. If you are using an Anodyne-created genre file, try installing again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

/*
 * Step 5
 */
$lang['upg_step5_title'] = 'Step 5 - Upgrade Site Globals';
$lang['upg_step5_label'] = 'Step 5: Upgrade Site Globals';
$lang['upg_step5_success'] = 'You have successfully upgraded SMS\' site globals to the new Nova settings format. The next step will upgrade your awards table and data to the new Nova format. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step5_failure'] = 'There was a problem upgrading your SMS site globals to the new Nova settings format. You can continue with the upgrade and update the items once Nova is installed. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step5_noupgrade'] = 'You have selected not to upgrade your SMS site globals. Please continue to the next step where we will upgrade your awards table and data to the new Nova format. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 6
 */
$lang['upg_step6_title'] = 'Step 6 - Upgrade Awards';
$lang['upg_step6_label'] = 'Step 6: Upgrade Awards';
$lang['upg_step6_success'] = 'You have successfully upgraded the awards to the new Nova format. The next step will upgrade your missions table and data to the new Nova format. This may take a few minutes depending on how many missions you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step6_failure'] = 'There was a problem upgrading your awards to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your awards at a later date. This may take a few minutes depending on how many missions you have! Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step6_noupgrade'] = 'You have selected not to upgrade your awards. Please continue to the next step where we will upgrade your missions table and data to the new Nova format. This may take a few minutes depending on how many missions you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 7
 */
$lang['upg_step7_title'] = 'Step 7 - Upgrade News Items';
$lang['upg_step7_label'] = 'Step 7: Upgrade News Items';
$lang['upg_step7_success'] = 'You have successfully upgraded the missions to the new Nova format. The next step will upgrade your news and news category tables and data to the new Nova format. This may take a few minutes depending on how many news items you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step7_failure'] = 'There was a problem upgrading your missions to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your missions at a later date and it will likely cause problems with your posts as well. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step7_noupgrade'] = 'You have selected not to upgrade your missions. Please continue to the next step where we will upgrade your news and news category tables and data to the new Nova format. This may take a few minutes depending on how many news items you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 8
 */
$lang['upg_step8_title'] = 'Step 8 - Upgrade News Items';
$lang['upg_step8_label'] = 'Step 8: Upgrade News Items';
$lang['upg_step8_success'] = 'You have successfully upgraded the news items to the new Nova format. The next step will upgrade your personal logs to the new Nova format. This may take a few minutes depending on how many personal logs you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step8_failure'] = 'There was a problem upgrading your news items to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your news items at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step8_noupgrade'] = 'You have selected not to upgrade your news items. Please continue to the next step where we will upgrade your personal logs to the new Nova format. This may take a few minutes depending on how many personal logs you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 11
 */
$lang['upg_step11_title'] = 'Step 11 - Upgrade Specifications';
$lang['upg_step11_label'] = 'Step 11: Upgrade Specifications';
$lang['upg_step11_success'] = 'You have successfully upgraded the specifications to the new Nova format. The next step will upgrade your tour items to the new Nova format. This may take a few minutes depending on how many tour items you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step11_failure'] = 'There was a problem upgrading all of your specifications to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your specifications at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step11_noupgrade'] = 'You have selected not to upgrade your specifications. Please continue to the next step where we will upgrade your tour items to the new Nova format. This may take a few minutes depending on how many tour items you have! Click <strong>Next Step</strong> to continue.';

/*
|---------------------------------------------------------------
| ERRORS
|---------------------------------------------------------------
*/

$lang['install_login_proceed'] = 'You must provide your email address and password to proceed!';

$lang['error_not_sysadmin_genre'] = 'You must be a system administrator to change this sim' . RSQUO . 's genre!';
$lang['error_not_sysadmin_remove'] = 'You must be a system administrator to remove this sim' . RSQUO . 's system data!';
$lang['error_incorrect_credentials'] = 'Either your username and/or password are incorrect. Please try again.';

$lang['install_error_1'] = 'The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.';
$lang['error_install_no_genre'] = 'You must configure your genre in <strong>applications/config/nova.php</strong>! You cannot continue until you set a genre. Once you have setup a genre, refresh this page to re-run the genre data install.';

/* End of file install_lang.php */
/* Location: ./application/language/english/install_lang.php */