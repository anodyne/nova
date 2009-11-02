<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($label['text']);?>

<?php if (isset($categories)): ?>
	<ul class="square margin1 padding1">
	<?php foreach ($categories as $k => $c): ?>
		<li><?php echo anchor('wiki/category/'. $k, $c);?></li>
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($label['nocats'], 'h3', 'orange');?>
<?php endif;?>