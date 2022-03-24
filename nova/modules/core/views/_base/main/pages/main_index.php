<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($msg_welcome);?>
<br>

<?php if (count($lists) > 1): ?>
	<div id="tabs">
		<ul>
			<?php if (isset($lists['news'])): ?>
				<li><a href="#one"><span><?php echo $label['news'];?></span></a></li>
			<?php endif;?>
			
			<?php if (isset($lists['posts'])): ?>
				<li><a href="#two"><span><?php echo $label['posts'];?></span></a></li>
			<?php endif;?>
			
			<?php if (isset($lists['logs'])): ?>
				<li><a href="#three"><span><?php echo $label['logs'];?></span></a></li>
			<?php endif;?>
		</ul>
		
		<?php if (isset($lists['news'])): ?>
			<div id="one">
				<?php echo text_output($label['news'], 'h2', 'page-subhead');?>
				
				<?php foreach ($lists['news'] as $value): ?>
					<h4><?php echo anchor('main/viewnews/' . $value['id'], RARROW .' '. $value['title']);?></h4>
					
					<p class="gray fontSmall">
						<?php echo $label['posted'] .' '. $value['date'];?>
						<?php echo $label['by'] .' '. $value['author'];?>
						<?php echo $label['in'] .' '. $value['category'];?></p>
					
					<?php echo text_output($value['content'], 'p');?><br />
				<?php endforeach; ?>
			</div>
		<?php endif;?>
		
		<?php if (isset($lists['posts'])): ?>
			<div id="two">
				<?php echo text_output($label['posts'], 'h2', 'page-subhead');?>
				
				<?php foreach ($lists['posts'] as $value): ?>
					<h4><?php echo anchor('sim/viewpost/' . $value['id'], RARROW .' '. $value['title']);?></h4>
					
					<p class="gray fontSmall">
						<strong><?php echo $label['mission'].':</strong> '.$value['mission'];?><br />
						<?php echo $label['posted'] .' '. $value['date'];?>
						<?php echo $label['by'] .' '. $value['authors'];?></p>
					
					<?php echo text_output($value['content'], 'p');?><br />
				<?php endforeach; ?>
			</div>
		<?php endif;?>
		
		<?php if (isset($lists['logs'])): ?>
			<div id="three">
				<?php echo text_output($label['logs'], 'h2', 'page-subhead');?>
				
				<?php foreach ($lists['logs'] as $value): ?>
					<h4><?php echo anchor('sim/viewlog/' . $value['id'], RARROW .' '. $value['title']);?></h4>
					
					<p class="gray fontSmall">
						<?php echo $label['posted'] .' '. $value['date'];?>
						<?php echo $label['by'] .' '. $value['author'];?></p>
					
					<?php echo text_output($value['content'], 'p');?><br />
				<?php endforeach; ?>
			</div>
		<?php endif;?>
	</div>
<?php else: ?>
	<?php if (isset($lists['news'])): ?>
		<?php echo text_output($label['news'], 'h2', 'page-subhead');?>
		
		<?php foreach ($lists['news'] as $value): ?>
			<h4><?php echo anchor('main/viewnews/' . $value['id'], RARROW .' '. $value['title']);?></h4>
			
			<p class="gray fontSmall">
				<?php echo $label['posted'] .' '. $value['date'];?>
				<?php echo $label['by'] .' '. $value['author'];?>
				<?php echo $label['in'] .' '. $value['category'];?></p>
			
			<?php echo text_output($value['content'], 'p');?><br />
		<?php endforeach; ?>
	<?php endif;?>
	
	<?php if (isset($lists['posts'])): ?>
		<?php echo text_output($label['posts'], 'h2', 'page-subhead');?>
		
		<?php foreach ($lists['posts'] as $value): ?>
			<h4><?php echo anchor('sim/viewpost/' . $value['id'], RARROW .' '. $value['title']);?></h4>
			
			<p class="gray fontSmall">
				<strong><?php echo $label['mission'].':</strong> '.$value['mission'];?><br />
				<?php echo $label['posted'] .' '. $value['date'];?>
				<?php echo $label['by'] .' '. $value['authors'];?></p>
			
			<?php echo text_output($value['content'], 'p');?><br />
		<?php endforeach; ?>
	<?php endif;?>
	
	<?php if (isset($lists['logs'])): ?>
		<?php echo text_output($label['logs'], 'h2', 'page-subhead');?>
		
		<?php foreach ($lists['logs'] as $value): ?>
			<h4><?php echo anchor('sim/viewlog/' . $value['id'], RARROW .' '. $value['title']);?></h4>
			
			<p class="gray fontSmall">
				<?php echo $label['posted'] .' '. $value['date'];?>
				<?php echo $label['by'] .' '. $value['author'];?></p>
			
			<?php echo text_output($value['content'], 'p');?><br />
		<?php endforeach; ?>
	<?php endif;?>
<?php endif;?>