<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php echo form_open('admin/index');?>
	<?php echo form_password($inputs['password']);?>
	<?php echo form_hidden('user', $user);?>
	<?php echo form_hidden('action', 'password_change');?>