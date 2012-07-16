<?php $req = Request::active();?>
<?php $controller = Inflector::denamespace($req->controller);?>

<header><?php echo Html::img('nova/modules/setup/views/design/images/logo.png');?></header>

<div class="outer-container">
	<div class="container">
		<div class="head">
			<?php if (isset($steps)): ?>
				<div id="steps"><?php echo $steps;?></div>
			<?php endif;?>
			<h1><?php echo $image.$label;?></h1>
			<div style="clear:both;"></div>
		</div>
		
		<div class="content">
			<div id="loading" class="hide">
				<p><?php echo Html::img('nova/modules/setup/views/design/images/loading.gif');?></p>
				<p class="muted"><strong>Processing...</strong></p>
			</div>
			
			<div id="loaded">
				<?php echo $flash;?>
				<?php echo $content;?>
			</div>
		</div>
		
		<?php if ($controls !== false): ?>	
			<div class="lower">
				<?php echo $controls;?>
			</div>
		<?php endif;?>
	</div>
</div>

<footer>
	&copy; <?php echo date('Y');?> Anodyne Productions
</footer>