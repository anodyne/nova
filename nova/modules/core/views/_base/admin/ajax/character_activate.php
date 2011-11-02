<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('characters/bio/'.$id.'/activate');?>
	<?php echo form_hidden('id', $id);?>
	
	<?php if (isset($users)): ?>
		<?php if ( ! $active_user): ?>
			<p>
				<?php echo form_checkbox('activate_user', 1, true, 'class="hud" id="activate_user"');?>
				<?php echo form_label($label['activate_user'], 'activate_user');?>
			</p>
		<?php endif;?>
		<p><?php echo form_dropdown('user', $users, $current_user, 'class="hud"');?></p>
		<p>
			<?php echo form_checkbox('primary', 1, $maincharacter, 'class="hud" id="primary"');?>
			<?php echo form_label($label['make_primary'], 'primary');?>
		</p>
	<?php endif;?>