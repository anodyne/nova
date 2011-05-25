<?php

return array(
	'change' => array(
		'title' => array(
			'addtable' => "Add Database Table",
			'addfield' => "Add Database Field",
			'runquery' => "Run a MySQL Query",
			'default' => "Change Database",
		),
		'text' => array(
			'addtable' => "I can create a new database table for you, all you need to do is tell me what you want to call the table. Don't worry about adding the table prefix, I'll do that for you before I create the table as well as an ID field for you. If you want to change the ID field, you'll have to do that from inside the database.",
			'addfield' => "I can create a new database table field for you, all you need to do is tell me a little about the field you want to create and I'll do it for you.",
			'runquery' => "I can run any properly formatted MySQL query you have (like something that may have come with a MOD). Simply paste the query into the field below and I'll execute the query. <strong class='error'>MySQL queries can cause a lot of damage to your Nova database so make sure you know you trust whoever gave you the query and understand what the query is trying to do!</strong>",
			'default' => "You can use the sections below to modify your database for any changes you'd like to make. You can only add tables and fields, you cannot delete or modify existing tables or fields. In addition, you can only take these actions on Nova's tables, no other tables in your database. <span class='bold error'>Use extreme caution when modifying the database!</span>",
		),
		'back' => "Back to Change Database Panel",
	),
	
	'install' => array(
		'remove' => array(
			'message' => "Whoa, hold up! Uninstalling Nova will remove all the data in the database tables (posts, logs, characters, etc.) and cannot be undone, so make absolutely sure you want to do this before continuing...",
			'success' => "Poof! I was able to successfully uninstall Nova. Now, you can go back to the Installation Center to reinstall Nova or upgrade from SMS."
		),
		'error' => array(
			'error_1' => "The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.",
			'error_2' => "You must be a system administrator to change this RPG's genre!",
			'no_genre' => "I can't find a genre in your Nova config file (<code>:path</code>). Make sure you've specified a genre and try again.",
			'not_logged_in' => "Oops! You aren't logged in and can't see the install options until you :login.",
		),
	),
	
	/**
	 * genre panel
	 */
	'genre.message' => "Welcome to the Genre Panel. From here, you can see the status of genres and either install or uninstall genres as needed. Make sure you use great caution when removing genres as it can cause the entire system to break. The only limitation you have is that you cannot uninstall the current genre. If you want to uninstall the current genre, you'll need to change your Nova config file (<code>:path</code>), save and upload the file, then come back here to uninstall that genre.",
);