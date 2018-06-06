<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<h2>Server Requirements</h2>

<ul class="square">
	<li>PHP 5.1 or higher</li>
	<li>MySQL 4.1 or higher</li>
	<li>Apache (recommended, but any PHP-supported web server will work)</li>
	<li>Register globals should be turned off</li>
	<li>Memory limit of 8M or higher</li>
</ul>

<p>If you are new to PHP or website management, you cannot run Nova on your local machine without a web server installed.  You must have either a hosting provider with the above requirements or a local server (XAMPP, WAMP, MAMP, LAMP, etc.) to install and use Nova. If you are unsure whether your server will allow you to run Nova, you can run the <?php echo anchor('install/verify', 'verification tool');?> before beginning.</p>

<h2>Clean Install Guide</h2>

<p>If you want to do a fresh install of Nova, you should read the <a href="https://help.anodyne-productions.com/article/nova-2/install" target="_blank">install guide</a> before you begin. If you don't understand something in the install guide, you should ask any questions you have on the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne support forums</a> before you attempt to install Nova. If you've read the install guide and are ready to proceed, you'll need the following items:</p>

<ul class="square">
	<li>A webserver with at least 10MB of disk space</li>
	<li>A MySQL database</li>
	<li>Your database connection information you received from your host</li>
	<li>Basic information about the primary character you want to play</li>
</ul>

<p class="fontMedium bold"><?php echo anchor('install/step/1', 'Go to Step 1 &raquo;');?></p>

<h2>Upgrade Guide</h2>

<p>If you want to upgrade from SMS 2 to Nova, you should read the <a href="https://help.anodyne-productions.com/article/nova-1/upgrade" target="_blank">upgrade guide</a> before you begin. If you don't understand something in the upgrade guide, you should ask any questions you have on the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne support forums</a> before you attempt to upgrade SMS to Nova. If you've read the upgrade guide and are ready to proceed, you'll need the following items:</p>

<ul class="square">
	<li>A webserver with at least 10MB of disk space</li>
	<li>A MySQL database</li>
	<li>An installation of SMS <?php echo SMS_UPGRADE_VERSION;?> in the same database you're installing Nova</li>
	<li>Your database connection information you received from your host</li>
</ul>

<p class="fontMedium bold"><?php echo anchor('upgrade/index', 'Go to the Upgrade Center &raquo;');?></p>
