<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<?php if ($edit_valid === TRUE || $edit_valid_form === TRUE): ?>
	<p>
		<?php echo link_to_if($edit_valid, 'manage/tour', $label['edit'], array('class' => 'edit fontSmall bold'));?>
		<?php echo link_to_if($edit_valid_form, 'site/tourform', $label['edit_form'], array('class' => 'edit fontSmall bold'));?>
	</p>
<?php endif;?>

<?php if (isset($items)): ?>
	<?php foreach ($items as $key => $value): ?>
		<table class="table100 zebra-even">
			<tbody>
			<?php if (isset($tour[$key])): ?>
				<tr>
					<td colspan="4">
						<?php echo text_output($value, 'span', 'fontLarge bold page-subhead');?>
						<?php if ($key != 0): ?>
							&nbsp;&nbsp;
							<?php echo anchor('sim/specs/'.$key, '[ '. $label['viewspec'] .' ]', array('class' => 'edit fontSmall bold'));?>
						<?php endif;?>
					</td>
				</tr>
				<?php foreach ($tour[$key] as $t): ?>
					<tr>
						<td height="35" class="col_15"></td>
						<td class="col_40pct bold"><?php echo anchor('sim/tour/'. $t['id'], $t['name'], array('class' => 'bold'));?></td>
						<td class="col_30">&nbsp;</td>
						<td><?php echo text_output($t['summary'], '');?></td>
					</tr>
				<?php endforeach;?>
			<?php endif;?>
			</tbody>
		</table><br />
	<?php endforeach;?>
<?php endif;?>

<?php if (!isset($tour)): ?>
	<?php echo text_output($label['notour_all'], 'h3', 'orange');?>
<?php endif; ?>