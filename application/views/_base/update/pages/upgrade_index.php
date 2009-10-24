<?php if ($status > 0): ?>
	<?php echo text_output($label['status_'. $status], 'p', 'red bold fontMedium');?>
<?php endif; ?>

<?php if ($status == 0): ?>
	<?php echo $label['text'];?>
	<br />
	<?php echo form_open('upgrade/step/1');?>
		<?php echo form_button($next);?>
	<?php echo form_close();?>
<?php endif;?>