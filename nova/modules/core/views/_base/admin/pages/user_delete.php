<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo form_open('user/delete');?>

<?php echo text_output($labels['confirm'], 'p');?>

<p><?php echo form_button($buttons['confirm']);?></p>

<?php echo form_close();?>
