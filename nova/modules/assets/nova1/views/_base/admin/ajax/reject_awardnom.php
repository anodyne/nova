<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?><br />

<?php echo form_open($form);?>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('action', 'reject');?>
	<?php echo form_button($inputs['submit']);?>
<?php echo form_close();?><br />