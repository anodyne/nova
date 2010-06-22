<p class="fontMedium"><?php echo __("So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables, upgrade all the items you selected from the SMS format to the Nova format and update posts, logs and news to behave properly in Nova. Now, the only thing left to do is update user passwords and set the game master.");?></p>

<hr />

<?php echo form::open('upgrade/step/3');?>
	<h3><?php echo __('New Password');?></h3>
	
	<p class="fontMedium"><?php echo __("Because Nova uses a new method of securiing passwords, I need to reset all of the passwords in the system. Tell me what you want the password to be (and make sure you remember to tell all your users what it is). This password is case-sensitive and users will be prompted to change their password the first time they log in.");?></p>
	
	<p><?php echo form::input('password', 'default');?></p>
	
	<hr />
	
	<h3><?php echo __('Admin Rights');?></h3>
	
	<p class="fontMedium"><?php echo __("Nova uses a role-based system for determining permissions, but since it's incompatible with SMS, you'll need to select the people who should have system administrator privileges. It's best to keep this list as limited as possible right now. You'll be able to add or remove people from roles once Nova is installed. To select multiple users, hold down control and click on the users you want to have system administrator rights.");?></p>
	
	<p><?php echo form::select('admins', $options, NULL, array('multiple' => 'multiple', 'size' => 10));?></p>