<?php echo text_output($header, 'h2');?>

<?php echo text_output($text);?>

<?php if (isset($list)): ?>
	<?php foreach ($list as $l): ?>
		<strong><?php echo $l;?></strong><br />
	<?php endforeach;?>
<?php else: ?>
	<?php echo lang_output('error_no_users', 'h4', 'orange');?>
<?php endif;?>