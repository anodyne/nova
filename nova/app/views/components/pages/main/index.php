<?php if (isset($widgets)): ?>
	<?php $count = count($widgets);?>
	
	<br>
	<div class="row">
		<?php if ($count == 1): ?>
			<div class="span16">
				<?php if (isset($widgets[1])): ?>
					<h2><?php echo $widgets[1]->name;?></h2>
					<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
		<?php elseif ($count == 2): ?>
			<div class="span8">
				<?php if (isset($widgets[2])): ?>
					<!--<h2><?php echo $widgets[2]->name;?></h2>-->
					<h2>The Nova Philosophy</h2>
					<?php echo View::factory('components/widgets/'.$widgets[2]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
			
			<div class="span8">
				<?php if (isset($widgets[1])): ?>
					<!--<h2><?php echo $widgets[1]->name;?></h2>-->
					<h2>Widgets</h2>
					<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
		<?php elseif ($count == 3): ?>
			<div class="span-one-third">
				<?php if (isset($widgets[1])): ?>
					<h2><?php echo $widgets[1]->name;?></h2>
					<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
			
			<div class="span-one-third">
				<?php if (isset($widgets[1])): ?>
					<h2><?php echo $widgets[1]->name;?></h2>
					<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
			
			<div class="span-one-third">
				<?php if (isset($widgets[1])): ?>
					<h2><?php echo $widgets[1]->name;?></h2>
					<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
				<?php endif;?>
			</div>
		<?php endif;?>
	</div>
<?php endif;?>