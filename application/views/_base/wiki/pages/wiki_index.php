<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?>
<br />

<?php if (isset($recent['updates'])): ?>
	<?php echo text_output($label['recent_updates'], 'h4', 'page-subhead');?>
	
	<ul class="square margin1 padding1">
	<?php foreach ($recent['updates'] as $r): ?>
		<li>
			<strong><?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?></strong><br />
			<span class="fontSmall gray">
				<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
			</span><br />
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>

<?php if (isset($recent['created'])): ?>
	<?php echo text_output($label['recent_created'], 'h4', 'page-subhead');?>
	
	<ul class="square margin1 padding1">
	<?php foreach ($recent['created'] as $r): ?>
		<li>
			<strong><?php echo anchor('wiki/view/page/'. $r['id'], $r['title']);?></strong><br />
			<span class="fontSmall gray">
				<?php echo $label['by'] .' '. $r['author'] .' '. $r['timespan'] .' '. $label['ago'];?>
			</span><br />
		</li>
	<?php endforeach;?>
	</ul>
<?php endif;?>