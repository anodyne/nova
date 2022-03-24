<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if ($step == 0): ?>
	<?php echo $message;?>
<?php elseif ($step == 1): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<hr />
	
	<?php echo form_open('install/setupconfig/2');?>
		<p>
			<kbd>Database Name</kbd>
			<span class="fontSmall gray">The name of the database you want me to install Nova into</span><br />
			<?php $value = ( ! $this->session->userdata('dbName')) ? 'nova' : $this->session->userdata('dbName');?>
			<?php echo form_input('dbName', $value);?>
		</p>
		<p>
			<kbd>Username</kbd>
			<span class="fontSmall gray">Your database username</span><br />
			<?php $value = ( ! $this->session->userdata('dbUser')) ? 'username' : $this->session->userdata('dbUser');?>
			<?php echo form_input('dbUser', $value);?>
		</p>
		<p>
			<kbd>Password</kbd>
			<span class="fontSmall gray">Your database password</span><br />
			<?php echo form_input('dbPass');?>
		</p>
		<p>
			<kbd>Database Host</kbd>
			<span class="fontSmall gray">There's a 99% chance you won't need to change this</span><br />
			<?php $value = ( ! $this->session->userdata('dbHost')) ? 'localhost' : $this->session->userdata('dbHost');?>
			<?php echo form_input('dbHost', $value);?>
		</p>
		<p>
			<kbd>Table Prefix</kbd>
			<span class="fontSmall gray">The database table prefix I should use</span><br />
			<?php $value = ( ! $this->session->userdata('prefix')) ? 'nova_' : $this->session->userdata('prefix');?>
			<?php echo form_input('prefix', $value);?>
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