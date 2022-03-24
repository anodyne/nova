<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($loa)): ?>
	<?php echo $pagination;?>
	
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['name'];?></th>
				<th><?php echo $label['reason'];?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($loa as $l): ?>
			<tr>
				<td class="col_50pct">
					<?php echo text_output($l['user'], 'span', 'fontMedium bold');?><br />
					<span class="fontSmall gray">
						<strong><?php echo $label['date_start'] .'</strong> '. $l['date_start'];?>
						<?php if (!empty($l['date_end'])): ?>
							<br />
							<strong><?php echo $label['date_end'] .'</strong> '. $l['date_end'];?>
						<?php endif;?>
						<br /><br />
						
						<strong><?php echo $label['duration_expected'] .'</strong> '. $l['duration'];?><br />
						<strong><?php echo $label['duration_actual'] .'</strong> '. $l['duration_actual'];?>
					</span>
				</td>
				<td><?php echo $l['reason'];?></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['none'], 'h3', 'orange');?>
<?php endif;?>