<?php echo text_output($label['choose'], 'h3');?>

<a href="<?php echo site_url('install/main');?>" class="install-options">
	<span><?php echo $label['title_fresh'];?></span>
	<em><?php echo $label['text_fresh'];?></em>
</a>

<a href="<?php echo site_url('upgrade/index');?>" class="install-options">
	<span><?php echo $label['title_upg'];?></span>
	<em><?php echo $label['text_upg'];?></em>
</a>

<a href="<?php echo site_url('update/index');?>" class="install-options">
	<span><?php echo $label['title_upd'];?></span>
	<em><?php echo $label['text_upd'];?></em>
</a>