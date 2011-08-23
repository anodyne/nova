<?php
/**
 * The language file used by the Setup module.
 *
 * @package		Nova
 * @category	I18n
 * @author		Anodyne Productions
 * @copyright	2011 Anodyne Productions
 */

return array(
	'setup' => array(
		
		/**
		 * Database connection file setup.
		 */
		'config' => array(
			'title' => "Config File Setup",
			'text' => array(
				'exists' => "The database connection file already exists in the <code>:appfolder/config</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.",
				'php' => "Your server is running PHP version :php but Nova requires at least PHP 5.3.0.",
				'noconfig' => "Sorry, I need the <code>:modules/assets/database/db.mysql:ext</code> file to work from. Please re-upload the file from the Nova zip archive and try again.",
				'nodb' => "Sorry, I need to have the MySQL extension loaded in order to continue with Nova's installation.",
				'connection' => "Enter your database connection details below. If you're not sure about these, contact your web host.",
				'step0' => "Welcome to the Nova 3 Setup Center! Before getting started, I'll need the following information about your database before we get started:</p><ol><li>The database name</li><li>The database username</li><li>The database password</li><li>The database host</li><li>The table prefix you want to use</li></ol><p>In all likelihood, these items were supplied to you by your web host. If you do not have this information, then you'll need to contact them before you can continue.</p><p><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You can also open <code>:modules/assets/database/db.mysql.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory if you'd rather not use this wizard.</strong>",
				'step2' => array(
					'success'=> "Alright sparky! I was able to successfully connect to the database, so now it's time to write the connection file. If you're ready, click the button below...",
					'nohost' => "I couldn't find the database host you provided for your database connection file. Most of the time, web hosts use <strong>localhost</strong>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.",
					'userpass' => "The username and/or password you gave me doesn't seem to work. Double check your username and/or password and try again.",
					'dbname' => "I was able to connect to the database server (which means your username and password are fine) but I couldn't find the <strong>:dbname</strong> database.</p><ul><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:dbname</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <strong>username_:dbname</strong>. Could that be the problem?</li></ul><p>If you don't know how to setup a database or your database connection settings, you should <strong>contact your web host</strong>.",
					'gen' => "There was an error I couldn't identify when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again."
				),
				'step3write' => "I was able to successfully write the database connection configuration file. You can start to install Nova now.",
				'step3nowrite' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
				'step4success' => "Alright sparky! You've finally finished. If you're ready, you can click on the button below to head over to the Installation Center and continuing installing Nova...",
				'nova1failure' => "Uh oh! You said you wanted to update from Nova 1, but you're trying to use the same database table prefix. Since Nova 3 uses a different database design, you have to select a different table prefix for Nova 3. Make sure you have a new database table prefix and try again.",
			),
		),
		
		/**
		 * Server verification.
		 */
		'verify' => array(
			'intro' => "Below are the results of the server verification test. If any of the items have <strong class='error'>failed</strong>, I won't be able to install Nova properly (or at all). If there are any <strong class='warning'>warnings</strong> listed, you should talk to your host about getting those items updated, but you'll still be able to install and use Nova despite the warnings.",
			'php' => "PHP is the dynamic, web-based language Nova is written in. This version of Nova requires that your server has PHP version :php_req or higher. Unfortunately, your server is only running version :php_act and you won't be able to continue until your host provides access to PHP 5 either through another means or by upgrading the server (all of our testing has been done in PHP 5.3, so we know Nova works really well with that version). When you contact your host, just tell them you need PHP version :php_req or higher and they'll know what that means.",
			'db' => "Nova is a database-driven system, meaning that without a MySQL database, it won't work. Unfortunately, your database configuration file says you're trying to use a database platform that we don't support. In order to run Nova you need to have a MySQL database and connect either through MySQL or MySQLi. Odds are that you've just mistyped the connection type in the configuration file, so make sure it reads mysql or mysqli. If your host doesn't have MySQL, you won't be able to run Nova.",
			'dbversion' => "Oops, it looks like you're running a version of MySQL that we don't support (:db_act to be exact). Make sure you're running at least MySQL version :db_req otherwise you won't be able to install Nova.",
			'reflection' => "What's this mean? PHP has a neat little class that's used extensively by Kohana (the framework running Nova) to get all kinds of information about classes. Unfortunately, your server doesn't have this available, so your host has some work to do. In order to continue, contact your host and ask them to enable the Reflection class in PHP. Once that's been done, this error will go away and you'll be able to install Nova.",
			'iconv' => "What the heck is this? Iconv is a standardized API used to convert text between different character encodings. So why is that important? Kohana, the framework running Nova, relies on this extension being loaded in order to convert strings between different character encodings. Unfortunately, we've detected that your server doesn't have this extension loaded. You can continue, but know that in the event you're doing anything with Kohana's UTF-8 functions, they won't work properly.",
			'pcre' => "PCRE is a library that PHP uses for regular expression pattern matching that uses the same syntax as Perl. This is one of the requirements for Kohana, the PHP framework running Nova. Since PHP 4.2, PCRE has been enabled by default and beginning with PHP 5.3, PCRE can't be disabled. If you're receiving this notice, your host has intentionally removed PCRE or not compiled it with Unicode and UTF-8 support. So what does that mean exactly? For the average installation, probably nothing unless you start comparing UTF-8 only characters in regular expressions (that includes routes too since the router uses regex to match URIs). In most cases, ignoring this error will be fine.",
			'spl' => "SPL Autoloading is magic. Literally, it's a magic method in PHP that automatically loads a file necessary for loading PHP classes so that files don't have to be included left and right (trust us, that's a good thing). The good news is that starting in PHP 5, this function is compiled into PHP, so if this test failed, your host did so intentionally. As of PHP 5.3, this function can no longer be turned off. The best thing to do is to talk to your host and get them to turn this back on, because without it, Nova won't work.",
			'filters' => "",
			'mbstring_overloaded' => "Uh oh! The mbstring extension is overloading PHP's native string functions.",
			'fopen' => "Not good. It seems that your web host has disabled PHP's <em>fopen</em> function which both Nova and Kohana need in several spots (Kohana will simply refuse to work in some situations even). In order to continue, you'll need to contact your web host and ask them to turn <em>fopen</em> back on for you. Once that's done, you'll be able to continue with the installation process.",
			'fwrite' => "It looks like your web host has disabled writing files to the server. Nova uses file writing to build the database connection file for you, but there's no need to worry since the installation process will give you text to copy and paste into the database connection settings file. You can safely continue without this, just be aware of this limitation.",
			'success' => "Good news! I've verified you can run Nova without any issues so whenever you're ready, click the button below to continue the setup process...",
		),
		
		/**
		 * Error messages.
		 */
		'error' => array(
			'1' => "The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.",
			'2' => "You must be a system administrator to change this RPG's genre!",
			'no_genre' => "Uh-oh! I wasn't able to find a genre code in your Nova config file. This can happen if you have created your own genre file, have edited the Nova config file, or you experienced some file corruption with the download. To fix this, open the Nova config file <code>(:path)</code> and add the genre code before trying again.",
			'not_logged_in' => "Oops! You aren't logged in and can't see the install options until you :login.",
		),
		
		/**
		 * Fresh install.
		 */
		'install' => array(
			'step0' => array(
				'instructions' => "Alright, time to get started! Nova is a dynamic, database-driven web system which means, you guessed it, I need to install the database now. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the readme that came in the Nova zip archive, check out the <a href='http://docs.anodyne-productions.com' target='_blank'>user guide</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.\r\n\r\nTime to get started now...",
			),
			'step1' => array(
				'success' => "You're pretty good at this! The database tables and some basic data have been created. Now, just fill out the information below and I'll update the system with it...",
				'failure' => "Uh oh! I ran in to a problem trying creating the database and basic data. For starters, make sure all your settings are right and try again. If you still can't install the system, drop us a line at our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a> for more help.",
				'errors' => "Uh oh! I couldn't go to the next step because there are some errors with what you filled in. Check the messages below, make any corrections and give it another try.",
			),
			'step2' => array(
				'instructions' => "Expecting more steps? Sorry to disappoint you, but Nova is installed and ready to use. Head on over to your site now to get started.",
			),
		),
		
		/**
		 * Nova 2 upgrade.
		 */
		'upgrade' => array(
			'step0' => array(
				'instructions' => "Alright, time to get started! Like Nova 2, Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then upgrade most of your Nova data to the newer Nova 3 format. Start to finish, the upgrade should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to the readme that came in the Nova zip archive, check out the <a href='http://docs.anodyne-productions.com' target='_blank'>user guide</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.\r\n\r\n<strong>Please note:</strong> if your host has imposed limits on the size of your database, you may not be able to upgrade to Nova 3. In order to preserve your original data, the entire database is duplicated. If you have size limits on your database, please make sure the upgrade will not put your over those limitz before you begin.\r\n\r\nTime to get started now...",
			),
			'step1' => array(
				'instructions' => "That was easy!\r\n\r\nThe first thing I needed to do was to rename all of your Nova 2 tables with a new prefix. Why? Doing this allows me to migrate your data to Nova 3 without modifying the original data. If something bad happens, you'll still have a copy of the original information.\r\n\r\nNow that all of your tables have been renamed, it's time to install Nova 3 and start migrating your data over.",
			),
		),
		
		'remove' => array(
			'instructions' => "Whoa, hold up! Uninstalling Nova will remove all the data in the database tables (posts, logs, characters, etc.) and cannot be undone. Make absolutely sure you want to do this before continuing.",
			'success' => "Poof! I was able to successfully uninstall Nova 3. Now, you can go back to the Setup Center to re-install Nova 3 or upgrade from Nova 2.",
			'failure' => "Uh oh! I wasn't able to uninstall Nova 3. Try again or if the problem continues, you can manually remove the database tables from the database.",
			'no_tables' => "I couldn't find a Nova 3 installation to remove.",
		),
		
		'change' => array(
			'default' => "You can use the sections below to modify your database for any changes you'd like to make. You can only add tables and fields, you cannot delete or modify existing tables or fields. In addition, you can only take these actions on Nova's tables, no other tables in your database. <span class='bold error'>Use extreme caution when modifying the database!</span>",
			'query' => "I can run any properly formatted MySQL query you have (like something that may have come with a MOD). Simply paste the query into the field below and I'll execute the query. <strong class='error'>MySQL queries can cause a lot of damage to your Nova database so make sure you trust whoever gave you the query and understand what the query is trying to do!</strong>",
			'field' => "Need a new field in one of the Nova database tables? I can create a new field for you, all you need to do is tell me a little about the field you want to create.",
			'table' => "Need a new database table for a MOD or something cool you're working on? I can create a new database table for you, all you need to do is tell me what you want to call the table. Don't worry about adding the table prefix, I'll do that before creating the table as well as an ID field for you. If you want to change the ID field, you'll have to do that from inside the database.",
		),
	),
);
