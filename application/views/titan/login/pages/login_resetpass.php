<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}?>

<?php echo text_output($header, 'h1', 'page-head');?>

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

	<?php echo form_button($button_submit);?>

	<?php echo anchor('login/index', ucwords(lang('actions_cancel')), 'class="button-sec"');?>
<?php echo form_close();?>