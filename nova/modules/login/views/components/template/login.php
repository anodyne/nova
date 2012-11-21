<noscript>
	<div class="alert system-warning"><div class="container"><?php echo lang('short.javascript');?></div></div>
</noscript>

<div class="container">
	<div class="content">
		<div class="page-header">
			<h1><?php echo $header;?></h1>
		</div>
		
		<p><?php echo $message;?></p>

		<?php echo $flash;?>
		<?php echo $content;?>
		
		<div style="clear:both;">&nbsp;</div>
	</div>

	<footer>
		<hr>

		&copy; <?php echo date('Y');?> Anodyne Productions
	</footer>
</div>