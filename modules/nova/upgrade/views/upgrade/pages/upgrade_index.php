<h2><?php echo __('main.title');?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<?php if ($installed === TRUE): ?>
	<hr />
	
	<h2 class="page-subhead"><?php echo __('First Steps');?></h2>
	
	<a href="<?php echo url::site('upgrade/verify');?>" class="install-secoptions">
		<span class="secoptions-verify"><?php echo __('Verify my server can run Nova');?></span>
	</a>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova2/tour" target="_blank" class="install-secoptions">
		<span class="secoptions-tour"><?php echo __('Take a tour of Nova');?></span>
	</a>
	
	<a href="<?php echo url::site('upgrade/readme');?>" class="install-secoptions">
		<span class="secoptions-readme"><?php echo __('View the Nova readme');?></span>
	</a>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova2/overview/upgrade" target="_blank" class="install-secoptions">
		<span class="secoptions-guide"><?php echo __('Read the Upgrade Guide');?></span>
	</a>
	
	<?php if ($installed === TRUE): ?>
		<a href="<?php echo url::site('install/remove');?>" class="install-secoptions">
			<span class="secoptions-remove"><?php echo __('Uninstall Nova');?></span>
		</a>
	<?php endif;?>
	
	<h2 class="page-subhead"><?php echo __("What's Next?");?></h2>
	
	<?php if ($installed === FALSE): ?>
		<a href="<?php echo url::site('upgrade/step');?>" class="install-secoptions">
			<span class="secoptions-go"><?php echo __('Start the Upgrade');?></span>
		</a>
		
		<a href="<?php echo url::site('install/main');?>" class="install-secoptions">
			<span class="secoptions-go"><?php echo __('Nova Fresh Install');?></span>
		</a>
	<?php endif;?>
	
	<?php if ($installed === TRUE): ?>
		<a href="<?php echo url::site('update/index');?>" class="install-secoptions">
			<span class="secoptions-update"><?php echo __('Update Nova');?></span>
		</a>
		
		<a href="<?php echo url::site('install/genre');?>" class="install-secoptions">
			<span class="secoptions-genre"><?php echo __('Install additional genres');?></span>
		</a>
		
		<a href="<?php echo url::site('install/changedb');?>" class="install-secoptions">
			<span class="secoptions-database"><?php echo __('Add your own database tables/fields');?></span>
		</a>
	<?php endif;?>
<?php endif;?>