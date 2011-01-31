<?php if ($step == 0): ?>
	<?php echo $message;?>
<?php elseif ($step == 1): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<hr />
	
	<?php echo form_open('install/setupconfig/2');?>
		<p>
			<kbd>Database Name</kbd>
			<span class="fontSmall gray">The name of the database you want me to install Nova into</span><br />
			<?php echo form_input('dbName', 'nova');?>
		</p>
		<p>
			<kbd>Username</kbd>
			<span class="fontSmall gray">Your database username</span><br />
			<?php echo form_input('dbUser', 'username');?>
		</p>
		<p>
			<kbd>Password</kbd>
			<span class="fontSmall gray">Your database password</span><br />
			<?php echo form_input('dbPass');?>
		</p>
		<p>
			<kbd>Database Host</kbd>
			<span class="fontSmall gray">There's a 99% chance you won't need to change this</span><br />
			<?php echo form_input('dbHost', 'localhost');?>
		</p>
		<p>
			<kbd>Table Prefix</kbd>
			<span class="fontSmall gray">The database table prefix I should use</span><br />
			<?php echo form_input('prefix', 'nova_');?>
		</p>
<?php elseif ($step == 2): ?>
	<p class="fontMedium"><?php echo $message;?></p>
<?php elseif ($step == 3): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<?php if (isset($code)): ?>
		<hr />
		
		<pre><?php echo $code;?></pre>
	<?php endif;?>
<?php elseif ($step == 4): ?>
	<p class="fontMedium"><?php echo $message;?></p>
<?php endif;?>