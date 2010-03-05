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

$lang['global_content_sysadmin'] = "Only system administrators can %s the system. In order to continue with the %s, you must verify you are a system administrator. Please provide your email address and password and click Submit.";

$lang['button_submit']			= 'Submit';
$lang['button_begin']			= 'Begin Upgrade';
$lang['button_login']			= 'Login Now';
$lang['button_site']			= 'Go To Your Site';
$lang['button_back_install'] 	= 'Back to Installation Center';
$lang['button_back_update'] 	= 'Back to Update Center';
$lang['button_next']			= 'Next Step';
$lang['button_clear']			= 'Clear Data';

$lang['global_email']			= 'Email Address';
$lang['global_genre']			= 'Genre';
$lang['global_off']				= 'Off';
$lang['global_on']				= 'On';
$lang['global_password']		= 'Password';
$lang['global_update']			= 'update';
$lang['global_upgrade']			= 'upgrade';

$lang['global_readme_title'] 	= 'Readme';
$lang['global_more_options']	= 'More Options';

/*
|---------------------------------------------------------------
| INSTALL TYPE
|---------------------------------------------------------------
*/

$lang['install_options_choose'] = 'Please select from the following options:';
$lang['install_options_fresh_title'] = 'Fresh Install';
$lang['install_options_upd_title'] = 'Update Nova';
$lang['install_options_upg_title'] = 'Upgrade From SMS';

$lang['install_options_fresh_text'] = "If you don't already have Nova installed on your server and want to install a clean copy of the system, use this option. Don't try to install the system over top of an existing Nova installation. If you want to re-install Nova, you'll need to uninstall the system first then install it again.";
$lang['install_options_upd_text'] = "Anodyne is committed to providing continued support for Nova through software updates. If you need to access the Update Center to check for and apply Nova software updates, use this option.";
$lang['install_options_upg_text'] = "Nova includes an easy-to-use upgrade process that will take the information from a site running SMS 2.6.9 or higher and upgrade it to be usable by Nova. In order to do the upgrade, your SMS database has to be in the same database as where you're installing Nova.";

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

$lang['install_index_options_install'] = 'Install a fresh copy of Nova';
$lang['install_index_options_upgrade'] = 'Upgrade to Nova from SMS 2';
$lang['install_index_options_update'] = 'Check for updates to Nova';
$lang['install_index_options_verify'] = 'Verify my server can run Nova';
$lang['install_index_options_readme'] = 'View the Nova readme';
$lang['install_index_options_remove'] = 'Uninstall Nova';
$lang['install_index_options_tour'] = 'Take a tour of Nova';
$lang['install_index_options_guide'] = 'Read the Install Guide';
$lang['install_index_options_genre'] = 'Install additional genres';
$lang['install_index_options_database'] = 'Add your own tables/fields to the database';
$lang['install_index_options_upg_guide'] = 'Read the Upgrade Guide';
$lang['install_index_options_firststeps'] = 'First Steps';
$lang['install_index_options_whatsnext'] = "What's Next?";

$lang['install_option_begin'] = 'Begin Nova Installation';

/*
 * Remove
 */
$lang['install_remove_title'] = 'Uninstall Nova';
$lang['install_remove_warning'] = 'Removing system data is permanent and cannot be undone, proceed with caution!';
$lang['install_remove_success'] = 'All system data has been cleared! You are free to re-install the system.';

/*
 * Genre Change
 */
$lang['install_genre_title'] = 'Install New Genre';
$lang['install_genre_inst'] = 'Please select the genre file you want to use for installing a new genre then click Submit.';
$lang['install_genre_success'] = 'New genre was successfully installed! You can now use the genre by changing the genre variable in your Nova config file.';

/*
 * Database Change
 */
$lang['install_changedb_title'] = 'Change Database';
$lang['install_changedb_header_table'] = 'Add Database Table';
$lang['install_changedb_header_field'] = 'Add Database Field';
$lang['install_changedb_inst'] = "You can use the sections below to modify your database for any changes you'd like to make. You can only add tables and fields, you cannot delete or modify existing tables or fields. In addition, you can only take these actions on Nova's tables, no other tables in your database. <span class='bold red'>Use extreme caution when modifying the database!</span>";
$lang['install_changedb_inst_table'] = "To create a new database table, simply provide the name you want the table called and click Submit. Nova will automatically add the table prefix, so you do not need to include it. In addition, Nova will create an ID field for you. If you want to change that field, you'll need to do so from the database.";
$lang['install_changedb_inst_field'] = "To create a new field in the database, simply select the table you'd like to add it to, the name, the type, the constraint (if any) and the default then click Submit.";

$lang['install_changedb_choose'] = 'Choose a Database Table';
$lang['install_changedb_table'] = 'Database Table';
$lang['install_changedb_name'] = 'Field Name';
$lang['install_changedb_constraint'] = 'Field Constraint';
$lang['install_changedb_type'] = 'Field Type';
$lang['install_changedb_value'] = 'Field Default';

$lang['install_changedb_table_success'] = 'Database table %s was successfully added!';
$lang['install_changedb_table_failure'] = 'Could not add database table %s. Please try again.';
$lang['install_changedb_field_success'] = 'Database field %s was successfully added to %s!';
$lang['install_changedb_field_failure'] = 'Could not add database field %s to %s. Please try again.';
$lang['install_changedb_field_notable'] = 'Could not add field to the database because no database table was specified. Please choose a database table and try again.';

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
$lang['install_step3_failure'] = "There was a problem inserting all of the genre data into your database. Please clear your database tables and try again. If you have created the genre file yourself, please make sure the file is formatted correctly and you don't have any syntax errors. If you are using an Anodyne-created genre file, try installing again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.";

$lang['install_step3_user'] = 'User Information';
$lang['install_step3_name'] = 'Real Name';
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

$lang['install_step4_filehandle'] = "Your server does not allow the necessary file handling functions required for checking for new versions of Nova. Because of this, you will not be notified when new versions of Nova are released and will need to manually check the Anodyne Productions website. You can contact your host to get this issue resolved and tell them to turn <em>allow_url_fopen</em> on in the php.ini file.";

$lang['install_step4_simname'] = 'Sim Name';
$lang['install_step4_emailsubject'] = 'Email Subject Prefix';
$lang['install_step4_sysemail'] = 'System Emails';
$lang['install_step4_updates'] = 'Update Notification';
$lang['install_step4_chars'] = 'Allowed Playing Characters / User';
$lang['install_step4_npcs'] = 'Allowed NPCs / User';
$lang['install_step4_dates'] = 'Date Format';
$lang['install_step4_updates_all'] = 'All Updates';
$lang['install_step4_updates_maj'] = 'Major Updates (1.0, 2.0, etc.)';
$lang['install_step4_updates_min'] = 'Minor Updates (1.1, 1.2, etc.)';
$lang['install_step4_updates_incr'] = 'Incremental Updates (1.0.1, 1.0.2, etc.)';
$lang['install_step4_updates_none'] = 'No Updates';

/*
 * Step 5
 */
$lang['install_step5_title'] = 'Step 5 - Set System Values';
$lang['install_step5_label'] = 'Step 5: Finalize';
$lang['install_step5_success'] = "You have successfully updated the selected system values.\r\n\r\nNova has been successfully installed and you can begin using it. Please take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don't know how to do that, please contact your host. Nova needs these directories writable for several features.";
$lang['install_step5_failure'] = "There was a problem updating your system settings. This is not a critical error however. Once you have logged in, you will be able to update site settings.\r\n\r\nPlease take the time to read through our extensive <a href='http://docs.anodyne-productions.com/nova.php' target='_blank'>user guide</a> as it will answer most questions you may have.\r\n\r\nNow that Nova is installed, please make sure the <em>application/assets/images</em> and <em>application/assets/backups</em> directories and all their subdirectories are writable (777). If you don't know how to do that, please contact your host. Nova needs these directories writable for several features.";

/*
|---------------------------------------------------------------
| SERVER VERIFICATION
|---------------------------------------------------------------
*/

$lang['verify_component'] = 'Component';
$lang['verify_required'] = 'Required';
$lang['verify_actual'] = 'Actual';
$lang['verify_result'] = 'Result';

$lang['verify_php'] = 'PHP';
$lang['verify_db'] = 'Database Platform';
$lang['verify_db_ver'] = 'Database Version';
$lang['verify_mem'] = 'Memory Limit';
$lang['verify_regglobals'] = 'Register Globals';
$lang['verify_file'] = 'File Handling';

$lang['verify_success'] = '<span class="bold green">Success</span>';
$lang['verify_failure'] = '<span class="bold red">Failed</span>';
$lang['verify_warning'] = '<span class="bold orange">Warning</span>';

$lang['verify_title'] = 'Verify Server Requirements';
$lang['verify_text'] = 'Below are the results of the server verification test. If any of the items have <span class="bold red">failed</span>, Nova won\'t install properly (or at all). If there are any <span class="bold orange">warnings</span> listed, you should talk to your host about getting those items updated, but you\'ll still be able to install and use Nova despite the warnings.';

/*
|---------------------------------------------------------------
| UPDATE
|---------------------------------------------------------------
*/

$lang['update_available'] = '%s %s is now available.%s';
$lang['update_your_version'] = " You are running %s %s.";
$lang['update_required'] = 'Update Required';
$lang['update_outofdate_files'] = 'Your system files are running version %s, but your database is running version %s. Please update your system files and try again.';
$lang['update_outofdate_database'] = 'Your database is running version %s, but your files are running version %s. Please use the link below to update your database.';

/*
 * Index
 */
$lang['upd_index_title'] = 'Update Center';
$lang['upd_index_header'] = 'Welcome to Nova!';
$lang['upd_index_options_update'] = 'Check for updates to Nova';
$lang['upd_index_options_verify'] = 'Verify my server can run Nova';
$lang['upd_index_options_readme'] = 'View the Nova readme';
$lang['upd_index_options_tour'] = 'Take a tour of Nova';
$lang['upd_index_options_upd_guide'] = 'Read the Update Guide';
$lang['upd_index_options_firststeps'] = 'First Steps';
$lang['upd_index_options_whatsnext'] = "What's Next?";

/*
 * Check
 */
$lang['upd_header_releasenotes'] = 'Release Notes';
$lang['upd_header_whatsnew'] = "What's New in This Release?";
$lang['update_text_no_updates'] = 'No updates are available for %s right now.';

$lang['upd_check_header_files'] = "Get the New Files";
$lang['upd_check_text_files'] = "The first thing you'll need to do is download the new Nova files. You can download the files from the Anodyne site. Once you've downloaded the files, follow the directions in the README for updating to the latest version of Nova.";
$lang['upd_check_go_files'] = "<a href='%s' target='_blank'>Get the files now ". RARROW ."</a>";

$lang['upd_check_header_start'] = "Already Have the Files? Start the Update!";
$lang['upd_check_text_start'] = "If you've already downloaded the files and made the udpates to your system but just need to update your database, you can use the link below to start the process.";
$lang['upd_check_go_start'] = 'Start the update '. RARROW;

/*
 * Errors
 */
$lang['upd_error_title'] = 'Update Error!';
$lang['upd_error_back'] = LARROW .' Back to the Update Center';
$lang['upd_error_1'] = 'No version of Nova can be found in this database. In order to update, you must have Nova installed in this database. Please verify your database connection settings and try again.';
$lang['upd_error_2'] = 'Maintenance mode is currently off. It\'s recommended that you turn maintenance mode on from Site Settings page before you attempting to update the system.';
$lang['upd_error_3'] = 'You are not a system administrator and cannot update the system!';

/*
 * Step 1
 */
$lang['upd_step1_title'] = 'Step 1: Backup Database';
$lang['upd_step1_success'] = 'You have successfully backed up your Nova database and can continue with the update process. Click <strong>Next Step</strong> to continue.';
$lang['upd_step1_failure'] = "There was a problem backing up your Nova database. This can be caused by a few different things, but it's most likely because your sever doesn't allowing files to be created on the server. Please manually backup your Nova database then click <strong>Next Step</strong> to continue.";
$lang['upd_step1_nofields'] = "The update cannot continue because there are no Nova tables in this database!";
$lang['upd_step1_memory'] = "Your server doesn't have enough available memory to do an automatic backup of your Nova database. You should manually backup your Nova database right now then, when finished, click <strong>Next Step</strong> to continue.";

/*
 * Step 2
 */
$lang['upd_step2_title'] = 'Step 2: Run Update';
$lang['upd_step2_success'] = 'You have successfully updated Nova to version %s. You can continue using Nova as normal now. Remember to turn maintenance mode off from the Site Settings page so the rest of your users can use the site!';
$lang['upd_step2_site'] = 'Back to Site';

/*
 * Verify
 */
$lang['upd_verify_back'] = LARROW .' Back to Update Center';

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
$lang['upg_verify_back'] = LARROW .' Back to Upgrade Center';

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
$lang['upg_step12_success'] = 'You have successfully upgraded the tour items to the new Nova format. The next step will upgrade your characters and users to the new Nova format. This will take a few minutes! Click <strong>Next Step</strong> to continue.';
$lang['upg_step12_failure'] = 'There was a problem upgrading all of your tour items to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your tour items at a later date. Click <strong>Next Step</strong> if you want to continue.';
$lang['upg_step12_noupgrade'] = 'You have selected not to upgrade your tour items. Please continue to the next step where we will upgrade your characters and users to the new Nova format. This will take a few minutes! Click <strong>Next Step</strong> to continue.';

/*
 * Step 13
 */
$lang['upg_step13_title'] = 'Step 13 - Upgrade Characters';
$lang['upg_step13_label'] = 'Step 13: Upgrade Characters';
$lang['upg_step13_success'] = 'You have successfully upgraded the characters and users to the new Nova format. All users will login to the system using the password set in the SMS config file. The next step will do some final clean up work across the database and will take a few minutes to complete. Click <strong>Next Step</strong> to continue.';
$lang['upg_step13_failure'] = 'There was a problem upgrading all of your characters and users to the new Nova format. This can be caused by having made previous changes to the table, causing problems with the upgrade script. You can continue with the upgrade, but you will have to manually add your characters and users at a later date. You will need to add your user record in the database manually before you will be able to login. Click <strong>Next Step</strong> if you want to continue.';

/*
 * Step 14
 */
$lang['upg_step14_title'] = 'Step 14 - Finalize';
$lang['upg_step14_label'] = 'Step 14: Finalize';
$lang['upg_step14_success'] = "You have successfully upgraded SMS to Nova. You can now login using your email address and the password you set in the SMS config file. Once you've logged in, you'll be able to make changes to the system. All other users will login to the system using the password set in the SMS config file. Click <strong>Login</strong> to continue.";

/*
|---------------------------------------------------------------
| ERRORS
|---------------------------------------------------------------
*/

$lang['error_not_sysadmin_remove'] = 'You must be a system administrator to remove this sim' . RSQUO . 's system data!';

$lang['error_verify_2'] = 'Email address not found, please try again.';
$lang['error_verify_3'] = 'Your password does not match our records, please try again.';
$lang['error_verify_4'] = 'We have found more than one account with your email address. Please contact the game master to resolve this issue.';

$lang['install_error_1'] = 'The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.';
$lang['install_error_2'] = 'You must be a system administrator to change this sim'. RSQUO .'s genre!';
$lang['error_install_no_genre'] = 'You must configure your genre in <strong>applications/config/nova.php</strong>! You cannot continue until you set a genre. Once you have setup a genre, refresh this page to re-run the genre data install.';

/* End of file install_lang.php */
/* Location: ./application/language/english/install_lang.php */