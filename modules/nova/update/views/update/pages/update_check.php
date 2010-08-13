<p class="fontMedium"><?php echo $message;?></p>

<hr />

<a href="<?php echo url::site('update/step');?>" id="next" class="install-options">
	<span><?php echo __('Get the New Files');?></span>
	<em><?php echo __('updatecheck.getfiles');?></em>
</a>

<a href="<?php echo url::site('update/step');?>" id="next" class="install-options">
	<span><?php echo __('Already Have the Files? Start the Update!');?></span>
	<em><?php echo __('updatecheck.start');?></em>
</a>