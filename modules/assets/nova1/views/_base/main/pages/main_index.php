<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg_welcome);?>

<?php if (isset($news)): ?>
	<?php echo text_output($label['news'], 'h2', 'page-subhead');?>
	
	<?php foreach ($news as $value): ?>
		<h4><?php echo anchor('main/viewnews/' . $value['id'], RARROW .' '. $value['title']);?></h4>
		
		<p class="gray fontSmall bold">
			<?php echo $label['posted'] .' '. $value['date'];?>
			<?php echo $label['by'] .' '. $value['author'];?>
			<?php echo $label['in'] .' '. $value['category'];?></p>
		
		<?php echo text_output($value['content'], 'p');?><br />
	<?php endforeach; ?>
<?php endif; ?>