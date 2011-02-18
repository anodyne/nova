<h2><?php echo ___('Welcome to :app_name!', array(':app_name' => Kohana::config('novasys.app_name')));?></h2>

<p class="fontMedium"><?php echo nl2br(___('install.main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo ___("First Steps");?></h2>

<a href="<?php echo url::site('install/verify');?>" class="install-secoptions">
	<span class="secoptions-verify"><?php echo ___('Verify my server can run Nova');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/overview/install" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo ___('Read the Install Guide');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
	<span class="secoptions-tour"><?php echo ___('Take a tour of Nova');?></span>
</a><br />

<h2 class="page-subhead"><?php echo ___("What's Next?");?></h2>

<a href="<?php echo url::site('install/step');?>" class="install-secoptions">
	<span class="secoptions-go"><?php echo ___('Begin Nova Installation');?></span>
</a>

<a href="<?php echo url::site('install/index');?>" class="install-secoptions">
	<span class="secoptions-back"><?php echo ___('Back to Install Options');?></span>
</a>