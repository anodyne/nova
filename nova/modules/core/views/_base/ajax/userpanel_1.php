<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($name, 'h4');?>

<ul class="padding1 fontSmall">
	<li><?php echo anchor('user/account', $label['edit_account']);?></li>
	<li><?php echo anchor('user/options', $label['edit_prefs']);?></li>
	<li><?php echo anchor('user/status', $label['request_loa']);?></li>
	<li><?php echo anchor('messages/index', $label['private_messages'] . $count);?></li>
</ul>