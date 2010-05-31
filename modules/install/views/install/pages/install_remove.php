<?php if (!isset($_POST['submit'])): ?>
	<p class="fontMedium"><?php echo $message;?></p>
	
	<hr />
	
	<?php echo form::open('install/remove');?>
		<p>
			<kbd><?php echo __('step1.email');?></kbd>
			<?php echo form::input('email');?>
		</p>
	
		<p>
			<kbd><?php echo __('step1.password');?></kbd>
			<?php echo form::password('password');?>
		</p>
<?php else: ?>
	<p class="fontMedium"><?php echo $message;?></p>
<?php endif;?>