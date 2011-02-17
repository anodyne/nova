<script type="text/javascript">
	$(document).ready(function(){
		$('#widgets').tabs();
	});
</script>

<h1 class="page-head"><?php echo $header;?></h1>

<p><?php echo $message;?></p><br />

<?php if (isset($widgets)): ?>
	<div id="widgets">
		<ul>
		<?php if (isset($widgets[1])): ?>
			<li><a href="#one"><span><?php echo $widgets[1]->name;?></span></a></li>
		<?php endif;?>
		
		<?php if (isset($widgets[2])): ?>
			<li><a href="#two"><span><?php echo $widgets[2]->name;?></span></a></li>
		<?php endif;?>
		
		<?php if (isset($widgets[3])): ?>
			<li><a href="#three"><span><?php echo $widgets[3]->name;?></span></a></li>
		<?php endif;?>
		
		<?php if (isset($widgets[4])): ?>
			<li><a href="#four"><span><?php echo $widgets[4]->name;?></span></a></li>
		<?php endif;?>
		</ul>
		
		<?php if (isset($widgets[1])): ?>
			<div id="one">
				<?php echo View::factory('components/widgets/'.$widgets[1]->location.'/widget')->render();?>
			</div>
		<?php endif;?>
		
		<?php if (isset($widgets[2])): ?>
			<div id="two">
				<?php echo View::factory('components/widgets/'.$widgets[2]->location.'/widget')->render();?>
			</div>
		<?php endif;?>
		
		<?php if (isset($widgets[3])): ?>
			<div id="three">
				<?php echo View::factory('components/widgets/'.$widgets[3]->location.'/widget')->render();?>
			</div>
		<?php endif;?>
		
		<?php if (isset($widgets[4])): ?>
			<div id="four">
				<?php echo View::factory('components/widgets/'.$widgets[4]->location.'/widget')->render();?>
			</div>
		<?php endif;?>
	</div>
<?php endif;?>