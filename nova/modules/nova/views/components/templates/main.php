<noscript>
	<div class="system_warning"><?php echo __("You need to have Javascript turned on to use all of Nova 3's features.");?></div>
</noscript>

<div class="navbar">
	<div class="navbar-inner">
		<div class="container">
			<a href="<?php echo \Uri::create('main/index');?>" class="brand"><?php echo $sim_name;?></a>
			<?php echo $navmain;?>
			<?php echo $navuser;?>
		</div>
	</div>
</div>

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
		<?php echo $footer;?>
	</footer>
</div>