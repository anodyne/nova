<div id="header"></div>

<div id="container">
	<div class="head">
		<h1><?php echo $label;?></h1>
	</div>
	
	<div class="content">
		<div id="loading" class="hidden">
			<img src="<?php echo url::base().APPFOLDER;?>/views/_base/install/images/loading-circle-large.gif" alt="" />
			<br />
			<strong><?php echo ucfirst(__('action.processing'));?>...</strong>
		</div>
		
		<div id="loaded" class="UITheme">
			<?php if (Request::Instance()->action == 'step' && Request::Instance()->param('id') > 0): ?>
				<div id="progress"></div>
				<div id="amount">Progress: <span id="percent">0%</span></div>
				<div style="clear:both;"></div>
			<?php endif;?>
		
			<?php echo $flash_message;?>
			<?php echo $content;?>
		</div>
	</div>
	
	<div class="lower"><?php echo $controls;?></div>
	
	<div class="footer">
		Powered by <strong><?php echo Kohana::config('info.app_name').' '.Kohana::config('info.app_version_major');?></strong>
	</div>
</div>