<?php if ($step == 0): ?>
	<?php echo __('setup.step0_text');?>
<?php elseif ($step == 1): ?>
	<p><?php echo __('setup.step1_text');?></p>
	
	<hr />
	
	<?php echo form::open('install/setupconfig/2');?>
		<p>
			<kbd>Database Name</kbd>
			<span class="fontSmall subtle">The name of the database you want to install Nova in</span><br />
			<input type="text" name="dbName" value="nova" />
		</p>
	
		<p>
			<kbd>Username</kbd>
			<span class="fontSmall subtle">Your database username</span><br />
			<input type="text" name="dbUser" value="username" />
		</p>
	
		<p>
			<kbd>Password</kbd>
			<span class="fontSmall subtle">Your database password</span><br />
			<input type="text" name="dbPass" value="password" />
		</p>
	
		<p>
			<kbd>Database Host</kbd>
			<span class="fontSmall subtle">99% chance you won't need to change this...</span><br />
			<input type="text" name="dbHost" value="localhost" />
		</p>
	
		<p>
			<kbd>Table Prefix</kbd>
			<span class="fontSmall subtle">The database table prefix</span><br />
			<input type="text" name="prefix" value="nova_" />
		</p>
<?php elseif ($step == 2): ?>

<?php elseif ($step == 3): ?>

<?php endif;?>