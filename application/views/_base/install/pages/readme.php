<p><strong>Please read this document in its entirety before attempting to install Nova. If you do not understand this document in part or in its entirety, please ask your question in the <a href="http://forums.anodyne-productions.com/" target="_blank">Anodyne Support forums</a> before attempting to install.</strong></p>

<h3>Requirements</h3>

<p>PHP 4.3.2+<br />
MySQL 4.1+<br />
Apache recommended, but should run on any PHP-supported web server<br />
Server running OS X, Linux, UNIX, or Windows (while using a Windows server is supported, we do not recommended it)</p>

<p>If you are new to PHP or website management, you cannot run this system (the files and folders contained within the zip file you just downloaded) on your local machine without a web server installed.  You must have either a hosting provider with the above requirements or a local server (XAMPP, WAMP, MAMP, LAMP, etc.) to install and use Nova. If you are unsure whether your server will allow you to run Nova, you can run the <?php echo anchor('install/verify', 'verification tool');?> before beginning.</p>

<h3>Clean Install Guide</h3>
<p>In order to proceed, you will need the following items:</p>

<ul class="square">
	<li>A webserver with at least 10MB of disk space</li>
	<li>A MySQL database</li>
	<li>Your database connection information you received from your host</li>
	<li>Basic information about the primary character you want to play</li>
</ul>

<p>If you have all this information, you can continue to the <?php echo anchor('install/step/1', 'installation');?> now.</p>

<h3>Upgrade Guide</h3>
<p>Nova does not currently support upgrading from SMS. In future milestones, we&rsquo;ll have a more complete upgrade package. Your site will need to be running the latest version of SMS 2.6 in order to be upgraded. If you do not have the latest version of SMS 2.6 on your site now, we encourage you to start by upgrading it. You will then be able to test the upgrade process with data from your sim&rsquo;s site. More information about upgrades will be available in future milestones.</p>

<p><?php echo anchor('install/index', $label['back'], array('class' => 'fontMedium bold'));?></p>