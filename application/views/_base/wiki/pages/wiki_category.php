<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($pages)): ?>
	<ul class="square margin1 padding1">
	<?php foreach ($pages as $p): ?>
		<li><?php echo anchor('wiki/view/page/'. $p['id'], $p['title']);?></li>
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($label['nopages'], 'h3', 'orange');?>
<?php endif;?>