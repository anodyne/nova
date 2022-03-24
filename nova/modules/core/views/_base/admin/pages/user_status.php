<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($label['text']);?>

<?php echo form_open('user/status');?>
	<p>
		<kbd><?php echo $label['status'];?></kbd>
		<?php echo form_dropdown('status', $values['loa'], $inputs['loa']);?>
	</p>
	<p>
		<kbd><?php echo $label['duration'];?></kbd>
		<?php echo form_textarea($inputs['duration']);?>
	</p>
	<p>
		<kbd><?php echo $label['reason'];?></kbd>
		<?php echo form_textarea($inputs['reason']);?>
	</p><br />
	
	<p><?php echo form_button($buttons['submit']);?></p>
<?php echo form_close();?>