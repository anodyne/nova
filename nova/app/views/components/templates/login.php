<noscript>
	<div class="system_warning"><?php echo ___("You need to have Javascript turned on to use all of Nova 3's features.");?></div>
</noscript>

<header>
	<div class="wrapper">
		<div class="nav-main">
			<img src="<?php echo Url::base().MODFOLDER;?>/app/views/design/images/main/nova.png" class="float-right">
			<ul>
				<li><a href="<?php echo Url::site('login/index');?>"><span><?php echo ucwords(___('log in'));?></span></a></li>
				<li><a href="<?php echo Url::site('login/reset');?>"><span><?php echo ucwords(___('reset password'));?></span></a></li>
				<li><a href="<?php echo Url::site('main/index');?>"><span><?php echo ___('Back to Site');?></span></a></li>
			</ul>
		</div>
	</div>
</header>

<section>
	<div class="wrapper">
		<div id="content">
			<?php echo $flash;?>
			
			<h1 class="page-head"><?php echo $header;?></h1>
			<p><?php echo $message;?></p>
			
			<?php echo $content;?>
			
			<div style="clear:both;">&nbsp;</div>
		</div>
		
		<footer>
			<div class="footer-content">
				<div class="float-right">&copy; <?php echo date('Y');?> <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a></div>
				Powered by Nova
			</div>
		</footer>
	</div>
</section>