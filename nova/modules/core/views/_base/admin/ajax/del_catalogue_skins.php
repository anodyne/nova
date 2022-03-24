<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('site/catalogueskins/skin/delete');?>
	<?php echo form_hidden('id', $id);?>
	<?php echo form_hidden('old_skin', $old_skin);?>
	
	<?php if (isset($sections)): ?>
		<?php foreach ($sections as $section => $s): ?>
			<h4><?php echo ucfirst($section);?></h4>
			<?php echo form_dropdown('change_'.$section, $skins[$section], $default[$section], 'class="hud"');?>
		<?php endforeach;?>
	<?php endif;?>