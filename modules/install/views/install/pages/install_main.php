<h2><?php echo __('main.title');?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo __('main.options_first_steps');?></h2>

<a href="<?php echo url::site('install/verify');?>" class="install-secoptions">
	<span class="secoptions-verify"><?php echo __('main.options_verify');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
	<span class="secoptions-tour"><?php echo __('main.options_tour');?></span>
</a>

<a href="<?php echo url::site('install/readme');?>" class="install-secoptions">
	<span class="secoptions-readme"><?php echo __('main.options_readme');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/overview/install" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo __('main.options_guide');?></span>
</a>

<?php if ($installed === TRUE): ?>
	<a href="<?php echo url::site('install/remove');?>" class="install-secoptions">
		<span class="secoptions-remove"><?php echo __('main.options_remove');?></span>
	</a>
<?php endif;?>

<h2 class="page-subhead"><?php echo __('main.options_whats_next');?></h2>

<?php if ($installed === FALSE): ?>
	<a href="<?php echo url::site('install/step/1');?>" class="install-secoptions">
		<span class="secoptions-go"><?php echo __('main.options_install');?></span>
	</a>
	
	<a href="<?php echo url::site('upgrade/index');?>" class="install-secoptions">
		<span class="secoptions-go"><?php echo __('index.upg_title');?></span>
	</a>
<?php endif;?>

<?php if ($installed === TRUE): ?>
	<a href="<?php echo url::site('update/index');?>" class="install-secoptions">
		<span class="secoptions-update"><?php echo __('index.upd_title');?></span>
	</a>
	
	<a href="<?php echo url::site('install/genre');?>" class="install-secoptions">
		<span class="secoptions-genre"><?php echo __('main.options_genre');?></span>
	</a>
	
	<a href="<?php echo url::site('install/changedb');?>" class="install-secoptions">
		<span class="secoptions-database"><?php echo __('main.options_database');?></span>
	</a>
<?php endif;?>