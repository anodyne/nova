<p><?php echo $message;?></p>

<?php if (HTTP_Request::POST != Request::current()->method()): ?>
	<p class="fontMedium bold"><a href="<?php echo Url::site('setup/main/index');?>">&laquo; Back to Setup Center</a></p>
<?php endif;?>