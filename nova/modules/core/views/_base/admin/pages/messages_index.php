<?php echo text_output($header, 'h1', 'page-head');?>

<div id="loading" class="loader">
	<?php echo img($loader);?>
	<?php echo text_output($label['loading'], 'h3', 'gray');?>
</div>

<div id="loaded" class="hidden">
	<p>
		<?php echo anchor('messages/write', img($images['write']) .' '. $label['write'], array('class' => 'image bold'));?>
	</p>
	
	<?php if ( ! isset($inbox)): ?>
		<?php echo text_output($label['no_inbox'], 'h3', 'orange');?>
	<?php else: ?>
		<?php echo form_open('messages/index');?>
			<br />
			
			<?php echo $inbox_pagination;?>
			
			<?php foreach ($inbox as $item): ?>
				<div class="info-full">
					<?php echo form_checkbox($item['checkbox']);?>
					
					<h4><?php echo anchor('messages/read/'. $item['id'], $item['subject']);?></h4>
					<p class="gray fontSmall">
						<?php echo img($images['user']).$item['author'];?><br />
						<?php echo img($images['clock']).$item['date'];?>
					</p>
				</div><br />
			<?php endforeach; ?>
			
			<?php echo $inbox_pagination;?>
			
			<div class="clear_right"></div>
		<?php echo form_close();?>
	<?php endif; ?>
</div>