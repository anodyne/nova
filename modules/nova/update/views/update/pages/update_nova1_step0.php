<p class="fontMedium"><?php echo $message;?></p>

<hr />

<?php echo form::open('update/nova1/1');?>
	<p>
		<kbd><?php echo __("Nova 1 Database Prefix");?></kbd>
		<span class="fontSmall subtle"><?php echo __('What is the database prefix of your Nova 1 database tables?');?></span><br />
		<?php echo form::input('nova1prefix');?>
	</p>