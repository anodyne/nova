<?php if ($option <= 6): ?>
	<p>Before we begin, here are a few things you should check out. Make sure you've read and understand the guide for the action you're about to do!</p>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova/overview/install" target="_blank" class="install-secoptions">
		<span class="secoptions-guide">Read the Install Guide</span>
	</a>
	
	<?php if ($option == 2): ?>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank" class="install-secoptions">
			<span class="secoptions-guide">Read the Nova 2 Upgrade Guide</span>
		</a>
	<?php endif;?>
	
	<?php if ($option == 3): ?>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank" class="install-secoptions">
			<span class="secoptions-guide">Read the Nova 1 Upgrade Guide</span>
		</a>
	<?php endif;?>
	
	<?php if ($option == 5): ?>
		<a href="http://docs.anodyne-productions.com/index.php/nova/overview/upgrade" target="_blank" class="install-secoptions">
			<span class="secoptions-guide">Read the SMS Upgrade Guide</span>
		</a>
	<?php endif;?>
	
	<a href="<?php echo Url::site('setup/main/verify');?>" class="install-secoptions">
		<span class="secoptions-verify">Verify my server can run Nova</span>
	</a>
	
	<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
	
	<hr>
	
	<a href="<?php echo Url::site('setup/install/step');?>" class="install-options">
		<span>Fresh Install</span>
		<em>Get up and running with a fresh install of Nova 3 in only a few minutes!</em>
	</a>
	
	<?php if ($option == 2): ?>
		<a href="<?php echo Url::site('setup/nova2/step');?>" class="install-options">
			<span>Upgrade from Nova 2</span>
			<em>Upgrade your Nova 2 information to the newer Nova 3 format.</em>
		</a>
	<?php elseif ($option == 3): ?>
		<a href="<?php echo Url::site('setup/nova1/step');?>" class="install-options">
			<span>Upgrade from Nova 1</span>
			<em>Upgrade your Nova 1 information to the newer Nova 3 format.</em>
		</a>
	<?php elseif ($option == 4): ?>
		<strong class="error">You have an older version of Nova and need to update to at least version 1.2.4 in order to upgrade to Nova 3.</strong>
	<?php endif;?>
	
	<?php if ($option == 5): ?>
		<a href="<?php echo Url::site('setup/sms/step');?>" class="install-options">
			<span>Upgrade from SMS 2</span>
			<em>Upgrade your SMS information to the newer Nova 3 format.</em>
		</a>
	<?php elseif ($option == 6): ?>
		<strong class="error">You have an older version of SMS and need to update to at least version 2.6.9 in order to upgrade to Nova 3.</strong>
	<?php endif;?>
<?php elseif ($option > 6): ?>
	<?php if ($option == 7): ?>
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
	
	<?php if ($option == 8): ?>
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
			<em>If you want to start over, you can remove all of your current Nova data. <strong>Warning:</strong> This action is permanent 
				and cannot be undone!</em>
		</a>
	<?php endif;?>
<?php endif;?>