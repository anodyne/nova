<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('user/account/'.$id.'/activate');?>
	<?php echo form_hidden('id', $id);?>
	
	<?php if (isset($characters)): ?>
		<?php foreach ($characters as $charid => $name): ?>
			<p>
				<?php $checked = ($charid == $primarychar) ? true : false;?>
				<?php echo form_checkbox('characters[]', $charid, $checked, 'id="'.$charid.'"');?>
				<?php echo form_label($name, $charid);?>
			</p>
		<?php endforeach;?>
	<?php endif;?>