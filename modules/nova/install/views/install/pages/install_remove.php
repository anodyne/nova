<p class="fontMedium"><?php echo $message;?></p>

<?php if ( ! isset($_POST['submit'])): ?>
	<p class="fontMedium bold"><?php echo html::anchor('install/index', '&laquo; '.__('Back to Installation Center'));?></p>
<?php endif;?>