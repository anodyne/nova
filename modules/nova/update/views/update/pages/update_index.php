<h2><?php echo __('Welcome to Nova!');?></h2>

<p class="fontMedium"><?php echo nl2br(__('main.text'));?></p>

<hr />

<h2 class="page-subhead"><?php echo __('First Steps');?></h2>
	
<a href="http://docs.anodyne-productions.com/index.php/nova2/update" target="_blank" class="install-secoptions">
	<span class="secoptions-guide"><?php echo __('Read the Update Guide');?></span>
</a><br />

<h2 class="page-subhead"><?php echo __("What's Next?");?></h2>

<a href="<?php echo url::site('update/check');?>" class="install-secoptions">
	<span class="secoptions-update"><?php echo __('Check for Updates');?></span>
</a>

<a href="<?php echo url::site('install/index');?>" class="install-secoptions">
	<span class="secoptions-back"><?php echo __('Back to Install Options');?></span>
</a>