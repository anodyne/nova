<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg);?>

<p>&nbsp;</p>

<?php echo form_open('main/join');?>
	<?php echo form_hidden('agree', 'yes');?>
	
	<?php if (isset($position)): ?>
		<?php echo form_hidden('position', $position);?>
	<?php endif; ?>
	
	<p><?php echo form_button($button['agree']);?></p>
<?php echo form_close();?>