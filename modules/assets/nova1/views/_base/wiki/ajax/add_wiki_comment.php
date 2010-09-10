<?php echo text_output($header, 'h2');?>
<p>
	<?php echo form_open('wiki/view/page/'. $id .'/comment');?>
		<?php echo form_textarea($inputs['comment_text']);?><br /><br />
		<?php echo form_button($inputs['comment_button']);?>
	<?php echo form_close();?><br />
</p>