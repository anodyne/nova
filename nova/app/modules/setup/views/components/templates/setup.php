<?php $request = Request::current();?>

<header>
	<div class="wrapper">
		<img src="<?php echo Url::base().MODFOLDER;?>/app/modules/setup/views/design/images/logo.png">
	</div>
</header>

<div id="outer-container">
	<div id="container">
		<div class="head">
			<?php if ($request->action() == 'step'): ?>
				<div id="steps"><?php echo $steps;?></div>
			<?php endif;?>
			<h1><?php echo $image.$label;?></h1>
			<div style="clear:both;"></div>
		</div>
		
		<div class="content">
			<div id="loading" class="hidden">
				<img src="<?php echo Url::base().MODFOLDER;?>/app/modules/setup/views/design/images/loading.gif" alt="">
				<br />
				<strong>Processing...</strong>
			</div>
			
			<div id="loaded">
				<?php echo $flash;?>
				<?php echo $content;?>
			</div>
		</div>
		
		<?php if ($controls !== false): ?>	
			<div class="lower">
				<div class="control"><?php echo $controls;?></div>
			</div>
		<?php endif;?>
	</div>
</div>