<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1');?>

<?php echo text_output($label['text']);?>

<?php echo form_open('user/status');?>
	<p>
		<label for="status" class="select"><?php echo $label['status'];?></label>
		<?php echo form_dropdown('status', $values['loa'], $inputs['loa'], 'data-native-menu="false" data-inline="true"');?>
	</p>
	<p>
		<label for="duration" class="select"><?php echo $label['duration'];?></label>
		<?php echo form_textarea($inputs['duration']);?>
	</p>
	<p>
		<label for="reason" class="select"><?php echo $label['reason'];?></label>
		<?php echo form_textarea($inputs['reason']);?>
	</p>
	
	<p><?php echo form_button($buttons['submit']);?></p>
<?php echo form_close();?>