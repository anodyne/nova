<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'manage/missions', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<div id="tabs">
	<ul>
		<li><a href="#one"><span><?php echo $label['s_current'];?></span></a></li>
		<li><a href="#two"><span><?php echo $label['s_upcoming'];?></span></a></li>
		<li><a href="#three"><span><?php echo $label['s_completed'];?></span></a></li>
	</ul>
	
	<div id="one">
		<?php if (isset($missions['current'])): ?>
			<?php foreach ($missions['current'] as $cur): ?>
				<h3><?php echo anchor('sim/missions/'. $cur['id'], $cur['title']);?></h3>
				<strong class="fontSmall gray"><?php echo $label['count'] .' '. $cur['count'];?></strong>
				<?php echo text_output($cur['desc']);?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php echo text_output($label['nomissions'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="two">
		<?php if (isset($missions['upcoming'])): ?>
			<?php foreach ($missions['upcoming'] as $upc): ?>
				<h3><?php echo anchor('sim/missions/'. $upc['id'], $upc['title']);?></h3>
				<strong class="fontSmall gray"><?php echo $label['count'] .' '. $upc['count'];?></strong>
				<?php echo text_output($upc['desc']);?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php echo text_output($label['nomissions'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
	
	<div id="three">
		<?php if (isset($missions['completed'])): ?>
			<?php foreach ($missions['completed'] as $com): ?>
				<h3><?php echo anchor('sim/missions/'. $com['id'], $com['title']);?></h3>
				<strong class="fontSmall gray"><?php echo $label['count'] .' '. $com['count'];?></strong>
				<?php echo text_output($com['desc']);?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php echo text_output($label['nomissions'], 'h3', 'orange');?>
		<?php endif; ?>
	</div>
</div>