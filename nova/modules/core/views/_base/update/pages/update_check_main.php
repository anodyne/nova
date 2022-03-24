<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if ($label['notes'] > ''): ?>
	<?php echo text_output($label['whatsnew'], 'h2');?>
	<?php echo text_output($label['notes'], 'p', 'fontMedium');?>
<?php endif;?>

<hr />

<a href="<?php echo $label['files_go'];?>" class="install-options">
	<span><?php echo $label['files'];?></span>
	<em><?php echo $label['files_text'];?></em>
</a>

<a href="<?php echo site_url('update/step/1');?>" id="next" class="install-options">
	<span><?php echo $label['start'];?></span>
	<em><?php echo $label['start_text'];?></em>
</a>