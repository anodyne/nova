<?php if ($enabled === true): ?>
	<br>
	
	<?php echo form::open('login/reset');?>
		<p>
			<kbd><?php echo ucwords(__('email address'));?></kbd>
			<?php echo form::input('email', false, array('type' => 'email'));?>
		</p>
		<p>
			<kbd><?php echo ucwords(__('security question'));?></kbd>
			<?php echo form::select('question', $questions);?>
		</p>
		<p>
			<kbd><?php echo ucwords(__('security answer'));?></kbd>
			<?php echo form::input('answer');?>
		</p>
		<br />
		
		<p>
			<?php echo form::button('submit', ucfirst(__("submit")), $button['submit']);?>
		</p>
	<?php echo form::close();?>
<?php endif;?>