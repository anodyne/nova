<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?><br />

<?php if (isset($apps)): ?>
	<?php echo $pagination;?>
	
	<table class="table100 zebra">
		<thead>
			<tr>
				<th><?php echo $label['character'];?></th>
				<th><?php echo $label['user'];?></th>
				<th><?php echo $label['action'];?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($apps as $a): ?>
			<tr>
				<td class="col_40pct">
					<?php echo text_output($a['character'], 'strong');?><br />
					<span class="fontSmall gray">
						<?php echo text_output($label['position'], 'strong') .': '. $a['position'];?>
					</span>
				</td>
				<td>
					<?php echo text_output($a['user'], 'strong');?><br />
					<span class="fontSmall gray">
						<?php echo text_output($label['date'], 'strong') .': '. $a['date'];?><br />
						<?php echo text_output($label['email'], 'strong') .': '. $a['email'];?><br />
						<?php echo text_output($label['ipaddr'], 'strong') .': '. $a['ipaddr'];?>
					</span>
				</td>
				<td class="col_30 align_center fontSmall bold">
					<?php if ($a['action'] == 'accepted'): ?>
						<?php echo img($images['green']);?>
					<?php elseif ($a['action'] == 'rejected'): ?>
						<?php echo img($images['red']);?>
					<?php elseif ($a['action'] == 'deleted'): ?>
						<?php echo img($images['delete']);?>
					<?php else: ?>
						<?php echo img($images['yellow']);?>
					<?php endif;?>
				</td>
				<td class="col_30 align_center">
					<?php echo anchor('report/viewapp/'. $a['id'], img($images['view']), array('class' => 'image'));?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['none'], 'h3', 'orange');?>
<?php endif;?>