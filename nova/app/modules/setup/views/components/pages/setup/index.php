<?php if ($option <= 4): ?>
	<p>Before we begin, here are a few things you should check out. Make sure you've read and understand the guide for the action you're about to do!</p>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova3/start/install" target="_blank" class="install-secoptions">
		<span class="secoptions-guide">Read the Install Guide</span>
	</a>
	
	<?php if ($option == 2): ?>
		<a href="http://docs.anodyne-productions.com/index.php/nova3/start/upgrade" target="_blank" class="install-secoptions">
			<span class="secoptions-guide">Read the Upgrade Guide</span>
		</a>
	<?php endif;?>
	
	<a href="<?php echo Url::site('setup/main/verify');?>" class="install-secoptions">
		<span class="secoptions-verify">Verify my server can run Nova</span>
	</a>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova3/tour" target="_blank" class="install-secoptions">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
	
	<hr>
	
	<a href="<?php echo Url::site('setup/install/step');?>" class="install-options">
		<span>Fresh Install</span>
		<em>Get up and running with a fresh install of Nova 3 in only a few minutes!</em>
	</a>
	
	<?php if ($option == 2): ?>
		<a href="<?php echo Url::site('setup/upgrade/step');?>" class="install-options">
			<span>Upgrade from Nova 2</span>
			<em>Upgrade your Nova 2 information to the newer Nova 3 format.</em>
		</a>
	<?php elseif ($option == 3): ?>
		<strong class="error">Uh-oh! I noticed you're running a version of Nova 1. Unfortunately, I can't upgrade you from Nova 1 to Nova 3. First, you'll need to upgrade from Nova 1 to Nova 2 and then I'll be able to do the Nova 3 upgrade.</strong>
	<?php endif;?>
	
	<?php if ($option == 4): ?>
		<strong class="error">Uh-oh! I noticed you're running a version of SMS 2. Unfortunately, I can't upgrade you from SMS 2 to Nova 3. First, you'll need to upgrade from SMS 2 to Nova 2 and then I'll be able to do the Nova 3 upgrade.</strong>
	<?php endif;?>
<?php elseif ($option > 4): ?>
	<?php if ($option == 5): ?>
		<p>Before we begin, here are a few things you should check out. Make sure you've read and understand the guide for the action you're about to do!</p>
		
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank" class="install-secoptions">
			<span class="secoptions-guide">Read the Update Guide</span>
		</a>
		
		<a href="<?php echo Url::site('setup/main/verify');?>" class="install-secoptions">
			<span class="secoptions-verify">Verify my server can run Nova</span>
		</a>
		
		<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
			<span class="secoptions-tour">Take a tour of Nova</span>
		</a>
		
		<hr>
		
		<a href="<?php echo Url::site('setup/update/step');?>" class="install-options">
			<span>Update Nova 3</span>
			<em>A newer version of Nova 3 is available. Grab the new copy and start the update!</em>
		</a>
	<?php endif;?>
	
	<?php if ($option > 4): ?>
		<a href="<?php echo Url::site('setup/install/genre');?>" class="install-options">
			<span>The Genre Panel</span>
			<em>Use Nova's flexibile genre system to change your game's genre. <strong>Note:</strong> You'll have to make manual changes to 
				your characters once the new genre is installed (ranks, positions, etc.).</em>
		</a>
		
		<a href="<?php echo Url::site('setup/install/changedb');?>" class="install-options">
			<span>Database Change Panel</span>
			<em>If you have a MOD you're building or installing, you can use this to add new tables or fields to your database without the 
				need to use phpMyAdmin.</em>
		</a>
		
		<a href="<?php echo Url::site('setup/install/remove');?>" class="install-options">
			<span>Uninstall Nova</span>
			<em>Sometimes you just need a fresh start. Nova's uninstallation utility to will let you start from scratch. <strong>Warning:</strong> This action is permanent and cannot be undone!</em>
		</a>
	<?php endif;?>
<?php endif;?>