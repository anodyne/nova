<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('characters/bio/'.$id.'/makeplaying');?>
	<?php echo form_hidden('id', $id);?>
	
	<?php if (isset($users)): ?>
		<p><?php echo form_dropdown('user', $users, $user, 'class="hud"');?></p>
	<?php endif;?>
	
	<p>
		<?php echo form_checkbox('main_character', 1, false, 'class="hud" id="main_character"');?>
		<?php echo form_label($label['main_character'], 'main_character');?>
	</p>