<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('site/roles/delete');?>
	<?php echo form_dropdown('new_role', $values['roles'], '', 'class="hud"');?>
	<?php echo form_hidden('id', $id);?>