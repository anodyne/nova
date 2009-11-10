<?php echo text_output($header, 'h1', 'page-head');?>

<div class="info-full">
	<p class="bold fontSmall">
		<?php echo anchor('wiki/recent/updates', $label['updates']);?> |
		<?php echo anchor('wiki/recent/created', $label['created']);?>
	</p>
</div>

<?php if (isset($recent['updates'])): ?>
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