<h2><?php echo __('main.title');?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo __("First Steps");?></h2>

<a href="<?php echo url::site('install/verify');?>" class="install-secoptions">
	<span class="secoptions-verify"><?php echo __('main.options_verify');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/overview/install" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo __('main.options_guide');?></span>
</a>

<a href="http://docs.anodyne-productions.com/index.php/nova/tour" target="_blank" class="install-secoptions">
	<span class="secoptions-tour"><?php echo __('main.options_tour');?></span>
</a><br />

<h2 class="page-subhead"><?php echo __("What's Next?");?></h2>

<a href="<?php echo url::site('install/step');?>" class="install-secoptions">
	<span class="secoptions-go"><?php echo __('main.options_install');?></span>
</a>

<a href="<?php echo url::site('install/index');?>" class="install-secoptions">
	<span class="secoptions-back"><?php echo __('Back to Install Options');?></span>
</a>