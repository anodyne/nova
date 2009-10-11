<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($message, 'p', 'fontMedium');?><br />

<?php echo form_open('login/reset_password');?>

	<p>
		<?php echo text_output($label['email'], 'strong', 'fontMedium');?><br />
		<?php echo form_input($inputs['email']);?>
	</p>
	
	<p>
		<?php echo text_output($label['question'], 'strong', 'fontMedium');?><br />
		<?php echo form_dropdown('question', $questions);?>
	</p>
	
	<p>
		<?php echo text_output($label['answer'], 'strong', 'fontMedium');?><br />
		<?php echo form_input($inputs['answer']);?>
	</p>
	
	<br /><p>
		<?php echo form_button($button_submit);?>
	</p>
<?php echo form_close();?>