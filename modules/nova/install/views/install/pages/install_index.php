<h3><?php echo __('index.choose');?></h3>

<?php if ($installed === FALSE): ?>
	<a href="<?php echo url::site('install/main');?>" class="install-options">
		<span><?php echo __('index.fresh_title');?></span>
		<em><?php echo __('index.fresh_text');?></em>
	</a>
	
	<a href="<?php echo url::site('upgrade/index');?>" class="install-options">
		<span><?php echo __('index.upg_title');?></span>
		<em><?php echo __('index.upg_text');?></em>
	</a>
<?php endif;?>


<?php if ($installed === TRUE): ?>
	<a href="<?php echo url::site('update/index');?>" class="install-options">
		<span><?php echo __('index.upd_title');?></span>
		<em><?php echo __('index.upd_text');?></em>
	</a>

	<a href="<?php echo url::site('install/genre');?>" class="install-options">
		<span><?php echo __('index.genre_title');?></span>
		<em><?php echo __('index.genre_text');?></em>
	</a>
	
	<a href="<?php echo url::site('install/changedb');?>" class="install-options">
		<span><?php echo __('index.db_title');?></span>
		<em><?php echo __('index.db_text');?></em>
	</a>
	
	<a href="<?php echo url::site('install/remove');?>" class="install-options">
		<span><?php echo __('index.remove_title');?></span>
		<em><?php echo __('index.remove_text');?></em>
	</a>
<?php endif;?>