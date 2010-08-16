<p class="fontMedium"><?php echo $message;?></p>

<?php if (isset($changes) && count($changes) > 0): ?>
	<hr />
	
	<p class="fontMedium">
		<?php echo __('The following changes have been made since Nova :version (your current version of the system):', array(':version' => $version));?>
	</p>
	
	<?php foreach ($changes as $key => $c): ?>
		<?php echo $c;?>
	<?php endforeach;?>
<?php endif;?>

<hr />

<a href="<?php echo url::site('update/step');?>" id="next" class="install-options">
	<span><?php echo __('Get the New Files');?></span>
	<em><?php echo __('updatecheck.getfiles');?></em>
</a>

<a href="<?php echo url::site('update/step');?>" id="next" class="install-options">
	<span><?php echo __('Already Have the Files? Start the Update!');?></span>
	<em><?php echo __('updatecheck.start');?></em>
</a>