<p><?php echo __('verify.text');?></p>

<hr />

<?php echo $table;?>

<style type="text/css">
	.install-notification {
		border: 1px solid #cd0a0a;
		background: #ef2d2d url('../images/install-btn-bg.png') repeat-x 0 0;
		
		border-radius: 6px;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
	}
	.left-band {
		float: left;
		width: 20px;
	}
	.notify-content {
		padding: .5em 1em;
		
		border-radius: 6px;
		-moz-border-radius: 6px;
		-webkit-border-radius: 6px;
	}
</style>

<div class="flash-message flash-error">
	<h1>PHP</h1>
	<p><?php echo __('verify.php_text', array(':php_req' => '5.2.4', ':php_act' => PHP_VERSION));?></p><br />
	
	<h1>Database Type</h1>
	<p><?php echo __('verify.db_text');?></p><br />
	
	<h1>MySQL Version</h1>
	<p><?php echo __('verify.dbver_text', array(':db_req' => '4.1'));?></p><br />
	
	<h1>Reflections Class</h1>
	<p><?php echo __('verify.reflections_text');?></p><br />
	
	<h1>Iconv Filter</h1>
	<p><?php echo __('verify.iconv_text');?></p><br />
</div>

<div class="flash-message flash-info">
	<h1>Register Globals</h1>
	<p>Uh oh! We noticed that your server has enabled the Register Globals feature. While you'll still be able to use Nova with Register Globals turned on, it can be a security risk, so you'll want to talk to your host about turning Reigster Globals off as soon as possible!</p><br />
	
	<h1>File Handling</h1>
	<p>There are a couple of places in Nova where we need to do some work with files, but we noticed that your server doesn't support the file handling functions. Nova will still work without it, but to get the full Nova experience, you should talk to your host about turning the file handling features on. Without file handling turned on, Nova can't check for updates, so you'll need to manually check for those updates at the Anodyne Productions website.</p>
</div>