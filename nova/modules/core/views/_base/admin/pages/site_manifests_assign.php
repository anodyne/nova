<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<style type="text/css">
	.droppable {
		padding: 8px;
		line-height: 1.95;
		
		border-radius: 4px;
		-moz-border-radius: 4px;
		-webkit-border-radius: 4px;
	}
	.draggable {
		padding: 2px 6px;
		
		cursor: move;
		
		border-radius: 2px;
		-moz-border-radius: 2px;
		-webkit-border-radius: 2px;
	}
</style>

<?php echo text_output($label['sitemanifests'].' &ndash; '.$label['assign'], 'h1', 'page-head');?>

<p><strong><?php echo anchor('site/manifests', $label['back']);?></strong></p>

<?php echo text_output($text);?>

<p><strong><?php echo anchor('site/manifests/assign', img($images['refresh']).' '.$label['refresh'], array('class' => 'image'));?></strong></p><br />

<?php if (isset($manifests)): ?>
	<div class="UITheme">
		<?php echo text_output($label['unassigned'], 'h2', 'page-subhead');?>
		
		<div mid="0" class="droppable info-full">
		<?php if (isset($unassigned)): ?>
			<?php foreach ($unassigned as $id => $d): ?>
				<span class="draggable ui-widget-header" did="<?php echo $id;?>" rel="tooltip" title="<?php echo $d['desc'];?>"><?php echo $d['name'];?></span>
			<?php endforeach;?>
		<?php endif;?>
		</div>
		
		<?php if (isset($manifests)): ?>
			<?php foreach ($manifests as $id => $m): ?>
				<h2 class="page-subhead">
					<?php echo $m['manifest'];?>
					<?php if ($m['display'] == 'n'): ?>
						<span class="gray fontSmall">[ <?php echo $label['off'];?> ]</span>
					<?php endif;?>
				</h2>
				
				<div mid="<?php echo $id;?>" class="droppable info-full">
				<?php if (isset($m['depts'])): ?>
					<?php foreach ($m['depts'] as $i => $dept): ?>
						<span class="draggable ui-widget-header" did="<?php echo $i;?>" rel="tooltip" title="<?php echo $dept['desc'];?>"><?php echo $dept['name'];?></span>
					<?php endforeach;?>
				<?php endif;?>
				</div>
			<?php endforeach;?>
		<?php endif;?>
	</div>
<?php else: ?>
	Foo
<?php endif;?>