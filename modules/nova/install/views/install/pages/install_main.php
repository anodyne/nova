<h2><?php echo __('Welcome to :app_name!', array(':app_name' => Kohana::config('nova.app_name')));?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo __("First Steps");?></h2>

<a href="<?php echo url::site('install/verify');?>" class="install-secoptions">
	<span class="secoptions-verify"><?php echo __('Verify my server can run Nova');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/overview/install" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo __('Read the Install Guide');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
	<span class="secoptions-tour"><?php echo __('Take a tour of Nova');?></span>
</a><br />

<h2 class="page-subhead"><?php echo __("What's Next?");?></h2>

<a href="<?php echo url::site('install/step');?>" class="install-secoptions">
	<span class="secoptions-go"><?php echo __('Begin Nova Installation');?></span>
</a>

<a href="<?php echo url::site('install/index');?>" class="install-secoptions">
	<span class="secoptions-back"><?php echo __('Back to Install Options');?></span>
</a>