<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('characters/bio/'.$id.'/deactivate');?>
	<?php echo form_hidden('id', $id);?>
	
	<?php if ( ! $has_characters): ?>
		<p>
			<?php echo form_checkbox('deactivate_user', 1, true, 'class="hud" id="deactivate_user"');?>
			<?php echo form_label($label['deactivate_user'], 'deactivate_user');?>
		</p>
	<?php endif;?>
	
	<?php if (isset($characters)): ?>
		<p><?php echo form_dropdown('main_character', $characters, null, 'class="hud"');?></p>
	<?php endif;?>