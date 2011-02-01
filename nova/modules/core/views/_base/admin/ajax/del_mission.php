<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('manage/missions/delete/'. $id .'/'. $form);?>
	<?php echo form_hidden('id', $id);?>