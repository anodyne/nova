<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('manage/depts/duplicate/unassigned');?>
	<?php echo form_hidden('id', $id);?>