<?php

return array
(
	/**
	 * install errors
	 */
	'install.error.error_1' => "The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.",
	'install.error.error_2' => "You must be a system administrator to change this RPG's genre!",
	'install.error_no_genre' => "I can't find a genre in your Nova config file (<code>:path</code>). Make sure you've specified a genre and try again.",
	
	/**
	 * choose install options
	 */
	'index.fresh_text' => "If you don't already have Nova installed on your server and want to install a clean copy of the system, use this option. Don't try to install the system over top of an existing Nova installation. If you want to re-install Nova, you'll need to uninstall the system first then install it again.",
	'index.upg_text' => "Nova includes an easy-to-use upgrade process that will take the information from a site running SMS 2.6.9 or higher and upgrade it to be usable by Nova. In order to do the upgrade, your SMS database has to be in the same database as where you're installing Nova.",
	'index.upd_text' => "Anodyne is committed to providing continued support for Nova through software updates. If you need to access the Update Center to check for and apply Nova software updates, use this option.",
	'index.genre_text' => "Nova's been built from the ground up with game flexibility in mind and allows you to install one of several genres for your RPG. If you want to install a new genre, use this option. You'll have to make manual adjustments to your characters once the new genre is installed. You must be a system administrator to install a new genre.",
	'index.remove_text' => "If you want to remove all of your current Nova data you can uninstall the system. <strong>Warning:</strong> this action is permanent and cannot be undone! You must be a system administrator to uninstall Nova.",
	'index.db_text' => "If you want to add new database tables or fields to your database, you can use this simple user interface to do so. For advanced operations, please use a MySQL management tool like phpMyAdmin. You must be a system administrator to change the database.",
	
	/**
	 * install landing page
	 */
	'main.text' => "In 2005, Anodyne Productions opened its doors with a simple belief: web software can be both elegant and powerful while still being easy to use.  That principle has guided Anodyne since then and Nova is no exception. Over two years in the making, Nova represents the next evolution in RPG management software with a clean interface, powerful system engine, more robust developer tools and tons of new features that'll make life running or enjoying an RPG better than ever.\r\n\r\nTo get started, first verify your server can run Nova by using the button before or you can select another option from the More Options menu at the top.  From everyone at Anodyne Productions, thank you for choosing Nova as your RPG management tool!",
	
	/**
	 * uninstall nova
	 */
	'remove.message' => "Whoa, hold up! Uninstalling Nova will remove all the data in the database tables (posts, logs, characters, etc.) and cannot be undone, so make absolutely sure you want to do this before continuing...",
	'remove.success' => "Poof! I was able to successfully uninstall Nova. Now, you can go back to the Installation Center to reinstall Nova or upgrade from SMS.",
	
	/**
	 * setup config
	 */
	'setup.nodb' => "Sorry, I need to have the MySQL extension loaded in order to continue with Nova's installation.",
	'setup.no_config_file' => "Sorry, I need the <code>:modules</code>/assets/database/db.mysql:ext</code> file to work from. Please re-upload the file from the Nova zip archive and try again.",
	'setup.config_exists' => "<p class='fontMedium'>The database connection file already exists in the <code>:appfolder</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.</p>",
	'setup.step0_text' => "<p class='fontMedium'>Welcome to Nova! Before getting started, I need some information about the database. You'll need to have the following items handy before proceeding:</p><ol><li>The database name</li><li>The database username</li><li>The database password</li><li>The database host</li><li>The table prefix you want to use</li></ol><p>In all likelihood, these items were supplied to you by your web host. If you do not have this information, then you will need to contact them before you can continue.</p><p class='fontMedium'><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You can also open <code>:modules/database/config/database.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory if you'd rather not use this wizard.</strong></p>",
	'setup.step2_db_host' => "<p class='fontMedium'>I couldn't find the database host you provided for your database connection file. Most of the time, web hosts use <strong>localhost</strong>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.</p>",
	'setup.step2_db_name' => "<p class='fontMedium'>I was able to connect to the database server (which means your username and password are fine) but I couldn't find the <strong>:dbname</strong> database.</p><ul class='fontMedium'><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:dbname</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <strong>username_:dbname</strong>. Could that be the problem?</li></ul><p class='fontMedium'>If you don't know how to setup a database or your database connection settings, you should <strong>contact your web host</strong>.</p>",
	'setup.step2_db_userpass' => "<p class='fontMedium'>The username and/or password you gave me doesn't seem to work. Double check your username and/or password and try again.</p>",
	'setup.step2_db_gen' => "<p class='fontMedium'>There was an error I couldn't identify when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.</p>",
	'setup.step2_success' => "<p class='fontMedium'>All right sparky! I was able to connect to the database successfully, so now it's time to write the database connection file. If you're ready, click the button below...</p>",
	'setup.step3_write' => "I was able to successfully write the database connection configuration file. You can start to install Nova now.",
	'setup.step3_no_write' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
	'setup.step4_success' => "All right sparky! You've finally finished. If you're ready, you can click on the button below to head over to the Installation Center and continuing installing Nova...",
	
	/**
	 * install step 0
	 */
	'step0.inst' => "Alright, time to get started! Nova is a dynamic, database-driven web system which means, you guessed it, I need to install the database now. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the readme that came in the Nova zip archive, check out the <a href='http://docs.anodyne-productions.com' target='_blank'>user guide</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.\r\n\r\nTime to get started now...",
	
	/**
	 * install step 1
	 */
	'step1.success' => "You're pretty good at this! The database tables and some basic data have been created. Now, just fill out the information below and I'll update the system with it...",
	'step1.failure' => "Uh oh! I ran in to a problem trying creating the database and basic data. For starters, make sure all your settings are right and try again. If you still can't install the system, drop us a line at our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a> for more help.",
	'step1.errors' => "Uh oh! I couldn't go to the next step because there are some errors with what you filled in. Check the messages below, make any corrections and give it another try.",
	
	/**
	 * install step 2
	 */
	'step2.message' => "I bet you were expecting more steps, huh? Sorry to disappoint you, but Nova is installed and ready to use. Head on over to your site now to check it out and start using your Nova site.",
	
	/**
	 * server verification
	 */
	'verify.text' => "Below are the results of the server verification test. If any of the items have <strong class='error'>failed</strong>, Nova won't install properly (or at all). If there are any <strong class='warning'>warnings</strong> listed, you should talk to your host about getting those items updated, but you'll still be able to install and use Nova despite the warnings.",
	
	'verify.php_text' => "PHP is the dynamic, web-based language Nova is written in. This version of Nova requires that your server has PHP version :php_req or higher. Unfortunately, your server is only running version :php_act and you won't be able to continue until your host provides access to PHP 5 either through another means or by upgrading the server (all of our testing has been done in PHP 5.3, so we know Nova works really well with that version). When you contact your host, just tell them you need PHP version :php_req or higher and they'll know what that means.",
	
	'verify.db_text' => "Nova is a database-driven system, meaning that without a MySQL database, it won't work. Unfortunately, your database configuration file says you're trying to use a database platform that we don't support. In order to run Nova you need to have a MySQL database and connect either through MySQL or MySQLi. Odds are that you've just mistyped the connection type in the configuration file, so make sure it reads mysql or mysqli. If your host doesn't have MySQL, you won't be able to run Nova.",
	
	'verify.dbver_text' => "Oops, it looks like you're running a version of MySQL that we don't support (:db_act to be exact). Make sure you're running at least MySQL version :db_req otherwise you won't be able to install Nova.",
	
	'verify.reflection_text' => "What's this mean? PHP has a neat little class that's used extensively by Kohana (the framework running Nova) to get all kinds of information about classes. Unfortunately, your server doesn't have this available, so your host has some work to do. In order to continue, contact your host and ask them to enable the Reflection class in PHP. Once that's been done, this error will go away and you'll be able to install Nova.",
	
	'verify.iconv_text' => "What the heck is this? Iconv is a standardized API used to convert text between different character encodings. So why is that important? Kohana, the framework running Nova, relies on this extension being loaded in order to convert strings between different character encodings. Unfortunately, we've detected that your server doesn't have this extension loaded. You can continue, but know that in the event you're doing anything with Kohana's UTF-8 functions, they won't work properly.",
	
	'verify.pcre_text' => "PCRE is a library that PHP uses for regular expression pattern matching that uses the same syntax as Perl. This is one of the requirements for Kohana, the PHP framework running Nova. Since PHP 4.2, PCRE has been enabled by default and beginning with PHP 5.3, PCRE can't be disabled. If you're receiving this notice, your host has intentionally removed PCRE or not compiled it with Unicode and UTF-8 support. So what does that mean exactly? For the average installation, probably nothing unless you start comparing UTF-8 only characters in regular expressions (that includes routes too since the router uses regex to match URIs). In most cases, ignoring this error will be fine.",
	
	'verify.spl_text' => "SPL Autoloading is magic. Literally, it's a magic method in PHP that automatically loads a file necessary for loading PHP classes so that files don't have to be included left and right (trust us, that's a good thing). The good news is that starting in PHP 5, this function is compiled into PHP, so if this test failed, your host did so intentionally. As of PHP 5.3, this function can no longer be turned off. The best thing to do is to talk to your host and get them to turn this back on, because without it, Nova won't work.",
	
	'verify.filters_text' => "",
	
	'verify.mbstring_overloaded_text' => "Uh oh! The mbstring extension is overloading PHP's native string functions.",
	
	'verify.fopen_text' => "Not good. It seems that your web host has disabled PHP's <em>fopen</em> function which both Nova and Kohana need in several spots (Kohana will simply refuse to work in some situations even). In order to continue, you'll need to contact your web host and ask them to turn <em>fopen</em> back on for you. Once that's done, you'll be able to continue with the installation process.",
	
	'verify.fwrite_text' => "It looks like your web host has disabled writing files to the server. Nova uses file writing to build the database connection file for you, but there's no need to worry since the installation process will give you text to copy and paste into the database connection settings file. You can safely continue without this, just be aware of this limitation.",
	
	'verify.success_text' => "Good news! I've verified you can run Nova without any issues so whenever you're ready, click the button below to start the installation process...",
	
	/**
	 * genre panel
	 */
	'genre.message' => "Welcome to the Genre Panel. From here, you can see the status of genres and either install or uninstall genres as needed. Make sure you use great caution when removing genres as it can cause the entire system to break. The only limitation you have is that you cannot uninstall the current genre. If you want to uninstall the current genre, you'll need to change your Nova config file (<code>:path</code>), save and upload the file, then come back here to uninstall that genre.",
	
	/**
	 * change database panel
	 */
	'changedb.message' => "You can use the sections below to modify your database for any changes you'd like to make. You can only add tables and fields, you cannot delete or modify existing tables or fields. In addition, you can only take these actions on Nova's tables, no other tables in your database. <span class='bold red'>Use extreme caution when modifying the database!</span>",
	'changedb.table_inst' => "I can create a new database table for you, all you need to do is tell me what you want to call the table. Don't worry about adding the table prefix, I'll do that for you before I create the table as well as an ID field for you. If you want to change the ID field, you'll have to do that from inside the database.",
	'changedb.field_inst' => "I can create a new database table field for you, all you need to do is tell me a little about the field you want to create and I'll do it for you.",
	'changedb.query_inst' => "I can run any properly formatted MySQL query you have (like something that may have come with a MOD). Simply paste the query into the field below and I'll execute the query. <strong class='error'>MySQL queries can cause a lot of damage to your Nova database so make sure you know you trust whoever gave you the query and understand what the query is trying to do!</strong>",
);