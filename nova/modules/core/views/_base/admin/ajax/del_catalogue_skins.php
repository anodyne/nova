<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('site/catalogueskins/skin/delete');?>
	<?php echo form_hidden('id', $id);?>