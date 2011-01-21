<?php echo text_output($header, 'h2');?>

<?php echo form_open('sim/viewpost/'. $post_id);?>
	<?php echo form_textarea($inputs['comment_text']);?>