<?php echo text_output($label['inst_step1']);?>

<p><?php echo form_button($test);?></p>

<?php echo form_open('install/step/2');?>
	<?php echo form_button($next);?>
<?php echo form_close();?>