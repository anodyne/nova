<?php echo text_output($header, 'h2');?>
<?php echo text_output($text);?>

<p>
	<?php echo form_open('site/catalogueskins/section/delete');?>
		<?php echo form_dropdown('new_skin', $skins, '', 'class="hud"');?><br /><br />
		
		<?php echo form_hidden('id', $id);?>
		<?php echo form_hidden('old_skin', $old_skin);?>
		<?php echo form_hidden('section', $section);?>
		<?php echo form_button($inputs['submit']);?>
	<?php echo form_close();?><br />
</p>