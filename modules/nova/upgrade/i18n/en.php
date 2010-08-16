<?php

return array
(
	/**
	 * upgrade step 1
	 */
	'step1.text' => "Nova gives you the ability to upgrade only the items you want from SMS. Using the list below, please select which items you want Nova to upgrade from the SMS format to the Nova format.",
	
	/**
	 * upgrade step 2
	 */
	'step2.text' => "So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables and put all the data from the items you selected into the Nova tables. Now, I need to upgrade a bunch of that data to the Nova format.",
	
	/**
	 * upgrade step 3
	 */
	'step3.text' => "So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables, upgrade all the items you selected from the SMS format to the Nova format and update posts, logs and news to behave properly in Nova. Now, the only thing left to do is update user passwords and set the game master.",
	'step3.passwords' => "Because Nova uses a new method of securing passwords, I need to reset all of the passwords in the system. Tell me what you want the password to be (and make sure you remember to tell all your users what it is). This password is case-sensitive and users will be prompted to change their password the first time they log in.",
	'step3.admin' => "Nova uses a role-based system for determining permissions, but since it's incompatible with SMS, you'll need to select the people who should have system administrator privileges. It's best to keep this list as limited as possible right now. You'll be able to add or remove people from roles once Nova is installed. To select multiple users, hold down control and click on the users you want to have system administrator rights.",
);