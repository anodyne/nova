<h2><?php echo __('Welcome to Nova!');?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo __('First Steps');?></h2>

<a href="<?php echo url::site('upgrade/verify');?>" class="install-secoptions">
	<span class="secoptions-verify"><?php echo __('Verify my server can run Nova');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova2/overview/upgrade" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo __('Read the Upgrade Guide');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova2/tour" target="_blank" class="install-secoptions">
	<span class="secoptions-tour"><?php echo __('Take a tour of Nova');?></span>
</a><br />

<h2 class="page-subhead"><?php echo __("What's Next?");?></h2>

<a href="<?php echo url::site('upgrade/step');?>" class="install-secoptions">
	<span class="secoptions-go"><?php echo __('Start the Upgrade');?></span>
</a>

<a href="<?php echo url::site('install/index');?>" class="install-secoptions">
	<span class="secoptions-back"><?php echo __('Back to Install Options');?></span>
</a>