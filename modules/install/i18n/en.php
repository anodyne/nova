<?php

return array
(
	'install.global.more_options' => 'More Options',
	
	/** install errors **/
	'install.error.no_genre' => "You must configure your genre in <strong>applications/config/nova.php</strong>! You cannot continue until you set a genre. Once you have setup a genre, refresh this page to re-run the genre data install.",
	'install.error.error_1' => "The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.",
	'install.error.error_2' => "You must be a system administrator to change this sim's genre!",
	
	/** choose install options **/
	'index.label' => 'Installation Center',
	'index.title' => 'Install Center',
	'index.choose' => 'Please select from the following options:',
	'index.fresh_title' => 'Fresh Install',
	'index.fresh_text' => "If you don't already have Nova installed on your server and want to install a clean copy of the system, use this option. Don't try to install the system over top of an existing Nova installation. If you want to re-install Nova, you'll need to uninstall the system first then install it again.",
	'index.upg_title' => 'Upgrade From SMS 2',
	'index.upg_text' => "Nova includes an easy-to-use upgrade process that will take the information from a site running SMS 2.6.9 or higher and upgrade it to be usable by Nova. In order to do the upgrade, your SMS database has to be in the same database as where you're installing Nova.",
	'index.upd_title' => 'Update Nova',
	'index.upd_text' => "Anodyne is committed to providing continued support for Nova through software updates. If you need to access the Update Center to check for and apply Nova software updates, use this option.",
	'index.genre_title' => 'Install a New Genre',
	'index.genre_text' => "Nova's been built from the ground up with game flexibility in mind and allows you to install one of several genres for your RPG. If you want to install a new genre, use this option. You'll have to make manual adjustments to your characters once the new genre is installed. You must be a system administrator to install a new genre.",
	'index.remove_title' => 'Uninstall Nova',
	'index.remove_text' => "If you want to remove all of your current Nova data you can uninstall the system. <strong>Warning:</strong> this action is permanent and cannot be undone! You must be a system administrator to uninstall Nova.",
	'index.db_title' => 'Add New Database Tables/Fields',
	'index.db_text' => "If you want to add new database tables or fields to your database, you can use this simple user interface to do so. For advanced operations, please use a MySQL management tool like phpMyAdmin. You must be a system administrator to change the database.",
	
	/** main landing page **/
	'main.text' => "In 2005, Anodyne Productions opened its doors with a simple belief: web software can be both elegant and powerful while still being easy to use.  That principle has guided Anodyne since then and Nova is no exception. Over two years in the making, Nova represents the next evolution in RPG management software with a clean interface, powerful system engine, more robust developer tools and tons of new features that'll make life running or enjoying an RPG better than ever.\r\n\r\nTo get started, first verify your server can run Nova by using the button before or you can select another option from the More Options menu at the top.  From everyone at Anodyne Productions, thank you for choosing Nova as your RPG management tool!",
	'main.title' => 'Welcome to Nova!',
	'main.options_first_steps' => 'First Steps',
	'main.options_tour' => 'Take a tour of Nova',
	'main.options_readme' => 'View the Nova readme',
	'main.options_verify' => 'Verify my server can run Nova',
	'main.options_guide' => 'Read the Install Guide',
	'main.options_remove' => 'Uninstall Nova',
	'main.options_whats_next' => "What's Next?",
	'main.options_install' => 'Begin Nova Installation',
	'main.options_genre' => 'Install additional genres',
	'main.options_database' => 'Add your own tables/fields to the database',
	
	/** readme **/
	'readme.title' => 'Readme',
	'readme.label' => 'Nova Readme',
	
	/** setup config **/
	'setup.title' => "Config File Setup",
	'setup.nodb' => "Sorry, I need to have either PDO (PHP Data Objects) or the MySQL extension loaded in order to continue with Nova's installation.",
	'setup.no_config_file' => "Sorry, I need both the <code>:modules/database/assets/db.pdo:ext</code> and <code>:modules</code>/database/assets/db.mysql:ext</code> files to work from. Please re-upload these files from the Nova zip archive and try again.",
	'setup.config_exists' => "<p class='fontMedium'>The database connection file already exists in the <code>:appfolder</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.</p>",
	'setup.php_version' => "Your server is running PHP version :php but Nova requires at least PHP 5.2.4.",
	'setup.step0_text' => "<p class='fontMedium'>Welcome to Nova! Before getting started, I need some information about the database. You'll need to have the following items handy before proceeding:</p><ol><li>The database name</li><li>The database username</li><li>The database password</li><li>The database host</li><li>The table prefix you want to use</li></ol><p>In all likelihood, these items were supplied to you by your web host. If you do not have this information, then you will need to contact them before you can continue.</p><p class='fontMedium'><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You can also open <code>:modules/database/config/database.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory if you'd rather not use this wizard.</strong></p>",
	'setup.step1_text' => "Enter your database connection details below. If you're not sure about these, contact your web host.",
	'setup.step1_conntype' => 'Connection Type',
	'setup.step1_conntype_desc' => "How I should connect to the database &ndash; you shouldn't need to change this",
	'setup.step1_dbname' => 'Database Name',
	'setup.step1_dbname_desc' => "The name of the database you want me to install Nova in",
	'setup.step1_dbuser' => 'Username',
	'setup.step1_dbuser_desc' => "Your database username",
	'setup.step1_dbpass' => 'Password',
	'setup.step1_dbpass_desc' => "Your database password",
	'setup.step1_dbhost' => 'Database Host',
	'setup.step1_dbhost_desc' => "There's a 99% chance you won't need to change this",
	'setup.step1_prefix' => 'Table Prefix',
	'setup.step1_prefix_desc' => "The database table prefix I should use",
	'setup.pdo' => "MySQL through PDO",
	'setup.mysql' => "Legacy MySQL",
	'setup.step2_db_host' => "<p class='fontMedium'>I couldn't find the database host you provided for your database connection file. Most of the time, web hosts use <strong>localhost</strong>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.</p>",
	'setup.step2_db_name' => "<p class='fontMedium'>I was able to connect to the database server (which means your username and password are fine) but I couldn't find the <strong>:dbname</strong> database.</p><ul class='fontMedium'><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:dbname</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <strong>username_:dbname</strong>. Could that be the problem?</li></ul><p class='fontMedium'>If you don't know how to setup a database or your database connection settings, you should <strong>contact your web host</strong>.</p>",
	'setup.step2_db_userpass' => "<p class='fontMedium'>The username and/or password you gave me doesn't seem to work. Double check your username and/or password and try again.</p>",
	'setup.step2_db_gen' => "<p class='fontMedium'>There was an error I couldn't identify when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.</p>",
	'setup.step2_write_file' => 'Write the Database Connection File',
	'setup.step2_start_over' => "Start Over",
	'setup.step2_success' => "<p class='fontMedium'>All right sparky! I was able to connect to the database successfully, so now it's time to write the database connection file. If you're ready, click the button below...</p>",
	'setup.step3_write' => "I was able to successfully write the database connection configuration file. You can start to install Nova now.",
	'setup.step3_no_write' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
	'setup.step3_install' => "Go to the Installation Center",
	'setup.step3_retest' => "Re-Test Database Connection",
	'setup.step4_success' => "All right sparky! You've finally finished. If you're ready, you can click on the button below to head over to the Installation Center and continuing installing Nova...",
	
	/** step 1 **/
	'step1.title' => 'Step 1 - Create Database Tables',
	'step1.label' => 'Step 1: Database Structure',
	'step1.success' => "You have successfully created the database structure needed by Nova! The next step will insert some basic data into your newly created database tables for use by Nova. Click <strong>Next Step</strong> to continue.",
	'step1.failure' => "There was a problem creating the database structure. Please make sure all your settings in your config file are correct and try again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.",
	
	/** step 2 **/
	'step2.title' => 'Step 2 - Insert Basic Data',
	'step2.label' => 'Step 2: Basic Data',
	'step2.success' => "You have successfully inserted the basic system data into your database. The next step will insert all of the genre-specific data into your database. Click <strong>Next Step</strong> to continue.",
	'step2.failure' => "There was a problem inserting all of the basic data into your database. Please clear your database tables and try again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.",
	
	/** step 3 **/
	'step3.title' => 'Step 3 - Insert Genre Data',
	'step3.label' => 'Step 3: User Account &amp; Character',
	'step3.success' => "You have successfully inserted the genre data into your database. Please use the fields below to create your user profile and main character. You will be able to edit the character bio and your account once installation is complete and you have logged in to the system. Once you are finished, click <strong>Next Step</strong> to continue.",
	'step3.failure' => "There was a problem inserting all of the genre data into your database. Please clear your database tables and try again. If you have created the genre file yourself, please make sure the file is formatted correctly and you don't have any syntax errors. If you are using an Anodyne-created genre file, try installing again. If the problem persists, please contact <a href='http://forums.anodyne-productions.com' target='_blank'>Anodyne Productions</a> for additional support.",
	'step3.form.user' => 'User Information',
	'step3.form.name' => 'Real Name',
	'step3.form.dob' => 'Date of Birth',
	'step3.form.character' => 'Character Information',
	'step3.form.fname' => 'First Name',
	'step3.form.lname' => 'Last Name',
	'step3.form.rank' => 'Rank',
	'step3.form.position' => 'Position',
	'step3.form.timezone' => 'Select Your Timezone',
	'step3.form.question' => 'Security Question',
	'step3.form.answer' => 'Answer',
	'step3.form.remember_security_answer' => 'Remember your security answer exactly as you type it!',
	
	/** server verification **/
	'verify.component' => 'Component',
	'verify.required' => 'Required',
	'verify.actual' => 'Actual',
	'verify.result' => 'Result',
	'verify.php' => 'PHP',
	'verify.db' => 'Database Platform',
	'verify.db_version' => 'Database Version',
	'verify.mem' => 'Memory Limit',
	'verify.regglobals' => 'Register Globals',
	'verify.file' => 'File Handling',
	'verify.reflection' => 'Reflection Enabled',
	'verify.filters' => 'Filters Enabled',
	'verify.iconv' => 'Iconv Extension',
	'verify.success' => '<strong class="success">Success</strong>',
	'verify.failure' => '<strong class="error">Failed</strong>',
	'verify.warning' => '<strong class="warning">Warning</strong>',
	'verify.title' => 'Verify Server Requirements',
	'verify.text' => "Below are the results of the server verification test. If any of the items have <strong class='error'>failed</strong>, Nova won't install properly (or at all). If there are any <strong class='warning'>warnings</strong> listed, you should talk to your host about getting those items updated, but you'll still be able to install and use Nova despite the warnings.",
	
	'verify.php_text' => "PHP is the dynamic, web-based language Nova is written in. This version of Nova requires that your server has PHP version :php_req or higher. Unfortunately, your server is only running version :php_act and you won't be able to continue until your host provides access to PHP 5 either through another means or by upgrading the server (all of our testing has been done in PHP 5.3, so we know Nova works really well with that version). When you contact your host, just tell them you need PHP version :php_req or higher and they'll know what that means.",
	
	'verify.db_text' => "Nova is a database-driven system, meaning that without a MySQL database, it won't work. Unfortunately, your database configuration file says you're trying to use a database platform that we don't support. In order to run Nova you need to have a MySQL database and connect either through MySQL or MySQLi. Odds are that you've just mistyped the connection type in the configuration file, so make sure it reads mysql or mysqli. If your host doesn't have MySQL, you won't be able to run Nova.",
	
	'verify.dbver_text' => "Oops, it looks like you're running a version of MySQL that we don't support (:db_act to be exact). Make sure you're running at least MySQL version :db_req otherwise you won't be able to install Nova.",
	
	'verify.reflection_text' => "What's this mean? PHP has an important Reflections class that is used by Kohana, the framework running Nova, to get all kinds of information about classes, functions and extensions. Unfortunately, your server doesn't have this available, so your host has some work to do. In order to continue, contact your host and ask them to enable the Reflection class in PHP. Once that's been done, this error will go away and you'll be able to install Nova.",
	
	'verify.iconv_text' => "What the heck is this? Iconv is a standardized API used to convert text between different character encodings. So why is that important? Kohana, the framework running Nova, relies on this extension being loaded in order to convert strings between different character encodings. Unfortunately, we've detected that your server doesn't have this extension loaded. You can continue, but know that in the event you're doing anything with Kohana's UTF-8 functions, they won't work properly.",
	
	'verify.pcre_text' => "PCRE is a library that PHP uses for regular expression pattern matching that uses the same syntax as Perl. This is one of the requirements for Kohana, the PHP framework running Nova. Since PHP 4.2, PCRE has been enabled by default and beginning with PHP 5.3, PCRE can't be disabled. If you're receiving this notice, your host has intentionally removed PCRE or not compiled it with Unicode and UTF-8 support. So what does that mean exactly? For the average installation, probably nothing unless you start comparing UTF-8 only characters in regular expressions (that includes routes too since the router uses regex to match URIs). In most cases, ignoring this error will be fine.",
	
	'verify.spl_text' => "SPL Autoloading is magic. Literally, it's a magic method in PHP that automatically loads a file necessary for loading PHP classes so that files don't have to be included left and right (trust us, that's a good thing). The good news is that starting in PHP 5, this function is compiled into PHP, so if this test failed, your host did so intentionally. As of PHP 5.3, this function can no longer be turned off. The best thing to do is to talk to your host and get them to turn this back on, because without it, Nova won't work.",
	
	'verify.filters_text' => "",
);