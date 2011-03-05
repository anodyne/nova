<?php

return array(
	'setup' => array(
		'index' => array(
			'title' => "Nova Setup",
		),
		'config' => array(
			'title' => "Config File Setup",
			'text' => array(
				'exists' => "<p class='fontMedium'>The database connection file already exists in the <code>:appfolder/config</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.</p>",
				'php' => "Your server is running PHP version :php but Nova requires at least PHP 5.2.4.",
				'noconfig' => "Sorry, I need the <code>:modules</code>/assets/database/db.mysql:ext</code> file to work from. Please re-upload the file from the Nova zip archive and try again.",
				'nodb' => "Sorry, I need to have the MySQL extension loaded in order to continue with Nova's installation.",
				'connection' => "Enter your database connection details below. If you're not sure about these, contact your web host.",
				'step0' => "<p class='fontMedium'>Welcome to Nova! Before getting started, I need some information about the database. You'll need to have the following items handy before proceeding:</p><ol><li>The database name</li><li>The database username</li><li>The database password</li><li>The database host</li><li>The table prefix you want to use</li></ol><p class='fontMedium'>In all likelihood, these items were supplied to you by your web host. If you do not have this information, then you will need to contact them before you can continue.</p><p class='fontMedium'><strong>If for any reason this automatic file creation doesn't work, don't worry. All this does is fill in the database information to a configuration file. You can also open <code>:modules/database/config/database.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory if you'd rather not use this wizard.</strong></p>",
				'step2' => array(
					'success'=> "<p class='fontMedium'>Alright sparky! I was able to connect to the database successfully, so now it's time to write the database connection file. If you're ready, click the button below...</p>",
					'nohost' => "<p class='fontMedium'>I couldn't find the database host you provided for your database connection file. Most of the time, web hosts use <strong>localhost</strong>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.</p>",
					'userpass' => "<p class='fontMedium'>The username and/or password you gave me doesn't seem to work. Double check your username and/or password and try again.</p>",
					'dbname' => "<p class='fontMedium'>I was able to connect to the database server (which means your username and password are fine) but I couldn't find the <strong>:dbname</strong> database.</p><ul class='fontMedium'><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:dbname</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <strong>username_:dbname</strong>. Could that be the problem?</li></ul><p class='fontMedium'>If you don't know how to setup a database or your database connection settings, you should <strong>contact your web host</strong>.</p>",
					'gen' => "<p class='fontMedium'>There was an error I couldn't identify when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again.</p>"
				),
				'step3write' => "I was able to successfully write the database connection configuration file. You can start to install Nova now.",
				'step3nowrite' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>database.php</code> in the <code>:appfolder/config</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
				'step4success' => "Alright sparky! You've finally finished. If you're ready, you can click on the button below to head over to the Installation Center and continuing installing Nova...",
				'nova1failure' => "<p class='fontMedium'>Uh oh! You said you wanted to update from Nova 1, but you're trying to use the same database table prefix. Since Nova 3 uses a different database design, you have to select a different table prefix for Nova 3. Make sure you have a new database table prefix and try again.</p>",
			),
		),
	),
);