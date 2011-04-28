<noscript>
	<div class="system_warning"><?php echo __("You need to have Javascript turned on to use all of Nova 2's features.");?></div>
</noscript>

<?php echo $panel;?>

<header>
	<div class="wrapper">
		<div class="nav-main">
			<img src="<?php echo url::base().MODFOLDER;?>/nova/core/views/design/images/menu-nova.png" class="float-right">
			<?php echo $navmain;?>
		</div>
	</div>
</header>

<section>
	<div class="wrapper">
		<nav>
			<?php echo $navsub;?>
		</nav>
		
		<div class="content">
			<?php echo $flash;?>
			<?php echo $content;?>
			<?php echo $ajax;?>
			
			<div style="clear:both;">&nbsp;</div>
			
			<footer>
				<?php echo $footer;?>
			</footer>
		</div>
	</div>
</section>