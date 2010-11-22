<noscript>
	<div class="system_warning"><?php echo __("You need to have Javascript turned on to use all of Nova 2's features.");?></div>
</noscript>

<!-- USER PANEL -->
<?php echo $panel;?>

<!-- HEAD -->
<div id="head-top"></div>

<!-- MENU -->
<div id="menu">
	<div class="wrapper">
		<div class="nav-main">
			<?php echo html::image('application/views/'.$skin.'/'.$sec.'/images/menu-nova.png', array('class' => 'float-right'));?>
			<?php echo $navmain;?>
		</div>
	</div>
</div>

<!-- BODY -->
<div id="body">
	<div class="wrapper">
		<!-- SUB NAVIGATION -->
		<div class="nav-sub">
			<h1><?php echo Jelly::query('setting')->where('key', '=', 'sim_name')->limit(1)->select()->value;?></h1>
			<hr />
			<?php echo $navsub;?>
		</div>
		
		<!-- PAGE CONTENT -->
		<div class="content">
			<?php echo $flash;?>
			<?php echo $content;?>
			<?php echo $ajax;?>
			
			<div style="clear:both;">&nbsp;</div>
			
			<!-- FOOTER -->
			<div id="footer">
				<?php echo $footer;?>
			</div>
		</div>
	</div>
</div>