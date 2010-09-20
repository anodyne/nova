<?php

return array(
	/**
	 * check for nova updates
	 */
	'updatecheck.start' => "If you've already downloaded the files and made the updates to your system but just need to update your database, you can use the link below to start the process.",
	'updatecheck.getfiles' => "The first thing you'll need to do is download the new Nova files. You can download the files from the Anodyne site. Once you've downloaded the files, follow the directions in the README for updating to the latest version of Nova.",
	
	/**
	 * update step 0
	 */
	'update0.message' => "Alright, time to get started! Start to finish, the update should only take a couple minutes to complete (depending on the speed of your connection and server) and then you'll be on your way. If you have questions, you can refer to the readme that came in the Nova zip archive, check out the <a href='http://docs.anodyne-productions.com' target='_blank'>user guide</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.\r\n\r\nBefore your begin, it's <strong>highly</strong> recommended that you backup both your files and your database. At Anodyne, we make sure to test all of the Nova updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe rather than sorry.\r\n\r\nIf you've backed everything up and you're ready, let's get started...",
	
	/**
	 * update step 1
	 */
	'update1.message' => "That was easy!\r\n\r\nThe update process has finished running and your system has been updated to the latest and greatest version of Nova. If you have any issues with this update, please visit our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a> to report the issue and get help.",
	
	/**
	 * update from nova 1 step 0
	 */
	'nova1_update0.message' => "Updating to Nova 2 is incredibly easy and will only take a few minutes to complete (depending on the speed of your connection and server) and then you'll be on your way and enjoying all the new benefits and features of Nova 2. If you have questions, you can refer to the readme that came in the Nova zip archive, check out the <a href='http://docs.anodyne-productions.com' target='_blank'>user guide</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.\r\n\r\nBefore your begin, it's <strong>highly</strong> recommended that you backup both your files and your database. At Anodyne, we make sure to test all of the Nova updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe rather than sorry.\r\n\r\nIf you've backed everything up and you're ready, you can start by providing the database table prefix for Nova 1 (by default, it was <strong><code>nova_</code></strong>). If you don't know what the database table prefix is, open phpMyAdmin and look at your database. The prefix will be what every table starts with that's the same across all the tables.",
	
	/**
	 * update from nova 1 step 2
	 */
	'nova1_update2.message' => "That was easy!\r\n\r\nThe update process has finished running and you've been upgraded to Nova 2! If you have any issues with this update, please visit our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a> to report the issue and get help. Head on over to your site now and start using Nova 2.",
	
	/**
	 * version checking function
	 */
	'check.files_outofdate' => "Your system files are running version :files, but your database is running version :db. Please update your system files and try again.",
	'check.db_outofdate' => "Your database is running version :db, but your files are running version :files. Please use the link below to update your database.",
	'check.your_version' => " You are running :app :version.",
	'check.update_available' => ":app :version is now available.:extra",
	'check.no_updates' => "There are no updates for :app available right now. Your installation is up-to-date! In the event your server can't check for updates the below links are available to manually run the update if need be.",
);