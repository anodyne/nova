<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($whats_new);?>

<br /><hr /><br />

<div id="accordion">
	<?php echo $full_changes;?>
</div>