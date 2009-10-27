<?php echo text_output($label['inst_step2']);?>

<?php if (GENRE == ''): ?>
	<?php echo lang_output('error_install_no_genre', 'p', 'bold red');?>	
<?php else: ?>
	<br />
	<?php echo form_open('install/step/3');?>
		<?php echo form_button($next);?>
	<?php echo form_close();?>
<?php endif; ?>