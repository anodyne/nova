<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo $msg;?>

<?php echo form_open('update/sms/2');?>
	<?php echo form_button($next);?>
<?php echo form_close();?>