<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo anchor('sim/missions', $label['missions'], array('class' => 'bold'));?></p>
<br />

<?php if (isset($groups)): ?>
	<hr /><br />
	<?php foreach ($groups as $g): ?>
		<h3><?php echo anchor('sim/missions/group/'. $g['id'], $g['name']);?></h3>
		<strong class="gray fontSmall"><?php echo $label['count_missions'] .' '. $g['count'];?></strong>
		<?php echo text_output($g['desc']);?>
	<?php endforeach;?>
<?php else: ?>
	<?php echo text_output($label['nogroups'], 'h3', 'orange');?>
<?php endif;?>