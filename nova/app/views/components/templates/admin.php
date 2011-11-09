<noscript>
	<div class="system_warning"><?php echo ___("You need to have Javascript turned on to use all of Nova 3's features.");?></div>
</noscript>

<?php echo $panel;?>

<header>
	<div class="wrapper">
		<div class="nav-main">
			<img src="<?php echo Url::base().MODFOLDER;?>/app/views/design/images/main/nova.png" class="float-right">
			<?php echo $navmain;?>
		</div>
	</div>
</header>

<div class="container-fluid">
	<div class="sidebar">
		<?php echo $navsub;?>
	</div>
	
	<div class="content">
		<?php echo $flash;?>
		
		<h1><?php echo $header;?></h1>
		<p><?php echo $message;?></p>
		
		<?php echo $content;?>
		<?php echo $ajax;?>
		
		<div style="clear:both;">&nbsp;</div>
	</div>
</div>

<div class="wrapper">
	<footer>
		<?php echo $footer;?>
	</footer>
</div>