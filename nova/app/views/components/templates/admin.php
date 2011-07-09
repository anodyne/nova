<noscript>
	<div class="system_warning"><?php echo __("You need to have Javascript turned on to use all of Nova 3's features.");?></div>
</noscript>

<?php echo $panel;?>

<div id="container">
	<header>Name Goes Here</header>
	
	<section>
		<div id="sidebar"><?php echo $navmain;?></div>
		
		<div id="subnav-popup"></div>
		
		<div id="content">
			<div class="inner">
				<div id="section-nav-trigger"><div class="arrow"></div>Control Panel</div>
				<div id="section-nav"></div>
				
				<?php echo $flash;?>
				<?php echo $content;?>
				<?php echo $ajax;?>
				
				<div style="clear:both;">&nbsp;</div>
			</div>
		</div>
	</section>
</div>

<footer><?php echo $footer;?></footer>