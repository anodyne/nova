<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($message, 'p');?><br />

<?php echo form_open('login/reset_password');?>

	<p>
		<?php echo text_output($label['email'], 'kbd');?>
		<?php echo form_input($inputs['email']);?>
	</p>
	
	<p>
		<?php echo text_output($label['question'], 'kbd');?>
		<?php echo form_dropdown('question', $questions);?>
	</p>
	
	<p>
		<?php echo text_output($label['answer'], 'kbd');?>
		<?php echo form_input($inputs['answer']);?>
	</p>
	
	<br /><p>
		<?php echo form_button($button_submit);?>
	</p>
<?php echo form_close();?>