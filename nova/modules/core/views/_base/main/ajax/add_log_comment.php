<?php echo text_output($header, 'h2');?>

<?php echo form_open('sim/viewlog/'. $log_id);?>
	<?php echo form_textarea($inputs['comment_text']);?>