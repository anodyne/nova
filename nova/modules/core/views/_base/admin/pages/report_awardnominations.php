<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php echo text_output($text);?><br />

<?php if (isset($nominations)): ?>
	<?php echo $pagination;?>
	
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($nominations as $n): ?>
			<tr>
				<td class="col_40pct">
					<?php echo text_output($n['name'], 'strong');?><br />
					<span class="fontSmall gray">
						<?php echo text_output($label['award'], 'strong') .': '. anchor('sim/awards/'. $n['awardid'], $n['award']);?><br />
						<?php echo text_output($label['nominated'], 'strong') .': '. anchor('personnel/character/'. $n['charid'], $n['nominate']);?><br />
						<?php echo text_output($label['date'], 'strong') .': '. $n['date'];?>
					</span>
				</td>
				<td class="fontSmall"><?php echo text_output($n['reason'], '');?></td>
				<td class="col_30 align_center">
					<?php if ($n['status'] == 'pending'): ?>
						<?php echo img($images['yellow']);?>
					<?php elseif ($n['status'] == 'rejected'): ?>
						<?php echo img($images['red']);?>
					<?php elseif ($n['status'] == 'accepted'): ?>
						<?php echo img($images['green']);?>
					<?php endif;?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table><br />
	
	<?php echo $pagination;?>
<?php else: ?>
	<?php echo text_output($label['none'], 'h3', 'orange');?>
<?php endif;?>