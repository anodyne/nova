<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($display, 'p', 'gray italic bold');?>

<?php if (isset($logs)): ?>
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['title'];?></th>
				<th><?php echo $label['author'];?></th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($logs as $log): ?>
			<tr>
				<td class="col_60pct">
					<strong>
						<?php echo anchor('sim/viewlog/'. $log['id'], $log['title'], array('class' => 'bold'));?>
					</strong><br />
					<span class="fontSmall"><?php echo $label['on'] .' '. $log['date'];?></span>
				</td>
				<td><?php echo $log['author'];?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['nologs'], 'h3', 'orange');?>
<?php endif; ?>