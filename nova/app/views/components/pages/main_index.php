<script type="text/javascript">
	$(document).ready(function(){
		$('#widgets').tabs();
		
		$('.contenteditable').click(function(){
			$(".contenteditable").freshereditor({
				toolbar_selector: ".toolbar",
				toolbar_buttons: ".contenteditable-buttons",
				excludes: [
					'removeFormat',
					'insertheading4',
					'strikethrough',
					'superscript',
					'subscript',
					'justifyleft',
					'justifyright',
					'justifyfull',
					'justifycenter',
					'backcolor',
					'FontSize',
					'code',
					'blockquote'
				]
			});
			$(".contenteditable").freshereditor("edit", true);
		});
	});
</script>

<h1 class="page-head"><?php echo $header;?></h1>

<?php if ( ! Auth::check_access('site/messages', false)): ?>
	<div class="toolbar"></div>
	<div class="fresheditor-toolbar-buttons">
		<button class="btn-main">Save</button>
		<button class="btn-main">Discard</button>
	</div>
	<div class="contenteditable" contenteditable="true"><?php echo $message;?></div>
<?php else: ?>
	<?php echo $message;?>
<?php endif;?>
<br>

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