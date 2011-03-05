<p class="fontMedium"><?php echo $message;?></p>

<?php if ( ! isset($_POST['submit'])): ?>
	<p class="fontMedium bold"><a href="<?php echo url::site('install/index');?>">&laquo; <?php echo ___('Back to Installation Center');?></a></p>
<?php endif;?>