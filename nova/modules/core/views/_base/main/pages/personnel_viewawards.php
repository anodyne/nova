<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if (isset($msg_error)): ?>
	<?php echo text_output($msg_error, 'h3', 'orange');?>
<?php endif; ?>

<?php if (isset($awards)): ?>
	<p class="bold"><?php echo anchor('personnel/character/'. $charid, $label['backchar']);?></p>
	<?php echo text_output($label['ooc'] .' '. $label['awards'], 'h2');?>
	<table class="table100 zebra" cellpadding="3">
		<thead>
			<tr>
				<th colspan="2"><?php echo $label['award'];?></th>
				<th><?php echo $label['reason'];?></th>
			</tr>
		</thead>
		
		<tbody>
		<?php foreach ($awards as $key => $value): ?>
			<tr>
				<td>
					<?php echo anchor('sim/awards/'. $value['award_id'], img($value['img']), array('class' => 'image'));?>
				</td>
				<td>
					<strong><?php echo $value['award'];?></strong><br />
					<em class="fontSmall">
						<?php echo $label['awarded'] .' '. $value['date'];?>
						
						<?php if ( ! empty($value['nom'])): ?>
							<br />
							<?php echo $label['nominatedby'] .' '. $value['nom'];?>
						<?php endif;?>
					</em>
				</td>
				<td class="col_50pct"><?php echo text_output($value['reason'], '');?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif; ?>
	
<?php if (isset($char)): ?>
	<p class="bold"><?php echo anchor('personnel/user/'. $user .'/5', $label['backuser']);?></p>
	<?php foreach ($char as $key => $value): ?>
	<br />
	<?php echo text_output($value['character'], 'h2');?>
	<table class="table100 zebra" cellpadding="3">
		<tbody>
		<?php foreach ($value['awards'] as $b): ?>
			<tr>
				<td><?php echo anchor('sim/awards/'. $b['award_id'], img($b['img']), array('class' => 'image'));?></td>
				<td>
					<strong><?php echo $b['award'];?></strong><br />
					<em class="fontSmall">
						<?php echo $label['awarded'] .' '. $b['date'];?>
						
						<?php if ( ! empty($b['nom'])): ?>
							<br />
							<?php echo $label['nominatedby'] .' '. $b['nom'];?>
						<?php endif;?>
					</em>
				</td>
				<td class="col_50pct"><?php echo text_output($b['reason'], '');?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?php endforeach; ?>
<?php endif; ?>