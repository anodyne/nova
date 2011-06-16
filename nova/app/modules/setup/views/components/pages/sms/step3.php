<p>So how about a little update? So far, I've been able to create all of the Nova database tables, put the basic data into the tables, upgrade all the items you selected from the SMS format to the Nova format and update posts, logs and news to behave properly in Nova. Now, the only thing left to do is update user passwords and set the game master.</p>

<p>Once you've finished the upgrade, there are a few things you'll want to do. First, make sure you deactivate the upgrade module from the Modules Catalogue in the Admin Control Panel so that the upgrade can't be run again. Second, make sure you set a security question and answer from your account page in case you need to reset your password. Finally, make sure to contact your players and remind them to set a security question and answer as well.</p>

<hr>

<?php echo Form::open('main/index');?>
	<h3>New Password</h3>
	
	<p>Because Nova uses a new method of securing passwords, I need to reset all of the passwords in the system. Tell me what you want the password to be and I'll update all the users then send an email to all active users with the new password. This password is case-sensitive and users will be prompted to change their password the first time they log in.</p>
	
	<p>
		<?php echo Form::input('password', 'default');?> &nbsp;
		
		<span class="hidden loading-password"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
		
		<span class="hidden error-password">
			<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
		</span>
		
		<span class="hidden success-password">
			<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?>
		</span>
	</p>
	
	<hr />
	
	<h3>Admin Rights</h3>
	
	<p>Nova uses a role-based system for determining permissions, but since it's incompatible with SMS, you'll need to select the people who should have system administrator privileges. It's best to keep this list as limited as possible right now. You'll be able to add or remove people from roles once Nova is installed. To select multiple users, hold down control and click on the users you want to have system administrator rights.</p>
	
	<p>
		<?php echo Form::select('admins', $options, null, array('multiple' => 'multiple', 'size' => 10, 'style' => 'width:500px'));?> &nbsp;
		
		<span class="hidden loading-admins"><?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/loading.gif');?></span>
		
		<span class="hidden error-admins">
			<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/exclamation-red.png', array('class' => 'tiptip', 'title' => ''));?>
		</span>
		
		<span class="hidden success-admins">
			<?php echo Html::image(MODFOLDER.'/app/modules/setup/views/design/images/tick-circle.png');?>
		</span>
	</p>