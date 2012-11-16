<noscript>
	<div class="system_warning"><?php echo lang("{{You need to have Javascript turned on to use all of Nova 3's features.}}");?></div>
</noscript>

<?php echo $navmain;?>

<div class="container">
	<div class="content">
		<div class="page-header">
			<h1><?php echo $header;?></h1>
		</div>
		<div><?php echo $message;?></div>
		
		<?php echo $flash;?>
		<?php echo $content;?>
		<?php echo $ajax;?>
		
		<div style="clear:both;">&nbsp;</div>
	</div>
</div>

<div class="container">
	<footer>
		<hr>
		
		<?php echo $footer;?>
	</footer>
</div>