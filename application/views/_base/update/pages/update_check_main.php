<?php echo $link;?>

<?php if ($label['notes'] > ''): ?>
	<?php echo text_output($label['whatsnew'], 'h2');?>
	<?php echo text_output($label['notes']);?>
	
	<br /><hr /><br />
	
	<?php echo text_output($label['files'], 'h3');?>
	<?php echo text_output($label['files_text']);?>
	<?php echo text_output($label['files_go'], 'p', 'fontMedium bold');?>
	
	<?php echo text_output($label['start'], 'h3');?>
	<?php echo text_output($label['start_text']);?>
	<?php echo text_output($label['start_go'], 'p', 'fontMedium bold');?>
<?php endif;?>