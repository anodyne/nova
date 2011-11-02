<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'site/messages', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<?php echo text_output($msg_credits_perm);?>

<br /> <hr /> <br />

<?php echo text_output($msg_credits);?>