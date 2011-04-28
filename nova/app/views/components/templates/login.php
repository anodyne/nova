<noscript>
	<div class="system_warning"><?php echo ___("You need to have Javascript turned on to use all of Nova 3's features.");?></div>
</noscript>

<header>
	<div class="wrapper">
		<nav>
			<ul>
				<li><a href="<?php echo url::site('login/index');?>"><span><?php echo ucwords(___('log in'));?></span></a></li>
				<li><a href="<?php echo url::site('login/reset');?>"><span><?php echo ucwords(___('reset password'));?></span></a></li>
				<li><a href="<?php echo url::site('main/index');?>"><span><?php echo ___('Back to Site');?></span></a></li>
			</ul>
		</nav>
		
		<div class="name"><?php echo $name;?></div>
	</div>
</header>

<section>
	<div class="wrapper">
		<div class="content">
			<?php echo $flash;?>
			<?php echo $content;?>
			
			<div style="clear:both;">&nbsp;</div>
			
			<footer>
				Powered by <strong>Nova</strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a>
			</footer>
		</div>
	</div>
</section>