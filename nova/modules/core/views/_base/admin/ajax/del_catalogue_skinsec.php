<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('site/catalogueskins/section/delete');?>
	<?php echo form_dropdown('new_skin', $skins, '', 'class="hud"');?>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('old_skin', $old_skin);?>
	<?php echo form_hidden('section', $section);?>