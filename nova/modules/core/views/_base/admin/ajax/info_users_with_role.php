<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php if (isset($list)): ?>
	<?php foreach ($list as $l): ?>
		<strong><?php echo $l;?></strong><br />
	<?php endforeach;?>
<?php else: ?>
	<h4 class="orange"><?php echo $label['notfound'];?></h4>
<?php endif;?>