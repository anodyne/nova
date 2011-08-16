<p>Nova is a dynamic, database-driven content management system. Because of that, in order to run Nova, you'll need Apache, MySQL and PHP installed on your server (or a program like WAMP or MAMP that turns your computer into a local server with those components). If you're unsure whether you'll be able to install and run Nova, you can use the <a href="<?php echo Url::site('setup/main/verify');?>">verification tool</a> before beginning.</p>

<h2>Server Requirements</h2>

<ul class="square">
	<li>PHP 5.3.0 or higher</li>
	<li>MySQL 4.1 or higher</li>
	<li>Apache (recommended, but any PHP-supported web server will work)</li>
	<li>Register globals should be turned off</li>
	<li>Memory limit of 8M or higher</li>
</ul>

<hr>

<a href="#" class="install-options" option="install">
	<span>How do I do a fresh install?</span>
</a>

<div id="content_install" class="hidden">
	<p>If you want to do a fresh install of Nova, you should read the <a href="http://docs.anodyne-productions.com/index.php/nova2/overview/install" target="_blank">install guide</a> before you begin. If you don't understand something in the install guide, you should ask any questions you have on the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne support forums</a> before you attempt to install Nova. If you've read the install guide and are ready to proceed, you'll need the following items:</p>
	
	<ul class="square">
		<li>A webserver with <strong>at least</strong> 15MB of disk space</li>
		<li>A MySQL database</li>
		<li>Your database connection information you received from your host</li>
		<li>Basic information about the primary character you want to play</li>
	</ul>
	
	<p class="fontMedium bold"><a href="<?php echo Url::site('setup/install/step');?>">Start the installation &raquo;</a></p>
</div>

<a href="#" class="install-options" option="upgrade">
	<span>How do I upgrade from SMS?</span>
</a>

<div id="content_upgrade" class="hidden">
	<p>If you want to upgrade from SMS 2 to Nova, you should read the <a href="http://docs.anodyne-productions.com/index.php/nova2/overview/upgrade" target="_blank">upgrade guide</a> before you begin. If you don't understand something in the upgrade guide, you should ask any questions you have on the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne support forums</a> before you attempt to upgrade SMS to Nova. If you've read the upgrade guide and are ready to proceed, you'll need the following items:</p>
	
	<ul class="square">
		<li>A webserver with <strong>at least</strong> 15MB of disk space</li>
		<li>A MySQL database</li>
		<li>An installation of <strong>SMS 2.6.9 or higher</strong> in the same database you're installing Nova to</li>
		<li>Your database connection information you received from your host</li>
	</ul>
	
	<p class="fontMedium bold"><a href="<?php echo Url::site('setup/upgrade/step');?>">Start the upgrade &raquo;</a></p>
</div>

<a href="#" class="install-options" option="update">
	<span>How do I update to the latest version?</span>
</a>

<div id="content_update" class="hidden">
	<p>If you're already running Nova and want to update to the latest version, you should read the <a href="http://docs.anodyne-productions.com/index.php/nova2/overview/update" target="_blank">update guide</a> before you begin. If you don't understand something in the upgrade guide, you should ask any questions you have on the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne support forums</a> before you attempt to update Nova. If you've read the update guide and are ready to proceed, you'll need the following items:</p>
	
	<ul class="square">
		<li>A webserver with <strong>at least</strong> 15MB of disk space</li>
		<li>A MySQL database</li>
		<li>An installation of either <strong>Nova 1.2.4</strong> or <strong>Nova 2.0 or higher</strong></li>
	</ul>
	
	<p class="fontMedium bold"><a href="<?php echo Url::site('setup/update/index');?>">Check for updates &raquo;</a></p>
</div>