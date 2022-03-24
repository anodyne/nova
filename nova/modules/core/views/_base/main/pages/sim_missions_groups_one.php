<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/missions/group', $label['backgroups'], array('class' => 'bold'));?></p><br />

<?php if (isset($group)): ?>
	<?php echo text_output($group['desc']);?>
	
	<h4><?php echo $label['count_posts_group'] .' '. $group['posts'];?></h4>
	
	<?php if (isset($group['missions'])): ?>
		<hr />
		
		<?php echo text_output($label['included'], 'h2', 'page-subhead');?>
		
		<div class="indent-left">
			<?php foreach ($group['missions'] as $m): ?>
				<h4><?php echo anchor('sim/missions/id/'. $m['id'], $m['title']);?></h4>
				<strong class="fontSmall gray"><?php echo $label['count'] .' '. $m['count'];?></strong>
				<?php echo text_output($m['desc'], 'p', 'fontSmall gray');?>
			<?php endforeach;?>
		</div>
	<?php endif;?>
	
	<?php if (isset($group['subgroups'])): ?>
		<br /><hr /><br />
		
		<?php echo text_output($label['included_groups'], 'h2', 'page-subhead');?>
		
		<div class="indent-left">
			<?php foreach ($group['subgroups'] as $s): ?>
				<h4><?php echo anchor('sim/missions/group/'. $s['id'], $s['name']);?></h4>
				<strong class="fontSmall gray"><?php echo $label['count_missions'] .' '. $s['count']['missions'];?></strong><br />
				<strong class="fontSmall gray"><?php echo $label['count'] .' '. $s['count']['posts'];?></strong>
				<?php echo text_output($s['desc'], 'p', 'fontSmall gray');?>
			<?php endforeach;?>
		</div>
	<?php endif;?>
<?php else: ?>
	<?php echo text_output($label['nogroup'], 'h3', 'orange');?>
<?php endif;?>