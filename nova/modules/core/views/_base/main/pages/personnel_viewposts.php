<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php endif; ?>

<?php if (isset($posts)): ?>
	<p class="bold"><?php echo anchor('personnel/character/' . $charid, $label['backchar']);?></p>
	
	<?php echo text_output($display, 'p', 'gray italic bold');?>
	
	<?php echo $pagination;?>
	
	<table class="zebra table100">
		<thead>
			<tr>
				<th><?php echo $label['title'];?></th>
				<th><?php echo $label['mission'];?></th>
				<th></th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td class="col_40pct">
					<?php echo anchor('sim/viewpost/'. $post['id'], $post['title'], array('class' => 'bold'));?><br />
					<span class="fontSmall"><?php echo $label['on'] .' '. $post['date'];?></span>
				</td>
				<td><?php echo anchor('sim/missions/id/'. $post['mission_id'], $post['mission']);?></td>
				<td class="col_75 align_center">
					<?php echo anchor('sim/viewpost/'. $post['id'], $label['view_post'], array('class' => 'bold'));?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php echo $pagination;?>
<?php elseif (isset($char)): ?>
	<p class="bold"><?php echo anchor('personnel/user/' . $user .'/4', $label['backuser']);?></p>
	<?php foreach ($char as $c): ?>
		<br />
		<?php echo text_output($c['character'], 'h2');?>
		
		<?php if (isset($c['posts'])): ?>
			<table class="zebra table100">
				<tbody>
				<?php foreach ($c['posts'] as $post): ?>
					<tr>
						<td class="col_40pct">
							<?php echo anchor('sim/viewpost/'. $post['id'], $post['title'], array('class' => 'bold'));?><br />
							<span class="fontSmall"><?php echo $label['on'] .' '. $post['date'];?></span>
						</td>
						<td><?php echo anchor('sim/missions/id/'. $post['mission_id'], $post['mission']);?></td>
						<td class="col_75 align_center">
							<?php echo anchor('sim/viewpost/'. $post['id'], $label['view_post'], array('class' => 'bold'));?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php else: ?>
			<?php echo text_output($label['noposts'], 'h3', 'orange');?>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>