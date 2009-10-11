<?php echo text_output($header, 'h2');?>
<?php echo text_output($text);?>

<p>
	<?php echo form_open('admin/change_password/');?>
		<?php echo form_hidden('user', $user);?>
		<?php echo form_textarea($inputs['comment_text']);?><br /><br />
		<?php echo form_button($inputs['comment_button']);?>
	<?php echo form_close();?><br />
</p>