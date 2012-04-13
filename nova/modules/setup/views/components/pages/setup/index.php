<?php if ($option == 1): ?>
	<p>Doing a fresh install of Nova 3 will put an empty installation of Nova into the database you specified when you set up your database connection. Using the features included in Nova 3, you'll be able to add new missions, posts, personal logs, announcements, ranks, positions, and much more.</p>
	
	<p>The links below provide information about how to install Nova 3 as well as a brief tour of some of Nova's major features. If you have additional questions, please visit the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne forums</a> for more help.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 3 Installation Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
<?php elseif ($option == 2): ?>
	<p>Since you're already running Nova 2, you can upgrade directly to Nova 3 and migrate all of your game's data to Nova 3. From start to finish, the entire process shouldn't take too long (probably around 10 minutes depending on your Internet connection). Go ahead and choose from the options below or click <strong>Start Upgrade</strong> to get going.</p>
	
	<p class="alert alert-info"><strong>Note:</strong> Make sure you've read the upgrade guide and have a backup of your files and database before you get started.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 2 &rarr; Nova 3 Upgrade Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
<?php elseif ($option == 3): ?>
	<p>It isn't enough to just release powerful, easy-to-use software, you also need to maintain it. Our goal is to continually make Nova better than it was before, be it fixing bugs or adding new features. The best way to make sure you're getting the most out of Nova is to keep up with the updates that we release.</p>
	
	<p>The links below provide information about how to update Nova 3 as well as the changelog for Nova. If you have additional questions, please visit the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne forums</a> for more help.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 3 Update Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-history">See what's changed</span>
	</a>
	
	<hr>
	
	<h2><?php echo $update->version;?></h2>
	
	<p><?php echo $update->description;?></p>
<?php elseif ($option == 4): ?>
	<dl>
		<dt><a href="<?php echo Uri::create('setup/update/index');?>" class="btn-alt"><span class="secoptions-update">Update Nova</span></a></dt>
		<dd>Stay up to date with updates to Nova that fix bugs and add functionality. Even if your server doesn't allow for checking for updates, you can start the update process from here and be up and running on the latest version of Nova in only a few minutes.</dd>
		
		<dt><a href="<?php echo Uri::create('setup/utility/genre');?>" class="btn-alt"><span class="secoptions-genre">The Genre Panel</span></a></dt>
		<dd>Nova has a flexible genre system that allows the system to be used for a wide range of games. Using the Genre Panel you can change your game's genre to one of the other provided genres. <strong>Be warned:</strong> if you change the genre, you'll likely have to do a healthy amount of manual work to change your characters to have the proper positions and ranks.</dd>
		
		<dt><a href="<?php echo Uri::create('setup/utility/database');?>" class="btn-alt"><span class="secoptions-database">Database Change Panel</span></a></dt>
		<dd>Nova's structure allows for creating MODs that modify existing functionality, or sometimes, even add whole new sets of features. Some of the MODs you may encounter may require changes to the database. Using the Database Change Panel, you can make those changes quickly and easily with a simple user interface. <strong>Be warned:</strong> you're still modifying the database, so use caution and always make sure you have a backup!</dd>
		
		<dt><a href="<?php echo Uri::create('setup/utility/remove');?>" class="btn-alt"><span class="secoptions-remove">Uninstall Nova</span></a></dt>
		<dd>If you want to completely uninstall Nova, you can do so with the uninstall option. <strong>Be warned:</strong> this action is permanent and cannot be undone. You will lose all data in the Nova database. Make sure this is what you want to do and that you have a backup before uninstalling. Also note that this will not delete any Nova files.</dd>
	</dl>
<?php elseif ($option == 5): ?>
	<p>It looks like you're running Nova 1 on your site right now. Unfortunately, there's no direct upgrade path from Nova 1 to Nova 3. In order to get up and running (with all of your Nova 1 data) on Nova 3, you'll need to first update from Nova 1 to Nova 2. Once you're done with that (you don't need to worry about MOD/skin updates) you'll be able to upgrade from Nova 2 to Nova 3.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 1 &rarr; Nova 3 Upgrade Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
<?php endif;?>