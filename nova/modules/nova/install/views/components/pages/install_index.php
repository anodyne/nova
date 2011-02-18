<?php if ($installed === false): ?>
	<h3><?php echo ___('Please select from the following options');?>:</h3>
	
	<a href="<?php echo url::site('install/main');?>" class="install-options">
		<span><?php echo ___('Fresh Install');?></span>
		<em><?php echo ___('install.index.fresh');?></em>
	</a>
	
	<a href="<?php echo url::site('update/nova1');?>" class="install-options">
		<span><?php echo ___('Update From Nova 1');?></span>
		<em><?php echo ___('install.index.nova1');?></em>
	</a>
	
	<a href="<?php echo url::site('upgrade/index');?>" class="install-options">
		<span><?php echo ___('Upgrade From SMS 2');?></span>
		<em><?php echo ___('install.index.upgrade');?></em>
	</a>
<?php endif;?>


<?php if ($installed === true): ?>
	<?php if (Auth::is_logged_in()): ?>
		<h3><?php echo ___('Please select from the following options');?>:</h3>
		
		<a href="<?php echo url::site('update/index');?>" class="install-options">
			<span><?php echo ___('Update Nova');?></span>
			<em><?php echo ___('install.index.update');?></em>
		</a>
	
		<a href="<?php echo url::site('install/genre');?>" class="install-options">
			<span><?php echo ___('The Genre Panel');?></span>
			<em><?php echo ___('install.index.genre');?></em>
		</a>
		
		<a href="<?php echo url::site('install/changedb');?>" class="install-options">
			<span><?php echo ___('Database Change Panel');?></span>
			<em><?php echo ___('install.index.db');?></em>
		</a>
		
		<a href="<?php echo url::site('install/remove');?>" class="install-options">
			<span><?php echo ___('Uninstall Nova');?></span>
			<em><?php echo ___('install.index.remove');?></em>
		</a>
	<?php else: ?>
		<h4 class="error"><?php echo ___('install.error.not_logged_in', array(':login' => '<a href="'.url::site('login/index').'">'.___('log in').'</a>'));?></h4>
	<?php endif;?>
<?php endif;?>