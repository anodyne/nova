<?php echo text_output($header, 'h2');?>
<?php echo text_output($text);?>

<p>
	<?php echo form_open('admin/index');?>
		<?php echo form_password($inputs['password']);?><br /><br />
		<?php echo form_button($inputs['submit']);?>
		
		<?php echo form_hidden('user', $user);?>
		<?php echo form_hidden('action', 'password_change');?>
	<?php echo form_close();?><br />
</p>