<?php echo text_output($header, 'h2');?>
<?php echo text_output($text);?>

<p>
	<?php echo form_open('wiki/view/revert/'. $page);?>
		<?php echo form_hidden('page', $page);?><br />
		<?php echo form_hidden('draft', $draft);?><br />
		<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?><br />
</p>