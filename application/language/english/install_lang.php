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

$lang['button_submit'] = 'Submit';

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
$lang['install_index_options_update'] = 'Check for updates to Nova '. RARROW;
$lang['install_index_options_verify'] = 'Verify my server can run Nova '. RARROW;
$lang['install_index_options_readme'] = 'View the Nova readme '. RARROW;
$lang['install_index_options_remove'] = 'Uninstall Nova '. RARROW;
$lang['install_index_options_tour'] = 'Take a tour of Nova '. RARROW;
$lang['install_index_options_guide'] = 'Read the Install Guide '. RARROW;
$lang['install_index_options_upg_guide'] = 'Read the Upgrade Guide '. RARROW;
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
 * Verify
 */
$lang['install_verify_title'] = 'Verify Server Requirements';
$lang['install_verify_text'] = 'Below are the results of the server verification test. If any of the items below have failed, you will not be able to upgrade SMS to Nova. If any of the items below are listed as warnings, you should talk to your host about getting those items upgraded, but you will still be able to use Nova even if those warnings exist.';

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
$lang['install_label_login'] = 'Login Now';
$lang['install_label_begin'] = 'Begin Upgrade';
$lang['install_label_testdb'] = 'Test Database';

/*
 * Step 2
 */
$lang['install_step1_title'] = 'Step 1 - Create Database Tables';
$lang['install_step1_label'] = 'Step 1: Database Structure';
$lang['install_step1_success'] = 'You have successfully created the database structure needed by Nova! The next step will insert some basic data into your newly created database tables for use by Nova. Click <strong>Next Step</strong> to continue.';
$lang['install_step1_failure'] = "There was a problem creating the database structure. Please make sure all your settings in your config file are correct and try again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.";

/*
 * Step 3
 */
$lang['install_step2_title'] = 'Step 2 - Insert Basic Data';
$lang['install_step2_label'] = 'Step 2: Basic Data';
$lang['install_step2_success'] = 'You have successfully inserted the basic system data into your database. The next step will insert all of the genre-specific data into your database. Click <strong>Next Step</strong> to continue.';
$lang['install_step2_failure'] = 'There was a problem inserting all of the basic data into your database. Please clear your database tables and try again. If the problem persists, please contact <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne Productions</a> for additional support.';

/*
 * Step 4
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
 * Step 5
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
 * Step 6
 */
$lang['install_step5_title'] = 'Step 5 - Set System Values';
$lang['install_step5_label'] = 'Step 5: Finalize';
$lang['install_step5_success'] = "You have successfully updated the selected system values.\r\n\r\nNova has been successfully installed and you can begin using it. Please take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don". RSQUO ."t know how to do that, please contact your host. Nova needs these directories writable for several features.";
$lang['install_step5_failure'] = "There was a problem updating your system settings. This is not a critical error however. Once you have logged in, you will be able to update site settings.\r\n\r\nPlease take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don". RSQUO ."t know how to do that, please contact your host. Nova needs these directories writable for several features.";

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

$lang['verify_component'] = 'Component';
$lang['verify_required'] = 'Required';
$lang['verify_actual'] = 'Actual';
$lang['verify_result'] = 'Result';

$lang['verify_php'] = 'PHP';
$lang['verify_db'] = 'Database Platform';
$lang['verify_db_ver'] = 'Database Version';
$lang['verify_mem'] = 'Memory Limit';
$lang['verify_regglobals'] = 'Register Globals';

$lang['verify_success'] = '<span class="bold green">Success</span>';
$lang['verify_failure'] = '<span class="bold red">Failed</span>';
$lang['verify_warning'] = '<span class="bold orange">Warning</span>';

$lang['verify_off'] = 'Off';
$lang['verify_on'] = 'On';

/*
|---------------------------------------------------------------
| UPDATE
|---------------------------------------------------------------
*/

/*
 * Index
 */
$lang['upd_index_title'] = 'Update Center';
$lang['upd_index_header'] = 'Welcome to Nova!';
$lang['upd_index_options_update'] = 'Check for updates to Nova '. RARROW;
$lang['upd_index_options_verify'] = 'Verify my server can run Nova '. RARROW;
$lang['upd_index_options_readme'] = 'View the Nova readme '. RARROW;
$lang['upd_index_options_tour'] = 'Take a tour of Nova '. RARROW;
$lang['upd_index_options_upd_guide'] = 'Read the Update Guide '. RARROW;
$lang['upd_index_options_firststeps'] = 'First Steps';
$lang['upd_index_options_whatsnext'] = 'What'. RSQUO .'s Next?';

/*
 * Check
 */
$lang['upd_header_releasenotes'] = 'Release Notes';
$lang['upd_header_whatsnew'] = "What's New in This Release?";
$lang['update_text_no_updates'] = 'No updates are available for %s right now.';

$lang['upd_check_header_files'] = "Get the New Files";
$lang['upd_check_text_files'] = "The first thing you'll need to do is download the new Nova files. You can download the files from the <a href='http://www.anodyne-productions.com/index.php/nova/download' target='_blank'>Anodyne site</a>. Once you've downloaded the files, follow the directions in the README for updating to the latest version of Nova.";
$lang['upd_check_go_files'] = "<a href='http://www.anodyne-productions.com/index.php/nova/download' target='_blank'>Get the files now ". RARROW ."</a>";

$lang['upd_check_header_start'] = "Already Have the Files? Start the Update!";
$lang['upd_check_text_start'] = "If you've already downloaded the files and made the udpates to your system but just need to update your database, you can use the link below to start the process.";
$lang['upd_check_go_start'] = 'Start the update '. RARROW;

/*
 * Errors
 */
$lang['upd_error_title'] = 'Update Error!';
$lang['upd_error_back'] = LARROW .' Back to the Update Center';
$lang['upd_error_1'] = 'No version of Nova can be found in this database. In order to update, you must have Nova installed in this database. Please verify your database connection settings and try again.';
$lang['upd_error_2'] = 'Maintenance mode is currently off. You must login and turn maintenance mode on from Site Settings page before you can update the system.';
$lang['upd_error_3'] = 'You are not a system administrator and cannot update the system!';

/*
 * Step 1
 */
$lang['upd_step1_title'] = 'Step 1: Backup Database';
$lang['upd_step1_success'] = 'You have successfully backed up your Nova database and can continue with the update process. Click <strong>Next Step</strong> to continue.';
$lang['upd_step1_failure'] = "There was a problem backing up your Nova database. This can be caused by a variety issues, but is most likely caused by your host not allowing files to be written to the server. Please manually backup your Nova database then click <strong>Next Step</strong> to continue.";
$lang['upd_step1_nofields'] = "The update cannot continue because there are no Nova tables in this database!";
$lang['upd_step1_memory'] = "Your server does not have a sufficient memory capacity to initiate an automatic backup of your Nova database. Please manually backup your Nova database then click <strong>Next Step</strong> to continue.";

/*
 * Step 2
 */
$lang['upd_step2_title'] = 'Step 2: Run Update';
$lang['upd_step2_success'] = 'You have successfully updated Nova to version %s. You can continue using Nova as normal now. Remember to turn maintenance mode off from the Site Settings page so the rest of your players can use the site!';
$lang['upd_step2_site'] = 'Back to Site '. RARROW;

/*
 * Verify
 */
$lang['upd_verify_title'] = 'Verify Server Requirements';
$lang['upd_verify_back'] = LARROW .' Back to Update Center';
$lang['upd_verify_text'] = 'Below are the results of the server verification test. If any of the items below have failed, you will not be able to upgrade SMS to Nova. If any of the items below are listed as warnings, you should talk to your host about getting those items upgraded, but you will still be able to use Nova even if those warnings exist.';

$lang['update_not_installed'] = 'You have not installed Nova and cannot update the system until it is installed!';

$lang['update_available'] = '%s %s is now available.';
$lang['update_outofdate_files'] = 'Your system files are running version %s, but your database is running version %s. Please update your system files and try again.';
$lang['update_outofdate_database'] = 'Your database is running version %s, but your files are running version %s. Please use the links below to update your database.';

$lang['upd_text_sysadmin'] = 'Only system administrators can update the system. In order to continue with the update, you must verify you are a system administrator. Please provide your email address and password and click Submit.';

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

/*
 * Index
 */
$lang['upg_index_title'] = 'Upgrade Center';

$lang['upg_status_1'] = 'Nova is already installed in this database! In order to continue, you will need to change your database prefix variable, uninstall Nova, or use another database.';
$lang['upg_status_2'] = 'You are running a version of SMS that is not supported for upgrade to Nova. You must be running SMS 2.6.0 or higher in order to upgrade. Please update SMS then try again.';
$lang['upg_status_3'] = 'We could not find an copy of SMS installed on this database. In order to upgrade, you must be running SMS 2.6.0 or higher.';
$lang['upg_status_4'] = 'You are using a genre other than the DS9 genre. This upgrade process only supports upgrading to the DS9 genre. Please change your genre in the Nova config file and try again.';

$lang['upg_index_header'] = 'Welcome to the Nova Upgrade Center!';
$lang['upg_index'] = "<p>We know you're excited to start using Nova, but before you jump right in and start upgrading, make sure you read through everything very carefully. Nova is the product of years of work and as a result, a lot of things are different from SMS. The upgrade process should cover everything but to ensure everything is upgraded properly the first time, you should read our <a href='http://docs.anodyne-productions.com/index.php/nova/overview/upgrade' target='_blank'>upgrade guide</a> in the user guide. We realize this is a long document, but it has information crucial to properly upgrading SMS to Nova, so make sure you take the time to read it before beginning.</p><h4>Before Beginning</h4><p>There are a couple things you need to do before you even start the upgrade process.</p><ol class='decimal'><li>Set up your database connection file located at <strong>application/config/database.php</strong></li><li>Make sure you're using the DS9 genre (the upgrade will only work for the DS9 genre)</li><li>Make sure you've set up your SMS config preferences, upgrade password and upgrade email address located in <strong>application/config/sms.php</strong></li></ol><p>It's very important that you take the above steps before beginning otherwise you could be missing all the management tools or have errors throughout the upgrade process.</p><h4>Let's Get Started!</h4><p>Step 1 will attempt to automatically back up your SMS database before beginning the upgrade. If you have a large database and your server memory limit isn't high enough or your server doesn't support writing files to directories, you may not be able to complete the backup, but if it doesn't work, you can manually backup your database before starting. We <strong>strongly</strong> encourage you to have a backup before upgrading.</p>";

/*
 * Errors
 */
$lang['upg_error_title'] = 'Upgrade Error!';
$lang['upg_error_1'] = 'The version of SMS you are running is not compatible with this upgrade script. You must be running SMS %s in order to upgrade. Please update SMS to version %s and try again.';
$lang['upg_error_2'] = 'No version of SMS can be found in this database. In order to upgrade, you must have SMS installed in this database. Please verify your database connection settings and try again.';
$lang['upg_error_3'] = 'Nova is already installed and the upgrade script cannot run. Please verify your database connection settings and try again.';
$lang['upg_error_4'] = 'You can only upgrade Nova with the DS9 genre. Your genre is currently set to %s. Please change your genre in the application/config/nova.php file and try again.';

/*
 * Verify
 */
$lang['upg_verify_title'] = 'Verify Server Requirements';
$lang['upg_verify_back'] = LARROW .' Back to Upgrade Center';
$lang['upg_verify_text'] = 'Below are the results of the server verification test. If any of the items below have failed, you will not be able to upgrade SMS to Nova. If any of the items below are listed as warnings, you should talk to your host about getting those items upgraded, but you will still be able to use Nova even if those warnings exist.';

/*
 * Step 1
 */
$lang['upg_step1_title'] = 'Step 1 - Backup Database';
$lang['upg_step1_label'] = 'Step 1: Backup Database';
$lang['upg_step1_success'] = 'You have successfully backed up your SMS database and can continue with the upgrade process. The next step will create the database tables Nova needs to run. Click <strong>Next Step</strong> to continue.';
$lang['upg_step1_failure'] = "There was a problem backing up your SMS database. This can be caused by a variety issues, but is most likely caused by your host not allowing files to be written to the server. Please manually backup your SMS database then click <strong>Next Step</strong> to continue.";
$lang['upg_step1_nofields'] = "The upgrade cannot continue because there are no SMS tables in this database!";
$lang['upg_step1_memory'] = "Your server does not have a sufficient memory capacity to initiate an automatic backup of your SMS database. Please manually backup your SMS database then click <strong>Next Step</strong> to continue.";

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
$lang['upg_step5_success'] = 'You have successfully upgraded SMS\' site globals and messages to the new Nova settings format. The next step will upgrade your awards table and data to the new Nova format. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step5_failure'] = 'There was a problem upgrading your SMS site globals and messages to the new Nova settings format. You can continue with the upgrade and update the items once Nova is installed. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step5_noupgrade'] = 'You have selected not to upgrade your SMS site globals and messages. Please continue to the next step where we will upgrade your awards table and data to the new Nova format. This may take a few minutes depending on how many awards you have! Click <strong>Next Step</strong> to continue.';

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
$lang['upg_step7_title'] = 'Step 7 - Upgrade Missions';
$lang['upg_step7_label'] = 'Step 7: Upgrade Missions';
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
 * Step 9
 */
$lang['upg_step9_title'] = 'Step 9 - Upgrade Personal Logs';
$lang['upg_step9_label'] = 'Step 9: Upgrade Personal Logs';
$lang['upg_step9_success'] = 'You have successfully upgraded the personal logs to the new Nova format. The next step will upgrade your mission posts to the new Nova format. This may take a few minutes depending on how many mission posts you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step9_failure'] = 'There was a problem upgrading your personal logs to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your personal logs at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step9_noupgrade'] = 'You have selected not to upgrade your personal logs. Please continue to the next step where we will upgrade your mission posts to the new Nova format. This may take a few minutes depending on how many mission posts you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 10
 */
$lang['upg_step10_title'] = 'Step 10 - Upgrade Mission Posts';
$lang['upg_step10_label'] = 'Step 10: Upgrade Mission Posts';
$lang['upg_step10_success'] = 'You have successfully upgraded the mission posts to the new Nova format. The next step will upgrade your specifications to the new Nova format. Click <strong>Next Step</strong> to continue.';
$lang['upg_step10_failure'] = 'There was a problem upgrading all of your mission posts to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your mission posts at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step10_noupgrade'] = 'You have selected not to upgrade your mission posts. Please continue to the next step where we will upgrade your specifications to the new Nova format. Click <strong>Next Step</strong> to continue.';

/*
 * Step 11
 */
$lang['upg_step11_title'] = 'Step 11 - Upgrade Specifications';
$lang['upg_step11_label'] = 'Step 11: Upgrade Specifications';
$lang['upg_step11_success'] = 'You have successfully upgraded the specifications to the new Nova format. The next step will upgrade your tour items to the new Nova format. This may take a few minutes depending on how many tour items you have! Click <strong>Next Step</strong> to continue.';
$lang['upg_step11_failure'] = 'There was a problem upgrading all of your specifications to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your specifications at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step11_noupgrade'] = 'You have selected not to upgrade your specifications. Please continue to the next step where we will upgrade your tour items to the new Nova format. This may take a few minutes depending on how many tour items you have! Click <strong>Next Step</strong> to continue.';

/*
 * Step 12
 */
$lang['upg_step12_title'] = 'Step 12 - Upgrade Tour Items';
$lang['upg_step12_label'] = 'Step 12: Upgrade Tour Items';
$lang['upg_step12_success'] = 'You have successfully upgraded the tour items to the new Nova format. The next step will upgrade your characters and players to the new Nova format. This will take a few minutes! Click <strong>Next Step</strong> to continue.';
$lang['upg_step12_failure'] = 'There was a problem upgrading all of your tour items to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your tour items at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step12_noupgrade'] = 'You have selected not to upgrade your tour items. Please continue to the next step where we will upgrade your characters and players to the new Nova format. This will take a few minutes! Click <strong>Next Step</strong> to continue.';

/*
 * Step 13
 */
$lang['upg_step13_title'] = 'Step 13 - Upgrade Characters';
$lang['upg_step13_label'] = 'Step 13: Upgrade Characters';
$lang['upg_step13_success'] = 'You have successfully upgraded the characters and players to the new Nova format. All players will login to the system using the password set in the SMS config file. The next step will do some final clean up work across the database and will take a few minutes to complete. Click <strong>Next Step</strong> to continue.';
$lang['upg_step13_failure'] = 'There was a problem upgrading all of your characters and players to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your characters and players at a later date. You will need to add your player record in the database manually before you will be able to login. Click <strong>Next Step</strong> if you want to continue.';

/*
 * Step 14
 */
$lang['upg_step14_title'] = 'Step 14 - Finalize';
$lang['upg_step14_label'] = 'Step 14: Finalize';
$lang['upg_step14_success'] = "You have successfully upgraded SMS to Nova. You can now login using your email address and the password you set in the SMS config file. Once you've logged in, you'll be able to make changes to the system. All other players will login to the system using the password set in the SMS config file. Click <strong>Login</strong> to continue.";

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