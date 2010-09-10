<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?><br />

<p>
	<?php echo form_open('manage/comments/'. $type .'/'. $status .'/'. $page .'/delete');?>
		<?php echo form_hidden('id', $id);?>
		<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?><br />
</p>