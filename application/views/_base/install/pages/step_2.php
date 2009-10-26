<?php echo text_output($label['inst_step2']);?>

<br />
<?php echo form_open('install/step/3');?>
	<?php echo form_button($next);?>
<?php echo form_close();?>