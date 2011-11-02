<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($label['choose'], 'h3');?>

<?php if ($installed === FALSE): ?>
	<a href="<?php echo site_url('install/main');?>" class="install-options">
		<span><?php echo $label['title_fresh'];?></span>
		<em><?php echo $label['text_fresh'];?></em>
	</a>

	<a href="<?php echo site_url('upgrade/index');?>" class="install-options">
		<span><?php echo $label['title_upg'];?></span>
		<em><?php echo $label['text_upg'];?></em>
	</a>
<?php endif;?>

<?php if ($installed === TRUE): ?>
	<a href="<?php echo site_url('update/index');?>" class="install-options">
		<span><?php echo $label['title_upd'];?></span>
		<em><?php echo $label['text_upd'];?></em>
	</a>

	<a href="<?php echo site_url('install/genre');?>" class="install-options">
		<span><?php echo $label['title_genre'];?></span>
		<em><?php echo $label['text_genre'];?></em>
	</a>
	
	<a href="<?php echo site_url('install/changedb');?>" class="install-options">
		<span><?php echo $label['title_db'];?></span>
		<em><?php echo $label['text_db'];?></em>
	</a>
	
	<a href="<?php echo site_url('install/remove');?>" class="install-options">
		<span><?php echo $label['title_remove'];?></span>
		<em><?php echo $label['text_remove'];?></em>
	</a>
	
	<a href="<?php echo site_url('main/index');?>" class="install-options">
		<span><?php echo $label['title_site'];?></span>
	</a>
<?php endif;?>