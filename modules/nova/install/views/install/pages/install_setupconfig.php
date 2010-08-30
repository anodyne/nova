<?php if ($step == 0): ?>
	<?php echo $message;?>
<?php elseif ($step == 1): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<hr />
	
	<?php echo form::open('install/setupconfig/2');?>
		<p>
			<kbd><?php echo __('Installation Type');?></kbd>
			<span class="fontSmall subtle"><?php echo __('Which type of Nova installation are you going to do?');?></span><br />
			<?php echo form::radio('installType', 'fresh', FALSE, array('id' => 'typeInstall'));?> <label for="typeInstall"><?php echo __('Fresh Install');?></label>
			<?php echo form::radio('installType', 'nova1', FALSE, array('id' => 'typeNova1'));?> <label for="typeNova1"><?php echo __('Update from Nova 1');?></label>
			<?php echo form::radio('installType', 'upgrade', FALSE, array('id' => 'typeUpgrade'));?> <label for="typeUpgrade"><?php echo __('Upgrade from SMS');?></label>
		</p>
		<p>
			<kbd><?php echo __('Database Name');?></kbd>
			<span class="fontSmall subtle"><?php echo __('The name of the database you want me to install Nova into');?></span><br />
			<?php echo form::input('dbName', Session::instance()->get('dbName', 'nova'));?>
		</p>
		<p>
			<kbd><?php echo __('Username');?></kbd>
			<span class="fontSmall subtle"><?php echo __('Your database username');?></span><br />
			<?php echo form::input('dbUser', Session::instance()->get('dbUser', 'username'));?>
		</p>
		<p>
			<kbd><?php echo __('Password');?></kbd>
			<span class="fontSmall subtle"><?php echo __('Your database password');?></span><br />
			<?php echo form::input('dbPass', Session::instance()->get('dbPass', 'password'));?>
		</p>
		<p>
			<kbd><?php echo __('Database Host');?></kbd>
			<span class="fontSmall subtle"><?php echo __("There's a 99% chance you won't need to change this");?></span><br />
			<?php echo form::input('dbHost', Session::instance()->get('dbHost', 'localhost'));?>
		</p>
		<p>
			<kbd><?php echo __('Table Prefix');?></kbd>
			<span class="fontSmall subtle"><?php echo __('The database table prefix I should use');?></span><br />
			<?php echo form::input('prefix', Session::instance()->get('prefix', 'nova_'));?>
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