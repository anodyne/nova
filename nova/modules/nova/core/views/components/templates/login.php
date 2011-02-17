<noscript>
	<div class="system_warning"><?php echo __("You need to have Javascript turned on to use all of Nova 2's features.");?></div>
</noscript>

<!-- MENU -->
<div id="menu">
	<div class="wrapper">
		<div class="nav">
			<ul>
				<li><?php echo html::anchor('login/index', '<span>'.ucwords(__('log in')).'</span>');?></li>
				<li><?php echo html::anchor('login/reset', '<span>'.ucwords(__('reset password')).'</span>');?></li>
				<li><?php echo html::anchor('main/index', '<span>'.__('Back to Site').'</span>');?></li>
			</ul>
		</div>
		
		<div class="name"><?php echo $name;?></div>
	</div>
</div>

<!-- BODY -->
<div id="body">
	<div class="wrapper">
		<!-- PAGE CONTENT -->
		<div class="content">
			<?php echo $flash;?>
			<?php echo $content;?>
			
			<div style="clear:both;">&nbsp;</div>
			
			<!-- FOOTER -->
			<div id="footer">
				Powered by <strong>Nova</strong> from <a href="http://www.anodyne-productions.com" target="_blank">Anodyne Productions</a>
			</div>
		</div>
	</div>
</div>