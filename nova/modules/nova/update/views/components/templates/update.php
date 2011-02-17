<header></header>

<div id="container">
	<div class="head">
		<h1><?php echo $label;?></h1>
	</div>
	
	<div class="content">
		<div id="loading" class="hidden">
			<img src="<?php echo url::base().MODFOLDER;?>/nova/update/views/design/images/loading-circle-large.gif" alt="" />
			<br />
			<strong><?php echo ucfirst(___('processing'));?>...</strong>
		</div>
		
		<div id="loaded" class="UITheme">
			<?php if (Request::current()->action() == 'step' and Request::current()->param('id') > 0): ?>
				<div id="amount">
					<span id="percent">0%</span>
					<div id="progress-container">
						<div id="progress"></div>
					</div>
				</div>
				<div style="clear:both;"></div>
			<?php endif;?>
		
			<?php echo $flash;?>
			<?php echo $content;?>
		</div>
	</div>
	
	<?php if ($controls !== false): ?>	
		<div class="lower">
			<div class="control"><?php echo $controls;?></div>
		</div>
	<?php endif;?>
	
	<footer>
		Powered by <strong><?php echo Kohana::config('novasys.app_name').' '.Kohana::config('novasys.app_version_major');?></strong>
	</footer>
</div>