<h3><?php echo __('Please select from the following options');?>:</h3>

<?php if ($installed === FALSE): ?>
	<a href="<?php echo url::site('install/main');?>" class="install-options">
		<span><?php echo __('Fresh Install');?></span>
		<em><?php echo __('index.fresh_text');?></em>
	</a>
	
	<a href="<?php echo url::site('upgrade/index');?>" class="install-options">
		<span><?php echo __('Upgrade From SMS 2');?></span>
		<em><?php echo __('index.upg_text');?></em>
	</a>
<?php endif;?>


<?php if ($installed === TRUE): ?>
	<a href="<?php echo url::site('update/index');?>" class="install-options">
		<span><?php echo __('Update Nova');?></span>
		<em><?php echo __('index.upd_text');?></em>
	</a>

	<a href="<?php echo url::site('install/genre');?>" class="install-options">
		<span><?php echo __('The Genre Panel');?></span>
		<em><?php echo __('index.genre_text');?></em>
	</a>
	
	<a href="<?php echo url::site('install/changedb');?>" class="install-options">
		<span><?php echo __('Database Change Panel');?></span>
		<em><?php echo __('index.db_text');?></em>
	</a>
	
	<a href="<?php echo url::site('install/remove');?>" class="install-options">
		<span><?php echo __('Uninstall Nova');?></span>
		<em><?php echo __('index.remove_text');?></em>
	</a>
<?php endif;?>