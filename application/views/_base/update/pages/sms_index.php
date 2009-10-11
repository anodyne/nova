<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg);?>

<?php echo form_open('update/sms/1');?>
	<?php echo form_button($next);?>
<?php echo form_close();?>