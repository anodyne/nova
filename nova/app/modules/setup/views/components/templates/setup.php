<?php $request = Request::current();?>

<header></header>

<div id="container">
	<div class="head">
		<h1><?php echo $image.$label;?></h1>
	</div>
	
	<div class="content">
		<div id="loading" class="hidden">
			<img src="<?php echo Url::base().MODFOLDER;?>/app/modules/setup/views/design/images/loading-circle-large.gif" alt="">
			<br />
			<strong><?php echo ucfirst(___('processing'));?>...</strong>
		</div>
		
		<div id="loaded" class="UITheme">
			<?php if ($request->action() == 'step' and $request->param('id') > 0): ?>
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
		Powered by <strong><?php echo Kohana::config('nova.app_name').' '.Kohana::config('nova.app_version_major');?></strong>
	</footer>
</div>