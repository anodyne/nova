<?php if ($step == 0): ?>
	<?php echo $message;?>
<?php elseif ($step == 1): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<hr />
	
	<?php echo form::open('install/setupconfig/2');?>
		<p>
			<kbd><?php echo __('setup.step1_dbname');?></kbd>
			<span class="fontSmall subtle"><?php echo __('setup.step1_dbname_desc');?></span><br />
			<?php echo form::input('dbName', Session::Instance()->get('dbName', 'nova'));?>
		</p>
	
		<p>
			<kbd><?php echo __('setup.step1_dbuser');?></kbd>
			<span class="fontSmall subtle"><?php echo __('setup.step1_dbuser_desc');?></span><br />
			<?php echo form::input('dbUser', Session::Instance()->get('dbUser', 'username'));?>
		</p>
	
		<p>
			<kbd><?php echo __('setup.step1_dbpass');?></kbd>
			<span class="fontSmall subtle"><?php echo __('setup.step1_dbpass_desc');?></span><br />
			<?php echo form::input('dbPass', Session::Instance()->get('dbPass', 'password'));?>
		</p>
	
		<p>
			<kbd><?php echo __('setup.step1_dbhost');?></kbd>
			<span class="fontSmall subtle"><?php echo __('setup.step1_dbhost_desc');?></span><br />
			<?php echo form::input('dbHost', Session::Instance()->get('dbHost', 'localhost'));?>
		</p>
	
		<p>
			<kbd><?php echo __('setup.step1_prefix');?></kbd>
			<span class="fontSmall subtle"><?php echo __('setup.step1_prefix_desc');?></span><br />
			<?php echo form::input('prefix', Session::Instance()->get('prefix', 'nova_'));?>
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