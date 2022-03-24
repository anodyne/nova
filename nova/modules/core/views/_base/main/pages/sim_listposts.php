<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($display, 'p', 'gray italic bold');?>

<?php if (isset($posts)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['title'];?></th>
				<th><?php echo $label['date'];?></th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($posts as $post): ?>
			<tr>
				<td>
					<strong>
						<?php echo anchor('sim/viewpost/'. $post['id'], $post['title'], array('class' => 'bold'));?>
					</strong><br />
					<span class="fontSmall gray">
						<?php echo $label['by'] .' '. $post['author'];?><br />
						
						<strong><?php echo $label['mission'];?></strong>
						<?php echo anchor('sim/missions/id/'. $post['mission_id'], $post['mission']);?>
					</span>
				</td>
				<td class="col_30pct align_center fontSmall"><?php echo $post['date'];?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['noposts'], 'h3', 'orange');?>
<?php endif; ?>