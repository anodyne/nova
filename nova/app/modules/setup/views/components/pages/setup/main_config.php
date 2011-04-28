<?php if ($step == 0): ?>
	<p><?php echo $message;?></p>
<?php elseif ($step == 1): ?>
	<p><?php echo $message;?></p>
	
	<hr>
	
	<?php echo Form::open('setup/main/config/2');?>
		<p>
			<kbd>Database Name</kbd>
			<span class="fontSmall subtle">The name of the database you want me to install Nova into</span><br>
			<?php echo Form::input('dbName', Session::instance()->get('dbName', 'nova'));?>
		</p>
		<p>
			<kbd>Username</kbd>
			<span class="fontSmall subtle">Your database username</span><br>
			<?php echo Form::input('dbUser', Session::instance()->get('dbUser', 'username'));?>
		</p>
		<p>
			<kbd>Password</kbd>
			<span class="fontSmall subtle">Your database password</span><br>
			<?php echo Form::input('dbPass', Session::instance()->get('dbPass', 'password'));?>
		</p>
		<p>
			<kbd>Database Host</kbd>
			<span class="fontSmall subtle">There's a 99% chance you won't need to change this</span><br>
			<?php echo Form::input('dbHost', Session::instance()->get('dbHost', 'localhost'));?>
		</p>
		<p>
			<kbd>Table Prefix</kbd>
			<span class="fontSmall subtle">The database table prefix I should use</span><br>
			<?php echo Form::input('prefix', Session::instance()->get('prefix', 'nova_'));?>
		</p>
<?php elseif ($step == 2): ?>
	<p><?php echo $message;?></p>
<?php elseif ($step == 3): ?>
	<p><?php echo $message;?></p>
	
	<?php if (isset($code)): ?>
		<hr>
		
		<pre><?php echo $code;?></pre>
	<?php endif;?>
<?php elseif ($step == 4): ?>
	<p><?php echo $message;?></p>
<?php endif;?>