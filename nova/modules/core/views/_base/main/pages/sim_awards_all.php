<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo text_output($header, 'h1', 'page-head');?>

<p><?php echo link_to_if($edit_valid, 'manage/awards', $label['edit'], array('class' => 'edit fontSmall bold'));?></p>

<?php if (isset($awards)): ?>
	<table class="table100 zebra">
		<tbody>
		<?php foreach ($awards as $v): ?>
			<tr>
				<td class="align_top top_1em"><?php echo anchor('sim/awards/'. $v['id'], img($v['img']), array('class' => 'image'));?></td>
				<td class="cell-spacer"></td>
				<td>
					<strong><?php echo $v['name'];?></strong><br />
					<?php echo text_output($v['desc'], 'span', 'fontSmall');?>
				</td>
				<td class="cell-spacer"></td>
				<td class="align_center col_75">
					<?php echo anchor('sim/awards/'. $v['id'], $label['details'], array('class' => 'bold'));?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php else: ?>
	<?php echo text_output($label['noawards'], 'h3', 'orange');?>
<?php endif; ?>