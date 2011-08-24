<p><?php echo $message;?></p>

<?php if (isset($changes) and count($changes) > 0): ?>
	<p>The following changes have been made since Nova :version (your current version of the system):</p>
	
	<?php foreach ($changes as $key => $c): ?>
		<?php echo $c;?>
	<?php endforeach;?>
<?php endif;?>

<hr>

<a href="http://nova.anodyne-productions.com" target="_blank" id="next" class="install-options">
	<span>Get the New Files</span>
	<em>The first thing you'll need to do is download the new Nova files. You can download the files from the Anodyne site. Once you've downloaded the files, follow the directions in the README for updating to the latest version of Nova.</em>
</a>

<a href="<?php echo Url::site('setup/update/step');?>" id="next" class="install-options">
	<span>Already Have the Files? Start the Update!</span>
	<em>If you've already downloaded the files and made the updates to your system but just need to update your database, you can use this link to start the process.</em>
</a>