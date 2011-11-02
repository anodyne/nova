<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['text'], 'p', 'fontMedium');?>

<hr />

<?php echo form_open('update/check');?>
	<p>
		<kbd><?php echo $label['email'];?></kbd>
		<?php echo form_input($inputs['email']);?>
	</p>
	<p>
		<kbd><?php echo $label['password'];?></kbd>
		<?php echo form_password($inputs['password']);?>
	</p>