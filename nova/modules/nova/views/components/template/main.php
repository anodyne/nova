<noscript>
	<div class="alert system-warning"><div class="container"><?php echo lang('short.javascript');?></div></div>
</noscript>

<?php echo $navmain;?>

<div class="container">
	<div class="content">
		
		<div class="page-header">
			<?php if (isset($header_key)): ?>
				<h1 class="editable-single" id="<?php echo $header_key;?>"><?php echo $header;?></h1>
			<?php else: ?>
				<h1><?php echo $header;?></h1>
			<?php endif;?>
		</div>

		<?php if (isset($message_key)): ?>
			<div class="editable-multi" id="<?php echo $message_key;?>"><?php echo $message;?></div>
		<?php else: ?>
			<div><?php echo $message;?></div>
		<?php endif;?>
		
		<?php if (isset($navsub)): ?>
			<?php echo $navsub;?>
		<?php endif;?>
		
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